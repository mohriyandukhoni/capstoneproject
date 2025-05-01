<?php
session_start();
if(
  $_SESSION['status'] != "administrator_logedin" &&
  $_SESSION['status'] != "manajemen_logedin"
){
    header("location:../index.php?alert=belum_login");
}
include '../koneksi.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- MODERNIZED: Only Bootstrap 5, Font Awesome 6 loaded -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ganti Password - KasFlow</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background: #f4f6f9; }
        .sidebar { min-height: 100vh; background: #212529; color: #fff; }
        .sidebar a { color: #fff; text-decoration: none; padding: 12px 20px; display: block; border-radius: 6px; margin-bottom: 4px; }
        .sidebar a.active, .sidebar a:hover { background: #0d6efd; color: #fff; }
        .sidebar .sidebar-header { font-size: 1.3rem; font-weight: bold; padding: 24px 20px 12px 20px; background: #181c20; }
        .content { padding: 32px 24px; }
        .form-container { background: #fff; border-radius: 12px; padding: 32px; box-shadow: 0 2px 8px rgba(0,0,0,0.04); max-width: 500px; margin: 0 auto; }
        .modal-header { background: #0d6efd; color: #fff; }
        @media (max-width: 991px) { .sidebar { min-height: auto; } }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav class="col-md-2 d-none d-md-block sidebar">
            <div class="sidebar-header mb-3">KasFlow</div>
            <div class="mb-3 p-2 bg-dark rounded text-white">
                <div class="fw-bold">👤 <?= htmlspecialchars($_SESSION['nama']) ?></div>
                <div><span class="badge bg-<?= $_SESSION['level']=='administrator'?'primary':'secondary' ?>"><?= ucfirst($_SESSION['level']) ?></span></div>
                </div>
            <a href="index.php"><i class="fa fa-home me-2"></i> Dashboard</a>
            <a href="transaksi.php"><i class="fa fa-money-bill me-2"></i> Data Transaksi</a>
            <a href="hutang.php"><i class="fa fa-list me-2"></i> Catatan Hutang</a>
            <a href="piutang.php"><i class="fa fa-list me-2"></i> Catatan Piutang</a>
            <a href="laporan.php"><i class="fa fa-file-lines me-2"></i> Laporan</a>
            <a href="gantipassword.php" class="active"><i class="fa fa-key me-2"></i> Ganti Password</a>
            <a href="../logout.php"><i class="fa fa-sign-out me-2"></i> Logout</a>
            </nav>
        <!-- Content -->
        <main class="col-md-10 ms-sm-auto content">
            <div class="form-container mt-5">
                <h4 class="mb-4 text-center">Ganti Password</h4>
                <?php if(isset($_GET['alert']) && $_GET['alert'] == 'berhasil'): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        Password berhasil diganti!
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php elseif(isset($_GET['alert']) && $_GET['alert'] == 'gagal'): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        Password gagal diganti!
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
                                <form action="gantipassword_aksi.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Password Lama</label>
                        <input type="password" class="form-control" name="password_lama" required>
                                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password Baru</label>
                        <input type="password" class="form-control" name="password_baru" required>
                                    </div>
                    <div class="mb-3">
                        <label class="form-label">Konfirmasi Password Baru</label>
                        <input type="password" class="form-control" name="konfirmasi_password" required>
                                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" name="ganti" class="btn btn-primary">Ganti Password</button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 