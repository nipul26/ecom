<?php 
// session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); 
$conn = mysqli_connect("localhost","root","","ecom") or die("database connection failed");
date_default_timezone_set("Asia/Kolkata");
?>
