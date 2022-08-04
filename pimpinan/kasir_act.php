<?php 
include '../koneksi.php';
$nama  = $_POST['nama'];
$username = $_POST['username'];
$password = md5($_POST['password']);

$rand = rand();
$allowed =  array('gif','png','jpg','jpeg');
$filename = $_FILES['foto']['name'];

if($filename == ""){
	mysqli_query($koneksi, "insert into kasir values (NULL,'$nama','$username','$password','')");
	header("location:kasir.php");
}else{
	$ext = pathinfo($filename, PATHINFO_EXTENSION);

	if(!in_array($ext,$allowed) ) {
		header("location:kasir.php?alert=gagal");
	}else{
		move_uploaded_file($_FILES['foto']['tmp_name'], '../gambar/kasir/'.$rand.'_'.$filename);
		$file_gambar = $rand.'_'.$filename;
		mysqli_query($koneksi, "insert into kasir values (NULL,'$nama','$username','$password','$file_gambar')");
		header("location:kasir.php");
	}
}

