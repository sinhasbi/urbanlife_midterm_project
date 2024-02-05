<?php
    require_once("../db_connect.php");
    
    $id = $_GET["id"];
    $sql = "UPDATE user SET valid='0' WHERE id=$id";

    if ($conn->query($sql)===TRUE) {
        echo "刪除成功";
    } else {
        echo "刪除失敗: " . $conn->error;
    
    };

    echo $sql;
    
    header("location:../member_pages/member.php");
?>