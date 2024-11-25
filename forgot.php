<?php
include "dbConn.php";
$password = ""; // Initialize the password variable

if (isset($_POST['submitBtn'])) {
    $username = $_POST['username'];
    $username = stripcslashes($username);
    $username = mysqli_real_escape_string($connection, $username);

    $sql = "SELECT username, password, email FROM usertable WHERE username = '$username'";
    $result = mysqli_query($connection, $sql);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $count = mysqli_num_rows($result);

    if ($count == 1) {
        $password = $row['password'];
    } else {
        echo "<h1><center>Invalid Username. Please try again.</center></h1>";
    }

    mysqli_close($connection);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sofia+Sans+Semi+Condensed:wght@300;500&display=swap" rel="stylesheet">
    <style>
        body { background-image: url("img/bg.jpg"); background-size: cover; }
        #forgot-form { 
            background-color: rgba(255, 255, 255, 0.8); 
            width: 400px; 
            margin: 0 auto; 
            padding: 20px; 
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
            margin-top: 100px;
            font-family: 'Sofia Sans Semi Condensed', sans-serif;
        }
        #forgot-form h1 { text-align: center; }
        #forgot-form label { display: block; margin-bottom: 10px; }
        #forgot-form input[type="text"] { width: 100%; padding: 8px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 4px; text-align: center; }
        #forgot-form input[type="submit"] { width: 100%; font-size: 18px; padding: 12px; background-color: #1e90ff; color: #fff; border: none; border-radius: 25px; cursor: pointer; }
        #forgot-form input[type="submit"]:hover { background-color: #1034A6; }
        #forgot-form a { display: block; text-align: center; margin-top: 10px; text-decoration: none; color: #1e90ff; }
        #forgot-form a:hover { text-decoration: underline; }

        .hidden{
            display:none;
        }
    </style>
</head>
<body>
    <div id="forgot-form">
        <h1>Forgot Password</h1>
        <form action="forgot.php" method="post">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required>
            <input type="submit" name="submitBtn" value="Password?">
            <!-- Display the password here -->
            <?php if ($password !== "") : ?>
                <p id="passwordText">Your password is <span id="passwordValue"><?= $password ?></span></p>
            <?php endif; ?>
        </form>
        <a href="login.php">Back to Login</a>
    </div>
</body>
</html>
