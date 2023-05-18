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
	<?php 
	require 'modules/page_elements/header.php';
	$today = date('Y-m-d');
	?>

	<div class="container">
		<div class="align-content-center-2"> 

			<!--------- ALL FILTERS --------->
			<div class="filters"> 

				<!-- FILTER -->
				<div class="sorting-div">
					<div>Сортировать:</div>
					<select name="sorting" id="sorting">
						<option value="no_sort"></option>
						<option value="min_prise">По цене(min)</option>
						<option value="max_prise">По цене(max)</option>
						<option value="date_earlier">По дате(ближайшие)</option>
						<option value="date_later">По дате(дальнейшие)</option>
					</select>
				</div>
				<!-- /FILTER -->

				<!-- SORT BY MASTER -->
				<fieldset id="master_filter">
					<legend>Выберите мастера:</legend>
					<div>
						<?php

						$query = "SELECT * FROM Master";
						$result = mysqli_query($link, $query) or die("Ошибка".mysqli_error($link));

						if($result)
						{
							$rows = mysqli_num_rows($result);
							for($i = 0; $i < $rows; ++$i)
							{
								$row = mysqli_fetch_assoc($result); 
								echo "<div>";
								echo "<input type='checkbox' class='all-checkboxes masters-ckbx' name='masters' value='".$row['ID']."'>";
								echo "<label for='masters'>".$row['name']."</label>";
								echo "</div>";
							}
						}
						?>
					</div> 
				</fieldset>
				<!-- /SORT BY MASTER -->

				<!-- SORT BY GROUP TYPE -->
				<fieldset id="group_filter">
					<legend>Выберите группу:</legend>
					<div>
						<?php

						$query = "SELECT DISTINCT groupType FROM Organized_course";
						$result = mysqli_query($link, $query) or die("Ошибка".mysqli_error($link));

						if($result)
						{
							$rows = mysqli_num_rows($result);
							for($i = 0; $i < $rows; ++$i)
							{
								$row = mysqli_fetch_assoc($result); 
								echo "<div>";
								echo "<input type='checkbox' class='all-checkboxes groups-ckbx' name='group' value='".$row['groupType']."'>";
								echo "<label for='group'>".$row['groupType']."</label>";
								echo "</div>";
							}
						}
						?>
					</div> 
				</fieldset>

				<!-- SORT BY GROUP TYPE -->

			</div>
			<!--------- /ALL FILTERS --------->

			<!--------- CATALOG COURSES --------->
			<div class="courses">

				<?php
				$query = "SELECT * FROM Organized_course JOIN Course ON Organized_course.ID_course=Course.ID JOIN Master ON Organized_course.ID_master=Master.ID WHERE Organized_course.startDate>'$today'";

				include 'modules/page_elements/courses_cards.php';

				?>
 
			</div>

			
			
			<!--------- /CATALOG COURSES --------->
		</div>
	</div>
</body>

<script src="js/jquery-3.4.1.min.js"></script>
<script src="js/main.js"></script>
</html>

