<?php
$dummy = 0;
$error = 0;
if (!isset($_GET['title']) or !isset($_GET['season']) or !isset($_GET['episode']) or !isset($_GET['introlength']) or !isset($_GET['introlength'])) {
    if (isset($_GET['title'])) {
	$selecttitle = "<option>".$_GET['title']."</option>";
	$selectseason = "";
	include 'inc/config.inc';
	$sql="SELECT season.SEASON FROM season INNER JOIN tvshow ON season.TVSHOW_ID=tvshow.ID WHERE tvshow.TITLE = '".mysql_real_escape_string($_GET['title'])."';";
	$ergebnis = mysql_query($sql, $verbindung);
	while($zeile = mysql_fetch_array($ergebnis)){
	    $selectseason = $selectseason."<option>".$zeile[0]."</option>";
	}
	if (mysql_errno() == '0') {
	    $dummy++;
	}
	else {
	    include 'inc/sqlerror.php'; $error++;
	}
	include 'header.php';
	echo '<form action="insertepisode.php" method="get">';
	echo '<div align="center">';
	echo '<p><h2>Insert Single Episode Inside SkipDB</h2></p>';
	echo '<div class="desc"><label>Titel</label></div><div>';
	echo '<select name="title">';
	echo $selecttitle;
	echo '</select>';
	echo '</div>';
	echo '<div class="desc"><label>Season</label></div><div>';
	echo '<select name="season">';
	echo $selectseason;
	echo '</select>';
	echo '</div>';
	echo '<div class="desc"><label>Episode (Number)</label></div><div><input type="text" name="episode" /></div>';
	echo '<div class="desc"><label>Intro Start Position (Seconds or hh:mm:ss)</label></div><div><input type="text" name="introstart" /></div>';
	echo '<div class="desc"><label>Intro length (Seconds) Or End (hh:mm:ss)</label></div><div><input type="text" name="introlength" /></div>';
	echo '<div class="desc"><label>Outro Start Position (Seconds or hh:mm:ss)</label></div><div><input type="text" name="outrostart" /></div>';
	echo '<p><input type="submit" value="Insert Now!" class="riskybutton" /></p>';
	echo '</form>';
	echo '</div>';
	include 'back.php';
	include 'footer.php';
	exit;
    }
    else {
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
	echo '<form action="insertepisode.php" method="get">';
	echo '<div align="center">';
	echo '<p><h2>Insert Single Episode Inside SkipDB</h2></p>';
	echo '<div class="desc"><label>Titel</label></div><div>';
	echo '<select name="title">';
	echo $selecttitle;
	echo '</select>';
	echo '</div>';
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
}
else {
    $get_title = $_GET['title'];
    $get_season = $_GET['season'];
    $get_episode = $_GET['episode'];
    $get_introstart = $_GET['introstart'];
    $get_introlength = $_GET['introlength'];
    $get_outrostart = $_GET['outrostart'];

    if (strpos($get_introstart,':') == true) {
	$split = explode(':', $get_introstart);
	$get_introstart = $split[0] * 3600 + $split[1] * 60 + $split[2];
    }

    if (strpos($get_introlength,':') == true) {
	$split = explode(':', $get_introlength);
	$end = $split[0] * 3600 + $split[1] * 60 + $split[2];
	$get_introlength = $end - $get_introstart;
    }

    include 'inc/config.inc';

    // get tvshowid by title
    $sql="SELECT ID FROM tvshow WHERE TITLE = '".mysql_real_escape_string($get_title)."' LIMIT 1;";
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
    $sql="SELECT ID FROM season WHERE TVSHOW_ID = '".$tvshowid."' AND SEASON = '".$get_season."' LIMIT 1;";
    $ergebnis = mysql_query($sql, $verbindung);
    $zeile = mysql_fetch_row($ergebnis);
    if (mysql_errno() == '0') {
        $dummy++;
    }
    else {
        include 'inc/sqlerror.php'; $error++;
    }
    $seasonid = $zeile[0];

    // get episodeid by tvshowid, seasonid, episode
    $sql="SELECT ID FROM episode WHERE TVSHOW_ID = '".$tvshowid."' AND SEASON_ID = '".$seasonid."' AND EPISODE = '".$get_episode."' LIMIT 1;";
    $ergebnis = mysql_query($sql, $verbindung);
    $zeile = mysql_fetch_row($ergebnis);
    if (mysql_errno() == '0') {
        $dummy++;
    }
    else {
        include 'inc/sqlerror.php'; $error++;
    }
    $episodeid = $zeile[0];

    if ($episodeid != "") {
	include 'header.php';
        echo '<div align="center">';
        echo '<p><H2>Insert Single Episode Inside SkipDB</h2></p>';
        echo '<p><h3><div class="warn">Episode exists!</div></h3></p>';
        echo '<p><h3><div class="info">Use "Update Episode"</div></h3></p>';
	echo '<form action="index.php">';
        echo '<button type="submit">Back</button>';
        echo '</form>';
        echo '</div>';
	include 'footer.php';

    }
    else {
	$dummy = 0;
	$sql = "INSERT INTO episode (ID, EPISODE, TVSHOW_ID, SEASON_ID, INTRO_START, INTRO_length, OUTRO_START) VALUES (NULL, '".$get_episode."', '".$tvshowid."', '".$seasonid."', '".$get_introstart."', '".$get_introlength."', '".$get_outrostart."');";
        $ergebnis = mysql_query($sql, $verbindung);
        if (mysql_errno() == '0') {
        	$dummy++;
        }
        else {
        	include 'inc/sqlerror.php'; $error++;
        }
	include 'header.php';
        echo '<div align="center">';
        echo '<p><H2>Insert Single Episode Inside SkipDB</h2></p>';
        echo '<p><div class="desc">Done...</div></p>';
        if ($dummy > 0){
	    echo '<p class="info">SQL-Commands: '.$dummy.'</p>';
        }
	if ($error > 0){
	    echo '<p class="warn">Errors: '.$error.'</p>';
        }
	echo '<form action="index.php">';
        echo '<button type="submit">Back</button>';
        echo '</form>';
        echo '</div>';
	include 'footer.php';
    }
}
?>
