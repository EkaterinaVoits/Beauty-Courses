<?php 
if(session_status()!=PHP_SESSION_ACTIVE) session_start();
include '..\..\connect\connect_database.php';

$query = "SELECT * FROM Course_registration JOIN Status ON Status.ID=Course_registration.ID_status ";
$result = mysqli_query($link, $query) or die("Ошибка " .
    mysqli_error($link));

if ($result) {
    $arr = array();
    $rows = mysqli_num_rows($result);
    if($rows>0) {
        
        
        for($i = 0; $i < $rows; ++$i)
        {
            $row = mysqli_fetch_row($result);
            $reg_id = $row[0];
            $status_id = $row[3]; 
            $arr["status".$reg_id]=$status_id;
        }
    }
}
echo "<pre>";
echo var_dump($arr);
echo "</pre>";


        $response = [
            "reg_arr" => $arr ,
        ];
echo json_encode($response);
die();
        ?>

