<?php
$dummy = 0;
$error = 0;
if (!isset($_GET['title']) or !isset($_GET['season']) or !isset($_GET['episode'])) {
    echo '<html>';
    echo '<head>';
    echo '<link rel="stylesheet" type="text/css" href="style.css">';
    echo '</head>';
    echo '<body>';
    echo '<div align="center">';
    echo '<p><H2>Welcome to SkipDB Interface</h2></p>';
    echo '<table>';
    echo '<tr>';
    echo '<td>';
    echo '<form action="insertshow.php">';
    echo '<div><button type="submit">Insert TV Show Entry</button></div>';
    echo '</form>';
    echo '</td>';
    echo '<td>';
    echo '<form action="deleteshow.php">';
    echo '<div><button type="submit">Delete TV Show Entry</button></div>';
    echo '</form>';
    echo '</td>';
    echo '</tr>';
    echo '<tr>';
    echo '<td>';
    echo '<form action="insertshowseason.php">';
    echo '<div><button type="submit">Insert Season Entry For TV Show</button></div>';
    echo '</form>';
    echo '</td>';
    echo '<td>';
    echo '<form action="deleteseason.php">';
    echo '<div><button type="submit">Delete Full Season</button></div>';
    echo '</form>';
    echo '</td>';
    echo '</tr>';
    echo '<tr>';
    echo '<td>';
    echo '<form action="insertepisode.php">';
    echo '<div><button type="submit">Insert Single Episode</button></div>';
    echo '</form>';
    echo '</td>';
    echo '<td>';
    echo '<form action="delete.php">';
    echo '<div><button type="submit">Delete Single Episode</button></div>';
    echo '</form>';
    echo '</td>';
    echo '</tr>';
    echo '<tr>';
    echo '<td>';
    echo '<form action="insertseason.php">';
    echo '<div><button type="submit">Insert Multiple Episodes</button></div>';
    echo '</form>';
    echo '</td>';
    echo '<td>';
    echo '<form action="listing.php">';
    echo '<div><button type="submit">List All TV Shows</button></div>';
    echo '</form>';
    echo '</td>';
    echo '</tr>';
    echo '<tr>';
    echo '<td>';
    echo '<form action="update.php">';
    echo '<div><button type="submit">Update Episode</button></div>';
    echo '</form>';
    echo '</td>';
    echo '<td>';
    echo '<form action="setupcheck.php">';
    echo '<div><button type="submit">Setup</button></div>';
    echo '</form>';
    echo '</td>';
    echo '</tr>';
    echo '</table>';
    echo '</div>';
    echo '</body>';
    echo '</html>';
    exit;
}
else {
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
?>