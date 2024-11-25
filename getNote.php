<?php
include "dbConn.php";

$sql = "SELECT notes FROM notes WHERE id = 1";
$result = mysqli_query($connection, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $note = $row['notes'];
    echo $note;
} else {
    echo "Note not found";
}

mysqli_close($connection);
?>