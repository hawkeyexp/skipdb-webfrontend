<?php
$dummy = 0;
$error = 0;
if ((isset($_GET['title'])) and (isset($_GET['season'])) and (isset($_GET['episode']))){
    include 'inc/config.inc';

    // get tvshowid by title
    $sql="SELECT ID FROM tvshow WHERE TITLE = '".mysqli_real_escape_string($verbindung, $_GET['title'])."' LIMIT 1;";
    $ergebnis = mysqli_query($verbindung, $sql);
    $zeile = mysqli_fetch_row($ergebnis);
    if (mysqli_errno($verbindung) == '0') {
        $dummy++;
    }
    else {
        include 'inc/sqlerror.php'; $error++;
    }
    $tvshowid = $zeile[0];

    // get seasonid by tvshowid and season
    $sql="SELECT ID FROM season WHERE TVSHOW_ID = '".$tvshowid."' AND SEASON_NUMBER = '".$_GET['season']."' LIMIT 1;";
    $ergebnis = mysqli_query($verbindung, $sql);
    $zeile = mysqli_fetch_row($ergebnis);
    if (mysqli_errno($verbindung) == '0') {
        $dummy++;
    }
    else {
        include 'inc/sqlerror.php'; $error++;
    }
    $seasonid = $zeile[0];

    $sql = "DELETE FROM episode WHERE TVSHOW_ID = '".$tvshowid."' AND SEASON_ID = '".$seasonid."' AND EPISODE_NUMBER = '".$_GET['episode']."';";
    $ergebnis = mysqli_query($verbindung, $sql);
    if (mysqli_errno($verbindung) == '0') {
    	$dummy++;
    }
    else {
    	include 'inc/sqlerror.php'; $error++;
    }
    include 'header.php';
    echo '<div align="center">';
    echo '<p><H2>Delete Single Episode Inside SkipDB</h2></p>';
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
if ((!isset($_GET['title'])) or (!isset($_GET['season'])) or (!isset($_GET['episode']))){
    if (!isset($_GET['title'])){
	$selecttitle = "";
	include 'inc/config.inc';
	$sql="SELECT TITLE FROM tvshow GROUP BY TITLE ORDER BY TITLE ASC";
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
	include 'header.php';
	echo '<div align="center">';
	echo '<p><H2>Delete Single Episode Inside SkipDB</h2></p>';
	echo '<form action="deleteepisode.php" method="get">';
	echo '<div class="desc">Title</div>';
	echo '<select name="title">';
	echo $selecttitle;
	echo '</select>';
	echo '<p><input type="submit" value="Continue" class="conbutton"></p>';
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
	exit;
    }
    else {
	$selecttitle = "<option>".$_GET['title']."</option>";
    }

    if ((isset($_GET['title'])) and (!isset($_GET['season'])) and (!isset($_GET['episode']))){
	$selectseason = "";
	include 'inc/config.inc';
	$sql="SELECT season.SEASON_NUMBER FROM season INNER JOIN tvshow ON season.TVSHOW_ID=tvshow.ID WHERE tvshow.TITLE = '".mysqli_real_escape_string($verbindung, $_GET['title'])."' GROUP BY SEASON_NUMBER ORDER BY SEASON_NUMBER ASC;";
        $ergebnis = mysqli_query($verbindung, $sql);
        while($zeile = mysqli_fetch_array($ergebnis, MYSQLI_BOTH)){
	    $selectseason = $selectseason."<option>".$zeile[0]."</option>";
        }
	if (mysqli_errno($verbindung) == '0') {
	    $dummy++;
        }
	else {
	    include 'inc/sqlerror.php'; $error++;
        }
	include 'header.php';
	echo '<div align="center">';
	echo '<p><H2>Delete Single Episode Inside SkipDB</h2></p>';
	echo '<form action="deleteepisode.php" method="get">';
	echo '<div class="desc">Title</div>';
	echo '<select name="title">';
	echo $selecttitle;
	echo '</select>';
	echo '<div class="desc">Season</div>';
	echo '<select name="season">';
        echo $selectseason;
	echo '</select>';
	echo '<p><input type="submit" value="Continue" class="conbutton"></p>';
	echo '</form>';
	echo '</div>';
	include 'back.php';
	include 'footer.php';
	exit;
    }
    else {
	if (isset($_GET['season'])) {
	    $selectseason = "<option>".$_GET['season']."</option>";
	}
    }
    if ((isset($_GET['title'])) and (isset($_GET['season'])) and (!isset($_GET['episode']))){
	$selectepisode = "";
	include 'inc/config.inc';

        // get tvshowid by title
        $sql="SELECT ID FROM tvshow WHERE TITLE = '".mysqli_real_escape_string($verbindung, $_GET['title'])."' LIMIT 1;";
        $ergebnis = mysqli_query($verbindung, $sql);
        $zeile = mysqli_fetch_row($ergebnis);
        if (mysqli_errno($verbindung) == '0') {
            $dummy++;
        }
        else {
            include 'inc/sqlerror.php'; $error++;
        }
        $tvshowid = $zeile[0];

        // get seasonid by tvshowid and season
        $sql="SELECT ID FROM season WHERE TVSHOW_ID = '".$tvshowid."' AND SEASON_NUMBER = '".$_GET['season']."' LIMIT 1;";
        $ergebnis = mysqli_query($verbindung, $sql);
        $zeile = mysqli_fetch_row($ergebnis);
        if (mysqli_errno($verbindung) == '0') {
            $dummy++;
        }
        else {
            include 'inc/sqlerror.php'; $error++;
        }
        $seasonid = $zeile[0];

        // get episodes by tvshowid and season
	$sql="SELECT EPISODE_NUMBER FROM episode WHERE TVSHOW_ID = '".$tvshowid."' AND SEASON_ID = '".$seasonid."' GROUP BY EPISODE_NUMBER ORDER BY EPISODE_NUMBER ASC;";
        $ergebnis = mysqli_query($verbindung, $sql);
        while($zeile = mysqli_fetch_array($ergebnis, MYSQLI_BOTH)){
	    $selectepisode = $selectepisode."<option>".$zeile[0]."</option>";
        }
	if (mysqli_errno($verbindung) == '0') {
	    $dummy++;
        }
	else {
	    include 'inc/sqlerror.php'; $error++;
        }
	include 'header.php';
	echo '<div align="center">';
	echo '<p><H2>Delete Single Episode Inside SkipDB</h2></p>';
	echo '<form action="deleteepisode.php" method="get">';
	echo '<div class="desc">Title</div>';
	echo '<select name="title">';
	echo $selecttitle;
	echo '</select>';
	echo '<div class="desc">Season</div>';
	echo '<select name="season">';
        echo $selectseason;
	echo '</select>';
	echo '<div class="desc">Episode</div>';
	echo '<select name="episode">';
        echo $selectepisode;
	echo '</select>';
	echo '<p><input type="submit" value="Delete Now!" class="riskybutton"></p>';
	echo '</form>';
	echo '</div>';
	include 'back.php';
	include 'footer.php';
	exit;
    }
}
?>
