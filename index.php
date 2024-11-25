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

$announcement = "SELECT * FROM admin_createannouncement ORDER BY time DESC";
$announcement_result = mysqli_query($connection, $announcement);

$sql = "SELECT resident_id, type, amount, release_date, due_date FROM admin_billingtable WHERE username = ?";
$stmt = $connection->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

$sqlLatestMessage = "SELECT * FROM chat ORDER BY timestamp DESC LIMIT 1";
$resultLatestMessage = $connection->query($sqlLatestMessage);
$latestMessage = "";
$latestUsername = "";
$latestTimestamp = "";

if ($resultLatestMessage->num_rows > 0) {
    $row = $resultLatestMessage->fetch_assoc();
    $latestMessage = $row['text'];
    $latestUsername = $row['username'];
    $latestTimestamp = $row['timestamp'];
}

// Query upcoming events from the user_bookingtable
$currentDate = date('Y-m-d');
$sqlUpcomingEvents = "SELECT * FROM user_bookingtable WHERE name = ? AND bookingdate >= ? ORDER BY bookingdate ASC";
$stmtUpcomingEvents = $connection->prepare($sqlUpcomingEvents);
$stmtUpcomingEvents->bind_param("ss", $username, $currentDate);
$stmtUpcomingEvents->execute();
$resultUpcomingEvents = $stmtUpcomingEvents->get_result();
$upcomingEvents = array();

if ($resultUpcomingEvents->num_rows > 0) {
    while ($row = $resultUpcomingEvents->fetch_assoc()) {
        $upcomingEvents[] = $row;
    }
}

if (isset($_POST['btnSubmit'])) {
  $name = $_POST['txtName'] ?? '';
  $email = $_POST['txtEmail'] ?? '';
  $message = $_POST['txtMessage'] ?? '';

  // Validate and sanitize input before inserting into the database
  $name = trim($_POST['name']);
$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
$message = trim($_POST['message']);

if (!empty($name) && !empty($email) && !empty($message)) {
    $query = "INSERT INTO `user_contactustable`(`name`, `email`, `message`) VALUES (?, ?, ?)";
    $stmtInsert = $connection->prepare($query);
    
    // Check if the prepared statement was created successfully
    if ($stmtInsert) {
        $stmtInsert->bind_param("sss", $name, $email, $message);

        if ($stmtInsert->execute()) {
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

            // Close the prepared statement
            $stmtInsert->close();
        } else {
            echo '<script>alert("Error submitting your message. Please try again");</script>';
        }
    } else {
        echo "Error preparing statement: " . $connection->error;
    }
} else {
    echo '<script>alert("Please fill in all fields.");</script>';
}
}
// Close the database connection
mysqli_close($connection);
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Signika+Negative&display=swap" rel="stylesheet">
  <script
  src="https://kit.fontawesome.com/4e1d1789bb.js"
  crossorigin="anonymous"
></script>
  <title>BEEKINEE</title>
  <style>
    html, body {
      padding: 0;
      margin: 0;
      height: 100%;
      font-size: 1.3em;
      font-family: 'Signika Negative', sans-serif;
    }

    header {
      height: 100vh;
      position: relative;
      overflow: hidden;
      background: url(img/condom.jpg) center no-repeat;
      background-size: cover;
    }

    header .top-content {
      position: absolute;
      top: 300px;
      left: 50%;
      transform: translate(-50%, -50%);
      text-align: center;
      color: #fff;
      border: 5px solid #ffffff89;
      padding: .2em 2em;
      background-color: rgba(0, 0, 0, 0.651);
    }

    .site {
      padding: 20em 0;
      text-align: center;
      font-size: .8em;
      color: #000000;
    }
    .site nav {
      position: absolute;
      top: calc(100vh - 50px);
      width: 100%;
      z-index: 999;
    }

    .site nav ul {
      position:relative;
      list-style-type: none;
      margin: 0;
      padding: 0;
      overflow: hidden;
      background-color: #1033a656;
      font-size: 15px;
    }

    .site nav li {
      float: left;
      position: relative;
    }

    .site nav li a {
      text-decoration: none;
      color: #fff;
      padding: 15px 40px;
      font-size: 1.3em;
      display: inline-block;
      transition: font-size 0.3s;
    }

    .site nav li a:hover {
      background: #1e90ff;
      color: black;
      font-weight: bold;
      transition: 0.6s;
    }

    .user {
      padding-right: 15px;
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

    body {
      background-image: url(img/bg.jpg);
      background-repeat: no-repeat;
      background-attachment: fixed;
      background-position: center;
      background-size: cover;
      background-size: 100%;
  }

    .mid-content {
      text-align: center;
      transform: translateY(20px);
    }

    .dashboard-item {
    background-color: #fff;
    color: #000;
    padding: 20px;
    margin: 60px 50px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
  }

      /* Hover effect for dashboard items */
  .dashboard-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    transition: transform 0.3s, box-shadow 0.3s;
  }

  .dashboard-item i {
    font-size: 3em;
    margin-bottom: 10px;
  }

  .dashboard-item h2 {
    font-size: 1.5em;
    margin-bottom: 10px;
  }

  .dashboard-item p {
    font-size: 1.1em;
  }
      .dashboard-item table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
  }

  .dashboard-item th,
  .dashboard-item td {
    padding: 12px;
    border-bottom: 1px solid #ddd;
    text-align: left;
  }

  .dashboard-item th {
    background-color: #1034A6;
    color: #fff;
  }

  .dashboard-item tr:hover {
    background-color: #f2f2f2;
  }

  .dashboard-item tr:last-child td {
    border-bottom: none;
  }

  #pay {
  background-color: #4CAF50; 
  color: #fff; 
  font-size: 1em; 
  padding: 12px 20px; 
  border: none; 
  border-radius: 5px;
  cursor: pointer;
  transition: background-color 0.3s ease; 
}

  #pay:hover {
    background-color: #388E3C; 
  }

    .message-box {
      color: black;
    }

    .message-box :hover{
      cursor: pointer;
      background-color: #f1f1f1;
    }

    .upcoming-event{
      color: black;
    }

    .no-event {
      color:red;
      cursor: pointer;
    }
    .upcoming-event :hover{
      background-color: #f1f1f1;
    }

    .no-event :hover{
      background-color: #f1f1f1;
    }

    
    .title {
      background-color: #333;
      color: #fff;
      text-align: center;
      padding: 10px;
  }

  .announcement {
      display: flex;
      justify-content: center;
      align-items: center;
      flex-wrap: wrap;
      padding: 2em;
  }

  .announcement-item{
      flex: 1;
      margin: 1em;
      padding: 1.5em;
      border-radius: 20px;
      background-color: #f1f1f1;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
  }

  .announcement-item img{
      border-radius: 20px;
      max-width: 100%;
      height: auto;
  }

  .fixed-button {
    text-decoration: none;
  position: fixed;
  bottom: 30px;
  right: 30px;
  background-color: #1034A6;
  color: white;
  border: none;
  border-radius: 50%;
  width: 60px;
  height: 60px;
  display: flex;
  justify-content: center;
  align-items: center;
  font-size: 1.5em;
  cursor: pointer;
  transition: background-color 0.3s ease;
  z-index: 1000;
}

.fixed-button:hover {
  background-color: #1e90ff;
}

.bot-content {
position: relative;
height: 450px;
padding: 50px 20px;
background-color: #000000;
color: rgb(201, 181, 56);
border-top: 5px solid #a2f1ff;
}

.bot-image {
float: left;
padding: 
}

#bot-content1 {
padding-top: 50px;
float: left;
font-size: 20px;
}

#bot-content2 {
padding-left: 50px;
float: right;
font-size: 20px;
}
#contact-form {
      margin-top: 20px;
  }

  #contact-form form {
      display: flex;
      flex-direction: column;
      max-width: 400px;
      margin: 0 auto;
  }

  #contact-form input,
  #contact-form textarea {
      margin-bottom: 10px;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
      font-size: 16px;
      font-family: 'Signika Negative', sans-serif;
  }

  #contact-form textarea {
      resize: vertical;
      height: 150px;
  }

  #contact-form button {
      background-color: #1034A6;
      color: #fff;
      border: none;
      padding: 12px 20px;
      border-radius: 5px;
      font-size: 16px;
      cursor: pointer;
      transition: background-color 0.3s ease;
  }

  #contact-form button:hover {
      background-color: #1e90ff;
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
      display: none;
    }

  </style>
</head>
<body>
<header>
  <div class="top-content">
    <h1><img src="img/logo.png"></h1>
    <h2><i>A Higher Quality of Living.</i></h2>
  </div>
</header>
<section class="site">
  <nav>
    <ul>
      <li class= "house"><a href="index.php"><i class="fas fa-home"></i></a></li>
      <li><a href="maintenancereq.php">Maintenance</a></li>
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
        <h2>ANNOUNCEMENT</h2>
    </div>
    <?php
      if ($announcement_result) {
        $count = 0; // Initialize a counter
    
        while ($row = mysqli_fetch_assoc($announcement_result)) {
            if ($count % 2 === 0) {
                echo '<div class="announcement">';
            }
    
            $announcementTitle = $row['announcement'];
            $announcementContent = $row['content'];
            $announcementImage = $row['image'];
    
            // Generate HTML for each announcement
            echo '<div class="announcement-item">';
            echo '<h3>' . $announcementTitle . '</h3><hr><br>';
            
            // Display the image if it's available
            if (!empty($announcementImage)) {
                echo '<img src="data:image/jpeg;base64,' . base64_encode($announcementImage) . '" alt="' . $announcementTitle . '" height="300" width="300">';
            }
            
            echo '<p>' . $announcementContent . '</p>';
            echo '</div>';
    
            $count++;
    
            if ($count % 2 === 0) {
                echo '</div>'; // Close the announcement div for this row
            }
        }
    
        if ($count % 2 !== 0) {
            echo '</div>'; // Close the announcement div for the last row if there's an odd number of announcements
        }
    
        // Free the result set
        mysqli_free_result($announcement_result);
    } else {
        echo "Error retrieving announcements: " . mysqli_error($connection);
    }
    ?>
  <div class="mid-content">
    <div class="title">
      <h1>Dashboard</h1>
    </div>
    <div class="dashboard-item">
      <i class="fa-solid fa-file-invoice"></i>
      <h2>Invoice</h2>
      <hr>
      <?php 
        if ($result->num_rows > 0) {
            $amountGreaterThanZero = false; // Initialize a variable to track if amount > 0

            while ($row = $result->fetch_assoc()) {
                $resident_id = $row["resident_id"];
                $type = $row["type"];
                $amount = $row["amount"];
                $release_date = $row["release_date"];
                $due_date = $row["due_date"];

                if ($amount > 0) {
                    $amountGreaterThanZero = true; // Set the flag if amount > 0
                    echo '<table>';
                    echo '<tr><th>Resident ID</th><th>Payment Towards</th><th>Amount</th><th>Release Date</th><th>Due Date</th></tr>';
                    echo '<tr>';
                    echo '<td>' . $resident_id . '</td>';
                    echo '<td>' . $type . '</td>';
                    echo '<td>' . $amount . '</td>';
                    echo '<td>' . $release_date . '</td>';
                    echo '<td>' . $due_date . '</td>';
                    echo '</tr>';
                    echo '</table>';
                    echo '<button type="submit" id="pay" name="btnPay" onclick="goToPay()">Pay Now</button>';
                }
            }

            if ($amountGreaterThanZero = false) {
              echo '<p>Nothing to pay, hurray!!</p>';
            }
        } 
        ?>

    </div>
    <div class="dashboard-item">
      <i class="fa-solid fa-envelope"></i>
      <h2>Messages</h2>
      <hr>
      <div class="message-box" onclick="goToChat()">
        <p><?php echo $latestMessage; ?><br><small><strong><?php echo $latestUsername; ?></strong> (<?php echo $latestTimestamp; ?>)</small></p>
      </div>
    </div>
    <div class="dashboard-item">
        <i class="fa-solid fa-calendar-alt"></i>
        <h2>Upcoming Events</h2>
        <hr>
        <?php if (count($upcomingEvents) > 0) : ?>
            <?php foreach ($upcomingEvents as $event) : ?>
                <div class="upcoming-event">
                    <p><strong>Facility:</strong> <?php echo $event['facilityname']; ?></p>
                    <p><strong>Unit No:</strong> <?php echo $event['unit_no']; ?></p>
                    <p><strong>Name:</strong> <?php echo $event['name']; ?></p>
                    <p><strong>Booking Date:</strong> <?php echo $event['bookingdate']; ?></p>
                    <p><strong>Number of Pax:</strong> <?php echo $event['numberofpax']; ?></p>
                    <p><strong>Slot Availability:</strong> <?php echo $event['slotavailability']; ?></p>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
          <div class="no-event" onclick="goToEvent()">
            <p>No upcoming event. Book Now!</p>
          </div>
        <?php endif; ?>
    </div>
  </div>
</section>
<a href="chat.php#latest_message" class="fixed-button">
<i class="fa-regular fa-comment"></i>
</a>
<div class="bot-content">
  <div class="bot-image">
    <img src="img/logo.png" class="" alt="Image" />
  </div>
  <div class="" id="bot-content1">
    <p>Address: 123 Main Street, City, Country</p>
    <p>Contact Number: +1 234 567 890</p>
    <p>Email: beekinee_admin@condogrp.com</p>
    <br>
    <br>
    <hr>
    <p>Follow Us for more details: </p>
    <i class="fa-brands fa-facebook"></i>&emsp;
    <i class="fa-brands fa-twitter"></i>&emsp;
    <i class="fa-brands fa-instagram"></i>&emsp;
    <i class="fa-brands fa-whatsapp"></i>
  </div>
  <div id="contact-form">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <input type="text" name="txtName" placeholder="Your Name" required>
            <input type="email" name="txtEmail" placeholder="Your Email" required>
            <textarea name="txtMessage" placeholder="Your Message" required></textarea>
            <button type="submit" name="btnSubmit">Submit</button>
        </form>
    </div>
    <div class="" id="bot-content2">
      <p>"Your Comfort, Our Priority – BEEKINEE Condominium Management System."</p>
    </div>
  <div class="footer">
    <div class="footer-content">
      <p>&copy; 2023 BEEKINEE. All rights reserved.</p>
    </div>
    <div class="footer-content1">
      <a href="license.php">License</a>
      <a href="term.php">Term of Service</a>
      <a href="privacypolicy.php">Privacy Policy</a>
    </div>
  </div>
</div>

<script>
  window.addEventListener('scroll', function() {
    var header = document.querySelector('header');
    var nav = document.querySelector('nav');
    var currentScrollY = window.scrollY;
    var headerHeight = header.offsetHeight;

    header.style.transform = 'translateY(' + (currentScrollY /1) + 'px)';
    header.style.opacity = 1.4 - (currentScrollY / 400);

    var opacity = Math.min(1, currentScrollY / headerHeight);

    nav.style.backgroundColor = 'rgba(16, 52, 166, ' + opacity + ')';

    if (currentScrollY >= window.innerHeight) {
      nav.style.position = 'fixed';
      nav.style.top = '0';
    } else {
      nav.style.position = 'absolute';
      nav.style.top = 'calc(100vh - 50px)';
    }
  });

  function goToChat() {
  window.location.href = "chat.php#latest_message";
}

  function goToEvent() {
  window.location.href = "facilities&event.php";
}
  function goToPay() {
  window.location.href = "UserWalletVeri.php";
}
</script>
</body>
</html>
