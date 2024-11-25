<?php
session_start();
include "dbConn.php";
// Check if the user confirmed the action
if (isset($_POST['confirm'])) {
    // Retrieve the action and amount from the session variables
    $action = $_SESSION['action'];
    $amount = $_SESSION['amount'];

    // Retrieve the resident_id from the session
    $residentID = $_SESSION['resident_id'];

    // Perform the top-up or withdrawal operation and update the user_wallettable
    if ($action === 'topup') {
        $stmt = $connection->prepare("UPDATE `user_wallettable` SET amount = amount + ? WHERE resident_id = ?");
        $stmt->bind_param("ii", $amount, $residentID);
        $stmt->execute();
        $stmt->close();
    } elseif ($action === 'withdraw') {
        $stmt = $connection->prepare("UPDATE `user_wallettable` SET amount = amount - ? WHERE resident_id = ?");
        $stmt->bind_param("ii", $amount, $residentID);
        $stmt->execute();
        $stmt->close();
    }

    // Close the connection
    $connection->close();

    // Clear the session variables related to the confirmation
    unset($_SESSION['action']);
    unset($_SESSION['amount']);

    // Redirect back to the usertopup.php page after the action is confirmed
    header("Location: usertopup.php");
    exit();
}

// Check if the user canceled the action
if (isset($_POST['cancel'])) {
    // Clear the session variables related to the confirmation
    unset($_SESSION['action']);
    unset($_SESSION['amount']);

    // Redirect back to the usertopup.php page after the action is canceled
    header("Location: usertopup.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Confirmation</title>
    <style>
        /* Add styles for the background image slot */
        body {
            background-image: url('your-background-image-url.jpg');
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

        /* Add styles for the confirmation container */
        .confirmation-container {
            border: none; /* Remove border */
            border-radius: 10px; /* Add curved corners */
            padding: 30px; /* Increase padding */
            max-width: 600px; /* Increase container width */
            background-color: #fff;
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.2); /* Increase box shadow */
            text-align: center; /* Center the content */
        }

        /* Style for the button */
        button {
            background-color: #3498db;
            color: #fff;
            padding: 6px 12px; /* Reduce button padding by 60% */
            font-size: 120%; /* Increase font size for the button */
            border: none;
            cursor: pointer;
            border-radius: 5px;
            display: inline-block; /* Make buttons appear on the same line */
            transition: background-color 0.3s ease; /* Add transition on hover */
            margin: 5px; /* Add spacing between buttons */
        }

        button:hover {
            background-color: #1c79b6; /* Darker tone on hover */
        }
    </style>
</head>
<body>
    <div class="confirmation-container">
        <h1>Confirmation</h1>
        <?php if ($_SESSION['action'] === 'topup'): ?>
            <p>Confirm to Top-up: <?php echo $_SESSION['amount']; ?></p>
        <?php elseif ($_SESSION['action'] === 'withdraw'): ?>
            <p>Confirm to Withdraw: <?php echo $_SESSION['amount']; ?></p>
        <?php endif; ?>

        <!-- Form to submit confirmation or cancellation -->
        <form method="POST" action="confirmation.php">
            <!-- Hidden input fields to pass action and amount back to confirmation.php -->
            <input type="hidden" name="action" value="<?php echo $_SESSION['action']; ?>">
            <input type="hidden" name="amount" value="<?php echo $_SESSION['amount']; ?>">

            <button type="submit" name="confirm">Confirm</button>
            <button type="submit" name="cancel">Cancel</button>
        </form>
    </div>
</body>
</html>