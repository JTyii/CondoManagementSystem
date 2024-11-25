<?php
include('dbConn.php');

$query = "SELECT * FROM `user_paymenttable` ORDER BY id DESC LIMIT 1";
$result = mysqli_query($connection, $query);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);

    $phonenumber = $row['phonenumber'];
    $email = $row['email'];
    $cardnumber = $row['cardnumber'];
    $paymentamount = $row['paymentamount'];

    echo "<h1>Payment Confirmation</h1>";
    echo "<p><strong>Phone Number:</strong> $phonenumber</p>";
    echo "<p><strong>Email:</strong> $email</p>";
    echo "<p><strong>Pin Number:</strong> $cardnumber</p>";
    echo "<p><strong>Payment Amount:</strong> $paymentamount</p>";
} else {
    echo "No details found.";
}

mysqli_close($connection);
?>