<?php
include "dbConn.php";

if (isset($_POST['message_id'])) {
  $messageId = $_POST['message_id'];

  // Perform the deletion query
  $query = "DELETE FROM chat WHERE message_id = $messageId";
  mysqli_query($connection, $query);
}

mysqli_close($connection);
?>