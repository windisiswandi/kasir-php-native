<?php 
include '../koneksi.php';
$kode  = $_POST['kode'];
$produk = mysqli_query($koneksi,"select * from produk where produk_kode='$kode'")or die(mysqli_error($koneksi));
$jumlah = mysqli_num_rows($produk);
if($jumlah == 1){
	$p = mysqli_fetch_assoc($produk);
	$return_arr = array();
	$return_arr[] = array(
		"id" => $p['produk_id'],
		"kode" => $p['produk_kode'],
		"nama" => $p['produk_nama'],
		"harga" => $p['produk_harga_jual'],
		"jumlah" => "1",
	);
	echo json_encode($return_arr);
}elseif($jumlah == 0){
	$return_arr = array();
	$return_arr[] = array(
		"id" => "",
		"kode" => "",
		"nama" => "",
		"harga" => "",
		"jumlah" => "",
	);
	echo json_encode($return_arr);
}