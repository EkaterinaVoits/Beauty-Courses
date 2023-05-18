<?php 

require_once'C:\OSPanel\domains\project1\connect\connect_database.php';

$query = "SELECT * FROM Menu";
$result = mysqli_query($link, $query) or die("Ошибка выполнения запроса".
		mysqli_error($link));

for ($i=0; $i<mysqli_num_rows($result); $i++) {
	$menu=mysqli_fetch_row($result);
	echo "<a class='menu_item' href=".$menu[2].">".$menu[1]."</a>";	
}

?>