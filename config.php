<?php
$host = "localhost";
$user = "root";
$pass = ""; 
$dbname = "movie_booking";

$con = mysqli_connect($host, $user, $pass, $dbname);

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
mysqli_set_charset($con, "utf8mb4");
?>