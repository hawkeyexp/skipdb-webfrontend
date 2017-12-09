<?php
include 'header.php';
echo '<div align="center">';
echo '<p><h2>Database Listing From SkipDB</h2></p>';
$dummy = "";
$selecttitle = "";
include 'inc/config.inc';
$sql="SELECT `TITLE` FROM `tvshows` WHERE 1 GROUP BY `TITLE` ORDER BY `TITLE` ASC";
$ergebnis = mysql_query($sql, $verbindung);
while($zeile = mysql_fetch_array($ergebnis)){
    $sqls="SELECT `SEASON` FROM `seasons` WHERE `TITLE` = '".mysql_real_escape_string($zeile[0])."' GROUP BY `SEASON` ORDER BY `SEASON` ASC";
    $ergebniss = mysql_query($sqls, $verbindung);
    $seasons = "";
    while($zeiles = mysql_fetch_array($ergebniss)){
	echo '<div class="tvshow">'.$zeile[0].' - Season '.$zeiles[0].'</div>';
        $sqle="SELECT `EPISODE` FROM `intro` WHERE `TITLE` = '".mysql_real_escape_string($zeile[0])."'AND `SEASON` = '".$zeiles[0]."' AND `START`!= '99999' AND `LENGHT`!= '99999' GROUP BY `EPISODE` ORDER BY `EPISODE` ASC";
        $ergebnise = mysql_query($sqle, $verbindung);
        $episodes = '';
        while($zeilee = mysql_fetch_array($ergebnise)){
	    if ($zeilee[0] != "1") {
		$episodes = $episodes.' | <a href="update.php?title='.$zeile[0].'&season='.$zeiles[0].'&episode='.$zeilee[0].'&back=history">'.$zeilee[0].'</a>';
	    }
	    else {
		$episodes = $episodes.' <a href="update.php?title='.$zeile[0].'&season='.$zeiles[0].'&episode='.$zeilee[0].'&back=history">'.$zeilee[0].'</a>';
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
echo '</div>';
echo '<div align="center">';
echo '<form action="index.php">';
echo '<button type="submit">Home</button>';
echo '</form>';
echo '</div>';
include 'footer.php';
?>
