<?php 
include "dbConn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $event = $_POST["event"];
    $description = $_POST["description"];
    $date = $_POST["date"];
    
    // Image upload handling
    $image = $_FILES["image"]["tmp_name"];
    if (!empty($image)) {
        $image_data = file_get_contents($image);
        $image_type = $_FILES["image"]["type"];
        if ($image_type == "image/jpeg" || $image_type == "image/png") {
            $image_data = mysqli_real_escape_string($connection, $image_data);
        } else {
            echo "Invalid image format. Please upload a JPEG or PNG image.";
            exit;
        }
    } else {
        $image_data = null;
    }
    
    // Insert event data into the database
    $sql = "INSERT INTO admin_createevent (event, description, date, image) VALUES ('$event', '$description', '$date', '$image_data')";
    if (mysqli_query($connection, $sql)) {
        echo "Event created successfully.";
    
        // Send notifications to users
        $message = "New event created: $event";
    
        $get_all_users_query = "SELECT resident_id FROM usertable";
        $users_result = mysqli_query($connection, $get_all_users_query);
    
        while ($user_row = mysqli_fetch_assoc($users_result)) {
            $user_id = $user_row['resident_id'];
            $notification_table = "notifications_user_" . $user_id;
    
            $insert_notification_query = "INSERT INTO $notification_table (notification, date) VALUES (?, NOW())";
            $stmt_notification = $connection->prepare($insert_notification_query);
    
            if ($stmt_notification) {
                $stmt_notification->bind_param("s", $message);
                $stmt_notification->execute();
                $stmt_notification->close();
            }
        }
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($connection);
    }    
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Events</title>
    <script src="https://kit.fontawesome.com/4e1d1789bb.js" crossorigin="anonymous"></script>
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

    .center-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh; 
        }

        h2 {
            text-align: center;
            margin-top: 30px;
        }

        form {
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 20px;
        }

        label {
            font-weight: bold;
        }

        input[type="text"],
        textarea,
        input[type="date"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        textarea {
            resize: vertical;
            height: 100px;
        }

        input[type="submit"] {
            background-color: #1033a6;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #1e90ff;
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
    <div class="center-container">
        <form action="" method="POST" enctype="multipart/form-data"> 
        <h2>Create Event</h2>
        <label for="event">Event:</label>
        <input type="text" name="event" id="event" required><br><br>

        <label for="description">Description:</label><br>
        <textarea name="description" id="description" rows="4" cols="50" required></textarea><br><br>

        <label for="date">Date:</label>
        <input type="date" name="date" id="date" required><br><br>

        <label for="image">Image:</label>
        <input type="file" name="image" id="image" accept="image/*"><br><br>

        <input type="submit" value="Create Event">
        </form>
    </div>
    <footer>
        <p>&copy; 2023 BEEKINEE Admin. All rights reserved.</p>
    </footer>
</body>
</html>