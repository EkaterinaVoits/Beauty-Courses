<?php 
if(session_status()!=PHP_SESSION_ACTIVE) session_start();
include '..\..\connect\connect_database.php';

$reg_id=$_POST['reg_id'];

$dropQuery = "DELETE FROM Course_registration WHERE Course_registration.ID = $reg_id";
$resultDrop = mysqli_query($link, $dropQuery) or die("Ошибка " .
    mysqli_error($link));

$query = "SELECT * FROM Course_registration JOIN User ON Course_registration.ID_user=User.ID JOIN Status ON Course_registration.ID_status=Status.ID JOIN Organized_course ON Course_registration.ID_orginizedCourse=Organized_course.ID JOIN Course ON Organized_course.ID_course=Course.ID";
$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));


if($result) {
    $rows = mysqli_num_rows($result);
    if($rows>0) {
        for($i = 0; $i < $rows; ++$i)
        {
            $row = mysqli_fetch_row($result); 

            echo "<div class='row row-margin'>";
            echo "<div class='reg_id col-1'>".$row[0]."</div>";
            echo "<div class='client_id col-2'>".$row[7]."</div>";
            echo "<div class='course_id col-1'>".$row[2]."</div>";
            echo "<div class='course_name col-2'>".$row[22]."</div>";
            echo "<div class='course_status col-2'>".$row[13]."</div>";

            $query2 = "SELECT * FROM Status";
            $result2 = mysqli_query($link, $query2) or die("Ошибка".mysqli_error($link));
            echo "<select name='status-select' id='".$row[0]."' class='status_select col-2'>";

            if($result2)
            {
                $rows2 = mysqli_num_rows($result2);
                echo "<option value='none'></option>";
                for($j = 0; $j < $rows2; ++$j)
                {
                    $row2 = mysqli_fetch_row($result2); 
                    echo "<option value='".$row2[0]."'>".$row2[1]."</option>";
                }
            }

            echo "</select>";

            "</div>";
            echo "<button class='del-reg-btn del-btn col-2' id='".$row[0]."'>Удалить</button>";
            echo "</div>";
        }
    }
}
?>
