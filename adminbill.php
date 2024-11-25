<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Bill</title>
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

    .navigate {
            position:fixed;
            margin-top: 30px;
            margin-right: 87%;
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
        .table-container {
            margin-top: 30px;
            margin-left: 50px;
            margin-right: 50px;
            border: 1px solid #ccc;
            border-radius: 20px;
            padding: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #fff;
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
            background-color: #e1f1ff; /* Subtle blue color for odd rows */
        }
        caption {
            caption-side: top;
            text-align: center;
            font-weight: bold;
            font-size: 24px;
            padding: 10px 0;
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
    <div class="navigate-button">
        <a href="financialsummary.php" class="navigate"><i class="fa-solid fa-left-long"></i>  Financial Report</a>
    </div>
    <div class="table-container">
        <?php
        // Include the dbConn.php file to establish the database connection
        include 'dbConn.php';

        // Function to update the database when the form is submitted
        function updateDatabase($connection, $bill_id, $amount, $type, $release_date, $due_date) {
            $amount = mysqli_real_escape_string($connection, $amount);
            $type = mysqli_real_escape_string($connection, $type);
            $release_date = mysqli_real_escape_string($connection, $release_date);
            $due_date = mysqli_real_escape_string($connection, $due_date);
            $sql = "UPDATE admin_billingtable SET amount='$amount', type='$type', release_date='$release_date', due_date='$due_date' WHERE bill_id=$bill_id";
            mysqli_query($connection, $sql);
        }        

        // Check if the form was submitted and process the update
        if (isset($_POST['submit'])) {
            $bill_id = $_POST['bill_id'];
            $amount = $_POST['amount'];
            $type = $_POST['type'];
            $due_date = $_POST['due_date'];
            $release_date = $_POST['release_date'];
            updateDatabase($connection, $bill_id, $amount, $type, $due_date, $release_date);
        }

        // Query to retrieve data from the admin_billingtable
        $sql = "SELECT bill_id, resident_id, phone_no, amount, type, release_date, due_date FROM admin_billingtable";

        // Execute the query
        $result = mysqli_query($connection, $sql);

        // Check if there are any records in the table
        if (mysqli_num_rows($result) > 0) {
            // Display table header with a centered caption
            echo '<table>';
            echo '<caption>Admin Billing Table</caption>';
            echo '<tr>';
            echo '<th>Bill id</th>';
            echo '<th>Resident id</th>';
            echo '<th>Phone number</th>';
            echo '<th>Amount</th>';
            echo '<th>Payment towards</th>';
            echo '<th>Release Date</th>';
            echo '<th>Due Date</th>';
            echo '<th>Action</th>';
            echo '</tr>';

            // Loop through each row and display the data with editable fields
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<tr>';
                echo '<td>' . $row['bill_id'] . '</td>';
                echo '<td>' . $row['resident_id'] . '</td>';
                echo '<td>' . $row['phone_no'] . '</td>';
                echo '<form method="post">';
                echo '<td><input type="number" name="amount" value="' . $row['amount'] . '"></td>';
                echo '<td><input type="text" name="type" value="' . $row['type'] . '"></td>';
                echo '<td><input type="date" name="release_date" value="' . $row['release_date'] . '"></td>';
                echo '<td><input type="date" name="due_date" value="' . $row['due_date'] . '"></td>';
                echo '<input type="hidden" name="bill_id" value="' . $row['bill_id'] . '">';
                echo '<td><input type="submit" name="submit" value="Update"></td>';
                echo '</form>';
                echo '</tr>';
            }

            echo '</table>';
        } else {
            echo 'No records found in the table.';
        }

        // Close the connection (you can also close it in dbConn.php)
        mysqli_close($connection);
        ?>
    </div>
    <footer>
        <p>&copy; 2023 BEEKINEE Admin. All rights reserved.</p>
    </footer>
</body>
</html>
