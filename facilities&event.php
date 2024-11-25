<?php 
include "dbConn.php";

// Retrieve events from the database
$sql = "SELECT * FROM admin_createevent ORDER BY date DESC";
$result = mysqli_query($connection, $sql);

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
    <link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Signika+Negative&display=swap" rel="stylesheet">
    <title>Facilities & Events</title>
    <script src="https://kit.fontawesome.com/4e1d1789bb.js" crossorigin="anonymous"></script>
</head>
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
    font-size: 0.6em;
    position: absolute;
    top: 4px;
    right: 4px;
}

  .maintitle {
  background-color: #333;
  color: #fff;
  text-align: center;
  font-size: 40px;
  padding: 30px;
}

section {
  padding: 10px 300px;
  font-size: 20px;
  border-radius: 20px;
  background-color: #f1f1f1;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
  text-align: center;
  margin: 20px 100px;
}

section ul {
  margin: 0;
  padding: 0;
}

section li {
  margin-bottom: 10px;
  text-align: justify;
  list-style-position: inside;
}

section h2{
  text-align: center;
}

      .facilities{
         background-color:  #537895;
         text-align: center;
        padding: 3px;
      }
      .word2{
        text-align: center;
        margin-left: 0px;
        font-size: 35px;
        font-family:'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif
      }

    .firstsection{
        margin-bottom: 2200px;
    }
    
    .image1{
        float: left;
        margin-left: 100px;
        box-shadow: 0 0 20px rgb(0, 0, 0);
        border: solid white 5px;
    }
    .content1{
        float: right;
        margin-right: 40px;
        font-size: x-large;
        margin-top: 30px;
        text-shadow: 1px 1px 1px grey;
    }

    .button{
    display: inline-block;
    position: relative;
    border: none;
    margin: 10px;
    padding: 10px;
    text-align: center;
    text-decoration: none;
    font: bold 12px/25px Arial, sans-serif;
    font-size: x-large;
    text-decoration: none;
    }

    .button :hover{
        background-color: gray;
    }

    .buttonblue{
    color: black;
    background: #70c9e3;
    border-radius: 20px;
    text-decoration: none;
    padding: 10px;
    }

    .buttongreen{
        color: black;
    background: #a5cd4e;
    border-radius: 20px;
    margin-right: 150px;
    text-decoration: none;
    padding: 10px;
    }

    .image2{
        margin-top: 100px;
        float: left;
        margin-left: 100px;
        box-shadow: 0 0 20px rgb(0, 0, 0);
        border: solid white 5px;
    }

    .content2{
        float: right;
        margin-right: 150px;
        font-size: x-large;
        margin-top: 300px;
        text-shadow: 1px 1px 1px grey;
    }

    .image3{
        margin-top: 100px;
        float: left;
        margin-left: 100px;
        box-shadow: 0 0 20px rgb(0, 0, 0);
        border: solid white 5px;
    }

    .content3{
        float: right;
        margin-right: 115px;
        font-size: x-large;
        margin-top: 250px;
        text-shadow: 1px 1px 1px grey;
    }

    .image4{
        margin-top: 100px;
        float: left;
        margin-left: 100px;
        box-shadow: 0 0 20px rgb(0, 0, 0);
        border: solid white 5px;
    }

    .content4{
        float: right;
        margin-right: 120px;
        font-size: x-large;
        margin-top: 250px;
        text-shadow: 1px 1px 1px grey;
    }

    .image5{
        margin-top: 100px;
        float: left;
        margin-left: 100px;
        box-shadow: 0 0 20px rgb(0, 0, 0);
        border: solid white 5px;
    }

    .content5{
        float: right;
        margin-right: 265px;
        font-size: x-large;
        margin-top: 230px;
        text-shadow: 1px 1px 1px grey;
    }

    .event{
        background-color: coral;
        text-align: center;
        padding: 3px;
    }

    .word{
        text-align: center;
        margin-left: 0px;
        font-size: 35px;
        font-family:'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif
    }

    .button2{
    display: inline-block;
    position: relative;
    border: none;
    margin: 10px;
    padding: 0 20px;
    text-align: center;
    text-decoration: none;
    font: bold 12px/25px Arial, sans-serif;
    font-size: x-large;
    }

    .button2 :hover{
    background-color: gray;
    }

    .buttonpurple{
    color: black;
    background: plum;
    border-radius: 20px;
    text-decoration: none;
    padding: 10px;
    }
    
    .event-container {
    display: flex; /* Use flexbox layout */
    align-items: center; /* Align vertically in the middle */
    margin: 20px 200px; 
}

.contents {
  text-align:center;
    flex: 1; 
    padding: 20px;
    font-size: 20px;
}

.images {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); /* Adjust the column width as needed */
  grid-gap: 20px;
  box-shadow: 0 0 20px rgb(0, 0, 0);
  border: solid white 5px;
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
  </section> </br> </br> 
  
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
  </section> </br> </br> 
  
  <section id="policies">
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
  </section></br> </br> 
  <center>
  <input type="checkbox" id="confirmCheckbox">
  <label for="confirmCheckbox">I agree to the terms and conditions.</label>
</center></br> </br> 
  <div id="facilitiesEventsContainer" class="hidden">
    <header>
        <h1 class="maintitle">Facilities and Events</h1>
    </header>
    <div class="firstsection">
    <div class="facilities">
        <h2 class="word2">Facilities</h2>
    </div> </br>
    <div class="swimmingpool">
        <div class="content1">
            <h3>Swimming Pool</h3>
            <p>The condominium offers a large swimming pool for residents to enjoy and relax.</p>
            <div class="button">
                <a href="availability.php" class="buttongreen">View Availability</a>
                <a href="FacilitiesBookingform.php" class="buttonblue">Book Now</a>
            </div>
        </div>
        <div class="image1">
            <img src="img/swimmingpool.jpg" alt="Swimming Pool" width="460" height="345">
        </div> 
    </div>
    </br>
    <div class="gym">
        <div class="content2">
            <h3>Gym</h3>
            <p>A fully-equipped gym is available for residents who want to stay fit.</p>
            <div class="button">
                <a href="availability.php" class="buttongreen">View Availability</a>
                <a href="FacilitiesBookingform.php" class="buttonblue">Book Now</a>
            </div>
        </div>
        <div class="image2">
            <img src="img/gym.jpg" alt="Gym" width="460" height="345">
        </div> 
    </div>
    </br>
    <div class="badminton">
        <div class="content3">
            <h3>Badminton Court</h3>
            <p>Badminton court is open for residents to play badminton and sweat out.</p>
            <div class="button">
                <a href="availability.php" class="buttongreen">View Availability</a>
                <a href="FacilitiesBookingform.php" class="buttonblue">Book Now</a>
            </div>
        </div>
        <div class="image3">
            <img src="img/badminton.jpg" alt="Badminton" width="460" height="345">
        </div> 
    </div>
</br>
    <div class="tabletennis">
        <div class="content4">
            <h3>Table Tennis Room</h3>
            <p>Badminton court is open for residents to play badminton and sweat out.</p>
            <div class="button">
                <a href="availability.php" class="buttongreen">View Availability</a>
                <a href="FacilitiesBookingform.php" class="buttonblue">Book Now</a>
            </div>
        </div>
        <div class="image4">
            <img src="img/table-tennis-room-d.jpg" alt="Table Tennis" width="460" height="345">
        </div> 
    </div>
</br>
    <div class="hall">
        <div class="content5">
            <h3>Beekinee Hall</h3>
            <p>A hall for residents to organise events and activities.</p>
            <p> Events of Beekini Heights will also be held here.</p>
            <div class="button">
                <a href="availability.php" class="buttongreen">View Availability</a>
                <a href="FacilitiesBookingform.php" class="buttonblue">Book Now</a>
            </div>
        </div>
        <div class="image5">
            <img src="img/hall.jpg" alt="Hall" width="460" height="345">
        </div> 
    </div>
</div>
</br>
<div class="secondsection">
    <div class="event">
        <h2 class="word">Events</h2>
    </div> 
</div>
</br>
    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <div class="event-container">
            <div class="contents">
                <h2><?php echo $row['event']; ?></h2>
                <p><?php echo $row['description']; ?></p>
                <div class="button2">
                    <a href="EventBooking.php" class="buttonpurple">Join Now</a>
                </div>
            </div>
            <div class="images">
                <?php if ($row['image']) { ?>
                    <img src="data:image/jpeg;base64,<?php echo base64_encode($row['image']); ?>" width="250" height="200">
                <?php } else { ?>
                    No image
                <?php } ?>
            </div> 
        </div>
    <?php } ?>
</br>

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
</div>
</body>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const confirmCheckbox = document.getElementById("confirmCheckbox");
    const facilitiesEventsContainer = document.getElementById("facilitiesEventsContainer");

    confirmCheckbox.addEventListener("change", function () {
        if (confirmCheckbox.checked) {
            facilitiesEventsContainer.classList.remove("hidden");
        } else {
            facilitiesEventsContainer.classList.add("hidden");
        }
    });
});
</script>
</html>