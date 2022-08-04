<?php 
// menghubungkan dengan koneksi
include 'koneksi.php';

// menangkap data yang dikirim dari form
$username = $_POST['username'];
$password = md5($_POST['password']);
$sebagai = $_POST['sebagai'];

if($sebagai == "administrator"){

	$login = mysqli_query($koneksi, "SELECT * FROM user WHERE user_username='$username' AND user_password='$password'");
	$cek = mysqli_num_rows($login);

	if($cek > 0){
		session_start();
		$data = mysqli_fetch_assoc($login);
		$_SESSION['id'] = $data['user_id'];
		$_SESSION['nama'] = $data['user_nama'];
		$_SESSION['username'] = $data['user_username'];
		$_SESSION['status'] = "administrator_logedin";
		header("location:admin/");
	}else{
		header("location:index.php?alert=gagal");
	}

}elseif($sebagai == "kasir"){
	$login = mysqli_query($koneksi, "SELECT * FROM kasir WHERE kasir_username='$username' AND kasir_password='$password'");
	$cek = mysqli_num_rows($login);

	if($cek > 0){
		session_start();
		$data = mysqli_fetch_assoc($login);
		$_SESSION['id'] = $data['kasir_id'];
		$_SESSION['nama'] = $data['kasir_nama'];
		$_SESSION['username'] = $data['kasir_username'];
		$_SESSION['status'] = "kasir_logedin";
		header("location:kasir/");
	}else{
		header("location:index.php?alert=gagal");
	}

}elseif($sebagai == "pimpinan"){

	$login = mysqli_query($koneksi, "SELECT * FROM pimpinan WHERE pimpinan_username='$username' AND pimpinan_password='$password'");
	$cek = mysqli_num_rows($login);

	if($cek > 0){
		session_start();
		$data = mysqli_fetch_assoc($login);
		$_SESSION['id'] = $data['pimpinan_id'];
		$_SESSION['nama'] = $data['pimpinan_nama'];
		$_SESSION['username'] = $data['pimpinan_username'];
		$_SESSION['status'] = "pimpinan_logedin";
		header("location:pimpinan/");
	}else{
		header("location:index.php?alert=gagal");
	}
}
