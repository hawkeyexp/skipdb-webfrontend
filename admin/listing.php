<?php
include 'header.php';
echo '<div align="center">';
echo '<p><h2>Database Listing</h2></p>';
$dummy = "";
$selecttitle = "";
include 'inc/config.inc';
$sql="SELECT ID, TITLE FROM tvshow GROUP BY TITLE ORDER BY TITLE ASC;";
$ergebnis = mysql_query($sql, $verbindung);
while($zeile = mysql_fetch_array($ergebnis)){

    $sqls="SELECT ID, SEASON_NUMBER FROM season WHERE TVSHOW_ID = '".$zeile[0]."' GROUP BY SEASON_NUMBER ORDER BY SEASON_NUMBER ASC;";
    $ergebniss = mysql_query($sqls, $verbindung);
    $seasons = "";
    while($zeiles = mysql_fetch_array($ergebniss)){
	echo '<div class="tvshow">'.$zeile[1].' - Season '.$zeiles[1].'</div>';
	// get episodes with intro/outro
        $sqle="SELECT EPISODE_NUMBER FROM episode WHERE TVSHOW_ID = '".$zeile[0]."' AND SEASON_ID = '".$zeiles[0]."' AND INTRO_LENGTH !='0' AND OUTRO_START != '0' GROUP BY EPISODE_NUMBER ORDER BY EPISODE_NUMBER ASC;";
        $ergebnise = mysql_query($sqle, $verbindung);
        $episodes = '';
	$showresult = 0;
        while($zeilee = mysql_fetch_array($ergebnise)){
	    if ($zeilee != '') {
		$showresult = 1;
	    }
	    $episodes = $episodes.' | <a href="updateepisode.php?title='.$zeile[1].'&season='.$zeiles[1].'&episode='.$zeilee[0].'&ref=1">'.$zeilee[0].'</a>';
        }
	if ($showresult == 1) {
	    $episodes = preg_replace('/\|/','',$episodes,1);
	    echo '<div class="episodes">'.$episodes.'</div>';
	}
	// get episodes with partitial missing
        $sqle="SELECT EPISODE_NUMBER FROM episode WHERE TVSHOW_ID = '".$zeile[0]."' AND SEASON_ID = '".$zeiles[0]."' AND (INTRO_LENGTH ='0' OR OUTRO_START = '0') AND !(INTRO_LENGTH = '0' AND OUTRO_START = '0') GROUP BY EPISODE_NUMBER ORDER BY EPISODE_NUMBER ASC;";
        $ergebnise = mysql_query($sqle, $verbindung);
        $episodes = '';
	$showresult = 0;
        while($zeilee = mysql_fetch_array($ergebnise)){
	    if ($zeilee != '') {
		$showresult = 1;
	    }
	    $episodes = $episodes.' | <a href="updateepisode.php?title='.$zeile[1].'&season='.$zeiles[1].'&episode='.$zeilee[0].'&ref=1">'.$zeilee[0].'</a>';
        }
	if ($showresult == 1) {
	    $episodes = preg_replace('/\|/','',$episodes,1);
	    echo '<div class="episodespartitial">'.$episodes.'</div>';
	}


	// get episodes without intro/outro
        $sqle="SELECT EPISODE_NUMBER FROM episode WHERE TVSHOW_ID = '".$zeile[0]."' AND SEASON_ID = '".$zeiles[0]."' AND INTRO_LENGTH ='0' AND OUTRO_START ='0' GROUP BY EPISODE_NUMBER ORDER BY EPISODE_NUMBER ASC;";
        $ergebnise = mysql_query($sqle, $verbindung);
        $episodes = '';
	$showresult = 0;
        while($zeilee = mysql_fetch_array($ergebnise)){
	    if ($zeilee != '') {
		$showresult = 1;
	    }
	    $episodes = $episodes.' | <a href="updateepisode.php?title='.$zeile[1].'&season='.$zeiles[1].'&episode='.$zeilee[0].'&ref=1">'.$zeilee[0].'</a>';
        }
	if ($showresult == 1) {
	    $episodes = preg_replace('/\|/','',$episodes,1);
	    echo '<div class="episodesmissing">'.$episodes.'</div><p>';
	}
	else {
	    echo '<p>';
	}
    }
}
if (mysql_errno() == '0') {
    $dummy++;
    }
else {
    include 'inc/sqlerror.php'; $error++;
}
echo '</div>';
echo '<div align="center">';
echo '<form action="index.php">';
echo '<button type="submit">Home</button>';
echo '</form>';
echo '</div>';
include 'footer.php';
?>
