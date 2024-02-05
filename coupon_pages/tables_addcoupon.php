<?php
require_once("../db_connect.php"); //讀入資料庫//＊＊浩雲要改
$sql = "SELECT * FROM coupon WHERE valid=1"; //找資料庫coupon表格 valid=1
$result = $conn->query($sql); //連接
$rows = $result->fetch_all(MYSQLI_ASSOC);

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
        .status-disabled {
            color: red;
        }

        .status-enabled {
            color: green;
        }
    </style>
</head>

<body class="g-sidenav-show bg-gray-100">
    <div class="min-height-300 bg-primary position-absolute w-100"></div>

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
        <div class="container-fluid py-4 d-flex justify-content-center ">
            <div class="row d-flex justify-content-center">
                <div class="col-md-12 d-flex justify-content-center  ">
                    <div class="card" style="width:1200px;">
                        <div class="card-header pb-0">
                            <a class="btn btn-primary " href="coupon.php" role="button"><i class="fa-solid fa-angles-left fa-fw"></i>回優惠券管理</a>

                        </div>

                        <div class="card-body">
                            <h4>新增優惠券</h4>


                            <form action="coupon_Docreate.php" method="post">
                                <div class="mb-3">
                                    <label for="name" class="form-label fs-6">優惠券名稱:</label>
                                    <input type="text" class="form-control fs-6" id="name" name="name">
                                </div>

                                <div class="mb-3">
                                    <label for="code" class="form-label fs-6">優惠券代碼(輸入大寫英文字母三碼＋數字兩碼):</label>
                                    <input type="text" class="form-control fs-6" id="code" name="code">
                                </div>

                                <div class="mb-3">
                                    <label for="" class="form-label fs-6">適用狀況:</label>

                                    <select class="form-select fs-6" aria-label="Default select example" name="category_id">
                                        <option selected>選擇試用產品的分類</option>
                                        <option value="1">1種子</option>
                                        <option value="2">2種苗</option>
                                        <option value="3">3農藥</option>
                                        <option value="4">4材料</option>
                                        <option value="5">5肥料</option>
                                        <option value="6">6書籍</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="type" class="form-label fs-6">優惠券種類:</label>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input fs-6" type="radio" name="type" id="type" value="百分比">
                                        <label class="form-check-label fs-6" for="inlineRadio1">百分比</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input fs-6" type="radio" name="type" id="type" value="金額">
                                        <label class="form-check-label fs-6" for="inlineRadio2">金額</label>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="amount" class="form-label fs-6">折扣值 (可輸入小數，如 0.7, 0.8 或整數):</label>
                                    <input type="number" class="form-control fs-6" id="amount" name="amount" step="0.01">
                                </div>


                                <div class="mb-3">
                                    <label for="" class="form-label fs-6">優惠券狀態:</label>
                                    <div class="form-check">

                                        <input class="form-check-input fs-6" type="radio" name="status" id="1" value="已停用">
                                        <label class="form-check-label fs-6" for="flexRadioDefault1">
                                            已停用
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input fs-6" type="radio" name="status" id="2" value="可使用" checked>
                                        <label class="form-check-label fs-6" for="flexRadioDefault2">
                                            可使用
                                        </label>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="min_price" class="form-label fs-6">低消金額(請輸入整數):</label>
                                    <input type="number" class="form-control fs-6" id="min_price" name="min_price">
                                </div>

                                <div class="mb-3">
                                    <label for="started" class="form-label fs-6">開始日期:</label>
                                    <input type="datetime-local" class="form-control fs-6" id="started" name="started">
                                </div>

                                <div class="mb-3">
                                    <label for="deadline" class="form-label fs-6">結束日期:</label>
                                    <input type="datetime-local" class="form-control fs-6" id="deadline" name="deadline">
                                </div>

                                <button type="submit" class="btn btn-primary fs-6">提交</button>
                            </form>
                        </div>



                        <hr class="horizontal dark">


                    </div>



                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">

                        </div>
                    </div>
                </div>
            </div>
        </div>




        </div>
    </main>
    <div class="fixed-plugin">
        <a class="fixed-plugin-button text-dark position-fixed px-3 py-2">
            <i class="fa fa-cog py-2"> </i>
        </a>
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