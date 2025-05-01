<?php
session_start();
if(
  $_SESSION['status'] != "administrator_logedin" &&
  $_SESSION['status'] != "manajemen_logedin"
){
    header("location:../index.php?alert=belum_login");
}
include '../koneksi.php';

// Tambah Hutang
if(isset($_POST['tambah'])){
    $tanggal = $_POST['tanggal'];
    $nama = $_POST['nama'];
    $jumlah = $_POST['jumlah'];
    $keterangan = $_POST['keterangan'];
    $status = $_POST['status'];

    $query = mysqli_query($koneksi, "INSERT INTO hutang (tanggal, nama, jumlah, keterangan, status) 
                                    VALUES ('$tanggal', '$nama', '$jumlah', '$keterangan', '$status')");
    
    if($query){
        header("location:hutang.php?alert=berhasil");
    }else{
        header("location:hutang.php?alert=gagal");
    }
}

// Edit Hutang
if(isset($_POST['edit'])){
    $id = $_POST['hutang_id'];
    $tanggal = $_POST['tanggal'];
    $nama = $_POST['nama'];
    $jumlah = $_POST['jumlah'];
    $keterangan = $_POST['keterangan'];
    $status = $_POST['status'];

    $query = mysqli_query($koneksi, "UPDATE hutang SET 
                                    tanggal = '$tanggal',
                                    nama = '$nama',
                                    jumlah = '$jumlah',
                                    keterangan = '$keterangan',
                                    status = '$status'
                                    WHERE id = '$id'");
    
    if($query){
        header("location:hutang.php?alert=berhasil");
    }else{
        header("location:hutang.php?alert=gagal");
    }
}

// Hapus Hutang
if(isset($_GET['hapus'])){
    $id = $_GET['hapus'];
    
    $query = mysqli_query($koneksi, "DELETE FROM hutang WHERE id = '$id'");
    
    if($query){
        header("location:hutang.php?alert=berhasil");
    }else{
        header("location:hutang.php?alert=gagal");
    }
}
?> 