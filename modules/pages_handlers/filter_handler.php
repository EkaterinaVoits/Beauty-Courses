<?php 
if(session_status()!=PHP_SESSION_ACTIVE) session_start();
include '..\..\connect\connect_database.php';

$today = date('Y-m-d');

if (isset($_POST['masters_id'] ) ) {
	$implodID = implode("','", $_POST['masters_id']);
} else {
	$implodID = "";
}

if (isset($_POST['groups_type'] ) ) {
	$implodGroupType = implode("','", $_POST['groups_type']);
} else {
	$implodGroupType="";
}


// ----------- СОРТИРОВКА ------------

if(isset($_POST['sort_request'])) {
	$sorting_type=$_POST['sort_request'];

	if($sorting_type=='min_prise') {
		$sort="ORDER BY price ASC";
	} 
	if($sorting_type=='max_prise'){
		$sort="ORDER BY price DESC";
	} 
	if($sorting_type=='date_earlier'){
		$sort="ORDER BY startDate ASC";
	} 
	if($sorting_type=='date_later'){
		$sort="ORDER BY startDate DESC";		
	} 
	if ($sorting_type=='no_sort'){
		$sort="";
	}
} else {
	$sort="";
}


// --- ничего не выбрано ---
if(!isset($_POST['groups_type']) && !isset($_POST['masters_id'])){ 

	$query = "SELECT * FROM Organized_course JOIN Course ON Organized_course.ID_course=Course.ID JOIN Master ON Organized_course.ID_master=Master.ID WHERE Organized_course.startDate>'$today'";
	include '../page_elements/courses_cards.php';
	mysqli_free_result($result);
}
 
// --- фильтр по группе ---
if(isset($_POST['groups_type']) && !isset($_POST['masters_id'])){ 

	$query = "SELECT * FROM Organized_course JOIN Course ON Organized_course.ID_course=Course.ID JOIN Master ON Organized_course.ID_master=Master.ID WHERE Organized_course.startDate>'$today' AND Organized_course.groupType IN ('".$implodGroupType."') ".$sort." ";
	include '../page_elements/courses_cards.php';
	mysqli_free_result($result);
}

//фильтр по мастеру
if(!isset($_POST['groups_type']) && isset($_POST['masters_id'])){ 

	$query = "SELECT * FROM Organized_course JOIN Course ON Organized_course.ID_course=Course.ID  JOIN Master ON Organized_course.ID_master=Master.ID WHERE Organized_course.startDate>'$today' AND Organized_course.ID_master IN ('".$implodID."') ".$sort."";
	include '../page_elements/courses_cards.php';
	mysqli_free_result($result);
}

//универсальный 
	$query="SELECT * FROM Organized_course JOIN Course ON Organized_course.ID_course=Course.ID JOIN Master ON Organized_course.ID_master=Master.ID WHERE Organized_course.startDate>'$today' AND Organized_course.ID_master IN ('".$implodID."') AND Organized_course.groupType IN ('".$implodGroupType."') ".$sort."";

$result = mysqli_query($link, $query) or die("Ошибка".mysqli_error($link));

include '../page_elements/courses_cards.php';
mysqli_free_result($result);



?>

