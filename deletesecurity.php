<?php
include "dbConn.php"; // Include your database connection script

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare and execute the DELETE query using a prepared statement
    $sql = "DELETE FROM security_personnel WHERE id = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: viewsecuritypersonnel.php"); // Redirect after successful deletion
        exit();
    } else {
        echo "Error deleting record: " . $stmt->error;
    }

    $stmt->close();
    $connection->close();
} else {
    echo "ID not provided";
    exit();
}
?>
