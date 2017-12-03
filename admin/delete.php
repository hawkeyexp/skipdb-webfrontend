<?php
$dummy = 0;
$error = 0;
if ((isset($_GET['title'])) and (isset($_GET['season'])) and (isset($_GET['episode']))){
    include 'inc/config.inc';
    $sql = "DELETE FROM `intro` WHERE `TITLE` = '".$_GET['title']."' AND `SEASON` = '".$_GET['season']."' AND `EPISODE` = '".$_GET['episode']."'";
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
    echo '<p><H2>Delete Single Episode Inside SkipDB</h2></p>';
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
        $sql="SELECT `TITLE` FROM `intro` WHERE `SEASON` != '0' GROUP BY `TITLE` ORDER BY `TITLE` ASC";
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
        echo '<html>';
	echo '<head>';
	echo '<link rel="stylesheet" type="text/css" href="style.css">';
	echo '</head>';
	echo '<body>';
	echo '<div align="center">';
	echo '<p><H2>Delete Single Episode Inside SkipDB</h2></p>';
	echo '<form action="delete.php" method="get">';
	echo '<div class="desc">Title</div>';
	echo '<select name="title">';
	echo $selecttitle;
	echo '</select>';
	echo '<p><input type="submit" value="Continue"></p>';
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
	$selecttitle = "<option>".$_GET['title']."</option>";
    }

    if ((isset($_GET['title'])) and (!isset($_GET['season'])) and (!isset($_GET['episode']))){
	$selectseason = "";
	include 'inc/config.inc';
        $sql="SELECT `SEASON` FROM `intro` WHERE `TITLE` = '".$_GET['title']."' AND `SEASON` != '0' GROUP BY `SEASON` ORDER BY `SEASON` ASC";
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
        echo '<html>';
	echo '<head>';
	echo '<link rel="stylesheet" type="text/css" href="style.css">';
	echo '</head>';
	echo '<body>';
	echo '<div align="center">';
	echo '<p><H2>Delete Single Episode Inside SkipDB</h2></p>';
	echo '<form action="delete.php" method="get">';
	echo '<div class="desc">Title</div>';
	echo '<select name="title">';
	echo $selecttitle;
	echo '</select>';
	echo '<div class="desc">Season</div>';
	echo '<select name="season">';
        echo $selectseason;
	echo '</select>';
	echo '<p><input type="submit" value="Continue"></p>';
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
	if (isset($_GET['season'])) {
	    $selectseason = "<option>".$_GET['season']."</option>";
	}
    }
    if ((isset($_GET['title'])) and (isset($_GET['season'])) and (!isset($_GET['episode']))){
	$selectepisode = "";
	include 'inc/config.inc';
        $sql="SELECT `EPISODE` FROM `intro` WHERE `TITLE` = '".$_GET['title']."' AND `SEASON` = '".$_GET['season']."' AND `EPISODE`!= '0' GROUP BY `EPISODE` ORDER BY `EPISODE` ASC";
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
        echo '<html>';
	echo '<head>';
	echo '<link rel="stylesheet" type="text/css" href="style.css">';
	echo '</head>';
	echo '<body>';
	echo '<div align="center">';
	echo '<p><H2>Delete Single Episode Inside SkipDB</h2></p>';
	echo '<form action="delete.php" method="get">';
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
	echo '<p><input type="submit" value="Delete Now!" style="color: white;background-color:crimson;"></p>';
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
}
?>
