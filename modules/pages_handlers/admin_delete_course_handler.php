<?php 
if(session_status()!=PHP_SESSION_ACTIVE) session_start();
include '..\..\connect\connect_database.php';

$course_id=$_POST['course_id'];

$courseQuery = "SELECT * FROM Organized_course JOIN Course ON Course.ID=Organized_course.ID WHERE Organized_course.ID_course=$course_id";
$resultCourseCourses = mysqli_query($link, $courseQuery) or die("Ошибка " . mysqli_error($link));

if($resultCourseCourses) {
    $rows = mysqli_num_rows($resultCourseCourses);
    
    if($rows>0) {
        echo "<div class='cant-del-msg'>Невозможно удалить курс (ID= ".$course_id."), так как он проводится </div>";
    } else {
        $dropQuery = "DELETE FROM Course WHERE Course.ID = $course_id";
        $resultDrop = mysqli_query($link, $dropQuery) or die("Ошибка " . mysqli_error($link));

    }

    $query = "SELECT * FROM Course";
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
                echo "<div class='col-3'>".$row[2]."</div>";
                echo "<div class='col-2'>".$row[3]." BYN</div>";
                echo "<button class='edit-course-btn del-btn col-2' id='".$row[0]."' onclick='editCourse(this.id)'>Редактировать</button>";
                echo "<button class='del-course-btn del-btn col-2' id='".$row[0]."' onclick='deleteCourse(this.id)'>Удалить</button>";
                echo "</div>";
            }
        }
    }




}










?>

<script src="../../js/jquery-3.4.1.min.js"></script>
<script src="../../js/main.js"></script>