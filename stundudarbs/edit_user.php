<?php
// edit_user.php

// Connect to the database
$conn = new mysqli('localhost', 'root', '', 'user_management');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if an ID was passed via GET request
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the user data based on the ID, including phone
    $sql = "SELECT first_name, last_name, phone, personal_code FROM users WHERE id=$id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch user data
        $user = $result->fetch_assoc();
        $firstName = $user['first_name'];
        $lastName = $user['last_name'];
        $phone = $user['phone'];  // Including phone number
        $personalCode = $user['personal_code'];
    } else {
        echo "User not found.";
        exit;
    }
} else {
    echo "No user ID provided.";
    exit;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
</head>
<body>
    <h2>Edit User</h2>
    
    <form action="update_user.php" method="post">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        
        <label for="firstName">First Name:</label>
        <input type="text" id="firstName" name="firstName" value="<?php echo $firstName; ?>" required><br>

        <label for="lastName">Last Name:</label>
        <input type="text" id="lastName" name="lastName" value="<?php echo $lastName; ?>" required><br>

        <label for="phone">Phone Number:</label>
        <input type="tel" id="phone" name="phone" value="<?php echo $phone; ?>" pattern="[0-9]{8}" required><br>

        <label for="personalCode">Personal Code:</label>
        <input type="text" id="personalCode" name="personalCode" value="<?php echo $personalCode; ?>" pattern="[0-9]{11}" required><br>

        <button type="submit">Update User</button>
    </form>
</body>
</html>
