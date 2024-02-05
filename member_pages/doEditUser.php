<?php
require_once("../db_connect.php");

$id = $_POST["editId"];
$name = trim($_POST["editName"]);
$email = trim($_POST["editEmail"]);
$birthday = trim($_POST["editBirthday"]);
$phone = trim($_POST["editPhone"]);
$address = trim($_POST["editAddress"]);
$creditnumber = trim($_POST["editCreditNumber"]);


if ($_FILES["editImg"]["error"] == 0) {

    $filetime = time();
    $fileExt = pathinfo($_FILES["editImg"]["name"], PATHINFO_EXTENSION);
    $filename = $filetime . "." . $fileExt;


    if (move_uploaded_file($_FILES["editImg"]["tmp_name"], "../member_images/" . $filename)) {
        //上傳到資料庫

        // $now = date('Y-m-d H:i:s');

        $sql = "UPDATE user SET name='$name',email='$email',birthday='$birthday',phone='$phone',address='$address',credit_number='$creditnumber',img='$filename' WHERE id=$id";


        if ($conn->query($sql)) {
            echo "新增資料完成";
        } else {
            echo "新增資料錯誤: " . $conn->error;
        }


        echo "upload success!";
    } else {
        echo "upload failed!" . $conn->error;
    }
} else {
    $sql = "UPDATE user SET name='$name',email='$email',birthday='$birthday',phone='$phone',address='$address',credit_number='$creditnumber'  WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        // echo "資料表 users 更新完成";
    } else {
        echo "更新資料表錯誤: " . $conn->error;
    };
}





$conn->close();
header("location: ../member_pages/member.php?search=$name");
