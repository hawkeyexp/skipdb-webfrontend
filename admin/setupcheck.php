<?php
echo '<html>';
echo '<head>';
echo '<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>';
echo '<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">';
echo '</head>';
echo '<body>';
echo '<nav class="navbar navbar-inverse">';
echo '<div class="container-fluid">';
echo '<div class="navbar-header">';
echo '<a class="navbar-brand" href="main.php">Skip Intro</a>';
echo '</div>';
echo '</div>';
echo '</nav>';
echo '<div class="panel panel-default">';
echo '<div class="panel-body">';
echo '<div align="center">';
echo '<p><H2>Welcome to SkipDB Interface</h2></p>';
echo '<form action="setup.php">';
echo '<div><button type="submit">Create Tables In Database</button></div>';
echo '</form>';
echo '<form action="check.php">';
echo '<div><button type="submit">Check SQL-Connection and Tables</button></div>';
echo '</form>';
echo '<form action="main.php">';
echo '<div><button type="submit">Back</button></div>';
echo '</form>';
echo '</div>';
echo '</div>';
echo '</div>';
echo '</body>';
echo '</html>';
?>
