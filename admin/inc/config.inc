<?php
$server="xxx.xxx.xxx.xxx"; // mysql server
$datenbank="skipdb"; // database name
$user="skipdb"; // user for database
$passwort="pass"; // password for database

$verbindung = MYSQL_CONNECT($server, $user, $passwort) or die ( "<H3>Database server not reachable</H3>");
MYSQL_SELECT_DB($datenbank, $verbindung) or die( "<H3>Database not available</H3>" );
mysql_query("SET NAMES UTF8");
?>