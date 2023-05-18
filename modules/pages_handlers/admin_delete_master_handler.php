<?php 
if(session_status()!=PHP_SESSION_ACTIVE) session_start();
include '..\..\connect\connect_database.php';

$master_id=$_POST['master_id'];

$masterCoursesQuery = "SELECT * FROM Organized_course JOIN Course ON Organized_course.ID_course=Course.ID WHERE Organized_course.ID_master=$master_id";
$resultMasterCourses = mysqli_query($link, $masterCoursesQuery) or die("Ошибка " . mysqli_error($link));

if($resultMasterCourses) {
    $rows = mysqli_num_rows($resultMasterCourses);
    
    if($rows>0) {
        echo "<div class='cant-del-msg'>Невозможно удалить мастера c ID=".$master_id." , так как он проводит ".mysqli_num_rows($resultMasterCourses)." курс(а): ";

        for($i = 0; $i < $rows; ++$i)
        {
            $row = mysqli_fetch_row($resultMasterCourses); 
            echo "<div> - ".$row[8]." (ID курса: ".$row[1].")</div>";

        }

        echo "</div>";
       
    } else {
        $dropQuery = "DELETE FROM Master WHERE Master.ID = $master_id";
        $resultDrop = mysqli_query($link, $dropQuery) or die("Ошибка " . mysqli_error($link));
    }
     $query = "SELECT * FROM Master";
     $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));

        if($result) {
            $rows = mysqli_num_rows($result);
            if($rows>0) {
                for($i = 0; $i < $rows; ++$i)
                {
                    $row = mysqli_fetch_row($result); 
                    echo "<div class='row row-margin'>";
                    echo "<div class='col-1'>".$row[0]."</div>";
                    echo "<div class='col-2'>".$row[1]."</div>";
                    echo "<div class='col-3'>".$row[3]."</div>";
                    echo "<div class='col-2'>".$row[4]."</div>";
                    echo "<div class='col-2'>".$row[5]."</div>";
                    echo "<button class='del-master-btn del-btn col-2' id='".$row[0]."' onclick='deleteMaster(this.id)'>Удалить</button>";
                    echo "</div>";
                }
            }
        }
           
}

 

/*$dropQuery = "DELETE FROM Course_registration WHERE Course_registration.ID = $reg_id";
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
            
        }
    }
}*/







?>

<script src="../../js/jquery-3.4.1.min.js"></script>
<script src="../../js/main.js"></script>