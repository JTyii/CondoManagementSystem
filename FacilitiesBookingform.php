<?php
include "dbConn.php";
session_start();
$name = $_SESSION['username'];

$unread_count = 0; // Initialize the variable

$get_resident_id_query = "SELECT resident_id FROM `usertable` WHERE `username` = ?";
$stmt_resident_id = $connection->prepare($get_resident_id_query);
$stmt_resident_id->bind_param("s", $name); // Use $name instead of $username
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
    }
}

if(isset($_POST ['Submit'])){
    $facilityname = $_POST['facilityname'];
    $unit_no = $_POST['unit_no'];
    $bookingdate = $_POST['bookingdate'];
    $slots = $_POST['slots'];
    $numberofpax = $_POST['numberofpax'];

    $query = "INSERT INTO `user_bookingtable`(`facilityname`, `unit_no`, `name`, `bookingdate`, `slots`, `numberofpax`) VALUES ('$facilityname','$unit_no','$name','$bookingdate','$slots','$numberofpax')";
    if (mysqli_query($connection, $query)) {
      // Insert booking request submitted notification
      $booking_notification = "Booking Request submitted.";

      // Get user ID to create a unique notification table
      $get_user_id_query = "SELECT resident_id FROM `usertable` WHERE `username`='$name'";
      $result = mysqli_query($connection, $get_user_id_query);

      if ($row = mysqli_fetch_assoc($result)) {
          $user_id = $row['resident_id'];
          $notification_table = "notifications_user_" . $user_id;

          $insert_booking_notification_query = "INSERT INTO `$notification_table` (notification, date) VALUES (?, NOW())";

          $stmt_booking_notification = mysqli_prepare($connection, $insert_booking_notification_query);

          if ($stmt_booking_notification) {
              mysqli_stmt_bind_param($stmt_booking_notification, "s", $booking_notification);

              if (mysqli_stmt_execute($stmt_booking_notification)) {
                  echo "<script>alert('Booking Request Submitted!'); window.location='index.php';</script>";
              } else {
                  echo "Error inserting booking notification: " . mysqli_error($connection);
              }

              mysqli_stmt_close($stmt_booking_notification);
          } else {
              echo "Error preparing booking notification statement: " . mysqli_error($connection);
          }
      } else {
          echo "Error retrieving user ID. Please try again.";
      }

      mysqli_close($connection);
  } else {
      echo "Error submitting your booking details. Please try again";
}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Signika+Negative&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/4e1d1789bb.js" crossorigin="anonymous"></script>
    <title>Condominium Facilities Booking</title>
</head>
<style>
  html, body {
  padding: 0;
  margin: 0;
  height: 100%;
  font-size: 1em;
  font-family: 'Signika Negative', sans-serif;
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
color:black;
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

body {
  font-family: 'Signika Negative', sans-serif;
    margin: 0;
    padding: 0;
    text-align: center;
    min-height: 100vh;
    background-image: url(img/bg.jpg);
      background-repeat: no-repeat;
      background-attachment: fixed;
      background-position: center;
      background-size: cover;
      background-size: 100%;
  }

  h1 {
    background-color: #1e90ff;
    color: white;
    padding: 25px;
    text-align: center;
    margin-bottom: 20px;
    margin-top: auto;
    border-radius: 9px;
  }
  
  form {
  max-width: 700px;
  margin: 0 auto;
  padding: 20px;
  background-color: rgba(255, 255, 255, 0.8);
  border: solid black 2px;
  box-shadow: 0 0 20px rgb(0, 0, 0);
  border-radius: 12px;
}

form h1 {
  background-color: #1e90ff;
  color: white;
  padding: 25px;
  text-align: center;
  margin-bottom: 20px;
  margin-top: auto;
  border-radius: 9px;
}

form label {
  display: block;
  margin-bottom: 5px;
  font-weight: bold;
  padding: auto;
}

form input[type="text"],
form input[type="date"],
form input[type="number"],
form input[type="time"],
form select {
  width: 70%;
  padding: 8px;
  margin-bottom: 10px;
  border: 1px solid #ccc;
  border-radius: 4px;
  text-align: center;
}

form input[type="submit"] {
  width: 40%;
  padding: 10px;
  background-color: #1e90ff;
  color: #fff;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  margin-top: 0%;
}

form input[type="submit"]:hover {
  background-color: #1034A6;
}

form .error {
  color: red;
  margin-top: 5px;
}

.form-box {
  margin-top: 100px;
  text-align: center;
}

.form-box select {
  width: 70%;
  height: 5vh;
  text-align: center;
  border-radius: 4px;
}
  
  label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
  }


  #facilityName,
#slotAvailability {
  width: 50%;
  height: 8vh;
  text-align: center;
  border-radius: 4px;
}
  
  input[type="text"],
  input[type="date"],
  input[type="number"] {
    width: 70%;
    padding: 8px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    text-align: center;
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
  
  .error {
    color: red;
    margin-top: 5px;
  }

  .footer {
    margin-top: 60px;
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
      <<a href="notification.php"><i class="fa-solid fa-envelope"></i>
                <?php
                if ($unread_count > 0) {
                    echo "<span class='notification-count'>$unread_count</span>";
                }
                ?>
            </a>
        <a href="edituserprofile.php"><i class="fas fa-user"></i></a>
        <?php echo "<text>$name</text>"; ?>
  </div>
    </ul>
  </nav>

  <form action="FacilitiesBookingform.php" method="POST" class="form-box">
      <H1>Facilities Booking Form</H1>
      <label for="facilityName">Facility Name:</label>
      <select id="facilityName" name="facilityname" required onchange="generateTimeSlots()">
        <option value="Select Facility">Select Facility</option>
        <option value="Badminton Court">Badminton Court</option>
        <option value="Gym">Gym</option>
        <option value="Swimming Pool">Swimming Pool</option>
        <option value="Table Tennis">Table Tennis</option>
        <option value="Beekinee Hall">Beekinee Hall</option>
      </select><br><br>
      
      <label for="unitNo">Unit No:</label>
      <input type="text" id="unitno" name="unit_no" required><br><br>
      
      <label for="bookingDate">Booking Date:</label>
      <input type="date" id="bookingdate" name="bookingdate" required><br><br>

      <label for="slotavailability">Select Your Slots:</label>
      <select id="slotavailability" name="slots" required onchange="generateTimeSlots()">
      </select><br><br>
      
      <label for="noofpax">No of Pax:</label>
      <input type="number" id="noofpax" name="numberofpax" min="1" required><br><br>
      </select><br><br>
      
      <input type="submit" value="Submit" name="Submit">
    </form>
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

<script>
    function generateTimeSlots() {
      var facilitySelect = document.getElementById("facilityName");
      var slotSelect = document.getElementById("slotavailability");
      var selectedFacility = facilitySelect.value;

      if (selectedFacility === "Swimming Pool") {
        var swimmingPoolSlots = [
          "10:00 AM - 12:00 PM",
          "12:00 PM - 02:00 PM",
          "02:00 PM -04:00 PM",
          "06:00 PM - 08.00 PM",
        ];

        
        for (var i = 0; i < swimmingPoolSlots.length; i++) {
          var option = document.createElement("option");
          option.text = swimmingPoolSlots[i];
          slotSelect.add(option);
        }
      } else if (selectedFacility === "Badminton Court") {
        // Generate time slots for Badminton Court
        var badmintonCourtSlots = [
          "10:00 AM - 12:00 PM",
          "12:00 PM - 02:00 PM",
          "02:00 PM -04:00 PM",
          "06:00 PM - 08.00 PM",
        ];

        // Add options to the select element
        for (var i = 0; i < badmintonCourtSlots.length; i++) {
          var option = document.createElement("option");
          option.text = badmintonCourtSlots[i];
          slotSelect.add(option);
        }
      } else if (selectedFacility === "Gym") {
        // Generate time slots for Gym
        var gymSlots = [
          "07:00 AM",
          "08.00 AM",
          "09:00 AM",
          "10:00 AM",
          "11:00 AM",
          "12:00 PM",
          "01:00 PM",
          "02:00 PM",
          "03:00 PM",
          "04:00 PM",
          "05:00 PM",
          "06:00 PM",
          "07:00 PM",
          "08:00 PM",
        ];

        // Add options to the select element
        for (var i = 0; i < gymSlots.length; i++) {
          var option = document.createElement("option");
          option.text = gymSlots[i];
          slotSelect.add(option);
        }
      } else if (selectedFacility === "Table Tennis") {
        // Generate time slots for Table Tennis
        var tableTennisSlots = [
          "10:00 AM - 12:00 PM",
          "12:00 PM - 02:00 PM",
          "02:00 PM -04:00 PM",
          "06:00 PM - 08.00 PM",
        ];

        // Add options to the select element
        for (var i = 0; i < tableTennisSlots.length; i++) {
          var option = document.createElement("option");
          option.text = tableTennisSlots[i];
          slotSelect.add(option);
        }
      } else if (selectedFacility === "Beekinee Hall") {
        // Generate time slots for Gym
        var HallSlots = [
          "07:00 AM",
          "08.00 AM",
          "09:00 AM",
          "10:00 AM",
          "11:00 AM",
          "12:00 PM",
          "01:00 PM",
          "02:00 PM",
          "03:00 PM",
          "04:00 PM",
          "05:00 PM",
          "06:00 PM",
          "07:00 PM",
          "08:00 PM",
        ];

        for (var i = 0; i < HallSlots.length; i++) {
          var option = document.createElement("option");
          option.text = HallSlots[i];
          slotSelect.add(option);

      // Enable the select element
      slotSelect.disabled = false;
    }
  }
}
  </script>


</html>
