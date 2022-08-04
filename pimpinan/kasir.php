<?php include 'header.php'; ?>

<div class="content-wrapper">

  <section class="content-header">
    <h1>
      Kasir
      <small>Data Kasir</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Kasir</li>
    </ol>
  </section>

  <section class="content">
    <div class="row">
      <section class="col-lg-10 col-lg-offset-1">
        <div class="box box-info">

          <div class="box-header">
            <h3 class="box-title">Kasir</h3>
            <a href="kasir_tambah.php" class="btn btn-primary btn-sm pull-right"><i class="fa fa-plus"></i> &nbsp Tambah Kasir Baru</a>              
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
                    <th width="10%">OPSI</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                  include '../koneksi.php';
                  $no=1;
                  $data = mysqli_query($koneksi,"SELECT * FROM kasir");
                  while($d = mysqli_fetch_array($data)){
                    ?>
                    <tr>
                      <td><?php echo $no++; ?></td>
                      <td><?php echo $d['kasir_nama']; ?></td>
                      <td><?php echo $d['kasir_username']; ?></td>
                      <td>
                        <center>
                          <?php if($d['kasir_foto'] == ""){ ?>
                            <img src="../gambar/sistem/kasir.png" style="width: 80px;height: auto">
                          <?php }else{ ?>
                            <img src="../gambar/kasir/<?php echo $d['kasir_foto'] ?>" style="width: 80px;height: auto">
                          <?php } ?>
                        </center>
                      </td>
                      <td>                        
                        <a class="btn btn-warning btn-sm" href="kasir_edit.php?id=<?php echo $d['kasir_id'] ?>"><i class="fa fa-cog"></i></a>
                        <a class="btn btn-danger btn-sm" href="kasir_hapus.php?id=<?php echo $d['kasir_id'] ?>" onclick="return confirm('Yakin ingin menghapus kasir ini?')"><i class="fa fa-trash"></i></a>
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