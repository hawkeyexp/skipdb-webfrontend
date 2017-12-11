<?php
$dummy = "";
$error = "";
if (isset($_GET['title']) and isset($_GET['season']) and isset($_GET['episode'])) {
    if (($_GET['title'] == "test") and ($_GET['season'] == "test") and ($_GET['episode'] == "test")) {
	$arr = array('title' => $_GET['title'],'season' => $_GET['season'],'episode' => $_GET['episode'],'start' => 0, 'lenght' => 0);
	echo json_encode($arr);
	exit;
    }

    include 'inc/testconfig.inc';

    // get tvshowid by title
    $sql="SELECT ID, TITLE FROM tvshow WHERE TITLE = '".mysql_real_escape_string($_GET['title'])."' LIMIT 1;";
    $ergebnis = mysql_query($sql, $verbindung);
    $zeile = mysql_fetch_row($ergebnis);
    if (mysql_errno() == '0') {
        $dummy++;
    }
    else {
        include 'inc/sqlerror.php'; $error++;
    }
    $tvshowid = $zeile[0];
    $title = $zeile[1];

    // get seasonid by tvshowid and season
    $sql="SELECT ID, SEASON FROM season WHERE TVSHOW_ID = '".$tvshowid."' AND SEASON = '".$_GET['season']."' LIMIT 1;";
    $ergebnis = mysql_query($sql, $verbindung);
    $zeile = mysql_fetch_row($ergebnis);
    if (mysql_errno() == '0') {
        $dummy++;
    }
    else {
        include 'inc/sqlerror.php'; $error++;
    }
    $seasonid = $zeile[0];
    $season = $zeile[1];

    // get episodeid by tvshowid, seasonid and episode
    $sql="SELECT * FROM episode WHERE TVSHOW_ID = '".$tvshowid."' AND SEASON_ID = '".$seasonid."' AND EPISODE = '".$_GET['episode']."' LIMIT 1;";
    $ergebnis = mysql_query($sql, $verbindung);
    $zeile = mysql_fetch_row($ergebnis);
    if (mysql_errno() == '0') {
        $dummy++;
    }
    else {
        include 'inc/sqlerror.php'; $error++;
    }

    $episode = $zeile[1];
    $start = $zeile[4];
    $lenght = $zeile[5];
    $outro = $zeile[6];

    // if db value is 0 for length or outro set it to 99999
    if ($lenght == '0') {
	$start = '99999';
	$lenght = '99999';
    }

    if ($outro == '0') {
	$outro = '99999';
    }

    $arr = array('title' => $title,'season' => $season,'episode' => $episode,'start' => $start, 'lenght' => $lenght, 'outro' => $outro);
    echo json_encode($arr);
}
else {
    echo "System Ready";
}
?>
