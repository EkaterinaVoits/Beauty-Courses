<!DOCTYPE html>
<?php 
if(session_status()!=PHP_SESSION_ACTIVE) session_start();
include 'connect\connect_database.php';
?>
<html>
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Beauty courses catalog</title>
	<link rel="stylesheet" href="css/style.css" type="text/css">
</head>

<body>
	<?php require 'modules/page_elements/header.php';?>

	<div class="container">
		<div class="align-content-center"> 


			<!-- GO-BACK BUTTON -->
			<div class="go-back">
				<a href="catalog.php">
					<img src="img/go_back.png " class="go-back-img">
					<div>НАЗАД</div>
				</a>
			</div>
			<!-- /GO-BACK BUTTON -->


			<!-- COURSE DESCRIPTION SECTION -->
			<div class="course-section">
				<div class="course">
					<?php

					$id_course=$_GET['id'];
					if(isset($_SESSION['user']['id'])) {
						$id_user=$_SESSION['user']['id'];
					} else {
						$id_user=null;
					}
					

					$query = "SELECT * FROM Course WHERE id='$id_course'";
					$result = mysqli_query($link, $query) or die("Ошибка".mysqli_error($link));

					if($result) {
						$row = mysqli_fetch_assoc($result); 

						$likeQuery = "SELECT isLike FROM Liked_course WHERE ID_course='$id_course' AND ID_user='$id_user'";
						//$likeQuery = "SELECT * FROM Liked_course JOIN Course ON Liked_course.ID_course=Course.ID WHERE ID_course='$id_course' AND ID_user='$id_user'";
						$likeResult = mysqli_query($link, $likeQuery) or die("Ошибка".mysqli_error($link));

						if ($likeResult) {
							$isLike = mysqli_fetch_row($likeResult);

							if (mysqli_num_rows($likeResult) > 0 && $isLike[0] == 1) {
								$fill = 'rgb(242 229 229)';
							} else if(mysqli_num_rows($likeResult) > 0 && $isLike[0] != 1) {
								$fill = 'none';
							} else {
								$fill = 'none';
							}
						}

						echo "<img src='img/courses_images/".$row['photo']."' class='course-img'>"; 
						echo "<div class='course-info'>"; 
						echo "<div class='course-title'>".$row['title']."</div>"; 
						echo "<div class='course-short-description'>".$row['description']."</div>"; 
						echo "<div class='likes' id='likes'>";
						echo "<svg  width='24' height='20' viewBox='0 0 44 36'  xmlns='http://www.w3.org/2000/svg'>
								<path id='like' d='M21.1563 5.93687L22 7.26263L22.8437 5.93687C24.7592 2.9268 28.1401 1 32 1C38.0477 1 43 5.95228 43 12C43 14.6991 41.7576 17.4919 39.7561 20.2211C37.7623 22.94 35.082 25.5045 32.3668 27.726C29.6564 29.9436 26.9411 31.7953 24.9006 33.0938C23.8814 33.7425 23.0329 34.2515 22.4407 34.5976C22.2733 34.6954 22.1263 34.7803 22.0019 34.8515C21.8772 34.7796 21.7299 34.6939 21.562 34.5951C20.9697 34.2464 20.1211 33.7338 19.1016 33.0812C17.0608 31.7748 14.3451 29.9135 11.6343 27.6894C8.91854 25.4613 6.23771 22.8932 4.24343 20.1783C2.24096 17.4522 1 14.6725 1 12C1 5.95228 5.95228 1 12 1C15.8599 1 19.2408 2.9268 21.1563 5.93687Z' stroke='black' stroke-width='2' fill='".$fill."' />
							</svg>";
						echo "<p id='likes_count' class='likes_count'>".$row['countLikes']."</p>";
						echo "</div>";
						echo "</div>";
					} 
					?>	
				</div>
				<!-- /COURSE DESCRIPTION SECTION -->

				<!-- ORGANIZED COURSE SECTION -->
				<div class="organized_course_section">
					<div class="title-org-courses">УСПЕЙТЕ ЗАПИСАТЬСЯ</div>
					<div class="courses-items-container">
						
					
					<?php
					$query = "SELECT * FROM Organized_course JOIN Course ON Organized_course.ID_course=Course.ID JOIN Master ON Organized_course.ID_master=Master.ID WHERE Course.ID='$id_course'";
 
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

							echo "<div class='course-item-4'>"; 
							

							echo "<div>"; 

							
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

						if($rows == 0) {
							echo "Ожидайте появления курса!";
						}

					} 

					?>
				</div>
				</div>
				<!-- /ORGANIZED COURSE SECTION -->

				<!-- REVIEW SECTION -->
				<div class="review-section">
					<div class="title-review">ОТЗЫВЫ</div>
					<div class="reviews" id="results_reviews">
						<?php

						$reviewQuery = "SELECT * FROM Course_review WHERE ID_course='$id_course'";
						$result_review = mysqli_query($link, $reviewQuery) or die("Ошибка".mysqli_error($link));
						$reviews = mysqli_num_rows($result_review);

						if($result_review) {
							if($reviews) {
								for($i = 0; $i < $reviews; ++$i) 
								{
									$review = mysqli_fetch_row($result_review); 

									$revier_id=$review[1];
									$revierQuery = "SELECT * FROM User WHERE id='$revier_id'";
									$result_revier = mysqli_query($link, $revierQuery) or die("Ошибка".mysqli_error($link));
									$revier = mysqli_fetch_row($result_revier); 

									echo "<div class='review-item'>";
									echo "<div class='revier'>";
									echo "<img src='img/".$revier[2]."' class='revier-img'>";
									echo "<div>";
									echo "<div class='revier-name'>".$revier[1]."</div>";
									echo "<div class='review-date'>".$review[5]."</div>";
									echo "</div>";
									echo "</div>";
									echo "<div class='review-text'>".$review[4]."</div>";
									//echo "<button class='reply-review'>Ответить</button>";
									echo "</div>";
								}
							} else {
								echo "<div class='no-reviews'>Комментариев пока нет. Оставьте отзыв первым!!!</div>";
							}
							mysqli_free_result($result_review);
						}
						?>
					</div>
				</div>
				<!-- /REVIEW SECTION -->

				<!-- MAKE REVIEW SECTION -->
				<form class="review-section">
					<div class="title-review">ДОБАВИТЬ ОТЗЫВ</div>
					<?php
					if(isset($_SESSION['user']['email'])) {
						?>		
						<div class="meke-review-form">
							<textarea type="text" class="review-textarea" name="review-textarea" id="review-textarea" required></textarea>
							<button class='button add-review-btn'>Добавить отзыв</button>
						</div>
						<?php
					} else {
						echo "<div class='no-reviews'><a href='modules/authorization/authorization.php' style='font-weight:800'>Войдите</a> или <a href='modules/registration/registration.php' style='font-weight:800'>зарегистрируйтесь</a>, чтобы добавить отзыв</div>";
					}
					?>
					
				</form>
				<!-- /MAKE REVIEW SECTION -->

			</div>
		</div>
	</div>

	<script src="js/jquery-3.4.1.min.js"></script>
	<script src="js/main.js"></script>

</body>
</html>

