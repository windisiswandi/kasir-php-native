<?php 
include '../koneksi.php';
$id  = $_GET['id'];

$cekProduk = mysqli_query($koneksi, "SELECT * From produk where produk_kategori=$id");
?>

<?php if(mysqli_num_rows($cekProduk)) : ?>
    <script>
        alert("Gagal! produk dengan kategori ini masih tersedia");
        window.location.href = "kategori.php";
    </script>

<?php else : ?>
    <?php 
        mysqli_query($koneksi, "delete from kategori where kategori_id='$id'");
        header("location:kategori.php");
    ?>
<?php endif; ?>