<?php
include ('dbConn.php'); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Resident Feedback</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/4e1d1789bb.js" crossorigin="anonymous"></script>
    <style>

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .background-image {
            background-image: url(img/adminbg.png);
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-position: center;
    background-size: cover;
    background-size: 100%;
        }

        .container {
            background-color: #fff;
            border-radius: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            padding: 20px;
            margin: 20px;
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

    /* Additional CSS for table layout */
    table {
        margin: 40px 50px 0 50px;
        width: 90%;
        border-collapse: collapse;
    }

    th, td {
        padding: 10px;
        border: 1px solid #000;
    }

    th {
        background-color: #f2f2f2;
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
<body class="background-image">
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
    <main>
        <div class="container">
            <?php
            $query = "SELECT * FROM user_contactustable";
            $result = mysqli_query($connection, $query);
            ?>
            <br>
            <br>
            <h1 id="customer-details"><center>Customer Feedback</center></h1>
            <table>
                <tr>
                    <th>Name</th>
                    <th>Unit Number</th>
                    <th>Email</th>
                    <th>Feedback Message</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['name'] . "</td>";
                    echo "<td>" . $row['unit_no'] . "</td>";
                    echo "<td>" . $row['email'] . "</td>";
                    echo "<td>" . $row['message'] . "</td>";
                    echo "<td><a href='editfeedbackmessage.php?edit_id1=" . urlencode($row['message']) .
    "' onclick='return confirm(\"Are you sure you want to edit this resident's feedback?\")'>Edit</a></td>";
    echo "<td><a href='viewfeedbackmessage.php?delete_id1=" . urlencode($row['message']) . 
    "' onclick='return confirm(\"Are you sure you want to delete this feedback message?\")' style='color: red;'>Delete</a></td>";
                    echo "</tr>";
                }

                if (isset($_GET['delete_id1'])) {
                    $message = $_GET['delete_id1'];
                    $query2 = "DELETE FROM `user_contactustable` WHERE `message` = ?";
                    $stmt = mysqli_prepare($connection, $query2);
                    mysqli_stmt_bind_param($stmt, "s", $message);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_close($stmt);
                    
                    echo "<script>
                        var row = document.querySelector('[data-message-id=\"" . $message . "\"]');
                        row.parentNode.removeChild(row);
                        </script>";
                }
                ?>
            </table>
        </div>
    </main>
    <footer>
        <p>&copy; 2023 BEEKINEE Admin. All rights reserved.</p>
    </footer>
</body>
<script>
function deleteFeedback(message_id) {
    if (confirm("Are you sure you want to delete this feedback message?")) {
        fetch('deletefeedbackmessage.php?delete_id1=' + encodeURIComponent(message_id))
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    var row = document.querySelector('[data-message-id="' + message_id + '"]');
                    if (row) {
                        row.parentNode.removeChild(row);
                    }
                } else {
                    alert('Failed to delete feedback message. Please try again later.');
                }
            })
            .catch(error => {
                alert('An error occurred while trying to delete the feedback message.');
                console.error(error);
            });
    }
}
</script>
</html>
