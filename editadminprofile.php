<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Admin Accounts</title>
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
         
        .table-container {
            margin-top: 30px;
            margin-left: 50px;
            margin-right: 50px;
            background-color: #fff;
            border-radius: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            padding: 20px;
            border: 1px solid #ddd;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid black;
            padding: 10px;
            text-align: left;
        }
        tr:nth-child(odd) {
            background-color: #e1f1ff;
        }
        caption {
            caption-side: top;
            text-align: center;
            font-weight: bold;
            font-size: 24px;
            padding: 10px 0;
        }

        input{
            width:200px;
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
<div class="table-container">
    <?php
    // Include the dbConn.php file to establish the database connection
    include 'dbConn.php';

    // Function to update the database when the form is submitted
    function updateAdminAccount($connection, $admin_id, $username, $email, $password) {
        $username = mysqli_real_escape_string($connection, $username);
        $email = mysqli_real_escape_string($connection, $email);
        $password =mysqli_real_escape_string($connection, $password);
        $sql = "UPDATE admintable SET username='$username', email='$email', password='$password' WHERE admin_id=$admin_id";
        mysqli_query($connection, $sql);
    }

    // Check if the form was submitted and process the update
    if (isset($_POST['submit'])) {
        $admin_id = $_POST['admin_id'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        updateAdminAccount($connection, $admin_id, $username, $email, $password);
    }

    // Query to retrieve data from the admin_accounts table
    $sql = "SELECT admin_id, username, email, password FROM admintable";

    // Execute the query
    $result = mysqli_query($connection, $sql);

    // Check if there are any records in the table
    if (mysqli_num_rows($result) > 0) {
        // Display table header with a centered caption
        echo '<table>';
        echo '<caption>Admin Accounts</caption>';
        echo '<tr>';
        echo '<th>Admin ID</th>';
        echo '<th>Username</th>';
        echo '<th>Email</th>';
        echo '<th>Password</th>';
        echo '<th>Action</th>';
        echo '</tr>';

        // Loop through each row and display the data with editable fields
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr>';
            echo '<form method="post">';
            echo '<td>' . $row['admin_id'] . '</td>';
            echo '<td><input type="text" name="username" value="' . $row['username'] . '"></td>';
            echo '<td><input type="email" name="email" value="' . $row['email'] . '"></td>';
            echo '<td><input type="text" name="password" value="' .$row['password'].'"></td>';
            echo '<input type="hidden" name="admin_id" value="' . $row['admin_id'] . '">';
            echo '<td><input type="submit" name="submit" value="Update"></td>';
            echo '</form>';
            echo '</tr>';
        }

        echo '</table>';
    } else {
        echo 'No records found in the table.';
    }

    mysqli_close($connection);
    ?>
</div>
<footer>
        <p>&copy; 2023 BEEKINEE Admin. All rights reserved.</p>
    </footer>
</body>
</html>
