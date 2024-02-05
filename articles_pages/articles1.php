<?php
require_once("../db_connect.php");

$sqlCategory = "SELECT *FROM article_category ";
$resultCategory = $conn->query($sqlCategory);
$rowsCategory = $resultCategory->fetch_all(MYSQLI_ASSOC);
$rowsCount = $resultCategory->num_rows;

$cate_filter = isset($_GET["cate"]) && !empty($_GET["cate"]) ? "WHERE category_id = " . $_GET["cate"] : "";

// 修改

$sqlAll = "SELECT article.* ,user.name  AS user_name ,article_category.name  AS category_name, article_img.filename AS filename
FROM article 
JOIN user ON article.user_id=user.id
JOIN article_category ON article.category_id=article_category.id
LEFT JOIN article_img ON article.img_id = article_img.id
$cate_filter
ORDER BY article.id";
$resultAll = $conn->query($sqlAll);
$articleTotalCount = $resultAll->num_rows;
$perPage = 10;
$pageCount = ceil($articleTotalCount / $perPage);


if (isset($_GET["order"])) {
  $order = $_GET["order"];
  if ($order == 1) {
    $orderString = "ORDER by id ASC";
  } elseif ($order == 2) {
    $orderString = "ORDER by id DESC";
  }
}

if(isset($_GET["cate"]) && !empty($_GET["cate"])){
  $cate = intval($_GET["cate"]);
  $sql = "SELECT article.*, user.name AS user_name, article_category.name AS category_name, article_img.filename AS filename
    FROM article 
    JOIN user ON article.user_id=user.id
    JOIN article_category ON article.category_id=article_category.id
    LEFT JOIN article_img ON article.img_id = article_img.id
    WHERE category_id = ? AND article.valid=1
   ";
    
  
  // 使用预处理语句
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $cate); // "i" 表示参数为整数类型
  $stmt->execute();
}
elseif(isset($_GET["search"])) {
  $search = "%" . $_GET["search"] . "%"; // 添加通配符来匹配搜索字符串的任意位置
  $sql = "SELECT article.*, user.name AS user_name, article_category.name AS category_name, article_img.filename AS filename
    FROM article 
    JOIN user ON article.user_id=user.id
    JOIN article_category ON article.category_id=article_category.id
    LEFT JOIN article_img ON article.img_id = article_img.id
    WHERE (article.title LIKE ? OR user.name LIKE ?) AND article.valid=1";

  // 使用预处理语句
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ss", $search, $search); // "s" 表示参数为字符串类型
  $stmt->execute();
} elseif (isset($_GET["p"]) || $_GET["search"] = "") {
  $p = $_GET["p"];
  $startIndex = ($p - 1) * $perPage;
  $sql = "SELECT article.*, user.name AS user_name, article_category.name AS category_name, article_img.filename AS filename
    FROM article 
    JOIN user ON article.user_id=user.id
    JOIN article_category ON article.category_id=article_category.id
    LEFT JOIN article_img ON article.img_id = article_img.id
    WHERE article.valid=1 
    $orderString
    LIMIT ?, ?";
  
  // 使用预处理语句
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ii", $startIndex, $perPage); // "i" 表示参数为整数类型
  $stmt->execute();
} else {
  $p = 1;
  $order = 1;
  $orderString = "ORDER BY id ASC";
  $sql = "SELECT article.*, user.name AS user_name, article_category.name AS category_name, article_img.filename AS filename
    FROM article 
    JOIN user ON article.user_id=user.id
    JOIN article_category ON article.category_id=article_category.id
    LEFT JOIN article_img ON article.img_id = article_img.id
    WHERE article.valid=1
    $orderString
    LIMIT ?";
  
  // 使用预处理语句
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $perPage); // "i" 表示参数为整数类型
  $stmt->execute();
}

// 获取查询结果
$result = $stmt->get_result();
$rowsCount = $result->num_rows;

// 关闭预处理语句
$stmt->close();


// if(isset($_GET["cate"]) && !empty($_GET["cate"])){
//   $cate = intval($_GET["cate"]);
//   $sql = "SELECT article.* ,user.name  AS user_name ,article_category.name  AS category_name, article_img.filename AS filename
//     FROM article 
//     JOIN user ON article.user_id=user.id
//     JOIN article_category ON article.category_id=article_category.id
//     LEFT JOIN article_img ON article.img_id = article_img.id
//     WHERE  category_id =? AND article.valid=1";
// }
// elseif(isset($_GET["search"])) {
//   $search = $_GET["search"];
//   $sql = "SELECT article.* ,user.name  AS user_name ,article_category.name  AS category_name, article_img.filename AS filename
//     FROM article 
//     JOIN user ON article.user_id=user.id
//     JOIN article_category ON article.category_id=article_category.id
//     LEFT JOIN article_img ON article.img_id = article_img.id
//     WHERE (article.title LIKE '%$search%' OR user.name LIKE '%$search%') AND article.valid=1";
// } elseif (isset($_GET["p"]) || $_GET["search"] = "") {
//   $p = $_GET["p"];
//   $startIndex = ($p - 1) * $perPage;
//   $sql = "SELECT article.* ,user.name  AS user_name ,article_category.name  AS category_name, article_img.filename AS filename
//     FROM article 
//     JOIN user ON article.user_id=user.id
//     JOIN article_category ON article.category_id=article_category.id
//     LEFT JOIN article_img ON article.img_id = article_img.id
//     WHERE article.valid=1 
//     $orderString
//     LIMIT $startIndex, $perPage";
// } else {
//   $p = 1;
//   $order = 1;
//   $orderString = "ORDER BY id ASC";
//   $sql = "SELECT article.* ,user.name  AS user_name ,article_category.name  AS category_name, article_img.filename AS filename
//     FROM article 
//     JOIN user ON article.user_id=user.id
//     JOIN article_category ON article.category_id=article_category.id
//     LEFT JOIN article_img ON article.img_id = article_img.id
//     WHERE article.valid=1
//     $orderString
//     LIMIT $perPage";
  
// }
// $result = $conn->query($sql);
//   $rowsCount = $result->num_rows;


// $pageCount = ceil($articleTotalCount / $perPage);







// if (isset($_GET["search"])&& $_GET["search"]!="") { 
//   $rowsCount = $result->num_rows;
// } 
// else { 
//   $rowsCount = $articleTotalCount;
// }

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <title>
    Argon Dashboard 2 by Creative Tim
  </title>
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link id="pagestyle" href="../assets/css/argon-dashboard.css?v=2.0.4" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <!-- Bootstrap JavaScript (Popper.js and Bootstrap JS) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="..." crossorigin="anonymous"></script>

</head>

<body class="g-sidenav-show   bg-gray-100">
  <div class="min-height-300 bg-primary position-absolute w-100"></div>
  <aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 z-index-0" id="sidenav-main ">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand m-0" href=" https://demos.creative-tim.com/argon-dashboard/pages/dashboard.html " target="_blank">
        <img src="../assets/img/logo-ct-dark.png" class="navbar-brand-img h-100" alt="main_logo">
        <span class="ms-1 font-weight-bold">城市生機</span>
      </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class=" w-auto " id="sidenav-collapse-main">
      <ul class="navbar-nav">
        <!-- <li class="nav-item">
          <a class="nav-link" href="./pages/dashboard.html">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-tv-2 text-primary text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">主頁面
            </span>
          </a>
        </li> -->
        <li class="nav-item">
          <a class="nav-link " href="./pages/tables.html">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fa-solid fa-user text-dark text-sm opacity-10 fa-fw"></i>
              <!-- <i class="ni ni-calendar-grid-58 text-warning text-sm opacity-10"></i> -->
            </div>
            <span class="nav-link-text ms-1">會員管理/註冊</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="./pages/billing.html">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fa-sharp fa-solid fa-leaf text-dark text-sm opacity-10 fa-fw"></i>
              <!-- <i class="ni ni-credit-card text-success text-sm opacity-10"></i> -->
            </div>
            <span class="nav-link-text ms-1">商品管理</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="./pages/virtual-reality.html">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fa-solid fa-table-list text-dark text-sm opacity-10 fa-fw"></i>
              <!-- <i class="ni ni-app text-info text-sm opacity-10"></i> -->
            </div>
            <span class="nav-link-text ms-1">商品類別管理</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="./pages/rtl.html">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fa-solid fa-message text-dark text-sm opacity-10 fa-fw"></i>
              <!-- <i class="ni ni-world-2 text-danger text-sm opacity-10"></i> -->
            </div>
            <span class="nav-link-text ms-1">文章管理</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="./pages/rtl.html">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fa-solid fa-store text-dark text-sm opacity-10 fa-fw"></i>
              <!-- <i class="ni ni-world-2 text-danger text-sm opacity-10"></i> -->
            </div>
            <span class="nav-link-text ms-1">訂單管理</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="./pages/rtl.html">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fa-solid fa-user-tie text-dark text-sm opacity-10 fa-fw"></i>
              <!-- <i class="ni ni-world-2 text-danger text-sm opacity-10"></i> -->
            </div>
            <span class="nav-link-text ms-1">講師管理</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="./pages/rtl.html">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fa-solid fa-graduation-cap text-dark text-sm opacity-10 fa-fw"></i>
              <!-- <i class="ni ni-world-2 text-danger text-sm opacity-10"></i> -->
            </div>
            <span class="nav-link-text ms-1">課程管理</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="./pages/rtl.html">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fa-solid fa-ticket-simple text-dark text-sm opacity-10 fa-fw"></i>
              <!-- <i class="ni ni-world-2 text-danger text-sm opacity-10"></i> -->
            </div>
            <span class="nav-link-text ms-1">優惠券管理</span>
          </a>
        </li>

        <li class="nav-item mt-3">
          <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">個人主頁</h6>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="../pages/profile.html">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-single-02 text-dark text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">個人檔案</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="../pages/sign-in.html">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-single-copy-04 text-warning text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">登入</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="../pages/sign-up.html">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-collection text-info text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">登出</span>
          </a>
        </li>
      </ul>
    </div>
    
  </aside>
  <main class="main-content position-relative border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl " id="navbarBlur" data-scroll="false">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="javascript:;">主頁面</a></li>
            <li class="breadcrumb-item text-sm text-white active" aria-current="page">文章管理</li>
          </ol>
          <!-- <h6 class="font-weight-bolder text-white mb-0">主頁面</h6> -->
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
          <div class="ms-md-auto pe-md-3 d-flex align-items-center">

          </div>
          <div class="text-white px-4">
            HI, USER
          </div>
          <ul class="navbar-nav  justify-content-end">
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
                <h4>文章列表</h4>
                <div>
                  新增
                  <a name="" id="" class="btn btn-primary" href="add-article.php" role="button">
                    <i class="fa-solid fa-plus fa-fw"></i>
                  </a>
                </div>
              </div>
              <div class="py-2">
                <ul class="nav nav-tabs">
                  <li class="nav-item">
                    <a class="nav-link  <?php if (!isset($_GET["cate"])) echo "active"; ?> " aria-current="page" href="articles.php">全部</a>
                  </li>
                  <?php foreach ($rowsCategory as $catedory) : ?>
                    <li class="nav-item">
                      <a class="nav-link 
                    <?php if (isset($_GET["cate"]) && $_GET["cate"] == $catedory["id"]) echo "active"; ?>" aria-current="page" href="articles.php?cate=<?= $catedory["id"] ?>"><?= $catedory["name"] ?></a>
                    </li>
                  <?php endforeach; ?>
                </ul>
              </div>
              <div class="col">
                <?php if (isset($_GET["search"]) && $_GET["search"] != "") :; ?>
                  <div class="col-auto">
                    <a name="" id="" class="btn btn-primary" href="articles.php" role="button"><i class="fa-solid fa-arrow-left fa-fw"></i></a>
                  </div>
                <?php endif; ?>
                <form action="" method="get">

                  <div class="input-group mb-3">
                    <input style="height: 41px;" type="search" class="form-control box-sizing inline-block" placeholder="搜尋" aria-label="Recipient's username" aria-describedby="button-addon2" name="search" <?php if (isset($_GET["search"])) : $searchValue = $_GET["search"]; ?> value="<?= $searchValue ?>" <?php endif; ?>>
                    <button class="btn btn-primary" type="submit" id="button-addon2"><i class="fa-solid fa-magnifying-glass fa-fw"></i></button>
                  </div>
                </form>
              </div>
              <div class="d-flex justify-content-between align-item-center">
                <div>
                  共
                  <?= $rowsCount ?>
                  筆
                </div>
                <?php if (!isset($_GET["cate"]) ) :; ?>
                <div class="d-flex">
                  <div class="me-2">排序</div>
                  <div class="btn-group">
                    <a class="btn btn-primary <?php if ($order == 1) echo "active" ?>" href="articles.php?order=1&p=<?= $p ?>"><i class="fa-solid fa-arrow-down-short-wide fa-fw"></i></a>
                    <a class="btn btn-primary <?php if ($order == 2) echo "active" ?>" href="articles.php?order=2&p=<?= $p ?>"><i class="fa-solid fa-arrow-down-wide-short fa-fw"></i></a>
                    <!-- <a class="btn btn-primary <?php if ($order == 3) echo "active" ?>" href="articles.php?order=3&p=<?= $p ?>"><i class="fa-solid fa-arrow-down-a-z fa-fw"></i></a>
                    <a class="btn btn-primary <?php if ($order == 4) echo "active" ?>" href="articles.php?order=4&p=<?= $p ?>"><i class="fa-solid fa-arrow-down-z-a fa-fw"></i></a> -->
                  </div>
                </div>
                <?php endif ;?>
              </div>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <?php if ($rowsCount > 0) : ?>
                  <table class="table align-items-center mb-0 table-bordered text-md">
                    <thead>
                      <tr>
                        <th class="text-secondary font-weight-bolder opacity-7">#</th>
                        <th class="text-secondary font-weight-bolder opacity-7">標題</th>
                        <th class="text-secondary font-weight-bolder opacity-7">分類</th>
                        <th class="text-secondary font-weight-bolder opacity-7">發文者</th>
                        <th class="text-secondary font-weight-bolder opacity-7">更新時間</th>
                        <th class="text-secondary text-center opacity-7"></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $rows = $result->fetch_all(MYSQLI_ASSOC);
                      foreach ($rows as $article) :
                      ?>
                        <tr>
                          <td>
                            <p class="text-secondary mb-0 text-center"><?= $article["id"] ?></p>
                          </td>
                          <td>
                            <p class=" text-secondary mb-0"><?= $article["title"] ?></p>
                          </td>
                          <td>
                            <p class=" text-secondary mb-0"><?= $article["category_name"] ?></p>
                          </td>
                          <td>
                            <p class=" text-secondary mb-0 text-center"><?= $article["user_name"] ?></p>
                          </td>
                          <td>
                            <p class="text-secondary mb-0"><?= $article["update"] ?></p>
                          </td>
                          <td>
                          

                            <!-- MODAL模型 -->
                            <div class="modal fade" id="staticBackdrop<?= $article["id"] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                              <div class="modal-dialog modal-xl">
                                <div class="modal-content">
                                  <!-- Modal Header -->
                                  <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="staticBackdropLabel"><?= $article["id"] ?></h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <!-- Modal Body -->
                                  <div class="modal-body">
                                    <div class="container">
                                      <div class="row">
                                        <div class="col">
                                          <table class="table table-bordered">
                                            <tr>
                                              <th>文章標題</th>
                                              <td><?= $article["title"] ?></td>
                                            </tr>
                                            <tr>
                                              <th>分類</th>
                                              <td><?= $article["category_name"] ?></td>
                                            </tr>
                                            <tr>
                                              <th>文章內文</th>
                                              <td class="text-wrap"><?= $article["content"] ?></td>
                                            </tr>
                                            <tr>
                                              <th>圖片</th>
                                              <td>
                                                <?php if (isset($article["filename"])) : ?>
                                                  <div class="ratio ratio-1x1" style="max-width: 200px;">
                                                    <img src="../picture/<?= $article["filename"] ?>" alt="">
                                                  </div>
                                                <?php endif ?>
                                              </td>

                                            </tr>
                                            <tr>
                                              <th>發文者</th>
                                              <td><?= $article["user_name"] ?></td>
                                            </tr>
                                            <tr>
                                              <th>更新時間</th>
                                              <td><?= $article["update"] ?></td>
                                            </tr>
                                          </table>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <!-- Modal Footer -->
                                  <div class="modal-footer d-flex justify-content-lg-between">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">關閉</button>
                                    <div>
                                      <!-- 修改 -->
                                      <?php if ($article["category_id"] == 1) : ?>
                                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal<?= $article["id"] ?>">修改</button>
                                        <!-- 刪除 -->
                                        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmModal<?= $article["id"] ?>" role="button"><i class="fa-solid fa-trash fa-fw"></i></button>
                                      <?php endif ?>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <!-- 按修改會跳出來的東西 (完成) -->
                            <div class="modal fade" id="editModal<?= $article["id"] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">修改資料</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <!-- Form for editing user details -->
                                  <form action="doEditArticle.php" method="post" enctype="multipart/form-data">
                                    <div class="modal-body">
                                      <input type="hidden" name="id" value="<?= $article["id"] ?>">
                                      <table class="table table-bordered">
                                        <tr>
                                          <th>文章標題</th>
                                          <td>
                                            <input type="text" class="form-control" name="editTitle" value="<?= $article["title"] ?>">
                                          </td>
                                        </tr>
                                        <tr>
                                          <th>分類</th>
                                          <td>
                                            official announcemen
                                          </td>
                                        </tr>
                                        <tr>
                                          <th>內文</th>
                                          <td>
                                            <textarea class="form-control" name="editContent" rows="4"><?= $article["content"] ?> </textarea>
                                          </td>
                                        </tr>
                                        <tr>
                                          <th>照片</th>
                                          <td>
                                            <?php if (isset($article["filename"])) : ?>
                                              <div class="ratio ratio-1x1" style="max-width: 200px;">
                                                <img src="../picture/<?= $article["filename"] ?>" alt="">
                                              </div>
                                            <?php endif ?>
                                            <input type="file" class="form-control mt-3" name="pic" value="<?= $article["filename"] ?>">
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
                            <!-- 按鈕 -->
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop<?= $article["id"] ?>"><i class="fa-solid fa-eye fa-fw"></i></button>
                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editModal<?= $article["id"] ?>"><i class="fa-solid fa-pen-to-square fa-fw"></i></button>
                        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmModal<?= $article["id"] ?>" role="button"><i class="fa-solid fa-trash fa-fw"></i></button>
                            
                            <!-- 按刪除會跳出來的東西 -->
                            <div class="modal fade" id="confirmModal<?= $article["id"] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                    <a type="button" href="doDeleteArticle.php?id=<?= $article["id"] ?>" class="btn btn-danger" role="button">確認</a>
                                  </div>
                                </div>
                              </div>
                            </div>

                          </td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>

                  </table>
              </div>
            </div>
          <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
    <!-- 分頁 -->
    <?php if ((!isset($_GET["search"]) || $_GET["search"] == "") && !isset($_GET["cate"])) : ?>
    <nav aria-label="Page navigation example">
      <ul class="pagination">
        <?php for ($i = 1; $i <= $pageCount; $i++) : ?>
          <li class="page-item <?php if ($i == $p) echo "active" ?>">
            <a class="page-link" href="articles.php?order=<?= $order ?>&p=<?= $i ?>"><?= $i ?></a>

          </li>

        <?php endfor; ?>
      </ul>
    </nav>
    <?php endif ?>
    <!-- 分頁結束 -->


    </div>
  </main>
  <div class="fixed-plugin">
    <a class="fixed-plugin-button text-dark position-fixed px-3 py-2">
      <i class="fa fa-cog py-2"> </i>
    </a>
    <div class="card shadow-lg">
      <div class="card-header pb-0 pt-3 ">
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
      <hr class="horizontal dark my-1">
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
          <button class="btn bg-gradient-primary w-100 px-3 mb-2 active me-2" data-class="bg-white" onclick="sidebarType(this)">White</button>
          <button class="btn bg-gradient-primary w-100 px-3 mb-2" data-class="bg-default" onclick="sidebarType(this)">Dark</button>
        </div>
        <p class="text-sm d-xl-none d-block mt-2">You can change the sidenav type just on desktop view.</p>
        <!-- Navbar Fixed -->
        <div class="d-flex my-3">
          <h6 class="mb-0">Navbar Fixed</h6>
          <div class="form-check form-switch ps-0 ms-auto my-auto">
            <input class="form-check-input mt-1 ms-auto" type="checkbox" id="navbarFixed" onclick="navbarFixed(this)">
          </div>
        </div>
        <hr class="horizontal dark my-sm-4">
        <div class="mt-2 mb-5 d-flex">
          <h6 class="mb-0">Light / Dark</h6>
          <div class="form-check form-switch ps-0 ms-auto my-auto">
            <input class="form-check-input mt-1 ms-auto" type="checkbox" id="dark-version" onclick="darkMode(this)">
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
            <i class="fab fa-facebook-square me-1" aria-hidden="true"></i> Share
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
    function updateDropdownTextAndInput(text) {
      // 更新下拉菜單按鈕文字
      document.getElementById('dropdownMenuButton1').innerText = text;
      // event.preventDefault();
    }
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../assets/js/argon-dashboard.min.js?v=2.0.4"></script>
</body>

</html>