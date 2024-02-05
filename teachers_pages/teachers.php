<?php
require_once("../db_connect.php");
// mysqli_set_charset($conn, "utf8");

$perPage=8;

$sqlAll="SELECT * FROM teacher WHERE valid=1";
$resultAll = $conn->query($sqlAll);
$teacherTotalCount = $resultAll->num_rows;

$pageCount= ceil($teacherTotalCount / $perPage);


if(isset($_GET["order"])){
  $order=$_GET["order"];

  if($order==1){
    $orderString="ORDER BY id ASC";
  }elseif($order==2){
    $orderString="ORDER BY id DESC";
  }
}



if(isset($_GET["search"])){
  $search = $_GET["search"];
  $sql = "SELECT * FROM teacher WHERE name LIKE '%$search%' AND valid=1";
}elseif (isset($_GET["p"])){
  $p=$_GET["p"];
  $startIndex= ($p - 1) * $perPage;
  $sql = "SELECT * FROM teacher WHERE valid=1 $orderString LIMIT $startIndex, $perPage";
}else{
  $p=1;
  $order=1;
  $orderString = "ORDER BY id ASC";
  $sql = "SELECT * FROM teacher WHERE valid=1 $orderString LIMIT $perPage";
}



$result = $conn->query($sql);

if(isset($_GET["search"])){
  $teacherCount = $result->num_rows;
}else{
  $teacherCount=$teacherTotalCount;
}








// $sqlTeacherLecture = "SELECT teacher.* ,lecture.name  AS lecture_name 
// FROM teacher
// LEFT JOIN lecture ON teacher.id=lecture.teacher_id
// ORDER BY teacher.id";


// $sqlTeacherLecture="SELECT teacher.*, lecture.name AS lecture_name FROM teacher JOIN lecture ON lecture.teacher_id=teacher.id";


// $sqlTeacherLecture="SELECT teacher.*, lecture.name AS lecture_name FROM teacher JOIN lecture ON lecture.teacher_id=teacher.id";


// $sqlTeacherLecture="SELECT lecture.name AS lecture_name FROM lecture JOIN teacher ON teacher.id = lecture.teacher_id WHERE lecture.teacher_id = teacher.id";

// $resultLecture = $conn->query($sqlTeacherLecture);
// $LectureRows = $resultLecture->fetch_all(MYSQLI_ASSOC);
// var_dump($LectureRows);



// $resultLecture=$conn->query($sqlTeacherLecture);
// $LectureRows=$resultLecture->fetch_all(MYSQLI_ASSOC);



?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <title>
    講師管理
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
          <a class="nav-link " href="../member_pages/member.php">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fa-solid fa-user text-dark text-sm opacity-10 fa-fw"></i>
              <!-- <i class="ni ni-calendar-grid-58 text-warning text-sm opacity-10"></i> -->
            </div>
            <span class="nav-link-text ms-1">會員管理/註冊</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="../product_pages/product-list.php">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fa-sharp fa-solid fa-leaf text-dark text-sm opacity-10 fa-fw"></i>
              <!-- <i class="ni ni-credit-card text-success text-sm opacity-10"></i> -->
            </div>
            <span class="nav-link-text ms-1">商品管理</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="../product-category_pages/primary_category.php">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fa-solid fa-table-list text-dark text-sm opacity-10 fa-fw"></i>
              <!-- <i class="ni ni-app text-info text-sm opacity-10"></i> -->
            </div>
            <span class="nav-link-text ms-1">商品類別管理</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="../articles_pages/articles.php">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fa-solid fa-message text-dark text-sm opacity-10 fa-fw"></i>
              <!-- <i class="ni ni-world-2 text-danger text-sm opacity-10"></i> -->
            </div>
            <span class="nav-link-text ms-1">文章管理</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="../order_pages/order.php">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fa-solid fa-store text-dark text-sm opacity-10 fa-fw"></i>
              <!-- <i class="ni ni-world-2 text-danger text-sm opacity-10"></i> -->
            </div>
            <span class="nav-link-text ms-1">訂單管理</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="../teachers_pages/teachers.php">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fa-solid fa-user-tie text-dark text-sm opacity-10 fa-fw"></i>
              <!-- <i class="ni ni-world-2 text-danger text-sm opacity-10"></i> -->
            </div>
            <span class="nav-link-text ms-1">講師管理</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="../lecture_pages/lecture.php">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fa-solid fa-graduation-cap text-dark text-sm opacity-10 fa-fw"></i>
              <!-- <i class="ni ni-world-2 text-danger text-sm opacity-10"></i> -->
            </div>
            <span class="nav-link-text ms-1">課程管理</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="../coupon_pages/coupon.php">
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
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" data-scroll="false">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <!-- <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="javascript:;">主頁面</a></li>
            <li class="breadcrumb-item text-sm text-white active" aria-current="page">講師管理</li>
          </ol> -->
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
            <div class="card-header pb-2">
              <div class="d-flex justify-content-between">
                <h4>講師列表</h4>
                <a href="teachers_add_teacher.php" class="btn btn-primary" href="" role="button"><i class="fa-solid fa-user-plus fa-fw"></i></a>
              </div>
              <div>
                <?php if(isset($_GET["search"])): ?>
                  <div class="col-auto">
                    <a class="btn btn-primary" href="teachers.php" role="button"><i class="fa-solid fa-angles-left fa-fw"></i></a>
                  </div>
                <?php endif; ?>
                <div class="col">
                  <form action="">
                    <div class="input-group mt-1 d-flex align-items-start">
                      <input type="search" class="form-control" placeholder="講師名字" aria-label="Recipient's teachername" aria-describedby="button-addon2" name="search"
                      <?php
                        if(isset($_GET["search"])):$searchValue=$_GET["search"];
                      ?>
                      value="<?=$searchValue?>" <?php endif; ?>
                      >
                      <button class="btn btn-primary" type="submit" id="button-addon2"><i class="fa-solid fa-magnifying-glass fa-fw"></i></button>
                    </div>
                  </form>
                </div>
              </div>
              <div class="d-flex justify-content-between align-items-start">
              <div>共<?= $teacherCount ?>人</div>
              <div class="d-flex">
                <?php if(!isset($_GET["search"])): ?>
                    <div class="me-2 mt-2">排序</div>
                    <div class="btn-group">
                      <a class="btn btn-primary
                      <?php if($order==1)echo "active" ?>
                      " href="teachers.php?order=1&p=<?= $p ?>"><i class="fa-solid fa-arrow-down-short-wide fa-fw"></i></a>
                      <a class="btn btn-primary
                      <?php if($order==2)echo "active" ?>
                      " href="teachers.php?order=2&p=<?= $p ?>"><i class="fa-solid fa-arrow-down-wide-short fa-fw"></i></a>
                    </div>
                <?php endif; ?>
              </div>
                
              </div>

            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0 text-md">
                  <thead class="font-weight-bolder">
                    <tr>
                      <th class="text-center text-secondary">ID</th>
                      <th class="text-center text-secondary">講師</th>
                      <th class="text-center text-secondary">性別</th>
                      <th class="text-center text-secondary">手機</th>
                      <th class="text-center text-secondary">信箱</th>
                      <th class="text-center text-secondary">介紹</th>
                      <th class="text-secondary opacity-7"></th>
                    </tr>
                  </thead>
                  <tbody class="text-secondary">
                    <?php 
                      $rows = $result->fetch_all(MYSQLI_ASSOC);
                      // var_dump($rows);
                      // echo '<br>';
                      // echo '<br>';
                      // echo '<br>';

                      // var_dump($LectureRows);

                      foreach ($rows as $row) :
                    ?>
                    <tr class="">
                      <td class="">
                        <div class="text-center"><?= $row["id"]?></div>
                      </td>
                      <td class="">
                        <div class="d-flex px-2 py-1 justify-content-center">
                          <!-- <div>
                            <img class="object-fit-cover" src="../teachers_images/<?= $row["img"] ?>" class="avatar avatar-sm me-3" alt="user1">
                          </div> -->
                          <div class="d-flex flex-column justify-content-center">
                            <div class="mb-0 "><?= $row["name"]?></div>
                          </div>
                        </div>
                      </td>
                      <td class="">
                        <p class=" mb-0 text-center"><?= $row["gender"]?></p>
                      </td>
                      <td class="align-middle text-center">
                        <span class=""><?= $row["phone"]?></span>
                      </td>
                      <td class="align-middle text-center">
                        <span class=""><?= $row["email"]?></span>
                      </td>
                      <td class="text-md text-truncate text-center" style="max-width: 250px;"><?= $row["intro"]?></td>
                      <td class="align-middle ">
                        <!-- <a href="teachers_teacher.php" class="font-weight-bold text-sm" data-toggle="tooltip" data-original-title="Edit user">
                        <i class="fa-solid fa-eye fa-fw"></i>
                        </a> -->
                        <div class="d-flex justify-content-center align-items-center">
                        <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#staticBackdrop<?= $row["id"] ?>"><i class="fa-solid fa-eye fa-fw"></i></button>
                        <button class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#editModal<?= $row["id"] ?>"><i class="fa-solid fa-pen-to-square fa-fw"></i></button>
                        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmModal<?= $row["id"] ?>" role="button"><i class="fa-solid fa-trash fa-fw"></i></button>
                        </div>




                        <?php
                        $id=$row["id"];
                        $sqlTeacherLecture="SELECT lecture.name FROM lecture WHERE lecture.teacher_id = $id";
                        $resultLecture=$conn->query($sqlTeacherLecture);
                        $LectureRows=$resultLecture->fetch_all(MYSQLI_ASSOC);
                        
                        // var_dump($LectureRows);

                        ?>




                        <!-- 個人檢視 -->
                        <div class="modal fade" id="staticBackdrop<?= $row["id"] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                          <div class="modal-dialog modal-lg" style="max-width: 1000px; min-width:700px; ">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h1 class="modal-title fs-5" id="staticBackdropLabel"><?= $row["name"]?></h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                                <div class="container">
                                  <div class="row">
                                    <div class="col-6 d-flex align-items-center justify-content-center">
                                      <div class="w-100 h-100 d-flex align-items-center justify-content-center square-container">
                                        <img style="width: 500px; min-width:250px;" class="object-fit-cover img-fluid"  src="../teachers_img/<?= $row["img"] ?>" alt="<?= $row["name"] ?>">
                                      </div>
                                    </div>
                                    <div class="col-6">
                                      <table class="table table-bordered">
                                        <!-- <tr>
                                            <div class="d-flex justify-content-center mx-auto mb-3">
                                              <img class="object-fit-cover img-fluid mx-auto" src="../teachers_images/<?= $row["img"] ?>" alt="<?= $row["name"] ?>">
                                            </div>
                                        </tr> -->
                                        <tr>
                                          <th class="p-3 text-center">ID</th>
                                          <td class="p-3">
                                            <?= $row["id"] ?>
                                          </td>
                                        </tr>
                                        <tr>
                                          <th class="p-3 text-center">講師姓名</th>
                                          <td class="p-3">
                                            <?= $row["name"] ?>
                                          </td>
                                        </tr>
                                        <tr>
                                          <th class="p-3 text-center">性別</th>
                                          <td class="p-3">
                                            <?= $row["gender"] ?>
                                          </td>
                                        </tr>
                                        <tr>
                                          <th class="p-3 text-center">手機號碼</th>
                                          <td class="p-3">
                                            <?= $row["phone"] ?>
                                          </td>
                                        </tr>
                                        <tr>
                                          <th class="p-3 text-center">信箱</th>
                                          <td class="p-3">
                                            <?= $row["email"] ?>
                                          </td>
                                        </tr>
                                        <tr>
                                          <th class="p-3 text-center">講師介紹</th>
                                          <td class="text-wrap p-3">
                                            <?= $row["intro"] ?>
                                          </td>
                                        </tr>
                                        <tr>

                                          <th class="p-3 text-center">教授課程</th>
                                          <td class="border-end p-3">
                                            <?php if (empty($LectureRows)) : ?>
                                              暫無課程
                                            <?php else: ?>
                                              <?php foreach($LectureRows as $LectureRow): ?>
                                              <li class="list-unstyled"><?=$LectureRow["name"]?></li>
                                              <?php endforeach; ?>
                                            <?php endif; ?>
                                          </td>
                                        </tr>
                                      </table>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="modal-footer d-flex justify-content-between">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">關閉</button>
                                <div>
                                  <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editModal<?= $row["id"] ?>"><i class="fa-solid fa-pen-to-square fa-fw"></i></button>
                                  <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmModal<?= $row["id"] ?>" role="button"><i class="fa-solid fa-trash fa-fw"></i></button>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>



                        <!-- 修改modal -->
                        <div class="modal fade" id="editModal<?= $row["id"]?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">修改資料</h1>
                              </div>
                              <form action="--UpdateTeacher.php" method="post" enctype="multipart/form-data" onsubmit="return checkFile()">
                                <div class="modal-body">

                                    <input type="hidden" name="id" value="<?=$row["id"]?>">
                                    <table class="table table-bordered">
                                      <tr>
                                        <th>講師姓名:</th>
                                        <td><input type="text" class="form-control" value="<?= $row["name"]?>" name="name" oninput="checkNameLength(this)"></td>
                                      </tr>
                                      <tr>
                                        <th>性別:</th>
                                        <td>
                                          <select placeholder="請選擇性別" name="gender" id="" class="form-select">
                                            <option value="男"  <?php if($row["gender"] == "男") echo "selected"; ?>>男</option>
                                            <option value="女"  <?php if($row["gender"] == "女") echo "selected"; ?>>女</option>
                                            <option value="其他"  <?php if($row["gender"] == "其他") echo "selected"; ?>>其他</option>
                                          </select>
                                        </td>
                                        <!-- <td><input type="text" class="form-control" value="<?= $row["gender"]?>" name="gender"></td> -->
                                      </tr>
                                      <tr>
                                        <th>手機號碼:</th>
                                        <td><input type="text" class="form-control" value="<?= $row["phone"]?>" name="phone" oninput="checkPhoneLength(this)"></td>
                                      </tr>
                                      <tr>
                                        <th>信箱:</th>
                                        <td><input type="email" class="form-control" value="<?= $row["email"]?>" name="email" oninput="checkEmailLength(this)"></td>
                                      </tr>
                                      <tr class="border-end">
                                        <th>講師介紹:</th>
                                        <td><textarea type="text" class="form-control" value="<?= $row["intro"]?>" name="intro" rows="5" style="resize: none" oninput="checkIntroLength(this)"><?= $row["intro"]?></textarea></td>
                                      </tr>
                                      <tr class="border-end">
                                        <th>講師照片:</th>
                                        <td>
                                          <input type="file" class="form-control" name="img" id="imgInput">
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


                        


                        <!-- 刪除modal -->
                        <div class="modal fade" id="confirmModal<?= $row["id"]?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">刪除使用者</h1>
                                <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                              </div>
                              <div class="modal-body">確認刪除?</div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                                <a type="button" href="--doDeleteTeacher.php?id=<?= $row["id"]?>" class="btn btn-danger" role="button">確認</a>
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
          </div>
        </div>
      </div>









      <?php if(!isset($_GET["search"])): ?>
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
              <?php for($i=1; $i<=$pageCount; $i++): ?>
              <li class="page-item <?php
              if($i==$p)echo "active";
              ?>"><a class="page-link" href="teachers.php?order=<?=$order?>&p=<?=$i?>"><?=$i?></a></li>
              <?php endfor; ?>
            </ul>
        </nav>
      <?php endif; ?>


      
      


























      <!-- <footer class="footer pt-3  ">
        <div class="container-fluid">
          <div class="row align-items-center justify-content-lg-between">
            <div class="col-lg-6 mb-lg-0 mb-4">
              <div class="copyright text-center text-sm text-muted text-lg-start">
                © <script>
                  document.write(new Date().getFullYear())
                </script>,
                made with <i class="fa fa-heart"></i> by
                <a href="https://www.creative-tim.com" class="font-weight-bold" target="_blank">Creative Tim</a>
                for a better web.
              </div>
            </div>
            <div class="col-lg-6">
              <ul class="nav nav-footer justify-content-center justify-content-lg-end">
                <li class="nav-item">
                  <a href="https://www.creative-tim.com" class="nav-link text-muted" target="_blank">Creative Tim</a>
                </li>
                <li class="nav-item">
                  <a href="https://www.creative-tim.com/presentation" class="nav-link text-muted" target="_blank">About Us</a>
                </li>
                <li class="nav-item">
                  <a href="https://www.creative-tim.com/blog" class="nav-link text-muted" target="_blank">Blog</a>
                </li>
                <li class="nav-item">
                  <a href="https://www.creative-tim.com/license" class="nav-link pe-0 text-muted" target="_blank">License</a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </footer> -->
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


  <script>

    // 設定名字字數不能超過50
    function checkNameLength(input) {
            var name = input.value;
            var maxLength = 50;
            
            if (name.length > maxLength) {
                alert("姓名字數過長");
                input.value = name.substring(0, maxLength); // 截斷超過的部分
            }
    }

    
    // 設定電話字數不能超過20
    function checkPhoneLength(input) {
            var phone = input.value;
            var maxLength = 20;
            
            if (phone.length > maxLength) {
                alert("手機號碼過長");
                input.value = phone.substring(0, maxLength); // 截斷超過的部分
            }
    }



    // 設定信箱字數不能超過50
    function checkEmailLength(input) {
            var email = input.value;
            var maxLength = 50;
            
            if (email.length > maxLength) {
                alert("信箱過長");
                input.value = email.substring(0, maxLength); // 截斷超過的部分
            }
    }





    // 設定介紹輸入欄位不可超過200字數
    function checkIntroLength(textarea) {
        var intro = textarea.value;
        var maxLength = 200;
        
        if (intro.length > maxLength) {
            alert("教師介紹字數請小於200");
            textarea.value = intro.substring(0, maxLength); // 截斷超過的部分
        }
    }

    
  </script>



</body>

</html>