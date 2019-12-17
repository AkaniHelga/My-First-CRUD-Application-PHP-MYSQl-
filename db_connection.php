<?php
//db config file

$host = "localhost";
$user = "root";
$password = "";
$database = "fashion";

// Create connection (procedural)
$con = mysqli_connect($host, $user, $password, $database);

// Check connection
// if (!$con) {
//     die("Connection failed: " . mysqli_connect_error());
// }
// echo "Connected successfully";

// $sql= "DELETE FROM brand WHERE id < 48";
// $sql = "DELETE FROM brand WHERE id<104";
// if (mysqli_query($con,$sql)) {
// 	echo "Deleted";
// } else{
// 	echo "Failed!";
// }
?>