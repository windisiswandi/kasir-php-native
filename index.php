<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Aplikasi POINT OF SALES</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/bower_components/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="assets/bower_components/Ionicons/css/ionicons.min.css">
  <link rel="stylesheet" href="assets/dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="assets/plugins/iCheck/square/blue.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="bg-green">
  <div class="container">
    <div class="login-box">

      <center>

        <h2 style="margin: 0"><b>POS</b> (<b>P</b>oint <b>O</b>f <b>S</b>ales)</h2>
        <h3>TOKO JARINGANKU</h3>

        <br/>

        <?php 
        if(isset($_GET['alert'])){
          if($_GET['alert'] == "gagal"){
            echo "<div class='alert alert-danger'>LOGIN GAGAL! USERNAME DAN PASSWORD SALAH!</div>";
          }else if($_GET['alert'] == "logout"){
            echo "<div class='alert alert-success'>ANDA TELAH BERHASIL LOGOUT</div>";
          }else if($_GET['alert'] == "belum_login"){
            echo "<div class='alert alert-warning'>ANDA HARUS LOGIN UNTUK MENGAKSES DASHBOARD</div>";
          }
        }
        ?>
      </center>

      <div class="login-box-body">

       <center>
        <img src="gambar/sistem/logo.png" style="width: 170px">
      </center>
      <p class="login-box-msg text-bold">LOGIN</p>

      <form action="periksa_login.php" method="POST">
        
        <div class="form-group has-feedback">
          <input type="text" class="form-control" placeholder="Username" name="username" required="required" autocomplete="off">
          <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>

        <div class="form-group has-feedback">
          <input type="password" class="form-control" placeholder="Password" name="password" required="required" autocomplete="off">
          <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>

        <div class="form-group has-feedback">
          
          <select class="form-control" name="sebagai" required="required">
            <option value="">- Pilih</option>
            <option value="administrator">Administrator</option>
            <option value="kasir">Kasir</option>
            <option value="pimpinan">Pimpinan</option>
          </select>

          <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>

        <div class="row">
          <div class="col-xs-offset-8 col-xs-4">
            <button type="submit" class="btn btn-success btn-block btn-flat">MASUK</button>
          </div>
        </div>

      </form>

    </div>
  </div>
</div>


<script src="assets/bower_components/jquery/dist/jquery.min.js"></script>
<script src="assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

</body>
</html>
