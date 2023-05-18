<link rel="stylesheet" href="../../css/style.css" type="text/css">

<meta charset="UTF-8">
<?php
session_start();
?>
<div class="align-center"> 
	<section class="main-section"> 

		<!-- Image -->
		<img src="/img/2.jpg" class="image_reg">

		<div class="registration-form">
			<div class="title">Регистрация</div>

				<div class="have-account">
					Уже зарегистрированы? 
					<a href='../authorization/authorization.php' class="login_href">Войти</a>
				</div>

				<!-- Form -->
				<form class="form">
					<div class="box-input">
						<label>Введите имя</label>
						<input class="input " name="name" type="text" title="Не менее 3 символов. Начинается с заглавной буквы.">
						<span class="error-span none" name="name-error-span"></span>
					</div>
					<div class="box-input">
						<label>Введите E-mail</label>
						<input class="input" name="email" type="text">
						<span class="error-span none" name="email-error-span"></span>
					</div>
					<div class="box-input">
						<label>Введите телефон</label>
						<input class="input tel_input" name="telephone" type="text" placeholder="+375 (__) ___-__-__">
						<span class="error-span none" name="telephone-error-span"></span>
					</div>
					<div class="box-input">
						<label>Изображение профиля</label>
						<input class="input" name="photo" type="file" >
						<span class="error-span none" name="photo-error-span"></span>
					</div>
					<div class="box-input">
						<label>Введите пароль</label>
						<input class="input" name="password" type="password" title="Пароль должен состоять из букв латинского и русского алфавита. Не должен содержать символы (#$%^&_=+-). Длина не меньше 6 символов.">
						<span class="error-span none" name="password-error-span"></span>
					</div>
					<div class="box-input">
						<label>Повторите пароль</label>
						<input class="input" name="password_confirm" type="password">
						<span class="error-span none" name="password_confirm-error-span"></span>
					</div>

					
					<input type="submit" class="button reg-btn" value="Зарегистрироваться">

					
				</form> 
				<!-- /Form -->

				<a href="/index.php" class="goBack_href">На главную</a>

		</div>
	</section>

</div>

<script src="../../js/jquery-3.4.1.min.js"></script><script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>

<script src="../../js/main.js"></script>

