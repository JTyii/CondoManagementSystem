<?php
include('dbConn.php');

if (isset($_GET['edit_id'])) {
    $booking_id = $_GET['edit_id'];

    // Retrieve booking information from the database based on the booking_id
    $query = "SELECT * FROM user_bookingtable WHERE booking_id = ?";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, "i", $booking_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

    // Check if the booking_id exists in the database
    if (!$row) {
        echo "Booking ID not found!";
        exit();
    }
} else {
    // Redirect back to the manage_reservation_tickets.php if booking_id is not provided
    header("Location: admin_managereservationtickets.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Reservation Ticket</title>
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
    <h1>Modify Reservation Ticket</h1>
    <form action="update_reservation.php" method="POST">
        <input type="hidden" name="booking_id" value="<?php echo $booking_id; ?>">
        <label for="facility_name">Facility Name:</label>
        <input type="text" id="facility_name" name="facility_name" value="<?php echo $row['facilityname']; ?>">

        <label for="unit_number">Unit Number:</label>
        <input type="text" id="unit_number" name="unit_number" value="<?php echo $row['unit_no']; ?>">

        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo $row['name']; ?>">

        <label for="booking_date">Booking Date:</label>
        <input type="date" id="booking_date" name="booking_date" value="<?php echo $row['bookingdate']; ?>">

        <label for="slots">Slots:</label>
        <input type="text" id="slots" name="slots" value="<?php echo $row['slots']; ?>">

        <label for="number_of_pax">Number of Pax:</label>
        <input type="number" id="noofpax" name="numberofpax" value="<?php echo $row['numberofpax']; ?>" min="1">

        <input type="submit" value="Save Changes" name="submit">
    </form>
</div>
</body>
</html>
