<?php include 'header.php'; ?>

<div class="content-wrapper">

  <section class="content-header">
    <h1>
      Penjualan
      <small>Edit Penjualan</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Penjualan</li>
    </ol>
  </section>

  <section class="content">

    <a href="penjualan.php" class="btn btn-sm btn-primary"><i class="fa fa-file"></i> &nbsp; DATA PENJUALAN</a>

    <br>
    <br>

    <div class="row">
      <section class="col-lg-12">       
        <div class="box box-info">

          <div class="box-body" style="padding: 20px">

            <?php 
            $id = $_GET['id'];
            $invoice = mysqli_query($koneksi,"select * from invoice where invoice_id='$id'");
            while($i = mysqli_fetch_array($invoice)){
              ?>

              <form action="penjualan_update.php" method="post" onSubmit="return cek(this)">

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
                      <input type="hidden" name="id" value="<?php echo $i['invoice_id']; ?>">
                      <input type="text" class="form-control" value="<?php echo $i['invoice_nomor']; ?>" readonly>
                    </div>

                  </div>
                  <div class="col-lg-3">

                    <div class="form-group">
                      <label>Tanggal Invoice</label>
                      <input type="date" class="form-control" name="tanggal" required="required" placeholder="Masukkan Tanggal Pembelian .. (Wajib)" value="<?php echo $i['invoice_tanggal'] ?>">
                    </div>

                  </div>
                  <div class="col-lg-3">

                    <div class="form-group">
                      <label>Pelanggan</label>
                      <input type="text" class="form-control" name="pelanggan" required="required" placeholder="Masukkan Nama Pelanggan .. (Wajib)" value="<?php echo $i['invoice_pelanggan'] ?>">
                    </div>

                  </div>

                </div>

                <hr>  


                <div class="row">

                  <div class="col-lg-3">
                    <h4>Tambah Pembelian</h4>

                    <div class="row">
                      <div class="form-group col-lg-7">
                        <label>Kode Produk</label>
                        <input type="hidden" class="form-control" id="tambahkan_id">
                        <input type="text" class="form-control" id="tambahkan_kode" placeholder="Masukkan Kode Produk ..">
                      </div>

                      <div class="col-lg-5" style="margin-top: 27px">

                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#cariProduk">
                          <i class="fa fa-search"></i> &nbsp Cari Produk
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="cariProduk" tabindex="-1" role="dialog" aria-labelledby="cariProdukLabel" aria-hidden="true">
                          <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                Pilih Pembelian Barang
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">


                                <div class="table-responsive">
                                  <table class="table table-bordered table-striped table-hover" id="table-datatable">
                                    <thead>
                                      <tr>
                                        <th width="1%">NO</th>
                                        <th width="1%">KODE</th>
                                        <th>PRODUK</th>
                                        <th width="1%">SATUAN</th>
                                        <th width="1%">STOK</th>
                                        <th>HARGA JUAL</th>
                                        <th>KETERANGAN</th>
                                        <th width="1%"></th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <?php 
                                      $no=1;
                                      $data = mysqli_query($koneksi,"SELECT * FROM produk, kategori where produk_kategori=kategori_id order by produk_id desc");
                                      while($d = mysqli_fetch_array($data)){
                                        ?>
                                        <tr>
                                          <td><?php echo $no++; ?></td>
                                          <td><?php echo $d['produk_kode']; ?></td>
                                          <td>
                                            <?php echo $d['produk_nama']; ?>
                                            <br>
                                            <small class="text-muted"><?php echo $d['kategori']; ?></small>
                                          </td>
                                          <td><?php echo $d['produk_satuan']; ?></td>
                                          <td><?php echo $d['produk_stok']; ?></td>
                                          <td><?php echo "Rp.".number_format($d['produk_harga_jual']).",-"; ?></td>
                                          <td><?php echo $d['produk_keterangan']; ?></td>
                                          <td>              
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
                      <label>Total</label>
                      <input type="text" class="form-control" id="tambahkan_total" disabled>
                    </div>

                    <div class="form-group">
                      <span class="btn btn-sm btn-primary pull-right btn-block" id="tombol-tambahkan">Tambahkan</span>
                    </div>

                  </div>


                  <div class="col-lg-9">
                    <h4>Daftar Pembelian</h4>

                    <table class="table table-bordered table-striped table-hover" id="table-pembelian">
                      <thead>
                        <tr>
                          <th>Kode Produk</th>
                          <th>Nama Produk</th>
                          <th style="text-align: center;">Harga</th>
                          <th style="text-align: center;">Jumlah</th>
                          <th style="text-align: center;">Total</th>
                          <th style="text-align: center;" width="1%">OPSI</th>
                        </tr>
                      </thead>
                      <tbody> 
                        <?php 
                        $id_invoice = $i['invoice_id'];
                        $x_jumlah = 0;
                        $x_harga = 0;
                        $transaksi = mysqli_query($koneksi,"select * from transaksi,produk where produk_id=transaksi_produk and transaksi_invoice='$id_invoice'");
                        while($t = mysqli_fetch_array($transaksi)){
                          ?>

                          <tr id='tr_<?php echo $t['transaksi_produk'] ?>'>
                            <td> 
                              <input type='hidden' name='transaksi_produk[]' value='<?php echo $t['transaksi_produk'] ?>'> 
                              <input type='hidden' name='transaksi_harga[]' value='<?php echo $t['transaksi_harga'] ?>'> 
                              <input type='hidden' name='transaksi_jumlah[]' value='<?php echo $t['transaksi_jumlah'] ?>'> 
                              <input type='hidden' name='transaksi_total[]' value='<?php echo $t['transaksi_total'] ?>'>
                              <?php echo $t['produk_kode']; ?>
                            </td>
                            <td><?php echo $t['produk_nama']; ?></td>
                            <td align='center'><?php echo "Rp.".number_format($t['transaksi_harga']).",-"; ?></td>
                            <td align='center'><?php echo number_format($t['transaksi_jumlah']); ?></td>
                            <td align='center'><?php echo "Rp.".number_format($t['transaksi_total']).",-"; ?></td>
                            <td align='center'> 
                              <span class='btn btn-sm btn-danger tombol-hapus-penjualan' total='<?php echo $t['transaksi_total'] ?>' jumlah='<?php echo $t['transaksi_jumlah'] ?>' harga='<?php echo $t['transaksi_harga'] ?>' id='<?php echo $t['transaksi_produk'] ?>'><i class='fa fa-close'></i> Batal</span>
                            </td>
                          </tr>

                          <?php 
                          $x_jumlah+=$t['transaksi_jumlah'];
                          $x_harga+=$t['transaksi_harga'];
                        }
                        ?>

                      </tbody>
                      <tfoot>
                        <tr class="bg-info">
                          <td style="text-align: right;" colspan="2"><b>Total</b></td>
                          <td style="text-align: center;"><span class="pembelian_harga" id="<?php echo $x_harga ?>"><?php echo "Rp".number_format($x_harga).",-" ?></span></td>
                          <td style="text-align: center;"><span class="pembelian_jumlah" id="<?php echo $x_jumlah ?>"><?php echo number_format($x_jumlah) ?></span></td>
                          <td style="text-align: center;"><span class="pembelian_total" id="<?php echo $i['invoice_total'] ?>"><?php echo "Rp".number_format($i['invoice_total']).",-" ?></span></td>
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
                              <input type="hidden" name="sub_total" class="sub_total_form" value="<?php echo $i['invoice_sub_total']; ?>">
                              <span class="sub_total_pembelian" id="<?php echo $i['invoice_sub_total']; ?>"><?php echo "Rp.".number_format($i['invoice_sub_total']).",-"; ?></span>
                            </td>
                          </tr>
                          <tr>
                            <th>Diskon</th>
                            <td>
                              <div class="row">
                                <div class="col-lg-10">
                                  <input class="form-control total_diskon" type="number" min="0" max="100" id="<?php echo $i['invoice_diskon'] ?>" name="diskon" value="<?php echo $i['invoice_diskon'] ?>" required="required">
                                </div>
                                <div class="col-lg-2">%</div>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <th>Total Pembelian</th>
                            <td>
                              <input type="hidden" name="total" class="total_form" value="<?php echo $i['invoice_total']; ?>">
                              <span class="total_pembelian" id="<?php echo $i['invoice_total']; ?>"><?php echo "Rp.".number_format($i['invoice_total']).",-"; ?></span>
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
                  <a href="penjualan_edit.php?id=<?php echo $id; ?>" class="btn btn-danger"><i class="fa fa-close"></i> Reset</a>
                  <button class="btn btn-success pull-right"><i class="fa fa-check"></i> Simpan Perubahan</button>
                </div>

                <br>
                <br>

              </form>

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