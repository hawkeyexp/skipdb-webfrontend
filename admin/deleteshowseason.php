<?php
$dummy = 0;
$error = 0;
if ((isset($_GET['title'])) and (isset($_GET['season'])) and (isset($_GET['tvshowid']))){
    include 'inc/config.inc';
    $sql = "DELETE FROM season WHERE TVSHOW_ID = '".$_GET['tvshowid']."' AND SEASON_NUMBER = '".$_GET['season']."';";
    $ergebnis = mysqli_query($verbindung, $sql);
    if (mysqli_errno($verbindung) == '0') {
    	$dummy++;
    }
    else {
    	include 'inc/sqlerror.php'; $error++;
    }
    include 'header.php';
    echo '<div align="center">';
    echo '<p><H2>Delete Season From TV Show Inside SkipDB</h2></p>';
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
if ((!isset($_GET['title'])) or (!isset($_GET['season']))){
    if (!isset($_GET['title'])){
	$selecttitle = "";
	include 'inc/config.inc';
	$sql="SELECT TITLE FROM tvshow GROUP BY TITLE ORDER BY TITLE ASC;";
        $ergebnis = mysqli_query($verbindung, $sql);
        while($zeile = mysqli_fetch_array($ergebnis, MYSQLI_BOTH)){
	    $selecttitle = $selecttitle."<option>".$zeile[0]."</option>";
        }
	if (mysqli_errno($verbindung) == '0') {
	    $dummy++;
        }
	else {
	    include 'inc/sqlerror.php'; $error++;
        }
    }
    else {
	$selecttitle = "<option>".$_GET['title']."</option>";
    }
    include 'header.php';
    echo '<div align="center">';
    echo '<p><H2>Delete Season From TV Show Inside SkipDB</h2></p>';
    echo '<form action="deleteshowseason.php" method="get">';
    echo '<div class="desc">Title</div>';
    echo '<select name="title">';
    echo $selecttitle;
    echo '</select>';
    if ((isset($_GET['title'])) and (!isset($_GET['season']))){
	$selectseason = "";
	include 'inc/config.inc';

	// get tvshowid by title
	$sql="SELECT ID FROM tvshow WHERE TITLE = '".mysqli_real_escape_string($verbindung, $_GET['title'])."';";
        $ergebnis = mysqli_query($verbindung, $sql);
        $tvshowid = mysqli_fetch_row($ergebnis)[0];
	if (mysqli_errno($verbindung) == '0') {
	    $dummy++;
        }
	else {
	    include 'inc/sqlerror.php'; $error++;
        }

        $sql="SELECT ID, SEASON_NUMBER FROM season WHERE TVSHOW_ID = '".$tvshowid."' GROUP BY SEASON_NUMBER ORDER BY SEASON_NUMBER ASC";
        $ergebnis = mysqli_query($verbindung, $sql);
        while($zeile = mysqli_fetch_array($ergebnis, MYSQLI_BOTH)){
	    // check if season has episodes - if yes ignore in listing
	    $sqlcheck="SELECT SEASON_ID FROM episode WHERE TVSHOW_ID = '".$tvshowid."' AND SEASON_ID = '".$zeile[0]."' LIMIT 1;";
	    $ergebnischeck = mysqli_query($verbindung, $sqlcheck);
	    $check = mysqli_fetch_row($ergebnischeck)[0];
	    if (mysqli_errno($verbindung) == '0') {
		$dummy++;
    	    }
	    else {
		include 'inc/sqlerror.php'; $error++;
    	    }
	    if ($check != $zeile[0]) {
		$selectseason = $selectseason."<option>".$zeile[1]."</option>";
	    }
        }
	if (mysqli_errno($verbindung) == '0') {
	    $dummy++;
        }
	else {
	    include 'inc/sqlerror.php'; $error++;
        }
	echo '<div class="desc">Season</div>';
	echo '<select name="season">';
        echo $selectseason;
	echo '</select>';
	echo '<input type="hidden" name="tvshowid" value="'.$tvshowid.'" />';
	echo '<p><div class="info">Only seasons without episodes will be selectable!</div></p>';
        echo '<p><input type="submit" value="Delete Now!" class="riskybutton" /></p>';
        echo '</form>';
        echo '</div>';
	include 'back.php';
	include 'footer.php';
        exit;
    }
    else {
	if (isset($_GET['season'])) {
	    $selectseason = "<option>".$_GET['season']."</option>";
	    echo '<div class="desc">Season:</div>';
	    echo '<select name="season">';
	    echo $selectseason;
	    echo '</select>';
	}
    }
    echo '<p><input type="submit" value="Continue" class="conbutton" /></p>';
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
