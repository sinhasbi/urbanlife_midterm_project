<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <title>
    註冊頁面
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

  <!-- JQUERY -->
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

  <style>
    .previewimage {
      --width: 400px;
      width: var(--width);
      height: var(--width);
      overflow: hidden;
      position: relative;
    }

    .previewimage img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .deletebtn {
      position: absolute;
      left: 150px;
      bottom: 0;
      display: none;
    }
  </style>
</head>

<body class="g-sidenav-show bg-gray-100">
  <main class="main-content mt-0">
    <form action="doRegister.php" method="post" enctype="multipart/form-data" novalidate>
      <div class="container">
        <div class="py-2">
          <a class="btn btn-primary" href="../member_pages/member.php" role="button"><i
              class="fa-solid fa-angles-left fa-fw"></i>回到會員列表</a>
        </div>

        <h1 class="text-center my-4">新增使用者</h1>
        <div class="row justify-content-center">
          <div class="col-lg-6 col-md-8 d-flex justify-content-center mt-8">
            <div class="previewimage border">
              <img alt="圖片預覽">
              <div>
                <button class="btn btn-warning deletebtn" type="hidden" id="deletebtn">更換圖片</button>
              </div>
            </div>
          </div>

          <div class="col-lg-6 col-md-8">
            <div class="mb-2">
              <label for="" class="form-label">名稱</label>
              <input type="text" class="form-control" name="name">
              <?php if (isset($_SESSION["error"]["name"])): ?>
                <div class="text-danger"><?= $_SESSION["error"]["name"] ?></div>
              <?php endif; ?>
            </div>
            <div class="mb-2">
              <label for="" class="form-label">帳號</label>
              <input type="text" class="form-control" name="account">
              <?php if (isset($_SESSION["error"]["account"])): ?>
                <div class="text-danger"><?= $_SESSION["error"]["account"] ?></div>
              <?php endif; ?>
            </div>
            <div class="mb-2">
              <label for="" class="form-label">密碼</label>
              <input type="password" class="form-control" name="password">
              <?php if (isset($_SESSION["error"]["password"])): ?>
                <div class="text-danger"><?= $_SESSION["error"]["password"] ?></div>
              <?php endif; ?>
            </div>
            <div class="mb-2">
              <label for="" class="form-label">重新輸入密碼</label>
              <input type="password" class="form-control" name="repassword">
              <?php if (isset($_SESSION["error"]["repassword"])): ?>
                <div class="text-danger"><?= $_SESSION["error"]["repassword"] ?></div>
              <?php endif; ?>
            </div>
            <div class="mb-2">
              <label for="" class="form-label">信箱</label>
              <input type="email" class="form-control" name="email">
              <?php if (isset($_SESSION["error"]["email"])): ?>
                <div class="text-danger"><?= $_SESSION["error"]["email"] ?></div>
              <?php endif; ?>
            </div>
            <div class="mb-2">
              <label for="" class="form-label">生日</label>
              <input type="date" class="form-control" name="birthday">
              <?php if (isset($_SESSION["error"]["birthday"])): ?>
                <div class="text-danger"><?= $_SESSION["error"]["birthday"] ?></div>
              <?php endif; ?>
            </div>
            <div class="mb-2">
              <label for="" class="form-label">電話號碼</label>
              <input type="text" class="form-control" name="phone">
              <?php if (isset($_SESSION["error"]["phone"])): ?>
                <div class="text-danger"><?= $_SESSION["error"]["phone"] ?></div>
              <?php endif; ?>
            </div>
            <div class="mb-2">
              <label for="" class="form-label">地址</label>
              <input type="text" class="form-control" name="address">
              <?php if (isset($_SESSION["error"]["address"])): ?>
                <div class="text-danger"><?= $_SESSION["error"]["address"] ?></div>
              <?php endif; ?>
            </div>
            <div class="mb-2">
              <label for="" class="form-label">信用卡號</label>
              <input type="text" class="form-control" name="creditcard">
              <?php if (isset($_SESSION["error"]["creditcard"])): ?>
                <div class="text-danger"><?= $_SESSION["error"]["creditcard"] ?></div>
              <?php endif; ?>
            </div>
            <div class="mb-2">
              <label for="" class="form-label">圖片</label>
              <input type="file" class="form-control" name="image" id="imginput">
            </div>
            <div class="text-center mt-5">
              <button class="btn btn-primary px-10" type="submit">新增使用者</button>
            </div>
          </div>
        </div>
      </div>
    </form>

    <script>
      $('input[type="file"]').on('change', function (e) {
        const file = this.files[0];
        const fr = new FileReader();

        fr.onload = function (e) {
          $('img').attr('src', e.target.result);
        };
        $('#deletebtn').show();
        fr.readAsDataURL(file);
      });

      const deletebtn = document.querySelector("#deletebtn");
      const imginput = document.querySelector("#imginput");
      deletebtn.addEventListener("click", function (event) {
        event.preventDefault();
        $('img').attr('src', '');
        $('#deletebtn').hide();
        imginput.value = "";
      });
    </script>
  </main>
</body>

</html>

<?php
// 清空 SESSION 中的错误信息
unset($_SESSION["error"]);
?>