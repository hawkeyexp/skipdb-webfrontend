<?php

include 'inc/config.inc';
$dummy = 0;
$sql="SELECT ID, COUNT(*) FROM tvshow";
$ergebnis = mysql_query($sql, $verbindung);
$zeile = mysql_fetch_array($ergebnis);
if (mysql_errno() == '0') {
    $dummy++;
}
else {
    include 'inc/sqlerror.php'; $error++;
}
if ($zeile[0] != "") {
$tvshows = $zeile[1];
}
else {
$tvshows = '0';
}

$dummy = 0;
$sql="SELECT ID, COUNT(*) FROM season";
$ergebnis = mysql_query($sql, $verbindung);
$zeile = mysql_fetch_array($ergebnis);
if (mysql_errno() == '0') {
    $dummy++;
}
else {
    include 'inc/sqlerror.php'; $error++;
}
if ($zeile[0] != "") {
$seasons = $zeile[1];
}
else {
$seasons = '0';
}

$dummy = 0;
$sql="SELECT ID, COUNT(*) FROM episode WHERE INTRO_LENGTH != '0'";
$ergebnis = mysql_query($sql, $verbindung);
$zeile = mysql_fetch_array($ergebnis);
if (mysql_errno() == '0') {
    $dummy++;
}
else {
    include 'inc/sqlerror.php'; $error++;
}
if ($zeile[0] != "") {
$episodesdata = $zeile[1];
}
else {
$episodesdata = '0';
}

$dummy = 0;
$sql="SELECT ID, COUNT(*) FROM episode WHERE INTRO_LENGTH = '0'";
$ergebnis = mysql_query($sql, $verbindung);
$zeile = mysql_fetch_array($ergebnis);
if (mysql_errno() == '0') {
    $dummy++;
}
else {
    include 'inc/sqlerror.php'; $error++;
}
if ($zeile[0] != "") {
$episodesnodata = $zeile[1];
}
else {
$episodesnodata = '0';
}


include 'header.php';
echo '<div align="center">';
echo '<p><form action="index.php">';
echo '<button type="submit" style="width:524px; font-size:1.2em">>> Show Main Menu <<</button>';
echo '</form></p>';
echo '<table>';
echo '<tr>';
echo '<td>';
echo '<div class="dash">TV Shows<br>'.$tvshows.'</div>';
echo '</td>';
echo '<td>';
echo '<div class="dash">Seasons<br>'.$seasons.'</div>';
echo '</td>';
echo '</tr>';
echo '<tr>';
echo '<td>';
echo '<div class="dash">Episodes with Data Sets<br>'.$episodesdata.'</div>';
echo '</td>';
echo '<td>';
echo '<div class="dash">Missing Data Sets<br>'.$episodesnodata.'</div>';
echo '</td>';
echo '</tr>';
echo '</table>';
echo '</div>';
include 'footer.php';
?>

