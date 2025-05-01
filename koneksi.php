<?php
// Mengambil konfigurasi dari variabel lingkungan Railway
$host = 'trolley.proxy.rlwy.net';  // Using public MySQL URL
$username = 'root';
$password = 'TLCvoPIjxDIkKjJcgdaMDyNKyqPakrkD';
$database = 'railway';
$port = '15149';

// Buat koneksi
$conn = mysqli_connect($host, $username, $password, $database, $port);

// Periksa koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>