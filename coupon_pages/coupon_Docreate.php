<?php
require_once("../db_connect.php");

$sql = "SELECT coupon.* , primary_category.id , primary_category.name AS category_name FROM coupon
JOIN primary_category ON coupon.category_id = primary_category.id
";



$result = $conn->query($sql);
$rows = $result->fetch_all(MYSQLI_ASSOC);


// 假設這些變量是從用戶輸入或其他數據源中獲得的
// $id = $_POST["id"];
$name = $_POST["name"];
$type = $_POST["type"];
$code = $_POST["code"];
$amount = floatval($_POST["amount"]);
$started = $_POST["started"];
$deadline = $_POST["deadline"];
$created_at = date('Y-m-d'); // 假設使用當前日期作為創建日期
$updated_at = date('Y-m-d'); // 假設使用當前日期作為更新日期
$status = $_POST["status"];
$min_price = $_POST["min_price"];
$category_id = $_POST["category_id"];




// echo ": " . $id . "<br>";
echo "優惠券名稱: " . $name . "<br>";
echo "優惠券的類型: " . $type . "<br>";
echo "優惠券代碼: " . $code . "<br>";
echo "折扣值: " . $amount . "<br>";
echo "開始日期: " . $started . "<br>";
echo "結束日期: " . $deadline . "<br>";
echo "創造日期: " . $created_at . "<br>";
echo "更新日期: " . $updated_at . "<br>";
echo "狀態: " . $status . "<br>";
echo "低消: " . $min_price . "<br>";
echo "折扣種類: " . $category_id . "<br>";





//檢查必要的欄位是否都已填寫
// if ( empty($name) || empty($type) || empty($code) || empty($amount) || empty($started) || empty($deadline) || empty($status) || empty($min_price) || empty($category_id)) {
// echo "請填入所有必要欄位";
// exit;
// }


// 準備 SQL 語句
$sql = "INSERT INTO coupon (name, type, code, amount, started, deadline, valid, created_at, updated_at, status, min_price, category_id)
VALUES ( '$name', '$type', '$code', $amount, '$started', '$deadline', 1, '$created_at', '$updated_at', '$status', '$min_price', '$category_id')";


var_dump($sql);
// if ($conn->query($sql)) {
// echo "新增資料完成";
// } else {
// echo "新增資料錯誤" . $conn->error;
// }
var_dump($code);

if ($conn->query($sql)) {
    echo "新增資料完成";
    // $last_id = $conn->insert_id;
    // echo ",id為$last_id";
} else {
    echo "新增資料錯誤: " . $conn->error;
}

$conn->close();
header("location:coupon.php?search=$name");
