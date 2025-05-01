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
    <!-- MODERNIZED: Only Bootstrap 5, Font Awesome 6, DataTables Bootstrap 5 loaded -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan - KasFlow</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <style>
        body { background: #f4f6f9; }
        .sidebar { min-height: 100vh; background: #212529; color: #fff; }
        .sidebar a { color: #fff; text-decoration: none; padding: 12px 20px; display: block; border-radius: 6px; margin-bottom: 4px; }
        .sidebar a.active, .sidebar a:hover { background: #0d6efd; color: #fff; }
        .sidebar .sidebar-header { font-size: 1.3rem; font-weight: bold; padding: 24px 20px 12px 20px; background: #181c20; }
        .content { padding: 32px 24px; }
        .table-container { background: #fff; border-radius: 12px; padding: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.04); }
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
            <a href="laporan.php" class="active"><i class="fa fa-file-lines me-2"></i> Laporan</a>
            <a href="gantipassword.php"><i class="fa fa-key me-2"></i> Ganti Password</a>
            <a href="../logout.php"><i class="fa fa-sign-out me-2"></i> Logout</a>
        </nav>
        <!-- Content -->
        <main class="col-md-10 ms-sm-auto content">
            <div class="table-container mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="mb-0">Laporan Keuangan</h4>
                    <form class="d-flex gap-2" method="GET" action="">
                        <input type="date" class="form-control" name="dari" value="<?= isset($_GET['dari']) ? $_GET['dari'] : '' ?>">
                        <input type="date" class="form-control" name="sampai" value="<?= isset($_GET['sampai']) ? $_GET['sampai'] : '' ?>">
                        <select name="jenis" class="form-control">
                            <option value="">Semua Jenis</option>
                            <option value="masuk" <?= (isset($_GET['jenis']) && $_GET['jenis']=='masuk')?'selected':'' ?>>Pemasukan</option>
                            <option value="keluar" <?= (isset($_GET['jenis']) && $_GET['jenis']=='keluar')?'selected':'' ?>>Pengeluaran</option>
                        </select>
                        <button class="btn btn-primary" type="submit"><i class="fa fa-filter"></i> Filter</button>
                        <a href="laporan.php" class="btn btn-secondary"><i class="fa fa-refresh"></i></a>
                    </form>
                </div>
                <?php if(isset($_GET['alert']) && $_GET['alert'] == 'berhasil'): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        Data berhasil diekspor!
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php elseif(isset($_GET['alert']) && $_GET['alert'] == 'gagal'): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        Data gagal diekspor!
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
                <div class="mb-3">
                    <a href="laporan_aksi.php?export=excel&<?= http_build_query($_GET) ?>" class="btn btn-success"><i class="fa fa-file-excel"></i> Export Excel</a>
                    <a href="laporan_aksi.php?pdf=1&<?= http_build_query($_GET) ?>" class="btn btn-danger" target="_blank"><i class="fa fa-file-pdf"></i> Export PDF</a>
                    <a href="laporan_cetak.php?<?= http_build_query($_GET) ?>" class="btn btn-info" target="_blank"><i class="fa fa-print"></i> Cetak</a>
                </div>
                <table id="tabelLaporan" class="table table-striped">
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
                        <?php
                        $no = 1;
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
                        while($data = mysqli_fetch_assoc($query)):
                        ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= htmlspecialchars($data['tanggal']) ?></td>
                            <td><?= htmlspecialchars($data['kategori']) ?></td>
                            <td><?= htmlspecialchars($data['keterangan']) ?></td>
                            <td><span class="badge bg-<?= $data['jenis']=='masuk'?'success':'danger' ?>"><?= ucfirst($data['jenis']) ?></span></td>
                            <td>Rp <?= number_format($data['jumlah'],0,',','.') ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script src="../assets/bower_components/jquery/dist/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('#tabelLaporan').DataTable();
    });
</script>
</body>
</html> 