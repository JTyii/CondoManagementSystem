<?php
include ('dbConn.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $Fname = $_POST['fname'];
    $Lname = $_POST['lname'];
    $email = $_POST['email'];
    $unitno = $_POST['unit_no'];
    $phone_no = $_POST['phone_no'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    if ($password != $confirm_password) {
        $error_message = 'Passwords do not match';
        header("refresh:2;url=register.php"); 
    } else {
        $query = "INSERT INTO `usertable`(`username`, `fname`, `lname`, `email`, `unit_no`, `phone_no`, `password`) VALUES ('$username','$Fname','$Lname', '$email','$unitno', '$phone_no', '$password')";
        mysqli_query($connection, $query);
        $success_message = 'Notification table created successfully';

    //Create notifications table
    $get_user_id_query = "SELECT resident_id FROM `usertable` WHERE `username`='$username' AND `email`='$email'";
    $result = mysqli_query($connection, $get_user_id_query);

    if ($row = mysqli_fetch_assoc($result)) {
        $user_id = $row['resident_id'];
        // Create a unique notification table for the user
        $notification_table = "notifications_user_" . $user_id;
        $create_notification_table_query = "CREATE TABLE `$notification_table` (
            id INT AUTO_INCREMENT PRIMARY KEY,
            notification TEXT,
            date DATE,
            is_read TINYINT(1) DEFAULT 0
        )";

        if (mysqli_query($connection, $create_notification_table_query)) {

            $welcome_notification = "Welcome to BEEKINEE! We're thrilled to have you as a new member of our community.";
            $profile_notification = "1. Complete Your Profile: Make sure to fill out your profile with accurate information. This will help other members get to know you better.\n\n";
            $profile_notification .= "2. Explore Our Features: Take a look around and discover the various features and services we offer.\n\n";
            $profile_notification .= "3. Connect and Interact: Join discussions, participate in events, and engage with other members. We encourage active participation to make the most of your experience.\n\n";
            $profile_notification .= "If you have any questions or need assistance, don't hesitate to reach out to our support team at beekinee_admin@condogrp.com or contact us :+1 234 567 890.";

            $insert_welcome_query = "INSERT INTO `$notification_table` (notification, date) VALUES (?, NOW())";
            $insert_profile_query = "INSERT INTO `$notification_table` (notification, date) VALUES (?, NOW())";

            $stmt_welcome = mysqli_prepare($connection, $insert_welcome_query);
            $stmt_profile = mysqli_prepare($connection, $insert_profile_query);

            if ($stmt_welcome && $stmt_profile) {
                mysqli_stmt_bind_param($stmt_welcome, "s", $welcome_notification);
                mysqli_stmt_bind_param($stmt_profile, "s", $profile_notification);

                if (mysqli_stmt_execute($stmt_welcome) && mysqli_stmt_execute($stmt_profile)) {
                    $success_message = "Notifications inserted successfully.";
                } else {
                    $error_message = "Error inserting notifications: " . mysqli_error($connection);
                }
                
                mysqli_stmt_close($stmt_welcome);
                mysqli_stmt_close($stmt_profile);
                $queryUserWallettable = "INSERT INTO `user_wallettable`(`resident_id`, `phone_no`) 
                VALUES ('$user_id', '$phone_no')";
                if (mysqli_query($connection, $queryUserWallettable)) {
                    $queryAdminBillingtable = "INSERT INTO `admin_billingtable`(`resident_id`, `phone_no`, `username`)
                    VALUES ('$user_id', '$phone_no', '$username')";
                    if (mysqli_query($connection, $queryAdminBillingtable)) {
                        $success_message= "Registration Successful. Redirecting you to Login Page...";
                        header("refresh:1;url=login.php");
                    } else {
                        echo "Error Creating your Account. Please Try Again.";
                    }
                } else {
                    echo "Error Creating your Account. Please Try Again.";
                }
            } else {
                echo "Error preparing statements: " . mysqli_error($connection);
            }
        } else {
            echo "Error creating notification table: " . mysqli_error($connection);
        }
    } else {
        echo "Error retrieving user ID. Please try again.";
    }
    mysqli_close($connection);
}}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
</head>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Sofia+Sans+Semi+Condensed:wght@300;500&display=swap" rel="stylesheet">
<style>
    body {
        font-family: 'Sofia Sans Semi Condensed', sans-serif;
        background-image: url("img/bg.jpg");
        background-size: cover;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
    }

    .Register-form {
        background-color: rgba(255, 255, 255, 0.95);
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
        text-align: center;
        width: 550px;
        margin-top: 60px;
        margin-bottom: 60px;
    }

    h1 {
        margin-bottom: 20px;
        font-size: 28px;
        color: #1033a6;
    }

    .Register-form form {
        display: flex;
        flex-direction: column;
    }

    label {
        font-size: 16px;
        margin-bottom: 10px;
        text-align: left;
        color: #333;
        margin-top: 10px;
    }

    .form-row {
        display: flex;
        justify-content: space-between;
        align-items: baseline;
    }

    .form-row label,
    .form-row input {
        width: 40%;
        margin-bottom: 5px;
        margin-top: 10px;
    }

    input[type=text],
    input[type=email],
    input[type=unit_no],
    input[type=password] {
        padding: 12px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 16px;
    }

    input[type="submit"] {
        margin-top: 10px;
        background-color: #1033a6;
        border: none;
        border-radius: 5px;
        color: white;
        cursor: pointer;
        font-size: 20px;
        padding: 10px;
        transition: background-color 0.3s ease;
    }

    input[type="submit"]:hover {
        background-color: #1e90ff;
        color: white;
    }

    #links {
        text-align: center;
        margin-top: 15px;
    }

    #links a {
        text-decoration: none;
        color: #1033a6;
        font-size: 20px;
        margin: 0 10px;
        transition: color 0.3s ease;
    }

    #links a:hover {
        color: #1e90ff;
        text-decoration: underline;
    }

    #logo-image {
        display: block;
        margin: 0 auto;
    }
    #error-message {
    color: red;
    font-size: 14px;
    margin-top: 5px;
    }
    #success-message {
        color: green;
        font-size: 14px;
        margin-top: 5px;
    }
</style>
</head>
<body>
    <div class="Register-form">
        <?php
            if (!empty($error_message)) {
                echo "<p id='error-message'>$error_message</p>";
            }
            if (!empty($success_message)) {
                echo "<p id='success-message'>$success_message</p>";
            }
            ?>
        <h1>Sign Up</h1>
        <form action="" method="POST">
            <p text align="center"><img id="logo-image" src="img/logo.png" alt="" width="400px" height="400"></p>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <div class="form-row">
                <label for="fname">First name:</label>
                <label for="lname">Last name:</label>
            </div>
            <div class="form-row">
                <input type="text" id="fname" name="fname" required>
                <span class="form-space"></span>
                <input type="text" id="lname" name="lname" required>
            </div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <label for="unit_no">Unit No.:</label>
            <input type="text" id="unit_no" name="unit_no" required>
            <label for="phone_no">Phone Number:</label>
            <input type="text" id="phone_no" name="phone_no" required>
            <div class="form-row">
                <label for="password">Password:</label>
                <label for="confirm_password">Confirm Password:</label>
            </div>
            <div class="form-row">
                <input type="password" id="password" name="password" required>
                <span class="form-space"></span> 
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
            <input type="submit" value="Sign Up" name="btnRegister">
        </form>
        <div id="links">
            <a href="login.php">Login</a>
        </div>
    </div>
</body>
<script>
</script>

</html>
