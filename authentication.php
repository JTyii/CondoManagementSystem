<?php  
    session_start();  
    include('dbConn.php');  
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

    if($count_usertable == 1){   
        header( "refresh:1;url=loading.php" );
    } elseif($count_admintable == 1){
        header("Location: admin_main.php");
    } else{  
        echo "<h1><center>Invalid username or password. Please try again.</center></h1>"; 
        header( "refresh:1;url=login.php");  
    }     
?>