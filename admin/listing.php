<?php
include 'header.php';
echo '<div align="center">';
echo '<p><h2>Database Listing SkipDB</h2></p>';
$dummy = "";
$selecttitle = "";
include 'inc/config.inc';
$sql="SELECT ID, TITLE FROM tvshow GROUP BY TITLE ORDER BY TITLE ASC;";
$ergebnis = mysql_query($sql, $verbindung);
while($zeile = mysql_fetch_array($ergebnis)){

    $sqls="SELECT ID, SEASON FROM season WHERE TVSHOW_ID = '".$zeile[0]."' GROUP BY `SEASON` ORDER BY `SEASON` ASC;";
    $ergebniss = mysql_query($sqls, $verbindung);
    $seasons = "";
    while($zeiles = mysql_fetch_array($ergebniss)){
	echo '<div class="tvshow">'.$zeile[1].' - Season '.$zeiles[1].'</div>';
        $sqle="SELECT EPISODE FROM episode WHERE TVSHOW_ID = '".$zeile[0]."' AND SEASON_ID = '".$zeiles[0]."' GROUP BY EPISODE ORDER BY EPISODE ASC;";
        $ergebnise = mysql_query($sqle, $verbindung);
        $episodes = '';
        while($zeilee = mysql_fetch_array($ergebnise)){
	    $episodes = $episodes.' | <a href="update.php?title='.$zeile[1].'&season='.$zeiles[1].'&episode='.$zeilee[0].'&back=history">'.$zeilee[0].'</a>';
        }
	$episodes = preg_replace('/\|/','',$episodes,1);
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
