<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Income Statement and Budgeted Expenses</title>
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
            margin-left: 10%;
            margin-right: 70%;
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
        .form-container {
            width: 500px;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 50px;
            margin-top: 50px;
            margin-left:500px;
            margin-right: 500px
        }
        
        label {
            display: block;
            margin-bottom: 5px;
        }
        .input-box {
            width: 95%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .input-box[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
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
        <a href="financialsummary.php" class="navigate"><i class="fa-solid fa-left-long"></i><br>Financial Summary</a>
    </div>
    <div class="form-container">
        <h1>Create Income Statement</h1>

        <?php
        // Include the database connection code
        require_once 'dbConn.php';

        // Initialize empty data for creating
        $revenues = '';
        $expenses = '';
        $month ='';

        // Handle form submission for creating
        if (isset($_POST['submit_income'])) {
            $revenues = $_POST['revenues'];
            $expenses = $_POST['expenses'];
            $month = $_POST['month'];

            // Calculate Net Profit/Loss
            $netProfitLoss = $revenues - $expenses;

            // Insert new data into the income_statement table
            $insertQuery = "INSERT INTO admin_incomestatement (`month`, Revenues, Expenses, `Net Profit/Loss`) VALUES ('$month','$revenues', '$expenses', '$netProfitLoss')";
            $insertResult = mysqli_query($connection, $insertQuery);

            if ($insertResult) {
                echo '<p>New data inserted successfully into Income statement!</p>';
            } else {
                echo '<p>Error inserting data into Income statement: ' . mysqli_error($connection) . '</p>';
            }
        }
        ?>

        <form method="post">
            <label for="revenues">Revenues:</label>
            <input class="input-box" type="text" name="revenues" value="<?php echo $revenues; ?>"><br>

            <label for="expenses">Expenses:</label>
            <input class="input-box" type="text" name="expenses" value="<?php echo $expenses; ?>"><br>

            <label for="month">Month:</label>
            <input class="input-box" type="text" name="month" value="<?php echo $month; ?>"><br>

            <input class="input-box" type="submit" name="submit_income" value="Save to Income Statement">
        </form>
    </div>

    <div class="form-container">
        <h1>Create Budgeted Expenses</h1>

        <?php
        // Include the database connection code
        require_once 'dbConn.php';

        // Initialize empty data for creating
        $budgetedIncome = '';
        $actualIncome = '';
        $budgetedExpenses = '';
        $actualExpenses = '';

        // Handle form submission for creating
        if (isset($_POST['submit_budget'])) {
            $month = $_POST['month'];
            $budgetedIncome = $_POST['budgetedincome'];
            $actualIncome = $_POST['actualincome'];
            $budgetedExpenses = $_POST['budgetedexpenses'];
            $actualExpenses = $_POST['actualexpenses'];


            // Calculate Net Profit/Loss
            $netProfitLoss = $actualIncome - $actualExpenses;

            // Insert new data into the budgetandreport table
            $insertQuery = "INSERT INTO budgetandreport (`month`, BudgetedIncome, ActualIncome, BudgetedExpenses, ActualExpenses) VALUES ('$month', '$budgetedIncome', '$actualIncome', '$budgetedExpenses', '$actualExpenses')";
            $insertResult = mysqli_query($connection, $insertQuery);

            if ($insertResult) {
                echo '<p>New data inserted successfully into budgetandreport!</p>';
            } else {
                echo '<p>Error inserting data into budgetandreport: ' . mysqli_error($connection) . '</p>';
            }
        }
        ?>

        <form method="post">
            <label for="budgetedincome">Month:</label>
            <input class="input-box" type="text" name="month" value="<?php echo $month; ?>"><br>

            <label for="budgetedincome">Budgeted Income:</label>
            <input class="input-box" type="text" name="budgetedincome" value="<?php echo $budgetedIncome; ?>"><br>

            <label for="actualincome">Actual Income:</label>
            <input class="input-box" type="text" name="actualincome" value="<?php echo $actualIncome; ?>"><br>

            <label for="budgetedexpenses">Budgeted Expenses:</label>
            <input class="input-box" type="text" name="budgetedexpenses" value="<?php echo $budgetedExpenses; ?>"><br>

            <label for="actualexpenses">Actual Expenses:</label>
            <input class="input-box" type="text" name="actualexpenses" value="<?php echo $actualExpenses; ?>"><br>

            <input class="input-box" type="submit" name="submit_budget" value="Save to Budget and Report">
        </form>

        <?php
        // Close the database connection
        mysqli_close($connection);
        ?>
    </div>
    <footer>
        <p>&copy; 2023 BEEKINEE Admin. All rights reserved.</p>
    </footer>
</body>
</html>
