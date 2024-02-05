<?php
require_once("../db_connect.php");
date_default_timezone_set('Asia/Taipei');
if (!isset($_POST["addTitle"]) || !isset($_POST["addContent"])) {
    echo "請循正常管道進入";
    exit;
}

$title = $_POST["addTitle"];
$content = $_POST["addContent"];
$date=date("Y-m-d");
$now = date("Y-m-d H:i:s");

// 必填欄位
if (empty($title) || empty($content)) {
    echo "請輸入必要欄位";
    exit;
}
$img_id = 0; 

if ($_FILES["pic"]["error"] == 0) {
    $filename=time();
    $fileExt=pathinfo($_FILES["pic"]["name"],PATHINFO_EXTENSION);
    $filename=$filename.".".$fileExt;
    //echo $filename;
    //exit;

    if (move_uploaded_file($_FILES["pic"]["tmp_name"], "../articles_picture/".$filename)) {
        // $filename = $_FILES["pic"]["name"];

        $now = date('Y-m-d H:i:s');
        $sql = "INSERT INTO article_img (filename ,created_at)
        VALUES ('$filename','$now')";
        if ($conn->query($sql)) {
            $img_id = $conn->insert_id;
           // echo "新增資料完成";
        } else {
            echo "新增資料錯誤: " . $conn->error;
        }


       // echo "upload success!";
    } else {
        echo "upload failed!";
    }
}


// 將新增資料收入sql變數中
$sql = "INSERT INTO article (title, content, `date`,`update`, category_id,user_id,img_id,valid) VALUES ('$title', '$content','$date','$now', 1, 1,'$img_id', 1)";
if ($conn->query($sql)) {
   // echo "新增資料完成";
} else {
    echo "新增資料錯誤: " . $conn->error;
}

$conn->close();
header("location: articles.php?search=$title");
