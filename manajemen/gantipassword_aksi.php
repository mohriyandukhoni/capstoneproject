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
    $query = mysqli_query($koneksi, "SELECT * FROM user WHERE username='$username' AND password='$password_lama'");
    $data = mysqli_fetch_assoc($query);

    if(mysqli_num_rows($query) > 0){
        if($password_baru == $konfirmasi_password){
            $query = mysqli_query($koneksi, "UPDATE user SET password='$password_baru' WHERE username='$username'");
            
            if($query){
                header("location:gantipassword.php?alert=berhasil");
            }else{
                header("location:gantipassword.php?alert=gagal");
            }
        }else{
            header("location:gantipassword.php?alert=gagal");
        }
    }else{
        header("location:gantipassword.php?alert=gagal");
    }
}
?> 