<!-- 1.改功能檔名（都小寫）路徑
2.最後改dbconnect -->

<!-- <?php
        require_once("../db_connect.php"); //讀入資料庫//
        $sql = "SELECT * FROM coupon WHERE valid=1"; //找資料庫coupon表格 valid=1 
        $result = $conn->query($sql); //連接
        $rows = $result->fetch_all(MYSQLI_ASSOC);

        ?>  -->

<?php
require_once("../db_connect.php"); // 匯入資料庫連接文件

$perPage = 8;
$orderString = "ORDER BY id ASC"; // 預設排序方式
$search = isset($_GET["search"]) ? $_GET["search"] : "";
$p = isset($_GET["p"]) ? $_GET["p"] : 1;
$startIndex = ($p - 1) * $perPage;

// 根據排序參數設定 $orderString
if (isset($_GET["order"])) {
    $order = $_GET["order"];
    if ($order == 1) {
        $orderString = "ORDER BY id ASC";
    } elseif ($order == 2) {
        $orderString = "ORDER BY id DESC";
    }
}

// 執行查詢以獲取總記錄數
$sqlAll = "SELECT * FROM coupon WHERE valid=1";
$resultAll = $conn->query($sqlAll);
$couponTotalCount = $resultAll->num_rows;
$pageCount = ceil($couponTotalCount / $perPage);

// 根據是否有搜索條件來構建 SQL 查詢
if (!empty($search)) {
    $sql = "SELECT * FROM coupon WHERE name LIKE '%$search%' AND valid=1 $orderString LIMIT $startIndex, $perPage";
} else {
    $order = 1;
    $sql = "SELECT * FROM coupon WHERE valid=1 $orderString LIMIT $startIndex, $perPage";
}

$result = $conn->query($sql);
$rows = $result->fetch_all(MYSQLI_ASSOC);

// 如果有搜索條件，更新顯示的優惠券數量
if (!empty($search)) {
    $couponCount = $result->num_rows;
} else {
    $couponCount = $couponTotalCount;
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png" />
    <link rel="icon" type="image/png" href="../assets/img/favicon.png" />
    <title>優惠券管理</title>
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- CSS Files -->
    <link id="pagestyle" href="../assets/css/argon-dashboard.css?v=2.0.4" rel="stylesheet" />

    <style>

    </style>
</head>

<body class="g-sidenav-show bg-gray-100">
    <div class="min-height-300 bg-primary position-absolute w-100"></div>
    <aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 z-index-0 " id="sidenav-main">
        <div class="sidenav-header">
            <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
            <a class="navbar-brand m-0" href=" https://demos.creative-tim.com/argon-dashboard/pages/dashboard.html " target="_blank">
                <img src="../assets/img/logo-ct-dark.png" class="navbar-brand-img h-100" alt="main_logo" />
                <span class="ms-1 font-weight-bold">城市生機</span>
            </a>
        </div>
        <hr class="horizontal dark mt-0" />
        <div class="w-auto" id="sidenav-collapse-main">
            <ul class="navbar-nav">

                <li class="nav-item">
                    <a class="nav-link" href="../member_pages/member.php">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fa-solid fa-user text-dark text-sm opacity-10 fa-fw"></i>
                        </div>
                        <span class="nav-link-text ms-1">會員管理/註冊</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../product_pages/product-list.php">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fa-sharp fa-solid fa-leaf text-dark text-sm opacity-10 fa-fw"></i>
                        </div>
                        <span class="nav-link-text ms-1">商品管理</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../product-category_pages/primary_category.php">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fa-solid fa-table-list text-dark text-sm opacity-10 fa-fw"></i>
                        </div>
                        <span class="nav-link-text ms-1">商品類別管理</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../articles_pages/articles.php">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fa-solid fa-message text-dark text-sm opacity-10 fa-fw"></i>
                        </div>
                        <span class="nav-link-text ms-1">文章管理</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../order_pages/order.php">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fa-solid fa-store text-dark text-sm opacity-10 fa-fw"></i>
                        </div>
                        <span class="nav-link-text ms-1">訂單管理</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../teachers_pages/teachers.php">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fa-solid fa-user-tie text-dark text-sm opacity-10 fa-fw"></i>
                        </div>
                        <span class="nav-link-text ms-1">講師管理</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../lecture_pages/lecture.php">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fa-solid fa-graduation-cap text-dark text-sm opacity-10 fa-fw"></i>
                        </div>
                        <span class="nav-link-text ms-1">課程管理</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="../coupon_pages/coupon.php">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fa-solid fa-ticket-simple text-dark text-sm opacity-10 fa-fw"></i>
                        </div>
                        <span class="nav-link-text ms-1">優惠券管理</span>
                    </a>
                </li>

                <li class="nav-item mt-3">
                    <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">
                        個人主頁
                    </h6>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../pages/profile.html">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-single-02 text-dark text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">個人檔案</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../pages/sign-in.html">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-single-copy-04 text-warning text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">登入</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../pages/sign-up.html">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-collection text-info text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">登出</span>
                    </a>
                </li>
            </ul>
        </div>
    </aside>
    <main class="main-content position-relative border-radius-lg">
        <!-- Navbar -->
        <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" data-scroll="false">
            <div class="container-fluid py-1 px-3">

                <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
                    <div class="ms-md-auto pe-md-3 d-flex align-items-center"></div>
                    <div class="text-white px-4">HI, USER</div>
                    <ul class="navbar-nav justify-content-end">
                        <li class="nav-item d-flex align-items-center">
                            <a href="javascript:;" class="nav-link text-white font-weight-bold px-0">
                                <i class="fa fa-user me-sm-1"></i>
                                <span class="d-sm-inline d-none">登入</span>
                            </a>
                        </li>
                        <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                            <a href="javascript:;" class="nav-link text-white p-0" id="iconNavbarSidenav">
                                <div class="sidenav-toggler-inner">
                                    <i class="sidenav-toggler-line bg-white"></i>
                                    <i class="sidenav-toggler-line bg-white"></i>
                                    <i class="sidenav-toggler-line bg-white"></i>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- End Navbar -->



        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header pb-0">
                            <div class="d-flex justify-content-between">
                                <h4>優惠券管理</h4>
                                <div>
                                    新增
                                    <a name="" id="" class="btn btn-primary" href="tables_addcoupon.php" role="button">
                                        <i class="fa-solid fa-plus fa-fw"></i>
                                    </a>
                                </div>


                            </div>

                            <div class="col">
                                <?php if (isset($_GET["search"])) : ?>
                                    <div class="me-2">
                                        <a class="btn btn-primary" href="../coupon_pages/coupon.php" role="button">
                                            <i class="fa-solid fa-angles-left fa-fw"></i>
                                        </a>
                                    </div>
                                <?php endif; ?>

                                <form action="">
                                    <div class="input-group mt-1 d-flex align-items-start">
                                        <input type="search" class="form-control box-sizing inline-block" placeholder="優惠券名稱" aria-label="Recipient's username" aria-describedby="button-addon2" name="search" <?php if (isset($_GET["search"])) : $searchValue = $_GET["search"]; ?> value="<?= $searchValue ?>" <?php endif; ?>>
                                        <button class="btn btn-primary" type="search" id="button-addon2"><i class="fa-solid fa-magnifying-glass fa-fw"></i></button>
                                    </div>
                                </form>
                            </div>

                            <div class="row">
                                <div class="col-sm-12 d-flex">
                                    <div class="col">
                                        <div class="d-flex justify-content-between align-item-center">
                                            <div>
                                                共<?= $couponCount ?>筆
                                            </div>
                                            <div class="d-flex">
                                                <?php if (!isset($_GET["search"])) : ?>
                                                    <div class="me-2">排序</div>
                                                    <div class="btn-group">
                                                        <a class="btn btn-primary
                      <?php if ($order == 1) echo "active" ?>
                      " href="coupon.php?order=1&p=<?= $p ?>"><i class="fa-solid fa-arrow-down-short-wide fa-fw"></i></a>
                                                        <a class="btn btn-primary
                      <?php if ($order == 2) echo "active" ?>
                      " href="coupon.php?order=2&p=<?= $p ?>"><i class="fa-solid fa-arrow-down-wide-short fa-fw"></i></a>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>








                                    </div>



                                </div>
                            </div>



                            <div class="card-body px-0 pt-0 pb-2">
                                <div class="table-responsive p-0">
                                    <table class="table align-items-center mb-0 text-md">
                                        <thead class="font-weight-bolder">
                                            <tr>
                                                <th class=" text-start text-uppercase text-secondary  font-weight-bolder opacity-7 ps-1">
                                                    id
                                                </th>

                                                <th class="text-uppercase text-secondary  font-weight-bolder opacity-7 ps-2">
                                                    優惠券名稱/代碼
                                                </th>

                                                <th class="text-uppercase text-secondary  font-weight-bolder opacity-7 ps-2">
                                                    適用狀況/種類面額
                                                </th>

                                                <th class="text-center text-secondary  font-weight-bolder opacity-7 ps-2">
                                                    創建時間
                                                </th>

                                                <th class="text-center text-secondary  font-weight-bolder opacity-7 ps-2">
                                                    更新時間
                                                </th>

                                                <th class="text-center text-uppercase text-secondary  font-weight-bolder opacity-7">
                                                    優惠券狀態
                                                </th>

                                                <th class="text-center text-uppercase text-secondary  font-weight-bolder opacity-7">
                                                    低消金額
                                                </th>

                                                <th class="text-center text-uppercase text-secondary  font-weight-bolder opacity-7">
                                                    使用期限
                                                </th>

                                                <th class="text-secondary opacity-7"></th>
                                            </tr>
                                        </thead>
                                        <tbody>




                                            <?php foreach ($rows as $coupon) : ?>
                                                <tr>
                                                    <td class="align-middle text-start">
                                                        <p class="mb-0 "> <?= $coupon["id"] ?></p>
                                                    </td>

                                                    <td>

                                                        <h6 class="mb-0 "> <?= $coupon["name"] ?></h6>
                                                        <p class=" text-secondary mb-0">
                                                            <?= $coupon["code"] ?>
                                                        </p>

                                                    </td>

                                                    <td>
                                                        <?php

                                                        $category_id = $coupon["category_id"];
                                                        $sqlPrimaryCategoryId = "SELECT primary_category.name FROM primary_category WHERE primary_category.id = $category_id";
                                                        $resultPrimary = $conn->query($sqlPrimaryCategoryId);
                                                        $PrimaryRows = $resultPrimary->fetch_all(MYSQLI_ASSOC);
                                                        // var_dump($PrimaryRows);

                                                        ?>
                                                        <?php foreach ($PrimaryRows as $primaryRow) : ?>

                                                            <h6 class=" mb-0"><?= $primaryRow["name"] ?></h6>
                                                        <?php endforeach; ?>
                                                        <p class=" text-secondary mb-0">
                                                            <?= $coupon["type"] ?> <?= $coupon["amount"] ?>
                                                        </p>
                                                    </td>
                                                    <td class=" text-secondary mb-0 text-center">
                                                        <span class="text-secondary"><?= $coupon["created_at"] ?></span>
                                                    </td>
                                                    <td class="text-secondary mb-0 text-center">
                                                        <span class="text-secondary"><?= $coupon["updated_at"] ?></span>
                                                    </td>

                                                    <!-- <td class="align-middle text-center text-sm">

                                                        <span class="badge badge-sm bg-gradient-success"><?= $coupon["status"] ?></span>


                                                    </td> -->
                                                    <td class="align-middle text-center">
                                                        <?php if ($coupon["status"] == "可使用") : ?>
                                                            <span class="badge badge-sm bg-gradient-success"><?= $coupon["status"] ?></span>
                                                        <?php else : ?>
                                                            <span class="badge badge-sm bg-secondary"><?= $coupon["status"] ?></span>
                                                        <?php endif; ?>
                                                    </td>



                                                    <td class="align-middle text-center">
                                                        <span class="text-secondary"><?= $coupon["min_price"] ?></span>
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        <span class="text-secondary"><?= $coupon["started"] ?>~<?= $coupon["deadline"] ?></span>
                                                    </td>
                                                    <td class="align-middle">
                                                        <!-- 預覽 編輯 刪除按鈕 -->
                                                        <div class="d-flex align-items-center">
                                                            <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#staticBackdrop<?= $coupon["id"] ?>">
                                                                <i class="fa-solid fa-eye fa-fw text-white"></i></button>
                                                            <button class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#editModal<?= $coupon["id"] ?>">
                                                                <i class="fa-solid fa-pen-to-square fa-fw"></i>
                                                            </button>
                                                            <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmModal<?= $coupon["id"] ?>" role="button"><i class="fa-solid fa-trash fa-fw"></i></button>
                                                        </div>



                                                        <!-- 預覽按鈕 MODAL模型 -->

                                                        <div class="modal fade " id="staticBackdrop<?= $coupon["id"] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                            <div class="modal-dialog modal-lg">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h1 class="modal-title fs-5" id="staticBackdropLabel">
                                                                            <?= $coupon["name"] ?>
                                                                        </h1>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">

                                                                        <div class="container d-flex justify-content-center">

                                                                            <div class="row">

                                                                                <div class="col-8">
                                                                                    <table class="table table-bordered">

                                                                                        <tr>
                                                                                            <th>ID</th>
                                                                                            <td class="border-end">
                                                                                                <?= $coupon["id"] ?>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <th>優惠券名稱</th>
                                                                                            <td class="border-end">
                                                                                                <?= $coupon["name"] ?>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <th>優惠券代碼</th>
                                                                                            <td class="border-end">
                                                                                                <?= $coupon["code"] ?>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <th>適用狀況</th>
                                                                                            <td class="border-end">

                                                                                                <?php foreach ($PrimaryRows as $primaryRow) : ?>

                                                                                                    <p class="text-xs font-weight-bold mb-0"><?= $primaryRow["name"] ?></p>
                                                                                                <?php endforeach; ?>

                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <th>種類面額</th>
                                                                                            <td class="border-end">
                                                                                                <?= $coupon["type"] ?> <?= $coupon["amount"] ?>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <th>優惠券狀態</th>
                                                                                            <td class="border-end">
                                                                                                <?= $coupon["status"] ?>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <th>低消金額</th>
                                                                                            <td class="border-end">
                                                                                                <?= $coupon["min_price"] ?>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <th>使用期限</th>
                                                                                            <td class="border-end">
                                                                                                <?= $coupon["started"] ?>~<?= $coupon["deadline"] ?>
                                                                                            </td>
                                                                                        </tr>

                                                                                    </table>

                                                                                </div>
                                                                            </div>
                                                                        </div>


                                                                    </div>


                                                                    <div class="modal-footer d-flex justify-content-lg-between">
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">關閉</button>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="d-flex">


                                                            <!-- 修改 Modal -->
                                                            <div class="modal fade" id="editModal<?= $coupon["id"] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h1 class="modal-title fs-5" id="exampleModalLabel">修改資料</h1>
                                                                        </div>
                                                                        <form action="coupon_Doupdate.php" method="post">
                                                                            <div class="modal-body">

                                                                                <input type="hidden" name="id" value="<?= $coupon["id"] ?>">
                                                                                <table class="table table-bordered">
                                                                                    <tr>
                                                                                        <th>優惠券名稱:</th>
                                                                                        <td><input type="text" class="form-control" value="<?= $coupon["name"] ?>" name="name"></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <th>優惠券代碼:</th>
                                                                                        <td><input type="text" class="form-control" value="<?= $coupon["code"] ?>" name="code"></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <th>適用狀況:</th>

                                                                                        <td>
                                                                                            <select name="category_id" id="" class="form-select">
                                                                                                <option value="1" <?php if ($coupon["category_id"] == "1") echo "selected"; ?>>seeds</option>
                                                                                                <option value="2" <?php if ($coupon["category_id"] == "2") echo "selected"; ?>>seedings</option>
                                                                                                <option value="3" <?php if ($coupon["category_id"] == "3") echo "selected"; ?>>agrochemical</option>
                                                                                                <option value="4" <?php if ($coupon["category_id"] == "4") echo "selected"; ?>>materials</option>
                                                                                                <option value="5" <?php if ($coupon["category_id"] == "5") echo "selected"; ?>>fertilizers</option>
                                                                                                <option value="6" <?php if ($coupon["category_id"] == "6") echo "selected"; ?>>books</option>
                                                                                            </select>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <th>種類面額:</th>
                                                                                        <td>
                                                                                            <div class="form-check form-check-inline">
                                                                                                <input class="form-check-input" type="radio" name="type" id="type" value="百分比" <?= $coupon["type"] == "百分比" ? "checked" : "" ?>>
                                                                                                <label class="form-check-label" for="inlineRadio1">百分比</label>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline">
                                                                                                <input class="form-check-input" type="radio" name="type" id="type" value="金額" <?= $coupon["type"] == "金額" ? "checked" : "" ?>>
                                                                                                <label class="form-check-label" for="inlineRadio2">金額</label>
                                                                                            </div>
                                                                                            <input type="number" class="form-control" id="amount" value="<?= $coupon["amount"] ?>" name="amount" step="0.01">
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <th>優惠券狀態:</th>
                                                                                        <td>
                                                                                            <div class="form-check">

                                                                                                <input class="form-check-input" type="radio" name="status" id="1" value="已停用" <?= $coupon["status"] == "已停用" ? "checked" : "" ?>>
                                                                                                <label class="form-check-label" for="flexRadioDefault1">
                                                                                                    已停用
                                                                                                </label>
                                                                                            </div>
                                                                                            <div class="form-check">
                                                                                                <input class="form-check-input " type="radio" name="status" id="2" value="可使用" <?= $coupon["status"] == "可使用" ? "checked" : "" ?>>
                                                                                                <label class="form-check-label" for="flexRadioDefault2">
                                                                                                    可使用
                                                                                                </label>
                                                                                            </div>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <th>低消金額:</th>
                                                                                        <td><input type="number" class="form-control" id="min_price" value="<?= $coupon["min_price"] ?>" name="min_price"></td>
                                                                                    </tr>
                                                                                    <tr class="border-end">
                                                                                        <th>使用期限:</th>
                                                                                        <td>
                                                                                            <input type="datetime-local" class="form-control" id="started" value="<?= $coupon["started"] ?>" name="started">
                                                                                            <input type="datetime-local" class="form-control" id="deadline" value="<?= $coupon["deadline"] ?>" name="deadline">
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                                                                                <button type="submit" class="btn btn-danger">確認</button>
                                                                            </div>
                                                                        </form>



                                                                    </div>
                                                                </div>
                                                            </div>


                                                        </div>



                                </div>




                                <!-- 刪除確認 Modal -->
                                <div class="modal fade" id="confirmModal<?= $coupon['id'] ?>" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">刪除使用者</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                確認刪除?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                                                <a role="button" class="btn btn-danger" href="coupon_Dodelete.php?id=<?= $coupon['id'] ?>">確認</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>






                                </td>
                                <!-- <td class="align-middle text-center">
                            <a href="javascript:;" class="text-secondary font-weight-bold text-m" data-toggle="tooltip" data-original-title="Edit user">
                              <i class="fa-solid fa-pen-to-square fa-fw"></i>
                            </a>
                          </td>
                          <td class="align-middle text-center">
                            <a href="javascript:;" class="text-secondary font-weight-bold text-m" data-toggle="tooltip" data-original-title="Edit user">
                              <i class="fa-solid fa-trash-can fa-fw"></i>
                            </a>
                          </td> -->

                            <?php endforeach; ?>
                            </tr>




                            </tbody>
                            </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <!-- 分頁 -->
            <?php if (!isset($_GET["search"])) : ?>
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center">
                        <?php for ($i = 1; $i <= $pageCount; $i++) : ?>
                            <li class="page-item <?= ($i == $p) ? 'active' : ''; ?>">
                                <a class="page-link" href="coupon.php?<?= !empty($order) ? "order=$order&" : ''; ?>p=<?= $i ?><?= !empty($search) ? '&search=' . urlencode($search) : ''; ?>">
                                    <?= $i ?>
                                </a>
                            </li>
                        <?php endfor; ?>
                    </ul>
                </nav>

            <?php endif; ?>

            <!-- <?php if (!isset($_GET["search"])) : ?>
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center">
                        <?php for ($i = 1; $i <= $pageCount; $i++) : ?>
                            <li class="page-item <?= ($i == $p) ? 'active' : ''; ?>">
                                <a class="page-link" href="coupon.php?order=<?= $order ?>&p=<?= $i ?><?= !empty($search) ? '&search=' . urlencode($search) : ''; ?>"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>
                    </ul>
                </nav>
            <?php endif; ?> -->





        </div>
    </main>
    <div class="fixed-plugin">
        <!-- <a class="fixed-plugin-button text-dark position-fixed px-3 py-2">
            <i class="fa fa-cog py-2"> </i>
        </a> -->
        <div class="card shadow-lg">
            <div class="card-header pb-0 pt-3">
                <div class="float-start">
                    <h5 class="mt-3 mb-0">Argon Configurator</h5>
                    <p>See our dashboard options.</p>
                </div>
                <div class="float-end mt-4">
                    <button class="btn btn-link text-dark p-0 fixed-plugin-close-button">
                        <i class="fa fa-close"></i>
                    </button>
                </div>
                <!-- End Toggle Button -->
            </div>
            <hr class="horizontal dark my-1" />
            <div class="card-body pt-sm-3 pt-0 overflow-auto">
                <!-- Sidebar Backgrounds -->
                <div>
                    <h6 class="mb-0">Sidebar Colors</h6>
                </div>
                <a href="javascript:void(0)" class="switch-trigger background-color">
                    <div class="badge-colors my-2 text-start">
                        <span class="badge filter bg-gradient-primary active" data-color="primary" onclick="sidebarColor(this)"></span>
                        <span class="badge filter bg-gradient-dark" data-color="dark" onclick="sidebarColor(this)"></span>
                        <span class="badge filter bg-gradient-info" data-color="info" onclick="sidebarColor(this)"></span>
                        <span class="badge filter bg-gradient-success" data-color="success" onclick="sidebarColor(this)"></span>
                        <span class="badge filter bg-gradient-warning" data-color="warning" onclick="sidebarColor(this)"></span>
                        <span class="badge filter bg-gradient-danger" data-color="danger" onclick="sidebarColor(this)"></span>
                    </div>
                </a>
                <!-- Sidenav Type -->
                <div class="mt-3">
                    <h6 class="mb-0">Sidenav Type</h6>
                    <p class="text-sm">Choose between 2 different sidenav types.</p>
                </div>
                <div class="d-flex">
                    <button class="btn bg-gradient-primary w-100 px-3 mb-2 active me-2" data-class="bg-white" onclick="sidebarType(this)">
                        White
                    </button>
                    <button class="btn bg-gradient-primary w-100 px-3 mb-2" data-class="bg-default" onclick="sidebarType(this)">
                        Dark
                    </button>
                </div>
                <p class="text-sm d-xl-none d-block mt-2">
                    You can change the sidenav type just on desktop view.
                </p>
                <!-- Navbar Fixed -->
                <div class="d-flex my-3">
                    <h6 class="mb-0">Navbar Fixed</h6>
                    <div class="form-check form-switch ps-0 ms-auto my-auto">
                        <input class="form-check-input mt-1 ms-auto" type="checkbox" id="navbarFixed" onclick="navbarFixed(this)" />
                    </div>
                </div>
                <hr class="horizontal dark my-sm-4" />
                <div class="mt-2 mb-5 d-flex">
                    <h6 class="mb-0">Light / Dark</h6>
                    <div class="form-check form-switch ps-0 ms-auto my-auto">
                        <input class="form-check-input mt-1 ms-auto" type="checkbox" id="dark-version" onclick="darkMode(this)" />
                    </div>
                </div>
                <a class="btn bg-gradient-dark w-100" href="https://www.creative-tim.com/product/argon-dashboard">Free Download</a>
                <a class="btn btn-outline-dark w-100" href="https://www.creative-tim.com/learning-lab/bootstrap/license/argon-dashboard">View documentation</a>
                <div class="w-100 text-center">
                    <a class="github-button" href="https://github.com/creativetimofficial/argon-dashboard" data-icon="octicon-star" data-size="large" data-show-count="true" aria-label="Star creativetimofficial/argon-dashboard on GitHub">Star</a>
                    <h6 class="mt-3">Thank you for sharing!</h6>
                    <a href="https://twitter.com/intent/tweet?text=Check%20Argon%20Dashboard%20made%20by%20%40CreativeTim%20%23webdesign%20%23dashboard%20%23bootstrap5&amp;url=https%3A%2F%2Fwww.creative-tim.com%2Fproduct%2Fargon-dashboard" class="btn btn-dark mb-0 me-2" target="_blank">
                        <i class="fab fa-twitter me-1" aria-hidden="true"></i> Tweet
                    </a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u=https://www.creative-tim.com/product/argon-dashboard" class="btn btn-dark mb-0 me-2" target="_blank">
                        <i class="fab fa-facebook-square me-1" aria-hidden="true"></i>
                        Share
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!--   Core JS Files   -->
    <script src="../assets/js/core/popper.min.js"></script>
    <script src="../assets/js/core/bootstrap.min.js"></script>
    <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
    <script>
        var win = navigator.platform.indexOf("Win") > -1;
        if (win && document.querySelector("#sidenav-scrollbar")) {
            var options = {
                damping: "0.5",
            };
            Scrollbar.init(document.querySelector("#sidenav-scrollbar"), options);
        }
    </script>
    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="../assets/js/argon-dashboard.min.js?v=2.0.4"></script>
</body>

</html>