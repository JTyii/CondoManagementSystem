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

if (isset($_POST['message'])) {
    $message = $_POST['message'];

    $sql = "INSERT INTO chat (text, username, timestamp) VALUES ('$message', '$username', NOW())";
    $result = mysqli_query($connection, $sql);
}

$sql = "SELECT * FROM chat ORDER BY timestamp ASC";
$result = $connection->query($sql);

$messages = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $messages[] = $row;
    }
}

mysqli_close($connection);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://kit.fontawesome.com/4e1d1789bb.js" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Signika+Negative&display=swap" rel="stylesheet">
    <title>Resident Chat</title>
    <style>
        html, body {
            padding: 0;
            margin: 0;
            height: 100%;
            font-size: 1.3em;
            text-align: center;
            background-color: #f1f1f1;
            align-items: center;
            font-family: 'Signika Negative', sans-serif;
            background-image: url(img/bg.jpg);
            background-repeat: no-repeat;
    background-attachment: fixed;
    background-position: center;
    background-size: cover;
    background-size: 100%;
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

        .title {
      background-color: #333;
      color: #fff;
      text-align: center;
      padding: 10px;
  }

    .chat-container {
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        padding: 10px;
        width: 70%;
        height: 30em;
        margin: 50px auto;
        max-height: 30em;
        overflow-y: auto;
    }

        .message-container {
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: space-between;
    position: relative;
    border: 2px solid black;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
    border-radius: 10px;
    padding: 10px;
    width: 60%;
    margin: 10px;
}
        .admin-username {
        color: red;
        font-weight: bold;
    }

    .message-container .fa-solid.fa-user, .fa-solid.fa-lock{
            margin-right: 10px;
        }

        .timestamp {
        position: absolute;
        bottom: 5px; /* Adjust as needed */
        right: 5px; /* Adjust as needed */
        font-size: 0.8em;
        color: #666;
    }

        .chat-container .message-container {
        /* Ensure each message container maintains proper alignment */
        display: flex;
        flex-direction: column;
        align-items: flex-start; /* Adjust as needed */
    }

    .message-container.current-user {
    float: right;
    background-color: #c8f7c8; /* Light green color */
}
        .message-post {
        margin-bottom: 10px;
        padding-bottom: 10px;
        border-bottom: 1px solid black;
        }

        .message-post p {
        margin: 0;
        padding: 5px 0;
        }

        .message-post .post-info {
        font-weight: bold;
        }

        .input-container {
        position: fixed;
        bottom: 0;
        text-align: center;
        width: 60%;
        margin-top: 10px;
        margin-left: 20%;
        margin-bottom: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #f1f1f1;
        border-radius: 30px;
        border: 2px solid black;
        }

        #message-input {
        font-family: 'Signika Negative', sans-serif;
        width: 80%;
        background-color: #f1f1f1;
        border: none;
        border-radius: 30px;
        height: 60px;
        padding: 10px;
        font-size: 1.2em;
        outline: none;
        }

        .fa-solid.fa-paper-plane {
        cursor: pointer;
        margin-left: 10px;
        font-size: 1.5em;
        color: #1033a6;
        transition: color 0.3s ease;
        }

        .fa-solid.fa-paper-plane:hover {
        color: #1e90ff;
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
    <br>
    <br>
    <div class="title">
        <h2>Resident Chat</h2>
    </div>
    <div class="chat-container">
    <?php
    for ($i = 0; $i < count($messages); $i++) {
        $message = $messages[$i];
        $isCurrentUser = $message['username'] === $username;
    
        echo '<div class="message-container' . ($isCurrentUser ? ' current-user' : '') . ($i === count($messages) - 1 ? ' latest-message' : '') . '">';
    
        echo '<p>';
    
        if ($message['username'] === 'ADMIN') {
            echo '<i class="fa-solid fa-lock"></i>';
            echo '<span class="admin-username">' . $message['username'] . '</span>';
        } else {
            echo '<i class="fa-solid fa-user"></i>';
            echo '<span>' . $message['username'] . '</span>';
        }
    
        echo '<hr><br>' . $message['text'] . '<span class="timestamp">' . $message['timestamp'] . '</span>';
    
        echo '</p>';
        echo '</div>';
    }
    ?>
</div>
    <div class="input-container">
        <input type="text" method="POST" id="message-input" placeholder="Type your message..." onkeypress="handleKeyPress(event)" />
        <i class="fa-solid fa-paper-plane" id="send-button" onclick="sendMessage()"></i>
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
    window.addEventListener('load', function() {
    scrollToLatestMessage();
    });

    function scrollToLatestMessage() {
        var latestMessageElement = document.querySelector('.latest-message');
        if (latestMessageElement) {
            latestMessageElement.scrollIntoView({
                behavior: 'smooth',
                block: 'center',
            });
        }
    }
    var replyBoxIndex = -1;
    
    function sendMessage() {
            var messageInput = document.getElementById('message-input');
            var message = messageInput.value.trim();

            if (message !== '') {
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState === 4 && this.status === 200) {
                        location.reload(); // Optional: You can handle the response from the server here instead of reloading the page.
                    }
                };
                xhttp.open("POST", "", true);
                xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhttp.send("message=" + encodeURIComponent(message));
            }

            messageInput.value = '';
        }

</script>
</html>