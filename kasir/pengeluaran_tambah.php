<?php include 'header.php'; ?>

<?php 
    include "pengeluaran_act.php";
    $dataPengeluaran = getPengeluaranAll(); 

    if (isset($_POST['submit_pengeluaran'])) {
        $data['data'] = $_POST;
        $data['file'] = $_FILES['file_foto'];
        $tambah = tambahPengeluaran($data);
        if ($tambah == -1) {
            echo "
                <script>alert('Erorr! file yang di masukan bukan type gambar')</script>
            ";
        }else {
            $dataPengeluaran = getPengeluaranAll();
        }
    }

    if (isset($_POST['edit_pengeluaran'])) {
        $data['data'] = $_POST;
        $data['file'] = $_FILES['file_foto'];
        $tambah = editPengeluaran($data);
        if ($tambah == -1) {
            echo "
                <script>alert('Erorr! file yang di masukan bukan type gambar')</script>
            ";
        }else {
            $dataPengeluaran = getPengeluaranAll();
        }
    }

    if (isset($_GET['hapus'])) {
        if (delPengeluaran($_GET['hapus'])) {
            echo "
                <script>window.location.href = 'pengeluaran_tambah.php'</script>
            ";
        }else {
            echo "
                <script>alert('gagal menghapus data')</script>
            ";
        }
    }
?>

<div class="content-wrapper">

  <section class="content-header">
    <h1>
      Pengeluaran
      <small>Input Pengeluaran Baru</small>
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

            <form method="post" enctype="multipart/form-data">

                <div class="row" style="display: flex; align-items: center;">
                    <input type="hidden" name="kasir_id" value="<?php echo $_SESSION['id']; ?>">
                    
                    <div class="col-lg-3">
                        <div class="form-group">
                        <label>Tanggal</label>
                        <input type="date" class="form-control" name="tgl_pengeluaran" required value="<?= date("Y-m-d"); ?>">
                        </div>

                    </div>

                    <div class="col-lg-3">
                        <div class="form-group">
                        <label>Pengeluaran</label>
                        <input type="text" class="form-control" name="pengeluaran" required="required" placeholder="Masukan pengeluaran.. (wajib)">
                        </div>

                    </div>

                    <div class="col-lg-3">
                        <div class="form-group">
                        <label>Nominal</label>
                        <input type="text" class="form-control" name="nominal" required="required" placeholder="Nominal">
                        </div>

                    </div>

                    <div class="col-lg-3">
                        <div class="form-group">
                            <label>Foto (Optional)</label>
                            <input type="file" name="file_foto">
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <input type="submit" class="btn btn-primary" name="submit_pengeluaran" value="Submit">
                    </div>
                </div>
            </form>
            
            <hr>  

            <div class="col">

              <h3>Daftar Pengeluaran</h3>

              <table class="table table-bordered table-striped table-hover" id="table-pembelian">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Tanggal</th>
                    <th>Pengeluaran</th>
                    <th>Nominal</th>
                    <th style="text-align: center;">Foto</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody> 
                    <?php
                        $total = 0 ;
                        foreach($dataPengeluaran as $key => $data) : $total += $data['nominal']; ?>
                        <tr>
                            <td><?= ++$key; ?></td>
                            <td><?= date("d-m-Y", strtotime($data['tanggal'])); ?></td>
                            <td><?= $data['pengeluaran']; ?></td>
                            <td><?= "Rp.".number_format($data['nominal']); ?></td>
                            <td class="text-center">
                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#foto_<?php echo $data['id_pengeluaran'] ?>">
                                <i class="fa fa-image"></i> Lihat
                                </button>

                                <!-- modal hapus -->
                                <div class="modal fade" id="foto_<?php echo $data['id_pengeluaran'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">

                                        <center>
                                        <?php if($data['foto'] == ""){ ?>
                                            <img src="../gambar/sistem/produk.png" style="width: 100%;height: auto">
                                        <?php }else{ ?>
                                            <img src="../gambar/pengeluaran/<?= $data['foto']; ?>" style="width: 100% ;height: auto">
                                        <?php } ?>
                                        </center>

                                    </div>
                                    </div>
                                </div>
                                </div>
                            </td>
                            <td>
                                <a class="btn btn-success btn-sm" data-toggle="modal" data-target="#edit_pengeluaran_<?php echo $data['id_pengeluaran']; ?>"><i class="fa fa-cog"></i></a>
                                <a data-toggle="modal" data-target="#hapus_pengeluaran_<?php echo $data['id_pengeluaran']; ?>" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>

                                <!-- modal edit -->
                                <div class="modal fade" id="edit_pengeluaran_<?php echo $data['id_pengeluaran']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                                <h3 class="modal-title" id="exampleModalLabel">Edit pengeluaran</h5>
                                            </div>
                                            <div class="modal-body" style="padding: 30px;">
                                                <?php
                                                    $item = getPengeluaranByItemID($data['id_pengeluaran']);
                                                ?>
                                                 <form method="post" enctype="multipart/form-data">
                                                    <div class="row">
                                                        <input type="hidden" name="id_pengeluaran" value="<?= $item['id_pengeluaran']; ?>">
                                                        <input type="hidden" name="foto" value="<?= $item['foto']; ?>">
                                                        
                                                        <?php if($item['foto']) : ?>
                                                            <img src="../gambar/pengeluaran/<?= $item['foto']; ?>" style="max-width: 150px; max-height: 150px;">
                                                        <?php else : ?>
                                                            <img src="../gambar/sistem/produk.png" style="max-width: 150px; max-height: 150px;">
                                                        <?php endif; ?>

                                                        <div style="margin-top: 20px;">
                                                            <div class="form-group">
                                                            <label>Tanggal</label>
                                                            <input type="date" class="form-control" name="tgl_pengeluaran" required value="<?= $item['tanggal']; ?>">
                                                            </div>

                                                        </div>

                                                        <div>
                                                            <div class="form-group">
                                                            <label>Pengeluaran</label>
                                                            <input type="text" class="form-control" name="pengeluaran" required="required" value="<?= $item['pengeluaran']; ?>">
                                                            </div>

                                                        </div>
                                                        <div>
                                                            <div class="form-group">
                                                            <label>Nominal</label>
                                                            <input id="nominal<?= $item['id_pengeluaran']; ?>" type="text" class="form-control" name="nominal" required="required" value="<?= $item['nominal']; ?>">
                                                            </div>

                                                            <script>
                                                                new AutoNumeric(`input#nominal<?= $item['id_pengeluaran']; ?>`, {
                                                                    currencySymbol : 'Rp.',
                                                                    decimalCharacter : ',',
                                                                    digitGroupSeparator : '.'
                                                                })
                                                            </script>
                                                        </div>

                                                        <div>
                                                            <div class="form-group">
                                                                <label>Foto (Optional)</label>
                                                                <input type="file" name="file_foto">
                                                            </div>
                                                        </div>

                                                        <div class="mt-4">
                                                            <input type="submit" class="btn btn-success" name="edit_pengeluaran" value="Submit">
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- modal hapus -->
                                <div class="modal fade" id="hapus_pengeluaran_<?php echo $data['id_pengeluaran']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Peringatan!</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            </div>
                                            <div class="modal-body">

                                            <p>Yakin ingin menghapusnya?</p>

                                            </div>
                                            <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                            <a class="btn btn-danger btn-sm" href="?hapus=<?php echo $data['id_pengeluaran']; ?>"><i class="fa fa-check"></i> Ya, Hapus</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-right"><b>TOTAL</b></td>
                        <td colspan="" class="text-cenr"><b><?= "Rp.".number_format($total); ?></b></td>
                    </tr>
                </tfoot>
              </table>

            </div>
          </div>
      </div>

    </div>
    </section>
   </div>
  </section>

</div>

<script>
    new AutoNumeric("input[name='nominal']", {
      currencySymbol : 'Rp.',
      decimalCharacter : ',',
      digitGroupSeparator : '.'
  })

</script>

<?php include 'footer.php'; ?>