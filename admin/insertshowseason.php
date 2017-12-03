<?php
$dummy = 0;
$error = 0;
if (isset($_GET['title']) and isset($_GET['season'])) {
    $get_title = $_GET['title'];
    $get_season = $_GET['season'];
    include 'inc/config.inc';
    $sql = "INSERT INTO `intro` (`ID`, `TITLE`, `SEASON`, `EPISODE`, `START`, `LENGHT`) VALUES (NULL, '".$get_title."', '".$get_season."', '0', '0', '0')";
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
    echo '<p><H2>Insert New Season To TV Show Inside SkipDB</h2></p>';
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
    exit;
}

if (!isset($_GET['title']) and !isset($_GET['season'])) {
    $selecttitle = "";
    include 'inc/config.inc';
    $sql="SELECT `TITLE` FROM `intro` GROUP BY `TITLE` ORDER BY `TITLE` ASC";
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
    echo '<html>';
    echo '<head>';
    echo '<link rel="stylesheet" type="text/css" href="style.css">';
    echo '</head>';
    echo '<body>';
    echo '<form action="insertshowseason.php" method="get">';
    echo '<div align="center">';
    echo '<p><H2>Insert New Season To TV Show Inside SkipDB</h2></p>';
    echo '<div class="desc"><label>Titel</label></div><div>';
    echo '<select name="title">';
    echo $selecttitle;
    echo '</select>';
    echo '</div>';
    echo '<p><input type="submit" value="Continue" /></p>';
    echo '</form>';
    echo '</div>';
    echo '<div align="center">';
    echo '<form action="main.php">';
    echo '<button type="submit">Back</button>';
    echo '</form>';
    echo '</div>';
    echo '</body>';
    echo '</html>';
    exit;
}
if (isset($_GET['title']) and !isset($_GET['season'])) {
    $selecttitle = "<option>".$_GET['title']."</option>";
    echo '<html>';
    echo '<head>';
    echo '<link rel="stylesheet" type="text/css" href="style.css">';
    echo '</head>';
    echo '<body>';
    echo '<form action="insertshowseason.php" method="get">';
    echo '<div align="center">';
    echo '<p><H2>Insert New Season To TV Show Inside SkipDB</h2></p>';
    echo '<div class="desc"><label>Titel</label></div><div>';
    echo '<select name="title">';
    echo $selecttitle;
    echo '</select>';
    echo '</div>';
    echo '<div class="desc"><label>Season</label></div><div><input type="text" name="season" /></div>';
    echo '<p><input type="submit" value="Insert Now!" style="background-color: lightgreen;" /></p>';
    echo '</form>';
    echo '</div>';
    echo '<div align="center">';
    echo '<form action="main.php">';
    echo '<button type="submit">Back</button>';
    echo '</form>';
    echo '</div>';
    echo '</body>';
    echo '</html>';
    exit;
}
?>
