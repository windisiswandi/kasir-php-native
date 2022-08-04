<?php 
include '../koneksi.php';

$id = $_GET['id'];

// hapus invoice
mysqli_query($koneksi, "delete from invoice where invoice_id='$id'");

$transaksi = mysqli_query($koneksi, "select * from transaksi where transaksi_invoice='$id'");
while($t = mysqli_fetch_array($transaksi)){

	$id_transaksi = $t['transaksi_id'];
	$produk = $t['transaksi_produk'];
	$jumlah = $t['transaksi_jumlah'];

	// ambil jumlah produk
	$detail = mysqli_query($koneksi, "select * from produk where produk_id='$produk'");
	$de = mysqli_fetch_assoc($detail);
	$jumlah_produk = $de['produk_stok'];

	// tambahkan jumlah produk
	$jp = $jumlah_produk+$jumlah;
	mysqli_query($koneksi, "update produk set produk_stok='$jp' where produk_id='$produk'");

	// simpan data pembelian
	mysqli_query($koneksi, "delete from transaksi where transaksi_id='$id_transaksi'")or die(mysqli_errno($koneksi));

}

header("location:penjualan.php?alert=hapus");