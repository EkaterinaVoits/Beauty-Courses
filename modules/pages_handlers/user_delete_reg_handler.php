<?php 
if(session_status()!=PHP_SESSION_ACTIVE) session_start();
include '..\..\connect\connect_database.php';



if(isset($_POST['reg_id'])) {
    $reg_id=$_POST['reg_id'];
    $user_id=$_SESSION['user']['id'];

    $dropQuery = "DELETE FROM Course_registration WHERE Course_registration.ID = $reg_id";
    $resultDrop = mysqli_query($link, $dropQuery) or die("Ошибка " .
        mysqli_error($link));


    $query = "SELECT * FROM Course_registration JOIN Organized_course ON Course_registration.ID_orginizedCourse=Organized_course.ID JOIN Course ON Organized_course.ID_course=Course.ID JOIN Status ON Course_registration.ID_status=Status.ID JOIN Master ON Organized_course.ID_master=Master.ID WHERE Course_registration.ID_user='$user_id'";
    $result = mysqli_query($link, $query) or die("Ошибка".mysqli_error($link));

    if($result)
    {
        $rows = mysqli_num_rows($result);
        if($rows>0) {
            for($i = 0; $i < $rows; ++$i)
            {
                        //$row = mysqli_fetch_assoc($result); 
                $row = mysqli_fetch_row($result); 


                echo "<div class='course-item-2'>"; 
                echo "<img src='../../img/courses_images/".$row[15]."' class='course-item-img-2' style='width:340px'/>"; 

                echo "<div>"; 

                echo "<div class='course-item-title-2'>".$row[12]."</div>"; 
                echo "<div class='course-item-description-2'>".$row[13]."</div>"; 

                echo "<div class='course-description'>"; 
                echo "<div>Начало: <span>".$row[7]."</span></div>"; 
                echo "<div>Продолжительность: <span>".$row[8]."</span></div>"; 
                echo "<div>Группа: <span>".$row[9]."</span></div>";
                echo "<div>График: <span>".$row[10]."</span></div>";
                echo "<div>Преподаватель: <span>".$row[20]."</span></div>";
                echo "<div>Стоимость: <span>".$row[14]." byn</span></div>";
                echo "<div>Статус: <span>".$row[18]."</span></div>";

                if($row[17]=="1") {
                    echo "<div><button class='button cancel-reg-btn' id='".$row[0]."' onclick='cancelReg(this.id)'>Отменить заявку</button></div>";
                }

                echo "</div>";

                echo "</div>"; 
                echo "</div>"; 
            }
        } else {
            echo "<div>Вы не записаны ни на какой курс. Успейте записаться!</div>";
        }





    }
}









    ?>
