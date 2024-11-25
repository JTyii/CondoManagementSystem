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

if(isset($_POST ['Register'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $unit_no = $_POST['unit_no'];
    $numberofpax = $_POST['numberofpax'];
    $event = $_POST['event'];
    $message = $_POST['message'];

    $query = "INSERT INTO `user_eventtable`(`name`, `email`, `unit_no`, `numberofpax`, `event`, `message`) VALUES ('$name','$email','$unit_no','$numberofpax','$event','$message')";
    if (mysqli_query($connection, $query)) {
      // Insert maintenance request submitted notification
      $event_notification = "Event Form submitted.";

      // Get user ID to create a unique notification table
      $get_user_id_query = "SELECT resident_id FROM `usertable` WHERE `username`='$username'";
      $result = mysqli_query($connection, $get_user_id_query);

      if ($row = mysqli_fetch_assoc($result)) {
          $user_id = $row['resident_id'];
          $notification_table = "notifications_user_" . $user_id;

          $insert_event_notification_query = "INSERT INTO `$notification_table` (notification, date) VALUES (?, NOW())";

          $stmt_event_notification = mysqli_prepare($connection, $insert_event_notification_query);

          if ($stmt_event_notification) {
              mysqli_stmt_bind_param($stmt_event_notification, "s", $event_notification);

              if (mysqli_stmt_execute($stmt_event_notification)) {
                  echo "<script>alert('Event Form Submitted!'); window.location='index.php';</script>";
              } else {
                  echo "Error inserting event notification: " . mysqli_error($connection);
              }

              mysqli_stmt_close($stmt_event_notification);
          } else {
              echo "Error preparing event notification statement: " . mysqli_error($connection);
          }
      } else {
          echo "Error retrieving user ID. Please try again.";
      }

      mysqli_close($connection);
  } else {
      echo "Error submitting your event details. Please try again";
  }
    mysqli_close($connection);
    } 
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf=8" />
    <link rel="stylesheet" href="EventBooking.css" />
    <script
      src="https://kit.fontawesome.com/4e1d1789bb.js"
      crossorigin="anonymous"
    ></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Signika+Negative&display=swap" rel="stylesheet">
    <title>Condominium Event Registrarion</title>
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
    margin: 0;
    padding: 0;
    align-items: center;
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
    margin-top: auto;
    text-align: center;
    margin-bottom: 20px;
    border-radius: 9px;
  }
  
  form {
    border: solid black 2px;
    border-radius: 12px;
    box-shadow: 0 0 20px rgb(0, 0, 0);
    width: 700px;
    height: 80vh;
    margin-left: auto;
    margin-right: auto;
    margin-top: 70px;
    align-items: center;
    text-align: center;
    background-color: rgba(255, 255, 255, 0.8);
    margin-bottom:180px;
  }

  .form-box {
      border: solid black 2px;
      border-radius: 12px;
      box-shadow: 0 0 20px rgb(0, 0, 0);
      width: 700px;
      height: 100vh;
      margin: 100px auto 40px;
      margin-bottom:180px;
      align-items: center;
      text-align: center;
      background-color: rgba(255, 255, 255, 0.8);
      padding: 50px;
    }

    .form-box input[type="submit"]:hover {
      background-color: #1034A6;
    }

  #event {
    margin-bottom: 2%;
    width: 35%;
    height: 3vh;
    text-align: center;
    border-radius: 4px;
  }

  label {
    display: block;
    width: 70%;
    padding: 8px;
    margin-bottom: 10px;
    text-align: center;
    align-items: center;
    margin-left: auto;
    margin-right: auto;
  }

  input {
    display: block;
    width: 70%;
    border: 1px solid #ccc;
    border-radius: 4px;
    padding: 8px;
    margin-bottom: 10px;
    text-align: center;
    align-items: center;
    margin-left: auto;
    margin-right: auto;
  }
  
  textarea {
    resize: vertical;
    border: 1px solid #ccc;
    border-radius: 4px;
    display: block;
    width: 70%;
    padding: 8px;
    margin-bottom: 10px;
    margin-left: auto;
    margin-right: auto;
  }
  
  input[type="submit"] {
    width: 70%;
    background-color: #1e90ff;
    color: white;
    border: 1px solid #ccc;
    border-radius: 4px;
    padding: 10px;
    cursor: pointer;
    margin-top: 2%;
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

    <form class="form-box" action="EventBooking.php" method="post">
     <h1>Condominium Event Registration</h1>
      <label for="name">Name:</label>
      <input type="text" id="name" name="name" placeholder="Enter Your Name.." required />

      <label for="email">Email:</label>
      <input type="email" id="email" name="email" placeholder="Enter Your Email.." required />

      <label for="unitno">Unit No:</label>
      <input type="unit_no" id="unit_no" name="unit_no" placeholder="Enter Your Unit Number.." required />

      <label for="noofpax">No of Pax:</label>
      <input type="numberofpax" id="numberofpax" name="numberofpax" min="1" placeholder="Enter Number of Pax.." required>

      <label for="event">Event:</label>
      <select id="event" name="event" placeholder="Select Facility" required>
        <option value="" disabled selected>Select an event</option>
        <option value="movienight">Movie Night</option>
        <option value="YogaClass">Yoga Class</option>
        <option value="BadmintonCompetition">Beekinee Heights Badminton Competition</option>
      </select>

      <label for="message">Remarks:</label>
      <textarea id="message" name="message" rows="4" placeholder="Leave any Remarks here.."></textarea>

      <input type="submit" name="Register" />
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
</html>
