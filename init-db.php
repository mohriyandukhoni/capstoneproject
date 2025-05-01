<?php
// Import file koneksi
require_once 'app/config/koneksi.php';

// Lokasi file SQL (sesuaikan dengan struktur repository)
$sql_file = file_get_contents('database/kasflow.sql');

if (!$sql_file) {
    die("File SQL tidak ditemukan.");
}

// Pisahkan query berdasarkan delimiter
$queries = explode(';', $sql_file);

$success = true;
$error_messages = [];

// Jalankan setiap query
foreach ($queries as $query) {
    $query = trim($query);
    if (!empty($query)) {
        $result = mysqli_query($conn, $query);
        if (!$result) {
            $success = false;
            $error_messages[] = "Error executing query: " . mysqli_error($conn) . "\nQuery: " . $query;
        }
    }
}

// Tampilkan hasil
if ($success) {
    echo "Database initialized successfully!";
} else {
    echo "Error initializing database:<br>";
    echo implode("<br>", $error_messages);
}

mysqli_close($conn);
?>