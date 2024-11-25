<?php
include('dbConn.php');
session_start();
$username = $_SESSION['username'];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $phonenumber = $_POST['phonenumber'];
    $email = $_POST['email'];
    $cardnumber = $_POST['cardnumber'];
    $paymentamount = $_POST['paymentamount'];

    // Remove any spaces from the phone number and card number
    $phonenumber = str_replace(' ', '', $phonenumber);
    $cardnumber = str_replace(' ', '', $cardnumber);

    // Define the regular expression patterns
    $phonePattern = '/^[0-9]+$/';
    $cardPattern = '/^[0-9]+$/';

    // Perform the validation for phone number
    if (!preg_match($phonePattern, $phonenumber)) {
        // Invalid phone number - display an error message
        echo "Invalid phone number. Only digits are allowed.";
        exit; // Stop further execution
    }

    // Perform the validation for card number
    if (!preg_match($cardPattern, $cardnumber)) {
        // Invalid card number - display an error message
        echo "Invalid card number. Only digits are allowed.";
        exit; // Stop further execution
    }

    $query = "INSERT INTO `user_paymenttable`(`phonenumber`, `email`, `cardnumber`, `paymentamount`)
        VALUES ('$phonenumber','$email','$cardnumber', '$paymentamount')";
    
    if (mysqli_query($connection, $query)) {
        $_SESSION['phonenumber'] = $phonenumber;
        $_SESSION['email'] = $email;
        $_SESSION['cardnumber'] = $cardnumber;
        $_SESSION['paymentamount'] = $paymentamount;
        echo "Redirecting you to the Confirmation Page...";
        header("refresh:1;url=PaymentConfirmation.php");
    }
    
    mysqli_close($connection);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://kit.fontawesome.com/4e1d1789bb.js" crossorigin="anonymous"></script>
    <title>Payment</title>
    <style>
        html, body {
            padding: 0;
            margin: 0;
            height: 100%;
            font-size: 1.3em;
            text-align: center;
        }

        nav {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 999;
        }

        nav ul{
            list-style-type: none;
            margin: 0;
            padding: 0;
            overflow: hidden;
            background-color: #1033a6;
            font-size: 15px;
        }

        nav li a{
            float:left;
        }

        nav li a {
            text-decoration: none;
            color: #fff;
            padding: 15px 40px;
            font-size: 1.3em;
            display: inline-block;
        }

        nav li a:hover {
        background: #1e90ff;
        color: black;
        }

        .user a,text{
            color:#fff;
            padding: 15px 10px;
            font-size: 1.3em;
            float:right;
        }

        .Payment-form {
            width: 470px;
            margin: 100px 500px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            background-color: #FFF;
        }

        h1 {
            text-align: center;
            font-size: 38px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type=text],
        input[type=email],
        input[type=password] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #38B8E8;
            border: none;
            border-radius: 3px;
            color: #FFF;
            cursor: pointer;
            display: block;
            font-size: 16px;
            margin: 20px 0 0;
            padding: 10px;
            width: 100%;
        }

        input[type="submit"]:hover {
            background-color: #2FAAC5;
        }

        #links {
            margin-top: 20px;
            text-align: center;
        }

        #links a {
            color: #154360;
            display: inline-block;
            margin: 0 10px;
            text-decoration: underline;
        }
    </style>
</head>

<body>
<nav>
    <ul>
      <li class= "house"><a href="index.php"><i class="fas fa-home"></i></a></li>
      <li><a href="maintenancereq.php" class="dropbtn">Maintenance</a></li>
      <li><a href="UserWalletVeri.php">Payments</a></li>
      <li><a href="chat.php">Community Chat</a></li>
      <li><a href="facilities&event.php">Facilities & Events</a></li>
      <li><a href="visitormanagement.php">Parking & Visitors</a></li>
      <li><a href="contactus.php">Contact Us</a></li>
      <div class="user">
      <a href ="notification.php"><i class="fa-solid fa-envelope"></i></a>
        <a href="edituserprofile.php"><i class="fas fa-user"></i></a>
        <?php echo "<text>$username</text>"; ?>
  </div>
    </ul>
  </nav>
    <div class="Payment-form">
        <h1>Payment Details</h1>
        <form action="Payment.php" method="POST">
            <label for="phonenumber">Phone Number:</label>
            <input type="text" id="phonenumber" name="phonenumber" required>
            <label for="email">Email:</label>
            <input type="text" id="email" name="email" required>
            <label for="cardnumber">Pin number:</label>
            <input type="text" id="cardnumber" name="cardnumber" required>
            <label for="paymentamount">Amount:</label>
            <input type="text" id="paymentamount" name="paymentamount" required>
            <input type="submit" value="Pay Now" name="btnRegister">
        </form>
        <div id="links">
            <a href="index.php">Go back</a>
        </div>
    </div>
</body>

</html>