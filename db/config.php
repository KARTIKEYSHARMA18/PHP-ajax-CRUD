<?php 
$servername = "127.0.0.1"; 
$username = "root";
$password = ""; 
$dbname = "user_list_app";

$conn = mysqli_connect($servername,$username, $password, $dbname);
if(!$conn){
    die("connectionn failed: ");
}


?>