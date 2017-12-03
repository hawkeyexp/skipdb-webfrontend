<?php
$dummy = "";
$error = "";
if (isset($_GET['title']) and isset($_GET['season']) and isset($_GET['episode'])) {
    include 'inc/config.inc';
    $sql="SELECT * FROM `intro` WHERE 1 AND `TITLE` = '".$_GET['title']."' AND `SEASON` = '".$_GET['season']."' AND `EPISODE` = '".$_GET['episode']."' LIMIT 1";
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
    $arr = array('title' => $title,'season' => $season,'episode' => $episode,'start' => $start, 'lenght' => $lenght);
    echo json_encode($arr);
}
else {
    echo "System Ready";
}
?>