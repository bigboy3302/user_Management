<?php
// delete_user.php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];

    // Connect to the database
    $conn = new mysqli('localhost', 'root', '', 'user_management');

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prevent SQL injection
    $name = $conn->real_escape_string($name);

    // Delete user from the database
    $sql = "DELETE FROM users WHERE CONCAT(first_name, ' ', last_name) = '$name'";

    if ($conn->query($sql) === TRUE) {
        echo "success";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
