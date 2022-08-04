<?php include 'header.php'; ?>

<div class="content-wrapper">

  <section class="content-header">
    <h1>
      Produk
      <small>Edit Produk</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li>Produk</li>
    </ol>
  </section>

  <section class="content">
    <div class="row">
      <section class="col-lg-8 col-lg-offset-2">       
        <div class="box box-info">

          <div class="box-header">
            <h3 class="box-title">Edit Produk</h3>
            <a href="produk.php" class="btn btn-primary btn-sm pull-right"><i class="fa fa-reply"></i> &nbsp Kembali</a> 
          </div>

          <div class="box-body">

           <?php 
           if(isset($_GET['alert'])){
            if($_GET['alert'] == "gagal"){
              echo "<div class='alert alert-danger'>File yang diperbolehkan hanya file gambar!</div>";
            }elseif($_GET['alert'] == "duplikat"){
              echo "<div class='alert alert-danger'><b>Kode Barang</b> sudah pernah digunakan!</div>";
            }
          }
          ?>
          <?php 
          $id = $_GET['id'];              
          $data = mysqli_query($koneksi, "select * from produk where produk_id='$id'");
          while($d = mysqli_fetch_array($data)){
            ?>

            <form action="produk_update.php" method="post" enctype="multipart/form-data">
              <input type="hidden" name="file_foto" value="<?= $d['produk_foto'] ?>">
              <div class="row">
                <div class="form-group col-lg-4">
                  <label>Kode Produk</label>
                  <input type="hidden" class="form-control" name="id" value="<?php echo $d['produk_id']; ?>">
                  <input type="text" class="form-control" name="kode" required="required" placeholder="Masukkan Kode Produk .. (Wajib)" value="<?php echo $d['produk_kode']; ?>" readonly>
                </div>
              </div>

              <div class="form-group">
                <label>Nama Produk</label>
                <input type="text" class="form-control" name="nama" required="required" placeholder="Masukkan Nama Produk .. (Wajib)" value="<?php echo $d['produk_nama']; ?>">
              </div>

              <div class="row">
                <div class="form-group col-lg-4">
                  <label>Satuan</label>
                  <input type="text" class="form-control" name="satuan" required="required" placeholder="Contoh: Kg, Klg, Pack, dll .. (Wajib)" value="<?php echo $d['produk_satuan']; ?>">
                </div>

                <div class="form-group col-lg-4">
                  <label>Kategori</label>
                  <select name="kategori" class="form-control" required="required">
                    <option value="">- Pilih -</option>
                    <?php 
                    $kategori = mysqli_query($koneksi,"SELECT * FROM kategori ORDER BY kategori ASC");
                    while($k = mysqli_fetch_array($kategori)){
                      ?>
                      <option <?php if($d['produk_kategori'] == $k['kategori_id']){echo "selected='selected'";} ?> value="<?php echo $k['kategori_id']; ?>"><?php echo $k['kategori']; ?></option>
                      <?php 
                    }
                    ?>
                  </select>
                </div>

                <div class="form-group col-lg-4">
                  <label>Stok</label>
                  <input type="number" class="form-control" name="stok" required="required" placeholder="Masukkan Jumlah Stok .. (Wajib)" value="<?php echo $d['produk_stok']; ?>">
                </div>

              </div>



              <div class="row">
                <div class="form-group col-lg-4">
                  <label>Harga Modal</label>
                  <input type="number" class="form-control" name="harga_modal" required="required" placeholder="Harga Modal .. (Wajib)" value="<?php echo $d['produk_harga_modal']; ?>">
                </div>

                <div class="form-group col-lg-4">
                  <label>Harga Jual</label>
                  <input type="number" class="form-control" name="harga_jual" required="required" placeholder="Harga Jual .. (Wajib)" value="<?php echo $d['produk_harga_jual']; ?>">
                </div>

                <div class="form-group col-lg-4">
                  <label>Peringatan Kwantitas</label>
                  <input type="number" class="form-control" name="kwantitas" value="<?php echo $d['produk_kwantitas']; ?>" placeholder="Default 5">
                </div>
              </div>

              <div class="form-group">
                <label>Keterangan</label>
                <textarea class="form-control" name="keterangan" placeholder="Masukkan Keterangan Produk .. (Opsional)"><?php echo $d['produk_keterangan']; ?></textarea>
              </div>

              <div class="form-group">
                <label>Foto <small><i>Opsional</i></small></label>
                <input type="file" name="foto">
                <small class="text-muted"><i>Kosongkan jika tidak ingin diganti.</i></small>
              </div>

              <div class="form-group pull-right">
                <input type="submit" class="btn btn-sm btn-primary" value="Simpan">
              </div>
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