<?php
session_start();
if(
  $_SESSION['status'] != "administrator_logedin" &&
  $_SESSION['status'] != "manajemen_logedin"
){
    header("location:../index.php?alert=belum_login");
}
include '../koneksi.php';

// Ambil data pemasukan dan pengeluaran per bulan
$pemasukan = array_fill(1, 12, 0);
$pengeluaran = array_fill(1, 12, 0);

$query = mysqli_query($koneksi, "SELECT MONTH(tanggal) as bulan, SUM(jumlah) as total, jenis FROM transaksi WHERE YEAR(tanggal) = YEAR(CURDATE()) GROUP BY bulan, jenis");
while($row = mysqli_fetch_assoc($query)) {
    if($row['jenis'] == 'pemasukan') {
        $pemasukan[(int)$row['bulan']] = (int)$row['total'];
    } else if($row['jenis'] == 'pengeluaran') {
        $pengeluaran[(int)$row['bulan']] = (int)$row['total'];
    }
}

// Query pemasukan & pengeluaran hari ini
$tgl_hari_ini = date('Y-m-d');
$q_pemasukan_hari_ini = mysqli_query($koneksi, "SELECT SUM(jumlah) as total FROM transaksi WHERE tanggal = '$tgl_hari_ini' AND jenis = 'pemasukan'");
$pemasukan_hari_ini = (int)mysqli_fetch_assoc($q_pemasukan_hari_ini)['total'];
$q_pengeluaran_hari_ini = mysqli_query($koneksi, "SELECT SUM(jumlah) as total FROM transaksi WHERE tanggal = '$tgl_hari_ini' AND jenis = 'pengeluaran'");
$pengeluaran_hari_ini = (int)mysqli_fetch_assoc($q_pengeluaran_hari_ini)['total'];

// Query pemasukan & pengeluaran bulan ini
$bln_ini = date('Y-m');
$q_pemasukan_bulan_ini = mysqli_query($koneksi, "SELECT SUM(jumlah) as total FROM transaksi WHERE DATE_FORMAT(tanggal, '%Y-%m') = '$bln_ini' AND jenis = 'pemasukan'");
$pemasukan_bulan_ini = (int)mysqli_fetch_assoc($q_pemasukan_bulan_ini)['total'];
$q_pengeluaran_bulan_ini = mysqli_query($koneksi, "SELECT SUM(jumlah) as total FROM transaksi WHERE DATE_FORMAT(tanggal, '%Y-%m') = '$bln_ini' AND jenis = 'pengeluaran'");
$pengeluaran_bulan_ini = (int)mysqli_fetch_assoc($q_pengeluaran_bulan_ini)['total'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - KasFlow</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background: #f4f6f9; }
        .sidebar { min-height: 100vh; background: #212529; color: #fff; }
        .sidebar a { color: #fff; text-decoration: none; padding: 12px 20px; display: block; border-radius: 6px; margin-bottom: 4px; }
        .sidebar a.active, .sidebar a:hover { background: #0d6efd; color: #fff; }
        .sidebar .sidebar-header { font-size: 1.3rem; font-weight: bold; padding: 24px 20px 12px 20px; background: #181c20; }
        .content { padding: 32px 24px; }
        .card-summary { border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.04); }
        .chart-card { background: #fff; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.04); padding: 24px; margin-bottom: 24px; }
        .calendar-container {
            background: #fff;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        }
        @media (max-width: 991px) { .sidebar { min-height: auto; } }
        @media (max-width: 767px) { .chart-card { padding: 12px; } }
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
            <a href="index.php" class="active"><i class="fa fa-home me-2"></i> Dashboard</a>
            <a href="transaksi.php"><i class="fa fa-money-bill me-2"></i> Data Transaksi</a>
            <a href="hutang.php"><i class="fa fa-list me-2"></i> Catatan Hutang</a>
            <a href="piutang.php"><i class="fa fa-list me-2"></i> Catatan Piutang</a>
            <a href="laporan.php"><i class="fa fa-file-lines me-2"></i> Laporan</a>
            <a href="gantipassword.php"><i class="fa fa-key me-2"></i> Ganti Password</a>
            <a href="../logout.php"><i class="fa fa-sign-out me-2"></i> Logout</a>
        </nav>
        <!-- Content -->
        <main class="col-md-10 ms-sm-auto content">
            <h3 class="mb-4">Dashboard Manajemen</h3>
            <div class="row mb-4">
                <div class="col-md-3 mb-3">
                    <div class="card card-summary p-3 bg-primary text-white">
                        <div class="d-flex align-items-center">
                            <div class="me-3"><i class="fa fa-arrow-down fa-2x"></i></div>
                            <div>
                                <div class="fw-bold">Pemasukan Hari Ini</div>
                                <div class="h5">Rp <?= number_format($pemasukan_hari_ini,0,',','.') ?></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card card-summary p-3 bg-success text-white">
                        <div class="d-flex align-items-center">
                            <div class="me-3"><i class="fa fa-arrow-up fa-2x"></i></div>
                            <div>
                                <div class="fw-bold">Pengeluaran Hari Ini</div>
                                <div class="h5">Rp <?= number_format($pengeluaran_hari_ini,0,',','.') ?></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card card-summary p-3 bg-info text-white">
                        <div class="d-flex align-items-center">
                            <div class="me-3"><i class="fa fa-wallet fa-2x"></i></div>
                            <div>
                                <div class="fw-bold">Pemasukan Bulan Ini</div>
                                <div class="h5">Rp <?= number_format($pemasukan_bulan_ini,0,',','.') ?></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card card-summary p-3 bg-warning text-white">
                        <div class="d-flex align-items-center">
                            <div class="me-3"><i class="fa fa-credit-card fa-2x"></i></div>
                            <div>
                                <div class="fw-bold">Pengeluaran Bulan Ini</div>
                                <div class="h5">Rp <?= number_format($pengeluaran_bulan_ini,0,',','.') ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="chart-card mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h5 class="mb-0">Grafik Pemasukan & Pengeluaran (Bulan Ini)</h5>
                            <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalFilterTanggal"><i class="fa fa-calendar"></i> Pilih Tanggal</button>
                        </div>
                        <canvas id="chartKeuangan" style="min-height:240px;max-height:400px;height:320px;width:100%"></canvas>
                    </div>
                </div>
            </div>
            <!-- Modal Filter Tanggal -->
            <div class="modal fade" id="modalFilterTanggal" tabindex="-1" aria-labelledby="modalFilterTanggalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="GET" action="">
                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title" id="modalFilterTanggalLabel"><i class="fa fa-calendar"></i> Pilih Rentang Tanggal</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label">Tanggal Mulai</label>
                                    <input type="date" name="tanggal_mulai" class="form-control" value="<?= isset($_GET['tanggal_mulai']) ? $_GET['tanggal_mulai'] : '' ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Tanggal Akhir</label>
                                    <input type="date" name="tanggal_akhir" class="form-control" value="<?= isset($_GET['tanggal_akhir']) ? $_GET['tanggal_akhir'] : '' ?>">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Terapkan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script src="../assets/bower_components/jquery/dist/jquery.min.js"></script>
<script src="../assets/plugins/datepicker/bootstrap-datepicker.js"></script>
<script>
    $(function(){
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true
        });
    });
    const pemasukanData = <?= json_encode(array_values($pemasukan)) ?>;
    const pengeluaranData = <?= json_encode(array_values($pengeluaran)) ?>;
    const ctx = document.getElementById('chartKeuangan').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
            datasets: [
                { label: 'Pemasukan', backgroundColor: '#198754', data: pemasukanData },
                { label: 'Pengeluaran', backgroundColor: '#dc3545', data: pengeluaranData }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { position: 'top' } },
            scales: {
                y: { beginAtZero: true, ticks: { callback: function(value) { return 'Rp ' + value.toLocaleString('id-ID'); } } }
            }
        }
    });
</script>
</body>
</html> 