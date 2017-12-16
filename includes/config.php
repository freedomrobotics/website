<?php
$dbhost="localhost";
$dbuser="root";
$dbpass="password";
$dbname="robotics";

$mysqli = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

if (mysqli_connect_errno()) {
  die("Failed to connect to database: " . mysqli_connect_error());
}

?>
