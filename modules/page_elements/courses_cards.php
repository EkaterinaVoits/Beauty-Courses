<?php
if(session_status()!=PHP_SESSION_ACTIVE) session_start();
?>
<link rel="stylesheet" href="../../css/style.css" type="text/css">

<?php

//$id_orgCourse=$_GET['id_orgCourse'];
if(isset($_SESSION['user']['id'])) {
	$id_user=$_SESSION['user']['id'];
} else {
	$id_user="";
} 

$result = mysqli_query($link, $query) or die("Ошибка".mysqli_error($link));

if($result)
{
	$rows = mysqli_num_rows($result);
	for($i = 0; $i < $rows; ++$i) 
	{
		$row = mysqli_fetch_row($result); 
		$id_orgCourse=$row[0];

		echo "<div class='course-item-2'>"; 
		echo "<img src='img/courses_images/".$row[11]."' class='course-item-img-2'/>"; 

		echo "<div>"; 

		echo "<div class='course-item-title-2'>".$row[8]."</div>"; 
		echo "<div class='course-item-description-2'>".$row[9]."</div>"; 

		echo "<div class='course-description'>"; 
		echo "<div>Начало: <span>".$row[3]."</span></div>"; 
		echo "<div>Продолжительность: <span>".$row[4]."</span></div>"; 
		echo "<div>Группа: <span>".$row[5]."</span></div>";
		echo "<div>График: <span>".$row[6]."</span></div>";
		echo "<div>Преподаватель: <span>".$row[14]."</span></div>";
		echo "<div>Стоимость: <span>".$row[10]." byn</span></div>";
		echo "</div>";
		echo "<div class='status-or-reserve-btn".$row[0]."'>";

		$regQuery = "SELECT * FROM Course_registration JOIN Status ON Course_registration.ID_status=Status.ID WHERE ID_user='$id_user' AND ID_orginizedCourse='$id_orgCourse'";
		$regResult = mysqli_query($link, $regQuery) or die("Ошибка".mysqli_error($link));

		if(mysqli_num_rows($regResult)>0) {

			$registration = mysqli_fetch_assoc($regResult);
			echo "<div class='status'>".$registration['status']."</div>";

		} else {

			if(isset($_SESSION['user']['id'])) {
				echo "<button class='button reserve-btn' id=".$row[0]." onclick='reserve(this.id)'>Подать заявку</button>";
				//echo "<div class='show_status' id='status".$row[0]."'>Заявка подана</div>"; 

			} else {
				echo "<div class='log-in'><a href='../modules/authorization/authorization.php'>Войдите</a>, чтобы подать заявку</div>"; 
			}
			
		}

		echo "</div>"; 
		echo "</div>"; 
		echo "</div>"; 
	}
	//mysqli_free_result($result); 	
} 
/*if(mysqli_num_rows($result)==0){
	echo "<div>Результатов не найдено</div>";
}
*/
?>


<script src="js/jquery-3.4.1.min.js"></script>
<script src="js/main.js"></script>