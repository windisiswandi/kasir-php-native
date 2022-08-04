<?php 
include 'header.php';
include '../koneksi.php';
?>

<div class="content-wrapper">

  <section class="content-header">
    <h1>
      Pimpinan
      <small>Edit Pimpinan</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Pimpinan</li>
    </ol>
  </section>

  <section class="content">
    <div class="row">
      <section class="col-lg-6 col-lg-offset-3">       
        <div class="box box-info">

          <div class="box-header">
            <h3 class="box-title">Edit Pimpinan</h3>
            <a href="pimpinan.php" class="btn btn-primary btn-sm pull-right"><i class="fa fa-reply"></i> &nbsp; Kembali</a> 
          </div>
          <div class="box-body">
            <form action="pimpinan_update.php" method="post" enctype="multipart/form-data">
              <?php 
              $id = $_GET['id'];              
              $data = mysqli_query($koneksi, "select * from pimpinan where pimpinan_id='$id'");
              while($d = mysqli_fetch_array($data)){
                ?>

                <div class="form-group">
                  <label>Nama</label>
                  <input type="text" class="form-control" name="nama" value="<?php echo $d['pimpinan_nama'] ?>" required="required">
                  <input type="hidden" class="form-control" name="id" value="<?php echo $d['pimpinan_id'] ?>" required="required">
                </div>

                <div class="form-group">
                  <label>Username</label>
                  <input type="text" class="form-control" name="username" value="<?php echo $d['pimpinan_username'] ?>" required="required">
                </div>

                <div class="form-group">
                  <label>Password</label>
                  <input type="password" class="form-control" name="password" min="5" placeholder="Kosong Jika tidak ingin di ganti">
                  <p>Kosong Jika tidak ingin di ganti</p>
                </div>

                <div class="form-group">
                  <label>Foto</label>
                  <input type="file" name="foto">
                  <p>Kosong Jika tidak ingin di ganti</p>
                </div>

                <div class="form-group">
                  <input type="submit" class="btn btn-sm btn-primary" value="Simpan">
                </div>
                <?php
              }

              ?>
              
            </form>
          </div>

        </div>
      </section>
    </div>
  </section>

</div>
<?php include 'footer.php'; ?>