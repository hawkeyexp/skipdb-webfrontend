<?php
$dummy = 0;
$error = 0;
if ((!isset($_GET['executeintro'])) and (!isset($_GET['executeoutro'])) and (!isset($_GET['executeshows'])) and (!isset($_GET['executeseasons']))) {
    include 'header.php';
    echo '<div align="center">';
    echo '<p><H2>Create SkipDB Tables</h2></p>';
    echo '<p><div class="new">WARNING: existing tables will be erased without warning!</div></p>';
    echo '<form action="setup.php" method="get">';
    echo '<input type="hidden" name="executeintro" value="y" />';
    echo '<p><input type="submit" value="Create Intro Table!" class="riskybutton" /></p>';
    echo '</form>';
    echo '<form action="setup.php" method="get">';
    echo '<input type="hidden" name="executeoutro" value="y" />';
    echo '<p><input type="submit" value="Create Outro Table!" class="riskybutton" /></p>';
    echo '</form>';
    echo '<form action="setup.php" method="get">';
    echo '<input type="hidden" name="executeshows" value="y" />';
    echo '<p><input type="submit" value="Create Shows Table!" class="riskybutton" /></p>';
    echo '</form>';
    echo '<form action="setup.php" method="get">';
    echo '<input type="hidden" name="executeseasons" value="y" />';
    echo '<p><input type="submit" value="Create Seasons Table!" class="riskybutton" /></p>';
    echo '</form>';
    echo '</div>';
    include 'backtools.php';
    include 'footer.php';
    exit;
}
else {
    if (!isset($_GET['go'])) {
	include 'header.php';
	echo '<div align="center">';
	echo '<p><H2>Create SkipDB Tables</h2></p>';
	echo '<p><div class="new">WARNING: Last chance to stop!</div></p>';
	echo '<form action="setup.php" method="get">';
	echo '<input type="hidden" name="go" value="y" />';
	if (isset($_GET['executeintro'])) {
	    echo '<input type="hidden" name="executeintro" value="y" />';
	    echo '<p><div class="info">Create Table INTRO</div></p>';
	}
	if (isset($_GET['executeoutro'])) {
	    echo '<input type="hidden" name="executeoutro" value="y" />';
	    echo '<p><div class="info">Create Table OUTRO</div></p>';
	}
	if (isset($_GET['executeshows'])) {
	    echo '<input type="hidden" name="executeshows" value="y" />';
	    echo '<p><div class="info">Create Table SHOWS</div></p>';
	}
	if (isset($_GET['executeseasons'])) {
	    echo '<input type="hidden" name="executeseasons" value="y" />';
	    echo '<p><div class="info">Create Table SEASONS</div></p>';
	}
	echo '<p><input type="submit" value="Yes, Do It!" class="riskybutton" /></p>';
	echo '</form>';

	echo '</div>';
	include 'backtools.php';
	include 'footer.php';
	exit;
    }

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
	include 'header.php';
	echo '<div align="center">';
	echo '<p><H2>Create SkipDB Intro Tables</h2></p>';
	echo '<p><div class="desc">Done...</div></p>';
	if ($dummy > 0){
	    echo '<p><font color="lightgreen">SQL-Commands: '.$dummy.'</font></p>';
	}
	else {
	    echo '<p>SQL-Commands: '.$dummy.'</p>';
	}
	if ($error > 0){
	    echo '<p><div class="warn">Errors: '.$error.'</div></p>';
	}
	else {
	    echo '<p>Errors: '.$error.'</p>';
	}
	echo '</div>';
	include 'back.php';
	include 'footer.php';
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
	include 'header.php';
	echo '<div align="center">';
	echo '<p><H2>Create SkipDB Outro Tables</h2></p>';
	echo '<p><div class="desc">Done...</div></p>';
	if ($dummy > 0){
	    echo '<p><font color="lightgreen">SQL-Commands: '.$dummy.'</font></p>';
	}
	else {
	    echo '<p>SQL-Commands: '.$dummy.'</p>';

	}
	if ($error > 0){
	    echo '<p><div class="warn">Errors: '.$error.'</div></p>';
	}
	else {
	    echo '<p>Errors: '.$error.'</p>';
	}
	echo '</div>';
	include 'back.php';
	include 'footer.php';
    }
    if (isset($_GET['executeshows'])) {
	include 'inc/config.inc';
	$sql = "DROP TABLE IF EXISTS `tvshows`;";
	$ergebnis = mysql_query($sql, $verbindung);
	if (mysql_errno() == '0') {
		$dummy++;
	}
	else {
		include 'inc/sqlerror.php'; $error++;
	}
	$sql = "CREATE TABLE `tvshows` (`ID` int(11) NOT NULL,`TITLE` text NOT NULL, `IMDBNUMBER` int(11) NOT NULL, `TVSHOWID` int(11) NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
	$ergebnis = mysql_query($sql, $verbindung);
	if (mysql_errno() == '0') {
		$dummy++;
	}
	else {
		include 'inc/sqlerror.php'; $error++;
	}
	$sql = "ALTER TABLE `tvshows` ADD KEY `ID` (`ID`) USING BTREE;";
	$ergebnis = mysql_query($sql, $verbindung);
	if (mysql_errno() == '0') {
		$dummy++;
	}
	else {
		include 'inc/sqlerror.php'; $error++;
	}
	$sql = "ALTER TABLE `tvshows` MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;";
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
	include 'header.php';
	echo '<div align="center">';
	echo '<p><H2>Create SkipDB TV Shows Tables</h2></p>';
	echo '<p><div class="desc">Done...</div></p>';
	if ($dummy > 0){
	    echo '<p><font color="lightgreen">SQL-Commands: '.$dummy.'</font></p>';
	}
	else {
	    echo '<p>SQL-Commands: '.$dummy.'</p>';

	}
	if ($error > 0){
	    echo '<p><div class="warn">Errors: '.$error.'</div></p>';
	}
	else {
	    echo '<p>Errors: '.$error.'</p>';
	}
	echo '</div>';
	include 'back.php';
	include 'footer.php';
    }

    if (isset($_GET['executeseasons'])) {
	include 'inc/config.inc';
	$sql = "DROP TABLE IF EXISTS `seasons`;";
	$ergebnis = mysql_query($sql, $verbindung);
	if (mysql_errno() == '0') {
		$dummy++;
	}
	else {
		include 'inc/sqlerror.php'; $error++;
	}
	$sql = "CREATE TABLE `seasons` (`ID` int(11) NOT NULL,`TITLE` text NOT NULL, `SEASON` int(11) NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
	$ergebnis = mysql_query($sql, $verbindung);
	if (mysql_errno() == '0') {
		$dummy++;
	}
	else {
		include 'inc/sqlerror.php'; $error++;
	}
	$sql = "ALTER TABLE `seasons` ADD KEY `ID` (`ID`) USING BTREE;";
	$ergebnis = mysql_query($sql, $verbindung);
	if (mysql_errno() == '0') {
		$dummy++;
	}
	else {
		include 'inc/sqlerror.php'; $error++;
	}
	$sql = "ALTER TABLE `seasons` MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;";
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
	include 'header.php';
	echo '<div align="center">';
	echo '<p><H2>Create SkipDB Seasons Tables</h2></p>';
	echo '<p><div class="desc">Done...</div></p>';
	if ($dummy > 0){
	    echo '<p><font color="lightgreen">SQL-Commands: '.$dummy.'</font></p>';
	}
	else {
	    echo '<p>SQL-Commands: '.$dummy.'</p>';

	}
	if ($error > 0){
	    echo '<p><div class="warn">Errors: '.$error.'</div></p>';
	}
	else {
	    echo '<p>Errors: '.$error.'</p>';
	}
	include 'back.php';
	include 'footer.php';
    }
}
?>
