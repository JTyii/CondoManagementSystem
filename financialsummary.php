<!DOCTYPE html>
<html>
<head>
<script src="https://kit.fontawesome.com/4e1d1789bb.js" crossorigin="anonymous"></script>
    <title>Financial Summaries</title>
    <style>
        /* Add your CSS styles here */
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

    .navigate {
            position:fixed;
            margin-top: 30px;
            margin-left: 89%;
            width: 300px;
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

.navigate1 {
    position:fixed;
    width: 300px;
    margin-top: 100px;
    margin-left: 88%;
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
.navigate2 {
    position:fixed;
    width: 200px;
    margin-top: 170px;
    margin-left: 85%;
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
.navigate3 {
    position:fixed;
    width: 200px;
    margin-top: 240px;
    margin-left: 85%;
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

        .navigate:hover {
            background-color: #1e90ff;
            color: #fff;
        }
        .navigate1:hover {
            background-color: #1e90ff;
            color: #fff;
        }
        .navigate2:hover {
            background-color: #1e90ff;
            color: #fff;
        }
        .navigate3:hover {
            background-color: #1e90ff;
            color: #fff;
        }

        .table-container {
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            margin: 40px 20px;
            margin-right: 300px;
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
        .negative-row {
        background-color: red;
        color: red; /* Set text color to white for better visibility */
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
        <a href="adminbill.php" class="navigate">Billing Table  <i class="fa-solid fa-right-long"></i></a>
    </div>
    <div class="navigate-button1">
        <a href="admin_finance.php" class="navigate1">Create Finance  <i class="fa-solid fa-right-long"></i></a>
    </div>
    <div class="navigate-button2">
        <a href="maintenance_report.php" class="navigate2">Maintenance Report  <i class="fa-solid fa-right-long"></i></a>
    </div>
    <div class="navigate-button3">
        <a href="edit_income_statement.php" class="navigate3">Edit Income Statement  <i class="fa-solid fa-right-long"></i></a>
    </div>
    <div class="table-container">
        <?php
        // Include the dbConn.php file to establish the database connection
        include 'dbConn.php';

        // Query to retrieve data from the income_statement table
        $incomeQuery = "SELECT income_id, Month, Revenues, Expenses, `Net Profit/Loss` FROM admin_incomestatement";
        $incomeResult = mysqli_query($connection, $incomeQuery);
        ?>
        <table>
            <caption>Income Statement Table</caption>
            <tr>
                <th>Income ID</th>
                <th>Month</th>
                <th>Revenues</th>
                <th>Expenses</th>
                <th>Net Profit/Loss</th>
            </tr>
            <?php
            // Display income_statement table data
            while ($incomeRow = mysqli_fetch_assoc($incomeResult)) {
                // Check if the net profit/loss is negative and apply the appropriate class
                $rowClass = ($incomeRow['Net Profit/Loss'] < 0) ? 'negative-row' : '';

                echo '<tr class="' . $rowClass . '">';
                echo '<td>' . $incomeRow['income_id'] . '</td>';
                echo '<td>' . $incomeRow['Month'] . '</td>';
                echo '<td>' . $incomeRow['Revenues'] . '</td>';
                echo '<td>' . $incomeRow['Expenses'] . '</td>';
                echo '<td>' . $incomeRow['Net Profit/Loss'] . '</td>';
                echo '</tr>';
            }
            ?>
        </table>
    </div>

    <div class="table-container">
        <table>
            <caption>Budgeted Expenses</caption>
            <tr>
                <th>Month</th>
                <th>Budgeted Income</th>
                <th>Actual Income</th>
                <th>Budgeted Expenses</th>
                <th>Actual Expenses</th>
            </tr>
            <?php
            // Query to retrieve data from the budgetandreport table
            $budgetQuery = "SELECT `month`, Budgetedincome, Actualincome, Budgetedexpenses, Actualexpenses FROM budgetandreport";
            $budgetResult = mysqli_query($connection, $budgetQuery);

            // Display budgetandreport table data
            while ($budgetRow = mysqli_fetch_assoc($budgetResult)) {
                echo '<tr>';
                echo '<td>' . $budgetRow['month'] . '</td>';
                echo '<td>' . $budgetRow['Budgetedincome'] . '</td>';
                echo '<td>' . $budgetRow['Actualincome'] . '</td>';
                echo '<td>' . $budgetRow['Budgetedexpenses'] . '</td>';
                echo '<td>' . $budgetRow['Actualexpenses'] . '</td>';
                echo '</tr>';
            }
            ?>
        </table>
    </div>

    <div class="table-container">
    <table>
        <caption>Deliquent Accounts</caption>
        <tr>
            <th>Bill ID</th>
            <th>Resident ID</th>
            <th>Username</th>
            <th>Phone Number</th>
            <th>Amount</th>
            <th>Type</th>
            <th>Release Date</th>
            <th>Due Date</th>
        </tr>
        
        <?php
        // Get current date
        $currentDate = date('Y-m-d'); // This will always fetch the current date when the page is loaded

        // Query to retrieve expired due dates with amount greater than 0
        $sql = "SELECT bill_id, resident_id, username, phone_no, amount, type, release_date, due_date FROM Admin_billingtable WHERE due_date < '$currentDate' AND amount > 0";
        $result = $connection->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["bill_id"] . "</td>";
                echo "<td>" . $row["resident_id"] . "</td>";
                echo "<td>" . $row["username"] . "</td>";
                echo "<td>" . $row["phone_no"] . "</td>";
                echo "<td>" . $row["amount"] . "</td>";
                echo "<td>" . $row["type"] . "</td>";
                echo "<td>" . $row["release_date"] . "</td>";
                echo "<td>" . $row["due_date"] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='8'>No expired due dates with non-zero amount</td></tr>";
        }

        // Close the connection (if it's not done in Dbconn.php)
        $connection->close();
        ?>
    </table>
    </div>
    <footer>
        <p>&copy; 2023 BEEKINEE Admin. All rights reserved.</p>
    </footer>
</body>
</html>

