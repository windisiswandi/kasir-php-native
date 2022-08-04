<?php 
include '../koneksi.php';
session_start();
$id = $_POST['id'];
$tanggal = $_POST['tanggal'];
$pelanggan = $_POST['pelanggan'];
$kasir = $_SESSION['id'];
$sub_total = $_POST['sub_total'];
$diskon = $_POST['diskon'];
$total = $_POST['total'];

mysqli_query($koneksi, "update invoice set invoice_tanggal='$tanggal', invoice_pelanggan='$pelanggan', invoice_sub_total='$sub_total', invoice_diskon='$diskon', invoice_total='$total' where invoice_id='$id'");


// hapus transaksi
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


// insert transaksi
$id_invoice = $id;

$transaksi_produk = $_POST['transaksi_produk'];
$transaksi_harga = $_POST['transaksi_harga'];
$transaksi_jumlah = $_POST['transaksi_jumlah'];
$transaksi_total = $_POST['transaksi_total'];

$jumlah_pembelian = count($transaksi_produk);

for($a=0;$a<$jumlah_pembelian;$a++){

	$t_produk = $transaksi_produk[$a];
	$t_harga = $transaksi_harga[$a];
	$t_jumlah = $transaksi_jumlah[$a];
	$t_total = $transaksi_total[$a];

	// ambil jumlah produk
	$detail = mysqli_query($koneksi, "select * from produk where produk_id='$t_produk'");
	$de = mysqli_fetch_assoc($detail);
	$jumlah_produk = $de['produk_stok'];

	// kurangi jumlah produk
	$jp = $jumlah_produk-$t_jumlah;
	mysqli_query($koneksi, "update produk set produk_stok='$jp' where produk_id='$t_produk'");

	// simpan data pembelian
	mysqli_query($koneksi, "insert into transaksi values(NULL,'$id_invoice','$t_produk','$t_harga','$t_jumlah','$t_total')")or die(mysqli_errno($koneksi));

}


header("location:penjualan.php?alert=update");