<?php
$dummy = 0;
$error = 0;
if ((!isset($_GET['title']) or !isset($_GET['imdb']) or $_GET['title'] == "")) {
    include 'header.php';
    echo '<form action="insertshow.php" method="get">';
    echo '<div align="center">';
    echo '<p><h2>Insert TV Show Entry Inside SkipDB</h2></p>';
    echo '<div class="desc"><label>Titel</label></div><div><input type="text" name="title" /></div>';
    echo '<div class="desc"><label>IMDB Number</label></div><div><input type="text" name="imdb" /></div>';
    echo '<p><input type="submit" value="Insert Now!" class="riskybutton" /></p>';
    echo '</form>';
    echo '<table>';
    echo '<tr>';
    echo '<td>';
    echo '<form action="menu_insert.php">';
    echo '<button type="submit">Back</button>';
    echo '</form>';
    echo '</td>';
    echo '<td>';
    echo '<form action="index.php">';
    echo '<button type="submit">Home</button>';
    echo '</form>';
    echo '</td>';
    echo '</tr>';
    echo '</table>';
    echo '</div>';
    include 'footer.php';
    exit;
}
else {
    $get_title = $_GET['title'];
    $get_imdb = $_GET['imdb'];
    include 'inc/config.inc';

    $sql="SELECT TITLE FROM tvshow WHERE TITLE = '".mysql_real_escape_string($get_title)."' LIMIT 1;";
    $ergebnis = mysql_query($sql, $verbindung);
    $zeile = mysql_fetch_row($ergebnis);
    if (mysql_errno() == '0') {
	$dummy++;
    }
    else {
	include 'inc/sqlerror.php'; $error++;
    }
    if ($zeile[0] != "") {
	include 'header.php';
        echo '<div align="center">';
	echo '<p><h2>Insert TV Show Entry Inside SkipDB</h2></p>';
        echo '<h3><p class="warn">Show exists!</p></h3>';
        echo '<table>';
        echo '<tr>';
        echo '<td>';
	echo '<form action="menu_insert.php">';
	echo '<button type="submit">Back</button>';
	echo '</form>';
        echo '</td>';
        echo '<td>';
	echo '<form action="index.php">';
	echo '<button type="submit">Home</button>';
	echo '</form>';
        echo '</td>';
        echo '</tr>';
        echo '</table>';
        echo '</div>';
	include 'footer.php';
    }
    else {
	$dummy = 0;
	$sql = "INSERT INTO tvshow (ID, TITLE, IMDBNUMBER, KODI_ID) VALUES (NULL, '".mysql_real_escape_string($get_title)."', '".$get_imdb."', '0')";
	$ergebnis = mysql_query($sql, $verbindung);
	if (mysql_errno() == '0') {
    	    $dummy++;
	}
	else {
    	    include 'inc/sqlerror.php'; $error++;
	}
	include 'header.php';
	echo '<div align="center">';
	echo '<p><h2>Insert TV Show Entry Inside SkipDB</h2></p>';
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
