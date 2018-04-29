<?php
$dummy = 0;
$error = 0;
if (isset($_GET['title'])){
    include 'inc/config.inc';
    $sql = "DELETE FROM tvshow WHERE TITLE = '".mysqli_real_escape_string($verbindung, $_GET['title'])."';";
    $ergebnis = mysqli_query($verbindung, $sql);
    if (mysqli_errno($verbindung) == '0') {
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
    $ergebnis = mysqli_query($verbindung, $sql);
    while($zeile = mysqli_fetch_array($ergebnis, MYSQLI_BOTH)){
	$sqlid="SELECT ID FROM tvshow WHERE TITLE = '".mysqli_real_escape_string($verbindung, $zeile[0])."' LIMIT 1;";
	$ergebnisid = mysqli_query($verbindung, $sqlid);
	$tvshowid = mysqli_fetch_row($ergebnisid)[0];
	if (mysqli_errno($verbindung) == '0') {
    	    $dummy++;
	}
	else {
    	    include 'inc/sqlerror.php'; $error++;
	}

	// check if show  has seasons - if yes ignore in listing
	$sqlcheck="SELECT TVSHOW_ID FROM season WHERE TVSHOW_ID = '".$tvshowid."' LIMIT 1;";
	$ergebnischeck = mysqli_query($verbindung, $sqlcheck);
	if (mysqli_errno($verbindung) == '0') {
    	    $dummy++;
	}
	else {
    	    include 'inc/sqlerror.php'; $error++;
	}
	$check = mysqli_fetch_row($ergebnischeck)[0];
	if ($check != $tvshowid) {
	    $selecttitle = $selecttitle."<option>".$zeile[0]."</option>";
	}
    }
    if (mysqli_errno($verbindung) == '0') {
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
    echo '<p><div class="info">Only tvshows without seasons / episodes will be selectable</div></p>';
    echo '<p><input type="submit" value="Delete Now!" class="riskybutton" /></p>';
    echo '</form>';
    echo '<table>';
    echo '<tr>';
    echo '<td>';
    echo '<form action="menu_delete.php">';
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
    echo '</div>';
    include 'footer.php';
}
?>
