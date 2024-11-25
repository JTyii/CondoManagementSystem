<?php
    session_start();

    include('dbConn.php');

    if (isset($_POST['btnSubmit'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $username = stripcslashes($username);
        $password = stripcslashes($password);
        $username = mysqli_real_escape_string($connection, $username);
        $password = mysqli_real_escape_string($connection, $password);

        $_SESSION['username'] = $username;

        $sql_usertable = "SELECT * FROM usertable WHERE username = '$username' AND password = '$password'";
        $result_usertable = mysqli_query($connection, $sql_usertable);
        $count_usertable = mysqli_num_rows($result_usertable);

        $sql_admintable = "SELECT * FROM admintable WHERE username = '$username' AND password = '$password'";
        $result_admintable = mysqli_query($connection, $sql_admintable);
        $count_admintable = mysqli_num_rows($result_admintable);

        if ($count_usertable == 1) {
            header("Location: loading.php");
        } elseif ($count_admintable == 1) {
            header("Location: admin_main.php");
        } else {
            $error_message = "Invalid username or password. Please try again.";
        }
    }
?>
</head>
<!DOCTYPE html>
<html>
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sofia+Sans+Semi+Condensed:wght@300;500&display=swap" rel="stylesheet">
    <title>Login Page</title>
    <style>
        body {
    background-image: url("img/bg.jpg");
    background-size: cover;
    font-family: 'Sofia Sans Semi Condensed', sans-serif;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
}

#login-form {
    background-color: rgba(255, 255, 255, 0.95);
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
    text-align: center;
    width: 350px;
}

#login-form h1 {
    margin-bottom: 20px;
    font-size: 28px;
    color: #1033a6;
}

#login-form form {
    display: flex;
    flex-direction: column;
}

#login-form label {
    font-size: 16px;
    margin-bottom: 5px;
    text-align: left;
    color: #333;
}

#login-form input[type="text"],
#login-form input[type="password"] {
    padding: 12px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
}

#login-form input[type="submit"] {
    background-color: #1033a6;
    color: #fff;
    padding: 12px 24px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 18px;
    transition: background-color 0.3s ease;
}

#login-form input[type="submit"]:hover {
    background-color: #1e90ff;
}

#login-links {
    margin-top: 15px;
}

#login-links a {
    text-decoration: none;
    color: #1033a6;
    font-size: 14px;
    margin: 0 10px;
    transition: color 0.3s ease;
}

#login-links a:hover {
    color: #1e90ff;
    text-decoration: underline;
}

#logo-image {
            width: 200px;
            height: auto; 
        }

        #error-message {
    color: red;
    font-size: 14px;
    margin-top: 5px;
}
    </style>
</head>
<body>
<div id="login-form">
    <h1>Login</h1>
    <form action="" method="post">
        <div id="logo-container">
            <img id="logo-image" src="img/logo.png" alt="Logo">
        </div>
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>
        
        <?php
        if (isset($error_message)) {
            echo "<p id='error-message'>$error_message</p>";
        }
        ?>
        
        <input type="submit" name="btnSubmit" value="Login">
    </form>
    <div id="login-links">
        <a href="forgot.php">Forgot password?</a>
        <a href="register.php">Sign Up</a>
    </div>
</div>
</body>
</html>
