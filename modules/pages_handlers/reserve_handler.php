<?php 
if(session_status()!=PHP_SESSION_ACTIVE) session_start();
include '..\..\connect\connect_database.php';


if(isset($_SESSION['user']['id'])) {

	$id_orgCourse=$_POST["id_org_course"];
	$id_user=$_SESSION['user']['id'];

	$query = "SELECT * FROM Course_registration WHERE ID_user='$id_user' AND ID_orginizedCourse='$id_orgCourse'";
	$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));

    if($result) {
    	$reserve = mysqli_fetch_assoc($result);

    	//Такой записи нет
    	if (mysqli_num_rows($result) == 0) {
    		
    		$query = "INSERT INTO Course_registration (ID_user, ID_orginizedCourse, ID_status) VALUES ($id_user, $id_orgCourse, 1)";
        	$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));

        	$status_id="заявка отправлена";

    	} 

        echo "<div class='status'>".$status_id."</div>";

    }
} 
?>