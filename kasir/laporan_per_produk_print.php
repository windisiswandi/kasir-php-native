 <!DOCTYPE html>
 <html>
 <head>
 	<meta charset="utf-8">
 	<meta http-equiv="X-UA-Compatible" content="IE=edge">
 	<title>Laporan Penjualan</title>
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
 		<h4>LAPORAN PENJUALAN</h4>
 	</center>

  <br>
  <br>

 	<?php 
 	if(isset($_GET['tanggal_sampai']) && isset($_GET['tanggal_dari'])){
 		$tgl_dari = $_GET['tanggal_dari'];
 		$tgl_sampai = $_GET['tanggal_sampai'];
 		?>

 		<div class="row">
 			<div class="col-lg-4">
 				<table class="table-tanggal">
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
                <table class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th width="1%">NO</th>
                      <th width="10%" class="text-center">TANGGAL</th>
                      <th style="witdh: 350px;">NAMA PRODUK</th>
                      <th class="text-center">PELANGGAN</th>
                      <th class="text-center">KASIR</th>
                      <th class="text-center">HARGA</th>
                      <th class="text-center">QTY</th>
                      <th class="text-center">DISKON</th>
                      <th class="text-center">TOTAL BAYAR</th>
                      <th class="text-center">MODAL</th>
                      <th class="text-center">LABA</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                    $no=1;
                    $x_total_harga = 0;
                    $x_total_qty = 0;
                    $x_total_diskon = 0;
                    $x_total_bayar = 0;
                    $x_total_modal = 0;
                    $x_total_laba = 0;
                    $data = mysqli_query($koneksi,"SELECT * FROM transaksi,kasir,invoice, produk where kasir_id=invoice_kasir and invoice_id=transaksi_invoice and transaksi_produk=produk_id and date(invoice_tanggal) >= '$tgl_dari' and date(invoice_tanggal) <= '$tgl_sampai' order by invoice_id desc");
                    while($d = mysqli_fetch_array($data)){
                      ?>
                      <tr>
                        <td class="text-center"><?php echo $no++; ?></td>
                        <td class="text-center"><?php echo date("d-m-Y", strtotime($d['invoice_tanggal'])); ?></td>
                        <td class=""><?php echo $d['produk_nama']; ?></td>
                        <td class="text-center"><?php echo $d['invoice_pelanggan']; ?></td>
                        <td class="text-center"><?php echo $d['kasir_nama']; ?></td>
                        <td class="text-center"><?php echo "Rp.".number_format($d['produk_harga_jual']).",-"; ?></td>
                        <td class="text-center"><?php echo $d['transaksi_jumlah']; ?></td>
                        <td class="text-center"><?php echo "Rp.".number_format($d['potongan']).",-"; ?></td>
                        <td class="text-center">
                          <?php
                            $totalBayar = $d['produk_harga_jual']*$d['transaksi_jumlah']-$d['potongan'];
                            echo "Rp.".number_format($totalBayar).",-";
                          ?>
                        </td>
                        <td class="text-center">
                          <?php
                            $total_modal = $d['produk_harga_modal']*$d['transaksi_jumlah'];
                            echo "Rp.".number_format($total_modal).",-";
                          ?>
                        </td>
                        <td class="text-center"><?= "Rp.".number_format($totalBayar-$total_modal).",-"; ?></td>
                      </tr>
                      <?php 
                      $x_total_harga += $d['produk_harga_jual'];
                      $x_total_qty += $d['transaksi_jumlah'];
                      $x_total_diskon += $d['potongan'];
                      $x_total_bayar += $totalBayar;
                      $x_total_modal += $total_modal;
                      $x_total_laba += $totalBayar-$total_modal;
                    }
                    ?>
                  </tbody>
                  <tfoot>
                    <tr class="bg-info">
                      <td colspan="5" class="text-right"><b>TOTAL</b></td>
                      <td class="text-center"><b><?php echo "Rp.".number_format($x_total_harga).",-"; ?></b></td>
                      <td class="text-center"><b><?php echo $x_total_qty; ?></b></td>
                      <td class="text-center"><b><?php echo "Rp.".number_format($x_total_diskon).",-"; ?></b></td>
                      <td class="text-center"><b><?php echo "Rp.".number_format($x_total_bayar).",-"; ?></b></td>
                      <td class="text-center"><b><?php echo "Rp.".number_format($x_total_modal).",-"; ?></b></td>
                      <td class="text-center"><b><?php echo "Rp.".number_format($x_total_laba).",-"; ?></b></td>
                    </tr>
                  </tfoot>
                </table>

 	<?php } else {
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
