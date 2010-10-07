<?php

$hostname = "localhost";
$database = "box";
$username = "root";
$password = "";

$error_no_database= "Could Not Find Database";
$error_no_connect = "Could Not Connect To Database";
$error_bad_query = "Incorrect SQL Query";
$error_no_data = "Could Not Get Data From Query";

if (!$con = mysql_connect($hostname,$username,$password)) {
	die($error_no_connect);
	//die(mysql_error());
}


if (!mysql_select_db($database, $con)) {
	die($error_no_database);
	//die(mysql_error());
}









?>