<?php
$servername = "localhost";
$username = "root";  // Change if different
$password = "";  // Change if you have a password
$dbname = "license_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
