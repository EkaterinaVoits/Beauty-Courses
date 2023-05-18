<!DOCTYPE html>
<?php 
if(session_status()!=PHP_SESSION_ACTIVE) session_start();
include '..\..\connect\connect_database.php';
?>
<html>
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Beauty courses project</title>
	<link rel="stylesheet" href="../../css/style.css" type="text/css">

	<!-- Bootstrap CSS (jsDelivr CDN) -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

</head>

<body>

	<!-------- HEADER -------->
	<header>
		<div class="container">
			<div class="wrapper"> 


				<!-- Logo -->
				<div class="logo"> 
					<a href="/index.php">
						YOUR BEAUTY 
					</a>
				</div>
				<!-- Logo -->

				<!-- Navigation -->		
				<div class="nav">
					<?php include '../menu/menu.php'; ?>
				</div>
				<!-- /Navigation -->

				<!-- Autorization -->
				<div class="autorize">
					<ul class="menu">
						<li class="menu_item">	
							<?php echo "<a href='../authorization/authorization_out.php'>Выйти</a>"; ?>	
						</li>
					</ul>
				</div>
				<!-- Autorization -->

			</div>
		</div>
	</header>
	<!-------- /HEADER -------->

	<!-------- BODY -------->
	<div class="container">
		<div class="wrapper-2">

			<!--------- PANEL --------->
			<div class="panel adm-panel">
				<ul class="tabs">
					<li class="tab" id='registration-admin-tab'>Регистрация</li>
					<li class="tab" id='masters-admin-tab'>Мастера</li>
					<li class="tab" id='org-courses-tab'>Орг.курсы</li>
					<li class="tab" id='courses-admin-tab'>Курсы</li>
					<li class="tab" id='consult-admin-tab'>Консультация</li>

				</ul>
			</div>
			<!--------- /PANEL --------->

			<!--------- REGISTRATION BLOCK --------->
			<div class="block" style="display: block;" id="admin-registration-block">

				<div class="block-2" > 
					<div class="title title-2">Управление регистрацией на курс</div>
					<div class="reg-table col-12">
						<div class="title-table row"> 
							<div class="col-1">ID</div>
							<div class="col-2">email клиента</div>
							<div class="col-1">ID орг. курса</div>
							<div class="col-2">Название курса</div>
							<!-- <div class="col-3">Статус</div> -->
							<div class="col-2">Статус</div>
							<div class="col-4">Управление</div>
						</div>
						<div class='reg-body-table'>

							<?php 
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
							
								?>
						</div>
					</div>
				</div>
				<div class="add-master-block"> 
					<form>
						<div class="title">Добавить регистрацию</div>
								<div>
									<div class="box-input-2">
										<label>Введите email пользователя</label>
							            <input name="users-email" id="users_email" type="email" required>
									</div>
									<div class="box-input-2">
										<label>Выберите орг.курс</label>
									 	<select name="org-course-select1" id="org_course_select1">
											<?php
												$query = "SELECT * FROM Organized_course JOIN Course ON Organized_course.ID_course=Course.ID";
												$result = mysqli_query($link, $query) or die("Ошибка".mysqli_error($link));

												if($result)
												{
													$rows = mysqli_num_rows($result);
													for($i = 0; $i < $rows; ++$i)
													{
														$row = mysqli_fetch_row($result); 
														echo "<option value='".$row[0]."'>".$row[8]." (ID курса = ".$row[0].")</option>";
													}
												}
											?>
										</select>
									</div>

								</div>
						  <button id="add_reg_btn" class='button'>добавить</button> 
				    </form>
				</div>
			</div>
		<!--------- /REGISTRATION BLOCK --------->

		<!--------- MASTERS BLOCK --------->
		<div class="block" id="admin-masters-block">
			<div class="block-3" > 
					<div class="title title-2">Мастера</div>
					<div class="masters-table col-9">
						<div class="title-table row"> 
							<div class="col-1">ID</div>
							<div class="col-2">Имя</div>
							<div class="col-3">email</div>
							<div class="col-2">Телефон</div>
							<div class="col-2">Доп.инфо</div>
							<div class="col-2">Управление</div>
						</div>


						<div class='masters-body-table row'>

							<?php 
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
						</div>
					</div>
				</div>

				<div class="add-master-block"> 
					<form>
						<div class="title">Добавить мастера</div>
							
								<div>
									<div class="box-input-2">
									 	<label>Введите имя</label>
										<input type="text" name="masters-name" id="masters_name" required/>
									</div>
									<div class="box-input-2">
										<label>Фото мастера</label>
										<input name="masters_photo" id="masters_photo" type="file" >
									</div>
									<div class="box-input-2"> 
										<label>Введите email</label>
							            <input name="masters-email" id="masters_email" type="text" required>
									</div>
									<div class="box-input-2">
										<label>Введите номер телефона</label>
							            <input name="masters-telephone" id="masters_telephone" type="text" required>
									</div>
									<div class="box-input-2">
										<label>Дополнительная информация</label>
				            			<textarea id='masters_info' name="masters-info" required></textarea>
									</div>

								</div>
						  <button id="add_master_btn" class='button'>добавить</button> 
				    </form>
				</div>
		</div> 
		<!--------- /MASTERS BLOCK ---------> 

		<!--------- ORGANIZED COURSE BLOCK --------->
		<div class="block" id="admin-org-courses-block">
			<div class="block-4" > 
					<div class="title title-2">Организованные курсы</div>
					<div class="org-courses-table col-12">
						<div class="title-table row"> 
							<div class="col-1">ID</div>
							<div class="col-1">ID курса</div>
							<div class="col-2">Курс</div>
							<div class="col-1">ID мастера</div>
							<div class="col-2">Мастер</div>
							<div class="col-2">Дата</div>
							<div class="col-1">Тип группы</div>
							<div class="col-2">График</div>
						</div>


						<div class='org-courses-body-table row'>

							<?php 
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
						</div>
					</div>
				</div>

				<div class="add-org-course-block"> 
					<form>
						<div class="title">Добавить курс</div>
								<div>
									<div class="box-input-2">
									 	<label>Выберите курс</label>
									 	<select name="course-select" id="course_select">
											<?php
												$query = "SELECT * FROM Course";
												$result = mysqli_query($link, $query) or die("Ошибка".mysqli_error($link));

												if($result)
												{
													$rows = mysqli_num_rows($result);
													for($i = 0; $i < $rows; ++$i)
													{
														$row = mysqli_fetch_assoc($result); 
														echo "<option value='".$row['ID']."'>".$row['title']." (ID курса = ".$row['ID'].")</option>";
													}
												}
											?>
										</select>
									</div>
									<div class="box-input-2">
									 	<label>Выберите мастера</label>
										<select name="master-select" id="master_select">
											<?php
												$query = "SELECT * FROM Master";
												$result = mysqli_query($link, $query) or die("Ошибка".mysqli_error($link));

												if($result)
												{
													$rows = mysqli_num_rows($result);
													for($i = 0; $i < $rows; ++$i)
													{
														$row = mysqli_fetch_assoc($result); 
														echo "<option value='".$row['ID']."'>".$row['name']." (ID мастера = ".$row['ID'].")</option>";
													}
												}
											?>
										</select>
									</div>									
									<div class="box-input-2"> 
										<label>Выберите дату начала курса</label>
							            <input name="course-startDate" id="course_startDate" type="date" required>
									</div>
									<div class="box-input-2">
										<label>Введите продолжительность курса</label>
				            			<input name="course-duration" id="course_duration" type="text" required>
									</div>
									<div class="box-input-2">
										<label>Введите тип группы</label>
							            <select name="course-groupType-select" id="course_groupType_select">
											<?php
												$query = "SELECT DISTINCT groupType FROM Organized_course";
												$result = mysqli_query($link, $query) or die("Ошибка".mysqli_error($link));

												if($result)
												{
													$rows = mysqli_num_rows($result);
													for($i = 0; $i < $rows; ++$i)
													{
														$row = mysqli_fetch_row($result); 
														echo "<option value='".$row[0]."'>".$row[0]."</option>";
													}
												}
											?>
										</select>
									</div>
									<div class="box-input-2">
										<label>Введите график</label>
				            			<input name="course-schedule" id="course_schedule" type="text" required>
									</div>
								</div>
						  <button id="add_org_course_btn" class='button'>добавить</button> 
				    </form>
				</div>

		</div>  
		<!--------- /ORGANIZED COURSE BLOCK --------->

		<!------------- COURSE BLOCK ------------->
		<div class="block" id="admin-courses-block">
			<div class="block-4" > 
					<div class="title title-2">Курсы</div>
					<div class="courses-table col-12">
						<div class="title-table row"> 
							<div class="col-1">ID</div>
							<div class="col-2">Название</div>
							<div class="col-3">Описание</div>
							<div class="col-2">Стоимость</div>
							<div class="col-3">Управление</div>
						</div>


						<div class='courses-body-table row'>

							<?php 
								$query = "SELECT * FROM Course";
								$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));

							    if($result) {
							    	$rows = mysqli_num_rows($result);
									if($rows>0) {
									for($i = 0; $i < $rows; ++$i)
									{
										$row = mysqli_fetch_row($result); 
										echo "<div id='row".$row[0]."' class='row row-margin'>";
										echo "<div class='col-1'>".$row[0]."</div>";
										echo "<div id='title-course".$row[0]."' class='col-2'>".$row[1]."</div>";
										echo "<div id='description-course".$row[0]."'class='col-3'>".$row[2]."</div>";
										echo "<div class='col-2'><span id='price-course".$row[0]."'>".$row[3]."</span> BYN</div>";
										echo "<button class='edit-course-btn del-btn col-2' id='".$row[0]."' onclick='editCourse(this.id)'>Редактировать</button>";
										echo "<button class='del-course-btn del-btn col-2' id='".$row[0]."' onclick='deleteCourse(this.id)'>Удалить</button>";
										echo "</div>";
									}
									}
								}
								?>
						</div>
					</div> 
				</div>

				<!-- <div class="add-org-course-block"> 
					<form>
						<div class="title">Редактировать</div>								
									
									<div class="box-input-2">
										<label>Название курса</label>
				            			<input name="course-name" id="course_name" type="text" required>
									</div>
									<div class="box-input-2">
										<label>Описание курса</label>
										<textarea type="text" class="review-textarea" name="course-description" id="course-description" required></textarea>
									</div>
									<div class="box-input-2">
										<label>Стоимость курса</label>
				            			<input name="course-price" id="course_price" type="number" required>
									</div>
								
						  <button id="save-course-changes-btn" class='button'>сохранить изменения</button> 
				    </form>
				</div> -->

		</div>  
		<!------------- /COURSE BLOCK ------------->

		<!------------- CONSULT BLOCK ------------->
		<div class="block" id="admin-consult-block">
			<div class="block-4" > 
					<div class="title title-2">Консультация</div>
					<div class="courses-table col-12">
						<div class="title-table row"> 
							<div class="col-1">ID</div>
							<div class="col-2">Имя клиента</div>
							<div class="col-2">Номер телефона</div>
							<div class="col-3">Статус</div>
							<div class="col-4">Управление</div>
						</div>


						<div class='courses-body-table row'>

							<?php 
								$query = "SELECT * FROM Consultation JOIN Status_consultation ON Consultation.ID_status=Status_consultation.ID";
								$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));

							    if($result) {
							    	$rows = mysqli_num_rows($result);
									if($rows>0) {
									for($i = 0; $i < $rows; ++$i)
									{
										$row = mysqli_fetch_row($result); 
										echo "<div id='row".$row[0]."' class='row row-margin'>";
										echo "<div class='col-1'>".$row[0]."</div>";
										echo "<div class='col-2'>".$row[1]."</div>";
										echo "<div class='col-2'>".$row[2]."</div>";
										echo "<div class='col-3' id='consult_status".$row[0]."'>".$row[5]."</div>";

										$query2 = "SELECT * FROM Status_consultation";
											$result2 = mysqli_query($link, $query2) or die("Ошибка".mysqli_error($link));
											echo "<select name='status-select' id='".$row[0]."' class='status_select2 col-2'>";

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

											echo "<button class='del-consult-btn del-btn col-2' id='".$row[0]."'>Удалить</button>";
									}
									}
								}
								?>
						</div>
					</div> 
				</div>
			</div>


	</div>
</div>
<!-------- /BODY -------->

</body>

<link rel="stylesheet" href="../../css/style.css" type="text/css">
<script src="../../js/jquery-3.4.1.min.js"></script>
<script src="../../js/main.js"></script>

</html>