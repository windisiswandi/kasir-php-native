<?php include 'header.php'; ?>

<div class="content-wrapper">

  <section class="content-header">
    <h1>
      Penjualan
      <small>Input Penjualan Baru</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Penjualan</li>
    </ol>
  </section>

  <section class="content">

    <!-- <a href="penjualan.php" class="btn btn-sm btn-primary"><i class="fa fa-file"></i> &nbsp; DATA PENJUALAN</a>
    <a href="penjualan_tambah.php" class="btn btn-sm btn-primary"> <i class="fa fa-plus"></i> &nbsp; INPUT PENJUALAN</a> -->

    <br>
    <br>

    <div class="row">
      <section class="col-lg-12">       
        <div class="box box-info">

          <div class="box-body" style="padding: 20px">

            <?php 
            if(isset($_GET['alert'])){
              if($_GET['alert'] == "gagal"){
                echo "<div class='alert alert-danger'>File yang diperbolehkan hanya file gambar!</div>";
              }elseif($_GET['alert'] == "duplikat"){
                echo "<div class='alert alert-danger'><b>Kode Produk</b> sudah pernah digunakan!</div>";
              }
            }
            ?>

            <form action="penjualan_act.php" method="post" onSubmit="return cek(this)">

             <div class="row">

              <div class="col-lg-3">

                <input type="hidden" name="kasir" value="<?php echo $_SESSION['id']; ?>">

                <div class="form-group">
                  <label>Kasir</label>
                  <input type="text" class="form-control" required="required" value="<?php echo $_SESSION['nama']; ?>" readonly>
                </div>

              </div>

              <div class="col-lg-3">

                <div class="form-group">
                  <label>No. Invoice</label>
                  <?php 
                        // mencari kode Produk dengan nilai paling besar
                  $hasil = mysqli_query($koneksi,"SELECT max(invoice_nomor) as maxKode FROM invoice");
                  $kp = mysqli_fetch_array($hasil);
                  $kodeInvoice = $kp['maxKode'];
                  // echo $kodeInvoice;
                  // echo "<br/>";
                  $noUrut = substr($kodeInvoice, 6, 3);
                  // echo $noUrut;
                  $noUrut++;
                  // echo $noUrut;
                  $thn = date('y');
                  $bln = date('m');
                  $tgl = date('d');
                  $char = $thn.$bln.$tgl;
                  $noInvoice = $char . sprintf("%02s", $noUrut);
                  // echo $noInvoice;
                  ?>
                  <input type="text" class="form-control" name="nomor" required="required" placeholder="Masukkan Nomor Invoice" value="<?php echo $noInvoice; ?>" readonly>
                </div>

              </div>

              <div class="col-lg-3">

                <div class="form-group">
                  <label>Tanggal Invoice</label>
                  <input type="date" class="form-control" name="tanggal" required="required" placeholder="Masukkan Tanggal Pembelian .. (Wajib)" value="<?php echo date('Y-m-d') ?>" readonly>
                </div>

              </div>

              <div class="col-lg-3">

                <div class="form-group">
                  <label>Pelanggan</label>
                  <input type="text" class="form-control" name="pelanggan" placeholder="Masukkan Nama Pelanggan .. (Optional)">
                </div>

              </div>

            </div>

            <hr>  


            <div class="row">

              <div class="col-lg-3">
                <h3>Tambah Pembelian</h3>

                <div class="row">

                 <div class="form-group col-lg-7">
                  <label>Kode Produk</label>
                  <input type="hidden" class="form-control" id="tambahkan_id">
                  <input type="text" class="form-control" id="tambahkan_kode" placeholder="Masukkan Kode Produk ..">
                </div>

                <div class="col-lg-5">

                  <button style="margin-top: 27px" type="button" class="btn btn-primary btn-sm btn-block" data-toggle="modal" data-target="#cariProduk">
                    <i class="fa fa-search"></i> &nbsp Cari Produk
                  </button>

                  <!-- Modal -->
                  <div class="modal fade" id="cariProduk" tabindex="-1" role="dialog" aria-labelledby="cariProdukLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                          Pilih Pembelian produk
                        </div>
                        <div class="modal-body">


                          <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover" id="table-datatable-produk">
                              <thead>
                                <tr>
                                  <th class="text-center">NO</th>
                                  <th>KODE</th>
                                  <th>PRODUK</th>
                                  <th class="text-center">SATUAN</th>
                                  <th class="text-center">STOK</th>
                                  <th class="text-center">HARGA JUAL</th>
                                  <th>KETERANGAN</th>
                                  <th></th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php 
                                $no=1;
                                $data = mysqli_query($koneksi,"SELECT * FROM produk, kategori where produk_kategori=kategori_id order by produk_id desc");
                                while($d = mysqli_fetch_array($data)){
                                  ?>
                                  <tr>
                                    <td width="1%" class="text-center"><?php echo $no++; ?></td>
                                    <td width="1%"><?php echo $d['produk_kode']; ?></td>
                                    <td>
                                      <?php echo $d['produk_nama']; ?>
                                      <br>
                                      <small class="text-muted"><?php echo $d['kategori']; ?></small>
                                    </td>
                                    <td width="1%" class="text-center"><?php echo $d['produk_satuan']; ?></td>
                                    <td width="1%" class="text-center"><?php echo $d['produk_stok']; ?></td>
                                    <td width="20%" class="text-center"><?php echo "Rp.".number_format($d['produk_harga_jual']).",-"; ?></td>
                                    <td width="15%"><?php echo $d['produk_keterangan']; ?></td>
                                    <td width="1%">              
                                      <?php 
                                      if($d['produk_stok'] > 0){
                                        ?>          
                                        <input type="hidden" id="kode_<?php echo $d['produk_id']; ?>" value="<?php echo $d['produk_kode']; ?>">
                                        <input type="hidden" id="nama_<?php echo $d['produk_id']; ?>" value="<?php echo $d['produk_nama']; ?>">
                                        <input type="hidden" id="harga_<?php echo $d['produk_id']; ?>" value="<?php echo $d['produk_harga_jual']; ?>">
                                        <button type="button" class="btn btn-success btn-sm modal-pilih-produk" id="<?php echo $d['produk_id']; ?>" data-dismiss="modal">Pilih</button>
                                        <?php 
                                      }
                                      ?>
                                    </td>
                                  </tr>
                                  <?php 
                                }
                                ?>
                              </tbody>
                            </table>
                          </div>

                        </div>
                      </div>
                    </div>
                  </div>

                </div>

              </div>


              <div class="form-group">
                <label>Produk</label>
                <input type="text" class="form-control" id="tambahkan_nama" disabled>
              </div>

              <div class="form-group">
                <label>Harga</label>
                <input type="text" class="form-control" id="tambahkan_harga" disabled>
              </div>

              <div class="form-group">
                <label>Jumlah</label>
                <input type="number" class="form-control" id="tambahkan_jumlah" min="1">
              </div>
              <div class="form-group">
                <label>Potongan</label>
                <input type="text" class="form-control" id="potongan" min="0">
              </div>
              <!-- <div class="form-group">
                <label>Total</label>
                <input type="text" class="form-control" id="tambahkan_total" disabled>
              </div> -->

              <div class="form-group">
                <span class="btn btn-sm btn-primary pull-right btn-block" id="tombol-tambahkan">TAMBAHKAN</span>
              </div>

            </div>


            <div class="col-lg-9">

              <h3>Daftar Pembelian</h3>

              <table class="table table-bordered table-striped table-hover" id="table-pembelian">
                <thead>
                  <tr>
                    <th>Kode</th>
                    <th>Nama Produk</th>
                    <th style="text-align: center;">Harga</th>
                    <th style="text-align: center;">Jumlah</th>
                    <th style="text-align: center;">Sub Total</th>
                    <th style="text-align: center;">Potongan</th>
                    <th style="text-align: center;">Total</th>
                    <th style="text-align: center;" width="1%">OPSI</th>
                  </tr>
                </thead>
                <tbody> 
                </tbody>
                <tfoot>
                  <tr class="bg-info">
                    <td style="text-align: right;" colspan="4"><b>Total</b></td>
                    <!-- <td style="text-align: center;"><span class="pembelian_harga" id="0">Rp.0,-</span></td>
                    <td style="text-align: center;"><span class="pembelian_jumlah" id="0">0</span></td> -->
                    <td style="text-align: center;"><span class="sub_total" id="0">Rp.0,-</span></td>
                    <td style="text-align: center;"><span class="potongan_produk" id="0">Rp.0,-</span></td>
                    <td style="text-align: center;"><span class="pembelian_total" id="0">Rp.0,-</span></td>
                    <td style="text-align: center;"></td>
                  </tr>
                </tfoot>
              </table>

              <br>

              <div class="row">
                <div class="col-lg-6">
                  <table class="table table-bordered table-striped">
                    <tr>
                      <th width="50%">Sub Total Pembelian</th>
                      <td>
                        <input type="hidden" name="subtotal" class="sub_total_form" value="0">
                        <span class="sub_total_pembelian" id="0">Rp.0,-</span>
                      </td>
                    </tr>
                    <tr>
                      <th>Total Potongan</th>
                      <td>
                        <input type="hidden" name="total_potongan" class="potongan_form" value="0">
                        <span class="total_potongan" id="0">Rp.0,-</span>
                      </td>
                    </tr>
                    <tr>
                      <th>Total Pembelian</th>
                      <td>
                        <input type="hidden" name="total" class="total_form" value="0">
                        <span class="total_pembelian" id="0">Rp.0,-</span>
                      </td>
                    </tr>
                  </table>
                </div>
              </div>

            </div>
          </div>

          <hr>

          <br>
          <div class="form-group">
            <a href="penjualan_tambah.php" class="btn btn-danger"><i class="fa fa-close"></i> Batalkan Transaksi</a>
            <button class="btn btn-success pull-right"><i class="fa fa-check"></i> Buat Transaksi</button>
          </div>

          <br>
          <br>

        </form>
      </div>

    </div>
  </section>
</div>
</section>

</div>

<script>
  new AutoNumeric("input#potongan", {
      currencySymbol : 'Rp.',
      decimalCharacter : ',',
      digitGroupSeparator : '.'
  })

</script>


<?php include 'footer.php'; ?>