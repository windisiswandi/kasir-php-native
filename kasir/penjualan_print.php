 <!DOCTYPE html>
 <html>
 <head>
 	<meta charset="utf-8">
 	<meta http-equiv="X-UA-Compatible" content="IE=edge">
 	<title>Cetak invoice - Sistem Point Of Sales (POS)</title>
 	<link rel="stylesheet" href="../assets/bower_components/bootstrap5/css/bootstrap.min.css">
 	<style>
		#ket_invoice tr td {padding: 3px;}
		table tr td, p {font-size: 14px;}
	</style>
 </head>
 <body style="padding: 10px;">
	<div class="row justify-content-between">
		<div class="col-sm-3">
			<h3><b>JARINGANKU STORE</b></h3>
			<p class="p-0 m-0">Jl. Pejanggik.74, selong, lombok Timur</p>
			<p class="p-0 m-0">084253245354</p>
		</div>
	</div>
	<br>
	<h5><b>Invoice Pembelian</b></h5>
 	<?php 
 	if($_GET['id']){
 		?>
 		<?php 
 		include "../koneksi.php";
 		$id = $_GET['id'];
 		$invoice = mysqli_query($koneksi,"select * from invoice,kasir where invoice_kasir=kasir_id and invoice_id='$id'");
 		while($d = mysqli_fetch_array($invoice)){
 			?>

 			<div class="row">
 				<div class="col-lg-4">
 					<table id="ket_invoice">
 						<tr>
 							<td>No. Invoice</td>
 							<td>:</td>
 							<td><?php echo $d['invoice_nomor']; ?></td>
 						</tr>
 						<tr>
 							<td>Tanggal Invoice</td>
 							<td>:</td>
 							<td><?php echo date('d-m-Y', strtotime($d['invoice_tanggal'])); ?></td>
 						</tr>
 						<tr>
 							<td>Pelanggan</td>
 							<td>:</td>
 							<td><?php echo $d['invoice_pelanggan']; ?></td>
 						</tr>
 						<tr>
 							<td width="40%">Kasir yang melayani</td>
 							<td width="1%">:</td>
 							<td><?php echo $d['kasir_nama']; ?></td>
 						</tr>
 					</table>					
 				</div>
 			</div>
			<br>
 			<h5><b>Daftar Pembelian</b></h5>

 			<table class="table table-bordered table-striped table-hover" id="table-pembelian">
 				<thead>
 					<tr>
 						<th>No</th>
 						<th>Nama Produk</th>
 						<th width="1%" style="text-align: center;">Harga</th>
 						<th width="1%" style="text-align: center;">Jumlah</th>
 						<th width="1%" style="text-align: center;">Sub Total</th>
 						<th width="1%" style="text-align: center;">Disc</th>
 						<th width="1%" style="text-align: center;">Total</th>
 					</tr>
 				</thead>
 				<tbody>
 					<?php 
 					$id_invoice = $d['invoice_id'];
					$i=1;
 					$ppata = mysqli_query($koneksi,"SELECT * FROM produk,kategori,transaksi where produk_kategori=kategori_id and transaksi_invoice='$id_invoice' and transaksi_produk=produk_id");
 					while($pp = mysqli_fetch_array($ppata)){
 						?>
 						<tr>
 							<td><?= $i++; ?></td>
 							<td>
 								<?php echo $pp['produk_nama']; ?>
 								<br>
 								<small class="text-muted"><?php echo $pp['kategori']; ?></small>
 							</td>
 							<td style="text-align: center;"><?php echo "Rp.".number_format($pp['transaksi_harga']).",-"; ?></td>  
 							<td style="text-align: center;"><?php echo $pp['transaksi_jumlah']; ?></td>
 							<td style="text-align: center;"><?php echo "Rp.".number_format($pp['sub_total']).",-"; ?></td>  
 							<td style="text-align: center;"><?php echo "Rp.".number_format($pp['potongan']).",-"; ?></td>  
 							<td style="text-align: center;"><?php echo "Rp.".number_format($pp['transaksi_total']).",-"; ?></td>  
 						</tr>
 						<?php 
 					}
 					?>
 				</tbody>
 			</table>


 			<div class="row">
 				<div class="col-lg-6">
 					<table class="table table-bordered table-striped">
 						<tr>
 							<th width="30%">Sub Total</th>
 							<td>
 								<span class="sub_total_pembelian"><?php echo "Rp.".number_format($d['invoice_sub_total']).",-"; ?></span>
 							</td>
 						</tr>
 						<tr>
 							<th>Total Disc</th>
 							<td>
 								<?php echo "Rp.".number_format($d['invoice_diskon']).",-"; ?>
 							</td>
 						</tr>
 						<tr>
 							<th>Total Belanja</th>
 							<td>
 								<span class="total_pembelian"><?php echo "Rp.".number_format($d['invoice_total']).",-"; ?></span>
 							</td>
 						</tr>
 					</table>
 				</div>
 			</div>

 			<?php 
 		}
 		?>
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
 		$(document).ready(function(){

 		});
 	</script>

 </body>
 </html>
