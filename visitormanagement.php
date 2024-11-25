<?php

include "dbConn.php";

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

if(isset($_POST['submit'])){session_start();
    $name = $_POST['name'];
    $contact = $_POST['contact'];
    $purpose = $_POST['purpose'];
    $checkin = $_POST['checkin'];
    $checkout = $_POST['checkout'];
    $parking = $_POST['parking'];
    $_SESSION['name'] = $name;
    $_SESSION['purpose'] = $purpose;
    $_SESSION['checkin'] = $checkin;
    $_SESSION['checkout'] = $checkout;
    $_SESSION['parking'] = $parking;

    $query = "INSERT INTO `admin_visitortable`(`visitor_name`, `visitor_contact`, `visit_purposes`, `check_in_time`, `check_out_time`, `parking_request`, `resident_name`) VALUES ('$name', '$contact', '$purpose', '$checkin', '$checkout', '$parking', '$username')";
    if (mysqli_query($connection, $query)){
        echo "<script>alert('Registered Successfully!');";
        header("Location: generatedvistorpass.php");
    } else {
        echo "Error submitting your registration. Please try again";
    }
    mysqli_close($connection);
} 
?>

<!DOCTYPE html>
<html>
<head>
  <title>Visitor Management</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Signika+Negative&display=swap" rel="stylesheet">
  <script src="https://kit.fontawesome.com/4e1d1789bb.js" crossorigin="anonymous"></script>
</head>
<style>
    html, body {
      padding: 0;
      margin: 0;
      height: 100%;
      font-size: 1.3em;
      font-family: 'Signika Negative', sans-serif;
    }

    .background-image{
        background-image: url(img/bg.jpg);
      background-repeat: no-repeat;
      background-attachment: fixed;
    background-position: center;
    background-size: cover;
    }
    nav {
    position: above;
    top: 0;
    width: 100%;
    z-index: 999;
  }

  nav ul{
    list-style-type: none;
    margin: 0;
    padding: 0;
    overflow: hidden;
    background-color: #1034A6;
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

  nav a:hover {
        background: #1e90ff;
      color: black;
      font-weight: bold;
      transition: 0.6s;
    }
  
  .user a,text{
        color:#fff;
        padding: 15px 10px;
        font-size: 1.3em;
        float:right;
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

section {
  padding: 20px;
}

form {
  border: solid black 2px;
  padding: 50px 40px 100px 40px;
  border-radius: 12px;
  box-shadow: 0 0 20px rgb(0, 0, 0);
  width: 650px;
  height: 90vh;
  margin-left: auto;
  margin-right: auto;
  margin-top: 100px;
  margin-bottom: 100px;
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

label {
  display: block;
  margin-bottom: 15px;
  font-weight: bold;
}

input[type="text"],
input[type="datetime-local"] {
  width: 100%;
  padding: 8px;
  margin-bottom: 10px;
  border: 1px solid #ccc;
  border-radius: 4px;
}

input[type="submit"] {
      border-radius: 12px;
      width: 70%;
      background-color: #1e90ff;
      color: white;
      border: 1px solid #ccc;
      border-radius: 4px;
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

      .hidden {
        display:none;
}
</style>
<body class="background-image">
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
  
  <section>
    <form action="" method="post">
      <h1>Visitor Registration Form</h1>
      <label for="visitorName">Visitor Name:</label>
      <input type="text" id="visitorName" name="name" required>
      
      <label for="visitorContact">Visitor Contact:</label>
      <input type="text" id="visitorContact" name="contact" required>
      
      <label for="visitPurpose">Visit Purpose:</label>
      <input type="text" id="visitPurpose" name="purpose" required>
      
      <label for="checkIn">Check-In Time:</label>
      <input type="datetime-local" id="checkIn" name="checkin" required>
      
      <label for="checkOut">Check-Out Time:</label>
      <input type="datetime-local" id="checkOut" name="checkout" required>
      
      <label for="parking">Parking Reservation:</label>
<select id="parking" name="parking" required style="width: 102.5%; height: 30px;">
    <option value="Yes">Yes</option>
    <option value="No">No</option>
</select>



      <input type="submit" name="submit">
    </form>
  </section>
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