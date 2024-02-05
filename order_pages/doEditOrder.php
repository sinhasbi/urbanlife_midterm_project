<?php
require_once("../db_connect.php");

if (!isset($_POST["editOrderStatus"])) {
    die("請循正常管道進入此頁面");
}
$id = $_POST["editOrderId"];
$orderStatus = $_POST["editOrderStatus"];
$sql = "UPDATE `order` SET order_status ='$orderStatus' WHERE id=$id";


if ($conn->query($sql)) {
    echo "新增資料完成";
} else {
    echo "新增資料錯誤: " . $conn->error;
}

$conn->close();
header("location: ../order_pages/order.php");
