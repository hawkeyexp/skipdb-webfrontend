<?php
$dummy = 0;
$error = 0;
if (!isset($_GET['execute'])) {
    include 'header.php';
    echo '<div align="center">';
    echo '<p><H2>Create SkipDB Tables</h2></p>';
    echo '<p><div class="new">WARNING: existing tables will be erased without warning!</div></p>';
    echo '<form action="setup.php" method="get">';
    echo '<input type="hidden" name="execute" value="y" />';
    echo '<p><input type="submit" value="Create SkipDB Tables!" class="riskybutton" /></p>';
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
	if (isset($_GET['execute'])) {
	    echo '<input type="hidden" name="execute" value="y" />';
	    echo '<p><div class="info">Create SkipDB Tables</div></p>';
	}
	echo '<p><input type="submit" value="Yes, Do It!" class="riskybutton" /></p>';
	echo '</form>';

	echo '</div>';
	include 'backtools.php';
	include 'footer.php';
	exit;
    }

    if (isset($_GET['execute'])) {
	include 'inc/config.inc';
	$sql = "DROP TABLE IF EXISTS `tvshow`;";
	$ergebnis = mysqli_query($verbindung, $sql);
	if (mysqli_errno($verbindung) == '0') {
		$dummy++;
	}
	else {
		include 'inc/sqlerror.php'; $error++;
	}
	$sql = "CREATE TABLE `tvshow` (`ID` int(11) NOT NULL,`TITLE` text NOT NULL,`IMDBNUMBER` int(11) DEFAULT '0',`KODI_ID` int(11) DEFAULT '0') ENGINE=InnoDB DEFAULT CHARSET=utf8;";
	$ergebnis = mysqli_query($verbindung, $sql);
	if (mysqli_errno($verbindung) == '0') {
		$dummy++;
	}
	else {
		include 'inc/sqlerror.php'; $error++;
	}
	$sql = "ALTER TABLE `tvshow` ADD PRIMARY KEY (`ID`);";
	$ergebnis = mysqli_query($verbindung, $sql);
	if (mysqli_errno($verbindung) == '0') {
		$dummy++;
	}
	else {
		include 'inc/sqlerror.php'; $error++;
	}
	$sql = "ALTER TABLE `tvshow` MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;";
	$ergebnis = mysqli_query($verbindung, $sql);
	if (mysqli_errno($verbindung) == '0') {
		$dummy++;
	}
	else {
		include 'inc/sqlerror.php'; $error++;
	}
	$sql = "COMMIT;";
	$ergebnis = mysqli_query($verbindung, $sql);
	if (mysqli_errno($verbindung) == '0') {
		$dummy++;
	}
	else {
		include 'inc/sqlerror.php'; $error++;
	}

	$sql = "DROP TABLE IF EXISTS `season`;";
	$ergebnis = mysqli_query($verbindung, $sql);
	if (mysqli_errno($verbindung) == '0') {
		$dummy++;
	}
	else {
		include 'inc/sqlerror.php'; $error++;
	}
	$sql = "CREATE TABLE `season` (`ID` int(11) NOT NULL,`SEASON_NUMBER` int(11) NOT NULL,`TVSHOW_ID` int(11) NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
	$ergebnis = mysqli_query($verbindung, $sql);
	if (mysqli_errno($verbindung) == '0') {
		$dummy++;
	}
	else {
		include 'inc/sqlerror.php'; $error++;
	}
	$sql = "ALTER TABLE `season` ADD PRIMARY KEY (`ID`);";
	$ergebnis = mysqli_query($verbindung, $sql);
	if (mysqli_errno($verbindung) == '0') {
		$dummy++;
	}
	else {
		include 'inc/sqlerror.php'; $error++;
	}
	$sql = "ALTER TABLE `season` MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;";
	$ergebnis = mysqli_query($verbindung, $sql);
	if (mysqli_errno($verbindung) == '0') {
		$dummy++;
	}
	else {
		include 'inc/sqlerror.php'; $error++;
	}
	$sql = "COMMIT;";
	$ergebnis = mysqli_query($verbindung, $sql);
	if (mysqli_errno($verbindung) == '0') {
		$dummy++;
	}
	else {
		include 'inc/sqlerror.php'; $error++;
	}
	$sql = "DROP TABLE IF EXISTS `episode`;";
	$ergebnis = mysqli_query($verbindung, $sql);
	if (mysqli_errno($verbindung) == '0') {
		$dummy++;
	}
	else {
		include 'inc/sqlerror.php'; $error++;
	}
	$sql = "CREATE TABLE `episode` (`ID` int(11) NOT NULL,`EPISODE_NUMBER` int(11) NOT NULL,`TVSHOW_ID` int(11) NOT NULL,`SEASON_ID` int(11) NOT NULL,`INTRO_START` int(11) NOT NULL DEFAULT '0',`INTRO_LENGTH` int(11) NOT NULL DEFAULT '0',`OUTRO_START` int(11) NOT NULL DEFAULT '0') ENGINE=InnoDB DEFAULT CHARSET=utf8;";
	$ergebnis = mysqli_query($verbindung, $sql);
	if (mysqli_errno($verbindung) == '0') {
		$dummy++;
	}
	else {
		include 'inc/sqlerror.php'; $error++;
	}
	$sql = "ALTER TABLE `episode` ADD PRIMARY KEY (`ID`);";
	$ergebnis = mysqli_query($verbindung, $sql);
	if (mysqli_errno($verbindung) == '0') {
		$dummy++;
	}
	else {
		include 'inc/sqlerror.php'; $error++;
	}
	$sql = "ALTER TABLE `episode` MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;";
	$ergebnis = mysqli_query($verbindung, $sql);
	if (mysqli_errno($verbindung) == '0') {
		$dummy++;
	}
	else {
		include 'inc/sqlerror.php'; $error++;
	}
	$sql = "COMMIT;";
	$ergebnis = mysqli_query($verbindung, $sql);
	if (mysqli_errno($verbindung) == '0') {
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
	    echo '<p class="info">SQL-Commands: '.$dummy.'</p>';
	}
	if ($error > 0){
	    echo '<p class="warn">Errors: '.$error.'</p>';
	}
	echo '</div>';
	include 'back.php';
	include 'footer.php';
    }
}
?>
