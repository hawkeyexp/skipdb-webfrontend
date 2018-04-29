<?php
$server="xxx.xxx.xxx.xxx"; // mysql server
$datenbank="skipdb"; // database name
$user="skipdb"; // user for database
$passwort="pass"; // password for database

$verbindung = mysqli_connect($server, $user, $passwort, $datenbank) or die ( "<H3>Database server not reachable</H3>");
mysqli_query($verbindung, "SET NAMES UTF8");
?>