<?php 
if(session_status()!=PHP_SESSION_ACTIVE) session_start();
include '..\..\connect\connect_database.php';

	$course_id = $_POST["course_id"];	
	$course_title = $_POST["course_title"];	
	$course_description = $_POST["course_description"];	
	$course_price = $_POST["course_price"];

	echo "<div class='col-1'>".$course_id."</div>";
	echo "<textarea name='new-course-title' class='col-2 changes-inputs' type='text' required>".$course_title."</textarea>";
	echo "<textarea name='new-course-description' class='col-3 changes-inputs' type='text' required >".$course_description."</textarea>";
	echo "<input name='new-course-price' class='col-2 changes-inputs' type='text' required value='".$course_price."'>";

	//echo "<div id='title-course".$row[0]."' class='col-2'>".$row[1]."</div>";
	//echo "<div class='col-3'>".$course_description."</div>";
	//echo "<div class='col-2'>".$course_price." BYN</div>";
	echo "<button class='edit-course-btn del-btn col-2' id='".$course_id."' onclick='saveChangesCourse(this.id)'>Сохранить</button>";
	echo "<button class='del-course-btn del-btn col-2' id='".$course_id."' onclick='deleteCourse(this.id)'>Удалить</button>";

	// $response = [
	//     "fill" => $color,
	//     "count" => $likesCount[0]
	// ];
	/*if(isset($_FILES['masters_photo']['name'])) {
		$photo_path=$_FILES['masters_photo']['name'];

		if (!move_uploaded_file($_FILES['masters_photo']['tmp_name'], '../../img/masters_photos/'.$photo_path)) {
		
		echo "<div>Что-то пошло не так</div>";
		}
	} else {
		$photo_path = "../../img/masters_photos/default_master_photo.jpg";
	}
 
	$addMasterQuery = "INSERT INTO Master(name, photo, email, telephone, info) VALUES ('$masters_name','$photo_path','$masters_email','$masters_telephone','$masters_info')";
	$masterResult = mysqli_query($link, $addMasterQuery) or die("Ошибка".mysqli_error($link));

	if(!$masterResult) {
		echo "<div>Что-то пошло не так</div>";
	}
 
	$query = "SELECT * FROM Master";
	$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
	
	if($result) {
		$rows = mysqli_num_rows($result);
        if($rows>0) {
            for($i = 0; $i < $rows; ++$i)
            {
                $row = mysqli_fetch_row($result);
                echo "<div class='row row-margin'>";  
				echo "<div class='col-1'>".$row[0]."</div>";
				echo "<div class='col-2'>".$row[1]."</div>";
				echo "<div class='col-3'>".$row[3]."</div>";
				echo "<div class='col-2'>".$row[4]."</div>";
				echo "<div class='col-2'>".$row[5]."</div>";
				echo "<button class='del-master-btn del-btn col-2' id='".$row[0]."' onclick='deleteMaster(this.id)'>Удалить</button>";
				echo "</div>";
            }
        }	
    }*/


    ?>