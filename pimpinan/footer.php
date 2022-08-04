<!-- /.content-wrapper -->
<footer class="main-footer">
  <div class="pull-right hidden-xs">
    <b>Version</b> 1.0
  </div>
  <strong>Copyright &copy; <?php echo date('Y'); ?></strong> - Sistem Informasi Penjualan Kasir - POS (Point Of Sales)
</footer>


</div>


<script src="../assets/bower_components/jquery/dist/jquery.min.js"></script>

<script src="../assets/bower_components/jquery-ui/jquery-ui.min.js"></script>

<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>

<script src="../assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

<script src="../assets/bower_components/raphael/raphael.min.js"></script>
<script src="../assets/bower_components/morris.js/morris.min.js"></script>

<script src="../assets/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>


<script src="../assets/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="../assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

<script src="../assets/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="../assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>

<script src="../assets/bower_components/jquery-knob/dist/jquery.knob.min.js"></script>

<script src="../assets/bower_components/moment/min/moment.min.js"></script>
<script src="../assets/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>

<script src="../assets/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

<script src="../assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>

<script src="../assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>

<script src="../assets/bower_components/fastclick/lib/fastclick.js"></script>

<script src="../assets/dist/js/adminlte.min.js"></script>

<script src="../assets/dist/js/pages/dashboard.js"></script>

<script src="../assets/dist/js/demo.js"></script>
<script src="../assets/bower_components/ckeditor/ckeditor.js"></script>
<script src="../assets/bower_components/chart.js/Chart.min.js"></script>

<script>
  $(document).ready(function(){

    $('#table-datatable').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : true,
      'ordering'    : false,
      'info'        : true,
      'autoWidth'   : true,
      "pageLength": 50
    });

    $('#datepicker').datepicker({
      autoclose: true,
      format: 'dd/mm/yyyy',
    }).datepicker("setDate", new Date());

    $('.datepicker2').datepicker({
      autoclose: true,
      format: 'yyyy/mm/dd',
    });

  });

  var randomScalingFactor = function(){ return Math.round(Math.random()*100)};

  var barChartData = {
    labels : ["Jan","Feb","Mar","Apr","Mei","Jun","Jul","Agu","Sep","Okt","Nov","Des"],
    datasets : [
    {
      label: 'Penjualan',
      fillColor : "rgba(51, 240, 113, 0.61)",
      strokeColor : "rgba(11, 246, 88, 0.61)",
      highlightFill: "rgba(220,220,220,0.75)",
      highlightStroke: "rgba(220,220,220,1)",
      data : [
      <?php
      for($bulan=1;$bulan<=12;$bulan++){
        $thn_ini = date('Y');


        $penjualan = mysqli_query($koneksi,"SELECT sum(invoice_total) as total FROM invoice WHERE month(invoice_tanggal)='$bulan' and year(invoice_tanggal)='$thn_ini'");
        $p = mysqli_fetch_assoc($penjualan);
        $total = $p['total'];
        if($p['total'] == ""){
          echo "0,";
        }else{
          echo $total.",";
        }

      }
      ?>
      ]
    },
    {
      label: 'Laba',
      fillColor : "rgba(255, 51, 51, 0.8)",
      strokeColor : "rgba(248, 5, 5, 0.8)",
      highlightFill : "rgba(151,187,205,0.75)",
      highlightStroke : "rgba(151,187,205,1)",
      data : [
      <?php
      for($bulan=1;$bulan<=12;$bulan++){

        $thn_ini = date('Y');

        $bulan_ini = $bulan;
        $total_modal = 0;
        $modal = mysqli_query($koneksi,"SELECT * FROM invoice,transaksi,produk where invoice_id=transaksi_invoice and transaksi_produk=produk_id and month(invoice_tanggal)='$bulan_ini' and year(invoice_tanggal)='$thn_ini'");
        while($l = mysqli_fetch_array($modal)){
          $m = $l['produk_harga_modal'] * $l['transaksi_jumlah'];
          $total_modal += $m;
        }

        $total_penjualan = 0;
        $penjualan = mysqli_query($koneksi,"SELECT sum(invoice_total) as total_penjualan FROM invoice where month(invoice_tanggal)='$bulan_ini' and year(invoice_tanggal)='$thn_ini'");
        $p = mysqli_fetch_assoc($penjualan);
        $total_penjualan = $p['total_penjualan'];

        $laba = $total_penjualan-$total_modal;

        $cek = mysqli_fetch_assoc($modal);

        if($laba == ""){
          echo "0,";
        }else{

          echo $laba.",";
        }
      }
      ?>
      ]
    }
    ]

  }



  var barChartData2 = {
    labels : [
    <?php 
    $dateBegin = strtotime("first day of this month");  
    $dateEnd = strtotime("last day of this month");

    $awal = date("Y/m/d", $dateBegin);         
    $akhir = date("Y/m/d", $dateEnd);

    $arsip = mysqli_query($koneksi,"SELECT distinct invoice_tanggal FROM invoice WHERE date(invoice_tanggal) >= '$awal' AND date(invoice_tanggal) <= '$akhir' order by date(invoice_tanggal) asc");
    while($p = mysqli_fetch_array($arsip)){
      $tgl = date('d/m/Y',strtotime($p['invoice_tanggal']));
      ?>
      "<?php echo $tgl; ?>",
      <?php 
    }
    ?>
    ],
    datasets : [
    {
      label: 'Penjualan',
      fillColor : "rgba(51, 240, 113, 0.61)",
      strokeColor : "rgba(11, 246, 88, 0.61)",
      highlightFill: "rgba(220,220,220,0.75)",
      highlightStroke: "rgba(220,220,220,1)",
      data : [
      <?php 
      $dateBegin = strtotime("first day of this month");  
      $dateEnd = strtotime("last day of this month");

      $awal = date("Y/m/d", $dateBegin);         
      $akhir = date("Y/m/d", $dateEnd);


      $arsip = mysqli_query($koneksi,"SELECT distinct invoice_tanggal FROM invoice WHERE date(invoice_tanggal) >= '$awal' AND date(invoice_tanggal) <= '$akhir' order by date(invoice_tanggal) asc");
      while($p = mysqli_fetch_array($arsip)){
        $tgl = date('Y/m/d',strtotime($p['invoice_tanggal']));

        $penjualan = mysqli_query($koneksi,"SELECT sum(invoice_total) as total FROM invoice WHERE date(invoice_tanggal)='$tgl'");
        $p = mysqli_fetch_assoc($penjualan);

        $total = $p['total'];
        if($p['total'] == ""){
          echo "0,";
        }else{
          echo $total.",";
        }
      }
      ?>

      ]
    },{
      label: 'Laba',
      fillColor : "rgba(255, 51, 51, 0.8)",
      strokeColor : "rgba(248, 5, 5, 0.8)",
      highlightFill : "rgba(151,187,205,0.75)",
      highlightStroke : "rgba(151,187,205,1)",
      data : [
      <?php 
      $dateBegin = strtotime("first day of this month");  
      $dateEnd = strtotime("last day of this month");

      $awal = date("Y/m/d", $dateBegin);         
      $akhir = date("Y/m/d", $dateEnd);

      $arsip = mysqli_query($koneksi,"SELECT distinct invoice_tanggal FROM invoice WHERE date(invoice_tanggal) >= '$awal' AND date(invoice_tanggal) <= '$akhir' order by date(invoice_tanggal) asc");
      while($p = mysqli_fetch_array($arsip)){
        $tgl = date('Y/m/d',strtotime($p['invoice_tanggal']));

        $total_penjualan = 0;
        $penjualan = mysqli_query($koneksi,"SELECT sum(invoice_total) as total FROM invoice WHERE date(invoice_tanggal)='$tgl'");
        $p = mysqli_fetch_assoc($penjualan);
        $total_penjualan = $p['total'];

        $total_modal = 0;
        $modal = mysqli_query($koneksi,"SELECT * FROM invoice,transaksi,produk where invoice_id=transaksi_invoice and transaksi_produk=produk_id and date(invoice_tanggal)='$tgl'");
        while($l = mysqli_fetch_array($modal)){
          $m = $l['produk_harga_modal'] * $l['transaksi_jumlah'];
          $total_modal += $m;
        }


        $laba = $total_penjualan-$total_modal;




        $total = $p['total'];
        if($laba == ""){
          echo "0,";
        }else{
          echo $laba.",";
        }
      }
      ?>

      ]
    }
    
    ]

  }


  window.onload = function(){
    var ctx = document.getElementById("grafik1").getContext("2d");
    window.myBar = new Chart(ctx).Bar(barChartData, {
      responsive : true,
      animation: true,
      barValueSpacing : 5,
      barDatasetSpacing : 1,
      tooltipFillColor: "rgba(0,0,0,0.8)",
      multiTooltipTemplate: "<%= datasetLabel %> - Rp.<%= value.toLocaleString() %>,-"
    });

    var ctx = document.getElementById("grafik2").getContext("2d");
    window.myBar = new Chart(ctx).Bar(barChartData2, {
      responsive : true,
      animation: true,
      barValueSpacing : 5,
      barDatasetSpacing : 1,
      tooltipFillColor: "rgba(0,0,0,0.8)",
      multiTooltipTemplate: "<%= datasetLabel %> - Rp.<%= value.toLocaleString() %>,-"
    });

  }

</script>
</body>
</html>
