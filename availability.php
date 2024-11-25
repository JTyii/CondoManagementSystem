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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Availability</title>
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

  nav li a:hover {
  background: #1e90ff;
  color:black;}
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


  .title {
      background-color: #333;
      color: #fff;
      text-align: center;
      padding: 10px;
  }

h2{
  text-align:center;
}

table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 70%;
  background-color: white;
  margin: 0 auto;
  margin-top: 50px;
}

td, th {
  border: 1px solid #dddddd;
  text-align: center;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #white;
}

table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
}

.facility{
  background-color:aqua;
}

.oh{
  background-color:green;
}

.as{
  background-color:grey;
}

h3{
  font:bold;
  margin-left:20px;
}

.first{
  font-weight: bold;
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
<body>
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
    <div class="title">
        <h2>Available Slots for Facilities</h2>
  </div>
    <h2>The table below shows the operating hours and all available slots for the facilities in Beekinee Heights.</h2>
    <table>
    <tr>
    <th class="facility">Facility</th>
    <th class="oh">Operating Hours</th>
    <th class="as">Available Slots</th>
  </tr>
  <tr>
    <td class="first">Swimming Pool</td>
    <td>10.00 AM to 07.00 PM</td>
    <td>Available for booking from 10.00 am to 07.00 pm up to two hours per slot. </td>
  </tr>
  <tr>
    <td class="first">Gym</td>
    <td>07.00 AM to 08.00 PM</td>
    <td>Available for booking from 07.00 am to 08.00 pm up to two hours per slot.</td>
  </tr>
  <tr>
    <td class="first">Badminton Court</td>
    <td>10.00 AM to 08.00 PM</td>
    <td>4 Slots Available for Booking per day:</br>
          10:00 AM - 12:00 PM</br>
          12:00 PM - 02:00 PM</br>
          02:00 PM -04:00 PM</br>
          06:00 PM - 08.00 PM
    </td>
  </tr>
  <tr>
    <td class="first">Table Tennis Room</td>
    <td>10.00 AM to 08.00 PM</td>
    <td>4 Slots Available for Booking per day:</br>
          10:00 AM - 12:00 PM</br>
          12:00 PM - 02:00 PM</br>
          02:00 PM -04:00 PM</br>
          06:00 PM - 08.00 PM
    </td>
  </tr>
  <tr>
    <td class="first">Beekinee Hall</td>
    <td>07.00 AM to 10.00 PM</td>
    <td>Available for booking from 07.00 am to 08.00 pm up to two hours per slot.</td>
  </tr>
</table>
<h3>*Please note that residents from one unit can only make up to two bookings per week. Any enquiries, please <a class="contact" href="contactus.php">contact us.</a></h3>
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
</div>
</body>
</html>