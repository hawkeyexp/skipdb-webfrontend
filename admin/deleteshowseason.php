<?php
$dummy = 0;
$error = 0;
if ((isset($_GET['title'])) and (isset($_GET['season']))){
    include 'inc/config.inc';
    $sql = "DELETE FROM `seasons` WHERE `TITLE` = '".mysql_real_escape_string($_GET['title'])."' AND `SEASON` = '".$_GET['season']."'";
    $ergebnis = mysql_query($sql, $verbindung);
    if (mysql_errno() == '0') {
    	$dummy++;
    }
    else {
    	include 'inc/sqlerror.php'; $error++;
    }
    include 'header.php';
    echo '<div align="center">';
    echo '<p><H2>Delete Season From TV Show Inside SkipDB</h2></p>';
    echo '<p><div class="desc">Done...</div></p>';
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
    echo '</div>';
    include 'back.php';
    include 'footer.php';
    exit;
}
if ((!isset($_GET['title'])) or (!isset($_GET['season']))){
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
    }
    else {
	$selecttitle = "<option>".$_GET['title']."</option>";
    }
    include 'header.php';
    echo '<div align="center">';
    echo '<p><H2>Delete Season From TV Show Inside SkipDB</h2></p>';
    echo '<form action="deleteshowseason.php" method="get">';
    echo '<div class="desc">Title</div>';
    echo '<select name="title">';
    echo $selecttitle;
    echo '</select>';
    if ((isset($_GET['title'])) and (!isset($_GET['season']))){
	$selectseason = "";
	include 'inc/config.inc';
        $sql="SELECT `SEASON` FROM `seasons` WHERE `TITLE` = '".mysql_real_escape_string($_GET['title'])."' AND `SEASON` != '0' GROUP BY `SEASON` ORDER BY `SEASON` ASC";
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
        echo '<p><input type="submit" value="Delete Now!" class="riskybutton" /></p>';
        echo '</form>';
        echo '</div>';
	include 'back.php';
	include 'footer.php';
        exit;
    }
    else {
	if (isset($_GET['season'])) {
	    $selectseason = "<option>".$_GET['season']."</option>";
	    echo '<div class="desc">Season:</div>';
	    echo '<select name="season">';
	    echo $selectseason;
	    echo '</select>';
	}
    }
    echo '<p><input type="submit" value="Continue" class="conbutton" /></p>';
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
