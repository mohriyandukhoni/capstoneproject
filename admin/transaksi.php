<?php
session_start();
if($_SESSION['status'] != "administrator_logedin"){
    header("location:../index.php?alert=belum_login");
}
include '../koneksi.php';

// Set page title and active menu
$page_title = "Data Transaksi";
$active_page = "transaksi";

include '../template/header.php';
?>

<div class="table-container mb-4">
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
        <h4 class="mb-0">Data Transaksi</h4>
        <div class="d-flex gap-2">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">
                <i class="fa fa-plus"></i> Tambah
            </button>
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalFilter">
                <i class="fa fa-filter"></i> Filter
            </button>
        </div>
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

    <div class="table-responsive">
        <table id="tabelTransaksi" class="table table-striped dt-responsive nowrap" style="width:100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Kategori</th>
                    <th>Keterangan</th>
                    <th>Jenis</th>
                    <th>Nominal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                $query = mysqli_query($koneksi, "SELECT * FROM transaksi,kategori WHERE kategori_id=transaksi_kategori ORDER BY transaksi_id DESC");
                while($data = mysqli_fetch_assoc($query)):
                ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= date('d/m/Y', strtotime($data['transaksi_tanggal'])) ?></td>
                    <td><?= htmlspecialchars($data['kategori_nama']) ?></td>
                    <td><?= htmlspecialchars($data['transaksi_keterangan']) ?></td>
                    <td>
                        <span class="badge bg-<?= $data['transaksi_jenis']=='Pemasukan'?'success':'danger' ?>">
                            <?= $data['transaksi_jenis'] ?>
                        </span>
                    </td>
                    <td>Rp. <?= number_format($data['transaksi_nominal']) ?></td>
                    <td class="btn-action-group">
                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $data['transaksi_id'] ?>" title="Edit">
                            <i class="fa fa-edit"></i>
                        </button>
                        <a href="transaksi_aksi.php?hapus=<?= $data['transaksi_id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')" title="Hapus">
                            <i class="fa fa-trash"></i>
                        </a>
                    </td>
                </tr>

                <!-- Modal Edit -->
                <div class="modal fade" id="modalEdit<?= $data['transaksi_id'] ?>" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Transaksi</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <form action="transaksi_aksi.php" method="POST">
                                <div class="modal-body">
                                    <input type="hidden" name="id" value="<?= $data['transaksi_id'] ?>">
                                    <div class="mb-3">
                                        <label class="form-label">Tanggal</label>
                                        <input type="date" class="form-control" name="tanggal" value="<?= $data['transaksi_tanggal'] ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Jenis</label>
                                        <select class="form-control" name="jenis" required>
                                            <option value="Pemasukan" <?= $data['transaksi_jenis']=='Pemasukan'?'selected':'' ?>>Pemasukan</option>
                                            <option value="Pengeluaran" <?= $data['transaksi_jenis']=='Pengeluaran'?'selected':'' ?>>Pengeluaran</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Kategori</label>
                                        <select class="form-control" name="kategori" required>
                                            <?php
                                            $kategori = mysqli_query($koneksi, "SELECT * FROM kategori ORDER BY kategori_nama ASC");
                                            while($k = mysqli_fetch_array($kategori)){
                                            ?>
                                            <option value="<?= $k['kategori_id'] ?>" <?= $k['kategori_id']==$data['transaksi_kategori']?'selected':'' ?>><?= $k['kategori_nama'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Nominal</label>
                                        <input type="number" class="form-control" name="nominal" value="<?= $data['transaksi_nominal'] ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Keterangan</label>
                                        <textarea class="form-control" name="keterangan" rows="3" required><?= htmlspecialchars($data['transaksi_keterangan']) ?></textarea>
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
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Transaksi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="transaksi_aksi.php" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Tanggal</label>
                        <input type="date" class="form-control" name="tanggal" value="<?= date('Y-m-d') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jenis</label>
                        <select class="form-control" name="jenis" required>
                            <option value="Pemasukan">Pemasukan</option>
                            <option value="Pengeluaran">Pengeluaran</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <select class="form-control" name="kategori" required>
                            <?php
                            $kategori = mysqli_query($koneksi, "SELECT * FROM kategori ORDER BY kategori_nama ASC");
                            while($k = mysqli_fetch_array($kategori)){
                            ?>
                            <option value="<?= $k['kategori_id'] ?>"><?= $k['kategori_nama'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nominal</label>
                        <input type="number" class="form-control" name="nominal" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Keterangan</label>
                        <textarea class="form-control" name="keterangan" rows="3" required></textarea>
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

<!-- Modal Filter -->
<div class="modal fade" id="modalFilter" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Filter Transaksi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="" method="GET">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Tanggal Awal</label>
                        <input type="date" class="form-control" name="tanggal_awal" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Akhir</label>
                        <input type="date" class="form-control" name="tanggal_akhir" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <select class="form-control" name="kategori">
                            <option value="">Semua Kategori</option>
                            <?php
                            $kategori = mysqli_query($koneksi, "SELECT * FROM kategori ORDER BY kategori_nama ASC");
                            while($k = mysqli_fetch_array($kategori)){
                            ?>
                            <option value="<?= $k['kategori_id'] ?>"><?= $k['kategori_nama'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jenis</label>
                        <select class="form-control" name="jenis">
                            <option value="">Semua Jenis</option>
                            <option value="Pemasukan">Pemasukan</option>
                            <option value="Pengeluaran">Pengeluaran</option>
                        </select>
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

<script>
$(document).ready(function() {
    // Initialize DataTable
    initDataTable('#tabelTransaksi');
});
</script>

<?php include '../template/footer.php'; ?> 