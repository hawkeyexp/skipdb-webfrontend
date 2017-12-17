<?php

ini_set('max_execution_time',300);
ini_set('default_socket_timeout',10);
$max_execution_time = ini_get("max_execution_time");

if (isset($_POST['ip']) and isset($_POST['port']) and isset($_POST['user']) and isset($_POST['pass'])){

    include 'header.php';
    echo '<div align="center">';
    echo '<p><h2>Import TV Shows/Seasons/Episodes From KODI</h2></p>';
    echo '<p><div id="baseProgress">';
    echo '<div id="percent">0%</div>';
    echo '<div id="bar"></div>';
    echo '</div></p>';
    /**echo '<form action="importkodidb.php" method="post">';
    echo '<input type="hidden" name="ip" value="'.$_POST['ip'].'" />';
    echo '<input type="hidden" name="port" value="'.$_POST['port'].'" />';
    echo '<input type="hidden" name="user" value="'.$_POST['user'].'" />';
    echo '<input type="hidden" name="pass" value="'.$_POST['pass'].'" />';
    echo '<input type="hidden" name="exec" value="go" />';
    echo '<p><input type="submit" value="Ready - Import Now!" class="riskybutton"></p>';
    echo '</form>';**/
    echo '</div>';

    function execute() {
	echo ob_implicit_flush(1);
	$error = 0;
	$dummy = 0;
	$tvshowsinserted = 0;
	$seasonsinserted = 0;
	$episodesinserted = 0;
        $ip = $_POST['ip'];
        $port = $_POST['port'];
        $username= $_POST['user'];
        $password = $_POST['pass'];

	echo '<script>
	function bar() {
	    var width = arguments[0];
	    var elem = document.getElementById("bar");
	    var elemtext = document.getElementById("percent");
	    if (width == 999) {
		elem.style.width = 100 + \'%\';
		elemtext.innerHTML = "<a href=\"#result\" style=\"color: #ffffff; text-decoration: none;\">Import finished!</a>";
	    }
	    else {
		elem.style.width = width + \'%\';
		elemtext.innerHTML = width * 1 + \'%\';
	    }
	}
	</script>';

        $request = '{"jsonrpc": "2.0", "method": "VideoLibrary.GetTVShows", "params": { "properties": ["title", "season", "imdbnumber"], "sort": { "order": "ascending", "method": "title" } }, "id": "libTvShows"}';
        $completeurl = 'http://'.$ip.':'.$port.'/jsonrpc?request='.urlencode($request);
        $arrContextOptions=array(
	    "http"=>array(
	    "header"=>"Authorization: Basic " . base64_encode("$username:$password")
	    ),
	);

	if (!$socket = @fsockopen($ip,$port,$errno,$errstr,3)){
		echo '<div class="warn">Couldn\'t connect to KODI!</div>';
		echo '</div>';
		echo '<div align="center">';
		echo '</div>';
		include 'back.php';
		include 'footer.php';
		exit;
	}
	else {
	    $response = file_get_contents($completeurl, false, stream_context_create($arrContextOptions));
	    $connecterror = error_get_last();
	    if ($connecterror != '') {
		echo '<div class="warn">Couldn\'t get data from KODI!</div>';
		echo '</div>';
		echo '<div align="center">';
		echo '</div>';
		include 'back.php';
		include 'footer.php';
		exit;
	    }
	}
	$result = json_decode($response,true);
	$shows = $result['result']['limits']['end'];

	include 'inc/config.inc';

	for ($count = 0; $count < $shows; $count++){
	    $progress = round(((100 / $shows) * $count),0);
	    echo "<script>bar(".$progress.");</script>";
	    $showtitle = $result['result']['tvshows'][$count]['title'];
	    $id = $result['result']['tvshows'][$count]['tvshowid'];
	    /**season = $result['result']['tvshows'][$count]['season'];
	    season number from gettvshows can be wrong caused by reserved '0' for tvshow specials
	    which is counted to normal seasons and causes a sum of 6 seasons when tvshow contains a special and
	    normally has 5 seasons.**/

	    // get correct season count by listing episodes by it's highest season number
	    $requests = '{"jsonrpc":"2.0","id":1,"method":"VideoLibrary.GetEpisodes", "params":{"tvshowid": '.$id.', "properties": ["season"], "sort": { "order": "descending", "method": "season" } }}';
	    $completeurls = 'http://'.$ip.':'.$port.'/jsonrpc?request='.urlencode($requests);
	    $arrContextOptionss=array(
	    "http"=>array(
		"header"=>"Authorization: Basic " . base64_encode("$username:$password")
		),
	    );
	    $responses = file_get_contents($completeurls, false, stream_context_create($arrContextOptionss));
	    $results = json_decode($responses,true);
	    $season = $results['result']['episodes'][0]['season'];


	    $imdb = $result['result']['tvshows'][$count]['imdbnumber'];
	    $skip = "";
	    $sql="SELECT ID, TITLE FROM tvshow WHERE TITLE = '".mysql_real_escape_string($showtitle)."' GROUP BY TITLE ORDER BY TITLE ASC;";
	    $ergebnis = mysql_query($sql, $verbindung);
	    while($zeile = mysql_fetch_array($ergebnis)){
		if ($showtitle == $zeile[1]) {
		    $skip = "yes";
		}
	    }
	    if (mysql_errno() == '0') {
		$dummy++;
	    }
	    else {
		include 'inc/sqlerror.php'; $error++;
	    }

	    if ($skip == "yes") {
		$sqltvid="SELECT ID FROM tvshow WHERE TITLE = '".mysql_real_escape_string($showtitle)."' LIMIT 1;";
		$ergebnistvid = mysql_query($sqltvid, $verbindung);
		$tvshowid = mysql_fetch_row($ergebnistvid)[0];

		echo '<div class="desc"><label>'.$showtitle.' (IMDB: '.$imdb.' | Seasons: '.$season.')</label></div><br>';
		echo str_repeat(' ',1024*64);
		// insert seasons (if missing)
		for ($counts = 1; $counts <= $season; $counts++){
		    $skip1 = "";
		    $sql="SELECT SEASON_NUMBER, TVSHOW_ID FROM season WHERE TVSHOW_ID  = '".$tvshowid."' AND SEASON_NUMBER = '".$counts."' LIMIT 1;";
		    $ergebnis = mysql_query($sql, $verbindung);
		    $zeile = mysql_fetch_row($ergebnis);

		    if ($tvshowid == $zeile[1] and $counts == $zeile[0]) {
			$skip1 = "yes";
		    }

		    if (mysql_errno() == '0') {
			$dummy++;
		    }
		    else {
			include 'inc/sqlerror.php'; $error++;
		    }

		    if ($skip1 != "yes") {
			$dummy = 0;
			$sql = "INSERT INTO season (ID, SEASON_NUMBER, TVSHOW_ID) VALUES (NULL,'".$counts."', '".$tvshowid."')";
			$ergebnis = mysql_query($sql, $verbindung);
			if (mysql_errno() == '0') {
			    $seasonsinserted++;
			    $dummy++;
			    echo '<div class="new"><label>Season: '.$counts.' (New Created!)</label></div><br>';
			    echo str_repeat(' ',1024*64);
			}
			else {
			    include 'inc/sqlerror.php'; $error++;
			}
		    }
		    $sqlseaid="SELECT ID FROM season WHERE TVSHOW_ID = '".$tvshowid."' AND SEASON_NUMBER = '".$counts."' LIMIT 1;";
		    $ergebnisseaid = mysql_query($sqlseaid, $verbindung);
		    $seasonid = mysql_fetch_row($ergebnisseaid)[0];

		    // get episodes of season
		    $requeste = '{"jsonrpc":"2.0","id":1,"method":"VideoLibrary.GetEpisodes", "params":{"tvshowid": '.$id.', "filter": {"field": "season", "operator": "is", "value": "'.$counts.'"}, "properties": ["season", "episode"]}}';
		    $completeurle = 'http://'.$ip.':'.$port.'/jsonrpc?request='.urlencode($requeste);
		    $arrContextOptionse=array(
		    "http"=>array(
			"header"=>"Authorization: Basic " . base64_encode("$username:$password")
			),
		    );
		    $responsee = file_get_contents($completeurle, false, stream_context_create($arrContextOptionse));
		    $resulte = json_decode($responsee,true);
		    $episodestotal = $resulte['result']['limits']['end'];
		    echo '<div class="info"><label>Season: '.$counts.' | Episodes: '.$episodestotal.'</label></div><br>';
		    echo str_repeat(' ',1024*64);

		    // create episode entries
		    for ($counte = 1; $counte <= $episodestotal; $counte++){
			$skipe = "";
			$sqle="SELECT EPISODE_NUMBER FROM episode WHERE SEASON_ID = '".$seasonid."' AND EPISODE_NUMBER = '".$counte."' LIMIT 1;";
			$ergebnise = mysql_query($sqle, $verbindung);
			$zeilee = mysql_fetch_row($ergebnise);
			if ($counte == $zeilee[0]) {
			    $skipe = "yes";
			}
			if (mysql_errno() == '0') {
			    $dummy++;
			}
			else {
			    include 'inc/sqlerror.php'; $error++;
			}

			if ($skipe != "yes") {
			    $dummy = 0;
			    $sqle = "INSERT INTO episode (ID, EPISODE_NUMBER, TVSHOW_ID, SEASON_ID) VALUES (NULL, '".$counte."','".$tvshowid."','".$seasonid."');";
			    $ergebnise = mysql_query($sqle, $verbindung);
			    if (mysql_errno() == '0') {
				$dummy++;
				$episodesinserted++;
				echo '<div class="new"><label>'.$showtitle.'- S'.sprintf("%'.02d",$counts).'E'.sprintf("%'.02d",$counte).' (New Created!)</label></div><br>';
				echo str_repeat(' ',1024*64);
			    }
			    else {
				include 'inc/sqlerror.php'; $error++;
			    }
			}
		    }
		    if ($episodestotal == "0") {
			echo '<div class="del" style="height:30px"><label>Season: '.$counts.' | Episodes: '.$episodestotal.' > Remove Season!</label></div><br>';
			echo str_repeat(' ',1024*64);
			$sqldel="DELETE FROM season WHERE TVSHOW_ID  = '".$tvshowid."' AND SEASON_NUMBER = '".$counts."';";
			$ergebnisdel = mysql_query($sqldel, $verbindung);
			if (mysql_errno() == '0') {
			    $dummy++;
			    $seasonsinserted--;
			}
			else {
			    include 'inc/sqlerror.php'; $error++;
			}
		    }
		    // end create episodes
		}
	    }
	    else {
		echo '<div class="desc"><label>'.$showtitle.' (IMDB: '.$imdb.' | Seasons: '.$season.')</label></div><br>';
		echo str_repeat(' ',1024*64);
		// insert show
		$dummy = 0;
		$sql = "INSERT INTO tvshow (ID, TITLE, IMDBNUMBER, KODI_ID) VALUES (NULL, '".mysql_real_escape_string($showtitle)."','".$imdb."','".$id."')";
		$ergebnis = mysql_query($sql, $verbindung);
		if (mysql_errno() == '0') {
		    $dummy++;
		    $tvshowsinserted++;
		    $sqltvid="SELECT ID FROM tvshow WHERE TITLE = '".mysql_real_escape_string($showtitle)."' LIMIT 1;";
		    $ergebnistvid = mysql_query($sqltvid, $verbindung);
		    $tvshowid = mysql_fetch_row($ergebnistvid)[0];
		    echo '<div class="new"><label>'.$showtitle.' (New Created!)</label></div><br>';
		    echo str_repeat(' ',1024*64);
		    // insert seasons (if missing)
		    for ($counts = 1; $counts <= $season; $counts++){
			$skip1 = "";
			$sql="SELECT SEASON_NUMBER, TVSHOW_ID FROM season WHERE TVSHOW_ID  = '".$tvshowid."' AND SEASON_NUMBER = '".$counts."' LIMIT 1;";
			$ergebnis = mysql_query($sql, $verbindung);
			$zeile = mysql_fetch_row($ergebnis);
			if ($tvshowid == $zeile[1] and $counts == $zeile[0]) {
			    $skip1 = "yes";
			}
			if (mysql_errno() == '0') {
			    $dummy++;
			}
			else {
			    include 'inc/sqlerror.php'; $error++;
			}
			if ($skip1 != "yes") {
			    $dummy = 0;
			    $sql = "INSERT INTO season (ID, SEASON_NUMBER, TVSHOW_ID) VALUES (NULL,'".$counts."', '".$tvshowid."')";
			    $ergebnis = mysql_query($sql, $verbindung);
			    if (mysql_errno() == '0') {
				$seasonsinserted++;
				$dummy++;
				echo '<div class="new"><label>Season: '.$counts.' (New Created!)</label></div><br>';
				echo str_repeat(' ',1024*64);
			    }
			    else {
				include 'inc/sqlerror.php'; $error++;
			    }
			}
			$sqlseaid="SELECT ID FROM season WHERE TVSHOW_ID = '".$tvshowid."' AND SEASON_NUMBER = '".$counts."' LIMIT 1;";
			$ergebnisseaid = mysql_query($sqlseaid, $verbindung);
			$seasonid = mysql_fetch_row($ergebnisseaid)[0];

			// get episodes of season
			$requeste = '{"jsonrpc":"2.0","id":1,"method":"VideoLibrary.GetEpisodes", "params":{"tvshowid": '.$id.', "filter": {"field": "season", "operator": "is", "value": "'.$counts.'"}, "properties": ["season", "episode"]}}';
			$completeurle = 'http://'.$ip.':'.$port.'/jsonrpc?request='.urlencode($requeste);
			$arrContextOptionse=array(
			    "http"=>array(
			    "header"=>"Authorization: Basic " . base64_encode("$username:$password")
			    ),
			);
			$responsee = file_get_contents($completeurle, false, stream_context_create($arrContextOptionse));
			$resulte = json_decode($responsee,true);
			$episodestotal = $resulte['result']['limits']['end'];
			echo '<div class="info"><label>Season: '.$counts.' | Episodes: '.$episodestotal.'</label></div><br>';
			echo str_repeat(' ',1024*64);

			// create episode entries
			for ($counte = 1; $counte <= $episodestotal; $counte++){
			    $skipe = "";
			    $sqle="SELECT EPISODE_NUMBER FROM episode WHERE SEASON_ID = '".$seasonid."' AND EPISODE_NUMBER = '".$counte."' LIMIT 1;";
			    $ergebnise = mysql_query($sqle, $verbindung);
			    $zeilee = mysql_fetch_row($ergebnise);
			    if ($counte == $zeilee[0]) {
				$skipe = "yes";
			    }
			    if (mysql_errno() == '0') {
				$dummy++;
			    }
			    else {
				include 'inc/sqlerror.php'; $error++;
			    }

			    if ($skipe != "yes") {
				$dummy = 0;
				$sqle = "INSERT INTO episode (ID, EPISODE_NUMBER, TVSHOW_ID, SEASON_ID) VALUES (NULL, '".$counte."','".$tvshowid."','".$seasonid."');";
				$ergebnise = mysql_query($sqle, $verbindung);
				if (mysql_errno() == '0') {
				    $episodesinserted++;
				    $dummy++;
				    echo '<div class="new"><label>'.$showtitle.'- S'.sprintf("%'.02d",$counts).'E'.sprintf("%'.02d",$counte).' (New Created!)</label></div><br>';
				    echo str_repeat(' ',1024*64);
				}
				else {
				    include 'inc/sqlerror.php'; $error++;
				}
			    }
			}
			if ($episodestotal == "0") {
			    echo '<div class="del" style="height:30px"><label>Season: '.$counts.' | Episodes: '.$episodestotal.' > Remove Season!</label></div><br>';
			    echo str_repeat(' ',1024*64);
			    $sqldel="DELETE FROM season WHERE TVSHOW_ID  = '".$tvshowid."' AND SEASON_NUMBER = '".$counts."';";
			    $ergebnisdel = mysql_query($sqldel, $verbindung);
			    if (mysql_errno() == '0') {
				$seasonsinserted--;
				$dummy++;
			    }
			    else {
				include 'inc/sqlerror.php'; $error++;
			    }
			}
			// end create episode entries
		    }
		    // end insert seasons
		}
		else {
		    include 'inc/sqlerror.php'; $error++;
		}
		// end insert show
	    }
	    $skip = "";
	}
	// show results
	echo '<a name="result">';
	echo '<div class="info" style="height: auto;"><p>';
	echo 'TV Shows inserted: '.$tvshowsinserted.'<br>';
	echo 'Seasons inserted: '.$seasonsinserted.'<br>';
	echo 'Episodes inserted: '.$episodesinserted.'<br>';
	echo '</p></div>';
	echo '</div>';
	include 'back.php';
	include 'footer.php';
	echo ob_implicit_flush(0);
    }

    //if (isset($_POST['exec'])) {
    execute();
    //}
    echo "<script>bar(100);</script>";
    echo "<script>bar(999);</script>";
}
else {
	include 'header.php';
	echo '<div align="center">';
	echo '<p><h2>Import TV Shows/Seasons/Episodes From KODI</h2></p>';
	echo '<p><div class="new" style="height: 90px">Warning: The import can take a long time and break php execution time!<br>PHP max execution time on server side is set to: <b style="color: #FF5555;">'.$max_execution_time.' seconds!</b><br>You can run again if import doesn\'t finish.</div></p>';
	echo '<form action="importkodidb.php" method="post">';
	echo '<div class="desc"><label>Host (IP)</label></div><div><input type="text" name="ip" /></div>';
	echo '<div class="desc"><label>Port (Webinterface)</label></div><div><input type="text" name="port" /></div>';
	echo '<div class="desc"><label>Username</label></div><div><input type="text" name="user" /></div>';
	echo '<div class="desc"><label>Password</label></div><div><input type="password" name="pass" /></div>';
	echo '<p><input type="submit" onclick="javascript:document.body.style.cursor=\'wait\';" value="Import Now!" class="riskybutton"></p>';
	echo '</form>';
	echo '</div>';
	echo '<div align="center">';
	echo '<form action="index.php">';
	echo '<button type="submit">Home</button>';
	echo '</form>';
	echo '</div>';
	include 'footer.php';
}
?>
