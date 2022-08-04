<?php 
include '../koneksi.php';
$id = $_GET['id'];
$data = mysqli_query($koneksi, "select * from produk where produk_id='$id'");
$d = mysqli_fetch_assoc($data);
$foto = $d['produk_foto'];
unlink("../gambar/produk/$foto");
mysqli_query($koneksi, "delete from produk where produk_id='$id'");
header("location:produk.php");
