<?php
include 'header.php';
echo '<div align="center">';
echo '<p><h2>Database Listing</h2></p>';
$dummy = "";
$selecttitle = "";
include 'inc/config.inc';
$sql="SELECT ID, TITLE FROM tvshow GROUP BY TITLE ORDER BY TITLE ASC;";
$ergebnis = mysqli_query($verbindung, $sql);
while($zeile = mysqli_fetch_array($ergebnis, MYSQLI_BOTH)){

    $sqls="SELECT ID, SEASON_NUMBER FROM season WHERE TVSHOW_ID = '".$zeile[0]."' GROUP BY SEASON_NUMBER ORDER BY SEASON_NUMBER ASC;";
    $ergebniss = mysqli_query($verbindung, $sqls);
    $seasons = "";
    while($zeiles = mysqli_fetch_array($ergebniss, MYSQLI_BOTH)){
	echo '<div class="tvshow">'.$zeile[1].' - Season '.$zeiles[1].'</div>';
	// get episodes with intro/outro
        $sqle="SELECT EPISODE_NUMBER FROM episode WHERE TVSHOW_ID = '".$zeile[0]."' AND SEASON_ID = '".$zeiles[0]."' AND INTRO_LENGTH !='0' AND OUTRO_START != '0' GROUP BY EPISODE_NUMBER ORDER BY EPISODE_NUMBER ASC;";
        $ergebnise = mysqli_query($verbindung, $sqle);
        $episodes = '';
	$showresult = 0;
        while($zeilee = mysqli_fetch_array($ergebnise, MYSQLI_BOTH)){
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
        $ergebnise = mysqli_query($verbindung, $sqle);
        $episodes = '';
	$showresult = 0;
        while($zeilee = mysqli_fetch_array($ergebnise, MYSQLI_BOTH)){
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
        $ergebnise = mysqli_query($verbindung, $sqle);
        $episodes = '';
	$showresult = 0;
        while($zeilee = mysqli_fetch_array($ergebnise, MYSQLI_BOTH)){
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
if (mysqli_errno($verbindung) == '0') {
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
