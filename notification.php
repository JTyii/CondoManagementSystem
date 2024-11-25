<?php
include 'dbConn.php';

session_start();
$username = $_SESSION['username'];

// Retrieve user ID based on the username
$user_id_query = "SELECT resident_id FROM usertable WHERE username = '$username'";
$user_id_result = mysqli_query($connection, $user_id_query);

if ($user_id_result && mysqli_num_rows($user_id_result) > 0) {
    $user_id_row = mysqli_fetch_assoc($user_id_result);
    $user_id = $user_id_row['resident_id'];

    // Form the name of the user-specific notification table
    $notification_table = "notifications_user_" . $user_id;
    $unread_count_query = "SELECT COUNT(*) AS unread_count FROM $notification_table WHERE `is_read` = 0";
    $unread_count_result = mysqli_query($connection, $unread_count_query);

    $unread_count = 0;
if ($unread_count_result) {
    $unread_count_row = mysqli_fetch_assoc($unread_count_result);
    $unread_count = $unread_count_row['unread_count'];
}

    // Retrieve notifications from the user-specific notification table
    $notifications_query = "SELECT * FROM $notification_table ORDER BY id DESC";
    $notifications_result = mysqli_query($connection, $notifications_query);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Signika+Negative&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/4e1d1789bb.js" crossorigin="anonymous"></script>
    <title>Notifications</title>
    <style>
html, body {
font-family: 'Signika Negative', sans-serif;
padding: 0;
margin: 0;
height: 100%;
font-size: 1.3em;
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
color: black;
font-weight: bold;
transition: 0.6s;
}

.user{
padding-right: 15px;
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
font-size: 0.8em;
position: absolute;
top: -10px;
right: -5px;
}

h1 {
text-align: center;
padding: 20px;
background-color: #333;
color: white;
}

.container {
position: relative;
}

.notification {
    position:relative;
    background-color: white;
    padding: 20px;
    margin: 30px;
    border-radius: 5px;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
}

.notification:hover {
  background-color: #C4F4FF;
}

.notification p {
  margin: 0;
  padding: 5px 0;
}

a {
  display: inline-block;
  text-decoration: none;
  color: #1033a6;
  font-weight: bold;
}

a:hover {
  color: #073bd6;
}

.footer {
position:bottom;
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
</head>
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
      <a href ="notification.php"><i class="fa-solid fa-envelope"></i>
      <?php
        if ($unread_count > 0) {
            echo "<span class='notification-count'>$unread_count</span>";
        }
        ?></a>
        <a href="edituserprofile.php"><i class="fas fa-user"></i></a>
        <?php echo "<text>$username</text>"; ?>
  </div>
    </ul>
  </nav>
    <h1>Notifications</h1>
    <div class="container">
    <?php
    if (isset($notifications_result) && mysqli_num_rows($notifications_result) > 0) {
      while ($notification_row = mysqli_fetch_assoc($notifications_result)) {
          $notification_text = $notification_row['notification'];
          $notification_date = $notification_row['date'];
          
          // Update the is_read column to mark the notification as read
          $update_notification_query = "UPDATE $notification_table SET is_read = 1 WHERE id = " . $notification_row['id'];
          mysqli_query($connection, $update_notification_query);
  ?>
          <div class="notification">
              <p><?php echo $notification_date; ?></p>
              <p><?php echo $notification_text; ?></p>
          </div>
  <?php
      }
  } else {
      echo "<center><p>No notifications found.</p></center>";
  }
    ?>
</div>
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