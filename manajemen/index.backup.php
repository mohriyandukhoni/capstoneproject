<?php
session_start();
if(
  $_SESSION['status'] != "administrator_logedin" &&
  $_SESSION['status'] != "manajemen_logedin"
){
    header("location:../index.php?alert=belum_login");
}
$nama = isset($_SESSION['nama']) ? $_SESSION['nama'] : 'Nama';
$level = isset($_SESSION['level']) ? $_SESSION['level'] : 'CFO';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Sistem Keuangan Manajemen Perusahaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background: #f5f7fb; }
        .sidebar {
            min-height: 100vh;
            background: #f3f5fa;
            padding: 0 0 0 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .sidebar .logo {
            width: 90px; height: 90px; border-radius: 50%; background: #d1d5db; margin: 32px 0 16px 0; display: flex; align-items: center; justify-content: center; overflow: hidden;
        }
        .sidebar .logo img { width: 100%; height: 100%; object-fit: cover; }
        .sidebar .menu { width: 100%; margin-top: 16px; }
        .sidebar .menu a {
            display: flex; align-items: center; gap: 16px;
            padding: 12px 32px; color: #222; text-decoration: none; font-size: 1.1rem; border-radius: 12px; margin-bottom: 8px; transition: background 0.2s;
        }
        .sidebar .menu a.active, .sidebar .menu a:hover { background: #e6eaff; color: #2d3a5a; }
        .sidebar .menu i { font-size: 1.3rem; }
        .sidebar .user-info {
            margin-top: auto; margin-bottom: 32px; text-align: center;
        }
        .sidebar .user-info img { width: 48px; height: 48px; border-radius: 50%; object-fit: cover; margin-bottom: 8px; }
        .sidebar .user-info .name { font-weight: 600; }
        .sidebar .user-info .level { font-size: 0.95rem; color: #888; }
        .sidebar .user-info .logout { margin-top: 8px; display: inline-block; color: #888; }
        .main-content { padding: 40px 40px 24px 40px; }
        .dashboard-title { font-size: 2rem; font-weight: 700; color: #2d3a5a; }
        .dashboard-greeting { font-size: 1.2rem; margin: 18px 0 32px 0; color: #444; }
        .info-cards { display: flex; gap: 24px; margin-bottom: 32px; flex-wrap: wrap; }
        .info-card { background: #fff; border-radius: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.04); padding: 32px 28px; flex: 1 1 220px; min-width: 220px; text-align: center; }
        .info-card .label { color: #888; font-size: 1.1rem; margin-bottom: 8px; }
        .info-card .value { font-size: 2rem; font-weight: 700; color: #2d3a5a; }
        .dashboard-row { display: flex; gap: 24px; flex-wrap: wrap; }
        .dashboard-card { background: #fff; border-radius: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.04); padding: 28px 24px; flex: 1 1 340px; min-width: 340px; }
        .dashboard-card h5 { font-size: 1.1rem; font-weight: 600; margin-bottom: 18px; }
        .budget-list { margin-top: 18px; }
        .budget-list li { margin-bottom: 6px; font-size: 1rem; }
        @media (max-width: 1100px) {
            .main-content { padding: 24px 8px; }
            .info-cards, .dashboard-row { flex-direction: column; gap: 18px; }
        }
        @media (max-width: 900px) {
            .container-fluid { flex-direction: column !important; }
            .sidebar { flex-direction: row; min-height: unset; height: auto; }
            .sidebar .menu { flex-direction: row; display: flex; gap: 8px; overflow-x: auto; }
            .sidebar .user-info { margin: 0 0 0 16px; }
        }
    </style>
</head>
<body>
<div class="container-fluid d-flex p-0">
    <aside class="sidebar col-md-2 p-0">
        <div class="logo">
            <img src="../gambar/sistem/ut.png" alt="Logo">
        </div>
        <div class="menu">
            <a href="index.php" class="active"><i class="fa fa-th-large"></i> Dashboard</a>
            <a href="transaksi.php"><i class="fa fa-wallet"></i> Manajemen Kas</a>
            <a href="investasi.php"><i class="fa fa-chart-line"></i> Manajemen Investasi</a>
            <a href="penganggaran.php"><i class="fa fa-calculator"></i> Penganggaran Modal</a>
            <a href="perencanaan.php"><i class="fa fa-file-invoice-dollar"></i> Perencanaan Keuangan</a>
            <a href="pengaturan.php"><i class="fa fa-cog"></i> Pengaturan</a>
        </div>
        <div class="user-info">
            <img src="../gambar/sistem/ut.png" alt="User">
            <div class="name"><?= htmlspecialchars($nama) ?></div>
            <div class="level"><?= htmlspecialchars($level) ?></div>
            <a href="../logout.php" class="logout" title="Logout"><i class="fa fa-sign-out-alt"></i></a>
        </div>
    </aside>
    <main class="main-content col-md-10">
        <div class="dashboard-title">Dashboard Sistem Keuangan Manajemen Perusahaan</div>
        <div class="dashboard-greeting">Halo, <?= htmlspecialchars($nama) ?>!</div>
        <div class="info-cards">
            <div class="info-card">
                <div class="label">Saldo Kas</div>
                <div class="value">Rp888.888.888,00</div>
            </div>
            <div class="info-card">
                <div class="label">Jumlah Aset</div>
                <div class="value">122</div>
            </div>
            <div class="info-card">
                <div class="label">Nilai Aset</div>
                <div class="value">Rp888.888.888,00</div>
            </div>
        </div>
        <div class="dashboard-row">
            <div class="dashboard-card">
                <h5>Return of Investment</h5>
                <canvas id="roiChart" height="120"></canvas>
            </div>
            <div class="dashboard-card">
                <h5>Anggaran Belanja</h5>
                <canvas id="budgetChart" height="120"></canvas>
                <ul class="budget-list">
                    <li><span style="color:#2d3a5a;">●</span> Departemen Manufaktur</li>
                    <li><span style="color:#2d3a5a;">●</span> Departemen Pemasaran</li>
                    <li><span style="color:#2d3a5a;">●</span> Departemen SDM</li>
                    <li><span style="color:#b0b6c3;">●</span> Departemen Akuntansi</li>
                    <li><span style="color:#e0e3ea;">●</span> Departemen Keuangan</li>
                </ul>
            </div>
        </div>
    </main>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// ROI Chart
const ctx = document.getElementById('roiChart').getContext('2d');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['Jan 2023', 'Feb 2023', 'Mar 2023', 'Apr 2023', 'Mei 2023', 'Jun 2023'],
        datasets: [
            {
                label: 'Kumulatif',
                data: [400, 420, 380, 500, 470, 430],
                borderColor: '#ff5858',
                backgroundColor: 'rgba(255,88,88,0.08)',
                tension: 0.4,
                fill: false,
            },
            {
                label: 'Pendapatan Setelah Pajak',
                data: [220, 250, 210, 320, 300, 210],
                borderColor: '#6c63ff',
                backgroundColor: 'rgba(108,99,255,0.08)',
                tension: 0.4,
                fill: false,
            }
        ]
    },
    options: {
        plugins: { legend: { display: true } },
        scales: { y: { beginAtZero: true } }
    }
});
// Budget Chart (Ring)
const ctx2 = document.getElementById('budgetChart').getContext('2d');
new Chart(ctx2, {
    type: 'doughnut',
    data: {
        labels: ['Manufaktur', 'Pemasaran', 'SDM', 'Akuntansi', 'Keuangan'],
        datasets: [{
            data: [30, 25, 20, 15, 10],
            backgroundColor: [
                '#2d3a5a', '#6c63ff', '#ff5858', '#b0b6c3', '#e0e3ea'
            ],
            borderWidth: 6,
            cutout: '70%',
        }]
    },
    options: {
        plugins: { legend: { display: false } },
        cutout: '70%',
    }
});
</script>
</body>
</html> 