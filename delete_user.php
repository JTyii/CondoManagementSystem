<?php
include("dbConn.php");

if (isset($_GET['id'])) {
    $userID = $_GET['id'];
    
    $deleteQuery = "DELETE FROM usertable WHERE resident_id = $userID";
    
    if (mysqli_query($connection, $deleteQuery)) {
        echo "<script>alert('User account deleted successfully');
        window.location='userreport.php'; // Redirect back to the report page
        </script>";
    } else {
        echo "Error deleting user account: " . mysqli_error($connection);
    }
} else {
    echo "Invalid request. User ID not provided.";
}
?>
