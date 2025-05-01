<?php
session_start();
if($_SESSION['status'] != "administrator_logedin"){
    header("location:../index.php?alert=belum_login");
}
include '../koneksi.php';

// Tambah Rekening
if(isset($_POST['tambah'])){
    $nama = $_POST['rekening_nama'];
    $nomor = $_POST['rekening_nomor'];
    $saldo = $_POST['rekening_saldo'];

    $query = mysqli_query($koneksi, "INSERT INTO rekening (nama, nomor, saldo) VALUES ('$nama', '$nomor', '$saldo')");
    
    if($query){
        header("location:rekening.php?alert=berhasil");
    }else{
        header("location:rekening.php?alert=gagal");
    }
}

// Edit Rekening
if(isset($_POST['edit'])){
    $id = $_POST['rekening_id'];
    $nama = $_POST['rekening_nama'];
    $nomor = $_POST['rekening_nomor'];
    $saldo = $_POST['rekening_saldo'];

    $query = mysqli_query($koneksi, "UPDATE rekening SET 
                                    nama = '$nama',
                                    nomor = '$nomor',
                                    saldo = '$saldo'
                                    WHERE id = '$id'");
    
    if($query){
        header("location:rekening.php?alert=berhasil");
    }else{
        header("location:rekening.php?alert=gagal");
    }
}

// Hapus Rekening
if(isset($_GET['hapus'])){
    $id = $_GET['hapus'];
    
    $query = mysqli_query($koneksi, "DELETE FROM rekening WHERE id = '$id'");
    
    if($query){
        header("location:rekening.php?alert=berhasil");
    }else{
        header("location:rekening.php?alert=gagal");
    }
}
?> 