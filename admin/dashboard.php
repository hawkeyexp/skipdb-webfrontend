<?php

include 'inc/config.inc';
$dummy = 0;
$sql="SELECT `TITLE`, COUNT(*) FROM `tvshows`";
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
$sql="SELECT `TITLE`, COUNT(*) FROM `seasons`";
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
$sql="SELECT `TITLE`, COUNT(*) FROM `intro` WHERE `START` != '99999'";
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
$sql="SELECT `TITLE`, COUNT(*) FROM `intro` WHERE `START` = '99999'";
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
echo '<button type="submit" style="width:524px; font-size:1.2em">Show SkipDB Main Menu</button>';
echo '</form></p>';
echo '<table>';
echo '<tr>';
echo '<td>';
echo '<p><div class="dash">TV Shows<br>'.$tvshows.'</div></p>';
echo '</td>';
echo '<td>';
echo '<p><div class="dash">Seasons<br>'.$seasons.'</div></p>';
echo '</td>';
echo '</tr>';
echo '<tr>';
echo '<td>';
echo '<p><div class="dash">Episodes with Data Sets<br>'.$episodesdata.'</div></p>';
echo '</td>';
echo '<td>';
echo '<p><div class="dash">Missing Data Sets<br>'.$episodesnodata.'</div></p>';
echo '</td>';
echo '</tr>';
echo '</table>';
echo '</div>';
include 'footer.php';
?>

