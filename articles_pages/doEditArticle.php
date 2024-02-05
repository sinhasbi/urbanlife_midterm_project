<?php
require_once("../db_connect.php");
date_default_timezone_set('Asia/Taipei');
$id = $_POST["id"];
$title = $_POST["editTitle"];
$content = $_POST["editContent"];


$targetDir = __DIR__ . "/../articles_picture/";

if ($_FILES["pic"]["error"] == 0) {
    // 获取上传的新图片信息
    $filename = time();
    $fileExt = pathinfo($_FILES["pic"]["name"], PATHINFO_EXTENSION);
    $filename = $filename . "." . $fileExt;

    // 移动上传的新图片到服务器指定目录
    if (move_uploaded_file($_FILES["pic"]["tmp_name"], $targetDir . $filename)) {
        // 查找对应的 article_img 记录并更新
        $now = date('Y-m-d H:i:s');
        $sql = "SELECT article_img.* FROM article_img
        LEFT JOIN article ON  article_img.id =article.img_id
        WHERE article.id='$id'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $img_id = $row["id"];
            $sql_update = "UPDATE article_img SET filename='$filename', created_at='$now' WHERE id='$img_id'";
            if ($conn->query($sql_update)) {
                // echo "图片更新成功!";
            } else {
                echo "图片更新失败: " . $conn->error;
            }
        } else {
            $sql_insert_img = "INSERT INTO article_img (filename, created_at) VALUES ('$filename', '$now')";
            if ($conn->query($sql_insert_img)) {
                $img_id = $conn->insert_id;
            } else {
                echo "新增圖片記錄失敗: " . $conn->error;
            }
        }
        
    } else {
        echo "图片移动失败!";
    }
}
$now = date('Y-m-d H:i:s');

$sql = "UPDATE article SET title='$title' ,content='$content',img_id='$img_id',`update`= '$now'  WHERE id='$id'";
if ($conn->query($sql) === TRUE) {
    // echo "更新成功";
} else {
    echo "更新資料錯誤: " . $conn->error;
}
$conn->close();


header("location: articles.php?search=$title");
