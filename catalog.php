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
		<script src="js/jquery-3.4.1.min.js"></script>
		
		<script src="js/main.js"></script>
	<link rel="stylesheet" href="css/style.css" type="text/css">
</head>

<body>
	<?php require 'modules/page_elements/header.php';?>

	<div class="container">
		<div class="align-content-center"> 
			<div class="our-courses-title">Наши курсы</div>
			<div class="catalog-items">
				<?php
				$query = "SELECT * FROM Course";
				$result = mysqli_query($link, $query) or die("Ошибка".mysqli_error($link));

				if($result)
				{
					$rows = mysqli_num_rows($result);
					for($i = 0; $i < $rows; ++$i)
					{
						$row = mysqli_fetch_assoc($result); 
						echo "<div class='course-item'>"; 
						echo "<img src='img/courses_images/".$row['photo']."' class='course-item-img'/>"; 
						// echo "<svg width='28' id='like".$row['ID']."' class='like' height='24' viewBox='0 0 44 36' fill='none'  stroke='black' stroke-width='2' xmlns='http://www.w3.org/2000/svg'>
						// 	<path d='M21.1563 5.93687L22 7.26263L22.8437 5.93687C24.7592 2.9268 28.1401 1 32 1C38.0477 1 43 5.95228 43 12C43 14.6991 41.7576 17.4919 39.7561 20.2211C37.7623 22.94 35.082 25.5045 32.3668 27.726C29.6564 29.9436 26.9411 31.7953 24.9006 33.0938C23.8814 33.7425 23.0329 34.2515 22.4407 34.5976C22.2733 34.6954 22.1263 34.7803 22.0019 34.8515C21.8772 34.7796 21.7299 34.6939 21.562 34.5951C20.9697 34.2464 20.1211 33.7338 19.1016 33.0812C17.0608 31.7748 14.3451 29.9135 11.6343 27.6894C8.91854 25.4613 6.23771 22.8932 4.24343 20.1783C2.24096 17.4522 1 14.6725 1 12C1 5.95228 5.95228 1 12 1C15.8599 1 19.2408 2.9268 21.1563 5.93687Z'/>
						// </svg>"; 
						echo "<div class='course-item-title'>".$row['title']."</div>"; 
						echo "<div class='course-item-description'>".$row['description']."</div>"; 
						echo "<div class='course-item-price'>".$row['price']." BYN</div>"; 

						echo "<button class='button show-course-btn' onclick='showCourse(this.id) ' id=".$row['ID']." >Узнать больше</button>"; 
						echo "</div>"; 
						}
						mysqli_free_result($result); 
					}
					?>
				</div>
			</div>
		</div>



		<script src="js/jquery-3.4.1.min.js"></script>
		
		<script src="js/main.js"></script>

	</body>
	</html>