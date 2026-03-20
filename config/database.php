<?php

$host = "localhost";
$user = "root";
$password = "";
$database = "webbanhang";

$conn = mysqli_connect($host,$user,$password,$database);
if(!$conn){
    die("Kết nối không thành công!");
    exit();
}
mysqli_select_db($conn, $database);
mysqli_query($conn, "SET NAMES UTF8");
return $conn;

?>