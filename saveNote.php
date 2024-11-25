
<?php
include "dbConn.php";

$response = array();

if (isset($_POST['note'])) {
    $note = $_POST['note'];

    // Update the existing note in the database
    $sql = "UPDATE notes SET notes = '$note' WHERE id = 1"; 
    $result = mysqli_query($connection, $sql);

    if ($result) {
        $response['success'] = true;
        $response['message'] = "Note saved successfully.";
    } else {
        $response['success'] = false;
        $response['message'] = "Error: " . mysqli_error($connection);
    }
}
mysqli_close($connection);

echo json_encode($response);
?>





