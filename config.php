<?php

$mysql_hostname = "localhost";
$mysql_user = "clientsc_cmguser";
$mysql_password = "89I5M-817&P*I5g";
$mysql_database = "clientsc_timemgn";

$servername = $mysql_hostname;
$username = $mysql_user;
$password = $mysql_password;
$dbname = $mysql_database;

$prefix = "";
$db = mysqli_connect($mysql_hostname, $mysql_user, $mysql_password,$mysql_database) or die("Could not connect database");

date_default_timezone_set('ASIA/DUBAI'); // CDT

$siteBaseURL = "http://clients.createmedia-group.com/cmg/time-sheet";
//$siteBaseURL = "http://localhost/cmg-timesheet";



?>