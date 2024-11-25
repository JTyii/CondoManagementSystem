<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Condo User Reports</title>
    <script src="https://kit.fontawesome.com/4e1d1789bb.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300&display=swap" rel="stylesheet">
    <style>
        /* Basic styling for the report page */

        body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;}

        .background-image {
            background-image: url(img/adminbg.png);
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-position: center;
            background-size: cover;
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

        main {
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 50px;
        }

        .navigate {
            position:fixed;
            margin-top: 30px;

            display: inline-block;
            padding: 10px 20px;
            width:auto;
            background-color: #fff;
            color: #1e90ff;
            border: 2px solid #1e90ff;
            border-radius: 20px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .navigate:hover {
            background-color: #1e90ff;
            color: #fff;
        }

        .report-wrapper {
            margin-bottom: 20px;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            text-align: center;
            width: 80%;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px; /* Adjust margin-top */
        }

        th, td {
            border: 1px solid #333;
            padding: 5px; /* Adjust padding */
        }

        th {
            background-color: #666;
            color: #fff;
            font-weight: bold;
            font-size: 14px; /* Adjust font size */
        }

        td {
            font-size: 12px; /* Adjust font size */
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
<div class="navigate-button">
        <a href="maintenance_report.php" class="navigate"><i class="fa-solid fa-left-long"></i>  Maintenance Report</a>
    </div>
<main>

    <div class="report-wrapper">
        <section class="report">
            <h2>Total Users:</h2>
            <?php
            include("dbConn.php"); // Include your database connection

            $totalUsersQuery = "SELECT COUNT(*) AS total_users FROM usertable";
            $result = mysqli_query($connection, $totalUsersQuery);
            $row = mysqli_fetch_assoc($result);

            $totalUsers = $row['total_users'];

            echo "<p>Total number of users: $totalUsers</p>";
            ?>
        </section>
    </div>

    <div class="report-wrapper">
        <section class="report">
            <h2>User Accounts:</h2>
            <?php
            $userAccountsQuery = "SELECT * FROM usertable";
            $result = mysqli_query($connection, $userAccountsQuery);
            ?>

            <table>
                <tr>
                    <th></th>
                    <th>Username</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Unit Number</th>
                    <th>Password</th>
                    <th>Action</th>
                </tr>
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    $userID = $row['resident_id'];
                    $username = $row['username'];
                    $fname = $row['fname'];
                    $lname = $row['lname'];
                    $email = $row['email'];
                    $unitno = $row['unit_no'];
                    $password = $row['password'];
                    echo "<tr>
                            <td>$userID</td>
                            <td>$username</td>
                            <td>$fname</td>
                            <td>$lname</td>
                            <td>$email</td>
                            <td>$unitno</td>
                            <td>$password</td>
                            <td><a href='delete_user.php?id=$userID'>Delete</a></td>
                          </tr>";
                }
                ?>
            </table>
        </section>
    </div>

    <div class="report-wrapper">
        <section class="report">
            <h2>Occupancy Status:</h2>
            <?php
            $totalUnits = 1000; // Total number of units in the condominium
            $occupiedUnitsQuery = "SELECT COUNT(DISTINCT unit_no) AS occupied_units FROM usertable";
            $result = mysqli_query($connection, $occupiedUnitsQuery);
            $row = mysqli_fetch_assoc($result);

            $occupiedUnits = $row['occupied_units'];
            $vacantUnits = $totalUnits - $occupiedUnits;

            echo "<p>Total Units: $totalUnits</p>";
            echo "<p>Occupied Units: $occupiedUnits</p>";
            echo "<p>Vacant Units: $vacantUnits</p>";
            ?>
        </section>
    </div>
</main>

<footer>
    <p>&copy; 2023 BEEKINEE Admin. All rights reserved.</p>
</footer>
</body>
</html>
