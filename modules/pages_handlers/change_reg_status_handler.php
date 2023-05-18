<?php 
if(session_status()!=PHP_SESSION_ACTIVE) session_start();
include '..\..\connect\connect_database.php';

$reg_status_id=$_POST['reg_status'];
$id_status_select=$_POST['id_status_select'];

$query = "UPDATE Course_registration SET ID_status = $reg_status_id WHERE Course_registration.ID = $id_status_select";
$result = mysqli_query($link, $query) or die("Ошибка " .
    mysqli_error($link));

if ($result) {
    $query2 = "SELECT * FROM Status WHERE Status.ID=$reg_status_id";
    $result2 = mysqli_query($link, $query2) or die("Ошибка".mysqli_error($link));

    $row = mysqli_fetch_row($result2); 
    $status=$row[1];
}

echo "<div class='course_status col-2' id='course_status".$id_status_select."'>".$status."</div>";

?>

