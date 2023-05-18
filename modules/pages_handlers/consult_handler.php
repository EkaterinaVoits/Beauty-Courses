<?php 
if(session_status()!=PHP_SESSION_ACTIVE) session_start();
include '..\..\connect\connect_database.php';

$user_name = $_POST["user_name"];	
$user_telephone = $_POST["user_telephone"];

$query = "INSERT INTO Consultation(user_name, user_telephone, ID_status) VALUES ('$user_name', '$user_telephone', 1)";
$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));

?>