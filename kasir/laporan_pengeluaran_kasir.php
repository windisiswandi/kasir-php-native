<?php include 'header.php'; ?>

<div class="content-wrapper">

  <section class="content-header">
    <h1>
      LAPORAN
      <small>Data Laporan Pengeluaran Kasir</small>
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
            <h3 class="box-title">Filter Laporan Pengeluaran</h3>
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
            <h3 class="box-title">Data Pengeluaran Kasir</h3>
          </div>
          <div class="box-body">

            <?php 
            if(isset($_GET['tanggal_sampai']) && isset($_GET['tanggal_dari'])){
              $tgl_dari = $_GET['tanggal_dari'];
              $tgl_sampai = $_GET['tanggal_sampai'];
              $kasir_id = $_SESSION['id'];
              $kasir_nama = $_SESSION['nama'];
              ?>

              <div class="row">
                <div class="col-lg-6">
                  <table class="table table-bordered">
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

          
              <a href="laporan_pengeluaran_kasir_print.php?tanggal_dari=<?php echo $tgl_dari ?>&tanggal_sampai=<?php echo $tgl_sampai ?>&kasir_data=<?= $kasir_id."-".$kasir_nama; ?>" target="_blank" class="btn btn-sm btn-primary"><i class="fa fa-print"></i> &nbsp PRINT</a>
              <div class="table-responsive">

                <table class="table table-bordered table-striped" id="table-datatable">
                  <thead>
                    <tr>
                      <th width="1%">NO</th>
                      <th>TANGGAL</th>
                      <th>PENGELUARAN</th>
                      <th>NOMINAL</th>
                      <th>FOTO</th>
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
                        <td>
                            <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#foto_<?php echo $d['id_pengeluaran'] ?>">
                              <i class="fa fa-image"></i> Lihat
                            </button>

                             <!-- modal hapus -->
                            <div class="modal fade" id="foto_<?php echo $d['id_pengeluaran'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <div class="modal-body">

                                    <center>
                                      <?php if($d['foto'] == ""){ ?>
                                        <img src="../gambar/sistem/produk.png" style="width: 100%;height: auto">
                                      <?php }else{ ?>
                                        <img src="../gambar/pengeluaran/<?= $d['foto']; ?>" style="width: 100% ;height: auto">
                                      <?php } ?>
                                    </center>

                                  </div>
                                </div>
                              </div>
                            </div>
                        </td>
                       
                      </tr>
                      <?php
                        $totalNominal += $d['nominal']; 
                    }
                    ?>
                  </tbody>
                  <tfoot>
                    <tr class="bg-info">
                      <td colspan="3" class="text-right"><b>TOTAL</b></td>
                      <td colspan="2"><?php echo "Rp.".number_format($totalNominal).",-"; ?></td>
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