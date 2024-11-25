<?php
include 'dbConn.php';

session_start();
$username = $_SESSION['username'];

$get_resident_id_query = "SELECT resident_id FROM `usertable` WHERE `username` = ?";
$stmt_resident_id = $connection->prepare($get_resident_id_query);
$stmt_resident_id->bind_param("s", $username);
$stmt_resident_id->execute();
$resident_id_result = $stmt_resident_id->get_result();

if ($resident_id_result->num_rows > 0) {
    $resident_row = $resident_id_result->fetch_assoc();
    $resident_id = $resident_row['resident_id'];
    $notification_table = "notifications_user_" . $resident_id;
    $unread_count_query = "SELECT COUNT(*) AS unread_count FROM `$notification_table` WHERE is_read = 0";
$unread_count_result = mysqli_query($connection, $unread_count_query);

if ($unread_count_result) {
    $unread_count_row = mysqli_fetch_assoc($unread_count_result);
    $unread_count = $unread_count_row['unread_count'];
} else {
    $unread_count = 0;
}
}

if(isset($_POST ['btnSubmit'])){
    $name = $_POST['txtName'];
    $contact = $_POST['txtContact'];
    $unit_no = $_POST['txtUnit_no'];
    $email = $_POST['txtEmail'];
    $message = $_POST['txtMessage'];
    $query = "INSERT INTO `user_contactustable`(`name`, `contact`, `unit_no`, `email`, `message`) VALUES ('$name','$contact','$unit_no','$email','$message')";
    if (mysqli_query($connection, $query)) {
      // Insert maintenance request submitted notification
      $contact_notification = "Contact Us Form submitted.";

      // Get user ID to create a unique notification table
      $get_user_id_query = "SELECT resident_id FROM `usertable` WHERE `username`='$username'";
      $result = mysqli_query($connection, $get_user_id_query);

      if ($row = mysqli_fetch_assoc($result)) {
          $user_id = $row['resident_id'];
          $notification_table = "notifications_user_" . $user_id;

          $insert_contact_notification_query = "INSERT INTO `$notification_table` (notification, date) VALUES (?, NOW())";

          $stmt_contact_notification = mysqli_prepare($connection, $insert_contact_notification_query);

          if ($stmt_contact_notification) {
              mysqli_stmt_bind_param($stmt_contact_notification, "s", $contact_notification);

              if (mysqli_stmt_execute($stmt_contact_notification)) {
                  echo "<script>alert('Contact Us Form Submitted!'); window.location='index.php';</script>";
              } else {
                  echo "Error inserting notification: " . mysqli_error($connection);
              }

              mysqli_stmt_close($stmt_contact_notification);
          } else {
              echo "Error preparing notification statement: " . mysqli_error($connection);
          }
      } else {
          echo "Error retrieving user ID. Please try again.";
      }

      mysqli_close($connection);
  } else {
      echo "Error submitting your details. Please try again";
  }
    mysqli_close($connection);
    }    
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Contact Us</title>
	<link rel="stylesheet" type="text/css" href="css/contact.css">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Signika+Negative&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/4e1d1789bb.js" crossorigin="anonymous"></script>
</head>
<style>
* {
	box-sizing: border-box;
	margin: 0;
	padding: 0;
}

body {
	font-family: 'Signika Negative', sans-serif;
	font-size: 16px;
	line-height: 1.5;
  background-image: url(img/bg.jpg);
  background-repeat: no-repeat;
  background-attachment: fixed;
  background-position: center;
  background-size: cover;
}

html, body {
      padding: 0;
      margin: 0;
      height: 100%;
      font-size: 1.3em;
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
      font-weight: bold;
      transition: 0.6s;
    }

    .user a, text {
      color: #fff;
      padding: 15px 10px;
      font-size: 1.3em;
      float: right;
    }

    .user a:hover {
      color:black;
      transform: scale(1.5);
      transition: 0.3s;
    }

    .notification-count {
    background-color: red;
    color: white;
    border-radius: 50%;
    padding: 2px 6px;
    font-size: 0.6em;
    position: absolute;
    top: 4px;
    right: 4px;
}

    form {
      border: solid black 2px;
      padding: 50px 40px 100px 40px;
      border-radius: 12px;
      box-shadow: 0 0 20px rgb(0, 0, 0);
      width: 650px;
      height: 125vh;
      margin-left: auto;
      margin-right: auto;
      margin-top: 100px;
      margin-bottom: 60px;
      align-items: center;
      text-align: center;
      background-color: rgba(255, 255, 255, 0.8);
      font-size: 18px;
    }

    h1 {
      background-color: #1e90ff;
      color: white;
      padding: 40px;
      margin-top: auto;
      text-align: center;
      margin-bottom: 20px;
      border-radius: 9px;
    }

label, input, textarea {
	font-family: 'Signika Negative', sans-serif;
	margin-bottom: 20px;
	width: 100%;
}
label {
	font-weight: bold;
}

input, textarea {
	padding: 10px;
	border: 1px solid #ccc;
	border-radius: 5px;
	font-size: 16px;
}
textarea {
	resize: none;
}
input[type="submit"] {
      border-radius: 12px;
      width: 70%;
      background-color: #1e90ff;
      color: white;
      border: 1px solid #ccc;
      padding: 10px;
      cursor: pointer;
      margin-top: 2%;
      font-size: 18px;
    }
    
    input[type="submit"]:hover {
      background-color: #1034A6;
    }

.footer {
      bottom: 0;
      left: 0;
      width: 100%;
      background: #1034A6;
      display: flex;
      align-items: center;
      display: flex;
      justify-content: space-between;
      color: #fff;
      overflow: hidden;
      border-top: 5px solid #a2f1ff;
      height: 50px;
    }

    .footer-content {
      padding-left: 30px;
    }

    .footer-content1 a {
      padding-right: 30px;
      color: white;
      text-decoration: none;
    }

    .footer-content1 a:hover {
      color: black;
    }
</style>
<body class="background-image">
<header>
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
      <a href ="notification.php"><i class="fa-solid fa-envelope"></i><?php
        if ($unread_count > 0) {
            echo "<span class='notification-count'>$unread_count</span>";
        }
        ?></a>
        <a href="edituserprofile.php"><i class="fas fa-user"></i></a>
        <?php echo "<text>$username</text>"; ?>
  </div>
    </ul>
  </nav>
	</header>
	<h3><center>Get in touch with us for any enquiries on Beekinee Heights and submit your enquiries via the form below.</center></h3>
	<form id="contact-form" action="contactus.php" method="post">
    <h1>Contact Us</h1>
		<label for="name">Name:</label>
		<input type="text" id="" name="txtName" placeholder="Your name.." required>

        <label for="contact">Contact:</label>
		<input type="contact" id="" name="txtContact" placeholder="Your contact.." required>

        <label for="unit_no">Unit Number:</label>
		<input type="text" id="" name="txtUnit_no" placeholder="Your unit number" required>
		
		<label for="email">Email:</label>
		<input type="email" id="" name="txtEmail" placeholder="Your email.." required> 
		
		<label for="message">Message:</label>
		<textarea id="" name="txtMessage" placeholder="Your Message.." style="height:200px" required></textarea>
		
		<input type="submit" value="SUBMIT" name="btnSubmit">
	</form>
	<div class="footer">
    <div class="footer-content">
      <p>&copy; 2023 BEEKINEE. All rights reserved. <a href = "adminsignup.php"><i class="fa-solid fa-hammer fa-beat"></i></a></p>
    </div>
    <div class="footer-content1">
      <a href="license.php">License</a>
      <a href="term.php">Term of Service</a>
      <a href="privacypolicy.php">Privacy Policy</a>
    </div>
  </div>
</body>
</html>