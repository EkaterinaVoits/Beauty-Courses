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

			<?php
			$user_id=$_SESSION['user']['id'];

			$userQuery="SELECT * FROM User WHERE ID='$user_id'";
			$user_result = mysqli_query($link, $userQuery);

			$user = mysqli_fetch_assoc($user_result);

			$user_name=$user['name'];
			$user_telephone=$user['telephone'];
			$user_email=$user['email'];
			$user_photo=$user['photo'];
			?>


			<!--------- PANEL --------->
			<div class="panel">
				<ul class="tabs">
					<li class="tab" id='profile-tab'>Мой профиль</li>
					<li class="tab" id='user-courses-tab'>Мои курсы</li>
					<li class="tab" id='liked-courses-tab'>Изобранное</li>
				</ul>
			</div>
			<!--------- /PANEL --------->

			<!--------- PROFILE BLOCK --------->			
			<div class="block profile-body" style="display: block;" id="profile-block">
				<div id="profile_content">
					<div class="align-profile-content">
						<div class="profile-info-block">
						
							<img src="../../img/<?= $user_photo ?>" class="profile-img" id="profile-img" alt="Фото профиля">

							<div class='profile-info'>
								<div class="profile-name" id="profile-name1"><?= $user_name ?></div>
								<div class="profile-telephone" id="profile-telephone1"><?= $user_telephone ?></div>
								<div class="profile-email" id="profile-email1"><?= $user_email ?></div>
							</div>
						</div>
						<button class="edit-profile-btn">
							<img src="../../img/edit_icon.png" class="edit-icon">
						</button>
					</div>
					
				</div>


				<div class="change_profile_content" id="change_profile_content">
					<div class="align-profile-content-2" >

						<div class="edit-img-div">
							<img src="../../img/<?= $user_photo ?>" class="profile-img" id="profile-img2" alt="Фото профиля">
						</div>
					
						<div class="inputs-margin">
							<div class="box-input">
								<label>Ваше имя</label>
								<input class="input" name="profile_name" type="text" value="<?= $user_name ?>" required>
								<span class="error-span none" name="profile_name-error-span"></span>
							</div>
							<div class="box-input">
								<label>Номер телефона</label>
								<input class="input" name="profile_telephone" type="text" value="<?= $user_telephone ?>" required>
								<span class="error-span none" name="profile_telephone-error-span"></span>
							</div>
							<div class="box-input">
								<label>Почта</label>
								<input class="input" name="profile_email" type="text" value="<?= $user_email ?>" required>
								<span class="error-span none" name="profile_email-error-span"></span>
							</div>
						</div>

						<div class="inputs-margin">
							<div class="box-input">
								<label>Старый пароль</label>
								<input class="input" name="old_password" id="old_password" type="password">
								<span class="error-span none" name="old_password-error-span"></span>
							</div>
							<div class="box-input">
								<label>Новый пароль</label>
								<input class="input" name="new_password" id="new_password" type="password" >
								<span class="error-span none" name="new_password-error-span"></span>
							</div>
							<div class="box-input">
								<label>Повторите новый пароль</label>
								<input class="input" name="new_password_confirm" id="new_password_confirm" type="password" >
								<span class="error-span none" name="new_password_confirm-error-span"></span>
							</div>

						</div>
					</div>

					<div class="edit-buttons">
						<div>
							<button class="change-btn" id="change-profile-img-btn">Изменить фотографию</button>
							<div class="box-input" id="load_new_photo" style="display: none;">
								<input class="input" name="new_profile_photo" id="new_profile_photo_input" type="file" >
								<span class="error-span none" name="photo-error-span"></span>
							</div>
						</div>
						
						<!-- onclick='saveEditChanges()' -->
						<button class="button save_edit_changes" id="<?= $user_email ?>">Сохранить изменения</button>
					</div>
					<div style="display: flex; justify-content: flex-end;">
						<button class="go-back-toProfile-btn">Назад</button>
					</div>
			</div>

		</div>
		<!--------- /PROFILE BLOCK --------->

		<!--------- COURSES BLOCK --------->
		<div class="block" id="user-courses-block">

			<?php
			$query = "SELECT * FROM Course_registration JOIN Organized_course ON Course_registration.ID_orginizedCourse=Organized_course.ID JOIN Course ON Organized_course.ID_course=Course.ID JOIN Status ON Course_registration.ID_status=Status.ID JOIN Master ON Organized_course.ID_master=Master.ID WHERE Course_registration.ID_user='$user_id'";
			$result = mysqli_query($link, $query) or die("Ошибка".mysqli_error($link));

			if($result)
			{
				$rows = mysqli_num_rows($result);
				if($rows>0) {
					for($i = 0; $i < $rows; ++$i)
					{
						//$row = mysqli_fetch_assoc($result); 
						$row = mysqli_fetch_row($result); 


						echo "<div class='course-item-2'>"; 
						echo "<img src='../../img/courses_images/".$row[15]."' class='course-item-img-2' style='width:340px'/>"; 

						echo "<div>"; 

						echo "<div class='course-item-title-2'>".$row[12]."</div>"; 
						echo "<div class='course-item-description-2'>".$row[13]."</div>"; 

						echo "<div class='course-description'>"; 
						echo "<div>Начало: <span>".$row[7]."</span></div>"; 
						echo "<div>Продолжительность: <span>".$row[8]."</span></div>"; 
						echo "<div>Группа: <span>".$row[9]."</span></div>";
						echo "<div>График: <span>".$row[10]."</span></div>";
						echo "<div>Преподаватель: <span>".$row[20]."</span></div>";
						echo "<div>Стоимость: <span>".$row[14]." byn</span></div>";
						echo "<div class='status'>".$row[18]."</div>";

						if($row[17]=="1") {
							echo "<div><button class='button cancel-reg-btn' id='".$row[0]."' onclick='cancelReg(this.id)'>Отменить заявку</button></div>";
						}

						echo "</div>";

						echo "</div>"; 
						echo "</div>"; 
					}
				} else {
					echo "<div>Вы не записаны ни на какой курс. Успейте записаться!</div>";
				}
			} 
			?>
		</div>
		<!--------- /COURSES BLOCK --------->  

		<!--------- LIKED COURSES BLOCK --------->
		<div class="block" id="liked-courses-block">
			<div class="catalog-items-3">
				<?php
				$query = "SELECT * FROM Liked_course JOIN Course ON Liked_course.ID_course=Course.ID WHERE Liked_course.ID_user='$user_id'";
				$result = mysqli_query($link, $query) or die("Ошибка".mysqli_error($link));

				if($result)
				{
					$rows = mysqli_num_rows($result);
					if($rows>0) {
						for($i = 0; $i < $rows; ++$i)
						{
							$row = mysqli_fetch_assoc($result); 
							echo "<div class='course-item-3'>"; 
							echo "<img src='../../img/courses_images/".$row['photo']."' class='course-item-img-3'/>"; 
							echo "<div class='course-item-title-3'>".$row['title']."</div>"; 
							echo "<div class='course-item-description-3'>".$row['description']."</div>"; 
							echo "<div class='course-item-price-3'>".$row['price']." BYN</div>"; 

							/*echo "<button class='button show-course-btn' id=".$row['ID'].">Узнать больше</button>"; */
							echo "</div>"; 
						}
						mysqli_free_result($result);
					} else {
						echo "<div>Пока изобранных курсов у вас нет. Успейте выбрать понравившиеся!</div>";
					}

				}
				?>
			</div>
		</div>  
		<!--------- /LIKED COURSES BLOCK --------->

	</div>
</div>
<!-------- /BODY -------->

</body>

<link rel="stylesheet" href="../../css/style.css" type="text/css">
<script src="../../js/jquery-3.4.1.min.js"></script>
<script src="../../js/main.js"></script>

</html>