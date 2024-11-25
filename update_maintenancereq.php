<?php
// update_reservation.php

include('dbConn.php');

if (isset($_POST['submit'])) {
    // Get the form data
    $maintenance_id = $_POST['maintenance_id'];
    $date = $_POST['date'];
    $category = $_POST['category'];
    $description = $_POST['description'];
    $expenses = $_POST['expenses'];
    $status = $_POST['status']; // Updated name for Number of Pax field

    // Update the reservation ticket in the database
    $query = "UPDATE user_maintenancetable SET date = ?, category = ?, description = ?, expenses = ?, status = ? WHERE maintenance_id = ?";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, "sssssi", $date, $category, $description, $expenses, $status, $maintenance_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    // Redirect back to the admin_maintenancereq.php after successful update
    header("Location: admin_maintenancereq.php");
    exit();
} else {
    // If the form is not submitted properly, redirect back to the admin_maintenancereq.php
    header("Location: admin_maintenancereq.php");
    exit();
}
?>
