<?php
include('dbConn.php');

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Fetch data from the database
$query = "SELECT category FROM user_maintenancetable";
$result = $connection->query($query);

$filters_amount_query = "SELECT COUNT(category) AS filters_count FROM user_maintenancetable WHERE category = 'filters'";
$filters_amount_result = $connection->query($filters_amount_query);

$filters_amount = 0;
if ($filters_amount_result->num_rows > 0) {
    $row = $filters_amount_result->fetch_assoc();
    $filters_amount = $row['filters_count'];
}
$testsmokedetectors_amount_query = "SELECT COUNT(category) AS testsmokedetectors_count FROM user_maintenancetable WHERE category = 'testsmokedetectors'";
$testsmokedetectors_amount_result = $connection->query($testsmokedetectors_amount_query);

$testsmokedetectors_amount = 0;
if ($testsmokedetectors_amount_result->num_rows > 0) {
    $row = $testsmokedetectors_amount_result->fetch_assoc();
    $testsmokedetectors_amount = $row['testsmokedetectors_count'];
}
$facilitiesissues_amount_query = "SELECT COUNT(category) AS facilitiesissues_count FROM user_maintenancetable WHERE category = 'facilitiesissues'";
$facilitiesissues_amount_result = $connection->query($facilitiesissues_amount_query);

$facilitiesissues = 0;
if ($facilitiesissues_amount_result->num_rows > 0) {
    $row = $facilitiesissues_amount_result->fetch_assoc();
    $facilitiesissues_amount = $row['facilitiesissues_count'];
}
$ventpipe_amount_query = "SELECT COUNT(category) AS ventpipe_count FROM user_maintenancetable WHERE category = 'ventpipe'";
$ventpipe_amount_result = $connection->query($ventpipe_amount_query);

$ventpipe_amount = 0;
if ($ventpipe_amount_result->num_rows > 0) {
    $row = $ventpipe_amount_result->fetch_assoc();
    $ventpipe_amount = $row['ventpipe_count'];
}
$others_amount_query = "SELECT COUNT(category) AS others_count FROM user_maintenancetable WHERE category = 'others'";
$others_amount_result = $connection->query($others_amount_query);

$others_amount = 0;
if ($others_amount_result->num_rows > 0) {
    $row = $others_amount_result->fetch_assoc();
    $others_amount = $row['others_count'];
}

$total_amount_query = "SELECT COUNT(*) AS total_count FROM user_maintenancetable";
$total = $connection->query($total_amount_query);

$data = array();

$categories = array('filters', 'testsmokedetectors', 'facilitiesissues', 'ventpipe', 'others');

foreach ($categories as $category) {
    $query1 = "SELECT COUNT(category) AS count FROM user_maintenancetable WHERE category = ?";
    $stmt = $connection->prepare($query1);
    $stmt->bind_param("s", $category);
    $stmt->execute();
    $result1 = $stmt->get_result();

    if ($result1->num_rows > 0) {
        $row = $result1->fetch_assoc();
        $data[$category] = $row['count'];
    } else {
        $data[$category] = 0;
    }
}

$connection->close();

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Signika+Negative&display=swap" rel="stylesheet">
        <script src="https://kit.fontawesome.com/4e1d1789bb.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <title>Maintenance Report</title>
        <style>
            html, body {
      padding: 0;
      margin: 0;
      height: 100%;
      font-size: 1em;
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

    body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    }

    .navigate {
            z-index: 1;
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
    .navigate1 {
            z-index: 1;
            position:fixed;
            margin-top: 30px;
            margin-left: 87%;
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

        .navigate1:hover {
            background-color: #1e90ff;
            color: #fff;
        }

    h1 {
        text-align: center;
    }

    .annual-stats, .category-stats {
        background-color: white;
        border-radius: 20px;
        margin: 20px;
        padding: 10px;
        border: 1px solid #ccc;
    }

    h2 {
        margin-bottom: 10px;
    }

    ul {
        list-style-type: none;
        padding: 0;
    }

    li {
        margin-bottom: 5px;
    }

    .category {
        font-weight: bold;
    }

    .container {
    margin-top: 100px;
    position: relative;
    min-height: 100vh;
    padding-bottom: 40px;
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
    <div class="navigate-button1">
        <a href="userreport.php" class="navigate1">Resident & Unit Report  <i class="fa-solid fa-right-long"></i></a>
    </div>
        <div class="container">
        <div class="annual-stats">
            <h2>Annual Statistics</h2>
            <p>Total Maintenance Requests: <?php echo $total->fetch_assoc()['total_count']; ?></p>
        </div>
        
        <div class="category-stats">
            <h2>Maintenance Request Categories</h2>
            <ul>
                <li><span class="category">Filter Changes:</span><?php echo $filters_amount?></li>
                <li><span class="category">Test Smoke & Carbon Monoxide Detectors:</span><?php echo $testsmokedetectors_amount?></li>
                <li><span class="category">Facilities Issues:</span><?php echo $facilitiesissues_amount?></li>
                <li><span class="category">Vent Pipe Cleaning:</span><?php echo $ventpipe_amount?></li>
                <li><span class="category">Others:</span><?php echo $others_amount?></li>
            </ul>
        </div>
        <div class="pie-chart-container">
            <canvas id="pieChart"></canvas>
        </div>
</div>
        <footer>
        <p>&copy; 2023 BEEKINEE Admin. All rights reserved.</p>
    </footer>
    </body>
    <script>
    // Data for the pie chart
    var pieChartData = {
        labels: <?php echo json_encode($categories); ?>,
        datasets: [{
            data: <?php echo json_encode(array_values($data)); ?>,
            backgroundColor: [
                '#FF6384', // Red
                '#36A2EB', // Blue
                '#FFCE56', // Yellow
                '#4CAF50', // Green
                '#FF9800'  // Orange
            ]
        }]
    };

    // Options for the pie chart
    var pieChartOptions = {
        responsive: true,
        maintainAspectRatio: false
    };

    // Get the canvas element
    var pieChartCanvas = document.getElementById('pieChart');

    // Create the pie chart
    var pieChart = new Chart(pieChartCanvas, {
        type: 'pie',
        data: pieChartData,
        options: pieChartOptions
    });
</script>

</html>
