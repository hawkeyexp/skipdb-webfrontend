<?php
$dummy = 0;
$error = 0;
if (isset($_GET['title']) and isset($_GET['season'])) {
    $get_title = $_GET['title'];
    $get_season = $_GET['season'];
    include 'inc/config.inc';

    $sqlcheck="SELECT * FROM `seasons` WHERE `TITLE` = '".mysql_real_escape_string($get_title)."' AND `SEASON` = '".$get_season."'";
    $ergebnischeck = mysql_query($sqlcheck, $verbindung);
    $zeilecheck = mysql_fetch_array($ergebnischeck);
    if (mysql_errno() == '0') {
        $dummy++;
    }
    else {
        include 'inc/sqlerror.php'; $error++;
    }
    if ($zeilecheck[0] != "") {

	include 'header.php';
	echo '<div align="center">';
	echo '<p><H2>Insert New Season To TV Show Inside SkipDB</h2></p>';
	echo '<p><H3><div class="warn">Season exists!</div><H3></p>';
	echo '</div>';
	include 'back.php';
	include 'footer.php';
    }
    else {
	$sql = "INSERT INTO `seasons` (`ID`, `TITLE`, `SEASON`) VALUES (NULL, '".mysql_real_escape_string($get_title)."', '".$get_season."')";
	$ergebnis = mysql_query($sql, $verbindung);
	if (mysql_errno() == '0') {
	    $dummy++;
	}
        else {
	    include 'inc/sqlerror.php'; $error++;
	}

	include 'header.php';
	echo '<div align="center">';
	echo '<p><H2>Insert New Season To TV Show Inside SkipDB</h2></p>';
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

}

if (!isset($_GET['title']) and !isset($_GET['season'])) {
    $selecttitle = "";
    include 'inc/config.inc';
    $sql="SELECT `TITLE` FROM `tvshows` GROUP BY `TITLE` ORDER BY `TITLE` ASC";
    $ergebnis = mysql_query($sql, $verbindung);
    while($zeile = mysql_fetch_array($ergebnis)){
        $selecttitle = $selecttitle."<option>".$zeile[0]."</option>";
    }
    if (mysql_errno() == '0') {
        $dummy++;
    }
    else {
        include 'inc/sqlerror.php'; $error++;
    }
    include 'header.php';
    echo '<form action="insertshowseason.php" method="get">';
    echo '<div align="center">';
    echo '<p><H2>Insert New Season To TV Show Inside SkipDB</h2></p>';
    echo '<div class="desc"><label>Titel</label></div><div>';
    echo '<select name="title">';
    echo $selecttitle;
    echo '</select>';
    echo '</div>';
    echo '<p><input type="submit" value="Continue" class="conbutton"/></p>';
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
if (isset($_GET['title']) and !isset($_GET['season'])) {
    $selecttitle = "<option>".$_GET['title']."</option>";
    include 'header.php';
    echo '<form action="insertshowseason.php" method="get">';
    echo '<div align="center">';
    echo '<p><H2>Insert New Season To TV Show Inside SkipDB</h2></p>';
    echo '<div class="desc"><label>Titel</label></div><div>';
    echo '<select name="title">';
    echo $selecttitle;
    echo '</select>';
    echo '</div>';
    echo '<div class="desc"><label>Season</label></div><div><input type="text" name="season" /></div>';
    echo '<p><input type="submit" value="Insert Now!" class="riskybutton" /></p>';
    echo '</form>';
    echo '</div>';
    include 'back.php';
    include 'footer.php';
    exit;
}
?>
