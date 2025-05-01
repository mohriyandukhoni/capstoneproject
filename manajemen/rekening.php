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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekening - KasFlow</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .sidebar {
            min-height: 100vh;
            background-color: #343a40;
        }
        .sidebar a {
            color: #fff;
            text-decoration: none;
            padding: 10px 15px;
            display: block;
        }
        .sidebar a:hover {
            background-color: #495057;
        }
        .sidebar a.active {
            background-color: #0d6efd;
        }
        .content {
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 sidebar p-0">
                <div class="d-flex flex-column">
                    <div class="p-3 text-white text-center">
                        <h4>KasFlow</h4>
                    </div>
                    <div class="mb-3 p-3 bg-dark rounded text-white text-center">
                        <div class="fw-bold">👤 <?= htmlspecialchars($_SESSION['nama']) ?></div>
                        <div><span class="badge bg-<?= $_SESSION['level']=='administrator'?'primary':'secondary' ?>"><?= ucfirst($_SESSION['level']) ?></span></div>
                    </div>
                    <a href="index.php" class="active"><i class="fas fa-home me-2"></i> Dashboard</a>
                    <a href="kategori.php"><i class="fas fa-tags me-2"></i> Kategori</a>
                    <a href="transaksi.php"><i class="fas fa-exchange-alt me-2"></i> Transaksi</a>
                    <a href="hutang.php"><i class="fas fa-hand-holding-usd me-2"></i> Hutang</a>
                    <a href="piutang.php"><i class="fas fa-money-bill-wave me-2"></i> Piutang</a>
                    <a href="rekening.php"><i class="fas fa-university me-2"></i> Rekening Bank</a>
                    <a href="laporan.php"><i class="fas fa-file-alt me-2"></i> Laporan</a>
                    <a href="ganti_password.php"><i class="fas fa-key me-2"></i> Ganti Password</a>
                    <a href="../logout.php"><i class="fas fa-sign-out-alt me-2"></i> Logout</a>
                </div>
            </div>

            <!-- Content -->
            <div class="col-md-10 content">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Data Rekening Bank</h5>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahRekening">
                            <i class="fas fa-plus"></i> Tambah Rekening
                        </button>
                    </div>
                    <div class="card-body">
                        <?php if(isset($_GET['alert'])): ?>
                            <?php if($_GET['alert'] == 'berhasil'): ?>
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    Data berhasil disimpan!
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php elseif($_GET['alert'] == 'gagal'): ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    Data gagal disimpan!
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>

                        <table id="tabelRekening" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Bank</th>
                                    <th>Nomor Rekening</th>
                                    <th>Atas Nama</th>
                                    <th>Saldo</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                $query = mysqli_query($koneksi, "SELECT * FROM rekening ORDER BY rekening_id DESC");
                                while($data = mysqli_fetch_array($query)){
                                ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo $data['rekening_nama']; ?></td>
                                    <td><?php echo $data['rekening_nomor']; ?></td>
                                    <td><?php echo $data['rekening_atas_nama']; ?></td>
                                    <td>Rp <?php echo number_format($data['rekening_saldo']); ?></td>
                                    <td>
                                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editRekening<?php echo $data['rekening_id']; ?>">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <a href="rekening_aksi.php?hapus=<?php echo $data['rekening_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>

                                <!-- Modal Edit -->
                                <div class="modal fade" id="editRekening<?php echo $data['rekening_id']; ?>" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Rekening</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form action="rekening_aksi.php" method="POST">
                                                <div class="modal-body">
                                                    <input type="hidden" name="rekening_id" value="<?php echo $data['rekening_id']; ?>">
                                                    <div class="mb-3">
                                                        <label class="form-label">Nama Bank</label>
                                                        <input type="text" class="form-control" name="rekening_nama" value="<?php echo $data['rekening_nama']; ?>" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Nomor Rekening</label>
                                                        <input type="text" class="form-control" name="rekening_nomor" value="<?php echo $data['rekening_nomor']; ?>" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Atas Nama</label>
                                                        <input type="text" class="form-control" name="rekening_atas_nama" value="<?php echo $data['rekening_atas_nama']; ?>" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Saldo</label>
                                                        <input type="number" class="form-control" name="rekening_saldo" value="<?php echo $data['rekening_saldo']; ?>" required>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" name="edit" class="btn btn-primary">Simpan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah -->
    <div class="modal fade" id="tambahRekening" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Rekening</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="rekening_aksi.php" method="POST">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama Bank</label>
                            <input type="text" class="form-control" name="rekening_nama" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nomor Rekening</label>
                            <input type="text" class="form-control" name="rekening_nomor" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Atas Nama</label>
                            <input type="text" class="form-control" name="rekening_atas_nama" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Saldo</label>
                            <input type="number" class="form-control" name="rekening_saldo" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" name="tambah" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#tabelRekening').DataTable();
        });
    </script>
</body>
</html> 