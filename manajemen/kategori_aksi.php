<?php
session_start();
if(
  $_SESSION['status'] != "administrator_logedin" &&
  $_SESSION['status'] != "manajemen_logedin"
){
    header("location:../index.php?alert=belum_login");
}
include '../koneksi.php';

// Tambah Kategori
if(isset($_POST['tambah'])){
    $nama = $_POST['kategori_nama'];
    $jenis = $_POST['kategori_jenis'];
    
    $query = mysqli_query($koneksi, "INSERT INTO kategori (nama, jenis) VALUES ('$nama', '$jenis')");
    
    if($query){
        header("location:kategori.php?alert=berhasil");
    }else{
        header("location:kategori.php?alert=gagal");
    }
}

// Edit Kategori
if(isset($_POST['edit'])){
    $id = $_POST['kategori_id'];
    $nama = $_POST['kategori_nama'];
    $jenis = $_POST['kategori_jenis'];
    
    $query = mysqli_query($koneksi, "UPDATE kategori SET nama='$nama', jenis='$jenis' WHERE id='$id'");
    
    if($query){
        header("location:kategori.php?alert=berhasil");
    }else{
        header("location:kategori.php?alert=gagal");
    }
}

// Hapus Kategori
if(isset($_GET['hapus'])){
    $id = $_GET['hapus'];
    
    $query = mysqli_query($koneksi, "DELETE FROM kategori WHERE id='$id'");
    
    if($query){
        header("location:kategori.php?alert=berhasil");
    }else{
        header("location:kategori.php?alert=gagal");
    }
}
?> 