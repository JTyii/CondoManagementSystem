<?php
include "dbConn.php"; // Include your database connection

$data = json_decode(file_get_contents("php://input"), true);
$imageDataUrl = $data['imageDataUrl'];

// Decode the data URL
$imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imageDataUrl));

// Update the user's profile picture in the database
session_start();
$username = $_SESSION['username'];

$update_query = "UPDATE `usertable` SET profile_pic='$imageData' WHERE username='$username'";
$result = mysqli_query($connection, $update_query);

$response = array();
if ($result) {
    $response['success'] = true;
} else {
    $response['success'] = false;
}

echo json_encode($response);
?>
