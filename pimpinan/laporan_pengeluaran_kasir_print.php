 <!DOCTYPE html>
 <html>
 <head>
 	<meta charset="utf-8">
 	<meta http-equiv="X-UA-Compatible" content="IE=edge">
 	<title>Laporan Pengeluaran Kasir</title>
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
 		<h4>LAPORAN PENGELUARAN KASIR</h4>
 	</center>

  <br>
  <br>

 	<?php 
 	if(isset($_GET['tanggal_sampai']) && isset($_GET['tanggal_dari']) && isset($_GET['kasir_data'])){
 		$tgl_dari = $_GET['tanggal_dari'];
 		$tgl_sampai = $_GET['tanggal_sampai'];
        $data_kasir = $_GET['kasir_data'];
        $kasir = explode("-", $data_kasir);
        $kasir_id = $kasir[0];
        $kasir_nama = $kasir[1];
 		?>

 		<div class="row">
 			<div class="col-lg-4">
 				<table class="table-tanggal">
 					<tr>
 						<th width="30%">NAMA KASIR</th>
 						<th width="1%">:</th>
 						<td><?php echo $kasir_nama; ?></td>
 					</tr>
 					<tr>
 						<th width="30%">DARI TANGGAL</th>
 						<th width="1%">:</th>
 						<td><?php echo $tgl_dari; ?></td>
 					</tr>
 					<tr>
 						<th>SAMPAI TANGGAL</th>
 						<th>:</th>
 						<td><?php echo $tgl_sampai; ?></td>
 					</tr>
 				</table>
 			</div>
 		</div>

 		<br>
        
        <table class="table table-bordered table-striped" id="table-datatable">
            <thead>
            <tr>
                <th width="1%">NO</th>
                <th>TANGGAL</th>
                <th>PENGELUARAN</th>
                <th>NOMINAL</th>
            </tr>
            </thead>
            <tbody>
            <?php 
            $no=1;
            $totalNominal = 0;
            $data = mysqli_query($koneksi,"SELECT * FROM pengeluaran_kasir where kasir_id='$kasir_id' and date(tanggal) >= '$tgl_dari' and date(tanggal) <= '$tgl_sampai'");
            while($d = mysqli_fetch_array($data)){
                ?>
                <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo date('d-m-Y', strtotime($d['tanggal'])); ?></td>
                <td><?php echo $d['pengeluaran']; ?></td>
                <td><?php echo "Rp.".number_format($d['nominal']).",-"; ?></td>
                </tr>
                <?php
                $totalNominal += $d['nominal']; 
            }
            ?>
            </tbody>
            <tfoot>
            <tr class="bg-info">
                <td colspan="3" class="text-right"><b>TOTAL</b></td>
                <td><b><?php echo "Rp.".number_format($totalNominal).",-"; ?></b></td>
            </tr>
            </tfoot>
        </table>



 		<?php 
 	}else{
 		?>

 		<div class="alert alert-info text-center">
 			Silahkan Filter Laporan Terlebih Dulu.
 		</div>

 		<?php
 	}
 	?>


 	<script>
 		window.print();
 	</script>

 </body>
 </html>
