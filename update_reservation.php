<?php
// update_reservation.php

include('dbConn.php');

if (isset($_POST['submit'])) {
    // Get the form data
    $booking_id = $_POST['booking_id'];
    $facility_name = $_POST['facility_name'];
    $unit_number = $_POST['unit_number'];
    $name = $_POST['name'];
    $booking_date = $_POST['booking_date'];
    $slots = $_POST['slots'];
    $numberofpax = $_POST['numberofpax']; // Updated name for Number of Pax field

    // Update the reservation ticket in the database
    $query = "UPDATE user_bookingtable SET facilityname = ?, unit_no = ?, name = ?, bookingdate = ?, slots = ?, numberofpax = ? WHERE booking_id = ?";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, "ssssssi", $facility_name, $unit_number, $name, $booking_date, $slots, $numberofpax, $booking_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    // Redirect back to the manage_reservation_tickets.php after successful update
    header("Location: admin_managereservationtickets.php");
    exit();
} else {
    // If the form is not submitted properly, redirect back to the manage_reservation_tickets.php
    header("Location: admin_managereservationtickets.php");
    exit();
}
?>
