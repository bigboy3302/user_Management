<?php
// update_user.php
header('Location: index.php');




if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = new mysqli('localhost', 'root', '', 'user_management');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $id = $_POST['id'];
    $firstName = $conn->real_escape_string($_POST['firstName']);
    $lastName = $conn->real_escape_string($_POST['lastName']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $personalCode = $conn->real_escape_string($_POST['personalCode']);

    $sql = "UPDATE users SET first_name='$firstName', last_name='$lastName', phone='$phone', personal_code='$personalCode' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        // Adjust the location to the correct path
        header('Location: /index.php'); // Update this path based on your main page location
        exit;
    } else {
        echo "Error updating record: " . $conn->error;
    }

    $conn->close();
}
