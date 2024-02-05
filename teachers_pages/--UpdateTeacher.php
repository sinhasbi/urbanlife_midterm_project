<?php
require_once("../db_connect.php");

if(!isset($_POST["name"])){
    die("請循正常管道進入");
}

$filename = null; // 初始化 $filename


if(isset($_FILES["img"]) && $_FILES["img"]["error"] == 0){
    $filename="T". time();
    $fileExt=pathinfo($_FILES["img"]["name"], PATHINFO_EXTENSION);
    $filename=$filename.".".$fileExt;
    // echo $filename;
    // exit;


    if(move_uploaded_file($_FILES["img"]["tmp_name"], "../teachers_img/".$filename)){

        echo "upload success!";
    }else{
        echo "upload failed";
    }
}


$name=$_POST["name"];
$gender=$_POST["gender"];
$phone=$_POST["phone"];
$email=$_POST["email"];
$intro=$_POST["intro"];
$id=$_POST["id"];


if(empty($name) || empty($gender) || empty($phone) || empty($email) || empty($intro)) {
    echo "請填入必要欄位";
    exit;
}
if (mb_strlen($intro, 'utf-8') > 200) {
    echo "教師介紹字數請小於200";
    exit;
}




// 更新資料庫，考慮是否有新的圖片檔案
if (isset($filename)) {
    $sql = "UPDATE teacher SET name='$name', gender='$gender', phone='$phone', email='$email', intro='$intro', img='$filename' WHERE id='$id'";
} else {
    $sql = "UPDATE teacher SET name='$name', gender='$gender', phone='$phone', email='$email', intro='$intro' WHERE id='$id'";
}


if($conn->query($sql) === TRUE) {
    echo "更新成功";
} else {
    echo "更新資料錯誤: " . $conn->error;
}


$conn->close();

header("location: teachers.php?search=$name");
