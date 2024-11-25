<?php
include('dbConn.php');

if (isset($_GET['edit_id'])) {
    $maintenance_id = $_GET['edit_id'];

    // Retrieve booking information from the database based on the booking_id
    $query = "SELECT * FROM user_maintenancetable WHERE maintenance_id = ?";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, "i", $maintenance_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

    // Check if the booking_id exists in the database
    if (!$row) {
        echo "Maintenance ID not found!";
        exit();
    }
} else {
    // Redirect back to the manage_reservation_tickets.php if booking_id is not provided
    header("Location: admin_maintenancereq.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Maintenance Request History</title>
</head>
<style>
.background-image {
        background-image: url(images/background-color.jpg);
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-position: center;
        background-size: cover;
    }

    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f1f1f1;
        display: flex;
        justify-content: center; /* Center the content horizontally */
        align-items: center; /* Center the content vertically */
        height: 100vh; /* Set the height of the body to the full viewport height */
    }

    /* Container to wrap the content */
    .container {
        max-width: 600px;
        margin: 0 auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
    }

    h1 {
        text-align: center;
        margin: 20px 0;
    }

    label {
        display: block;
        margin-bottom: 10px;
    }

    input[type="text"],
    input[type="number"],
    input[type="date"] {
        width: 100%;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
        margin-bottom: 20px;
    }

    input[type="submit"] {
        background-color: #1033a6;
        color: #fff;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    input[type="submit"]:hover {
        background-color: #1e90ff;      
    }
</style>
<body class="background-image">
<div class="container">
    <h1>Modify Maintenance Request History</h1>
    <form action="update_maintenancereq.php" method="POST">
        <input type="hidden" name="maintenance_id" value="<?php echo $maintenance_id; ?>">

        <label for="date">Date:</label>
        <input type="date" id="date" name="date" value="<?php echo $row['date']; ?>">

        <label for="category">Category:</label>
        <input type="text" id="category" name="category" value="<?php echo $row['category']; ?>">

        <label for="description">Description:</label>
        <input type="text" id="description" name="description" value="<?php echo $row['description']; ?>">

        <label for="expenses">Expenses:</label>
        <input type="number" id="expenses" name="expenses" value="<?php echo $row['expenses']; ?>">

        <label for="status">Status:</label>
        <input type="text" id="status" name="status" value="<?php echo $row['status']; ?>">

        <input type="submit" value="Save Changes" name="submit">
    </form>
</div>
</body>
</html>
