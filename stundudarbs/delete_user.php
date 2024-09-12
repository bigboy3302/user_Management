<?php 
// delete_user.php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the user ID from the POST request
    $userId = $_POST['userId'];

    // Check if userId is present
    if (empty($userId)) {
        echo "Error: No user ID provided.";
        exit();
    }

    // Connect to the database
    $conn = new mysqli('localhost', 'root', '', 'user_management');

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare the SQL DELETE query using the user ID
    $userId = (int)$conn->real_escape_string($userId); // Casting to int for safety
    $sql = "DELETE FROM users WHERE id = $userId";

    // Execute the query
    if ($conn->query($sql) === TRUE) {
        echo "success";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the database connection
    $conn->close();
}
?>

