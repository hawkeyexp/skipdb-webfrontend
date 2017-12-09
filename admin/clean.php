<?php
$dummy = 0;
$error = 0;
if (isset($_GET['clean'])){
    include 'inc/config.inc';
    $sql = "DELETE FROM `intro` WHERE `SEASON` = '0' or `EPISODE` = '0'";
    $ergebnis = mysql_query($sql, $verbindung);
    if (mysql_errno() == '0') {
    	$dummy++;
    }
    else {
    	include 'inc/sqlerror.php'; $error++;
    }
    include 'header.php';
    echo '<div align="center">';
    echo '<p><H2>Cleaning SkipDB</h2></p>';
    echo '<p><div class="desc">Done...</div></p>';
    if ($dummy > 0){
	echo '<p><font color="lightgreen">SQL-Commands: '.$dummy.'</font></p>';
    }
    else {
	echo '<p>SQL-Commands: '.$dummy.'</p>';
    }
    if ($error > 0){
	echo '<p><font color="crimson">Errors: '.$error.'</font></p>';
    }
    else {
	echo '<p>Errors: '.$error.'</p>';
    }
    echo '</div>';
    include 'backtools.php';
    include 'footer.php';
    exit;
}
else {
    include 'header.php';
    echo '<div align="center">';
    echo '<p><H2>Cleaning SkipDB</h2></p>';
    echo '<p><div class="new">This will only clean up old entries from old db structure!</div></p>';
    echo '<form action="clean.php" method="get">';
    echo '<input type="hidden" name="clean" value="go" />';
    echo '<p><input type="submit" value="Clean Now!" class="riskybutton"></p>';
    echo '</form>';
    echo '</div>';
    include 'backtools.php';
    include 'footer.php';
    exit;
}
?>
