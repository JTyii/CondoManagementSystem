<?php
session_start();

include "dbConn.php";

// Check if the form is submitted
if (isset($_POST['submit'])) {
    $residentID = $_POST['resident_id'];
    $phoneNumber = $_POST['phone_number'];

    // Prepare and execute the SQL query
    $stmt = $connection->prepare("SELECT * FROM `user_wallettable` WHERE resident_id = ? AND phone_no = ?");
    $stmt->bind_param("is", $residentID, $phoneNumber);
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Verification successful, store session variables and proceed to the next page
        $userData = $result->fetch_assoc();
        $_SESSION['resident_id'] = $userData['resident_id'];
        $_SESSION['phone_number'] = $userData['phone_no'];
        header("Location: Invoice.php");
        exit();
    } else {
        // Verification failed, display an error message
        echo "Invalid resident ID or phone number. Please try again.";
    }

    // Close the statement
    $stmt->close();
}

// Close the connection
$connection->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Resident Verification</title>
    <style>
        /* Add styles for the background image slot */
        body {
            background-image: url('img/bg.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-size: 150%; /* Increase font size */
        }

        /* Add styles for the form container */
        .form-container {
            border: none; /* Remove border */
            border-radius: 10px; /* Add curved corners */
            padding: 30px; /* Increase padding */
            max-width: 600px; /* Increase container width */
            background-color: #fff;
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.2); /* Increase box shadow */
        }

        /* Style for the button */
        button {
            background-color: #3498db;
            color: #fff;
            padding: 15px 30px; /* Increase button size */
            font-size: 120%; /* Increase font size for the button */
            border: none;
            cursor: pointer;
            border-radius: 5px;
            display: block;
            margin: 0 auto;
        }

        /* Style for the input boxes */
        input[type="text"] {
            width: 100%;
            padding: 12px;
            box-sizing: border-box;
            margin-bottom: 15px; /* Increase margin */
            border: 1px solid #ccc;
            border-radius: 8px; /* Add curved corners */
            font-size: 120%; /* Increase font size for the input boxes */
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>Resident Verification</h1>
        <form method="POST" action="">
            <label for="resident_id">Resident ID:</label>
            <input type="text" name="resident_id" id="resident_id" required>

            <label for="phone_number">Phone Number:</label>
            <input type="text" name="phone_number" id="phone_number" required>

            <button type="submit" name="submit">Verify</button>
        </form>
    </div>
</body>
</html>