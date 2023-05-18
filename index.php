<!DOCTYPE html>
<?php 
	if(session_status()!=PHP_SESSION_ACTIVE) session_start();
	include 'C:\OSPanel\domains\project1\connect\connect_database.php';
?>
<html>
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Beauty courses project</title>
	<link rel="stylesheet" href="css/style.css" type="text/css">
</head>

<body>
	<?php require 'modules/page_elements/header.php';?>
	<?php require 'modules/page_elements/body.php';?>

<div class="container">
		<div class="align-content-center"> 
	<div class="consult-block">
		
			<div class="consult-title">
				Хотите получить консультацию? <br>Заполните форму, и мы с вами свяжемся!
			</div>
			<form class="consult-form">
				<div>
					<div class="box-input">
						<label>Ваше имя</label>
						<input class="input2 " name="user_name_consult" id="user_name_consult" type="text">
					</div>
					
					<div class="box-input">
						<label>Номер телефона</label>
						<input class="input2 tel_input" name="user_telephone_consult" id="user_telephone_consult" type="text" placeholder="+375 (__) ___-__-__">
					</div>
				</div>
				<button class="button take-consult-btn">Оставить заявку</button>
			</form>
		
	</div>
</div>
</div>
	<?php require 'modules/page_elements/footer.php';?>

</body>

<script src="js/jquery-3.4.1.min.js"></script>
<script src="js/main.js"></script>

</html>




