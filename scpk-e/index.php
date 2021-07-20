<?php 
include "config/koneksi.php";
include "config/library.php";
$page=@$_GET['page'];
opendb();

if(!isset($_SESSION['sesIdUser'])) {
	?><script language="JavaScript">document.location='login.php'</script><?php
} else { 
$tipe_adm=@$_SESSION['sesTipeUser'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Fuzzy-E SCPK</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">
  <link rel="stylesheet" href="css/app.css">
  <link rel="stylesheet" type="text/css" href="css/reset.css">
	<link rel="stylesheet" type="text/css" href="css/pagination.css">
	<link rel="stylesheet" type="text/css" href="css/B_blue.css">
  
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="?page=home" class="nav-link {{'home' == request()->path() ? 'active' : ''}}">Beranda</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
          <?php echo @$_SESSION['sesNamaUser']; ?>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href="logout.php">Logout</a>
          <a class="dropdown-item" href="?page=password">Ubah Password</a>
        </div>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <div class="brand-link">
      <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">SCPK-E</span>
    </div>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="img/1avatar.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a class="d-block"><?php echo @$_SESSION['sesNamaUser']; ?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

          <li class="nav-item has-treeview">
            <a href="?page=home" class="nav-link {{'home' == request()->path() ? 'active' : ''}}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>

          <li class="nav-item has-treeview">
            <a href="#" class="nav-link {{'?page=pasien' == request()->path() ? 'active' : ''}}">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Data Pasien
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="?page=pasien" class="nav-link {{'?page=pasien' == request()->path() ? 'active' : ''}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Lihat Data Pasien</p>
                </a>
              </li>
            </ul>
          </li>

          <?php if($tipe_adm==1) { ?>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Konsultasi
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="?page=permohonan" class="nav-link ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Data Permohonan</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="?page=hasil" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Data Hasil Permohonan</p>
                </a>
              </li>
            </ul>
          </li>
          <?php } ?>


          <li class="nav-header">DATA MASTER</li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-file"></i>
              <p>
                Data Fuzzy
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">

			        <?php if($tipe_adm==1) { ?>

              <li class="nav-item">
                <a href="?page=variabel" class="nav-link {{'?page=variabel' == request()->path() ? 'active' : ''}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Data Variabel</p>
                </a>
              </li>
			        <li class="nav-item">
                <a href="?page=himpunan" class="nav-link {{'?page=himpunan' == request()->path() ? 'active' : ''}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Data Himpunan</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="?page=parameter" class="nav-link {{'?page=parameter' == request()->path() ? 'active' : ''}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Data Bobot</p>
                </a>
              </li>
			        <li class="nav-item">
                <a href="?page=rule" class="nav-link {{'?page=rule' == request()->path() ? 'active' : ''}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Data Rule</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="?page=pohon" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pohon Keputusan</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="?page=kriteria" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Data Kriteria</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="?page=relasi" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Data Relasi</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="?page=resiko" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Data Resiko</p>
                </a>
              </li>

			        <?php } if($tipe_adm==2) { ?>

			        <li class="nav-item">
                <a href="?page=user" class="nav-link {{'?page=user' == request()->path() ? 'active' : ''}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Data User</p>
                </a>
              </li>

			        <?php } ?>
            </ul>
          </li>

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
  	<?php
		if($page=="variabel" && $tipe_adm==1) { include "list_variabel.php"; }
		elseif($page=="variabel-input" && $tipe_adm==1) { include "input_variabel.php"; }
		elseif($page=="pasien") { include "list_pasien.php"; }
    elseif($page=="pasien-input" && $tipe_adm==1) { include "input_pasien.php"; }
    elseif($page=="pasien-input" && $tipe_adm==2) { include "input_pasien.php"; }
		elseif($page=="pasien-view" && $tipe_adm==2) { include "view_pasien.php"; }
		elseif($page=="parameter" && $tipe_adm==1) { include "list_parameter.php"; }
		elseif($page=="parameter-input" && $tipe_adm==1) { include "input_parameter.php"; }
		elseif($page=="kondisi" && $tipe_adm==2) { include "list_kondisi.php"; }
		elseif($page=="kondisi-input" && $tipe_adm==2) { include "input_kondisi.php"; }
		elseif($page=="himpunan" && $tipe_adm==1) { include "list_himpunan.php"; }
		elseif($page=="himpunan-input" && $tipe_adm==1) { include "input_himpunan.php"; }
		elseif($page=="rule" && $tipe_adm==1) { include "list_rule.php"; }
		elseif($page=="rule-input" && $tipe_adm==1) { include "input_rule.php"; }
		elseif($page=="permohonan" && $tipe_adm==1) { include "list_permohonan.php"; }
		elseif($page=="permohonan-input" && $tipe_adm==1) { include "input_permohonan.php"; }
		elseif($page=="hasil" && $tipe_adm==1) { include "list_hasil.php"; }
    elseif($page=="hasil-proses" && $tipe_adm==1) { include "proses_hasil.php"; }
    elseif($page=="pohon" && $tipe_adm==1) { include "list_pohon.php"; }
    elseif($page=="pohon-input" && $tipe_adm==1) { include "input_pohon.php"; }
    elseif($page=="kriteria" && $tipe_adm==1) { include "list_kriteria.php"; }
    elseif($page=="kriteria-input" && $tipe_adm==1) { include "input_kriteria.php"; }
    elseif($page=="relasi" && $tipe_adm==1) { include "list_relasi.php"; }
    elseif($page=="relasi-input" && $tipe_adm==1) { include "input_relasi.php"; }
    elseif($page=="resiko" && $tipe_adm==1) { include "list_resiko.php"; }
    elseif($page=="resiko-input" && $tipe_adm==1) { include "input_resiko.php"; }
    elseif($page=="solving-konsul" && $tipe_adm==1) { include "solving_konsul.php"; }
    elseif($page=="solving-konsulTes" && $tipe_adm==1) { include "solving_konsulTes.php"; }
    elseif($page=="analisa-diagnosa-konsul" && $tipe_adm==1) { include "analisa_diagnosa_konsul.php"; }
		elseif($page=="user" && $tipe_adm==2) { include "list_user.php"; }
		elseif($page=="user-input" && $tipe_adm==2) { include "input_user.php"; }
		elseif($page=="password") { include "ubah_password.php"; }
		else { include "home.php"; }
	?>	
  </div>

  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2020 <a href="#">SCPK-E</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 1.0.0
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script>
<script>
  $(function(){
    $('#dataTables').DataTable();
  });

  var url = window.location;
  // for sidebar menu but not for treeview submenu
  $('ul.nav-sidebar a').filter(function() {
      return this.href == url;
  }).parent().siblings().removeClass('active').end().addClass('active');
  // for treeview which is like a submenu
  $('ul.nav-treeview a').filter(function() {
      return this.href == url;
  }).parentsUntil(".nav-sidebar > .nav-treeview").siblings().removeClass('menu-open').end().addClass('active menu-open');
</script>
<script type="text/javascript" src="js/jquery.js"></script>
<!--<script type="text/javascript" src="js/map.js"></script>-->
<script type="text/javascript" src="js/main.js"></script>
<script type="text/javascript" src="js/custom.js"></script>
<script type="text/javascript" src="js/jquery.validate.js"></script>
</body>
</html>
<?php } closedb(); ?>