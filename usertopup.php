<?php
session_start();
include "dbConn.php";
// Check if the top-up form is submitted
if (isset($_POST['topup'])) {
    // Retrieve the top-up amount from the form
    $amount = $_POST['topup_amount'];

    // Store the top-up amount and action in session variables
    $_SESSION['action'] = 'topup';
    $_SESSION['amount'] = $amount; 

    // Redirect to the confirmation page
    header("Location: confirmation.php");
    exit();
}

// Check if the withdrawal form is submitted
if (isset($_POST['withdraw'])) {
    // Retrieve the withdrawal amount from the form
    $amount = $_POST['withdraw_amount'];

    // Store the withdrawal amount and action in session variables
    $_SESSION['action'] = 'withdraw';
    $_SESSION['amount'] = $amount;

    // Redirect to the confirmation page
    header("Location: confirmation.php");
    exit();
}

// Retrieve the resident_id and phone_number from the session
$residentID = $_SESSION['resident_id'];
$phoneNumber = $_SESSION['phone_number'];

// Prepare and execute the SQL query to get user's information
$stmt = $connection->prepare("SELECT * FROM `user_wallettable` WHERE resident_id = ? AND phone_no = ?");
$stmt->bind_param("is", $residentID, $phoneNumber);
$stmt->execute();

// Get the result
$result = $stmt->get_result();

// Close the statement
$stmt->close();

// Check if the user's information is found in the database
if ($result->num_rows > 0) {
    // Fetch the user's information
    $userData = $result->fetch_assoc();
} else {
    // User not found, handle the error appropriately
    die("User not found.");
}

// Close the connection
$connection->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Wallet Information</title>
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
            font-size: 150%;
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
            padding: 4px 8px; /* Reduce button padding by 60% */
            font-size: 120%; /* Increase font size for the button */
            border: none;
            cursor: pointer;
            border-radius: 5px;
            display: block;
            transition: background-color 0.3s ease; /* Add transition on hover */
        }

        button:hover {
            background-color: #1c79b6; /* Darker tone on hover */
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

        /* Style for the select dropdown */
        select {
            width: 100%;
            padding: 7px; /* Reduce dropdown padding by half */
            box-sizing: border-box;
            margin-bottom: 15px; /* Increase margin */
            border: 1px solid #ccc;
            border-radius: 8px; /* Add curved corners */
            font-size: 120%; /* Increase font size for the dropdown list */
        }

        /* Style for the Skip to Next Page button */
        .skip-button {
            display: block;
            width: 100%;
            text-align: center; /* Center the button horizontally */
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>User Wallet Information</h1>
        <p>Resident ID: <?php echo $userData['resident_id']; ?></p>
        <p>Phone Number: <?php echo $userData['phone_no']; ?></p>
        <p>Amount: <?php echo $userData['amount']; ?></p>

        <!-- Top-up form -->
        <form method="POST" action="">
            <label for="topup_amount">Select Top-up Amount:</label>
            <select name="topup_amount" id="topup_amount">
                <?php for ($amount = 0; $amount <= 500; $amount += 5): ?>
                    <option value="<?php echo $amount; ?>"><?php echo $amount; ?></option>
                <?php endfor; ?>
            </select>
            <button type="submit" name="topup">Top-up</button>
        </form>

        <!-- Withdrawal form -->
        <form method="POST" action="">
            <label for="withdraw_amount">Select Withdrawal Amount:</label>
            <select name="withdraw_amount" id="withdraw_amount">
                <?php for ($amount = 0; $amount <= $userData['amount']; $amount += 5): ?>
                    <option value="<?php echo $amount; ?>"><?php echo $amount; ?></option>
                <?php endfor; ?>
            </select>
            <button type="submit" name="withdraw">Withdraw</button>
        </form>

        <form method="POST" action="Invoice.php">
            <br>
            <button type="submit" name="skip" class="skip-button">Return to Invoice Page</button>
        </form>
    </div>
</body>
</html>