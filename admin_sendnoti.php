<?php
include('dbConn.php');


$successMessage = ""; 
// Check if the form is submitted
if (isset($_POST['submitBtn'])) {
    $notification = $_POST['notification'];
    $target_users = $_POST['target_users'];

    if ($target_users == 'all') {
        // Get all user IDs from the usertable
        $user_ids = [];
        $get_user_ids_query = "SELECT resident_id FROM usertable";
        $result = mysqli_query($connection, $get_user_ids_query);
        while ($row = mysqli_fetch_assoc($result)) {
            $user_ids[] = $row['resident_id'];
        }

        // Insert notifications for each user
        foreach ($user_ids as $user_id) {
            $insert_notification_query = "INSERT INTO notifications_user_$user_id (notification, date) VALUES ('$notification', NOW())";
            mysqli_query($connection, $insert_notification_query);
        }

        $successMessage = "Notifications sent successfully.";
    } elseif ($target_users == 'single') {
        // Get the selected user's ID
        $selected_user_id = $_POST['selected_user'];

        // Insert notification into the selected user's notification table
        $insert_notification_query = "INSERT INTO notifications_user_$selected_user_id (notification, date) VALUES ('$notification', NOW())";
        mysqli_query($connection, $insert_notification_query);

        $successMessage = "Notifications sent successfully.";
    }
}

// Get all user IDs and usernames for the dropdown
$get_users_query = "SELECT resident_id, username FROM usertable";
$users_result = mysqli_query($connection, $get_users_query);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/4e1d1789bb.js" crossorigin="anonymous"></script>
    <title>Admin Notifications</title>
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

    .success-message {
            background-color: #4CAF50; /* Green color */
            color: white;
            padding: 10px;
            text-align: center;
            border-radius: 5px;
            margin-top: 20px;
            display: <?php echo $successMessage ? 'block' : 'none'; ?>; /* Show only if there's a success message */
        }


        .container {
            position:relative;
            max-width: 800px;
            margin: 60px 350px;
            border-radius: 10px;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-top: 10px;
        }

        select, textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        select[multiple] {
            height: auto;
        }

        input[type="submit"] {
            background-color: #3498db;
            border: none;
            color: white;
            padding: 10px 20px;
            font-size: 18px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-left: 300px;
        }

        input[type="submit"]:hover {
            background-color: #2980b9;
        }

        footer {
        position: absolute;
        bottom: 0;
        width: 98%;
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
    <div class="container">
        <h1>Admin Notifications</h1>
        <form action="admin_sendnoti.php" method="POST" id="notificationForm">
            <label for="target_users">Target Users:</label>
            <select name="target_users" id="target_users">
                <option value="all">All Users</option>
                <option value="single">Single User</option>
            </select>
            <label for="selected_user">Select User:</label>
            <select name="selected_user" id="selected_user" disabled>
                <?php
                if ($users_result && mysqli_num_rows($users_result) > 0) {
                    while ($user_row = mysqli_fetch_assoc($users_result)) {
                        echo '<option value="' . $user_row['resident_id'] . '">' . $user_row['username'] . '</option>';
                    }
                }
                ?>
            </select>

            <label for="notification">Notification:</label>
            <textarea name="notification" id="notification" cols="30" rows="5" required></textarea>
            <div class="success-message">
                <?php echo $successMessage; ?>
            </div>
            <br>
            <input type="submit" name="submitBtn" value="Send Notifications">
        </form>
    </div>
    <footer>
        <p>&copy; 2023 BEEKINEE Admin. All rights reserved.</p>
    </footer>
</body>
<script>
    const targetUsers = document.getElementById('target_users');
    const selectedUser = document.getElementById('selected_user');

    targetUsers.addEventListener('change', function() {
        if (targetUsers.value === 'all') {
            selectedUser.disabled = true;
        } else if (targetUsers.value === 'single') {
            selectedUser.disabled = false;
        }
    });
</script>
</html>

