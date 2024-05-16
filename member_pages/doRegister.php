<?php
session_start();
require_once ("../db_connect.php");

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

// 清空错误信息
$_SESSION["error"] = [];

// if (empty($name) || empty($account) || empty($password) || empty($email) || empty($birthday) || empty($phone) || empty($address) || empty($creditcard)) {
//     die("請輸入必填欄位");
//     exit;
// }

if (empty($name)) {
    $_SESSION["error"]["name"] = "請輸入名稱";
}
if (empty($account)) {
    $_SESSION["error"]["account"] = "請輸入帳號";
}

$checkAccount = "SELECT * FROM user WHERE account='$account'";
$result = $conn->query($checkAccount);
$accountExist = $result->num_rows;

if ($accountExist != 0) {
    $_SESSION["error"]["account"] = "帳號已存在";
}
if (empty($password)) {
    $_SESSION["error"]["password"] = "請輸入密碼";
}
if ($password != $repassword) {
    $_SESSION["error"]["repassword"] = "密碼輸入不一致";
}
if (empty($email)) {
    $_SESSION["error"]["email"] = "請輸入信箱";
}
if (empty($birthday)) {
    $_SESSION["error"]["birthday"] = "請輸入生日";
}
if (empty($phone)) {
    $_SESSION["error"]["phone"] = "請輸入電話號碼";
}
if (empty($address)) {
    $_SESSION["error"]["address"] = "請輸入信用卡號";
}
if (empty($creditcard)) {
    $_SESSION["error"]["creditcard"] = "請輸入信用卡號";
}

// 如果有任何错误信息，重定向回表单页面
if (!empty($_SESSION["error"])) {
    header("Location: ../member_pages/register.php");
    exit;
}

$now = date('Y-m-d H:i:s');
// 簡單的加密方法
// $password = md5($password);

if ($_FILES["image"]["error"] == 0) {
    $filetime = time();
    $fileExt = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
    $filename = $filetime . "." . $fileExt;

    if (move_uploaded_file($_FILES["image"]["tmp_name"], "../member_images/" . $filename)) {
        // 上傳到資料庫
        $sql = "INSERT INTO user (name, account, password, email, birthday, phone, address, credit_number, created_at, valid, img)
                VALUES ('$name','$account','$password','$email','$birthday','$phone','$address','$creditcard','$now',1,'$filename')";

        if ($conn->query($sql)) {
            echo "新增資料完成";
        } else {
            echo "新增資料錯誤: " . $conn->error;
        }
    } else {
        echo "upload failed!" . $conn->error;
    }
}

$conn->close();
header("Location: ../member_pages/member.php?search=$name");
exit;
?>