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

if (isset($_POST['Submit'])) {
    $unit_no = $_POST['unitno'];
    $date = $_POST['date'];
    $category = $_POST['category'];
    $description = $_POST['description'];

    $query = "INSERT INTO `user_maintenancetable`(`username`, `unit_no`, `date`, `category`, `description`) VALUES ('$username','$unit_no','$date','$category','$description')";
    
    if (mysqli_query($connection, $query)) {
        // Insert maintenance request submitted notification
        $maintenance_notification = "Maintenance Request submitted.";

        // Get user ID to create a unique notification table
        $get_user_id_query = "SELECT resident_id FROM `usertable` WHERE `username`='$username'";
        $result = mysqli_query($connection, $get_user_id_query);

        if ($row = mysqli_fetch_assoc($result)) {
            $user_id = $row['resident_id'];
            $notification_table = "notifications_user_" . $user_id;

            $insert_maintenance_notification_query = "INSERT INTO `$notification_table` (notification, date) VALUES (?, NOW())";

            $stmt_maintenance_notification = mysqli_prepare($connection, $insert_maintenance_notification_query);

            if ($stmt_maintenance_notification) {
                mysqli_stmt_bind_param($stmt_maintenance_notification, "s", $maintenance_notification);

                if (mysqli_stmt_execute($stmt_maintenance_notification)) {
                    echo "<script>alert('Maintenance Request Submitted!'); window.location='index.php';</script>";
                } else {
                    echo "Error inserting maintenance notification: " . mysqli_error($connection);
                }

                mysqli_stmt_close($stmt_maintenance_notification);
            } else {
                echo "Error preparing maintenance notification statement: " . mysqli_error($connection);
            }
        } else {
            echo "Error retrieving user ID. Please try again.";
        }

        mysqli_close($connection);
    } else {
        echo "Error submitting your maintenance details. Please try again";
    }
}
?>
<!DOCTYPE html>
<html>
  <head>
      <meta charset="utf-8" />
      <link rel="stylesheet" type="text/css" href="css/maintenancereq.css">
      <script
          src="https://kit.fontawesome.com/4e1d1789bb.js"
          crossorigin="anonymous"
      ></script>
      <link rel="preconnect" href="https://fonts.googleapis.com">
	    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	    <link href="https://fonts.googleapis.com/css2?family=Signika+Negative&display=swap" rel="stylesheet">
      <title>Maintenance Request Page</title>
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
      align-items: center;
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
      padding: 40px;
      margin-top: auto;
      text-align: center;
      margin-bottom: 20px;
      border-radius: 9px;
    }
    
    form {
      border: solid black 2px;
      padding: 50px 40px 100px 40px;
      border-radius: 12px;
      box-shadow: 0 0 20px rgb(0, 0, 0);
      width: 650px;
      height: 100vh;
      margin-left: auto;
      margin-right: auto;
      margin-top: 100px;
      margin-bottom: 100px;
      align-items: center;
      text-align: center;
      background-color: rgba(255, 255, 255, 0.8);
      font-size: 18px;
    }
    
    #category {
      margin-bottom: 2%;
      width: 45%;
      height: 4vh;
      text-align: center;
      border-radius: 4px;
    }

    label {
      font-weight: bold;
      display: block;
      width: 70%;
      padding: 8px;
      margin-bottom: 15px;
      text-align: center;
      align-items: center;
      margin-left: auto;
      margin-right: auto;
    }

    input {
      display: block;
      width: 70%;
      border: 1px solid #ccc;
      border-radius: 12px;
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
      margin-bottom: 15px;
      margin-left: auto;
      margin-right: auto;
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

    button {
      background-color: red;
      width: 50%;
      height: 50px;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 12px;
      color: white;
      font-family: 'Signika Negative', sans-serif;
      font-size: 18px;
      transition: background-color 0.3s ease; /* Add transition for smooth effect */
    }

    button:hover {
        background-color: darkred; /* Set the new background color for hover state */
        cursor: pointer;
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
  </head>
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
  <form class="form-box" method="POST">
      <h1>Maintenance Requests</h1>

      <label for="unitno">Unit No:</label>
      <input type="text" id="unitno" name="unitno" required />

      <label for="date">Date:</label>
      <input type="date" id="date" name="date" required />

      <label for="category">Category:</label>
      <select id="category" name="category" required>
          <option value="" disabled selected>Select a category</option>
          <option value="filters">Filters Change</option>
          <option value="testsmokedetectors">Test Smoke & Carbon Monoxide Detectors</option>
          <option value="facilitiesissues">Facilities Issues</option>
          <option value="ventpipe">Vent Pipe Cleaning</option>
          <option value="others">Others</option>
      </select>

      <label for="description">Description:</label>
      <textarea id="description" name="description" rows="4" required></textarea>

      <input type="submit" name="Submit" value="Submit" />
      <button type="button" onclick="goToHistory()">Track My Maintenance Request</button>
  </form>
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
</body>
<script>
  function goToHistory(){
    window.location.href="trackmaintenancereq.php";
  }
</script>
</html>
