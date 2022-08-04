<?php include 'header.php'; ?>

<div class="content-wrapper">

  <section class="content-header">
    <h1>
      LAPORAN 
      <small>Stok Barang</small>
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
            <h3 class="box-title">Data Stok Barang</h3>
          </div>
          <div class="box-body">
            <a href="laporan_stok_barang_print.php" target="_blank" class="btn btn-sm btn-primary"><i class="fa fa-print"></i> &nbsp PRINT</a>
            <div class="table-responsive">
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
                          <td><?php echo $no++; ?></td>
                          <td><?php echo $d['produk_kode']; ?></td>
                          <td><?php echo $d['produk_nama']; ?></td>
                          <td><?php echo $d['kategori']; ?></td>
                          <td><?php echo $d['produk_stok']; ?></td>
                          <td><?php echo "Rp.".number_format($d['produk_harga_modal']).",-"; ?></td>
                          <td><?php echo "Rp.".number_format($d['produk_harga_jual']).",-"; ?></td>
                      </tr>
                      <?php 
                    }
                    ?>
                  </tbody>
                </table>
            </div>
          </div>
        </div>
      </section>
    </div>
  </section>

</div>
<?php include 'footer.php'; ?>