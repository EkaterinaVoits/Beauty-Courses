<?php 
if(session_status()!=PHP_SESSION_ACTIVE) session_start();
include '..\..\connect\connect_database.php';

	$course_id = $_POST["course_id"];	
	$course_title = $_POST["new_course_title"];	
	$course_description = $_POST["new_course_description"];	
	$course_price = $_POST["new_course_price"];

	$query = "UPDATE Course SET title = '$course_title', description='$course_description', price='$course_price' WHERE ID = '$course_id'";
	$result = mysqli_query($link, $query) or die("Ошибка " .mysqli_error($link));
	
	echo "<div class='col-1'>".$course_id."</div>";
	echo "<div id='title-course".$course_id."' class='col-2'>".$course_title."</div>";
	echo "<div id='description-course".$course_id."'class='col-3'>".$course_description."</div>";
	echo "<div class='col-2'><span id='price-course".$course_id."'>".$course_price."</span> BYN</div>";
	echo "<button class='edit-course-btn del-btn col-2' id='".$course_id."' onclick='editCourse(this.id)'>Редактировать</button>";
	echo "<button class='del-course-btn del-btn col-2' id='".$course_id."' onclick='deleteCourse(this.id)'>Удалить</button>";
	echo "</div>";

?>