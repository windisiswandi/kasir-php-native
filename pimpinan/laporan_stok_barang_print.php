 <!DOCTYPE html>
 <html>
 <head>
 	<meta charset="utf-8">
 	<meta http-equiv="X-UA-Compatible" content="IE=edge">
 	<title>Laporan Stok Barang</title>
 	<link rel="stylesheet" href="../assets/bower_components/bootstrap5/css/bootstrap.min.css">
 	<?php include '../koneksi.php'; ?>
 </head>
 <body style="padding: 10px;">

 	<style type="text/css">
 		.table-tanggal tr th, .table-tanggal tr td{
 			padding: 5px;
 		}
    hr {border-bottom: 2px solid black; margin: 20px 0;}
 	</style>

    <h3><b>JARINGANKU STORE</b></h3>
    <p class="p-0 m-0">Jl. Manggis, Uma Sima, Kec. Sumbawa, Kabupaten Sumbawa, Nusa Tenggara Barat</p>
    <p class="p-0 m-0">085338253180</p>
    <hr>
        <center>
            <h4>LAPORAN STOK BARANG</h4>
        </center>

    <br>
    <br>

 	  <table class="table table-bordered table-striped" id="table-datatable">
            <thead>
            <tr>
                <th width="1%">NO</th>
                <th>KODE</th>
                <th>NAMA PRODUK</th>
                <th>KATEGORI</th>
                <th>STOK</th>
                <th>MODAL</th>
                <th>JUAL</th>
            </tr>
            </thead>
            <tbody>
            <?php 
            $no=1;
            $data = mysqli_query($koneksi,"SELECT * FROM produk, kategori where produk_kategori=kategori_id");
            while($d = mysqli_fetch_array($data)){
                ?>
                <tr>
                <td class="text-center"><?php echo $no++; ?></td>
                <td class="text-center"><?php echo $d['produk_kode']; ?></td>
                <td class="text-center"><?php echo $d['produk_nama']; ?></td>
                <td class="text-center"><?php echo $d['kategori']; ?></td>
                <td class="text-center"><?php echo $d['produk_stok']; ?></td>
                <td class="text-center"><?php echo "Rp.".number_format($d['produk_harga_modal']).",-"; ?></td>
                <td class="text-center"><?php echo "Rp.".number_format($d['produk_harga_jual']).",-"; ?></td>
            
            <?php } ?>
            </tbody>
        </table>


 	<script>
 		window.print();
 	</script>

 </body>
 </html>
