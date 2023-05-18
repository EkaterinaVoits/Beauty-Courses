<?php

if(session_status()!=PHP_SESSION_ACTIVE) session_start();
include '..\..\connect\connect_database.php';

//---Функция обрабатывающая поля---
	function clearString($str) {
			$str = trim($str); //удаляем пробелы 
			$str = strip_tags($str); //удаляем теги HTML
			$str = stripslashes($str); //удаляем экранирование символов
			if(isset($str)) {
				return $str;
			}	
		} 


	$error_fields=[];


//------------- EMAIL ---------------

	$email = $_POST["email"];
	clearString($email); 
	$emailError='';

	$check_emailQuery="SELECT * FROM User WHERE email='$email'";
	$check_email=mysqli_query($link, $check_emailQuery) or die("Ошибка выполнения запроса" . 
				mysqli_error($link));

	if(mysqli_num_rows($check_email)>0) {
		$response = [
			"status"=> false,
			"type" => 1,
			"emailError"=>'Эта почта уже зарегистрирована',
			"fields"=>['email']
		];
		echo json_encode($response);

		die(); 
	}

	if($email==='') {
		$error_fields[]='email';
		$emailError='Заполните поле';
	} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$error_fields[]='email';
		$emailError='Введенная почта не соответствует требованиям';
	}

//------------- NAME ---------------

	$name = $_POST["name"];
	clearString($name);

	$regex_name = '/[А-ЯA-Z]{1}[а-яa-z]{2,}/u';
	$nameError='';

	if($name==='') {
		$error_fields[]='name';
		$nameError='Заполните поле';
	} elseif (!preg_match($regex_name, $name)) {
		$error_fields[]='name';
		$nameError='Введенное имя не соответствует требованиям';
	}


//------------- TELEPHONE ---------------

	$telephone = $_POST["telephone"];
	clearString($telephone);


	$regex_tel='/^\+375\s\((29|33|44|25)\)\s\d{3}-\d{2}-\d{2}$/';
	$telephoneError='';

	if($telephone==='') {
		$error_fields[]='telephone';
		$telephoneError='Заполните поле';
	} elseif (!preg_match($regex_tel, $telephone)) {
		$error_fields[]='telephone';
		$telephoneError='Введенный телефон соответствует требованиям';
	}


//------------- PHOTO ---------------
/*
	if(!$_FILES['photo']) {
		$error_fields[]='photo';
	}
*/

//------------- PASSWORD ---------------

	//Пароль должен состоять из букв латинского и русского алфавита. Не должен содержать символы (#$%^&_=+-). Длина пароля должна быть не меньше 6 символов.

	$password = $_POST["password"];
	clearString($password);

	$regex_password = '/(?=.{6,}$)[[a-zA-Zа-яА-Я]+[^(\#\$\%\^\&\_\=\+\-)]*/';
	$passwordError='';
	
	if($password==='') {
		$error_fields[]='password';
		$passwordError='Заполните поле';
	} elseif (!preg_match($regex_password, $password)) {
		$error_fields[]='password';
		$passwordError='Введенный пароль не соответствует требованиям';
	} elseif ($password!='' && preg_match($regex_password, $password)) {
		$passwordError='';
	}


//------------- PASSWORD_CONFIRM---------------

	$password_confirm = $_POST["password_confirm"];
	clearString($password_confirm);

	$password_confirmError='';
	
	if($password_confirm==='') {
		$error_fields[]='password_confirm';
		$password_confirmError='Заполните поле';
	} 

//------------- ERROR MESSAGE---------------

	if(!empty($error_fields)) {
		$response = [
			"status"=> false,
			"type" => 1,
			"fields"=>$error_fields,
			"nameError"=>$nameError,
			"emailError"=>$emailError,
			"telephoneError"=>$telephoneError,
			"passwordError"=>$passwordError,
			"password_confirmError"=>$password_confirmError
		];
		echo json_encode($response);

		die();
	}


//------------- REGISTRATION---------------

	if($password===$password_confirm) {

		//----загрузка фото-----
		$photo_path = 'users_photos/'.time().$_FILES['photo']['name'];
		if (!move_uploaded_file($_FILES['photo']['tmp_name'], '../../img/'.$photo_path)) {
			$response = [
				"status"=> false,
				"type" => 2
			];
			echo json_encode($response);
		}

		$salt = mt_rand(100, 999);
		$password = md5(md5($password).$salt);

		$query="INSERT INTO User (name, photo, email, telephone, password, salt) 
		VALUES ('$name','$photo_path','$email','$telephone','$password','$salt')";
		$result = mysqli_query($link, $query) or die("Ошибка " . 
				mysqli_error($link));


		$userQuery="SELECT * FROM User WHERE email='$email' AND password='$password'";
		$user_result = mysqli_query($link, $userQuery);

		$user = mysqli_fetch_assoc($user_result);
		
		$_SESSION['user']= [
			"id" => $user['ID'],
			"name" => $user['name'],
			"photo" => $user['photo'],
			"email"=> $user['email'],
			"telephone" => $user['telephone'],
			"password" => $user['password']
		];
		$_SESSION['userType']=$user['userType'];
		
		$response = [
			"status"=> true,
		];
		echo json_encode($response);

	} else {
	 	
		$response = [
			"status"=> false,
			"fields"=>$error_fields,
			"password_confirmError" => "Пароли не совпадают",
		];
		echo json_encode($response);

	}
?>

