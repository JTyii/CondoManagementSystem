<?php
include('dbConn.php'); // Include database connection

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $visitorName = $_POST["visitorName"];
    $status = $_POST["status"];

    // Update the pending_request column in the database
    $sql = "UPDATE admin_visitortable SET pending_request = '$status' WHERE visitor_name = '$visitorName'";
    if ($connection->query($sql) === TRUE) {
        echo "Status updated successfully";
    } else {
        echo "Error updating status: " . $connection->error;
    }

    $connection->close();
}
?>