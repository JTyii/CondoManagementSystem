<?php
include "dbConn.php"; // Include your database connection script

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $announcementTitle = $_POST['announcementTitle'] ?? '';
    $announcementContent = $_POST['announcementContent'] ?? '';
    $announcementImage = $_FILES['announcementImage']['tmp_name'] ?? '';

    if (!empty($announcementTitle) && !empty($announcementContent)) {
        $query = "INSERT INTO `admin_createannouncement` (`announcement`, `content`, `time`, `image`) VALUES (?, ?, NOW(), ?)";
        $stmtInsert = $connection->prepare($query);
        $stmtInsert->bind_param("sss", $announcementTitle, $announcementContent, $announcementImage);

        if ($stmtInsert->execute()) {
            echo '<script>alert("Announcement Created Successfully!");</script>';

            // Send notifications to users about the new announcement
            $message = "New announcement: $announcementTitle";
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
            echo '<script>alert("Error creating announcement. Please try again.");</script>';
        }
    } else {
        echo '<script>alert("Please fill in all fields.");</script>';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/4e1d1789bb.js" crossorigin="anonymous"></script>
    <title>Create Announcement</title>
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


        .container {
            max-width: 600px;
            height: 400px;
            margin-top: 50px;
            margin-left: 30%;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 20px;
        }

        form {
            margin-bottom: 100px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
        }

        input[type="text"],
        textarea {
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

        input[type="file"] {
            margin-top: 10px;
        }

        button[type="submit"] {
            background-color: #1033a6;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
        }

        button[type="submit"]:hover {
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
            <div class="container">
                <h1>Create Announcement</h1>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
                    <label for="announcementTitle">Title:</label>
                    <input type="text" name="announcementTitle" required>
                    <label for="announcementContent">Content:</label>
                    <textarea name="announcementContent" rows="4" required></textarea>
                    <label for="image">Image:</label>
                    <input type="file" name="announcementImage" id="image" accept="image/*">
                    <button type="submit" name="btnCreateAnnouncement">Create Announcement</button>
                </form>
            </div>
    <footer>
        <p>&copy; 2023 BEEKINEE Admin. All rights reserved.</p>
    </footer>
</body>
</html>
