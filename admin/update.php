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
    include 'header.php';
    echo '<div align="center">';
    echo '<p><H2>Update Existing Episode Inside SkipDB</h2></p>';
    echo '<p><div class="desc">Done...</div></p>';
    if ($dummy > 0){
	echo '<p><font color="lightgreen">SQL-Commands: '.$dummy.'</font></p>';
    }
    else {
	echo '<p>SQL-Commands: '.$dummy.'</p>';
    }
    if ($error > 0){
	echo '<p><div class="del">Errors: '.$error.'</div></p>';
    }
    else {
	echo '<p>Errors: '.$error.'</p>';
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
	echo '<div align="center">';
	echo '<p><H2>Update Existing Episode Inside SkipDB</h2></p>';
	echo '<form action="update.php" method="get">';
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
	$selecttitle = "<option>".$_GET['title']."</option>";
	include 'header.php';
	echo '<div align="center">';
	echo '<p><H2>Update Existing Episode Inside SkipDB</h2></p>';
	echo '<form action="update.php" method="get">';
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
        $sql="SELECT `EPISODE` FROM `intro` WHERE `TITLE` = '".mysql_real_escape_string($_GET['title'])."' AND `SEASON` = '".$_GET['season']."' AND `EPISODE` != '0' GROUP BY `EPISODE` ORDER BY `EPISODE` ASC";
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
	echo '<form action="update.php" method="get">';
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
    $get_title = $_GET['title'];
    $get_season = $_GET['season'];
    $get_episode = $_GET['episode'];
    include 'inc/config.inc';
    $sql="SELECT * FROM `intro` WHERE 1 AND `TITLE` = '".mysql_real_escape_string($get_title)."' AND `SEASON` = '".$get_season."' AND `EPISODE` = '".$get_episode."'";
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

    include 'header.php';
    echo '<div align="center">';
    echo '<form action="update.php" method="get">';
    echo '<p><H2>Update Existing Episode Inside SkipDB</h2></p>';
    echo '<input type="hidden" name="id" value="'.$id.'" />';
    echo '<input type="hidden" name="title" value="'.$title.'" />';
    echo '<input type="hidden" name="season" value="'.$season.'" />';
    echo '<input type="hidden" name="episode" value="'.$episode.'" />';
    echo '<div class="info">'.$title.' - S'.sprintf("%'.02d",$season).'E'.sprintf("%'.02d",$episode).'</div>';
    echo '<div class="desc">Start Position Intro (Seconds)</div>';
    echo '<input type="text" name="start" value="'.$start.'" />';
    echo '<div class="desc">Lenght Of Intro (Seconds)</div>';
    echo '<input type="text" name="lenght" value="'.$lenght.'" />';
    echo '<p><input type="submit" value="Update Episode!" class="riskybutton" /></p>';
    echo '</form>';
    echo '</div>';
    include 'back.php';
    include 'footer.php';
}
?>
