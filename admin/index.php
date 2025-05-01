<?php
session_start();
if($_SESSION['status'] != "administrator_logedin"){
    header("location:../index.php?alert=belum_login");
}
include '../koneksi.php';

// Set page title and active menu
$page_title = "Dashboard";
$active_page = "dashboard";

include '../template/header.php';
?>

<div class="row">
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-2">Total Pemasukan</h6>
                        <?php 
                        $pemasukan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(transaksi_nominal) as total FROM transaksi WHERE transaksi_jenis='Pemasukan'"));
                        ?>
                        <h4 class="mb-0">Rp. <?= number_format($pemasukan['total']) ?></h4>
                    </div>
                    <div class="bg-success bg-opacity-10 rounded-circle p-3">
                        <i class="fa fa-arrow-up text-success fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-2">Total Pengeluaran</h6>
                        <?php 
                        $pengeluaran = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(transaksi_nominal) as total FROM transaksi WHERE transaksi_jenis='Pengeluaran'"));
                        ?>
                        <h4 class="mb-0">Rp. <?= number_format($pengeluaran['total']) ?></h4>
                    </div>
                    <div class="bg-danger bg-opacity-10 rounded-circle p-3">
                        <i class="fa fa-arrow-down text-danger fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-2">Total Hutang</h6>
                        <?php 
                        $hutang = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(hutang_nominal) as total FROM hutang WHERE hutang_status='0'"));
                        ?>
                        <h4 class="mb-0">Rp. <?= number_format($hutang['total']) ?></h4>
                    </div>
                    <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                        <i class="fa fa-credit-card text-warning fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-2">Total Piutang</h6>
                        <?php 
                        $piutang = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(piutang_nominal) as total FROM piutang WHERE piutang_status='0'"));
                        ?>
                        <h4 class="mb-0">Rp. <?= number_format($piutang['total']) ?></h4>
                    </div>
                    <div class="bg-info bg-opacity-10 rounded-circle p-3">
                        <i class="fa fa-money-bill text-info fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-7 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Transaksi Terakhir</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Kategori</th>
                                <th>Jenis</th>
                                <th>Nominal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $query = mysqli_query($koneksi, "SELECT * FROM transaksi,kategori WHERE kategori_id=transaksi_kategori ORDER BY transaksi_id DESC LIMIT 5");
                            while($data = mysqli_fetch_assoc($query)):
                            ?>
                            <tr>
                                <td><?= date('d/m/Y', strtotime($data['transaksi_tanggal'])) ?></td>
                                <td><?= htmlspecialchars($data['kategori_nama']) ?></td>
                                <td>
                                    <span class="badge bg-<?= $data['transaksi_jenis']=='Pemasukan'?'success':'danger' ?>">
                                        <?= $data['transaksi_jenis'] ?>
                                    </span>
                                </td>
                                <td>Rp. <?= number_format($data['transaksi_nominal']) ?></td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-5 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Hutang Jatuh Tempo</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Keterangan</th>
                                <th>Nominal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $query = mysqli_query($koneksi, "SELECT * FROM hutang WHERE hutang_status='0' AND hutang_jatuh_tempo <= CURDATE() ORDER BY hutang_jatuh_tempo ASC LIMIT 5");
                            while($data = mysqli_fetch_assoc($query)):
                            ?>
                            <tr>
                                <td><?= date('d/m/Y', strtotime($data['hutang_jatuh_tempo'])) ?></td>
                                <td><?= htmlspecialchars($data['hutang_keterangan']) ?></td>
                                <td>Rp. <?= number_format($data['hutang_nominal']) ?></td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../template/footer.php'; ?> 