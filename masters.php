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
			<div class="our-courses-title">Наши преподаватели</div>
			<div class="catalog-items">
				<?php
				$query = "SELECT * FROM Master";
				$result = mysqli_query($link, $query) or die("Ошибка".mysqli_error($link));

				if($result)
				{
					$rows = mysqli_num_rows($result);
					for($i = 0; $i < $rows; ++$i)
					{
						$row = mysqli_fetch_assoc($result); 
						echo "<div class='master-item'>"; 
						echo "<img src='img/masters_photos/".$row['photo']."' class='master-item-img'/>"; 
						echo "<div class='master-item-name'>".$row['name']."</div>"; 
						// echo "<div class='master-item-email'>".$row['email']."</div>"; 
						echo "<div class='master-item-info'>".$row['info']."</div>"; 
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