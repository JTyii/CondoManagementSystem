<?php
include('dbConn.php'); // Include database connection

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $visitorName = $_POST["visitorName"];

    // Extract resident_name based on the visitor_name
    $extractResidentSql = "SELECT resident_name FROM admin_visitortable WHERE visitor_name = '$visitorName'";
    $residentResult = $connection->query($extractResidentSql);
    $residentRow = $residentResult->fetch_assoc();
    $residentName = $residentRow['resident_name'];

    // Find corresponding resident_id in the usertable
    $findResidentIdSql = "SELECT resident_id FROM usertable WHERE username = '$residentName'";
    $residentIdResult = $connection->query($findResidentIdSql);
    $residentIdRow = $residentIdResult->fetch_assoc();
    $residentId = $residentIdRow['resident_id'];

    // Create notification table name
    $notification_table = "notifications_user_" . $residentId;

    // Generate a random 5-letter string
    $randomString = substr(str_shuffle("abcdefghijklmnopqrstuvwxyz"), 0, 5);
    
    $notificationText = "Your Visitor Pass is $randomString";

    // Insert the notification into the notification table
    $notification_query = "INSERT INTO $notification_table (notification) VALUES ('$notificationText')";
    if ($connection->query($notification_query) === TRUE) {
        echo "Notification inserted successfully";
    } else {
        echo "Error inserting notification: " . $connection->error;
    }
}

$connection->close();
?>
