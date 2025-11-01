<?php
$host = "localhost";
$user = "root";   // default in XAMPP
$pass = "";       // leave empty if you didn't set a password
$dbname = "jobmatch_db";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>