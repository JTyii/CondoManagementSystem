<?php
include('dbConn.php');

if (isset($_GET['delete_id'])) {
  $booking_id = $_GET['delete_id'];
  $query = "DELETE FROM user_maintenancetable WHERE `maintenance_id` = ?";
  $stmt = mysqli_prepare($connection, $query);
  mysqli_stmt_bind_param($stmt, "i", $booking_id);
  mysqli_stmt_execute($stmt);

  // Check for errors
  if (mysqli_stmt_error($stmt)) {
      die("Error: " . mysqli_stmt_error($stmt));
  }

  mysqli_stmt_close($stmt);

  // Redirect to the same page after deletion
  header("Location: admin_maintenancereq.php");
  exit();
}


// Get users' booking information
$query = "SELECT * FROM user_maintenancetable";
$result = mysqli_query($connection, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Maintenance Request History</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300&display=swap" rel="stylesheet">
</head>
<style>
    .background-image {
        background-image: url(img/bg.jpg);
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-position: center;
        background-size: cover;
    }

    body {
        font-family: 'Roboto', sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f1f1f1;
    }

    .container {
        background-color: #fff;
        border-radius: 5px;
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
        background: #1e90ff;
      color: black;
      font-weight: bold;
      transition: 0.6s;
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
        position: absolute;
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
                <li><a href="secpersonnelmng.php">Security</a></li>
                <li><a href="admin_thirdpartysecurity.php">Third Party Services</a></li>
                <li><a href="admin_chat.php">Chat</a></li>
                <li><a href="viewfeedbackmessage.php">User Feedback</a></li>
                <li><a href="admin_managereservationtickets.php">Reservation Management</a></li>
                <li><a href="admin_createevents.php">Create Events</a></li>
                <li><a href="admin_sendnoti.php">Send Notifications</a></li>
                <div class="logout">
                    <li><a href="login.php">Logout&emsp;<i class="fa-solid fa-right-from-bracket"></i></a></li>
                </div>
            </ul>
        </nav>
    </header>
    <main>
    <div class="container">
        <h1>Admin Maintenance Request History</h1>
        <table>
            <tr>
                <th>Maintenance ID</th>
                <th>Date</th>
                <th>Category</th>
                <th>Description</th>
                <th>Expenses</th>
                <th>Status</th>
                <th>Modify</th>
                <th>Delete</th>
            </tr>
            <?php
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['maintenance_id'] . "</td>";
                echo "<td>" . $row['date'] . "</td>";
                echo "<td>" . $row['category'] . "</td>";
                echo "<td>" . $row['description'] . "</td>";
                echo "<td>" . $row['expenses'] . "</td>";
                echo "<td>" . $row['status'] . "</td>";
                echo "<td><a href='edit_maintenancereq.php?edit_id=" . ($row['maintenance_id'] ?? '') . "'>Modify</a></td>";
                echo "<td><a href='admin_maintenancereq.php?delete_id=" . ($row['maintenance_id'] ?? '') . "' onclick='return confirm(\"Are you sure you want to delete this reservation ticket?\")'>Delete</a></td>";
                echo "</tr>";
            }
            ?>
        </table>
    </div>
</main>
    <footer>
        <p>&copy; 2023 BEEKINEE Admin Dashboard. All rights reserved.</p>
    </footer>
</body>
</html>
