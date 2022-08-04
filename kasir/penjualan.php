<?php include 'header.php'; ?>

<div class="content-wrapper">

  <section class="content-header">
    <h1>
      Penjualan
      <small>Data Penjualan</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Penjualan</li>
    </ol>
  </section>

  <section class="content">

    <a href="penjualan.php" class="btn btn-sm btn-primary"><i class="fa fa-file"></i> &nbsp; DATA PENJUALAN</a>
    <a href="penjualan_tambah.php" class="btn btn-sm btn-primary"> <i class="fa fa-plus"></i> &nbsp; INPUT PENJUALAN</a>

    <br>
    <br>

    <div class="row">
      <section class="col-lg-12">
        <div class="box box-info">

          <div class="box-header">
            <h3 class="box-title">Transaksi Penjualan Yang Saya Layani</h3>
          </div>
          <div class="box-body">


            <?php 
            if(isset($_GET['alert'])){
              if($_GET['alert'] == "sukses"){
                echo "<div class='alert alert-success text-center'>Transaksi berhasil tersimpan!</div>";
              }elseif($_GET['alert'] == "hapus"){
                echo "<div class='alert alert-success text-center'>Penjualan telah dihapus!</div>";
              }elseif($_GET['alert'] == "update"){
                echo "<div class='alert alert-success text-center'>Penjualan telah diupdate!</div>";
              }
              

            }
            ?>

            <div class="table-responsive">
              <table class="table table-bordered table-striped" id="table-datatable">
                <thead>
                  <tr>
                    <th width="1%">NO</th>
                    <th width="10%" class="text-center">NOMOR</th>
                    <th class="text-center">TANGGAL</th>
                    <th class="text-center">PELANGGAN</th>
                    <th class="text-center">KASIR</th>
                    <th class="text-center">SUB TOTAL</th>
                    <th class="text-center">DISKON</th>
                    <th class="text-center">TOTAL BAYAR</th>
                    <th width="13%" class="text-center">OPSI</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                  $no=1;
                  $id_kasir = $_SESSION['id'];
                  $data = mysqli_query($koneksi,"SELECT * FROM invoice,kasir where kasir_id=invoice_kasir and invoice_kasir='$id_kasir' order by invoice_id desc");
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
                      <td>    

                        <div class="btn-group">


                          <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#detail_pembelian_<?php echo $d['invoice_id'] ?>">
                            <i class="fa fa-search"></i>
                          </button>

                          <a target="_blank" href="penjualan_print.php?id=<?php echo $d['invoice_id']; ?>" class="btn btn-success btn-sm"><i class="fa fa-file"></i></a>
                          
                          <a href="penjualan_edit.php?id=<?php echo $d['invoice_id']; ?>" class="btn btn-warning btn-sm"><i class="fa fa-cog"></i></a>

                          <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#hapus_penjualan_<?php echo $d['invoice_id'] ?>">
                            <i class="fa fa-trash"></i>
                          </button>

                        </div>

                       
                        <div class="modal fade" id="detail_pembelian_<?php echo $d['invoice_id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                                <h4 class="modal-title" id="exampleModalLabel">Detail Penjualan</h4>
                              </div>
                              <div class="modal-body">

                                <div class="row">

                                  <div class="col-lg-12">
                                   <label>Kasir yang melayani</label>
                                   <br>
                                   <?php echo $d['kasir_nama']; ?>
                                 </div>

                                 <br>
                                 <br>
                                 <br>

                                 <div class="col-lg-4">

                                  <div class="form-group">
                                    <label>No. Invoice</label>
                                    <br>
                                    <?php echo $d['invoice_nomor']; ?>
                                  </div>

                                </div>
                                <div class="col-lg-4">

                                  <div class="form-group">
                                    <label>Tanggal Invoice</label>
                                    <br>
                                    <?php echo date('d-m-Y', strtotime($d['invoice_tanggal'])); ?>
                                  </div>

                                </div>
                                <div class="col-lg-4">

                                  <div class="form-group">
                                    <label>Pelanggan</label>
                                    <br>
                                    <?php echo $d['invoice_pelanggan']; ?>
                                  </div>

                                </div>

                              </div>

                              <hr>  

                              <b>Daftar Pembelian</b>

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
                                  $i = 1;
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
                                      <th width="50%">Sub Total</th>
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



                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            </div>
                          </div>
                        </div>
                      </div>




                      <!-- modal hapus -->
                      <div class="modal fade" id="hapus_penjualan_<?php echo $d['invoice_id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                              <h4 class="modal-title" id="exampleModalLabel">Peringatan!</h4>
                            </div>
                            <div class="modal-body">

                              <p>Yakin ingin menghapus data ini ?</p>
                              <p>Stok produk akan dikembalikan dan data yang terhubung juga akan ikut dihapus.</p>

                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                              <a href="penjualan_hapus.php?id=<?php echo $d['invoice_id'] ?>" class="btn btn-primary">Hapus</a>
                            </div>
                          </div>
                        </div>
                      </div>

                    </td>
                  </tr>
                  <?php 
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </section>
    </div>
</section>

</div>
<?php include 'footer.php'; ?>