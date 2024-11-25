<?php
include('dbConn.php');

if (isset($_GET['delete_id1'])) {
    $message_id = $_GET['delete_id1'];
    $query = "DELETE FROM user_contactustable WHERE `message` = ?";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, "s", $message_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    // Return a JSON response to indicate success
    echo json_encode(['success' => true]);
    exit();
} else {
    // Return a JSON response to indicate failure
    echo json_encode(['success' => false]);
    exit();
}
?>
