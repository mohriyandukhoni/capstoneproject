<?php
session_start();
if(
  $_SESSION['status'] != "administrator_logedin" &&
  $_SESSION['status'] != "manajemen_logedin"
){
    header("location:../index.php?alert=belum_login");
}
include '../koneksi.php';

// Tambah Transaksi
if(isset($_POST['tambah'])){
    $tanggal = $_POST['tanggal'];
    $kategori = $_POST['kategori_id'];
    $rekening = $_POST['rekening_id'];
    $jumlah = $_POST['jumlah'];
    $keterangan = $_POST['keterangan'];
    $jenis = $_POST['jenis'];

    $query = mysqli_query($koneksi, "INSERT INTO transaksi (tanggal, kategori_id, rekening_id, jumlah, keterangan, jenis) 
                                    VALUES ('$tanggal', '$kategori', '$rekening', '$jumlah', '$keterangan', '$jenis')");
    
    if($query){
        // Update saldo rekening
        if($jenis == "pemasukan"){
            mysqli_query($koneksi, "UPDATE rekening SET saldo = saldo + $jumlah WHERE id = '$rekening'");
        }else{
            mysqli_query($koneksi, "UPDATE rekening SET saldo = saldo - $jumlah WHERE id = '$rekening'");
        }
        header("location:transaksi.php?alert=berhasil");
    }else{
        header("location:transaksi.php?alert=gagal");
    }
}

// Edit Transaksi
if(isset($_POST['edit'])){
    $id = $_POST['transaksi_id'];
    $tanggal = $_POST['tanggal'];
    $kategori = $_POST['kategori_id'];
    $rekening = $_POST['rekening_id'];
    $jumlah = $_POST['jumlah'];
    $keterangan = $_POST['keterangan'];
    $jenis = $_POST['jenis'];

    // Ambil data transaksi lama
    $query_lama = mysqli_query($koneksi, "SELECT * FROM transaksi WHERE id = '$id'");
    $data_lama = mysqli_fetch_assoc($query_lama);

    // Update saldo rekening lama
    if($data_lama['jenis'] == "pemasukan"){
        mysqli_query($koneksi, "UPDATE rekening SET saldo = saldo - {$data_lama['jumlah']} WHERE id = '{$data_lama['rekening_id']}'");
    }else{
        mysqli_query($koneksi, "UPDATE rekening SET saldo = saldo + {$data_lama['jumlah']} WHERE id = '{$data_lama['rekening_id']}'");
    }

    // Update transaksi
    $query = mysqli_query($koneksi, "UPDATE transaksi SET 
                                    tanggal = '$tanggal',
                                    kategori_id = '$kategori',
                                    rekening_id = '$rekening',
                                    jumlah = '$jumlah',
                                    keterangan = '$keterangan',
                                    jenis = '$jenis'
                                    WHERE id = '$id'");
    
    if($query){
        // Update saldo rekening baru
        if($jenis == "pemasukan"){
            mysqli_query($koneksi, "UPDATE rekening SET saldo = saldo + $jumlah WHERE id = '$rekening'");
        }else{
            mysqli_query($koneksi, "UPDATE rekening SET saldo = saldo - $jumlah WHERE id = '$rekening'");
        }
        header("location:transaksi.php?alert=berhasil");
    }else{
        header("location:transaksi.php?alert=gagal");
    }
}

// Hapus Transaksi
if(isset($_GET['hapus'])){
    $id = $_GET['hapus'];
    
    // Ambil data transaksi
    $query = mysqli_query($koneksi, "SELECT * FROM transaksi WHERE id = '$id'");
    $data = mysqli_fetch_assoc($query);
    
    // Update saldo rekening
    if($data['jenis'] == "pemasukan"){
        mysqli_query($koneksi, "UPDATE rekening SET saldo = saldo - {$data['jumlah']} WHERE id = '{$data['rekening_id']}'");
    }else{
        mysqli_query($koneksi, "UPDATE rekening SET saldo = saldo + {$data['jumlah']} WHERE id = '{$data['rekening_id']}'");
    }
    
    // Hapus transaksi
    $query = mysqli_query($koneksi, "DELETE FROM transaksi WHERE id = '$id'");
    
    if($query){
        header("location:transaksi.php?alert=berhasil");
    }else{
        header("location:transaksi.php?alert=gagal");
    }
}
?> 