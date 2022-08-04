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

    $('#table-datatable-produk').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : true,
      'ordering'    : false,
      'info'        : true,
      'autoWidth'   : true,
      "pageLength": 10
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









 
  $(document).ready(function() {


    function formatNumber(num) {
      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
    }



    // pilih produk
    $(document).on("click", ".modal-pilih-produk", function() {

      var id = $(this).attr('id');
      var kode = $("#kode_" + id).val();
      var nama = $("#nama_" + id).val();
      var harga = $("#harga_" + id).val();

      $("#tambahkan_id").val(id);
      $("#tambahkan_kode").val(kode);
      $("#tambahkan_nama").val(nama);
      $("#tambahkan_harga").val(harga);
      $("#tambahkan_jumlah").val(1);
      // $("#tambahkan_total").val(harga);

    });


    // ubah jumlah
    // $(document).on("change keyup", "#tambahkan_jumlah", function() {

    //     // var id = $(this).attr('id');
    //     // var kode = $("#kode_"+id).val();
    //     // var nama = $("#nama_"+id).val();
    //     var harga = $("#tambahkan_harga").val();
    //     var jumlah = $("#tambahkan_jumlah").val();
    //     var total = harga * jumlah;
    //     $("#tambahkan_total").val(total);

    //   });
    
    // // tambahkan kode
    // $("body").on("keyup", "#tambahkan_kode", function() {
    //   var kode = $(this).val();
    //   var data = "kode=" + kode;
    //   $.ajax({
    //     type: "POST",
    //     url: "penjualan_cari_ajax.php",
    //     data: data,
    //     dataType: 'JSON',
    //     success: function(html) {
    //       $("#tambahkan_id").val(html[0].id);

    //       $("#tambahkan_nama").val(html[0].nama);
    //       $("#tambahkan_harga").val(html[0].harga);
    //       $("#tambahkan_jumlah").val(html[0].jumlah);
    //       $("#tambahkan_total").val(html[0].harga)

    //     }

    //   });
    // });

   

    // tombol tambahkan produk
    $("body").on("click", "#tombol-tambahkan", function() {



      var id = $("#tambahkan_id").val();
      var kode = $("#tambahkan_kode").val();
      var nama = $("#tambahkan_nama").val();
      var harga = $("#tambahkan_harga").val();
      var jumlah = $("#tambahkan_jumlah").val();
      var potongan = $("#potongan").val() != "" ? $("#potongan").val() : "0";
          potongan = parseInt(potongan.replace("Rp.", "").replace(".", "").replace(",00",""));
      var sub_total = harga*jumlah;
      var total = sub_total - potongan;


      if (id.length == 0) {
        alert("Produk belum dipilih");
      } else if (kode.length == 0) {
        alert("Kode produk harus diisi");
      } else if (jumlah == 0) {
        alert("Jumlah harus lebih besar dari 0");
      } else {
        var table_pembelian = "<tr id='tr_" + id + "'>" +
        `<td> 
          <input type='hidden' name='transaksi_produk[]' value='${id}'> 
          <input type='hidden' name='transaksi_harga[]' value='${harga}'> 
          <input type='hidden' name='transaksi_jumlah[]' value='${jumlah}'> 
          <input type='hidden' name='transaksi_subtotal[]' value='${sub_total}'> 
          <input type='hidden' name='transaksi_potongan[]' value='${potongan}'> 
          <input type='hidden' name='transaksi_total[]' value='${total}'>
          ${kode}
        </td>` +
        "<td>" + nama + "</td>" +
        "<td align='center'>Rp." + formatNumber(harga) + ",-</td>" +
        "<td align='center'>" + formatNumber(jumlah) + "</td>" +
        "<td align='center'>Rp." + formatNumber(sub_total) + "</td>" +
        "<td align='center'>Rp." + formatNumber(potongan) + "</td>" +
        "<td align='center'>Rp." + formatNumber(total) + ",-</td>" +
        `<td align='center'> <span class='btn btn-sm btn-danger tombol-hapus-penjualan' potongan='${potongan}' subtotal='${sub_total}' total='${total}' id='${id}'><i class='fa fa-close'></i> Batal</span></td>` +
        "</tr>";
        $("#table-pembelian tbody").append(table_pembelian);


            // update total pembelian
            // var pembelian_harga = $(".pembelian_harga").attr("id");
            // var pembelian_jumlah = $(".pembelian_jumlah").attr("id");
            var sub_total_produk = $(".sub_total").attr("id");
            var potongan_total = $(".potongan_produk").attr("id");
            var pembelian_total = $(".pembelian_total").attr("id");

            // jumlahkan pembelian
            // var jumlahkan_harga = eval(pembelian_harga) + eval(harga);
            // var jumlahkan_jumlah = eval(pembelian_jumlah) + eval(jumlah);
            var sub_total_produk = eval(sub_total_produk) + eval(sub_total);
            var jumlahkan_potongan = eval(potongan_total) + eval(potongan);
            var jumlahkan_total = eval(pembelian_total) + eval(total);

            // isi di table penjualan
            // $(".pembelian_harga").attr("id", jumlahkan_harga);
            // $(".pembelian_jumlah").attr("id", jumlahkan_jumlah);
            $(".sub_total").attr("id", sub_total_produk);
            $(".potongan_produk").attr("id", jumlahkan_potongan);
            $(".pembelian_total").attr("id", jumlahkan_total);

            // tulis di table penjualan
            // $(".pembelian_harga").text("Rp." + formatNumber(jumlahkan_harga) + ",-");
            // $(".pembelian_jumlah").text(formatNumber(jumlahkan_jumlah));
            $(".sub_total").text("Rp."+formatNumber(sub_total_produk));
            $(".potongan_produk").text("Rp."+formatNumber(jumlahkan_potongan));
            $(".pembelian_total").text("Rp." + formatNumber(jumlahkan_total) + ",-");

            // total
            $(".total_pembelian").text("Rp." + formatNumber(jumlahkan_total) + ",-"); 
            $(".total_potongan").text("Rp." + formatNumber(jumlahkan_potongan) + ",-");
            $(".sub_total_pembelian").text("Rp." + formatNumber(sub_total_produk) + ",-");

            $(".total_form").val(jumlahkan_total);
            $(".potongan_form").val(jumlahkan_potongan);
            $(".sub_total_form").val(sub_total_produk);

            // kosongkan
            $("#tambahkan_id").val("");
            $("#tambahkan_kode").val("");
            $("#tambahkan_nama").val("");
            $("#tambahkan_harga").val("");
            $("#tambahkan_jumlah").val("");
            $("#potongan").val("");
          }

        });




    // tombol hapus penjualan
    $("body").on("click", ".tombol-hapus-penjualan", function() {
      var id = $(this).attr("id");
      var subTotal = $(this).attr("subtotal");
      var potongan = $(this).attr("potongan");
      var total = $(this).attr("total");

        // update total pembelian
        var sub_total = $(".sub_total").attr("id");
        var potongan_total = $(".potongan_produk").attr("id");
        var pembelian_total = $(".pembelian_total").attr("id");

        // jumlahkan pembelian
        var kurangi_subtotal = eval(sub_total) - eval(subTotal);
        var kurangi_potongan = eval(potongan_total) - eval(potongan);
        var kurangi_total = eval(pembelian_total) - eval(total);

        // isi di table penjualan
        $(".sub_total").attr("id", kurangi_subtotal);
        $(".potongan_produk").attr("id", kurangi_potongan);
        $(".pembelian_total").attr("id", kurangi_total);

        // tulis di table penjualan
        $(".sub_total").text("Rp." + formatNumber(kurangi_subtotal) + ",-");
        $(".potongan_produk").text("Rp."+formatNumber(kurangi_potongan));
        $(".pembelian_total").text("Rp." + formatNumber(kurangi_total) + ",-");

        // total
        $(".total_pembelian").text("Rp." + formatNumber(kurangi_total) + ",-"); 
        $(".total_potongan").text("Rp." + formatNumber(kurangi_potongan) + ",-");
        $(".sub_total_pembelian").text("Rp." + formatNumber(kurangi_subtotal) + ",-");

        $(".total_form").val(kurangi_total);
        $(".potongan_form").val(kurangi_potongan);
        $(".sub_total_form").val(kurangi_subtotal);


        $("#tr_" + id).remove();

      });

    // // diskon
    // $("body").on("keyup", ".total_diskon", function() {
    //   var diskon = $(this).val();

    //   if(diskon.length != 0 && diskon != ""){

    //     var sub_total = $(".sub_total_pembelian").attr("id");
    //     var total = $(".total_pembelian").attr("id");

    //     var hasil_diskon = sub_total*diskon/100;
    //     var hasil2 = sub_total-hasil_diskon;
    //     $(".total_pembelian").text("Rp."+formatNumber(hasil2)+",-");
    //     $(".total_form").val(hasil2);

    //   }else{

    //     var sub_total_pembelian = $(".sub_total_pembelian").attr("id");
    //     $(".total_pembelian").attr("id",sub_total_pembelian);
    //     $(".total_pembelian").text("Rp."+formatNumber(sub_total_pembelian)+",-");

    //   }

      

    // });


    


  });


  function cek()
  {
    var total = $(".total_form").val();
    if(total > 0){
      return confirm('Apakah anda yakin ingin memproses transaksi?');
      // return true;
    }else{
      alert("Pembelian Masih Kosong");
      return false;
    }
  }

</script>

</body>
</html>
