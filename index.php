<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Back - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(120deg, #f857a6 0%, #ff5858 100%);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-container {
            background: #fff;
            border-radius: 24px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.08);
            display: flex;
            overflow: hidden;
            max-width: 900px;
            width: 100%;
            min-height: 500px;
        }
        .login-left {
            background: linear-gradient(135deg, #f857a6 0%, #ff5858 100%);
            color: #fff;
            flex: 1.2;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-start;
            padding: 60px 40px;
            position: relative;
        }
        .login-left h2 {
            font-weight: 700;
            font-size: 2.5rem;
        }
        .login-left p {
            margin: 18px 0 32px 0;
            font-size: 1.1rem;
            opacity: 0.95;
        }
        .login-left .btn {
            background: #fff;
            color: #f857a6;
            border: none;
            font-weight: 600;
            padding: 12px 36px;
            border-radius: 30px;
            font-size: 1.1rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            transition: background 0.2s, color 0.2s;
        }
        .login-left .btn:hover {
            background: #f857a6;
            color: #fff;
        }
        .login-right {
            flex: 1.5;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background: #fff;
            position: relative;
            padding: 40px 30px;
        }
        .login-right img {
            max-width: 320px;
            margin-bottom: 32px;
        }
        .login-form {
            width: 100%;
            max-width: 340px;
        }
        .login-form .form-control {
            border-radius: 20px;
            padding: 12px 18px;
            font-size: 1.1rem;
        }
        .login-form .btn-primary {
            background: #f857a6;
            border: none;
            border-radius: 20px;
            font-weight: 600;
            font-size: 1.1rem;
            padding: 12px 0;
            margin-top: 10px;
        }
        .login-form .btn-primary:hover {
            background: #ff5858;
        }
        @media (max-width: 900px) {
            .login-container { flex-direction: column; min-height: 0; }
            .login-left, .login-right { flex: unset; width: 100%; min-height: 300px; }
            .login-left { align-items: center; text-align: center; }
        }
    </style>
</head>
<body>
<div class="login-container">
    <div class="login-left">
        <div style="font-size:1.5rem; font-weight:600; margin-bottom:24px;">
            KasFlow
        </div>
        <h2>Welcome Back</h2>
        <p>To keep connected with us please<br>login with your personal info</p>
    </div>
    <div class="login-right" id="loginform">
        <img src="gambar/sistem/ut.png" alt="Login Illustration" style="max-width: 150px; max-height: 150px;">
        <?php
        if(isset($_GET['alert'])){
            if($_GET['alert'] == "gagal"){
                echo "<div class='alert alert-danger text-center'>Username atau Password <b>Salah!</b></div>";
            }else if($_GET['alert'] == "belum_login"){
                echo "<div class='alert alert-warning text-center'>Anda <b>Belum Login!</b></div>";
            }else if($_GET['alert'] == "logout"){
                echo "<div class='alert alert-success text-center'>Anda <b>Berhasil Logout!</b></div>";
            }
        }
        ?>
        <form class="login-form" action="periksa_login.php" method="POST">
            <div class="mb-3">
                <input type="text" name="username" class="form-control" placeholder="Username" required autofocus>
            </div>
            <div class="mb-3">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">LOGIN</button>
          </form>
    </div>
</div>
</body>
</html>