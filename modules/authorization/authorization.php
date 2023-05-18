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
	
</head>
<body>

	<div class="align-center"> 
		<section class="main-section authorize-section">
			<div class="autorization-form">

				<div class="title">Авторизация</div>

				<div class="have-account">
					Еще не зарегистрированы? 
					<a href='../registration/registration.php' class="login_href">Зарегистрироваться</a>
				</div>
				

				<!-- Form -->
				<form class="form">
					<div class="box-input">
						<label>Введите email</label>
						<input class="input" name="email" type="text" required>
						<!--  required -->
						<span class="error-span none" name="email-error-span"></span>
					</div>
					<div class="box-input">
						<label>Введите пароль</label>
						<input class="input" name="password" type="password">
						<span class="error-span none" name="password-error-span"></span>
					</div>
					<input type="submit" class="button login-btn" value="Войти" name="login_btn">
				</form>
				<!-- /Form -->
						

				<a href="/index.php" class="goBack_href">На главную</a>
			</div>

			<!-- Image -->
			<img src="/img/1.jpg" class="image_login"/>

		</section>
	</div>

	<link rel="stylesheet" href="../../css/style.css" type="text/css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>

	<script src="../../js/main.js"></script>
<!-- 	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script> -->
	<script src="../../js/jquery-3.4.1.min.js"></script>
</body>
</html>