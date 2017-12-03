<?php
echo '<html>';
echo '<head>';
echo '<link rel="stylesheet" type="text/css" href="style.css">';
echo '</head>';
echo '<body>';
echo '<div class="listing">';
echo '<div align="center">';
echo '<H2>Database Listing From SkipDB</h2>';
$dummy = "";
$selecttitle = "";
include 'inc/config.inc';
$sql="SELECT `TITLE` FROM `intro` GROUP BY `TITLE` ORDER BY `TITLE` ASC";
$ergebnis = mysql_query($sql, $verbindung);
while($zeile = mysql_fetch_array($ergebnis)){
    // get seasons
    $sqls="SELECT `SEASON` FROM `intro` WHERE `TITLE` = '".$zeile[0]."' AND `SEASON` != '0' AND `EPISODE` != '0' GROUP BY `SEASON` ORDER BY `SEASON` ASC";
    $ergebniss = mysql_query($sqls, $verbindung);
    $seasons = "";
    while($zeiles = mysql_fetch_array($ergebniss)){
	echo '<div class="tvshow">'.$zeile[0].' - Season '.$zeiles[0].'</div>';
        // get episodes
        $sqle="SELECT `EPISODE` FROM `intro` WHERE `TITLE` = '".$zeile[0]."'AND `SEASON` = '".$zeiles[0]."' AND `EPISODE`!= '0' GROUP BY `EPISODE` ORDER BY `EPISODE` ASC";
        $ergebnise = mysql_query($sqle, $verbindung);
        $episodes = '';
        while($zeilee = mysql_fetch_array($ergebnise)){
	    if ($zeilee[0] != "1") {
		$episodes = $episodes.' | '.$zeilee[0];
	    }
	    else {
		$episodes = $episodes.' '.$zeilee[0];
	    }
        }
	echo '<div class="episodes">'.$episodes.'</div><p>';
    }
}
if (mysql_errno() == '0') {
    $dummy++;
    }
else {
    include 'inc/sqlerror.php'; $error++;
}
echo '<div align="center">';
echo '<form action="main.php">';
echo '<button type="submit">Back</button>';
echo '</form>';
echo '</div>';
echo '</div>';
echo '</body>';
echo '</html>';
?>
