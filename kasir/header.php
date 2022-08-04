<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Aplikasi POS (Point of Sale)</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="../assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../assets/bower_components/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="../assets/bower_components/Ionicons/css/ionicons.min.css">
  <link rel="stylesheet" href="../assets/dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="../assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" href="../assets/dist/css/skins/_all-skins.min.css">
  <link rel="stylesheet" href="../assets/bower_components/morris.js/morris.css">
  <link rel="stylesheet" href="../assets/bower_components/jvectormap/jquery-jvectormap.css">
  <link rel="stylesheet" href="../assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <link rel="stylesheet" href="../assets/bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <link rel="stylesheet" href="../assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

  <script src="../assets/dist/js/autoNumeric.min.js"></script>

  <?php 
  include '../koneksi.php';
  date_default_timezone_set('Asia/Jakarta');
  session_start();
  if($_SESSION['status'] != "kasir_logedin"){
    header("location:../index.php?alert=belum_login");
  }
  ?>

</head>
<body class="hold-transition skin-green layout-top-nav">

  <style>
    #table-datatable {
      width: 100% !important;
    }
    #table-datatable .sorting_disabled{
      border: 1px solid #f4f4f4;
    }
    .dropdown-menu > li > a {
      padding: 8px 20px;
    }

    input[type="date"].form-control, input[type="time"].form-control, input[type="datetime-local"].form-control, input[type="month"].form-control {
      line-height: 15px;
    }
      
  </style>

  <div class="wrapper">

    <header class="main-header">
      <nav class="navbar navbar-static-top">
        <div class="container-fluid">

          <div class="navbar-header">
            <a href="index.php" class="navbar-brand"><b>JARINGANKU STORE</b></a>
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
              <i class="fa fa-bars"></i>
            </button>
          </div>

          <div class="collapse navbar-collapse pull-left" id="navbar-collapse">

            <ul class="nav navbar-nav">

              <li class="active">
                <a href="index.php">
                  <i class="fa fa-home"></i> &nbsp; <span>DASHBOARD</span> <span class="sr-only">(current)</span>
                </a>
              </li>

              <li>
                <a href="produk.php">
                  <i class="fa fa-folder"></i> &nbsp; <span>PRODUK</span>
                </a>
              </li>

              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-shopping-cart"></i> &nbsp; TRANSAKSI<span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                  <li>
                    <a href="pengeluaran_tambah.php">
                      <i class="fa fa-folder"></i> <span> INPUT PENGELUARAN</span>
                    </a>
                  </li>
                  <li>
                    <a href="penjualan_tambah.php">
                      <i class="fa fa-folder"></i> <span> INPUT PENJUALAN</span>
                    </a>
                  </li>

                  <li>
                    <a href="penjualan.php">
                      <i class="fa fa-folder"></i> <span> DATA PENJUALAN</span>
                    </a>
                  </li>
                </ul>
              </li>


              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                  <i class="fa fa-file"></i> &nbsp; LAPORAN <span class="caret"></span></a>
                  <ul class="dropdown-menu" role="menu">
                    <li>
                      <a href="laporan_pengeluaran_kasir.php">
                        <i class="fa fa-folder"></i> <span> Laporan pengeluaran kasir</span>
                      </a>
                    </li>
                    <li>
                      <a href="laporan_per_produk.php">
                        <i class="fa fa-folder"></i> <span> Laporan penjualan (per produk)</span>
                      </a>
                    </li>
                    <li>
                      <a href="laporan.php">
                        <i class="fa fa-folder"></i> <span> Laporan penjualan (per invoice)</span>
                      </a>
                    </li>

                    <li>
                      <a href="laporan_stok_barang.php">
                        <i class="fa fa-folder"></i> <span>Laporan Stok Barang</span>
                      </a>
                    </li>
                  </ul>
              </li>

              <li>
                <a href="gantipassword.php">
                  <i class="fa fa-lock"></i> &nbsp; <span>GANTI PASSWORD</span>
                </a>
              </li>

            </ul>


          </div>

          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">

              <?php 
              $limit = mysqli_query($koneksi,"select * from produk where produk_stok<=produk.produk_kwantitas");
              $jumlah_limit = mysqli_num_rows($limit);
              ?>
              <li class="dropdown notifications-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-bell-o"></i>
                  <span class="label label-danger"><?php echo $jumlah_limit; ?></span>
                </a>
                <ul class="dropdown-menu">
                  <li class="header text-center">Ada <b><?php echo $jumlah_limit; ?></b> produk yang hampir habis.</li>
                  <li>
                    <ul class="menu">
                      <?php 
                      while($l = mysqli_fetch_array($limit)){ ?>
                        <li>
                          <a href="produk.php">
                            <i class="fa fa-archive text-red"></i> <b><?php echo $l['produk_nama'] ?></b> <span class="pull-right">tersisa <b><?php echo $l['produk_stok']; ?></b></span>
                          </a>
                        </li>
                      <?php } ?>
                    </ul>
                  </li>
                  <li class="footer"><a href="produk.php">Lihat stok produk</a></li>
                </ul>
              </li>

              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <?php 
                  $id_kasir = $_SESSION['id'];
                  $profil = mysqli_query($koneksi,"select * from kasir where kasir_id='$id_kasir'");
                  $profil = mysqli_fetch_assoc($profil);
                  if($profil['kasir_foto'] == ""){ 
                    ?>
                    <img src="../gambar/sistem/kasir.png" class="user-image">
                  <?php }else{ ?>
                    <img src="../gambar/kasir/<?php echo $profil['kasir_foto']; ?>" class="user-image">
                  <?php } ?>
                  <span class="hidden-xs"><?php echo $_SESSION['nama']; ?> - KASIR</span>
                </a>

              </li>

              <li>
                <a href="logout.php">
                  <i class="fa fa-sign-out"></i> <span>LOGOUT</span>
                </a>
              </li>

            </ul>
          </div>
        </div>
      </nav>

    </header>