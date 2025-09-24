# Sistem Informasi Keuangan

Aplikasi web untuk mengelola keuangan dengan fitur pencatatan transaksi, hutang, piutang, dan laporan keuangan.

## Fitur

- Dashboard dengan ringkasan informasi keuangan
- Manajemen transaksi keuangan (pemasukan & pengeluaran)
- Pencatatan hutang
- Pencatatan piutang  
- Laporan keuangan
- Manajemen kategori transaksi
- Manajemen rekening
- Manajemen pengguna
- Ganti password
- Login sistem

## Teknologi

- PHP 7.4+
- MySQL/MariaDB
- HTML5
- CSS3 
- JavaScript
- Bootstrap 4
- AdminLTE 3
- Font Awesome 5

## Instalasi

1. Clone repository ini
```bash
git clone https://github.com/mohriyandukhoni/Sistem-Informasi-Keuangan.git
```

2. Import database `keuangan.sql` ke MySQL/MariaDB

3. Sesuaikan konfigurasi database di file `koneksi.php`
```php
$host = "localhost";
$username = "root"; 
$password = "";
$database = "keuangan";
```

4. Jalankan di web server (Apache/Nginx)

5. Akses aplikasi melalui browser

## Login Default

- Username: admin
- Password: admin

## Fitur Keamanan

- Login sistem dengan session
- Password di-hash
- Validasi input
- Pencegahan SQL injection
- CSRF protection
Thu Jul 31 18:32:21 UTC 2025
Wed Sep 24 21:16:35 UTC 2025
