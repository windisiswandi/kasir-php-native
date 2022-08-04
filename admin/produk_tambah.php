<?php include 'header.php'; ?>

<div class="content-wrapper">

  <section class="content-header">
    <h1>
      Produk
      <small>Tambah Produk Baru</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Produk</li>
    </ol>
  </section>

  <section class="content">
    <div class="row">
      <section class="col-lg-8 col-lg-offset-2">       
        <div class="box box-info">

          <div class="box-header">
            <h3 class="box-title">Tambah Produk</h3>
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


          <form action="produk_act.php" method="post" enctype="multipart/form-data">

            <div class="row">
              <div class="form-group col-lg-4">
                <label>Kode Produk</label>
                <?php 
                // mencari kode barang dengan nilai paling besar
                $hasil = mysqli_query($koneksi,"SELECT max(produk_kode) as maxKode FROM produk");
                $kp = mysqli_fetch_array($hasil);
                $kodeProduk = $kp['maxKode'];
                // echo $kodeProduk;
                // mengambil angka atau bilangan dalam kode produk terbesar,
                // dengan cara mengambil substring mulai dari karakter ke-1 diambil 6 karakter
                // misal 'BRG001', akan diambil '001'
                // setelah substring bilangan diambil lantas dicasting menjadi integer
                $noUrut = substr($kodeProduk, 4, 4);
                // bilangan yang diambil ini ditambah 1 untuk menentukan nomor urut berikutnya
                $noUrut++;

                // membentuk kode produk baru
                // perintah sprintf("%03s", $noUrut); digunakan untuk memformat string sebanyak 3 karakter
                // misal sprintf("%03s", 12); maka akan dihasilkan '012'
                // atau misal sprintf("%03s", 1); maka akan dihasilkan string '001'
                $char = "PROD";
                $kodeProduk = $char . sprintf("%04s", $noUrut);
                ?>
                <input type="text" class="form-control" name="kode" required="required" placeholder="Masukkan Kode Produk .. (Wajib)" value="<?php echo $kodeProduk; ?>" readonly>
              </div>
            </div>

            <div class="form-group">
              <label>Nama Produk</label>
              <input type="text" class="form-control" name="nama" required="required" placeholder="Masukkan Nama Produk .. (Wajib)">
            </div>

            <div class="row">
              <div class="form-group col-lg-4">
                <label>Satuan</label>
                <input type="text" class="form-control" name="satuan" required="required" placeholder="Contoh: Kg, Klg, Pack, dll .. (Wajib)">
              </div>

              <div class="form-group col-lg-4">
                <label>Kategori</label>
                <select name="kategori" class="form-control" required="required">
                  <option value="">- Pilih -</option>
                  <?php 
                  $kategori = mysqli_query($koneksi,"SELECT * FROM kategori ORDER BY kategori ASC");
                  while($k = mysqli_fetch_array($kategori)){
                    ?>
                    <option value="<?php echo $k['kategori_id']; ?>"><?php echo $k['kategori']; ?></option>
                    <?php 
                  }
                  ?>
                </select>
              </div>

              <div class="form-group col-lg-4">
                <label>Stok</label>
                <input type="number" class="form-control" name="stok" required="required" placeholder="Masukkan Jumlah Stok .. (Wajib)">
              </div>

            </div>



            <div class="row">
              <div class="form-group col-lg-4">
                <label>Harga Modal</label>
                <input type="text" class="form-control" name="harga_modal" required="required" placeholder="Harga Modal .. (Wajib)">
              </div>

              <div class="form-group col-lg-4">
                <label>Harga Jual</label>
                <input type="text" class="form-control" name="harga_jual" required="required" placeholder="Harga Jual .. (Wajib)">
              </div>

              <div class="form-group col-lg-4">
                <label>Peringatan Kwantitas</label>
                <input type="number" class="form-control" name="kwantitas" value="5" placeholder="Default 5">
              </div>
            </div>

            <div class="form-group">
              <label>Keterangan</label>
              <textarea class="form-control" name="keterangan" placeholder="Masukkan Keterangan Produk .. (Opsional)"></textarea>
            </div>

            <div class="form-group">
              <label>Foto <small><i>Opsional</i></small></label>
              <input type="file" name="foto">

            </div>

            <div class="form-group pull-right">
              <input type="submit" class="btn btn-sm btn-primary" value="Simpan">
            </div>
          </form>
        </div>

      </div>
    </section>
  </div>
</section>

<script>
  new AutoNumeric("input[name='harga_modal']", {
      currencySymbol : 'Rp.',
      decimalCharacter : ',',
      digitGroupSeparator : '.'
  })
  new AutoNumeric("input[name='harga_jual']", {
      currencySymbol : 'Rp.',
      decimalCharacter : ',',
      digitGroupSeparator : '.'
  })

</script>

</div>
<?php include 'footer.php'; ?>