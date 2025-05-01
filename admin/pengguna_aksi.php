<?php
session_start();
if($_SESSION['status'] != "administrator_logedin"){
    header("location:../index.php?alert=belum_login");
}
include '../koneksi.php';

// Tambah pengguna baru
if(isset($_POST['tambah'])){
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash password
    $level = mysqli_real_escape_string($koneksi, $_POST['level']);

    // Cek username sudah ada atau belum
    $cek = mysqli_query($koneksi, "SELECT * FROM user WHERE user_username='$username'");
    if(mysqli_num_rows($cek) > 0){
        header("location:pengguna.php?alert=username_exists");
        exit();
    }

    $query = mysqli_query($koneksi, "INSERT INTO user (user_nama, user_username, user_password, user_level) 
                                    VALUES ('$nama', '$username', '$password', '$level')");
    
    if($query){
        header("location:pengguna.php?alert=berhasil");
    }else{
        header("location:pengguna.php?alert=gagal");
    }
}

// Edit pengguna
if(isset($_POST['edit'])){
    $id = mysqli_real_escape_string($koneksi, $_POST['pengguna_id']);
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $level = mysqli_real_escape_string($koneksi, $_POST['level']);
    
    // Cek username sudah ada atau belum (kecuali username sendiri)
    $cek = mysqli_query($koneksi, "SELECT * FROM user WHERE user_username='$username' AND user_id != '$id'");
    if(mysqli_num_rows($cek) > 0){
        header("location:pengguna.php?alert=username_exists");
        exit();
    }

    if(!empty($_POST['password'])){
        // Jika password diisi, update dengan password baru
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $query = mysqli_query($koneksi, "UPDATE user SET 
                                        user_nama='$nama',
                                        user_username='$username',
                                        user_password='$password',
                                        user_level='$level'
                                        WHERE user_id='$id'");
    }else{
        // Jika password kosong, update tanpa password
        $query = mysqli_query($koneksi, "UPDATE user SET 
                                        user_nama='$nama',
                                        user_username='$username',
                                        user_level='$level'
                                        WHERE user_id='$id'");
    }
    
    if($query){
        header("location:pengguna.php?alert=berhasil");
    }else{
        header("location:pengguna.php?alert=gagal");
    }
}

// Hapus pengguna
if(isset($_GET['hapus'])){
    $id = mysqli_real_escape_string($koneksi, $_GET['hapus']);
    
    // Cek apakah user yang akan dihapus adalah user yang sedang login
    if($id == $_SESSION['user_id']){
        header("location:pengguna.php?alert=cant_delete_self");
        exit();
    }
    
    $query = mysqli_query($koneksi, "DELETE FROM user WHERE user_id='$id'");
    
    if($query){
        header("location:pengguna.php?alert=berhasil");
    }else{
        header("location:pengguna.php?alert=gagal");
    }
}
?> 