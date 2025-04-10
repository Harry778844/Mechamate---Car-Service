<?php
$host = "localhost:3306";
$dbUser = "root";
$dbPass = "";
$dbName = "mechmate";

$conn = new mysqli($host, $dbUser, $dbPass, $dbName);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>