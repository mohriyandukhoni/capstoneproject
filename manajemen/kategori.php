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
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategori - KasFlow</title>
    <link rel="stylesheet" href="../assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/bower_components/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="../assets/dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="../assets/plugins/datatables/dataTables.bootstrap.css">
</head>
<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <header class="main-header">
            <a href="index.php" class="logo">
                <span class="logo-mini"><b>SKU</b></span>
                <span class="logo-lg"><b>Keuangan</b></span>
            </a>
            <nav class="navbar navbar-static-top">
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <img src="../gambar/sistem/user.png" class="user-image">
                                <span class="hidden-xs">Administrator</span>
                            </a>
                        </li>
                        <li>
                            <a href="../logout.php"><i class="fa fa-sign-out"></i> LOGOUT</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>

        <aside class="main-sidebar">
            <section class="sidebar">
                <div class="user-panel">
                    <div class="pull-left image">
                        <img src="../gambar/sistem/user.png" class="img-circle">
                    </div>
                    <div class="pull-left info">
                        <p><?php echo $_SESSION['nama']; ?></p>
                        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                    </div>
                </div>

                <ul class="sidebar-menu" data-widget="tree">
                    <li class="header">MAIN NAVIGATION</li>
                    <li>
                        <a href="index.php">
                            <i class="fa fa-dashboard"></i> <span>DASHBOARD</span>
                        </a>
                    </li>
                    <li class="active">
                        <a href="kategori.php">
                            <i class="fa fa-folder"></i> <span>KATEGORI</span>
                        </a>
                    </li>
                    <li>
                        <a href="transaksi.php">
                            <i class="fa fa-money"></i> <span>TRANSAKSI</span>
                        </a>
                    </li>
                    <li>
                        <a href="hutang.php">
                            <i class="fa fa-list"></i> <span>HUTANG</span>
                        </a>
                    </li>
                    <li>
                        <a href="piutang.php">
                            <i class="fa fa-list"></i> <span>PIUTANG</span>
                        </a>
                    </li>
                    <li>
                        <a href="bank.php">
                            <i class="fa fa-building"></i> <span>REKENING BANK</span>
                        </a>
                    </li>
                    <li>
                        <a href="laporan.php">
                            <i class="fa fa-file"></i> <span>LAPORAN</span>
                        </a>
                    </li>
                    <li>
                        <a href="gantipassword.php">
                            <i class="fa fa-lock"></i> <span>GANTI PASSWORD</span>
                        </a>
                    </li>
                    <li>
                        <a href="logout.php">
                            <i class="fa fa-sign-out"></i> <span>LOGOUT</span>
                        </a>
                    </li>
                </ul>
            </section>
        </aside>

        <div class="content-wrapper">
            <section class="content-header">
                <h1>
                    Kategori
                    <small>Data Kategori</small>
                </h1>
            </section>

            <section class="content">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box">
                            <div class="box-header">
                                <h3 class="box-title">Data Kategori</h3>
                                <div class="pull-right">
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambahKategori">
                                        <i class="fa fa-plus"></i> Tambah Kategori
                                    </button>
                                </div>
                            </div>
                            <div class="box-body">
                                <table id="tabelKategori" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Kategori</th>
                                            <th>Jenis</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        $query = mysqli_query($koneksi, "SELECT * FROM kategori ORDER BY kategori_id DESC");
                                        while($data = mysqli_fetch_assoc($query)){
                                        ?>
                                        <tr>
                                            <td><?php echo $no++; ?></td>
                                            <td><?php echo $data['kategori_nama']; ?></td>
                                            <td><?php echo $data['kategori_jenis']; ?></td>
                                            <td>
                                                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editKategori<?php echo $data['kategori_id']; ?>">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#hapusKategori<?php echo $data['kategori_id']; ?>">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <footer class="main-footer">
            <div class="pull-right hidden-xs">
                <b>Version</b> 1.0
            </div>
            <strong>Copyright &copy; 2025</strong> - Sistem Informasi Keuangan
        </footer>
    </div>

    <!-- Modal Tambah Kategori -->
    <div class="modal fade" id="tambahKategori" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Tambah Kategori</h4>
                </div>
                <form action="kategori_aksi.php" method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama Kategori</label>
                            <input type="text" name="kategori_nama" class="form-control" placeholder="Nama Kategori" required>
                        </div>
                        <div class="form-group">
                            <label>Jenis</label>
                            <select name="kategori_jenis" class="form-control" required>
                                <option value="">Pilih Jenis</option>
                                <option value="pemasukan">Pemasukan</option>
                                <option value="pengeluaran">Pengeluaran</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                        <button type="submit" name="tambah" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="../assets/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="../assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="../assets/dist/js/adminlte.min.js"></script>
    <script src="../assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../assets/plugins/datatables/dataTables.bootstrap.min.js"></script>
    <script>
        $(function () {
            $('#tabelKategori').DataTable();
        });
    </script>
</body>
</html> 