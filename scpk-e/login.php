<?php
include "config/koneksi.php";
include "config/library.php";
$false=@$_GET['false'];
opendb();
if(antiinjec(@$_POST['username'])!="") {
  $username=antiinjec(@$_POST['username']);
  $password=md5(antiinjec(@$_POST['password']));

  $query="SELECT id_user, nama_lengkap, username, password, tipe_akses FROM user WHERE username='$username' AND password='$password'";
  $hasil=querydb($query);
  $userjum=mysql_fetch_array($hasil);
  if ($userjum['username']<>"") {
	  $_SESSION['sesIdUser']=$userjum['id_user'];
	  $_SESSION['sesNamaUser']=$userjum['nama_lengkap'];
	  $_SESSION['sesTipeUser']=$userjum['tipe_akses'];
  ?>
	  <script language="JavaScript">document.location='./'</script>
  <?php
  } else {
  ?>
	<script language="JavaScript">
	document.location='login.php?false=true'</script><?php
  }
}
closedb();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Halaman Login</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="img/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main2.css">
<!--===============================================================================================-->
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-form-title" style="background-image: url(img/campur.jpg);">
					<span class="login100-form-title-1">
						Halaman Login
					</span>
				</div>

        <form class="login100-form validate-form" action="" method="post" enctype="multipart/form-data">
        <?php if($false!="") { ?>
        <div style="display:inline-table; padding:8px 5px 5px 5px; background:#FF0000; border:1px solid #FFF; text-align:center; font-size:12px; color:#FFF; border-radius:8px; margin-bottom:5px;">
			      Username atau password yang Anda masukkan salah.
		    </div>
        <?php } ?>
        
					<div class="wrap-input100 validate-input m-b-26" data-validate="Username TIDAK BOLEH KOSONG!">
						<span class="label-input100">Username</span>
						<input class="input100" type="text" name="username" placeholder="Masukkan username Anda">
						<span class="focus-input100"></span>
					</div>

					<div class="wrap-input100 validate-input m-b-18" data-validate = "Password TIDAK BOLEH KOSONG!">
						<span class="label-input100">Password</span>
						<input class="input100" type="password" name="password" placeholder="Masukkan password Anda">
						<span class="focus-input100"></span>
					</div>

					<div class="container-login100-form-btn">
						<button class="login100-form-btn">
							Masuk
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	
<!--===============================================================================================-->
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="js/main2.js"></script>

</body>
</html>