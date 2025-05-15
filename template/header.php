<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KasFlow - Sistem Manajemen Keuangan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #f857a6;
            --secondary-color: #ff5858;
            --dark-color: #2c3e50;
            --light-color: #f8f9fa;
            --sidebar-width: 250px;
            --sidebar-collapsed-width: 70px;
        }
        
        body {
            background-color: #f5f6fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
        }
        
        .sidebar {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            min-height: 100vh;
            color: white;
            padding: 20px;
            position: fixed;
            width: var(--sidebar-width);
            transition: all 0.3s ease;
            z-index: 1000;
            left: 0;
            top: 0;
        }
        
        .sidebar.collapsed {
            width: var(--sidebar-collapsed-width);
        }
        
        .sidebar .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 12px 20px;
            border-radius: 8px;
            margin: 4px 0;
            transition: all 0.3s;
            white-space: nowrap;
            overflow: hidden;
            display: flex;
            align-items: center;
        }
        
        .sidebar .nav-link:hover {
            background: rgba(255,255,255,0.1);
            color: white;
        }
        
        .sidebar .nav-link.active {
            background: white;
            color: var(--primary-color);
        }
        
        .sidebar .nav-link i {
            width: 20px;
            text-align: center;
            margin-right: 10px;
            font-size: 1.1em;
        }
        
        .sidebar.collapsed .nav-link span {
            display: none;
        }
        
        .sidebar.collapsed .nav-link i {
            margin-right: 0;
        }
        
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 20px;
            transition: all 0.3s ease;
            min-height: 100vh;
        }
        
        .main-content.expanded {
            margin-left: var(--sidebar-collapsed-width);
        }
        
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        
        .card-header {
            background: white;
            border-bottom: 1px solid rgba(0,0,0,0.1);
            padding: 15px 20px;
            border-radius: 15px 15px 0 0 !important;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, var(--secondary-color) 0%, var(--primary-color) 100%);
        }
        
        .table {
            border-radius: 10px;
            overflow: hidden;
        }
        
        .table thead th {
            background: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
        }
        
        .sidebar-toggle {
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 1001;
            background: white;
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .sidebar-toggle:hover {
            background: #f8f9fa;
            transform: scale(1.05);
        }
        
        .sidebar-toggle i {
            transition: transform 0.3s ease;
        }
        
        .sidebar-toggle.active i {
            transform: rotate(180deg);
        }
        
        @media (max-width: 768px) {
            .sidebar {
                margin-left: calc(-1 * var(--sidebar-width));
            }
            
            .sidebar.active {
                margin-left: 0;
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .main-content.active {
                margin-left: var(--sidebar-width);
            }
            
            .sidebar-toggle {
                display: flex;
            }
        }
        
        @media (min-width: 769px) {
            .sidebar-toggle {
                display: flex;
            }
        }
    </style>
</head>
<body>
    <button class="sidebar-toggle" id="sidebarToggle">
        <i class="fas fa-bars"></i>
    </button>
    
    <div class="sidebar" id="sidebar">
        <div class="d-flex align-items-center mb-4">
            <img src="../gambar/sistem/ut.png" alt="Logo" style="width: 40px; height: 40px; margin-right: 10px;">
            <h4 class="mb-0">KasFlow</h4>
        </div>
        <nav class="nav flex-column">
            <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>" href="index.php">
                <i class="fas fa-home"></i>
                <span>Dashboard</span>
            </a>
            <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'transaksi.php' ? 'active' : ''; ?>" href="transaksi.php">
                <i class="fas fa-exchange-alt"></i>
                <span>Transaksi</span>
            </a>
            <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'kategori.php' ? 'active' : ''; ?>" href="kategori.php">
                <i class="fas fa-tags"></i>
                <span>Kategori</span>
            </a>
            <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'rekening.php' ? 'active' : ''; ?>" href="rekening.php">
                <i class="fas fa-wallet"></i>
                <span>Rekening</span>
            </a>
            <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'hutang.php' ? 'active' : ''; ?>" href="hutang.php">
                <i class="fas fa-hand-holding-usd"></i>
                <span>Hutang</span>
            </a>
            <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'piutang.php' ? 'active' : ''; ?>" href="piutang.php">
                <i class="fas fa-money-bill-wave"></i>
                <span>Piutang</span>
            </a>
            <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'laporan.php' ? 'active' : ''; ?>" href="laporan.php">
                <i class="fas fa-chart-bar"></i>
                <span>Laporan</span>
            </a>
            <?php if($_SESSION['user_level'] == 'administrator'){ ?>
            <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'pengguna.php' ? 'active' : ''; ?>" href="pengguna.php">
                <i class="fas fa-users"></i>
                <span>Pengguna</span>
            </a>
            <?php } ?>
            <a class="nav-link" href="../logout.php">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
        </nav>
    </div>
    <div class="main-content" id="mainContent">
        <div class="container-fluid"> 