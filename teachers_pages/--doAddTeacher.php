<?php
require_once("../db_connect.php");

if(!isset($_POST["name"])){
    echo "請循正常管道進入";
    exit;
}

$name=$_POST["name"];
$gender=$_POST["gender"];
$phone=$_POST["phone"];
$email=$_POST["email"];
$intro=$_POST["intro"];
// $img=$_POST["img"];


if(empty($name) || empty($gender) || empty($phone) || empty($email) || empty($intro)) {
    echo "請填入必要欄位";
    exit;
}
if (mb_strlen($intro, 'utf-8') > 200) {
    echo "教師介紹字數請小於200";
    exit;
}


if($_FILES["img"]["error"] == 0){
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


$sql = "INSERT INTO teacher (name, gender, phone, email, intro, img, valid)
VALUES ('$name', '$gender', '$phone', '$email', '$intro', '$filename', 1)";

if($conn->query($sql)){
    echo "新增資料完成";
    // $last_id = $conn->insert_id;
    // echo ", id 為 $last_id";
} else {
    echo "新增資料錯誤: " . $conn->error;
}

$conn->close();

header("location:teachers.php?search=$name");