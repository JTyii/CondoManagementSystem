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

    $query = "SELECT * FROM `usertable` WHERE username = '$username'";
    $result = mysqli_query($connection, $query);

    if(isset($_POST['username']) && isset($_POST['fname']) && isset($_POST['lname']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['unit_no']) && isset($_POST['phone_no']) && isset($_POST['current_password'])) {
        $new_username = $_POST['username'];
        $new_fname = $_POST['fname'];
        $new_lname = $_POST['lname'];
        $new_email = $_POST['email'];
        $new_password = $_POST['password'];
        $new_unit_no = $_POST['unit_no'];
        $new_phone_no = $_POST['phone_no'];
        $current_password = $_POST['current_password'];
        
        $query = "SELECT * FROM `usertable` WHERE username = '$username'";
        $result = mysqli_query($connection, $query);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $stored_password = $row['password'];

            if ($current_password === $stored_password) {
                // Current password matches, proceed with updating the profile
                $update_query = "UPDATE `usertable` SET username='$new_username', fname='$new_fname', 
                lname='$new_lname', email='$new_email', password='$new_password', unit_no='$new_unit_no', phone_no='$new_phone_no' WHERE username='$username'";
                mysqli_query($connection, $update_query);
                echo "<script>alert('Profile has been updated! Please Remember your New Password!');</script>";
                header("Refresh:0");
            } else {
                echo "<script>alert('Incorrect current password. Changes not saved.');</script>";
                header("Refresh:0");
            }
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
  <title>Edit Profile</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Signika+Negative&display=swap" rel="stylesheet">
  <script
  src="https://kit.fontawesome.com/4e1d1789bb.js"
  crossorigin="anonymous"
></script>
<style>
html, body {
  font-family: 'Signika Negative', sans-serif;
  padding: 0;
  margin: 0;
  height: 100%;
  font-size: 1em;
  background-image: url(img/bg.jpg);
  background-repeat: no-repeat;
  background-attachment: fixed;
  background-position: center;
  background-size: cover;
  background-size: 100%;

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

  .container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 140vh;
    width: 900px;
    margin: 100px;
    margin-right: auto;
    margin-left: auto;
    border: solid black 2px;
    border-radius: 12px;
    box-shadow: 0 0 20px rgb(0, 0, 0);
    background-color: rgba(255, 255, 255, 0.8);
  }
  
  hr {
  border-color: black;
}

  .profile-info {
    margin-left: 50px;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 0 20px rgb(0, 0, 0);
    background-color: #90e0ef;
    border: 2px solid black;
    color:black;
    width: 300px;
}

.profile-info img {
    width: 120px;
    border-radius: 50%;
    margin-bottom: 20px;
}

.profile-details {
    text-align: left;
    font-size: 20px;
    font-weight: bold;
    margin-bottom: 20px;
}

.wallet {
  margin-left: 50px;
  margin-top: 30px;
  text-align: center;
}

.wallet button {
  font-size: 25px;
  padding: 10px 20px;
  background-color: #1e90ff;
  color: #fff;
  border: none;
  border-radius: 12px;
  cursor: pointer;
  transition: background-color 0.3s;
}

.wallet button:hover {
  background-color: #1034A6;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.logout-btn {
  margin-left:50px;
  text-align: center;
  margin-top: 20px;
}

.logout-btn button {
    background-color: #F44336;
    color: #fff;
    border: none;
    padding: 12px 24px;
    font-size: 20px;
    border-radius: 12px;
    cursor: pointer;
    transition: background-color 0.3s;
    outline: none;
}

.logout-btn button:hover {
    background-color: #D32F2F;
}

.edit-profile-section {
    position: relative;
    padding: 10px 40px 10px 40px;
    margin: 70px 40px 70px 40px;
    border-left: 5px solid #ccc;
  }

h2 {
margin-bottom: 10px;
}

.edit-profile-section form {
  text-align: center;
}

.edit-profile-section label {
    display: block;
    margin-bottom: 10px;
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

input[type="text"],
input[type="password"] {
width: 100%;
padding: 8px;
margin-bottom: 15px;
border: 1px solid #ccc;
border-radius: 12px;
text-align: center;
}

input[type="submit"] {
width: 90%;
font-size: 18px;
padding: 12px;
margin-left: 15px;
background-color: #1e90ff;
color: #fff;
border: none;
border-radius: 12px;
cursor: pointer;
margin-top: 20px;
}

input[type="submit"]:hover {
background-color:#1034A6;
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
      <div class="container">
        <div class="left-panel">
          <div class="profile-info">
            <center><img src="img/editprofileicon.jpg"></center>
              <div class="profile-details">
                <?php
                if(mysqli_num_rows($result) > 0){
                    while($row = mysqli_fetch_assoc($result)){
                        echo "<center><h1>".$row['fname']." ".$row['lname']."</h1></center>";
                        echo "<center><i>BEEKINEE HEIGHTS RESIDENT</i></center>";
                        echo "<hr>";
                        echo "<br>";
                        echo "<p>Username: ".$row['username']."</p>";
                        echo "<p>Email Address: ".$row['email']."</p>";
                        echo "<p>Unit No: ".$row['unit_no']."</p>";
                        echo "<p>Phone Number: ".$row['phone_no']."</p>";
                        echo "<p>Resident ID: ".$row['resident_id']."</p>";
                    }
                }
                ?>
              </div>
          </div>
          <div class="wallet">
            <button onclick="goToPay()"><i class="fa-solid fa-wallet"></i>  Wallet History</button>
          </div>
          <br>
          <br>
          <div class="logout-btn">
            <button onclick="location.href='login.php'">Log Out</button>
          </div>
        </div>
        <div class="edit-profile-section">
          <center><h1>Edit Profile:</h1></center>
          <hr>
          <?php
            $query = "SELECT * FROM `usertable` WHERE username = '$username'";
            $result = mysqli_query($connection, $query);
            if (mysqli_num_rows($result) > 0) {
              while ($row = mysqli_fetch_assoc($result)) {
                echo "<form action='edituserprofile.php' method='POST'>";
                
                // Populate the input fields with existing user data
                echo "<label for='username'>Username:</label>";
                echo "<input type='text' id='username' name='username' value='" . $row['username'] . "' required>";
                
                echo "<label for='fname'>First Name:</label>";
                echo "<input type='text' id='fname' name='fname' value='" . $row['fname'] . "' required>";
                
                echo "<label for='lname'>Last Name:</label>";
                echo "<input type='text' id='lname' name='lname' value='" . $row['lname'] . "' required>";
                
                echo "<label for='email'>Email Address:</label>";
                echo "<input type='text' id='email' name='email' value='" . $row['email'] . "' required>";

                echo "<label for='current_password'>Current Password:</label>";
                echo "<input type='password' id='current_password' name='current_password' required>";
                
                echo "<label for='password'>New Password:</label>";
                echo "<input type='password' id='password' name='password' required>";
                
                echo "<label for='unit_no'>Unit No:</label>";
                echo "<input type='text' id='unit_no' name='unit_no' value='" . $row['unit_no'] . "' required>";

                echo "<label for='phone_no'>Phone Number:</label>";
                echo "<input type='text' id='phone_no' name='phone_no' value='" . $row['phone_no'] . "' required>";

                
                
                echo "<input type='submit' value='Save Changes'>";
                
                echo "</form>";
              }
            }
          ?>
        </div>
      </div>
  <footer>
        <div class="footer">
          <div class="footer-content">
            <p>&copy; 2023 BEEKINEE. All rights reserved.&emsp;&emsp;</p>
          </div>
          <div class="footer-content1">
            &emsp;<a href="license.php">License</a>&emsp; 
            <a href="term.php">Term of Service</a>&emsp;
            <a href="privacypolicy.php">Privacy Policy</a>
          </div>
        </div>
</footer>
</body>
<script>
   function goToPay(){
    window.location.href="transactionhistory.php";
  }
</script>
</html>
