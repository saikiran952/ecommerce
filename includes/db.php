<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "ecommerce"; // replace with your DB name

$conn = new mysqli($host, $user, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
