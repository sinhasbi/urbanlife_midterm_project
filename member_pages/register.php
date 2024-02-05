<?php
session_start();
require_once("../db_connect.php");

$sql = "SELECT img FROM user ORDER By id DESC";
$result = $conn->query($sql);
$rows = $result->fetch_all(MYSQLI_ASSOC);

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

      img {
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

    }
  </style>
</head>

<body class="g-sidenav-show   bg-gray-100">

  <main class="main-content  mt-0 ">

    <form action="doRegister.php" method="post" enctype="multipart/form-data" novalidate>
      <div class="container">
        <div class="py-2">
          <a class="btn btn-primary " href="../member_pages/member.php" role="button"><i class="fa-solid fa-angles-left fa-fw"></i>回到會員列表</a>
        </div>

        <h1 class="text-center my-4">新增使用者</h1>
        <div class="row justify-content-center">
          <div class="col-lg-6 col-md-8 d-flex justify-content-center mt-8">
            <div class="previewimage border ">
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
            </div>
            <div class="mb-2">
              <label for="" class="form-label">帳號</label>
              <input type="text" class="form-control" name="account">
            </div>
            <div class="mb-2">
              <label for="" class="form-label">密碼</label>
              <input type="password" class="form-control" name="password">
            </div>
            <div class="mb-2">
              <label for="" class="form-label">重新輸入密碼</label>
              <input type="password" class="form-control" name="repassword">
            </div>
            <div class="mb-2">
              <label for="" class="form-label">信箱</label>
              <input type="email" class="form-control" name="email">
            </div>
            <div class="mb-2">
              <label for="" class="form-label">生日</label>
              <input type="date" class="form-control" name="birthday">
            </div>
            <div class="mb-2">
              <label for="" class="form-label">電話號碼</label>
              <input type="text" class="form-control" name="phone">
            </div>
            <div class="mb-2">
              <label for="" class="form-label">地址</label>
              <input type="text" class="form-control" name="address">
            </div>
            <div class="mb-2">
              <label for="" class="form-label">信用卡號</label>
              <input type="text" class="form-control" name="creditcard">
            </div>
            <div class="mb-2">
              <label for="" class="form-label">圖片</label>
              <input type="file" class="form-control" name="image" id="imginput">
            </div>
            <div class="text-center mt-5">
              <button class="btn btn-primary px-10" type="submit">新增使用者</button>
            </div>
            <?php if (isset($_SESSION["error"]["message"])) : ?>
              <div class="">
                <div class="text-danger text-center">
                  <?= $_SESSION["error"]["message"] ?>
                </div>
              </div>
            <?php endif;
            unset($_SESSION["error"]["message"]);
            ?>
          </div>
        </div>
      </div>


    </form>

    <script>
      $('input').on('change', function(e) {
        // console.log(this.files[0]);
        const file = this.files[0]; //將上傳檔案轉換為base64字串

        const fr = new FileReader(); //建立FileReader物件

        fr.onload = function(e) {
          $('img').attr('src', e.target.result); //讀取的结果放入圖片
        };
        $('#deletebtn').show();

        // 使用 readAsDataURL 將圖片轉成 Base64
        fr.readAsDataURL(file);
      });


      const deletebtn = document.querySelector("#deletebtn")
      const imginput = document.querySelector("#imginput")
      deletebtn.addEventListener("click", function() {
        // console.log("click");
        event.preventDefault();
        $('img').attr('src', '');

        // deletebtn.type = 'hidden';
        // 隱藏刪除按鈕
        $('#deletebtn').hide();
        imginput.value = "";

      })
    </script>



    <!-- <section>
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-6 col-md-8">

            <h1 class="text-center">新增使用者</h1>
            <div class="mb-2">
              <label for="" class="form-label">名字</label>
              <input type="text" class="form-control" id="name">
            </div>
            <div class="mb-2">
              <label for="" class="form-label">帳號</label>
              <input type="text" class="form-control" id="account">
            </div>
            <div class="mb-2">
              <label for="" class="form-label">密碼</label>
              <input type="password" class="form-control" id="password">
            </div>
            <div class="mb-2">
              <label for="" class="form-label">重新輸入密碼</label>
              <input type="password" class="form-control" id="repassword">
            </div>
            <div class="mb-2">
              <label for="" class="form-label">信箱</label>
              <input type="email" class="form-control" id="email">
            </div>
            <div class="mb-2">
              <label for="" class="form-label">生日</label>
              <input type="date" class="form-control" id="birthday">
            </div>
            <div class="mb-2">
              <label for="" class="form-label">電話號碼</label>
              <input type="text" class="form-control" id="phone">
            </div>
            <div class="mb-2">
              <label for="" class="form-label">地址</label>
              <input type="text" class="form-control" id="address">
            </div>
            <div class="mb-2">
              <label for="" class="form-label">信用卡號</label>
              <input type="text" class="form-control" id="creditcard">
            </div>
            <div class="mb-2">
              <label for="" class="form-label">圖片</label>
              <input type="file" class="form-control" id="image">
            </div>
            <div class="text-center mt-3">
            <button class="btn btn-primary" type="button" id="send">送出</button>
            </div>
          </div>
        </div>
      </div>
    </section> -->
  </main>

  <!-- 
  <script>
    const send = document.querySelector("#send"),
      name = document.querySelector("#name"),
      account = document.querySelector("#account"),
      password = document.querySelector("#password"),
      repassword = document.querySelector("#repassword"),
      email = document.querySelector("#email"),
      birthday = document.querySelector("#birthday"),
      phone = document.querySelector("#phone"),
      address = document.querySelector("#address"),
      creditcard = document.querySelector("#creditcard")
      image=document.querySelector("#image")

    send.addEventListener("click", function () {
      console.log("click");
      nameVal = name.value;
      accountVal = account.value;
      passwordVal = password.value;
      repasswordVal = repassword.value;
      emailVal = email.value;
      birthdayVal = birthday.value;
      phoneVal = phone.value;
      addressVal = address.value;
      creditcardVal = creditcard.value;
      imageVal=image.val



      $.ajax({
        method:"POST", //or GET
        url: "../api/doRegister.php",
        dataType: "json",
        data: {
          name: nameVal,
          account: accountVal,
          password: passwordVal,
          repassword: repasswordVal,
          email: emailVal,
          birthday: birthdayVal,
          phone: phoneVal,
          address: addressVal,
          creditcard: creditcardVal,
          image:imageVal

        }
      })
        .done(function (response) {
          // console.log(response);
          if (response.status == 0) {
            alert(response.message)
            return;
          }
          console.log(response);
          alert("新增使用者: " + accountVal + "成功")

        }).fail(function (jqXHR, textStatus) {
          
          console.log("Request failed: " + textStatus);
          
          console.log("Server response: " + jqXHR.responseText);
        });

    })
  </script> -->



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