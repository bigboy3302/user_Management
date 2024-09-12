<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <style>
        body {
            background-color: gray;
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: Arial, sans-serif;
            overflow: hidden; /* Hide scrollbars */
        }

        table {
            width: 1200px; /* Adjusted width */
            height: 800px; /* Adjusted height */
            border-collapse: collapse;
            table-layout: fixed; /* Ensure table doesn't exceed the viewport */
            transition: transform 2s; /* Smooth transition for the rotation */
        }

        td {
            width: 33%;
            height: 33%;
            border: 1px solid #ccc;
            text-align: center;
            vertical-align: middle;
            padding: 20px;
        }

        /* Container-specific styles */
        #container1 {
            width: 100%; /* Ensure it takes up the full width of its cell */
            height: 100%; /* Ensure it takes up the full height of its cell */
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden; /* Hide overflow to ensure image fits within the container */
        }

        #container1 img {
            max-height: 90%; /* Make the image slightly smaller in height */
            max-width: 90%; /* Make the image slightly smaller in width */
            object-fit: contain; /* Maintain aspect ratio and fit within the container */
            cursor: pointer;
        }

        /* Modal Styles for Full-Screen Image */
        #imageModal {
            display: none;
            position: fixed;
            z-index: 10;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8);
            justify-content: center;
            align-items: center;
        }

        #imageModal img {
            max-width: 90%;
            max-height: 90%;
        }

        #imageModal .close {
            position: absolute;
            top: 20px;
            right: 40px;
            color: white;
            font-size: 40px;
            cursor: pointer;
        }

        /* Confetti animation */
        .confetti {
            width: 10px;
            height: 10px;
            position: absolute;
            animation: fall 5s linear infinite;
        }

        .confetti:nth-child(1) { background-color: red; }
        .confetti:nth-child(2) { background-color: blue; }
        .confetti:nth-child(3) { background-color: yellow; }
        .confetti:nth-child(4) { background-color: green; }
        .confetti:nth-child(5) { background-color: purple; }

        @keyframes fall {
            0% { top: -20px; }
            100% { top: 100%; }
        }

        /* Breathing bubble animation */
        .breathing-bubble {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 150px; /* Increased size */
            height: 150px; /* Increased size */
            border-radius: 50%;
            background-color: rgb(243, 0, 252);
            animation: breathe 6s infinite;
            margin: auto; /* Center the bubble */
        }

        @keyframes breathe {
            0%, 100% { width: 150px; height: 150px; background-color: rgb(243, 0, 252); }
            50% { width: 200px; height: 200px; background-color: rgb(0, 255, 136); }
        }

        /* Rotation animation */
        @keyframes rotateTable {
            from {
                transform: rotate(0deg);
            }
            to {
                transform: rotate(360deg);
            }
        }

        /* Links styling */
        a { color: blue; text-decoration: none; }
        a:hover { color: orange; transition: 1s; }
        a:active { color: red; }
    </style>
</head>
<body>
    <table id="rotatingTable">
        <tr>
            <!-- Container 1: VTDT Background with Large Image -->
            <td id="container1">
                <img src="vtdt.png" alt="Image" id="imageClick">
            </td>

            <!-- Container 2: Confetti Rain -->
            <td id="container2" style="position: relative;">
                <div class="confetti" style="left: 10%; animation-duration: 3s;"></div>
                <div class="confetti" style="left: 30%; animation-duration: 4s;"></div>
                <div class="confetti" style="left: 50%; animation-duration: 3s;"></div>
                <div class="confetti" style="left: 70%; animation-duration: 1s;"></div>
                <div class="confetti" style="right: 70%; animation-duration: 2s;"></div>
            </td>

            <!-- Container 3: Rotating Page Button -->
            <td id="container3">
                <button onclick="rotatePage()">Click for Surprise</button>
            </td>
        </tr>
        <tr>
            <!-- Container 4: Breathing Bubble -->
            <td id="container4">
                <div class="breathing-bubble"></div>
            </td>

            <!-- Container 5: Links -->
            <td id="container5">
                <a href="https://youtube.com" target="_blank">YouTube</a><br>
                <a href="https://gmail.com" target="_blank">Gmail</a><br>
                <a href="https://www.vtdt.lv" target="_blank">VTDT</a><br>
                <a href="https://example.com" target="_blank">Example Link 1</a><br>
                <a href="https://example.com" target="_blank">Example Link 2</a>
            </td>

            <!-- Container 6: Weather Display -->
            <td id="container6">
                <p>Latvia, Cēsis</p>
                <p id="temperature">Temperature: Loading...</p>
            </td>
        </tr>
        <tr>
            <!-- Container 7: DB Input Form -->
            <td id="container7">
                <form action="add_user.php" method="post" onsubmit="return validateForm()">
                    <input type="text" name="firstName" placeholder="First Name" required><br>
                    <input type="text" name="lastName" placeholder="Last Name" required><br>
                    <input type="tel" name="phone" placeholder="Phone Number" pattern="[0-9]{8}" required><br>
                    <input type="text" name="personalCode" placeholder="Personal Code" pattern="[0-9]{11}" required><br>
                    <button type="submit">Submit</button>
                </form>
            </td>

            <!-- Container 8: User Management Section (Edit Only) -->
            <td id="container8">
                <h3>User List</h3>
                <div id="userList">
                    <?php
                    // Connect to the database
                    $conn = new mysqli('localhost', 'root', '', 'user_management');

                    // Check connection
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    // Fetch users
                    $sql = "SELECT id, first_name, last_name FROM users";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        echo "<ul>";
                        while($row = $result->fetch_assoc()) {
                            echo "<li>{$row['first_name']} {$row['last_name']} 
                                <a href='edit_user.php?id={$row['id']}'>Edit</a></li>";
                        }
                        echo "</ul>";
                    } else {
                        echo "No users found.";
                    }

                    $conn->close();
                    ?>
                </div>
            </td>

            <td id="container9">
                <h3>Delete User</h3>
                <form id="deleteUserForm">
                    <label for="deleteUserSelect">Select User to Delete:</label><br>
                    <select id="deleteUserSelect" name="userId" required>
                        <option value="">Select a user</option>
                        <?php
                        // Connect to the database
                        $conn = new mysqli('localhost', 'root', '', 'user_management');

                        // Check connection
                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }

                        // Fetch users
                        $sql = "SELECT id, first_name, last_name FROM users";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            // Create dropdown options for each user
                            while($row = $result->fetch_assoc()) {
                                echo "<option value='{$row['id']}'>{$row['first_name']} {$row['last_name']}</option>";
                            }
                        } else {
                            echo "<option value=''>No users available</option>";
                        }

                        $conn->close();
                        ?>
                    </select><br><br>
                    <button type="submit">Delete</button>
                </form>
            </td>
        </tr>
        </tr>

    <!-- Modal for Full-Screen Image -->
    <div id="imageModal">
        <span class="close" onclick="closeModal()">&times;</span>
        <img id="modalImage" src="vtdt.png">
    </div>

    <script src="script.js"></script>
</body>
</html>
