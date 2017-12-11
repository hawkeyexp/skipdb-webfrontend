<?php
$dummy = 0;
$error = 0;
if (isset($_GET['title'])){
    include 'inc/config.inc';
    $sql = "DELETE FROM tvshow WHERE TITLE = '".mysql_real_escape_string($_GET['title'])."';";
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
	echo '<p class="info">SQL-Commands: '.$dummy.'</p>';
    }
    if ($error > 0){
	echo '<p class="warn">Errors: '.$error.'</p>';
    }
    echo '</div>';
    include 'back.php';
    include 'footer.php';
    exit;
}
else {
    $selecttitle = "";
    include 'inc/config.inc';
    $sql="SELECT TITLE FROM tvshow GROUP BY `TITLE` ORDER BY `TITLE` ASC;";
    $ergebnis = mysql_query($sql, $verbindung);
    while($zeile = mysql_fetch_array($ergebnis)){
	$sqlid="SELECT ID FROM tvshow WHERE TITLE = '".mysql_real_escape_string($zeile[0])."' LIMIT 1;";
	$ergebnisid = mysql_query($sqlid, $verbindung);
	$tvshowid = mysql_fetch_row($ergebnisid)[0];
	if (mysql_errno() == '0') {
    	    $dummy++;
	}
	else {
    	    include 'inc/sqlerror.php'; $error++;
	}

	// check if show  has seasons - if yes ignore in listing
	$sqlcheck="SELECT TVSHOW_ID FROM season WHERE TVSHOW_ID = '".$tvshowid."' LIMIT 1;";
	$ergebnischeck = mysql_query($sqlcheck, $verbindung);
	if (mysql_errno() == '0') {
    	    $dummy++;
	}
	else {
    	    include 'inc/sqlerror.php'; $error++;
	}
	$check = mysql_fetch_row($ergebnischeck)[0];
	if ($check != $tvshowid) {
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
