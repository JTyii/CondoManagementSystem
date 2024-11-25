<?php
include "dbConn.php"; // Include your database connection script

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Retrieve updated data from the form
        $name = $_POST["name"];
        $contact = $_POST["contact"];
        $designation = $_POST["designation"];
        $email = $_POST["email"];
        $hourly_rate = $_POST["hourly_rate"];
        $shift = $_POST["shift"];
        $status = $_POST["status"];

        // Update the record in the database
        $sql = "UPDATE security_personnel SET name=?, contact=?, designation=?, email=?, hourly_rate=?, `shift`=?, status=? WHERE id=?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("ssssdssi", $name, $contact, $designation, $email, $hourly_rate, $shift, $status, $id);
        
        if ($stmt->execute()) {
            header("Location: viewsecuritypersonnel.php");
            exit();
        } else {
            echo "Error updating record: " . $stmt->error;
        }

        $stmt->close();
    }

    // Fetch the existing data for the selected ID
    $sql = "SELECT * FROM security_personnel WHERE id=?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "No record found";
        exit();
    }

    $stmt->close();
    $connection->close();
} else {
    echo "ID not provided";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/4e1d1789bb.js" crossorigin="anonymous"></script>
    <title>Edit Security Personnel</title>
</head>
<style>
        body {
            padding: 0;
            margin: 0;
            background-color: #f2f2f2;
            font-family: Arial, sans-serif;
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
            background-color: rgba(255, 255, 255, 0.8);
            max-width: 500px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            text-align: center;
            margin-bottom: 50px;
        }

        h2 {
    background-color: #1e90ff;
    color: white;
    padding: 25px;
    margin-top: auto;
    text-align: center;
    margin-bottom: 20px;
    border-radius: 9px;
  }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 10px;
            margin-left: 0;
        }

        input, select {
            width: 80%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            margin-left: 0;
        }

        button {
            background-color: #1e90ff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            width: 50%;
            margin-left: 0;
        }

        button:hover {
            background-color: #1033a6;
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
    <h2>Edit Security Personnel</h2>
    <form method="POST">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo $row['name']; ?>" required>

        <label for="contact">Contact:</label>
        <input type="text" id="contact" name="contact" value="<?php echo $row['contact']; ?>" required>

        <label for="designation">Designation:</label>
        <input type="text" id="designation" name="designation" value="<?php echo $row['designation']; ?>" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo $row['email']; ?>" required>

        <label for="hourly_rate">Hourly Rate:</label>
        <input type="number" id="hourly_rate" name="hourly_rate" step="0.01" value="<?php echo $row['hourly_rate']; ?>" required>

        <label for="shift">Shift:</label>
        <select id="shift" name="shift">
            <option value="Day" <?php if ($row['shift'] === 'Day') echo 'selected'; ?>>Day</option>
            <option value="Night" <?php if ($row['shift'] === 'Night') echo 'selected'; ?>>Night</option>
        </select>

        <label for="status">Status:</label>
        <select id="status" name="status">
            <option value="Active" <?php if ($row['status'] === 'Active') echo 'selected'; ?>>Active</option>
            <option value="Inactive" <?php if ($row['status'] === 'Inactive') echo 'selected'; ?>>Inactive</option>
        </select>

        <button type="submit">Update</button>
    </form>
    </div>
    <footer>
        <p>&copy; 2023 BEEKINEE Admin. All rights reserved.</p>
    </footer>
</body>
</html>
