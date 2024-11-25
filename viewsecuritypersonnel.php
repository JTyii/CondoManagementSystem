<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Security Personnel List</title>
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

        .signup-button {
            text-align: center;
            margin-top: 20px;
        }

        .signup {
            display: inline-block;
            padding: 10px 20px;
            background-color: #fff;
            color: #1e90ff;
            border: 2px solid #1e90ff;
            border-radius: 10px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .signup:hover {
            background-color: #1e90ff;
            color: #fff;
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
            background-color: #fff;
            border-radius: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            padding: 20px;
            margin: 20px;
            border: 1px solid #ddd;
        }

        h2 {
            text-align: center;
        }

        table {
            margin: 40px 50px 0 50px;
            width: 90%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 10px;
            border: 1px solid #000;
        }

        th {
            background-color: #f2f2f2;
        }

        .edit-link,
        .delete-link {
            text-decoration: none;
            color: #1e90ff;
            margin-left: 25px;
        }

        .edit-link:hover,
        .delete-link:hover {
            color: #1033a6;
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
    <div class="container">
        <table>
            <h2>Security Personnel List</h2>
            <tr>
                <th>Name</th>
                <th>Contact</th>
                <th>Designation</th>
                <th>Email</th>
                <th>Hourly Rate</th>
                <th>Shift</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            <?php
            include "dbConn.php"; // Include your database connection script
            
            $sql = "SELECT * FROM security_personnel";
            $result = $connection->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["name"] . "</td>";
                    echo "<td>" . $row["contact"] . "</td>";
                    echo "<td>" . $row["designation"] . "</td>";
                    echo "<td>" . $row["email"] . "</td>";
                    echo "<td>" . $row["hourly_rate"] . "</td>";
                    echo "<td>" . $row["shift"] . "</td>";
                    echo "<td>" . $row["status"] . "</td>";
                    echo "<td>
                        <a class='edit-link' href='editsecurity.php?id=" . $row['id'] . "'>Edit</a>
                        <a class='delete-link' href='deletesecurity.php?id=" . $row['id'] . "' onclick='return confirm(\"Are you sure you want to delete this security personnel?\")'>Delete</a>
                      </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No data available</td></tr>";
            }

            $connection->close();
            ?>
        </table>
    </div>
    <div class="signup-button">
        <a href="secpersonnelmng.php" class="signup">Register New Security Personnel</a>
    </div>
    <footer>
        <p>&copy; 2023 BEEKINEE Admin. All rights reserved.</p>
    </footer>
</body>

</html>