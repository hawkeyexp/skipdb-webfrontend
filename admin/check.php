<?php
$dummy = 0;
$error = 0;
include 'header.php';
echo '<div align="center">';
echo '<p><H2>MySQL Table Check SkipDB</h2></p>';
echo '<div class="info">Result</div><p>';

include 'inc/config.inc';
$sql = "SHOW FULL TABLES FROM `".$datenbank."`;";
$ergebnis = mysqli_query($verbindung, $sql);
while($tbl = mysqli_fetch_array($ergebnis)) {
    echo '<div class="desc">'.$tbl[0].'</div>';
    $sql1 = "DESCRIBE `".$tbl[0]."`;";
    $ergebnis1 = mysqli_query($verbindung, $sql1);
    while($zeile = mysqli_fetch_array($ergebnis1, MYSQLI_BOTH)) {
	echo '<div class="info">'.$zeile[0].'</div>';
    }
}
if (mysqli_errno($verbindung) == '0') {
    $dummy++;
}
else {
    include 'inc/sqlerror.php'; $error++;
}

echo '</div>';
include 'backtools.php';
include 'footer.php';
?>
