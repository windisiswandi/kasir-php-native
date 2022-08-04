<?php 
include '../koneksi.php';
$id  = $_POST['id'];
$nama  = $_POST['nama'];
$username = $_POST['username'];
$pwd = $_POST['password'];
$password = md5($_POST['password']);

// cek gambar
$rand = rand();
$allowed =  array('gif','png','jpg','jpeg');
$filename = $_FILES['foto']['name'];
$ext = pathinfo($filename, PATHINFO_EXTENSION);

if($pwd=="" && $filename==""){
	mysqli_query($koneksi, "update kasir set kasir_nama='$nama', kasir_username='$username' where kasir_id='$id'");
	header("location:kasir.php");
}elseif($pwd==""){
	if(!in_array($ext,$allowed) ) {
		header("location:kasir.php?alert=gagal");
	}else{
		move_uploaded_file($_FILES['foto']['tmp_name'], '../gambar/kasir/'.$rand.'_'.$filename);
		$x = $rand.'_'.$filename;
		mysqli_query($koneksi, "update kasir set kasir_nama='$nama', kasir_username='$username', kasir_foto='$x' where kasir_id='$id'");		
		header("location:kasir.php?alert=berhasil");
	}
}elseif($filename==""){
	mysqli_query($koneksi, "update kasir set kasir_nama='$nama', kasir_username='$username', kasir_password='$password' where kasir_id='$id'");
	header("location:kasir.php");
}

