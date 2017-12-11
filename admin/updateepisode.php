<?php
$dummy = 0;
$error = 0;
if ((isset($_GET['title'])) and (isset($_GET['season'])) and (isset($_GET['episode'])) and (isset($_GET['id'])) and (isset($_GET['start'])) and (isset($_GET['length']))and (isset($_GET['outro']))){

    $get_introstart = $_GET['start'];
    $get_inrolength = $_GET['length'];

    if (strpos($get_introstart,':') == true) {
	$split = explode(':', $get_introstart);
	$get_introstart = $split[0] * 3600 + $split[1] * 60 + $split[2];
    }

    if (strpos($get_inrolength,':') == true) {
	$split = explode(':', $get_inrolength);
	$end = $split[0] * 3600 + $split[1] * 60 + $split[2];
	$get_inrolength = $end - $get_introstart;
    }

    include 'inc/config.inc';
    $sql = "UPDATE episode SET INTRO_START = '".$get_introstart."', INTRO_LENGTH = '".$get_inrolength."', OUTRO_START = '".$_GET['outro']."' WHERE ID = '".$_GET['id']."';";
    $ergebnis = mysql_query($sql, $verbindung);
    if (mysql_errno() == '0') {
    	$dummy++;
    }
    else {
    	include 'inc/sqlerror.php'; $error++;
    }
    include 'header.php';
    echo '<div align="center">';
    echo '<p><H2>Update Existing Episode Inside SkipDB</h2></p>';
    echo '<p><div class="desc">Done...</div></p>';
    if ($dummy > 0){
	echo '<p class="info">SQL-Commands: '.$dummy.'</p>';
    }
    if ($error > 0){
	echo '<p class="warn">Errors: '.$error.'</p>';
    }
    echo '</div>';
    include 'back.php';
    include 'footer.php';
    exit;
}

if ((!isset($_GET['title'])) or (!isset($_GET['season'])) or (!isset($_GET['episode']))){
    if (!isset($_GET['title'])){
	$selecttitle = "";
	include 'inc/config.inc';
	$sql="SELECT TITLE FROM tvshow GROUP BY TITLE ORDER BY TITLE ASC;";
        $ergebnis = mysql_query($sql, $verbindung);
        while($zeile = mysql_fetch_array($ergebnis)){
	    $selecttitle = $selecttitle."<option>".$zeile[0]."</option>";
        }
	if (mysql_errno() == '0') {
	    $dummy++;
        }
	else {
	    include 'inc/sqlerror.php'; $error++;
        }
	include 'header.php';
	echo '<div align="center">';
	echo '<p><H2>Update Existing Episode Inside SkipDB</h2></p>';
	echo '<form action="updateepisode.php" method="get">';
	echo '<div class="desc">Title</div>';
	echo '<select name="title">';
	echo $selecttitle;
	echo '</select>';
	echo '<p><input type="submit" value="Continue" class="conbutton"/></p>';
	echo '</form>';
	echo '</div>';
	echo '<div align="center">';
	echo '<form action="index.php">';
	echo '<button type="submit">Home</button>';
	echo '</form>';
	echo '</div>';
	include 'footer.php';
	exit;
    }

    if ((isset($_GET['title'])) and (!isset($_GET['season'])) and (!isset($_GET['episode']))){
	$selectseason = "";
	include 'inc/config.inc';
	$sql="SELECT season.ID, tvshow.TITLE, season.SEASON FROM season INNER JOIN tvshow ON season.TVSHOW_ID=tvshow.ID WHERE tvshow.TITLE = '".mysql_real_escape_string($_GET['title'])."';";
	$ergebnis = mysql_query($sql, $verbindung);
	while($zeile = mysql_fetch_array($ergebnis)){
    	    $selectseason = $selectseason."<option>".$zeile[2]."</option>";
	}
	if (mysql_errno() == '0') {
	    $dummy++;
        }
	else {
	    include 'inc/sqlerror.php'; $error++;
        }
	$selecttitle = "<option>".$_GET['title']."</option>";
	include 'header.php';
	echo '<div align="center">';
	echo '<p><h2>Update Existing Episode Inside SkipDB</h2></p>';
	echo '<form action="updateepisode.php" method="get">';
	echo '<div class="desc">Title</div>';
	echo '<select name="title">';
	echo $selecttitle;
	echo '</select>';
	echo '<div class="desc">Season</div>';
	echo '<select name="season">';
        echo $selectseason;
	echo '</select>';
	echo '<p><input type="submit" value="Continue" class="conbutton"/></p>';
	echo '</form>';
	echo '</div>';
	include 'back.php';
	include 'footer.php';
	exit;
    }

    if ((isset($_GET['title'])) and (isset($_GET['season'])) and (!isset($_GET['episode']))){
	$selectepisode = "";
	include 'inc/config.inc';

        // get tvshowid by title
        $sql="SELECT ID FROM tvshow WHERE TITLE = '".mysql_real_escape_string($_GET['title'])."' LIMIT 1;";
        $ergebnis = mysql_query($sql, $verbindung);
        $zeile = mysql_fetch_row($ergebnis);
        if (mysql_errno() == '0') {
            $dummy++;
        }
        else {
            include 'inc/sqlerror.php'; $error++;
        }
        $tvshowid = $zeile[0];

        // get seasonid by tvshowid and season
        $sql="SELECT ID FROM season WHERE TVSHOW_ID = '".$tvshowid."' AND SEASON = '".$_GET['season']."' LIMIT 1;";
        $ergebnis = mysql_query($sql, $verbindung);
        $zeile = mysql_fetch_row($ergebnis);
        if (mysql_errno() == '0') {
            $dummy++;
        }
        else {
            include 'inc/sqlerror.php'; $error++;
        }
        $seasonid = $zeile[0];

        $sql="SELECT EPISODE FROM episode WHERE TVSHOW_ID = '".$tvshowid."' AND SEASON_ID = '".$seasonid."' ORDER BY EPISODE ASC;";
        $ergebnis = mysql_query($sql, $verbindung);
        while($zeile = mysql_fetch_array($ergebnis)){
	    $selectepisode = $selectepisode."<option>".$zeile[0]."</option>";
        }
	if (mysql_errno() == '0') {
	    $dummy++;
        }
	else {
	    include 'inc/sqlerror.php'; $error++;
        }
	$selecttitle = "<option>".$_GET['title']."</option>";
	$selectseason = "<option>".$_GET['season']."</option>";
	include 'header.php';
	echo '<div align="center">';
	echo '<p><H2>Update Existing Episode Inside SkipDB</h2></p>';
	echo '<form action="updateepisode.php" method="get">';
	echo '<div class="desc">Title</div>';
	echo '<select name="title">';
        echo $selecttitle;
	echo '</select>';
	echo '<div class="desc">Season</div>';
	echo '<select name="season">';
	echo $selectseason;
	echo '</select>';
	echo '<div class="desc">Episode</div>';
	echo '<select name="episode">';
        echo $selectepisode;
	echo '</select>';
	echo '<p><input type="submit" value="Continue" class="conbutton"/></p>';
	echo '</form>';
	echo '</div>';
	include 'back.php';
	include 'footer.php';
    exit;
    }
}
else {
    include 'inc/config.inc';

    // get tvshowid by title
    $sql="SELECT ID FROM tvshow WHERE TITLE = '".mysql_real_escape_string($_GET['title'])."' LIMIT 1;";
    $ergebnis = mysql_query($sql, $verbindung);
    $zeile = mysql_fetch_row($ergebnis);
    if (mysql_errno() == '0') {
        $dummy++;
    }
    else {
        include 'inc/sqlerror.php'; $error++;
    }
    $tvshowid = $zeile[0];

    // get seasonid by tvshowid and season
    $sql="SELECT ID FROM season WHERE TVSHOW_ID = '".$tvshowid."' AND SEASON = '".$_GET['season']."' LIMIT 1;";
    $ergebnis = mysql_query($sql, $verbindung);
    $zeile = mysql_fetch_row($ergebnis);
    if (mysql_errno() == '0') {
        $dummy++;
    }
    else {
        include 'inc/sqlerror.php'; $error++;
    }
    $seasonid = $zeile[0];

    $sql="SELECT * FROM episode WHERE TVSHOW_ID = '".$tvshowid."' AND SEASON_ID = '".$seasonid."' AND EPISODE = '".$_GET['episode']."' LIMIT 1;";
    $ergebnis = mysql_query($sql, $verbindung);
    $zeile = mysql_fetch_row($ergebnis);
    if (mysql_errno() == '0') {
	$dummy++;
    }
    else {
	include 'inc/sqlerror.php'; $error++;
    }
    $id = $zeile[0];
    $title = $_GET['title'];
    $season = $_GET['season'];
    $episode = $_GET['episode'];
    $start = $zeile[4];
    $length = $zeile[5];
    $outro = $zeile[6];

    include 'header.php';
    echo '<div align="center">';
    echo '<form action="updateepisode.php" method="get">';
    echo '<p><H2>Update Existing Episode Inside SkipDB</h2></p>';
    echo '<input type="hidden" name="id" value="'.$id.'" />';
    echo '<input type="hidden" name="title" value="'.$title.'" />';
    echo '<input type="hidden" name="season" value="'.$season.'" />';
    echo '<input type="hidden" name="episode" value="'.$episode.'" />';
    echo '<div class="info">'.$title.' - S'.sprintf("%'.02d",$season).'E'.sprintf("%'.02d",$episode).'</div>';
    echo '<div class="desc">Start Position Intro (Seconds or hh:mm:ss)</div>';
    echo '<input type="text" name="start" value="'.$start.'" />';
    echo '<div class="desc">Intro length (Seconds) Or End (hh:mm:ss)</div>';
    echo '<input type="text" name="length" value="'.$length.'" />';
    echo '<div class="desc"><label>Outro Start Position (Seconds or hh:mm:ss)</label></div>';
    echo '<input type="text" name="outro" value="'.$outro.'" />';
    echo '<p><input type="submit" value="Update Episode!" class="riskybutton" /></p>';
    echo '</form>';
    echo '</div>';
    include 'back.php';
    include 'footer.php';
}
?>
