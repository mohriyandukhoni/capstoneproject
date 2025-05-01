<?php
// Mengambil konfigurasi dari variabel lingkungan Railway
$host = getenv('MYSQLHOST');
$username = getenv('MYSQLUSER');
$password = getenv('MYSQLPASSWORD');
$database = getenv('MYSQLDATABASE');
$port = getenv('MYSQLPORT') ?: '3306';

// Buat koneksi
$conn = mysqli_connect($host, $username, $password, $database, $port);

// Periksa koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>