<?php
if (!empty($this->session->userdata('id'))) {
  header("Location: dashboard");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Engine API V3</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!--===============================================================================================-->
  <link rel="icon" type="image/png" href="images/icons/favicon.ico" />
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="asset/login/vendor/bootstrap/css/bootstrap.min.css">
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="asset/login/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="asset/login/vendor/animate/animate.css">
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="asset/login/vendor/css-hamburgers/hamburgers.min.css">
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="asset/login/vendor/select2/select2.min.css">
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="asset/login/css/util.css">
  <link rel="stylesheet" type="text/css" href="asset/login/css/main.css">
  <!--===============================================================================================-->
</head>

<body>

  <div class="limiter">
    <div class="container-login100">
      <div class="wrap-login100">
        <div class="login100-pic js-tilt" data-tilt>
          <img src="asset/login/images/img-01.png" alt="IMG">
        </div>

        <form class="login100-form validate-form" method="post" action="login/login_validation">
          <span class="login100-form-title">
            Operator Login
          </span>

          <div class="wrap-input100 validate-input" data-validate="Email / Id tidak dapat ditemukan.">
            <input class="input100" type="text" name="id" placeholder="username / Email">
            <span class="focus-input100"></span>
            <span class="symbol-input100">
              <i class="fa fa-envelope" aria-hidden="true"></i>
            </span>
          </div>

          <div class="wrap-input100 validate-input" data-validate="Password Anda salah / Tidak boleh kosong.">
            <input class="input100" type="password" name="pass" placeholder="Password">
            <span class="focus-input100"></span>
            <span class="symbol-input100">
              <i class="fa fa-lock" aria-hidden="true"></i>
            </span>
          </div>
          <?= $password_info ?>
          <div class="container-login100-form-btn">
            <button class="login100-form-btn" name="btn">
              Masuk
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>




  <!--===============================================================================================-->
  <script src="asset/login/vendor/jquery/jquery-3.2.1.min.js"></script>
  <!--===============================================================================================-->
  <script src="asset/login/vendor/bootstrap/js/popper.js"></script>
  <script src="asset/login/vendor/bootstrap/js/bootstrap.min.js"></script>
  <!--===============================================================================================-->
  <script src="asset/login/vendor/select2/select2.min.js"></script>
  <!--===============================================================================================-->
  <script src="asset/login/vendor/tilt/tilt.jquery.min.js"></script>
  <script>
    $('.js-tilt').tilt({
      scale: 1.1
    })
  </script>
  <!--===============================================================================================-->
  <script src="asset/login/js/main.js"></script>

</body>

</html>