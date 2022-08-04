<?php 
include '../koneksi.php';
$kode  = $_POST['kode'];
$nama  = $_POST['nama'];
$satuan  = $_POST['satuan'];
$kategori = $_POST['kategori'];
$stok = $_POST['stok'];

$harga_modal = str_replace("Rp.", "", $_POST["harga_modal"]);
$harga_modal = str_replace(".", "", $harga_modal);
$harga_modal = str_replace(",00", "", $harga_modal);

$harga_jual = str_replace("Rp.", "", $_POST["harga_jual"]);
$harga_jual = str_replace(".", "", $harga_jual);
$harga_jual = str_replace(",00", "", $harga_jual);

$keterangan = $_POST['keterangan'];
$kwantitas = $_POST['kwantitas'] ? $_POST["kwantitas"] : 5;

$rand = rand();
$allowed =  array('gif','png','jpg','jpeg');
$filename = $_FILES['foto']['name'];

if($filename == ""){
	mysqli_query($koneksi, "insert into produk values (NULL,'$kode','$nama','$satuan','$kategori','$stok','$harga_modal','$harga_jual','$keterangan','', '$kwantitas')")or die(mysqli_error($koneksi));
	header("location:produk.php");
}else{
	$ext = pathinfo($filename, PATHINFO_EXTENSION);

	if(!in_array($ext,$allowed) ) {
		header("location:produk.php?alert=gagal");
	}else{
		move_uploaded_file($_FILES['foto']['tmp_name'], '../gambar/produk/'.$rand.'_'.$filename);
		$file_gambar = $rand.'_'.$filename;
		mysqli_query($koneksi, "insert into produk values (NULL,'$kode','$nama','$satuan','$kategori','$stok','$harga_modal','$harga_jual','$keterangan','$file_gambar', '$kwantitas')");
		header("location:produk.php");
	}
}

