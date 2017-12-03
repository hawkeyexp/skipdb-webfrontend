<?php
$dummy = 0;
$error = 0;
if (!isset($_GET['title'])) {
    echo '<html>';
    echo '<head>';
    echo '<link rel="stylesheet" type="text/css" href="style.css">';
    echo '</head>';
    echo '<body>';
    echo '<form action="insertshow.php" method="get">';
    echo '<div align="center">';
    echo '<p><h2>Insert New Show Inside SkipDB</h2></p>';
    echo '<div class="desc"><label>Titel</label></div><div><input type="text" name="title" /></div>';
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
else {
    $get_title = $_GET['title'];
    include 'inc/config.inc';
    $dummy = 0;
    $sql = "INSERT INTO `intro` (`ID`, `TITLE`, `SEASON`, `EPISODE`, `START`, `LENGHT`) VALUES (NULL, '".$get_title."', '0', '0', '', '')";
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
    echo '<p><h2>Insert New Show Inside SkipDB</h2></p>';
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
?>