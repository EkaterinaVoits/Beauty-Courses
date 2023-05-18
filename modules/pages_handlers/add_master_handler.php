<?php 
if(session_status()!=PHP_SESSION_ACTIVE) session_start();
include '..\..\connect\connect_database.php';

	$masters_name = $_POST["masters_name"];	
	$masters_email = $_POST["masters_email"];	
	$masters_telephone = $_POST["masters_telephone"];	
	$masters_info = $_POST["masters_info"];
	if(isset($_FILES['masters_photo']['name'])) {
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
	}


?>