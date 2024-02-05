<?php
require_once("../db_connect.php");

// 假設這是要更新的優惠券的ID，您可以從某個地方獲取它，例如表單或URL參數
$id = $_POST["id"];

// 其他要更新的字段
$name = $_POST["name"];
$type = $_POST["type"];
$code = $_POST["code"];
$amount = floatval($_POST["amount"]);
$started = $_POST["started"];
$deadline = $_POST["deadline"];
$updated_at = date('Y-m-d'); // 更新日期
$status = $_POST["status"];
$min_price = $_POST["min_price"];
$category_id = $_POST["category_id"];

// 準備 SQL 更新語句
$sql = "UPDATE coupon SET 
        name='$name',
        type='$type',
        code='$code',
        amount=$amount,
        started='$started',
        deadline='$deadline',
        updated_at='$updated_at',
        status='$status',
        min_price='$min_price',
        category_id='$category_id'
        WHERE id=$id";

var_dump($sql);

if ($conn->query($sql)) {
    echo "更新資料完成";
} else {
    echo "更新資料錯誤: " . $conn->error;
}

$conn->close();
header("location:coupon.php?search=$name");
