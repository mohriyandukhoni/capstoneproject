<?php 
session_start();
include 'koneksi.php';

$username = mysqli_real_escape_string($koneksi, $_POST['username']);
$password = mysqli_real_escape_string($koneksi, $_POST['password']);

// DEBUG: tampilkan input dan query (bisa dihapus jika tidak perlu)
// echo "<pre>";
// echo "Username: $username\n";
// echo "Password: $password\n";
// $sql = "SELECT * FROM user WHERE user_username='$username' AND user_password='$password'";
// echo "SQL: $sql\n";
$sql = "SELECT * FROM user WHERE user_username='$username' AND user_password='$password'";
$query = mysqli_query($koneksi, $sql);
// if (!$query) {
//     echo "Query error: ".mysqli_error($koneksi)."\n";
// }
$num_rows = mysqli_num_rows($query);
// echo "Rows found: $num_rows\n";
$data = mysqli_fetch_assoc($query);
// echo "Data: ";
// print_r($data);
// echo "</pre>";

if($num_rows > 0){
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
