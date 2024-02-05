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
  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
  <!-- Awesome Font -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class="g-sidenav-show bg-gray-100">
  <div class="container max-height-vh-100 h-100 " style="max-width: 500px">
    <div class="py-2 mt-3">
      <a href="articles.php" class="btn btn-primary" role="button">
        <i class="fa-solid fa-angles-left fa-fw"></i>回商品管理
      </a>
    </div>
    <p class="text-uppercase text-center">新增文章</p>
    <form action="doAddArticle.php" method="post" enctype="multipart/form-data">
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label for="example-text-input" class="form-control-label">文章標題</label>
            <input class="form-control" type="text" placeholder="請輸入文章標題" name="addTitle">
          </div>
        </div>
        <div class="col-md-12">
          <div class="form-group">
            <label for="example-text-input" class="form-control-label">分類</label>
            <input class="form-control" type="text" value="official announcemen" aria-label="Disabled input example" disabled readonly>
          </div>
        </div>
        <div class="col-md-12">
          <div class="form-group">
            <label for="example-text-input" class="form-control-label">文章內文</label>
            <textarea class="form-control" type="text" value="請輸入文章內文" rows="3" name="addContent"></textarea>
          </div>
        </div>
        <div class="col-md-12">
          <div class="form-group">
            <label for="formFileMultiple" class="form-label">新增圖片</label>
            <input class="form-control" type="file" id="formFileMultiple" multiple name="pic">
          </div>
        </div>
      </div>
      <div class="d-grid gap-2 col-2 mx-auto">
        <button type="submit" class="btn btn-primary">
          送出
        </button>
      </div>
    </form>
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
</body>

</html>