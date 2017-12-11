<?php
$dummy = 0;
$error = 0;
if (isset($_GET['title']) and isset($_GET['season'])) {
    $get_title = $_GET['title'];
    $get_season = $_GET['season'];
    include 'inc/config.inc';

    $sqlcheck="SELECT season.ID, tvshow.ID, tvshow.TITLE, season.SEASON FROM season INNER JOIN tvshow ON season.TVSHOW_ID=tvshow.ID WHERE tvshow.TITLE = '".mysql_real_escape_string($get_title)."' AND season.SEASON = '".$get_season."';";
    $ergebnischeck = mysql_query($sqlcheck, $verbindung);
    $zeilecheck = mysql_fetch_array($ergebnischeck);
    $tvshowid = $zeilecheck[1];

    if (mysql_errno() == '0') {
        $dummy++;
    }
    else {
        include 'inc/sqlerror.php'; $error++;
    }
    if ($tvshowid != "") {

	include 'header.php';
	echo '<div align="center">';
	echo '<p><h2>Insert Season Entry For TV Show Inside SkipDB</h2></p>';
	echo '<h3><p class="warn">Season exists!</p><h3>';
	echo '</div>';
	include 'back.php';
	include 'footer.php';
    }
    else {
	// get tvshow id by title
	$sql="SELECT ID FROM tvshow WHERE TITLE = '".mysql_real_escape_string($get_title)."';";
	$ergebnis = mysql_query($sql, $verbindung);
	$zeile = mysql_fetch_row($ergebnis);
	if (mysql_errno() == '0') {
	    $dummy++;
	}
        else {
	    include 'inc/sqlerror.php'; $error++;
	}
	$tvshowid = $zeile[0];

	// insert new season for tvshow
	$sql = "INSERT INTO season (ID, SEASON, TVSHOW_ID) VALUES (NULL, '".$get_season."', '".$tvshowid."');";
	$ergebnis = mysql_query($sql, $verbindung);
	if (mysql_errno() == '0') {
	    $dummy++;
	}
        else {
	    include 'inc/sqlerror.php'; $error++;
	}

	include 'header.php';
	echo '<div align="center">';
	echo '<p><H2>Insert Season Entry For TV Show Inside SkipDB</h2></p>';
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
    }

}

if (!isset($_GET['title']) and !isset($_GET['season'])) {
    $selecttitle = "";
    include 'inc/config.inc';
    //new structure
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
    echo '<form action="insertshowseason.php" method="get">';
    echo '<div align="center">';
    echo '<p><h2>Insert Season Entry For TV Show Inside SkipDB</h2></p>';
    echo '<div class="desc"><label>Titel</label></div>';
    echo '<div>';
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
if (isset($_GET['title']) and !isset($_GET['season'])) {
    $selecttitle = "<option>".$_GET['title']."</option>";
    include 'header.php';
    echo '<form action="insertshowseason.php" method="get">';
    echo '<div align="center">';
    echo '<p><h2>Insert Season Entry For TV Show Inside SkipDB</h2></p>';
    echo '<div class="desc"><label>Titel</label></div>';
    echo '<div>';
    echo '<select name="title">';
    echo $selecttitle;
    echo '</select>';
    echo '</div>';
    echo '<div class="desc"><label>Season</label></div><div><input type="text" name="season" /></div>';
    echo '<p><input type="submit" value="Insert Now!" class="riskybutton" /></p>';
    echo '</form>';
    echo '</div>';
    include 'back.php';
    include 'footer.php';
    exit;
}
?>