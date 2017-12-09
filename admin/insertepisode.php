<?php
$dummy = 0;
$error = 0;
if (!isset($_GET['title']) or !isset($_GET['season']) or !isset($_GET['episodestart']) or !isset($_GET['introend']) or !isset($_GET['introend'])) {
    $selecttitle = "";
    include 'inc/config.inc';
    $sql="SELECT `TITLE` FROM `tvshows` WHERE 1 GROUP BY `TITLE` ORDER BY `TITLE` ASC";
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

    if (isset($_GET['title'])) {
	$selecttitle = "<option>".$_GET['title']."</option>";
	$selectseason = "";
	include 'inc/config.inc';
	$sql="SELECT `SEASON` FROM `seasons` WHERE `TITLE` = '".mysql_real_escape_string($_GET['title'])."' GROUP BY `SEASON` ORDER BY `SEASON` ASC";
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
	echo '<div class="desc"><label>Episode (Number)</label></div><div><input type="text" name="episodestart" /></div>';
	echo '<div class="desc"><label>Intro Start Position (Seconds or hh:mm:ss)</label></div><div><input type="text" name="introstart" /></div>';
	echo '<div class="desc"><label>Intro Lenght (Seconds) Or End (hh:mm:ss)</label></div><div><input type="text" name="introend" /></div>';
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
	$sql="SELECT `TITLE` FROM `tvshows` WHERE 1 GROUP BY `TITLE` ORDER BY `TITLE` ASC";
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
    $get_episodestart = $_GET['episodestart'];
    $get_introstart = $_GET['introstart'];
    $get_introend = $_GET['introend'];

    if (strpos($get_introstart,':') == true) {
	$split = explode(':', $get_introstart);
	$get_introstart = $split[0] * 3600 + $split[1] * 60 + $split[2];
    }

    if (strpos($get_introend,':') == true) {
	$split = explode(':', $get_introend);
	$end = $split[0] * 3600 + $split[1] * 60 + $split[2];
	$get_introend = $end - $get_introstart;
    }

    include 'inc/config.inc';
    $sql="SELECT * FROM `intro` WHERE 1 AND `TITLE` = '".mysql_real_escape_string($get_title)."' AND `SEASON` = '".$get_season."' AND `EPISODE` = '".$get_episodestart."'";
    $ergebnis = mysql_query($sql, $verbindung);
    $zeile = mysql_fetch_array($ergebnis);
    if (mysql_errno() == '0') {
	$dummy++;
    }
    else {
	include 'inc/sqlerror.php'; $error++;
    }
    if ($zeile[0] != "") {
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
	$sql = "INSERT INTO `intro` (`ID`, `TITLE`, `SEASON`, `EPISODE`, `START`, `LENGHT`) VALUES (NULL, '".mysql_real_escape_string($get_title)."', '".$get_season."', '".$get_episodestart."', '".$get_introstart."', '".$get_introend."')";
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
	    echo '<p><font color="lightgreen">SQL-Commands: '.$dummy.'</font></p>';
        }
	else {
	    echo '<p>SQL-Commands: '.$dummy.'</p>';
        }
	if ($error > 0){
	    echo '<p><div class="warn">Errors: '.$error.'</div></p>';
        }
	else {
	    echo '<p>Errors: '.$error.'</p>';
        }
	echo '<form action="index.php">';
        echo '<button type="submit">Back</button>';
        echo '</form>';
        echo '</div>';
	include 'footer.php';
    }
}
?>
