<?php
include "dbConn.php";

session_start();
$username = $_SESSION['username'];

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
    <title>Resident Chat</title>
    <style>
        body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-image: url(img/adminbg.png);
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-position: center;
    background-size: cover;
    background-size: 100%;
    }

        header {
        background-color: #1033a6;
        color: #fff;
        padding: 20px;
    }

    header h1 {
        margin: 0;
        display: flex;
        align-items: center;
    }

    nav {
        display: flex;
        align-items: center;
    }

    nav ul {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        align-items: center;
    }

    nav li {
        margin-left: 30px;
    }

    nav a {
        text-decoration: none;
        color: #fff;
        font-weight: bold;
        font-size: 18px;
        transition: color 0.3s ease;
    }

    nav a:hover {
        color: #1e90ff;
    }

    .logout {
        margin-left: auto;
    }

    .logout a {
        text-decoration: none;
        color: #fff;
        font-size: 18px;
        transition: color 0.3s ease;
    }

    .logout a:hover {
        color: red;
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

    .admin-username {
        color: red;
        font-weight: bold;
    }

        .delete-button {
    cursor: pointer;
    background-color: #ff5c5c;
    color: #fff;
    border: none;
    padding: 8px 16px;
    border-radius: 5px;
    font-size: 1em;
    transition: background-color 0.3s ease;
  }

  .delete-button:hover {
    background-color: #e62e2e;
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


        footer {
        position: fixed;
        bottom: 0;
        width: 100%;
        background-color: #1033a6;
        color: #fff;
        padding: 10px;
        text-align: center;
    }

    footer p {
        margin: 0;
    }
        </style>
</head>
<body>
<header>
<nav>
            <h1>Admin</h1>
            <ul>
                <li><a href="admin_main.php"><i class="fa-solid fa-home"></i></a></li>
                <li><a href="viewsecuritypersonnel.php">Security</a></li>
                <li><a href="admin_thirdpartysecurity.php">Third Party Services</a></li>
                <li><a href="admin_chat.php">Chat</a></li>
                <li><a href="viewfeedbackmessage.php">Feedbacks</a></li>
                <li><a href="admin_managereservationtickets.php">Reservations</a></li>
                <li><a href="admin_createevents.php">Events</a></li>
                <li><a href="admin_sendnoti.php">Notifications</a></li>
                <li><a href="admin_announcement.php">Announcements</a></li>
                <li><a href="visitorhistory.php">Visitors</a></li>
                <div class="logout">
                    <li><a href="login.php">Logout&emsp;<i class="fa-solid fa-right-from-bracket"></i></a></li>
                </div>
                <li><a href="editadminprofile.php"><i class="fa-solid fa-user-pen"></i></a></li>
            </ul>
        </nav>
    </header>
    <br>
    <br>
    <center><h2>Admin Chat</h2></center>
    <div class="chat-container">
    <?php
    for ($i = 0; $i < count($messages); $i++) {
        $messageId = $messages[$i]['message_id']; // Get the message ID
        echo '<div class="message-container' . ($i === count($messages) - 1 ? ' latest-message' : '') . '">';
        echo '<p>';

        if ($messages[$i]['username'] === 'ADMIN') {
            echo '<i class="fa-solid fa-lock"></i>';
            echo '<span class="admin-username">' . $messages[$i]['username'] . '</span>';
        } else {
            echo '<i class="fa-solid fa-user"></i>';
            echo '<span>' . $messages[$i]['username'] . '</span>';
        }

        echo '<hr><br>' . $messages[$i]['text'] . '<span class="timestamp">' . $messages[$i]['timestamp'] . '</span><span class="reply-icon" onclick="showReplyBox(' . $i . ')"><i class="fa-solid fa-reply"></i></span>';
        echo '<button class="delete-button" onclick="deleteMessage(' . $messageId . ')">Delete</button>';
        echo '</p>';
        echo '</div>';
    }
    ?>
</div>
    <div class="input-container">
        <input type="text" method="POST" id="message-input" placeholder="Type your message..." onkeypress="handleKeyPress(event)" />
        <i class="fa-solid fa-paper-plane" id="send-button" onclick="sendMessage()"></i>
    </div>

    <footer>
        <p>&copy; 2023 BEEKINEE Admin. All rights reserved.</p>
    </footer>
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

    function showReplyBox(messageIndex) {
        var replyBox = document.createElement('div');
        replyBox.classList.add('reply-box');

        var replyInput = document.createElement('input');
        replyInput.type = 'text';
        replyInput.placeholder = 'Type your reply...';

        var sendButton = document.createElement('i');
        sendButton.classList.add('fa-solid', 'fa-paper-plane', 'send-reply');
        sendButton.setAttribute('onclick', 'sendReply(' + messageIndex + ')');

        replyBox.appendChild(replyInput);
        replyBox.appendChild(sendButton);

        var messageContainer = document.getElementsByClassName('message-container')[messageIndex];
        messageContainer.appendChild(replyBox);

        if (replyBoxIndex !== -1) {
            var previousReplyBox = document.getElementsByClassName('reply-box')[replyBoxIndex];
            previousReplyBox.style.display = 'none';
        }

        replyBoxIndex = messageIndex;
    }

    function sendReply(messageIndex) {
        var replyInput = document.getElementsByClassName('reply-box')[messageIndex].getElementsByTagName('input')[0];
        var replyMessage = replyInput.value;

        replyInput.value = '';

        var replyBox = document.getElementsByClassName('reply-box')[messageIndex];
        replyBox.style.display = 'none';

        replyBoxIndex = -1;
    }
    function handleKeyPress(event) {
        if (event.key === "Enter") {
            sendMessage();
        }
    }
    
    function sendMessage() {
            var messageInput = document.getElementById('message-input');
            var message = messageInput.value.trim();

            if (message !== '') {
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState === 4 && this.status === 200) {
                        location.reload(); 
                    }
                };
                xhttp.open("POST", "", true);
                xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhttp.send("message=" + encodeURIComponent(message));
            }

            messageInput.value = '';
        }

        function deleteMessage(messageId) {
  if (confirm("Are you sure you want to delete this message?")) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
      if (this.readyState === 4 && this.status === 200) {
        location.reload(); 
      }
    };
    xhttp.open("POST", "delete_message.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("message_id=" + encodeURIComponent(messageId));
  }
}

</script>
</html>