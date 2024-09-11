<?php

// add_user.php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $phone = $_POST['phone'];
    $personalCode = $_POST['personalCode'];

    // Connect to the database
    $conn = new mysqli('localhost', 'root', '', 'user_management');

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insert user into the database
    $sql = "INSERT INTO users (first_name, last_name, phone_number, personal_code) VALUES ('$firstName', '$lastName', '$phone', '$personalCode')";

    if ($conn->query($sql) === TRUE) {
        echo "New user added successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
