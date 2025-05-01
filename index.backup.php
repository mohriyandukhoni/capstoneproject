<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Sistem Informasi Keuangan - Login</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/bower_components/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="assets/dist/css/AdminLTE.min.css">
  <style>
    body {
      background: #f0f2f5;
    }
    .login-box {
      margin-top: 10%;
      background: white;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 20px rgba(0,0,0,0.1);
    }
    .login-logo {
      margin-bottom: 30px;
    }
    .login-logo img {
      max-width: 150px;
    }
    .login-box-body {
      padding: 20px;
      border-radius: 5px;
    }
    .btn-primary {
      background-color: #3c8dbc;
      border-color: #367fa9;
    }
    .btn-primary:hover {
      background-color: #367fa9;
      border-color: #2e6da4;
    }
  </style>
</head>

<body>
  <div class="login-box">
    <div class="login-logo text-center">
      <img src="gambar/sistem/ut.png" alt="Logo" class="img-fluid">
      <h2><b>Manajemen Keuangan</b></h2>
    </div>
    <div class="login-box-body">
      <?php
      if(isset($_GET['alert'])){
        if($_GET['alert'] == "gagal"){
          echo "<div class='alert alert-danger text-center'>
                  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                  Username atau Password <b>Salah!</b>
                </div>";
        }else if($_GET['alert'] == "belum_login"){
          echo "<div class='alert alert-warning text-center'>
                  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                  Anda <b>Belum Login!</b>
                </div>";
        }else if($_GET['alert'] == "logout"){
          echo "<div class='alert alert-success text-center'>
                  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                  Anda <b>Berhasil Logout!</b>
                </div>";
        }
      }
      ?>
      <form action="periksa_login.php" method="POST">
        <div class="form-group has-feedback">
          <input type="text" name="username" class="form-control" placeholder="Username" required>
          <span class="glyphicon glyphicon-user form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
          <input type="password" name="password" class="form-control" placeholder="Password" required>
          <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="row">
          <div class="col-xs-12">
            <button type="submit" class="btn btn-primary btn-block btn-flat">LOGIN</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <script src="assets/bower_components/jquery/dist/jquery.min.js"></script>
  <script src="assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
</body>

</html>