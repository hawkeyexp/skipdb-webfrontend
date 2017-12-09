<?php
$dummy = 0;
$dummycheck = 0;
$dummyskip = 0;
if (!isset($_GET['title']) or !isset($_GET['season']) or !isset($_GET['episodestart']) or !isset($_GET['episodeend']) or !isset($_GET['introend']) or !isset($_GET['introend'])) {
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
	echo '<form action="insertmultipleepisodes.php" method="get">';
	echo '<div align="center">';
	echo '<p><H2>Insert Multiple Episodes Inside SkipDB</h2></p>';
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
	echo '<div class="desc"><label>First Episode</label></div><div><input type="text" name="episodestart" /></div>';
	echo '<div class="desc"><label>Last Episode</label></div><div><input type="text" name="episodeend" /></div>';
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
	include 'header.php';
	echo '<form action="insertmultipleepisodes.php" method="get">';
	echo '<div align="center">';
	echo '<p><H2>Insert Multiple Episodes Inside SkipDB</h2></p>';
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
    $get_episodeend = $_GET['episodeend'];
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

    $error = 0;
    include 'inc/config.inc';
    $count = $get_episodestart;
    for ($count; $count <= $get_episodeend; $count++) {

	$sqlcheck="SELECT * FROM `intro` WHERE 1 AND `TITLE` = '".mysql_real_escape_string($get_title)."' AND `SEASON` = '".$get_season."' AND `EPISODE` = '".$count."'";
	$ergebnischeck = mysql_query($sqlcheck, $verbindung);
	$zeilecheck = mysql_fetch_array($ergebnischeck);
	if (mysql_errno() == '0') {
	    $dummycheck++;
	}
	else {
	    include 'inc/sqlerror.php'; $error++;
	}
	if ($zeilecheck[0] != "") {
	    $dummyskip++;
	}
	else {
	    $sql = "INSERT INTO `intro` (`ID`, `TITLE`, `SEASON`, `EPISODE`, `START`, `LENGHT`) VALUES (NULL, '".mysql_real_escape_string($get_title)."', '".$get_season."', '".$count."', '".$get_introstart."', '".$get_introend."')";
	    $ergebnis = mysql_query($sql, $verbindung);
	    if (mysql_errno() == '0') {
		$dummy++;
	    }
	    else {
		include 'inc/sqlerror.php'; $error++;
	    }
	}
    }
    include 'header.php';
    echo '<div align="center">';
    echo '<p><H2>Insert Multiple Episodes Inside SkipDB</h2></p>';
    echo '<p><div class="desc">Done...</div></p>';
    if ($dummy > 0){
	echo '<p><font color="lightgreen">SQL-Commands: '.$dummy.'</font></p>';
    }
    else {
	echo '<p>SQL-Commands: '.$dummy.'</p>';
    }
    if ($dummyskip > 0){
	echo '<p><h3><div class="warn">Skipped: '.$dummyskip.' (Existing)</div></h3></p>';
    }
    if ($error > 0){
	echo '<p><font color="crimson">Errors: '.$error.'</font></p>';
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
?>

