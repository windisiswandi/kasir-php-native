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
	mysqli_query($koneksi, "update pimpinan set pimpinan_nama='$nama', pimpinan_username='$username' where pimpinan_id='$id'");
	header("location:pimpinan.php");
}elseif($pwd==""){
	if(!in_array($ext,$allowed) ) {
		header("location:pimpinan.php?alert=gagal");
	}else{
		move_uploaded_file($_FILES['foto']['tmp_name'], '../gambar/pimpinan/'.$rand.'_'.$filename);
		$x = $rand.'_'.$filename;
		mysqli_query($koneksi, "update pimpinan set pimpinan_nama='$nama', pimpinan_username='$username', pimpinan_foto='$x' where pimpinan_id='$id'");		
		header("location:pimpinan.php?alert=berhasil");
	}
}elseif($filename==""){
	mysqli_query($koneksi, "update pimpinan set pimpinan_nama='$nama', pimpinan_username='$username', pimpinan_password='$password' where pimpinan_id='$id'");
	header("location:pimpinan.php");
}

