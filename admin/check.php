<?php
$dummy = 0;
$error = 0;
include 'header.php';
echo '<div align="center">';
echo '<p><H2>MySQL Table Check SkipDB</h2></p>';
echo '<div class="info">Result</div><p>';

include 'inc/config.inc';
$sql = "SHOW FULL TABLES FROM `".$datenbank."`;";
$ergebnis = mysql_query($sql, $verbindung);
while($tbl = mysql_fetch_array($ergebnis)) {
    echo '<div class="desc">'.$tbl[0].'</div>';
    $sql1 = "DESCRIBE `".$tbl[0]."`;";
    $ergebnis1 = mysql_query($sql1, $verbindung);
    while($zeile = mysql_fetch_array($ergebnis1)) {
	echo '<div class="info">'.$zeile[0].'</div>';
    }
}
if (mysql_errno() == '0') {
    $dummy++;
}
else {
    include 'inc/sqlerror.php'; $error++;
}

echo '</div>';
include 'backtools.php';
include 'footer.php';
?>
