<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <script src="https://kit.fontawesome.com/4e1d1789bb.js" crossorigin="anonymous"></script>
    <title>Visitor History Page</title>
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
        height: 30px;
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
            position:relative;
            max-width: 800px;
            margin: 60px 350px;
            border-radius: 10px;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
  
  h1 {
    text-align: center;
    padding: 20px;
  }
  
  table {
    width: 100%;
    border-collapse: collapse;
    background-color: rgba(255, 255, 255, 0.8);
  }
  
  th, td {
    padding: 10px;
    text-align: left;
    border-bottom: 1px solid #ccc;
  }
  
  thead th {
    background-color: #75b7fa;
  }
  
  tbody tr:nth-child(even) {
    background-color: rgba(255, 255, 255, 0.8);
  }
  
  .accept-btn, .accept-all-btn {
    padding: 5px 10px;
    background-color: #1e90ff;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
  }
  
  .accept-btn:hover, .accept-all-btn:hover {
    background-color: #1034A6;
  }
  
  .reject-btn, .reject-all-btn {
    padding: 5px 10px;
    background-color: #d65854;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
  }

  .reject-btn:hover, .reject-all-btn:hover {
    background-color: #9e221e;
  }
  .action-buttons {
    margin-top: 20px;
    text-align: center;
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
<div class="container">
<h1>Visitor History</h1>
<table>
    <thead>
    <tr>
        <th>Visitor Name</th>
        <th>Visitor Contact</th>
        <th>Visit Purposes</th>
        <th>Check-In Time</th>
        <th>Check-Out Time</th>
        <th>Parking Request</th>
        <th>Pending Requests</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <?php
    include('dbConn.php'); // Include database connection
    
    $sql = "SELECT * FROM admin_visitortable";
    $result = $connection->query($sql);
    
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $visitorName = $_POST["visitorName"];
        $status = $_POST["status"];
        
        // Update the pending_request column in the database
        $sql = "UPDATE admin_visitortable SET pending_request = '$status' WHERE visitor_name = '$visitorName'";
        if ($connection->query($sql) === TRUE) {
            // Extract resident_name based on the visitor_name
            $extractResidentSql = "SELECT resident_name FROM admin_visitortable WHERE visitor_name = '$visitorName'";
            $residentResult = $connection->query($extractResidentSql);
            $residentRow = $residentResult->fetch_assoc();
            $residentName = $residentRow['resident_name'];
    
            // Find corresponding resident_id in the usertable
            $findResidentIdSql = "SELECT resident_id FROM usertable WHERE username = '$residentName'";
            $residentIdResult = $connection->query($findResidentIdSql);
            $residentIdRow = $residentIdResult->fetch_assoc();
            $residentId = $residentIdRow['resident_id'];
    
            // Create notification table name
            $notification_table = "notifications_user_" . $residentId;
    
            // Generate a random 5-letter string
            $randomString = substr(str_shuffle("abcdefghijklmnopqrstuvwxyz1234567890"), 0, 5);

            // Format the notification text
            $notificationText = "Your Visitor Pass is $randomString";
            
            // Insert the formatted notification into the notification table
            $notification_query = "INSERT INTO $notification_table (notification) VALUES ('$notificationText')";
            if ($connection->query($notification_query) === TRUE) {
                echo "Status updated and notification inserted successfully";
            } else {
                echo "Error updating status and inserting notification: " . $connection->error;
            }
        }
    } 
    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . $row['visitor_name'] . '</td>';
        echo '<td>' . $row['visitor_contact'] . '</td>';
        echo '<td>' . $row['visit_purposes'] . '</td>';
        echo '<td>' . $row['check_in_time'] . '</td>';
        echo '<td>' . $row['check_out_time'] . '</td>';
        echo '<td>' . $row['parking_request'] . '</td>';
        echo '<td>';
        if ($row['pending_request'] === 'Accepted') {
            echo '<span style="opacity: 0.5;">Accepted</span>';
        } elseif ($row['pending_request'] === 'Declined') {
            echo '<span style="opacity: 0.5;">Declined</span>';
        } else {
            echo '<button type="button" class="accept-btn" data-visitor="' . $row['visitor_name'] . '">Accept</button>';
            echo '<button type="button" class="decline-btn" data-visitor="' . $row['visitor_name'] . '">Decline</button>';
        }
        echo '</td>';
        echo '</tr>';
    }

    $connection->close();
    ?>

    </tbody>
</table>
  </div>
<footer>
        <p>&copy; 2023 BEEKINEE Admin. All rights reserved.</p>
    </footer>
<script>
    document.addEventListener("DOMContentLoaded", function () {
    const acceptButtons = document.querySelectorAll(".accept-btn");
    const declineButtons = document.querySelectorAll(".decline-btn");

    acceptButtons.forEach(button => {
        button.addEventListener("click", function () {
            const visitorName = this.getAttribute("data-visitor");
            updateRequestStatus(visitorName, "Accepted");
            insertNotification(visitorName);
            hideButtons(visitorName);
        });
    });

    declineButtons.forEach(button => {
        button.addEventListener("click", function () {
            const visitorName = this.getAttribute("data-visitor");
            updateRequestStatus(visitorName, "Declined");
            hideButtons(visitorName);
        });
    });

    function updateRequestStatus(visitorName, status) {
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "updateStatus.php", true); // Use the new PHP file
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                console.log(xhr.responseText);
                // Reload the page after the status update
                location.reload();
            }
        };
        const data = `visitorName=${visitorName}&status=${status}`;
        xhr.send(data);
    }

    function insertNotification(visitorName) {
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "insertNotification.php", true); // Use the new PHP file
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            console.log(xhr.responseText);
        }
    };
    const data = `visitorName=${visitorName}`;
    xhr.send(data);
}

    function hideButtons(visitorName) {
        const acceptButton = document.querySelector(`.accept-btn[data-visitor="${visitorName}"]`);
        const declineButton = document.querySelector(`.decline-btn[data-visitor="${visitorName}"]`);

        if (acceptButton) {
            acceptButton.style.display = "none";
        }

        if (declineButton) {
            declineButton.style.display = "none";
        }
    }
});
</script>
</body>
</html>








