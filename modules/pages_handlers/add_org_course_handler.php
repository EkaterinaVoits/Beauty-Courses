<?php 
if(session_status()!=PHP_SESSION_ACTIVE) session_start();
include '..\..\connect\connect_database.php';

$course_id = $_POST["course_id"];
$master_id = $_POST["master_id"];
$course_startDate = $_POST["course_startDate"];
$course_duration = $_POST["course_duration"];
$course_groupType = $_POST["course_groupType"];	
$course_schedule = $_POST["course_schedule"];	

$addOrgCourseQuery = "INSERT INTO Organized_course(ID_course, ID_master, startDate, duration, groupType, schedule ) VALUES ('$course_id','$master_id','$course_startDate','$course_duration','$course_groupType','$course_schedule')";
$orgCourseResult = mysqli_query($link, $addOrgCourseQuery) or die("Ошибка".mysqli_error($link));

if(!$orgCourseResult) {
	echo "<div>Что-то пошло не так</div>";
}

$query = "SELECT * FROM Organized_course JOIN Course ON Organized_course.ID_course=Course.ID JOIN Master ON Organized_course.ID_master=Master.ID ORDER BY Organized_course.ID ASC";
$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));

if($result) {
	$rows = mysqli_num_rows($result);
	if($rows>0) {
		for($i = 0; $i < $rows; ++$i)
		{
			$row = mysqli_fetch_row($result); 
			echo "<div class='row row-margin'>";
			echo "<div class='col-1'>".$row[0]."</div>";
			echo "<div class='col-1'>".$row[1]."</div>";
			echo "<div class='col-2'>".$row[8]."</div>";
			echo "<div class='col-1'>".$row[2]."</div>";
			echo "<div class='col-2'>".$row[14]."</div>";
			echo "<div class='col-2'>".$row[3]."</div>";
			echo "<div class='col-1'>".$row[5]."</div>";
			echo "<div class='col-2'>".$row[6]."</div>";
			echo "</div>";
		}
	}
}

?>