<?php
$dummy = 0;
$error = 0;
if ((isset($_GET['title'])) and (isset($_GET['season'])) and (isset($_GET['tvshowid']))){
    include 'inc/config.inc';
    $sql = "DELETE FROM season WHERE TVSHOW_ID = '".$_GET['tvshowid']."' AND SEASON_NUMBER = '".$_GET['season']."';";
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

	// get tvshowid by title
	$sql="SELECT ID FROM tvshow WHERE TITLE = '".mysql_real_escape_string($_GET['title'])."';";
        $ergebnis = mysql_query($sql, $verbindung);
        $tvshowid = mysql_fetch_row($ergebnis)[0];
	if (mysql_errno() == '0') {
	    $dummy++;
        }
	else {
	    include 'inc/sqlerror.php'; $error++;
        }

        $sql="SELECT ID, SEASON_NUMBER FROM season WHERE TVSHOW_ID = '".$tvshowid."' GROUP BY SEASON_NUMBER ORDER BY SEASON_NUMBER ASC";
        $ergebnis = mysql_query($sql, $verbindung);
        while($zeile = mysql_fetch_array($ergebnis)){
	    // check if season has episodes - if yes ignore in listing
	    $sqlcheck="SELECT SEASON_ID FROM episode WHERE TVSHOW_ID = '".$tvshowid."' AND SEASON_ID = '".$zeile[0]."' LIMIT 1;";
	    $ergebnischeck = mysql_query($sqlcheck, $verbindung);
	    $check = mysql_fetch_row($ergebnischeck)[0];
	    if (mysql_errno() == '0') {
		$dummy++;
    	    }
	    else {
		include 'inc/sqlerror.php'; $error++;
    	    }
	    if ($check != $zeile[0]) {
		$selectseason = $selectseason."<option>".$zeile[1]."</option>";
	    }
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
	echo '<input type="hidden" name="tvshowid" value="'.$tvshowid.'" />';
	echo '<p><div class="info">Only seasons without episodes will be selectable!</div></p>';
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
