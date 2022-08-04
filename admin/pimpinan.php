<?php include 'header.php'; ?>

<div class="content-wrapper">

  <section class="content-header">
    <h1>
      Pimpinan
      <small>Data Pimpinan</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Pimpinan</li>
    </ol>
  </section>

  <section class="content">
    <div class="row">
      <section class="col-lg-10 col-lg-offset-1">
        <div class="box box-info">

          <div class="box-header">
            <h3 class="box-title">Pimpinan</h3>
          </div>
          <div class="box-body">
            <div class="table-responsive">
              <table class="table table-bordered table-striped" id="table-datatable">
                <thead>
                  <tr>
                    <th width="1%">NO</th>
                    <th>NAMA</th>
                    <th>USERNAME</th>
                    <th width="15%">FOTO</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                  include '../koneksi.php';
                  $no=1;
                  $data = mysqli_query($koneksi,"SELECT * FROM pimpinan");
                  while($d = mysqli_fetch_array($data)){
                    ?>
                    <tr>
                      <td><?php echo $no++; ?></td>
                      <td><?php echo $d['pimpinan_nama']; ?></td>
                      <td><?php echo $d['pimpinan_username']; ?></td>
                      <td>
                        <center>
                          <?php if($d['pimpinan_foto'] == ""){ ?>
                            <img src="../gambar/sistem/pimpinan.png" style="width: 80px;height: auto">
                          <?php }else{ ?>
                            <img src="../gambar/pimpinan/<?php echo $d['pimpinan_foto'] ?>" style="width: 80px;height: auto">
                          <?php } ?>
                        </center>
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
      </section>
    </div>
  </section>

</div>
<?php include 'footer.php'; ?>