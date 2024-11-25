<?php
  session_start();
  include "dbConn.php";
  $username = $_SESSION['username'];

  $query = "SELECT * FROM `user_maintenancetable` WHERE `username` = ?";
  $stmt = mysqli_prepare($connection, $query);
  mysqli_stmt_bind_param($stmt, "s", $username);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <script
        src="https://kit.fontawesome.com/4e1d1789bb.js"
        crossorigin="anonymous"
      ></script>
      <link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Signika+Negative&display=swap" rel="stylesheet">
      <title>Maintenance Request History</title>
    </head>
<body>
<style>
body {
  font-family: 'Signika Negative', sans-serif;
  padding: 0;
  background-image: url(img/bg.jpg);
  background-repeat: no-repeat;
  background-attachment: fixed;
  background-position: center;
  background-size: cover;
  background-size: 100%;
}
html, body {
    padding: 0;
    margin: 0;
    height: 100%;
    font-size: 1em;
  }
  
  nav {
  position: relative;
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

  body {
    background-image: url(img/bg.jpg);
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-position: center;
    background-size: cover;
    background-size: 100%;
  }

  .title {
      background-color: #333;
      color: #fff;
      text-align: center;
      padding: 10px;
  }
  
  
  table {
    position:relative;
    width: 100%;
    border-collapse: collapse;
    background-color: rgba(255, 255, 255, 0.8);
  }
  
  th, td {
    padding: 10px;
    text-align: left;
    border-bottom: 1px solid #ccc;
  }
  
  thead th {
    background-color: #75b7fa;
  }
  
  tbody tr:nth-child(even) {
    background-color: rgba(255, 255, 255, 0.8);
  }
  .footer {
    position: absolute;
    bottom:0;
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
  <br>
    <div class="title">
    <h1>Maintenance Tracking & History</h1>
</div>
<br>
<table>
<thead>
    <tr>
        <th>Username</th>
        <th>Unit No.</th>
        <th>Date</th>
        <th>Category</th>
        <th>Description</th>
        <th>Status</th>
        <th></th>
    </tr>
  </thead>
  <tbody>
    <?php
    if (mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['username'] . "</td>";
        echo "<td>" . $row['unit_no'] . "</td>";
        echo "<td>" . $row['date'] . "</td>";
        echo "<td>" . $row['category'] . "</td>";
        echo "<td>" . $row['description'] . "</td>";
        echo "<td>" . $row['status'] . "</td>";
        echo "</tr>";
      }
    } else {
      echo "<tr><td colspan='7'>No maintenance requests found.</td></tr>";
    }
    ?>
  </tbody>
</table>
<div class="footer">
    <div class="footer-content">
      <p>&copy; 2023 BEEKINEE. All rights reserved. <a href = "adminsignup.php"><i class="fa-solid fa-hammer fa-beat"></i></a></p>
    </div>
    <div class="footer-content1">
      <a href="">License</a>
      <a href="">Term of Service</a>
      <a href="privacypolicy.html">Privacy Policy</a>
    </div>
  </div>
</div>
</body>
</html>
