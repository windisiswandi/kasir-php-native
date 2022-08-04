<?php 
include '../koneksi.php';
session_start();
$nomor = $_POST['nomor'];
$tanggal = $_POST['tanggal'];
$pelanggan = $_POST['pelanggan'];
$kasir = $_SESSION['id'];
$sub_total = $_POST['subtotal'];
$diskon = $_POST['total_potongan'];
$total = $_POST['total'];

mysqli_query($koneksi, "insert into invoice values(NULL,'$nomor','$tanggal','$pelanggan','$kasir','$sub_total','$diskon','$total')")or die(mysqli_errno($koneksi));

$id_invoice = mysqli_insert_id($koneksi);

$transaksi_produk = $_POST['transaksi_produk'];
$transaksi_harga = $_POST['transaksi_harga'];
$transaksi_jumlah = $_POST['transaksi_jumlah'];
$transaksi_subtotal = $_POST['transaksi_subtotal'];
$transaksi_potongan = $_POST['transaksi_potongan'];
$transaksi_total = $_POST['transaksi_total'];

$jumlah_pembelian = count($transaksi_produk);

for($a=0;$a<$jumlah_pembelian;$a++){

	$t_produk = $transaksi_produk[$a];
	$t_harga = $transaksi_harga[$a];
	$t_jumlah = $transaksi_jumlah[$a];
	$t_subtotal = $transaksi_subtotal[$a];
	$t_potongan = $transaksi_potongan[$a];
	$t_total = $transaksi_total[$a];

	// ambil jumlah produk
	$detail = mysqli_query($koneksi, "select * from produk where produk_id='$t_produk'");
	$de = mysqli_fetch_assoc($detail);
	$jumlah_produk = $de['produk_stok'];

	// kurangi jumlah produk
	$jp = $jumlah_produk-$t_jumlah;
	mysqli_query($koneksi, "update produk set produk_stok='$jp' where produk_id='$t_produk'");

	// simpan data pembelian
	mysqli_query($koneksi, "insert into transaksi values(NULL,'$id_invoice','$t_produk','$t_harga','$t_jumlah','$t_total', '$t_subtotal', '$t_potongan')")or die(mysqli_errno($koneksi));

}


header("location:penjualan.php?alert=sukses");