<?php
include "dbConn.php";

session_start();
$username = $_SESSION['username'];
?>
<!DOCTYPE html>
<html>
 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Compliance & Regulatory</title>
     <script src="https://kit.fontawesome.com/4e1d1789bb.js" crossorigin="anonymous"></script>
</head>
<style>

    html, body {
      padding: 0;
      margin: 0;
      height: 100%;
      font-size: 1.3em;
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

  .maintitle{
  background-color: burlywood;
  color: #fff;
  text-align: center;
  font-size: 40px;
  padding: 40px;
  }

  .backgroundimage{
    background-image: url(images/background3.jpg);
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-position:center;
    background-size: cover;
    }

  section {
  padding: 20px;
  font-size: 20px;
  border: 4px solid black;
  text-align: center;
}

ul {
  margin: 0;
  padding: 0;
}

li {
  margin-bottom: 10px;
  text-align: center;
  list-style-position: inside;
}

h2{
  text-align: center;
}

.policies{
  margin-bottom: 80px;
}

.footer {
      position: absolute;
      bottom: 0;
      left: 0;
      width: 100%;
      background: #1034A6;
      display: flex;
      align-items: center;
      display: flex;
      justify-content: space-between;
      color: #fff;
      font-size: 0.6em;
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
<body class="backgroundimage">
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
  <header>
    <h1 class="maintitle">Compliance and Regulatory</h1>
  </header>
  
  <section id="rules">
    <h2><u>Condominium Rules</u></h2>
    <ul>
      <li>No pets allowed in common areas.</li>
      <li>Quiet hours are from 10:00 PM to 8:00 AM.</li>
      <li>Proper disposal of garbage in designated bins.</li>
      <li>No smoking in common areas.</li>
      <li>Prohibition of illegal activities within the premises.</li>
      <li>Respect for neighbors' privacy and peace.</li>
      <li>Use of designated parking spaces only.</li>
      <li>No unauthorized modifications to common areas or facilities.</li>
      <li>Maintaining cleanliness and hygiene in personal units.</li>
    </ul>
  </section> </br> </br> </br> </br> </br> </br>
  
  <section id="regulations">
    <h2><u>Regulations</u></h2>
    <ul>
      <li>Fire safety regulations must be strictly followed.</li>
      <li>Guest registration required at the main entrance.</li>
      <li>Speed limit of 10 km/h within the premises.</li>
      <li>Proper use of elevators and adherence to weight restrictions.</li>
      <li>Prohibition of hanging laundry on balconies or windows.</li>
      <li>Guidelines for renovation and modification of individual units.</li>
      <li>Proper use and maintenance of common facilities and equipment.</li>
      <li>Prohibition of altering or tampering with utility installations.</li>
      <li>Guidelines for the use of community rooms and shared spaces.</li>
    </ul>
  </section> </br> </br> </br> </br> </br> </br>
  
  <section class="policies">
    <h2><u>Policies</u></h2>
    <ul>
      <li>Visitor policy: All visitors must be accompanied by residents.</li>
      <li>Pool usage policy: No lifeguard on duty, swim at your own risk.</li>
      <li>Guest parking policy: Guests must park in designated visitor parking areas.</li>
      <li>Noise policy: Avoid excessive noise that may disturb other residents.</li>
      <li>Package delivery policy: Guidelines for package acceptance and retrieval.</li>
      <li>Health and safety policy: Compliance with health and safety regulations.</li>
      <li>Guest access policy: Procedures for granting access to guests.</li>
      <li>Common area reservation policy: Guidelines for booking common spaces.</li>
      <li>Compliance policy: Consequences for violations of rules and regulations.</li>
    </ul>
  </section>

  <label for="confirmCheckbox">I agree to the terms and conditions.</label>
<input type="checkbox" id="confirmCheckbox">
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