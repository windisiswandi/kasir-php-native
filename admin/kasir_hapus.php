<?php 
include '../koneksi.php';
$id = $_GET['id'];
$data = mysqli_query($koneksi, "select * from kasir where kasir_id='$id'");
$d = mysqli_fetch_assoc($data);
$foto = $d['kasir_foto'];
unlink("../gambar/kasir/$foto");
mysqli_query($koneksi, "delete from kasir where kasir_id='$id'");
header("location:kasir.php");
