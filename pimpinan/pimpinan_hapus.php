<?php 
include '../koneksi.php';
$id = $_GET['id'];
$data = mysqli_query($koneksi, "select * from pimpinan where pimpinan_id='$id'");
$d = mysqli_fetch_assoc($data);
$foto = $d['pimpinan_foto'];
unlink("../gambar/pimpinan/$foto");
mysqli_query($koneksi, "delete from pimpinan where pimpinan_id='$id'");
header("location:pimpinan.php");
