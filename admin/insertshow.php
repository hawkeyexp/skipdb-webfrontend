<?php
$dummy = 0;
$error = 0;
if (!isset($_GET['title']) or !isset($_GET['imdb'])) {
    include 'header.php';
    echo '<form action="insertshow.php" method="get">';
    echo '<div align="center">';
    echo '<p><h2>Insert New Show Inside SkipDB</h2></p>';
    echo '<div class="desc"><label>Titel</label></div><div><input type="text" name="title" /></div>';
    echo '<div class="desc"><label>IMDB Number</label></div><div><input type="text" name="imdb" /></div>';
    echo '<p><input type="submit" value="Insert Now!" class="riskybutton" /></p>';
    echo '</form>';
    echo '</div>';
    echo '<div align="center">';
    echo '<form action="index.php">';
    echo '<button type="submit">Home</button>';
    echo '</form>';
    echo '</div>';
    include 'footer.php';
    exit;
}
else {
    $get_title = $_GET['title'];
    $get_imdb = $_GET['imdb'];
    include 'inc/config.inc';

    $sql="SELECT * FROM `tvshows` WHERE 1 AND `TITLE` = '".mysql_real_escape_string($get_title)."'";
    $ergebnis = mysql_query($sql, $verbindung);
    $zeile = mysql_fetch_array($ergebnis);
    if (mysql_errno() == '0') {
	$dummy++;
    }
    else {
	include 'inc/sqlerror.php'; $error++;
    }
    if ($zeile[0] != "") {
	include 'header.php';
        echo '<div align="center">';
        echo '<p><h2>Insert New Show Inside SkipDB</h2></p>';
        echo '<p><h3><div class="warn">Show exists!</div></h3></p>';
        echo '</div>';
	include 'back.php';
	include 'footer.php';
    }
    else {
	$dummy = 0;
	$sql = "INSERT INTO `tvshows` (`ID`, `TITLE`, `IMDBNUMBER`, `TVSHOWID`) VALUES (NULL, '".mysql_real_escape_string($get_title)."', '".$get_imdb."', '0')";
	$ergebnis = mysql_query($sql, $verbindung);
	if (mysql_errno() == '0') {
    	    $dummy++;
	}
	else {
    	    include 'inc/sqlerror.php'; $error++;
	}
	include 'header.php';
	echo '<div align="center">';
        echo '<p><h2>Insert New Show Inside SkipDB</h2></p>';
	echo '<p><div class="desc">Done...</div></p>';
	if ($dummy > 0){
	    echo '<p><font color="lightgreen">SQL-Commands: '.$dummy.'</font></p>';
	}
	else {
	    echo '<p>SQL-Commands: '.$dummy.'</p>';
	}
	if ($error > 0){
	    echo '<p><div class="del">Errors: '.$error.'</div></p>';
	}
	else {
	    echo '<p>Errors: '.$error.'</p>';
	}
	echo '</div>';
	include 'back.php';
	include 'footer.php';
    }
}
?>
