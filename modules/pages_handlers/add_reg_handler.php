<?php 
if(session_status()!=PHP_SESSION_ACTIVE) session_start();
include '..\..\connect\connect_database.php';

$users_email = $_POST["users_email"];	
$id_orgCourse = $_POST["id_orgCourse"];

$existenceUserQuery="SELECT id FROM User WHERE User.email='$users_email'";
$existenceUserResult = mysqli_query($link, $existenceUserQuery) or die("Ошибка".mysqli_error($link));

//если пользователь с такой почтой существует
if($existenceUserResult) {
	$rows = mysqli_num_rows($existenceUserResult);
	if($rows>0) {

		$row = mysqli_fetch_row($existenceUserResult); 
		$user_id=$row[0];

		//если пользователь с такой почтой уже зарегистрирован на данном курсе
		$existenceRegQuery="SELECT id FROM Course_registration WHERE Course_registration.ID_user='$user_id' AND Course_registration.ID_orginizedCourse='$id_orgCourse'";
		$existenceRegResult = mysqli_query($link, $existenceRegQuery) or die("Ошибка".mysqli_error($link));

		if($existenceRegResult) {
			$rows1 = mysqli_num_rows($existenceRegResult);

			if($rows1==0) {
				$addRegQuery = "INSERT INTO Course_registration(ID_user, ID_orginizedCourse, ID_status) VALUES ('$user_id','$id_orgCourse', 1)";
				$addRegResult = mysqli_query($link, $addRegQuery) or die("Ошибка".mysqli_error($link));
			} else {
				echo "<div class='cant-del-msg'>Запись не была добавлена, так как пользователь с такой почтой уже зарегистрирован на данном курсe</div>";
			}
		}

	} else {
		echo "<div class='cant-del-msg'>Запись не была добавлена, так как пользователя с такой почтой не существует</div>";
	}
}

$query = "SELECT * FROM Course_registration JOIN User ON Course_registration.ID_user=User.ID JOIN Status ON Course_registration.ID_status=Status.ID JOIN Organized_course ON Course_registration.ID_orginizedCourse=Organized_course.ID JOIN Course ON Organized_course.ID_course=Course.ID ORDER BY Course_registration.ID ASC";								

$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));

if($result) {
	$rows = mysqli_num_rows($result);
	if($rows>0) {
		for($i = 0; $i < $rows; ++$i)
		{
			$row = mysqli_fetch_row($result); 
			echo "<div class='row row-margin'>";
			echo "<div class='reg_id col-1'>".$row[0]."</div>";
			echo "<div class='client_id col-2'>".$row[7]."</div>";
			echo "<div class='course_id col-1'>".$row[2]."</div>";
			echo "<div class='course_name col-2'>".$row[22]."</div>";
			echo "<div class='course_status col-2' id='course_status".$row[0]."'>".$row[13]."</div>";

			$query2 = "SELECT * FROM Status";
			$result2 = mysqli_query($link, $query2) or die("Ошибка".mysqli_error($link));
			echo "<select name='status-select' id='".$row[0]."' class='status_select col-2'>";

			if($result2)
			{
				$rows2 = mysqli_num_rows($result2);
				echo "<option value='no_status'></option>";
				for($j = 0; $j < $rows2; ++$j)
				{
					$row2 = mysqli_fetch_row($result2); 
					echo "<option value='".$row2[0]."'>".$row2[1]."</option>";
				}
			}

			echo "</select>";

			"</div>";
			echo "<button class='del-reg-btn del-btn col-2' id='".$row[0]."'>Удалить</button>";
			echo "</div>";
		}
	}
}

	/*$addMasterQuery = "INSERT INTO Master(name, photo, email, telephone, info) VALUES ('$masters_name','$photo_path','$masters_email','$masters_telephone','$masters_info')";
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