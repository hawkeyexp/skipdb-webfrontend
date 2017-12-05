<?php
echo '<html>';
echo '<head>';
echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>';
echo '<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>';
echo '<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">';
echo '<link rel="stylesheet" type="text/css" href="styles.css">';
echo '</head>';
echo '<body>';
echo '<nav class="navbar navbar-inverse">';
echo '<div class="container-fluid">';
echo '<div class="navbar-header">';
echo '<a class="navbar-brand" href="main.php">Skip Intro</a>';
echo '</div>';
echo '</div>';
echo '</nav>';
echo '<div class="container">
          <h2>TV Shows</h2>
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Title</th>
                <th>Season</th>
                <th>Episode</th>
              </tr>
            </thead>
            <tbody>';
$dummy = "";
$selecttitle = "";
include 'inc/config.inc';
$sql="SELECT `TITLE` FROM `intro` GROUP BY `TITLE` ORDER BY `TITLE` ASC";
$ergebnis = mysql_query($sql, $verbindung);
while($zeile = mysql_fetch_array($ergebnis)){
    // get seasons
    $sqls="SELECT `SEASON` FROM `intro` WHERE `TITLE` = '".$zeile[0]."' AND `SEASON` != '0' AND `EPISODE` != '0' GROUP BY `SEASON` ORDER BY `SEASON` ASC";
    $ergebniss = mysql_query($sqls, $verbindung);
    $seasons = "";
    while($zeiles = mysql_fetch_array($ergebniss)){
        // get episodes
        $sqle="SELECT `EPISODE` FROM `intro` WHERE `TITLE` = '".$zeile[0]."'AND `SEASON` = '".$zeiles[0]."' AND `EPISODE`!= '0' GROUP BY `EPISODE` ORDER BY `EPISODE` ASC";
        $ergebnise = mysql_query($sqle, $verbindung);
        $episodes = '';
        while($zeilee = mysql_fetch_array($ergebnise)){
	    if ($zeilee[0] != "1") {
		$episodes = $episodes.' | '.$zeilee[0];
	    }
	    else {
		$episodes = $episodes.' '.$zeilee[0];
	    }
        }
        echo '<tr>
                <td>'.$zeile[0].'</td>
                <td>'.$zeiles[0].'</td>
                <td>'.$episodes.'</td>
              </tr>';
    }
}
echo '</tbody></table></div>';
if (mysql_errno() == '0') {
    $dummy++;
    }
else {
    include 'inc/sqlerror.php'; $error++;
}

echo '</body>';
echo '</html>';
?>
