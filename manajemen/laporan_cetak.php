<?php
session_start();
if(
  $_SESSION['status'] != "administrator_logedin" &&
  $_SESSION['status'] != "manajemen_logedin"
){
    header("location:../index.php?alert=belum_login");
}
include '../koneksi.php';

$where = [];
if(isset($_GET['dari']) && $_GET['dari'] != ''){
    $where[] = "t.tanggal >= '".mysqli_real_escape_string($koneksi, $_GET['dari'])."'";
}
if(isset($_GET['sampai']) && $_GET['sampai'] != ''){
    $where[] = "t.tanggal <= '".mysqli_real_escape_string($koneksi, $_GET['sampai'])."'";
}
if(isset($_GET['jenis']) && $_GET['jenis'] != ''){
    $where[] = "t.jenis = '".mysqli_real_escape_string($koneksi, $_GET['jenis'])."'";
}
$sql = "SELECT t.*, k.nama as kategori FROM transaksi t LEFT JOIN kategori k ON t.kategori_id = k.id ".(count($where)?'WHERE '.implode(' AND ',$where):'')." ORDER BY t.tanggal DESC";
$query = mysqli_query($koneksi, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cetak Laporan Keuangan</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        h2 { text-align: center; }
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background: #f0f0f0; }
        @media print {
            button { display: none; }
        }
    </style>
</head>
<body>
    <button onclick="window.print()" style="float:right;margin-bottom:10px;">Print</button>
    <h2>Laporan Keuangan</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Kategori</th>
                <th>Keterangan</th>
                <th>Jenis</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            <?php $no=1; while($data = mysqli_fetch_assoc($query)): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= htmlspecialchars($data['tanggal']) ?></td>
                <td><?= htmlspecialchars($data['kategori']) ?></td>
                <td><?= htmlspecialchars($data['keterangan']) ?></td>
                <td><?= ucfirst($data['jenis']) ?></td>
                <td>Rp <?= number_format($data['jumlah'],0,',','.') ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html> 