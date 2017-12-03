<?php
$dummy = 0;
$error = 0;
if ((!isset($_GET['executeintro'])) and (!isset($_GET['executeoutro']))) {
    echo '<html>';
    echo '<head>';
    echo '<link rel="stylesheet" type="text/css" href="style.css">';
    echo '</head>';
    echo '<body>';
    echo '<div align="center">';
    echo '<p><H2>Create SkipDB Tables</h2></p>';
    echo '<p><H3><font color="red" style="text-shadow: 2px 2px #000000">WARNING: existing tables will be erased without warning!</font></h3></p>';
    echo '<form action="setup.php" method="get">';
    echo '<input type="hidden" name="executeintro" value="y" />';
    echo '<p><input type="submit" value="Create Intro Tables!" style="background-color: lightgreen;" /></p>';
    echo '</form>';
    echo '<form action="setup.php" method="get">';
    echo '<input type="hidden" name="executeoutro" value="y" />';
    echo '<p><input type="submit" value="Create Outro Tables!" style="background-color: lightgreen;" /></p>';
    echo '</form>';
    echo '</div>';
    echo '<br><div align="center">';
    echo '<form action="setupcheck.php">';
    echo '<button type="submit">Back</button>';
    echo '</form>';
    echo '</div>';
    echo '</body>';
    echo '</html>';
    exit;
}
else {
    if (isset($_GET['executeintro'])) {
	include 'inc/config.inc';
	$sql = "DROP TABLE IF EXISTS `intro`;";
	$ergebnis = mysql_query($sql, $verbindung);
	if (mysql_errno() == '0') {
		$dummy++;
	}
	else {
		include 'inc/sqlerror.php'; $error++;
	}
	$sql = "CREATE TABLE `intro` (`ID` int(11) NOT NULL,`TITLE` text NOT NULL,`SEASON` int(11) NOT NULL,`EPISODE` int(11) NOT NULL,`START` int(11) NOT NULL, `LENGHT` int(11) NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
	$ergebnis = mysql_query($sql, $verbindung);
	if (mysql_errno() == '0') {
		$dummy++;
	}
	else {
		include 'inc/sqlerror.php'; $error++;
	}
	$sql = "ALTER TABLE `intro` ADD KEY `ID` (`ID`) USING BTREE;";
	$ergebnis = mysql_query($sql, $verbindung);
	if (mysql_errno() == '0') {
		$dummy++;
	}
	else {
		include 'inc/sqlerror.php'; $error++;
	}
	$sql = "ALTER TABLE `intro` MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;";
	$ergebnis = mysql_query($sql, $verbindung);
	if (mysql_errno() == '0') {
		$dummy++;
	}
	else {
		include 'inc/sqlerror.php'; $error++;
	}
	$sql = "COMMIT;";
	$ergebnis = mysql_query($sql, $verbindung);
	if (mysql_errno() == '0') {
		$dummy++;
	}
	else {
		include 'inc/sqlerror.php'; $error++;
	}
	echo '<html>';
	echo '<head>';
	echo '<link rel="stylesheet" type="text/css" href="style.css">';
	echo '</head>';
	echo '<body>';
	echo '<div align="center">';
	echo '<p><H2>Create SkipDB Intro Tables</h2></p>';
	echo '<p>Done...</p>';
	if ($dummy > 0){
	    echo '<p><font color="lightgreen">SQL-Commands: '.$dummy.'</font></p>';
	}
	else {
	    echo '<p>SQL-Commands: '.$dummy.'</p>';
	}
	if ($error > 0){
	    echo '<p><font color="#990000">Errors: '.$error.'</font></p>';
	}
	else {
	    echo '<p>Errors: '.$error.'</p>';
	}
	echo '<form action="main.php">';
	echo '<button type="submit">Back</button>';
	echo '</form>';
	echo '</div>';
	echo '</body>';
        echo '</html>';
    }
    if (isset($_GET['executeoutro'])) {
	include 'inc/config.inc';
	$sql = "DROP TABLE IF EXISTS `outro`;";
	$ergebnis = mysql_query($sql, $verbindung);
	if (mysql_errno() == '0') {
		$dummy++;
	}
	else {
		include 'inc/sqlerror.php'; $error++;
	}
	$sql = "CREATE TABLE `outro` (`ID` int(11) NOT NULL,`TITLE` text NOT NULL,`SEASON` int(11) NOT NULL,`EPISODE` int(11) NOT NULL,`START` int(11) NOT NULL, `LENGHT` int(11) NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
	$ergebnis = mysql_query($sql, $verbindung);
	if (mysql_errno() == '0') {
		$dummy++;
	}
	else {
		include 'inc/sqlerror.php'; $error++;
	}
	$sql = "ALTER TABLE `outro` ADD KEY `ID` (`ID`) USING BTREE;";
	$ergebnis = mysql_query($sql, $verbindung);
	if (mysql_errno() == '0') {
		$dummy++;
	}
	else {
		include 'inc/sqlerror.php'; $error++;
	}
	$sql = "ALTER TABLE `outro` MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;";
	$ergebnis = mysql_query($sql, $verbindung);
	if (mysql_errno() == '0') {
		$dummy++;
	}
	else {
		include 'inc/sqlerror.php'; $error++;
	}
	$sql = "COMMIT;";
	$ergebnis = mysql_query($sql, $verbindung);
	if (mysql_errno() == '0') {
		$dummy++;
	}
	else {
		include 'inc/sqlerror.php'; $error++;
	}
	echo '<html>';
	echo '<head>';
	echo '<link rel="stylesheet" type="text/css" href="style.css">';
	echo '</head>';
	echo '<body>';
	echo '<div align="center">';
	echo '<p><H2>Create SkipDB Outro Tables</h2></p>';
	echo '<p>Done...</p>';
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
	echo '<form action="main.php">';
	echo '<button type="submit">Back</button>';
	echo '</form>';
	echo '</div>';
	echo '</body>';
        echo '</html>';
    }
}

?>
