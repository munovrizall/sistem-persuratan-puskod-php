<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login</title>

  <?php
  $rootPath = $_SERVER['DOCUMENT_ROOT'];
  include $rootPath . "/sistem-persuratan-puskod/components/style.html";
  ?>
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <!-- /.login-logo -->
    <div class="card card-outline card-primary">
      <div class="card-header text-center">
        <a href="/sistem-persuratan-puskod/adminltindex2.html" class="h1"><b>
            <img src="assets/image/logo-kemhan.png" class="brand-image img-circle elevation-3" style="opacity: .8; height: 80px; width: 80px;">
            <br></b>Pusat Kodifikasi</a>
      </div>
      <div class="card-body">

        <form>
          <div class="input-group mb-3">
            <input type="email" class="form-control" placeholder="Email">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" placeholder="Password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <!-- /.col -->
          <div>
            <button type="button" class="btn btn-primary btn-block" onclick="login();">Login</button>
          </div>
          <!-- /.col -->
      </div>
      </form>

    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
  </div>
  <!-- /.login-box -->

  <!-- jQuery -->
  <script src="/sistem-persuratan-puskod/adminlte/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="/sistem-persuratan-puskod/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="/sistem-persuratan-puskod/adminlte/dist/js/adminlte.min.js"></script>

  <script>
    function login() {
      window.location.href = "/sistem-persuratan-puskod/tata-usaha/homepage.php";
    }
  </script>
</body>

</html>