<?php
$dummy = 0;
$error = 0;
if ((isset($_GET['title'])) and (isset($_GET['season'])) and (isset($_GET['episode'])) and (isset($_GET['id'])) and (isset($_GET['start'])) and (isset($_GET['lenght']))){
    include 'inc/config.inc';
    $sql = "UPDATE `intro` SET `START` = '".$_GET['start']."', `LENGHT` = '".$_GET['lenght']."' WHERE `ID` = '".$_GET['id']."'";
    $ergebnis = mysql_query($sql, $verbindung);
    if (mysql_errno() == '0') {
    	$dummy++;
    }
    else {
    	include 'inc/sqlerror.php'; $error++;
    }
    echo '<html>';
    echo '<head>';
    echo '<link rel="stylesheet" type="text/css" href="style.css">';
    echo '</head>';
    echo '<body>';
    echo '<div align="center">';
    echo '<p><H2>Update Existing Episode Inside SkipDB</h2></p>';
    echo '<p>Done...</p>';
    if ($dummy > 0){
	echo '<p><font color="lightgreen">SQL-Commands: '.$dummy.'</font></p>';
    }
    else {
	echo '<p>SQL-Commands: '.$dummy.'</p>';
    }
    if ($error > 0){
	echo '<p><font color="crimson">Errors: '.$error.'</font></p>';
    }
    else {
	echo '<p>Errors: '.$error.'</p>';
    }
    echo '<form action="main.php">';
    echo '<button type="submit">Back</button>';
    echo '</form>';
    echo '</div>';
    echo '</body>';
    echo '</html>';
    exit;
}
if ((!isset($_GET['title'])) or (!isset($_GET['season'])) or (!isset($_GET['episode']))){
    if (!isset($_GET['title'])){
	$selecttitle = "";
	include 'inc/config.inc';
        $sql="SELECT `TITLE` FROM `intro` WHERE `SEASON` != '0' AND `EPISODE` != '0' GROUP BY `TITLE` ORDER BY `TITLE` ASC";
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
    }
    else {
	$selecttitle = "<option>".$_GET['title']."</option>";
    }
    echo '<html>';
    echo '<head>';
    echo '<link rel="stylesheet" type="text/css" href="style.css">';
    echo '</head>';
    echo '<body>';
    echo '<div align="center">';
    echo '<p><H2>Update Existing Episode Inside SkipDB</h2></p>';
    echo '<form action="update.php" method="get">';
    echo '<div class="desc">Title</div>';
    echo '<select name="title">';
    echo $selecttitle;
    echo '</select>';
    if ((isset($_GET['title'])) and (!isset($_GET['season'])) and (!isset($_GET['episode']))){
	$selectseason = "";
	include 'inc/config.inc';
        $sql="SELECT `SEASON` FROM `intro` WHERE `TITLE` = '".$_GET['title']."' AND `SEASON` != '0' AND `EPISODE` != '0' GROUP BY `SEASON` ORDER BY `SEASON` ASC";
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
	echo '<div class="desc">Season</div>';
	echo '<select name="season">';
        echo $selectseason;
	echo '</select>';
    }
    else {
	if (isset($_GET['season'])) {
	    $selectseason = "<option>".$_GET['season']."</option>";
	    echo '<div class="desc">Season</div>';
	    echo '<select name="season">';
	    echo $selectseason;
	    echo '</select>';
	}
    }
    if ((isset($_GET['title'])) and (isset($_GET['season'])) and (!isset($_GET['episode']))){
	$selectepisode = "";
	include 'inc/config.inc';
        $sql="SELECT `EPISODE` FROM `intro` WHERE `TITLE` = '".$_GET['title']."' AND `SEASON` = '".$_GET['season']."' AND `EPISODE` != '0' GROUP BY `EPISODE` ORDER BY `EPISODE` ASC";
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
	echo '<div class="desc">Episode</div>';
	echo '<select name="episode">';
        echo $selectepisode;
	echo '</select>';
    }
    else {
	if (isset($_GET['episode'])) {
	    $selectepisode = "<option>".$_GET['episode']."</option>";
	    echo '<p>Episode</p>';
	    echo '<select name="episode">';
	    echo $selectepisode;
	    echo '</select>';
	}
    }

    echo '<p><input type="submit" value="Continue" /></p>';
    echo '</form>';
    echo '</div>';
    echo '<div align="center">';
    echo '<form action="main.php">';
    echo '<button type="submit">Back</button>';
    echo '</form>';
    echo '</div>';
    echo '</body>';
    echo '</html>';
    exit;
}
else {
    $get_title = $_GET['title'];
    $get_season = $_GET['season'];
    $get_episode = $_GET['episode'];
    include 'inc/config.inc';
    $sql="SELECT * FROM `intro` WHERE 1 AND `TITLE` = '".$get_title."' AND `SEASON` = '".$get_season."' AND `EPISODE` = '".$get_episode."'";
    $ergebnis = mysql_query($sql, $verbindung);
    $zeile = mysql_fetch_array($ergebnis);
    if (mysql_errno() == '0') {
	$dummy++;
    }
    else {
	include 'inc/sqlerror.php'; $error++;
    }
    $id = $zeile[0];
    $title = $zeile[1];
    $season = $zeile[2];
    $episode = $zeile[3];
    $start = $zeile[4];
    $lenght = $zeile[5];
    echo '<html>';
    echo '<head>';
    echo '<link rel="stylesheet" type="text/css" href="style.css">';
    echo '</head>';
    echo '<body>';
    echo '<div align="center">';
    echo '<form action="update.php" method="get">';
    echo '<p><H2>Update Existing Episode Inside SkipDB</h2></p>';
    echo '<input type="hidden" name="id" value="'.$id.'" />';
    echo '<p><div class="desc">Title:   '.$title.'</p>';
    echo '<input type="hidden" name="title" value="'.$title.'" />';
    echo '<p>Season:  '.$season.'</p>';
    echo '<input type="hidden" name="season" value="'.$season.'" />';
    echo '<p>Episode: '.$episode.'</p>';
    echo '<input type="hidden" name="episode" value="'.$episode.'" /></div>';
    echo '<div class="desc">Start Position Intro (Seconds)</div>';
    echo '<input type="text" name="start" value="'.$start.'" />';
    echo '<div class="desc">Lenght Of Intro (Seconds)</div>';
    echo '<input type="text" name="lenght" value="'.$lenght.'" />';
    echo '<p><input type="submit" value="Update Episode!" style="background-color:lightgreen;" /></p>';
    echo '</form>';
    echo '</div>';
    echo '<div align="center">';
    echo '<form action="main.php">';
    echo '<button type="submit">Back</button>';
    echo '</form>';
    echo '</div>';
    echo '</body>';
    echo '</html>';
}
?>
