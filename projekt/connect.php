<?php
$servername = "localhost";
$username = "root";
$password = "";
$basename = "sworn_to_death";

$dbc = mysqli_connect($servername, $username, $password, $basename) 
    or die('Error connecting to MySQL server: ' . mysqli_connect_error());

mysqli_set_charset($dbc, "utf8");

define('UPLPATH', 'img/');

session_start();
?>