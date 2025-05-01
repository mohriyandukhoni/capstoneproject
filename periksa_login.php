<?php 
session_start();
include 'koneksi.php';

$username = mysqli_real_escape_string($koneksi, $_POST['username']);
$password = $_POST['password']; // Don't escape password before hashing

// DEBUG: tampilkan input dan query (bisa dihapus jika tidak perlu)
// echo "<pre>";
// echo "Username: $username\n";
// echo "Password: $password\n";
// $sql = "SELECT * FROM user WHERE user_username='$username' AND user_password='$password'";
// echo "SQL: $sql\n";
$sql = "SELECT * FROM user WHERE user_username='$username'";
$query = mysqli_query($koneksi, $sql);
// if (!$query) {
//     echo "Query error: ".mysqli_error($koneksi)."\n";
// }
$data = mysqli_fetch_assoc($query);
// echo "Data: ";
// print_r($data);
// echo "</pre>";

// Verify if user exists and password matches
if($data && password_verify($password, $data['user_password'])) {
	$_SESSION['username'] = $username;
	$_SESSION['nama'] = $data['user_nama'];
	$_SESSION['level'] = $data['user_level'];

	if($data['user_level'] == "administrator"){
		$_SESSION['status'] = "administrator_logedin";
		header("location:admin/index.php");
	}else if($data['user_level'] == "manajemen"){
		$_SESSION['status'] = "manajemen_logedin";
		header("location:manajemen/index.php");
	}
}else{
	header("location:index.php?alert=gagal");
}
?>
