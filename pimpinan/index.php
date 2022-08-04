<?php include 'header.php'; ?>

<div class="content-wrapper">

  <section class="content-header">
    <h1>
      Dashboard
      <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Dashboard</li>
    </ol>
  </section>

  <section class="content">

    <div class="row">

      <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-red">
          <div class="inner">
            <?php 
            $tanggal = date('Y-m-d');
            $penjualan = mysqli_query($koneksi,"SELECT sum(invoice_total) as total_invoice FROM invoice WHERE invoice_tanggal='$tanggal'");
            $p = mysqli_fetch_assoc($penjualan);
            ?>
            <h4 style="font-weight: bolder"><?php echo "Rp. ".number_format($p['total_invoice'])." ,-" ?></h4>
            <p>Penjualan Hari Ini</p>
          </div>
          <div class="icon">
            <i class="ion ion-stats-bars"></i>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-blue">
          <div class="inner">
            <?php 
            $bulan = date('m');
            $penjualan = mysqli_query($koneksi,"SELECT sum(invoice_total) as total FROM invoice WHERE month(invoice_tanggal)='$bulan'");
            $p = mysqli_fetch_assoc($penjualan);
            ?>
            <h4 style="font-weight: bolder"><?php echo "Rp. ".number_format($p['total'])." ,-" ?></h4>
            <p>Penjualan Bulan Ini</p>
          </div>
          <div class="icon">
            <i class="ion ion-stats-bars"></i>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-yellow">
          <div class="inner">
            <?php 
            $tahun = date('Y');
            $penjualan = mysqli_query($koneksi,"SELECT sum(invoice_total) as total FROM invoice WHERE year(invoice_tanggal)='$tahun'");
            $p = mysqli_fetch_assoc($penjualan);
            ?>
            <h4 style="font-weight: bolder"><?php echo "Rp. ".number_format($p['total'])." ,-" ?></h4>
            <p>Penjualan Tahun Ini</p>
          </div>
          <div class="icon">
            <i class="ion ion-stats-bars"></i>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-black">
          <div class="inner">
            <?php 
            $penjualan = mysqli_query($koneksi,"SELECT sum(invoice_total) as total FROM invoice");
            $p = mysqli_fetch_assoc($penjualan);
            ?>
            <h4 style="font-weight: bolder"><?php echo "Rp. ".number_format($p['total'])." ,-" ?></h4>
            <p>Total Seluruh Penjualan</p>
          </div>
          <div class="icon">
            <i class="ion ion-stats-bars"></i>
          </div>
        </div>
      </div>


      <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-red">
          <div class="inner">
            <?php 
            $hari_ini = date('Y-m-d');
            $total_modal = 0;
            $modal = mysqli_query($koneksi,"SELECT * FROM invoice,transaksi,produk where invoice_id=transaksi_invoice and transaksi_produk=produk_id and invoice_tanggal='$hari_ini'");
            while($l = mysqli_fetch_array($modal)){
              $m = $l['produk_harga_modal'] * $l['transaksi_jumlah'];
              $total_modal += $m;
            }

            $total_penjualan = 0;
            $penjualan = mysqli_query($koneksi,"SELECT sum(invoice_total) as total_penjualan FROM invoice where invoice_tanggal='$hari_ini'");
            $p = mysqli_fetch_assoc($penjualan);
            $total_penjualan = $p['total_penjualan'];

            $laba = $total_penjualan-$total_modal;
            ?>

            <h4 style="font-weight: bolder"><?php echo "Rp.".number_format($laba).",-" ?></h4>
            <p>Laba Hari Ini</p>
          </div>
          <div class="icon">
            <i class="ion ion-stats-bars"></i>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-blue">
          <div class="inner">
            <?php 
            $bulan_ini = date('m');
            $total_modal = 0;
            $modal = mysqli_query($koneksi,"SELECT * FROM invoice,transaksi,produk where invoice_id=transaksi_invoice and transaksi_produk=produk_id and month(invoice_tanggal)='$bulan_ini'");
            while($l = mysqli_fetch_array($modal)){
              $m = $l['produk_harga_modal'] * $l['transaksi_jumlah'];
              $total_modal += $m;
            }

            $total_penjualan = 0;
            $penjualan = mysqli_query($koneksi,"SELECT sum(invoice_total) as total_penjualan FROM invoice where month(invoice_tanggal)='$bulan_ini'");
            $p = mysqli_fetch_assoc($penjualan);
            $total_penjualan = $p['total_penjualan'];

            $laba = $total_penjualan-$total_modal;
            ?>

            <h4 style="font-weight: bolder"><?php echo "Rp.".number_format($laba).",-" ?></h4>
            <p>Laba Bulan Ini</p>
          </div>
          <div class="icon">
            <i class="ion ion-stats-bars"></i>
          </div>
        </div>
      </div>


      <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-yellow">
          <div class="inner">
            <?php 
            $tahun_ini = date('Y');
            $total_modal = 0;
            $modal = mysqli_query($koneksi,"SELECT * FROM invoice,transaksi,produk where invoice_id=transaksi_invoice and transaksi_produk=produk_id and year(invoice_tanggal)='$tahun_ini'");
            while($l = mysqli_fetch_array($modal)){
              $m = $l['produk_harga_modal'] * $l['transaksi_jumlah'];
              $total_modal += $m;
            }

            $total_penjualan = 0;
            $penjualan = mysqli_query($koneksi,"SELECT sum(invoice_total) as total_penjualan FROM invoice where year(invoice_tanggal)='$tahun_ini'");
            $p = mysqli_fetch_assoc($penjualan);
            $total_penjualan = $p['total_penjualan'];

            $laba = $total_penjualan-$total_modal;
            ?>

            <h4 style="font-weight: bolder"><?php echo "Rp.".number_format($laba).",-" ?></h4>
            <p>Laba Tahun Ini</p>
          </div>
          <div class="icon">
            <i class="ion ion-stats-bars"></i>
          </div>
        </div>
      </div>





      <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-black">
          <div class="inner">
            <?php 
            $total_modal = 0;
            $modal = mysqli_query($koneksi,"SELECT * FROM invoice,transaksi,produk where invoice_id=transaksi_invoice and transaksi_produk=produk_id");
            while($l = mysqli_fetch_array($modal)){
              $m = $l['produk_harga_modal'] * $l['transaksi_jumlah'];
              $total_modal += $m;
            }

            $total_penjualan = 0;
            $penjualan = mysqli_query($koneksi,"SELECT sum(invoice_total) as total_penjualan FROM invoice");
            $p = mysqli_fetch_assoc($penjualan);
            $total_penjualan = $p['total_penjualan'];

            $laba = $total_penjualan-$total_modal;
            ?>
            <h4 style="font-weight: bolder"><?php echo "Rp.".number_format($laba).",-" ?></h4>
            <p>Total Seluruh Laba</p>
          </div>
          <div class="icon">
            <i class="ion ion-stats-bars"></i>
          </div>
        </div>
      </div>





    </div>




    <div class="row">
      <div class="col-lg-2 col-xs-6">
        <div class="small-box bg-green">
          <div class="inner">
            <?php 
            $produk = mysqli_query($koneksi,"SELECT * from produk");
            $p = mysqli_num_rows($produk);
            ?>
            <h4 style="font-weight: bolder"><?php echo $p ?></h4>
            <p>Jumlah Produk</p>
          </div>
          <div class="icon">
            <i class="ion ion-stats-bars"></i>
          </div>
        </div>
      </div>

      <div class="col-lg-2 col-xs-6">
        <div class="small-box bg-green">
          <div class="inner">
            <?php 
            $kategori = mysqli_query($koneksi,"SELECT * from kategori");
            $k = mysqli_num_rows($kategori);
            ?>
            <h4 style="font-weight: bolder"><?php echo $k ?></h4>
            <p>Jumlah Kategori Produk</p>
          </div>
          <div class="icon">
            <i class="ion ion-stats-bars"></i>
          </div>
        </div>
      </div>

      <div class="col-lg-2 col-xs-6">
        <div class="small-box bg-green">
          <div class="inner">
            <?php 
            $pimpinan = mysqli_query($koneksi,"SELECT * from pimpinan");
            $p = mysqli_num_rows($pimpinan);
            ?>
            <h4 style="font-weight: bolder"><?php echo $p ?></h4>
            <p>Jumlah Pimpinan</p>
          </div>
          <div class="icon">
            <i class="ion ion-stats-bars"></i>
          </div>
        </div>
      </div>

      <div class="col-lg-2 col-xs-6">
        <div class="small-box bg-green">
          <div class="inner">
            <?php 
            $user = mysqli_query($koneksi,"SELECT * from user");
            $u = mysqli_num_rows($user);
            ?>
            <h4 style="font-weight: bolder"><?php echo $u ?></h4>
            <p>Jumlah Admin</p>
          </div>
          <div class="icon">
            <i class="ion ion-stats-bars"></i>
          </div>
        </div>
      </div>

      <div class="col-lg-2 col-xs-6">
        <div class="small-box bg-green">
          <div class="inner">
            <?php 
            $kasir = mysqli_query($koneksi,"SELECT * from kasir");
            $p = mysqli_num_rows($kasir);
            ?>
            <h4 style="font-weight: bolder"><?php echo $p ?></h4>
            <p>Jumlah Kasir</p>
          </div>
          <div class="icon">
            <i class="ion ion-stats-bars"></i>
          </div>
        </div>
      </div>

      <div class="col-lg-2 col-xs-6">
        <div class="small-box bg-green">
          <div class="inner">
            <?php 
            $invoice = mysqli_query($koneksi,"SELECT * from invoice");
            $i = mysqli_num_rows($invoice);
            ?>
            <h4 style="font-weight: bolder"><?php echo $i ?></h4>
            <p>Jumlah Invoice</p>
          </div>
          <div class="icon">
            <i class="ion ion-stats-bars"></i>
          </div>  
        </div>
      </div>
    </div>



    <!-- /.row -->
    <div class="row">

      <section class="col-lg-6">
        <div class="nav-tabs-custom">

          <ul class="nav nav-tabs pull-right">
            <li class="active"><a href="#tab1" data-toggle="tab">Perhari</a></li>
            <li class="pull-left header">Grafik Penjualan Perhari</li>
          </ul>

          <div class="tab-content" style="padding: 20px">
            <div class="chart tab-pane active" id="tab1">
              <canvas id="grafik2" style="position: relative; height: 300px;"></canvas>
              <!-- <div id="grafik2" style="height: 300px"></div> -->
            </div>
          </div>

        </div>
      </section>

      <section class="col-lg-6">
        <div class="nav-tabs-custom">

          <ul class="nav nav-tabs pull-right">
            <li class="active"><a href="#tab1" data-toggle="tab">Perbulan</a></li>
            <li class="pull-left header">Grafik Penjualan Perbulan</li>
          </ul>

          <div class="tab-content" style="padding: 20px">
            <div class="chart tab-pane active" id="tab1">
              <canvas id="grafik1" style="position: relative; height: 300px;"></canvas>
            </div>
            <div class="chart tab-pane" id="tab2" style="position: relative; height: 300px;"></div>
          </div>

        </div>
      </section>

    </div>


  </section>

</div>





<?php include 'footer.php'; ?>