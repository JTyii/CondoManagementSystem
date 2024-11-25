<?php
include "dbConn.php";

$response = array();

if (isset($_POST['note'])) {
    $note = $_POST['note'];

    // Update the existing note in the database
    $sql = "UPDATE notes SET notes = '$note' WHERE id = 1"; 
    $result = mysqli_query($connection, $sql);

    if ($result) {
        $response['success'] = true;
    } else {
        $response['success'] = false;
        $response['message'] = "Error: " . mysqli_error($connection);
    }
}
mysqli_close($connection);

if (isset($_POST['note'])) {
    echo json_encode($response);
    exit(); 
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Main Page</title>
    <script src="https://kit.fontawesome.com/4e1d1789bb.js" crossorigin="anonymous"></script>
</head>
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


    main {
        position: relative;
        padding: 20px;
        display: flex;
        justify-content: space-between;
        text-align:center;
    }

    .card {
        background-color: #fff;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        border-radius: 10px;
        padding: 20px;
        flex-basis: 100%;
    }

    .card h2 {
        margin-top: 0;
        text-align: center;
    }

    .report {
        display: flex;
        flex-wrap: wrap;
        justify-content: center; /* Center the items horizontally */
        text-decoration: none;
    }

    .report .finance a,
    .report .maintenance a,
    .report .resident a {
        color: #000; 
        text-decoration: none;
    }

    .report .finance:hover,
    .report .maintenance:hover,
    .report .resident:hover {
        transform: scale(1.1);
        cursor: pointer;
        text-decoration: none;
    }

    .finance, .maintenance, .resident {
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        border-radius: 20px;
        background-color: #fff;
        text-align: center;
        flex-basis: calc(33.33% - 50px);
        margin: 10px;
        padding: 50px 10px; /* Decreased padding for smaller icons */
        box-sizing: border-box;
    }

    .finance i, .maintenance i, .resident i {
        font-size: 48px; 
        margin-bottom: 10px;
    }

    .sticky-note {
        margin: 70px 50px;
        bottom: 30px; 
        width: 1200px;
        height: 200px;
        background-color: #ffeb3b; /* Sticky note background color */
        border: 2px solid #ffc107; /* Sticky note border color */
        border-radius: 10px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    .sticky-note-content {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px;
    }

    .sticky-note textarea {
        background-color: #ffeb3b;
        margin-right: 20px;
        border: none;
        flex-grow: 1;
    }

.save-button {
    margin-bottom: 50px;
    background-color: #1e90ff;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.save-button:hover {
    background-color: #1033a6;
}
.fixed-button {
    text-decoration: none;
  position: fixed;
  bottom: 50px;
  right: 30px;
  background-color: #1034A6;
  color: white;
  border: none;
  border-radius: 50%;
  width: 60px;
  height: 60px;
  display: flex;
  justify-content: center;
  align-items: center;
  font-size: 1.5em;
  cursor: pointer;
  transition: background-color 0.3s ease;
  z-index: 1000;
}

.fixed-button:hover {
  background-color: #1e90ff;
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

    <main>
        <section class="card">
            <h1>Welcome, Admin!</h1>
            <p>Remember to note down what you have changed in the note!</p>
        </section>
    </main>
    <section class="report">
        <div class="finance">
            <a href="financialsummary.php">
            <i class="fa-solid fa-coins"></i>
            <h1>Financial Report</h1>
        </a>
        </div>
        <div class="maintenance">
            <a href="maintenance_report.php">
            <i class="fa-solid fa-wrench"></i>
            <h1>Maintenance Report</h1>
        </a>
        </div>
        <div class="resident">
        <a href="userreport.php">
            <i class="fa-solid fa-user-group"></i>
            <h1>Resident & Unit Report</h1>
        </a></div>
    </section>
    <center>
    <div class="sticky-note">
    <h2>Note</h2>
    <textarea id="stickyNote" name="note" placeholder="Note it down...." style="height: 100px; width: 1000px;"></textarea>
    <button class="save-button" onclick="saveNote()">Save</button>
</div></center>
<a href="admin_chat.php" class="fixed-button">
<i class="fa-regular fa-comment"></i>
</a>
    <footer>
        <p>&copy; 2023 BEEKINEE Admin. All rights reserved.</p>
    </footer>
</body>
<script>
    function saveNote() {
    var note = document.getElementById("stickyNote").value;

    // Send note to the server using AJAX
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "saveNote.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);
            if (response.success) {
                // Reload the page after saving
                location.reload();
            } else {
                console.error("Error saving note:", response.message);
            }
        }
    };
    xhr.send("note=" + encodeURIComponent(note));
}

function createNewSaveButton() {
    var saveButtonContainer = document.querySelector(".sticky-note");
    
    // Create a new "Save" button
    var newButton = document.createElement("button");
    newButton.textContent = "Save";
    newButton.onclick = saveNote;
    
    // Replace the existing "Save" button with the new button
    saveButtonContainer.removeChild(saveButtonContainer.querySelector("button"));
    saveButtonContainer.appendChild(newButton);
}

function fetchAndDisplayNote() {
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "getNote.php", true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var note = xhr.responseText;
                document.getElementById("stickyNote").value = note;
            }
        };
        xhr.send();
    }
    window.onload = function () {
        fetchAndDisplayNote();
    };
</script>
</html>
