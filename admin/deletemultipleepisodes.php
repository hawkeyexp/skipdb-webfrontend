<?php
$dummy = 0;
$error = 0;
if ((isset($_GET['title'])) and (isset($_GET['season']))){
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
    $sql="SELECT ID FROM season WHERE TVSHOW_ID = '".$tvshowid."' AND SEASON_NUMBER = '".$_GET['season']."' LIMIT 1;";
    $ergebnis = mysql_query($sql, $verbindung);
    $zeile = mysql_fetch_row($ergebnis);
    if (mysql_errno() == '0') {
        $dummy++;
    }
    else {
        include 'inc/sqlerror.php'; $error++;
    }
    $seasonid = $zeile[0];

    $sql = "DELETE FROM episode WHERE TVSHOW_ID = '".$tvshowid."' AND SEASON_ID = '".$seasonid."';";
    $ergebnis = mysql_query($sql, $verbindung);
    if (mysql_errno() == '0') {
    	$dummy++;
    }
    else {
    	include 'inc/sqlerror.php'; $error++;
    }
    include 'header.php';
    echo '<div align="center">';
    echo '<p><H2>Delete All Episodes Of A Season Inside SkipDB</h2></p>';
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
if ((!isset($_GET['title'])) or (!isset($_GET['season']))){
    if (!isset($_GET['title'])){
	$selecttitle = "";
	include 'inc/config.inc';
	$sql="SELECT TITLE FROM tvshow GROUP BY TITLE ORDER BY TITLE ASC";
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
    echo '<p><H2>Delete All Episodes Of A Season Inside SkipDB</h2></p>';
    echo '<form action="deletemultipleepisodes.php" method="get">';
    echo '<div class="desc">Title</div>';
    echo '<select name="title">';
    echo $selecttitle;
    echo '</select>';
    if ((isset($_GET['title'])) and (!isset($_GET['season']))){
	$selectseason = "";
	include 'inc/config.inc';
	$sql="SELECT season.SEASON_NUMBER FROM season INNER JOIN tvshow ON season.TVSHOW_ID=tvshow.ID WHERE tvshow.TITLE = '".mysql_real_escape_string($_GET['title'])."' GROUP BY SEASON_NUMBER ORDER BY SEASON_NUMBER ASC;";
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
    echo '<table>';
    echo '<tr>';
    echo '<td>';
    echo '<form action="menu_delete.php">';
    echo '<button type="submit">Back</button>';
    echo '</form>';
    echo '</td>';
    echo '<td>';
    echo '<form action="index.php">';
    echo '<button type="submit">Home</button>';
    echo '</form>';
    echo '</td>';
    echo '</tr>';
    echo '</table>';
    echo '</div>';
    echo '</div>';
    include 'footer.php';
}
?>
