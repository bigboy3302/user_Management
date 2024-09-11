<?php
$host = 'localhost';  // Your MySQL host
$db = 'user_management';  // Database name
$user = 'root';  // Your MySQL user
$pass = '';  // Your MySQL password

// Create connection
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
