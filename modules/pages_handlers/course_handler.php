<?php 
if(session_status()!=PHP_SESSION_ACTIVE) session_start();
include '..\..\connect\connect_database.php';

$ID=$_GET["id"];
$_SESSION['id_course']=$ID;

if($ID != '') {
	echo $ID;
}

?>