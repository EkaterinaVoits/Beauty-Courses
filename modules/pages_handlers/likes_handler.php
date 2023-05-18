<?php 
if(session_status()!=PHP_SESSION_ACTIVE) session_start();
include '..\..\connect\connect_database.php';

$courseID=$_SESSION['id_course'];
$userID=$_SESSION['user']['id'];

$query = "SELECT isLike from Liked_course WHERE ID_user = '$userID' and ID_course = '$courseID'";
$result = mysqli_query($link, $query) or die("Ошибка " .
    mysqli_error($link));

if ($result) {
    $isLike = mysqli_fetch_row($result);

    //если лайк был поставлен (запись в бд уже создана)
    if (mysqli_num_rows($result) == 1 && $isLike[0] == 1) {

        $query = "UPDATE Course SET countLikes = countLikes - 1 WHERE ID = $courseID";
        $result = mysqli_query($link, $query) or die("Ошибка " .
            mysqli_error($link));

        $query = "UPDATE Liked_course SET isLike = 0 WHERE ID_course = $courseID and ID_user = $userID";
        $result = mysqli_query($link, $query) or die("Ошибка " .
            mysqli_error($link));

        $color = 'none';

    //если лайк был убран (запись в бд уже создана)
    } else if (mysqli_num_rows($result) == 1 && $isLike[0] == 0) {

        $query = "UPDATE Course SET countLikes = countLikes + 1 WHERE ID = $courseID";
        $result = mysqli_query($link, $query) or die("Ошибка " .
            mysqli_error($link));

        $query = "UPDATE Liked_course SET isLike = 1 WHERE ID_course	 = $courseID and ID_user = $userID";
        $result = mysqli_query($link, $query) or die("Ошибка " .
            mysqli_error($link));

        $color = 'rgb(242 229 229)';

    //если запись в бд не создана и до этого лайк не ставился
    } else if (mysqli_num_rows($result) == 0){

        $query = "UPDATE Course SET countLikes = countLikes + 1 WHERE ID = $courseID";
        $result = mysqli_query($link, $query) or die("Ошибка " .
            mysqli_error($link));

        $query = "INSERT INTO Liked_course (ID_user, ID_course, isLike)
        VALUES ($userID, $courseID, 1)";
        $result = mysqli_query($link, $query) or die("Ошибка " .
            mysqli_error($link));

        $color = 'rgb(242 229 229)';
    }
}

$query = "SELECT countLikes from Course WHERE ID = $courseID";
$result = mysqli_query($link, $query) or die("Ошибка " .
    mysqli_error($link));

$likesCount = mysqli_fetch_row($result);

mysqli_close($link);

$response = [
    "fill" => $color,
    "count" => $likesCount[0]
];

echo json_encode($response);

?>

