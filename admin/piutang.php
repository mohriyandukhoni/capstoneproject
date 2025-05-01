<?php
session_start();
if($_SESSION['status'] != "administrator_logedin"){
    header("location:../index.php?alert=belum_login");
}
include '../koneksi.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catatan Piutang - KasFlow</title>
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
            <a href="piutang.php" class="active"><i class="fa fa-list me-2"></i> Catatan Piutang</a>
            <a href="laporan.php"><i class="fa fa-file-lines me-2"></i> Laporan</a>
            <a href="kategori.php"><i class="fa fa-tags me-2"></i> Kategori</a>
            <a href="rekening.php"><i class="fa fa-wallet me-2"></i> Rekening</a>
            <a href="pengguna.php"><i class="fa fa-users me-2"></i> Pengguna</a>
            <a href="gantipassword.php"><i class="fa fa-key me-2"></i> Ganti Password</a>
            <a href="../logout.php"><i class="fa fa-sign-out me-2"></i> Logout</a>
        </nav>
        <!-- Content -->
        <main class="col-md-10 ms-sm-auto content">
            <div class="table-container mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="mb-0">Catatan Piutang</h4>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah"><i class="fa fa-plus"></i> Tambah Piutang</button>
                </div>
                <?php if(isset($_GET['alert']) && $_GET['alert'] == 'berhasil'): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        Data berhasil disimpan!
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php elseif(isset($_GET['alert']) && $_GET['alert'] == 'gagal'): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        Data gagal disimpan!
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
                <table id="tabelPiutang" class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Nama</th>
                            <th>Jumlah</th>
                            <th>Keterangan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $query = mysqli_query($koneksi, "SELECT * FROM piutang ORDER BY id DESC");
                        while($data = mysqli_fetch_assoc($query)):
                        ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= htmlspecialchars($data['tanggal']) ?></td>
                            <td><?= htmlspecialchars($data['nama']) ?></td>
                            <td>Rp <?= number_format($data['jumlah'],0,',','.') ?></td>
                            <td><?= htmlspecialchars($data['keterangan']) ?></td>
                            <td><span class="badge bg-<?= $data['status']=='lunas'?'success':'warning' ?>">
                                <?= $data['status']=='lunas' ? 'Lunas' : 'Belum Lunas' ?>
                            </span></td>
                            <td>
                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $data['id'] ?>" title="Edit"><i class="fa fa-edit"></i></button>
                                <a href="piutang_aksi.php?hapus=<?= $data['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')" title="Hapus"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                        <!-- Modal Edit -->
                        <div class="modal fade" id="modalEdit<?= $data['id'] ?>" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Piutang</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form action="piutang_aksi.php" method="POST">
                                        <div class="modal-body">
                                            <input type="hidden" name="piutang_id" value="<?= $data['id'] ?>">
                                            <div class="mb-3">
                                                <label class="form-label">Tanggal</label>
                                                <input type="date" class="form-control" name="tanggal" value="<?= $data['tanggal'] ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Nama</label>
                                                <input type="text" class="form-control" name="nama" value="<?= htmlspecialchars($data['nama']) ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Jumlah</label>
                                                <input type="number" class="form-control" name="jumlah" value="<?= $data['jumlah'] ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Keterangan</label>
                                                <input type="text" class="form-control" name="keterangan" value="<?= htmlspecialchars($data['keterangan']) ?>">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Status</label>
                                                <select name="status" class="form-control" required>
                                                    <option value="belum" <?= $data['status']=='belum'?'selected':'' ?>>Belum</option>
                                                    <option value="lunas" <?= $data['status']=='lunas'?'selected':'' ?>>Lunas</option>
                                                </select>
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
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
            <!-- Modal Tambah -->
            <div class="modal fade" id="modalTambah" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Tambah Piutang</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <form action="piutang_aksi.php" method="POST">
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label">Tanggal</label>
                                    <input type="date" class="form-control" name="tanggal" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Nama</label>
                                    <input type="text" class="form-control" name="nama" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Jumlah</label>
                                    <input type="number" class="form-control" name="jumlah" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Keterangan</label>
                                    <input type="text" class="form-control" name="keterangan">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Status</label>
                                    <select name="status" class="form-control" required>
                                        <option value="belum">Belum</option>
                                        <option value="lunas">Lunas</option>
                                    </select>
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
        </main>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script src="../assets/bower_components/jquery/dist/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('#tabelPiutang').DataTable();
    });
</script>
</body>
</html> 