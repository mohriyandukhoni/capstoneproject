<?php
session_start();
if(
  $_SESSION['status'] != "administrator_logedin" &&
  $_SESSION['status'] != "manajemen_logedin"
){
    header("location:../index.php?alert=belum_login");
}
include '../koneksi.php';

if(isset($_POST['ganti'])){
    $username = $_SESSION['username'];
    $password_lama = $_POST['password_lama'];
    $password_baru = $_POST['password_baru'];
    $konfirmasi_password = $_POST['konfirmasi_password'];

    // Cek password lama
    $query = mysqli_query($koneksi, "SELECT * FROM user WHERE user_username='$username'");
    $data = mysqli_fetch_assoc($query);

    // Verifikasi password lama
    if($data && password_verify($password_lama, $data['user_password'])){
        if($password_baru == $konfirmasi_password){
            // Hash password baru
            $password_hash = password_hash($password_baru, PASSWORD_DEFAULT);
            
            // Update password
            $query = mysqli_query($koneksi, "UPDATE user SET user_password='$password_hash' WHERE user_username='$username'");
            
            if($query){
                header("location:gantipassword.php?alert=berhasil");
            }else{
                header("location:gantipassword.php?alert=gagal");
            }
        }else{
            header("location:gantipassword.php?alert=tidakcocok");
        }
    }else{
        header("location:gantipassword.php?alert=passwordsalah");
    }
}
?> 