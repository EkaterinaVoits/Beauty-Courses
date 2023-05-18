<?php

	$host = "localhost";
	$database = "_beauty_courses";
	$user = "root";
	$password="";

	$link = mysqli_connect($host, $user, $password, $database) or die("Ошибка подключения к бд".mysqli_error($link));
?>