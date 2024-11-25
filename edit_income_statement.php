<!DOCTYPE html>
<html>
<head>
    <title>Edit Income Statement</title>
    <script src="https://kit.fontawesome.com/4e1d1789bb.js" crossorigin="anonymous"></script>
    <style>
        /* Add your CSS styles here */
        body {
            margin:0;
            background-color: #f2f2f2;
            font-family: Arial, sans-serif;
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
            margin-top: 50px;
            margin-left: 100px;
            margin-right: 100px;
            border: 1px solid #ccc;
            border-radius: 10px;
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
<div class="container">
<div class="table-container">
        <?php
        // Include the dbConn.php file to establish the database connection
        include 'dbConn.php';

        // Function to calculate Net Profit/Loss
        function calculateNetProfitLoss($revenues, $expenses) {
            return $revenues - $expenses;
        }

        // Function to update the database when the form is submitted
        function updateDatabase($connection, $income_id, $revenues, $expenses) {
            $income_id = mysqli_real_escape_string($connection, $income_id);
            $revenues = mysqli_real_escape_string($connection, $revenues);
            $expenses = mysqli_real_escape_string($connection, $expenses);
            $netProfitLoss = calculateNetProfitLoss($revenues, $expenses);
            $sql = "UPDATE admin_incomestatement SET Revenues='$revenues', Expenses='$expenses', `Net Profit/Loss`='$netProfitLoss' WHERE income_id=$income_id";
            mysqli_query($connection, $sql);
        }

        // Function to delete a record from the database
        function deleteRecord($connection, $income_id) {
            $sql = "DELETE FROM admin_incomestatement WHERE income_id=$income_id";
            mysqli_query($connection, $sql);
        }

        // Check if the form was submitted for update or delete
        if (isset($_POST['submit'])) {
            $income_id = $_POST['income_id'];
            $revenues = $_POST['revenues'];
            $expenses = $_POST['expenses'];
            updateDatabase($connection, $income_id, $revenues, $expenses);
        } elseif (isset($_POST['delete'])) {
            $income_id = $_POST['income_id'];
            deleteRecord($connection, $income_id);
        }

        // Query to retrieve data from the income_statement table
        $sql = "SELECT income_id, Revenues, Expenses, `Net Profit/Loss` FROM admin_incomestatement";

        // Execute the query
        $result = mysqli_query($connection, $sql);

        // Check if there are any records in the table
        if (mysqli_num_rows($result) > 0) {
            // Display table header with a centered caption
            echo '<table>';
            echo '<caption>Income Statement Table</caption>';
            echo '<tr>';
            echo '<th>Income ID</th>';
            echo '<th>Revenues</th>';
            echo '<th>Expenses</th>';
            echo '<th>Net Profit/Loss</th>';
            echo '<th>Action</th>';
            echo '</tr>';

            // Loop through each row and display the data with editable fields
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<tr>';
                echo '<form method="post">';
                echo '<td>' . $row['income_id'] . '</td>';
                echo '<td><input type="text" name="revenues" value="' . $row['Revenues'] . '"></td>';
                echo '<td><input type="text" name="expenses" value="' . $row['Expenses'] . '"></td>';
                echo '<td>' . $row['Net Profit/Loss'] . '</td>';
                echo '<input type="hidden" name="income_id" value="' . $row['income_id'] . '">';
                echo '<td><input type="submit" name="submit" value="Update">';
                echo '<button class="delete-button" type="submit" name="delete">Delete</button></td>';
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

<div class="table-container">
    <?php
    // Include the dbConn.php file to establish the database connection
    include 'dbConn.php';

    // Check if the form was submitted for update or delete
    if (isset($_POST['submit_new'])) {
        $id = $_POST['id'];
        $month = $_POST['month'];
        $budgetedIncome = $_POST['budgetedincome'];
        $actualIncome = $_POST['actualincome'];
        $budgetedExpenses = $_POST['budgetedexpenses'];
        $actualExpenses = $_POST['actualexpenses'];
        
        // Perform necessary operations with the provided variables
        // Insert or update the data into the database as needed
        // You should add your own logic here to handle the new data

        // For demonstration purposes, let's just display the data
        echo "New data submitted:";
        echo "<br>ID: $id";
        echo "<br>Month: $month";
        echo "<br>Budgeted Income: $budgetedIncome";
        echo "<br>Actual Income: $actualIncome";
        echo "<br>Budgeted Expenses: $budgetedExpenses";
        echo "<br>Actual Expenses: $actualExpenses";
    }

    // Query to retrieve data from the new_income_statement table
    $sql_new = "SELECT budget_id, Month, Budgetedincome, Actualincome, Budgetedexpenses, Actualexpenses FROM budgetandreport";

     // Execute the query for the new table
     $result_new = mysqli_query($connection, $sql_new);

         // Check if the delete button in the second table was clicked
    if (isset($_POST['delete_new'])) {
        $budget_id = $_POST['budget_id'];
        $sql_delete = "DELETE FROM budgetandreport WHERE budget_id='$budget_id'";
        mysqli_query($connection, $sql_delete);
        // Redirect or display a message after deletion
        // For example: header('Location: your_page.php');
    }

     // Check if there are any records in the new table
     if (mysqli_num_rows($result_new) > 0) {
         // Display the new table header
         echo '<table>';
         echo '<caption>New Income Statement Data</caption>';
         echo '<tr>';
         echo '<th>Budget ID</th>';
         echo '<th>Month</th>';
         echo '<th>Budgeted Income</th>';
         echo '<th>Actual Income</th>';
         echo '<th>Budgeted Expenses</th>';
         echo '<th>Actual Expenses</th>';
         echo '<th>Action</th>';
         echo '</tr>';
 
         // Loop through each row and display the data with editable fields
         while ($row_new = mysqli_fetch_assoc($result_new)) {
             echo '<tr>';
             echo '<form method="post">';
             echo '<td>' . $row_new['budget_id'] . '</td>';
             echo '<td><input type="text" name="month" value="' . $row_new['Month'] . '"></td>';
             echo '<td><input type="text" name="budgetedincome" value="' . $row_new['Budgetedincome'] . '"></td>';
             echo '<td><input type="text" name="actualincome" value="' . $row_new['Actualincome'] . '"></td>';
             echo '<td><input type="text" name="budgetedexpenses" value="' . $row_new['Budgetedexpenses'] . '"></td>';
             echo '<td><input type="text" name="actualexpenses" value="' . $row_new['Actualexpenses'] . '"></td>';
             echo '<td>';
             echo '<input type="hidden" name="budget_id" value="' . $row_new['budget_id'] . '">';
             echo '<input type="submit" name="submit_new" value="Update">';
             echo '<button class="delete-button" type="submit" name="delete_new">Delete</button>';
             echo '</td>';
             echo '</form>';
             echo '</tr>';
         }
 
         echo '</table>';
     } else {
         echo 'No records found in the new table.';
     }
 
     // Close the connection (you can also close it in dbConn.php)
     mysqli_close($connection);
     ?>
 </div>
</div>
 <footer>
        <p>&copy; 2023 BEEKINEE Admin. All rights reserved.</p>
    </footer>
 </body>
 </html>

