<?php 
include '../koneksi.php';
$nama  = $_POST['nama'];
$username = $_POST['username'];
$password = md5($_POST['password']);

$rand = rand();
$allowed =  array('gif','png','jpg','jpeg');
$filename = $_FILES['foto']['name'];

if($filename == ""){
	mysqli_query($koneksi, "insert into pimpinan values (NULL,'$nama','$username','$password','')");
	header("location:pimpinan.php");
}else{
	$ext = pathinfo($filename, PATHINFO_EXTENSION);

	if(!in_array($ext,$allowed) ) {
		header("location:pimpinan.php?alert=gagal");
	}else{
		move_uploaded_file($_FILES['foto']['tmp_name'], '../gambar/pimpinan/'.$rand.'_'.$filename);
		$file_gambar = $rand.'_'.$filename;
		mysqli_query($koneksi, "insert into pimpinan values (NULL,'$nama','$username','$password','$file_gambar')");
		header("location:pimpinan.php");
	}
}

