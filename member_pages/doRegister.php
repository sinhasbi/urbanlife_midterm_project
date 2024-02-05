<?php
session_start();
require_once("../db_connect.php");

if (!isset($_POST["account"])) {
    die("請循正常管道進入此頁面");
}

$name = trim($_POST["name"]);
$account = trim($_POST["account"]);
$password = trim($_POST["password"]);
$repassword = trim($_POST["repassword"]);
$email = trim($_POST["email"]);
$birthday = trim($_POST["birthday"]);
$phone = trim($_POST["phone"]);
$address = trim($_POST["address"]);
$creditcard = trim($_POST["creditcard"]);




// if (empty($name) || empty($account) || empty($password) || empty($email) || empty($birthday) || empty($phone) || empty($address) || empty($creditcard)) {
//     die("請輸入必填欄位");
    
//     exit;
    
// }

if (empty($name)) {
    $_SESSION["error"]["message"] = "請輸入名稱";
    header("location:../member_pages/register.php");
    exit;
}

if (empty($account)) {
    $_SESSION["error"]["message"] = "請輸入帳號";
    header("location:../member_pages/register.php");
    exit;
}

$checkAccount = "SELECT * FROM user WHERE account='$account'";
$result = $conn->query($checkAccount);
$accountExist = $result->num_rows;

if ($accountExist != 0) {
    $_SESSION["error"]["message"] = "帳號已存在";
    header("location:../member_pages/register.php");
    exit;
}

if (empty($password)) {
    $_SESSION["error"]["message"] = "請輸入密碼";
    header("location:../member_pages/register.php");
    exit;
}
if ($password != $repassword) {
    $_SESSION["error"]["message"] = "密碼輸入不一致";
    header("location:../member_pages/register.php");
    exit; 
}
if (empty($email)) {
    $_SESSION["error"]["message"] = "請輸入信箱";
    header("location:../member_pages/register.php");
    exit;
}
if (empty($birthday)) {
    $_SESSION["error"]["message"] = "請輸入生日";
    header("location:../member_pages/register.php");
    exit;
}
if (empty($phone)) {
    $_SESSION["error"]["message"] = "請輸入電話號碼";
    header("location:../member_pages/register.php");
    exit;
}
if (empty($creditcard)) {
    $_SESSION["error"]["message"] = "請輸入密碼";
    header("location:../member_pages/register.php");
    exit;
}



$now = date('Y-m-d H:i:s');
//簡單的加密方法
// $password = md5($password);


if ($_FILES["image"]["error"] == 0) {

    $filetime = time();
    $fileExt = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
    $filename = $filetime . "." . $fileExt;


    if (move_uploaded_file($_FILES["image"]["tmp_name"], "../member_images/" . $filename)) {
        //上傳到資料庫
        
        $now = date('Y-m-d H:i:s');

        $sql = "INSERT INTO user (name, account,password,email,birthday,phone,address,credit_number,created_at,valid,img)
        VALUES ('$name','$account','$password','$email','$birthday','$phone','$address','$creditcard','$now',1,'$filename')";

        // $sql = "INSERT INTO images (name, filename, created_at)
        //         VALUES ('$name', '$filename','$now')";
        if ($conn->query($sql)) {
            echo "新增資料完成";
        } else {
            echo "新增資料錯誤: " . $conn->error;
        }


        echo "upload success!";

    } else {
        echo "upload failed!". $conn->error;
    }

}


$conn->close();
header("location: ../member_pages/member.php?search=$name");
