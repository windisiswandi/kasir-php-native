<?php include 'header.php'; ?>

<div class="content-wrapper">

  <section class="content-header">
    <h1>
      LAPORAN
      <small>Data Laporan Penjualan</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Dashboard</li>
    </ol>
  </section>

  <section class="content">
    <div class="row">
      <section class="col-lg-12">
        <div class="box box-info">
          <div class="box-header">
            <h3 class="box-title">Filter Laporan Penjualan</h3>
          </div>
          <div class="box-body">
            <form method="get" action="">
              <div class="row">
                <div class="col-md-2">

                  <div class="form-group">
                    <label>Mulai Tanggal</label>
                    <input autocomplete="off" type="text" value="<?php if(isset($_GET['tanggal_dari'])){echo $_GET['tanggal_dari'];}else{echo "";} ?>" name="tanggal_dari" class="form-control datepicker2" placeholder="Mulai Tanggal" required="required">
                  </div>

                </div>

                <div class="col-md-2">

                  <div class="form-group">
                    <label>Sampai Tanggal</label>
                    <input autocomplete="off" type="text" value="<?php if(isset($_GET['tanggal_sampai'])){echo $_GET['tanggal_sampai'];}else{echo "";} ?>" name="tanggal_sampai" class="form-control datepicker2" placeholder="Sampai Tanggal" required="required">
                  </div>

                </div>

                <div class="col-md-1">

                  <div class="form-group">
                    <input style="margin-top: 26px" type="submit" value="TAMPILKAN" class="btn btn-sm btn-primary btn-block">
                  </div>

                </div>
              </div>
            </form>
          </div>
        </div>

        <div class="box box-info">
          <div class="box-header">
            <h3 class="box-title">Data Penjualan</h3>
          </div>
          <div class="box-body">

            <?php 
            if(isset($_GET['tanggal_sampai']) && isset($_GET['tanggal_dari'])){
              $tgl_dari = $_GET['tanggal_dari'];
              $tgl_sampai = $_GET['tanggal_sampai'];
              ?>

              <div class="row">
                <div class="col-lg-6">
                  <table class="table table-bordered">
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

              <a href="laporan_pdf.php?tanggal_dari=<?php echo $tgl_dari ?>&tanggal_sampai=<?php echo $tgl_sampai ?>" target="_blank" class="btn btn-sm btn-success"><i class="fa fa-file-pdf-o"></i> &nbsp CETAK PDF</a>
              <a href="laporan_print.php?tanggal_dari=<?php echo $tgl_dari ?>&tanggal_sampai=<?php echo $tgl_sampai ?>" target="_blank" class="btn btn-sm btn-primary"><i class="fa fa-print"></i> &nbsp PRINT</a>
              <div class="table-responsive">

                <table class="table table-bordered table-striped" id="table-datatable">
                  <thead>
                    <tr>
                      <th width="1%">NO</th>
                      <th width="10%" class="text-center">NO.INVOICE</th>
                      <th class="text-center">TANGGAL</th>
                      <th class="text-center">PELANGGAN</th>
                      <th class="text-center">KASIR</th>
                      <th class="text-center">SUB TOTAL</th>
                      <th class="text-center">DISKON</th>
                      <th class="text-center">TOTAL BAYAR</th>
                      <th class="text-center">MODAL</th>
                      <th class="text-center">LABA</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                    $no=1;
                    $x_total_sub_total = 0;
                    $x_total_diskon = 0;
                    $x_total_total = 0;
                    $x_total_modal = 0;
                    $x_total_laba = 0;
                    $data = mysqli_query($koneksi,"SELECT * FROM invoice,kasir where kasir_id=invoice_kasir and date(invoice_tanggal) >= '$tgl_dari' and date(invoice_tanggal) <= '$tgl_sampai' order by invoice_id desc");
                    while($d = mysqli_fetch_array($data)){
                      ?>
                      <tr>
                        <td class="text-center"><?php echo $no++; ?></td>
                        <td class="text-center"><?php echo $d['invoice_nomor']; ?></td>
                        <td class="text-center"><?php echo date('d-m-Y', strtotime($d['invoice_tanggal'])); ?></td>
                        <td class="text-center"><?php echo $d['invoice_pelanggan']; ?></td>
                        <td class="text-center"><?php echo $d['kasir_nama']; ?></td>
                        <td class="text-center"><?php echo "Rp.".number_format($d['invoice_sub_total']).",-"; ?></td>
                        <td class="text-center"><?php echo "Rp.".number_format($d['invoice_diskon']).",-"; ?></td>
                        <td class="text-center"><?php echo "Rp.".number_format($d['invoice_total']).",-"; ?></td>
                        <td class="text-center">

                          <?php 
                          $id_invoice = $d['invoice_id'];
                          $total_modal = 0;
                          $modal = mysqli_query($koneksi,"SELECT * FROM invoice,transaksi,produk where invoice_id=transaksi_invoice and transaksi_produk=produk_id and invoice_id='$id_invoice'");
                          while($l = mysqli_fetch_array($modal)){
                            $m = $l['produk_harga_modal'] * $l['transaksi_jumlah'];
                            $total_modal += $m;
                          }
                          ?>
                          <?php echo "Rp.".number_format($total_modal).",-"; ?>

                        </td>
                        <td class="text-center">

                          <?php 
                          $total_laba = $d['invoice_total'] - $total_modal;
                          ?>
                          <?php echo "Rp.".number_format($total_laba).",-"; ?>

                        </td>
                      </tr>
                      <?php 
                      $x_total_sub_total += $d['invoice_sub_total'];
                      $x_total_diskon += $d['invoice_diskon'];
                      $x_total_total += $d['invoice_total'];
                      $x_total_modal += $total_modal;
                      $x_total_laba += $total_laba;
                    }
                    ?>
                  </tbody>
                  <tfoot>
                    <tr class="bg-info">
                      <td colspan="5" class="text-right"><b>TOTAL</b></td>
                      <td class="text-center"><?php echo "Rp.".number_format($x_total_sub_total).",-"; ?></td>
                      <td class="text-center"><?php echo "Rp.".number_format($x_total_diskon).",-"; ?></td>
                      <td class="text-center"><?php echo "Rp.".number_format($x_total_total).",-"; ?></td>
                      <td class="text-center"><?php echo "Rp.".number_format($x_total_modal).",-"; ?></td>
                      <td class="text-center"><?php echo "Rp.".number_format($x_total_laba).",-"; ?></td>
                    </tr>
                  </tfoot>
                </table>


              </div>

              <?php 
            }else{
              ?>

              <div class="alert alert-info text-center">
                Silahkan Filter Laporan Terlebih Dulu.
              </div>

              <?php
            }
            ?>

          </div>
        </div>
      </section>
    </div>
  </section>

</div>
<?php include 'footer.php'; ?>