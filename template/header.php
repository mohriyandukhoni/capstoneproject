<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page_title ?> - KasFlow</title>
    
    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css" rel="stylesheet">
    <link href="../assets/css/responsive.css" rel="stylesheet">
</head>
<body>
<button class="mobile-nav-toggle" onclick="toggleSidebar()">
    <i class="fa fa-bars"></i>
</button>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav class="col-md-2 sidebar" id="sidebar">
            <div class="sidebar-header mb-3">KasFlow</div>
            <div class="mb-3 p-2 bg-dark rounded text-white">
                <div class="fw-bold">👤 <?= htmlspecialchars($_SESSION['nama']) ?></div>
                <div><span class="badge bg-<?= $_SESSION['level']=='administrator'?'primary':'secondary' ?>"><?= ucfirst($_SESSION['level']) ?></span></div>
            </div>
            <?php if($_SESSION['level'] == 'administrator'): ?>
            <a href="index.php" class="<?= $active_page == 'dashboard' ? 'active' : '' ?>"><i class="fa fa-home me-2"></i> Dashboard</a>
            <a href="transaksi.php" class="<?= $active_page == 'transaksi' ? 'active' : '' ?>"><i class="fa fa-money-bill me-2"></i> Data Transaksi</a>
            <a href="hutang.php" class="<?= $active_page == 'hutang' ? 'active' : '' ?>"><i class="fa fa-list me-2"></i> Catatan Hutang</a>
            <a href="piutang.php" class="<?= $active_page == 'piutang' ? 'active' : '' ?>"><i class="fa fa-list me-2"></i> Catatan Piutang</a>
            <a href="laporan.php" class="<?= $active_page == 'laporan' ? 'active' : '' ?>"><i class="fa fa-file-lines me-2"></i> Laporan</a>
            <a href="kategori.php" class="<?= $active_page == 'kategori' ? 'active' : '' ?>"><i class="fa fa-tags me-2"></i> Kategori</a>
            <a href="rekening.php" class="<?= $active_page == 'rekening' ? 'active' : '' ?>"><i class="fa fa-wallet me-2"></i> Rekening</a>
            <a href="pengguna.php" class="<?= $active_page == 'pengguna' ? 'active' : '' ?>"><i class="fa fa-users me-2"></i> Pengguna</a>
            <?php else: ?>
            <a href="index.php" class="<?= $active_page == 'dashboard' ? 'active' : '' ?>"><i class="fa fa-home me-2"></i> Dashboard</a>
            <a href="transaksi.php" class="<?= $active_page == 'transaksi' ? 'active' : '' ?>"><i class="fa fa-money-bill me-2"></i> Data Transaksi</a>
            <a href="hutang.php" class="<?= $active_page == 'hutang' ? 'active' : '' ?>"><i class="fa fa-list me-2"></i> Catatan Hutang</a>
            <a href="piutang.php" class="<?= $active_page == 'piutang' ? 'active' : '' ?>"><i class="fa fa-list me-2"></i> Catatan Piutang</a>
            <a href="laporan.php" class="<?= $active_page == 'laporan' ? 'active' : '' ?>"><i class="fa fa-file-lines me-2"></i> Laporan</a>
            <?php endif; ?>
            <a href="gantipassword.php" class="<?= $active_page == 'gantipassword' ? 'active' : '' ?>"><i class="fa fa-key me-2"></i> Ganti Password</a>
            <a href="../logout.php"><i class="fa fa-sign-out me-2"></i> Logout</a>
        </nav>
        <!-- Content -->
        <main class="col-md-10 ms-sm-auto content"> 