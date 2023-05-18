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

	//---Выделение ошибочных инпутов---
	$error_fields=[];

//------------- EMAIL ---------------

	$email = $_POST["email"];
	clearString($email);
	$emailError='';

	$check_emailQuery="SELECT * FROM User WHERE email='$email'";
	$check_email=mysqli_query($link, $check_emailQuery) or die("Ошибка выполнения запроса" . 
				mysqli_error($link));

	if($email=='') {
		$error_fields[]='email';
		$emailError='Заполните поле';
	} elseif(mysqli_num_rows($check_email)==0) {
		$error_fields[]='email';
		$emailError='Такая почта не зарегистрирована';
	}


//------------- PASSWORD ---------------

	$password=$_POST["password"];
	clearString($password);
	$passwordError='';

	// $check_passwordQuery="SELECT password FROM User WHERE email='$email'";
	// $check_password=mysqli_query($link, $check_passwordQuery) or die("Ошибка выполнения запроса" . 
	// 			mysqli_error($link));
	// $database_pass=mysqli_fetch_row($check_password);

	if($password=='') {
		$error_fields[]='password';
		$passwordError='Заполните поле';
	} 
/*
	if($password!='') {
		
		$passwordError='';
	} 
*/


//------------- ERROR MESSAGE ---------------

	if(!empty($error_fields)) {
		$response = [
			"status"=> false,
			"type" => 1,
			"fields"=>$error_fields,
			"emailError"=>$emailError,
			"passwordError"=>$passwordError
		];
		echo json_encode($response);

		die();
	}


//------------- LOG IN ---------------
	
	$saltQuery="SELECT salt FROM User WHERE email='$email'";
	$saltResult = mysqli_query($link, $saltQuery) or die("Ошибка выполнения запроса" . mysqli_error($link));
	$salt = mysqli_fetch_row($saltResult);

	$password = md5(md5($password).$salt[0]);


	$check_userQuery="SELECT * FROM User WHERE email='$email' AND password='$password'";
	$check_user = mysqli_query($link, $check_userQuery);

	if(mysqli_num_rows($check_user)>0) {

		$user = mysqli_fetch_assoc($check_user);

		$_SESSION['user']= [
			"id" => $user['ID'],
			"name" => $user['name'],
			"photo" => $user['photo'],
			"email"=> $user['email'],
			"telephone" => $user['telephone']
		];
		$_SESSION['userType']=$user['userType'];

		$response = [
			"status"=>true
		];
		echo json_encode($response);
	} else {
		$response = [
			"status"=> false,
		];
		echo json_encode($response);
	}


?>


