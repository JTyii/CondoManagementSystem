<?php
include('dbConn.php');

if (isset($_GET['delete_id'])) {
  $booking_id = $_GET['delete_id'];
  $query = "DELETE FROM user_bookingtable WHERE `booking_id` = ?";
  $stmt = mysqli_prepare($connection, $query);
  mysqli_stmt_bind_param($stmt, "i", $booking_id);
  mysqli_stmt_execute($stmt);

  // Check for errors
  if (mysqli_stmt_error($stmt)) {
      die("Error: " . mysqli_stmt_error($stmt));
  }

  mysqli_stmt_close($stmt);

  // Redirect to the same page after deletion
  header("Location: admin_managereservationtickets.php");
  exit();
}


// Get users' booking information
$query = "SELECT * FROM user_bookingtable";
$result = mysqli_query($connection, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Reservation Tickets</title>
    <script src="https://kit.fontawesome.com/4e1d1789bb.js" crossorigin="anonymous"></script>
</head>
<style>
    .background-image {
        background-image: url(img/adminbg.png);
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-position: center;
    background-size: cover;
    background-size: 100%;
    }

    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f1f1f1;
    }

    .container {
        background-color: #fff;
        border-radius: 20px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        padding: 20px;
        margin-top: 50px;
        margin-left: 70px;
        margin-right: 70px;
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

table {
        border-collapse: collapse;
        width: 100%;
        margin-top: 20px;
    }

    th, td {
        padding: 10px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    th {
        background-color: #f2f2f2;
        color: #333;
    }

    tr:hover {
        background-color: #f5f5f5;
    }

    /* Style for the "Edit" and "Delete" links */
    a {
        text-decoration: none;
        color: #1e90ff;
    }

    a:hover {
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
        <h1>Manage Reservation Tickets</h1>
        <table>
            <tr>
                <th>Facility Name</th>
                <th>Unit Number</th>
                <th>Name</th>
                <th>Booking Date</th>
                <th>Slots</th>
                <th>Number of Pax</th>
                <th>Modify</th>
                <th>Delete</th>
            </tr>
            <?php
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['facilityname'] . "</td>";
                echo "<td>" . $row['unit_no'] . "</td>";
                echo "<td>" . $row['name'] . "</td>";
                echo "<td>" . $row['bookingdate'] . "</td>";
                echo "<td>" . $row['slots'] . "</td>";
                echo "<td>" . $row['numberofpax'] . "</td>";
                echo "<td><a href='edit_reservation.php?edit_id=" . ($row['booking_id'] ?? '') . "'>Modify</a></td>";
                echo "<td><a href='admin_managereservationtickets.php?delete_id=" . ($row['booking_id'] ?? '') . "' onclick='return confirm(\"Are you sure you want to delete this reservation ticket?\")'>Delete</a></td>";
                echo "</tr>";
            }
            ?>
        </table>
    </div>
</main>
<footer>
        <p>&copy; 2023 BEEKINEE Admin. All rights reserved.</p>
    </footer>
</body>
</html>
