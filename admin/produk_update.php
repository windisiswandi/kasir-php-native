<?php 
include '../koneksi.php';
$id  = $_POST['id'];
$kode  = $_POST['kode'];
$nama  = $_POST['nama'];
$satuan  = $_POST['satuan'];
$kategori = $_POST['kategori'];
$stok = $_POST['stok'];
$harga_modal = $_POST['harga_modal'];
$harga_jual = $_POST['harga_jual'];
$keterangan = $_POST['keterangan'];
$kwantitas = $_POST['kwantitas'] ? $_POST["kwantitas"] : 5;

$rand = rand();
$allowed =  array('gif','png','jpg','jpeg');
$filename = $_FILES['foto']['name'];

if($filename == ""){
	mysqli_query($koneksi, "update produk set produk_nama='$nama', produk_satuan='$satuan', produk_kategori='$kategori', produk_stok='$stok', produk_harga_modal='$harga_modal', produk_harga_jual='$harga_jual', produk_keterangan='$keterangan', produk_kwantitas='$kwantitas' where produk_id='$id' ")or die(mysqli_error($koneksi));
	header("location:produk.php");
}else{
	$ext = pathinfo($filename, PATHINFO_EXTENSION);

	if(!in_array($ext,$allowed) ) {
		header("location:produk.php?alert=gagal");
	}else{
		// hapus foto lama
		$lama = mysqli_query($koneksi,"select * from produk where produk_id='$id'");
		$l = mysqli_fetch_assoc($lama);
		$foto_lama = $l['produk_foto'];
		unlink('../gambar/produk/'.$foto_lama);
		// upload foto baru
		move_uploaded_file($_FILES['foto']['tmp_name'], '../gambar/produk/'.$rand.'_'.$filename);
		$file_gambar = $rand.'_'.$filename;
		
		// update data produk
		mysqli_query($koneksi, "update produk set produk_nama='$nama', produk_satuan='$satuan', produk_kategori='$kategori', produk_stok='$stok', produk_harga_modal='$harga_modal', produk_harga_jual='$harga_jual', produk_keterangan='$keterangan', produk_foto='$file_gambar', produk_kwantitas='$kwantitas' where produk_id='$id' ")or die(mysqli_error($koneksi));
		header("location:produk.php");
	}
}

