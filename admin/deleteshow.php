<?php
$dummy = 0;
$error = 0;
if (isset($_GET['title'])){
    include 'inc/config.inc';
    $sql = "DELETE FROM `tvshows` WHERE `TITLE` = '".mysql_real_escape_string($_GET['title'])."'";
    $ergebnis = mysql_query($sql, $verbindung);
    if (mysql_errno() == '0') {
    	$dummy++;
    }
    else {
    	include 'inc/sqlerror.php'; $error++;
    }
    include 'header.php';
    echo '<div align="center">';
    echo '<p><H2>Delete TV Show Entry Inside SkipDB</h2></p>';
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
    include 'back.php';
    include 'footer.php';
    exit;
}
else {
    $selecttitle = "";
    include 'inc/config.inc';
    $sql="SELECT `TITLE` FROM `tvshows` WHERE 1 GROUP BY `TITLE` ORDER BY `TITLE` ASC";
    $ergebnis = mysql_query($sql, $verbindung);
    while($zeile = mysql_fetch_array($ergebnis)){
	// check if show  has seasons - if yes ignore in listing
	$sqlcheck="SELECT `TITLE` FROM `seasons` WHERE `TITLE` = '".mysql_real_escape_string($zeile[0])."' LIMIT 1";
	$ergebnischeck = mysql_query($sqlcheck, $verbindung);
	if (mysql_errno() == '0') {
    	    $dummy++;
	}
	else {
    	    include 'inc/sqlerror.php'; $error++;
	}
	$check = mysql_fetch_row($ergebnischeck);
	if ($check[0] != $zeile[0]) {
	    $selecttitle = $selecttitle."<option>".$zeile[0]."</option>";
	}
    }
    if (mysql_errno() == '0') {
        $dummy++;
    }
    else {
        include 'inc/sqlerror.php'; $error++;
    }
    include 'header.php';
    echo '<div align="center">';
    echo '<p><H2>Delete TV Show Entry Inside SkipDB</h2></p>';
    echo '<form action="deleteshow.php" method="get">';
    echo '<div class="desc">Title</div>';
    echo '<select name="title">';
    echo $selecttitle;
    echo '</select>';
    echo '<p><input type="submit" value="Delete Now!" class="riskybutton" /></p>';
    echo '</form>';
    echo '</div>';
    echo '<div align="center">';
    echo '<form action="index.php">';
    echo '<button type="submit">Home</button>';
    echo '</form>';
    echo '</div>';
    include 'footer.php';
}
?>
