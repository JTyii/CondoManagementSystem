<?php
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'jeebycorp';
$connection = mysqli_connect($host,$user,$password,$database);

if($connection === false){
    die('Connection failed'. mysqli_connect_error());
}