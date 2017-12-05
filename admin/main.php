<?php
$dummy = 0;
$error = 0;
if (!isset($_GET['title']) or !isset($_GET['season']) or !isset($_GET['episode'])) {
    include 'inc/config.inc';
    $result=mysql_query("SELECT count(DISTINCT TITLE) as total from intro");
    $data=mysql_fetch_assoc($result);
    $totaltvshows = $data['total'];
    $result=mysql_query("SELECT count(DISTINCT TITLE,SEASON) as total from intro where START !=0 AND LENGHT != 0");
    $data=mysql_fetch_assoc($result);
    $totalseasons = $data['total'];
    $result=mysql_query("SELECT count(DISTINCT TITLE,EPISODE) as total from intro where START !=0 AND LENGHT != 0");
    $data=mysql_fetch_assoc($result);
    $totalepisodes = $data['total'];
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
    echo '<a class="navbar-brand" href="#">Skip Intro</a>';
    echo '</div>';
    echo '<ul class="nav navbar-nav">';
    echo '<li class="dropdown">';
    echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown">Add/Update <span class="caret"></span></a>';
    echo '<ul class="dropdown-menu">';
    echo '<li><a href="insertshow.php">Add TV Show</a></li>';
    echo '<li><a href="insertshowseason.php">Add Season</a></li>';
    echo '<li><a href="insertepisode.php">Add Episode</a></li>';
    echo '<li><a href="insertseason.php">Add Multiple Episodes</a></li>';
    echo '<li><a href="update.php">Update Episode</a></li>';
    echo '</ul>';
    echo '</li>';
    echo '<li class="dropdown">';
    echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown">Delete <span class="caret"></span></a>';
    echo '<ul class="dropdown-menu">';
    echo '<li><a href="deleteshow.php">Delete TV Show</a></li>';
    echo '<li><a href="deleteseason.php">Delete Season</a></li>';
    echo '<li><a href="delete.php">Delete Episode</a></li>';
    echo '</ul>';
    echo '</li>';
    echo '</ul>';
    echo '<ul class="nav navbar-nav navbar-right">';
    echo '<li class="dropdown">';
    echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown"<span class="glyphicon glyphicon-cog"></span> Setup <span class="caret"></span></a>';
    echo '<ul class="dropdown-menu">';
    echo '<li><a href="setup.php">Create Tables</a></li>';
    echo '<li><a href="check.php">Check SQL-Connection and Tables</a></li>';
    echo '</ul>';
    echo '</li>';
    echo '</ul>';
    echo '</div>';
    echo '</nav>';
    echo '<div class="container">
            <div class="row">
                <div class="col-sm-4">
                    <div class="intro-widget well well-sm">
                        <div class="icon">
                             <i class="glyphicon glyphicon-picture"></i>
                        </div>
                        <div class="text">
                            <var>'.$totaltvshows.'</var>
                            <label class="text-muted">TV Shows</label>
                        </div>
                        <div class="options">
                            <a href="tvshowlisting.php" class="btn btn-default btn-lg"><i class="glyphicon glyphicon-search"></i> View</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="intro-widget well well-sm">
                        <div class="icon">
                             <i class="glyphicon glyphicon-facetime-video"></i>
                        </div>
                        <div class="text">
                            <var>'.$totalseasons.'</var>
                            <label class="text-muted">Seasons</label>
                        </div>
                        <div class="options">
                            <a href="tvshowlisting.php" class="btn btn-default btn-lg"><i class="glyphicon glyphicon-search"></i> View</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="intro-widget well well-sm">
                        <div class="icon">
                             <i class="glyphicon glyphicon-film"></i>
                        </div>
                        <div class="text">
                            <var>'.$totalepisodes.'</var>
                            <label class="text-muted">Episodes</label>
                        </div>
                        <div class="options">
                            <a href="tvshowlisting.php" class="btn btn-default btn-lg"><i class="glyphicon glyphicon-search"></i> View</a>
                        </div>
                    </div>
                </div>
            </div>
          </div>';
    echo '</body>';
    echo '</html>';
    exit;
}
else {
    include 'inc/config.inc';
    $sql="SELECT * FROM `intro` WHERE 1 AND `TITLE` = '".$_GET['title']."' AND `SEASON` = '".$_GET['season']."' AND `EPISODE` = '".$_GET['episode']."' LIMIT 1";
    $ergebnis = mysql_query($sql, $verbindung);
    $zeile = mysql_fetch_array($ergebnis);
    if (mysql_errno() == '0') {
	$dummy++;
    }
    else {
	include 'inc/sqlerror.php'; $error++;
    }
    $id = $zeile[0];
    $title = $zeile[1];
    $season = $zeile[2];
    $episode = $zeile[3];
    $start = $zeile[4];
    $lenght = $zeile[5];
    $arr = array('title' => $title,'season' => $season,'episode' => $episode,'start' => $start, 'lenght' => $lenght);
    echo json_encode($arr);
}
?>