<?php 
if(session_status()!=PHP_SESSION_ACTIVE) session_start();
include '..\..\connect\connect_database.php';

function clearString($str) {
			$str = trim($str); //удаляем пробелы 
			$str = strip_tags($str); //удаляем теги HTML
			$str = stripslashes($str); //удаляем экранирование символов
			if(isset($str)) {
				return $str;
			}	
		} 


$user_id=$_SESSION['user']['id'];

$query="SELECT * FROM User WHERE ID='$user_id'";
$result = mysqli_query($link, $query) or die("Ошибка".mysqli_error($link));
		
if($result) {
			
	$User = mysqli_fetch_assoc($result); 

	$photo=$User['photo'];
}

$user_email_beforeChanges=$_POST["user_email_beforeChanges"];	
$error_fields=[];


if(isset($_POST["name"]) && isset($_POST["telephone"]) && isset($_POST["email"])) {

	//------------- EMAIL ---------------
	$user_email = $_POST["email"];
	clearString($user_email); 
	$emailError='';

	//если юзер изменял почту
	if($user_email_beforeChanges!=$user_email) {
		$check_emailQuery="SELECT * FROM User WHERE email='$user_email'";
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

		if($user_email==='') {
				$error_fields[]='profile_email';
				$emailError='Заполните поле';
		} elseif (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
				$error_fields[]='profile_email';
				$emailError='Введенная почта не соответствует требованиям';
		}

	} 
	
	//------------- NAME ---------------
	$user_name = $_POST["name"];	
	clearString($user_name);

	$regex_name = '/[А-ЯA-Z]{1}[а-яa-z]{2,}/u';
	$nameError='';

	if($user_name==='') {
		$error_fields[]='profile_name';
		$nameError='Заполните поле';
	} elseif (!preg_match($regex_name, $user_name)) {
		$error_fields[]='profile_name';
		$nameError='Введенное имя не соответствует требованиям';
	}
	
	//------------- TELEPHONE ---------------
	$user_telephone = $_POST["telephone"];
	clearString($user_telephone);

	$regex_tel='/^\+375\((29|33|44|25)\)\d{3}-\d{2}-\d{2}$/';
	$telephoneError='';

	if($user_telephone==='') {
		$error_fields[]='profile_telephone';
		$telephoneError='Заполните поле';
	} elseif (!preg_match($regex_tel, $user_telephone)) {
		$error_fields[]='profile_telephone';
		$telephoneError='Введенный телефон соответствует требованиям';
	}

	//------------- PHOTO ---------------

	$photoError='';

	if(isset($_FILES['new_user_photo']['name'])) {

		$photo_path = 'users_photos/'.time().$_FILES['new_user_photo']['name'];

		if (!move_uploaded_file($_FILES['new_user_photo']['tmp_name'], '../../img/'.$photo_path)) {
			
			$error_fields[]='profile_photo';
			$photoError='Не удалось загрузить фото';

			$response = [
				"status"=> false,
				"type" => 2
			];
			echo json_encode($response);
		}
	} else {
		$photo_path ="users_photos/16799889301515953470.jpg";
	}

	$old_password = $_POST["old_password"];
	$new_password = $_POST["new_password"];
	$password_confirm = $_POST["password_confirm"];

	$oldPasswordError='';
	$newPasswordError='';
	$confirmPasswordError='';

	//если пользователь менял пароль
	if($old_password!="" && $new_password!="" && $password_confirm!="") {

		$userQuery="SELECT * FROM User WHERE email='$user_email_beforeChanges'";
		$userResult = mysqli_query($link, $userQuery) or die("Ошибка".mysqli_error($link));
		
		if($userResult) {
			
			$user = mysqli_fetch_assoc($userResult); 

			$oldPass=$user['password'];
			$salt=$user['salt'];

			$password = md5(md5($old_password).$salt);
			
			//если введённый пароль соответствует старому паролю
			if($oldPass==$password) {

				//------------- PASSWORD ---------------

				//Пароль должен состоять из букв латинского и русского алфавита. Не должен содержать символы (#$%^&_=+-). Длина пароля должна быть не меньше 6 символов.

				clearString($new_password);

				$regex_password = '/(?=.{6,}$)[[a-zA-Zа-яА-Я]+[^(\#\$\%\^\&\_\=\+\-)]*/';
				
				if (!preg_match($regex_password, $new_password)) {
					$error_fields[]='new_password';
					$newPasswordError='Введенный пароль не соответствует требованиям';
				} else {
					//пароль соотретствует регулярке, но два пароля не совпадают
					if($new_password!=$password_confirm) {
						$error_fields[]='new_password_confirm';
						$confirmPasswordError='Пароли не совпадают';

					// ВСЁ ВЕРНО, ЗАНЕСЕНИЕ В БД ИЗМЕНЕНИЯ
					} else {
						$new_password_withSalt=md5(md5($new_password).$salt);
						$query = "UPDATE User SET name = '$user_name', email='$user_email', telephone='$user_telephone', photo='$photo_path', password='$new_password_withSalt' WHERE ID = '$user_id'";
						$result = mysqli_query($link, $query) or die("Ошибка " .mysqli_error($link));
					}
				}
						
			} else {
				$error_fields[]='old_password';
				$oldPasswordError='Неверный пароль';
			}
		}
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
			"photoError"=>$photoError,
			"oldPasswordError"=>$oldPasswordError,
			"newPasswordError"=>$newPasswordError,
			"confirmPasswordError"=>$confirmPasswordError
		];
		echo json_encode($response);

		die();
	} else {

		$query = "UPDATE User SET name = '$user_name', email='$user_email', telephone='$user_telephone', photo='$photo_path' WHERE ID = '$user_id'";
		$result = mysqli_query($link, $query) or die("Ошибка " .mysqli_error($link));

		$response = [
			"status"=> true,
			"new_name"=>$user_name,
			"new_telephone"=>$user_telephone,
			"new_email"=>$user_email,
			"new_photo"=>$photo_path,
		];
		echo json_encode($response);
	}


}



?>
