<?php
$host = "127.0.0.1";
$user = "root";
$pass = "";
$db = "car_rental";
$port = 3307; // MCP config

$conn = new mysqli($host, $user, $pass, $db, $port);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?> 