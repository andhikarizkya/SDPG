<?php
error_reporting(0);
include("header.php");

$stat	= @$_GET['stat'];
$id		= (int)antiinjec(@$_GET['id']);

if($stat=="ubah") {
	$hdata=querydb("SELECT id_user, nama_lengkap, no_telepon, terdaftar, username, tipe_akses FROM user WHERE id_user=$id");
	$data=mysql_fetch_array($hdata);
}

if(@$_POST['stat_simpan']) {
	$id				= antiinjec(@$_POST['id']);
	$nama_lengkap	= antiinjec(@$_POST['nama_lengkap']);
	$no_telepon		= antiinjec(@$_POST['no_telepon']);
	$username		= antiinjec(@$_POST['username']);
	$password		= antiinjec(@$_POST['password']);
	$password		= md5($password);
	$password2		= antiinjec(@$_POST['password2']);
	$tipe_akses		= (int)antiinjec(@$_POST['tipe_akses']);
	$terdaftar		= date("Y-m-d");
	
	if(antiinjec(@$_POST['password']) != $password2) {
		?>
			<script language="JavaScript">alert('Password dan Ulangi Password harus sama.'); history.go(-1); </script>
		<?php
		exit;
    }
	
	if($stat=="tambah") {
		$d_cek=mysql_fetch_array(querydb("SELECT count(*) FROM user WHERE username='$username'"));
		if($d_cek[0]==0) {
			querydb("INSERT INTO user(nama_lengkap, no_telepon, terdaftar, username, tipe_akses, password)
					 VALUES ('$nama_lengkap' , '$no_telepon', '$terdaftar', '$username', $tipe_akses, '$password')");
			?>
			<script language="JavaScript">document.location='?page=user&con=1'</script>
			<?php
		} else {
			//echo "<div class='warning'>user [$user] sudah ada. </div>";
			?>
			<script language="JavaScript">alert('username [<?php echo $username; ?>] sudah ada.'); history.go(-1); </script>
			<?php
		}
	} elseif($stat=="ubah") {
		$d_cek=mysql_fetch_array(querydb("SELECT count(*) FROM user WHERE username='$username' AND id_user<>$id"));
		echo $user;
		if($d_cek[0]==0) {
			querydb("UPDATE user SET nama_lengkap='$nama_lengkap', no_telepon='$no_telepon', terdaftar='$terdaftar', username='$username', tipe_akses=$tipe_akses, password='$password' WHERE id_user=$id");
			?>
			<script language="JavaScript">document.location='?page=user&con=2'</script>
			<?php
		} else {
			//echo "<div class='warning'>user [$user] sudah ada. </div>";
			?>
			<script language="JavaScript">alert('username [<?php echo $username; ?>] sudah ada.'); history.go(-1); </script>
			<?php
		}
	}
} elseif($stat=="hapus" && $id!="") {
	querydb("DELETE FROM user WHERE id_user=$id");
	?>
	<script language="JavaScript">document.location='?page=user&con=3'</script>
	<?php
}
?>

<script type="text/javascript">
$j(function() { $j("#form1").validate({
	rules: {
	  terdaftar: {
		required: true,
		number: true,
		rangelength: [11, 12]
	  }
	}
  }); 
});
</script>

<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Data User</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="?page=home">Beranda</a></li>
          <li class="breadcrumb-item">Data Fuzzy</li>
          <li class="breadcrumb-item active">Data User</li>
        </ol>
      </div>
    </div>
  </div>
</div>

<section class="content">
  	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h2 class="card-title" style="margin-bottom: 1px;"><?php if($stat=="tambah") { echo "Tambah"; } elseif($stat=="ubah") { echo "Ubah"; } ?> User</h2>
				</div>
				<div class="card-body">
						<form class="needs-validation" action="?page=user-input&stat=<?php echo $stat; ?>" method="post" enctype="multipart/form-data" name="form1" id="form1" novalidate>
							<input type="hidden" name="stat_simpan" value="set">
							<input type="hidden" name="id" value="<?php echo $id; ?>">

    						<div class="form-group row">
      							<label class="col-md-4 col-form-label text-md-right" for="validationCustom01">Nama Lengkap</label>
      							
								<div class="col-md-6">  
									<input type="text" class="form-control" id="validationCustom01" name="nama_lengkap" value="<?php echo"$data[nama_lengkap]";?>" required>
									<div class="invalid-feedback">
										Nama tidak boleh kosong!
									</div>
								</div>
    						</div>
							
    						<div class="form-group row">
      							<label class="col-md-4 col-form-label text-md-right" for="validationCustom02">No. Telepon</label>
      							
								<div class="col-md-6">  
									<input type="number" class="form-control" id="validationCustom02" name="no_telepon" value="<?php echo"$data[no_telepon]";?>" required>
									<div class="invalid-feedback">
										Nomor Telepon tidak boleh kosong!
      								</div>
								</div>
    						</div>

							<div class="form-group row">
      							<label class="col-md-4 col-form-label text-md-right" for="validationCustom03">Tipe Akses</label>
      							
								<div class="col-md-6"> 
									<select class="form-control" id="validationCustom03" name="tipe_akses" required>
										<option value="">-- Pilih Hak Akses User --</option>
										<option value="1" <?php if($data['tipe_akses']==1) { echo "selected"; } ?>>Kader</option>
										<option value="2" <?php if($data['tipe_akses']==2) { echo "selected"; } ?>>Administrator</option>
									</select>
									<div class="invalid-feedback">
										Mohon pilih tipe akses user!
									</div>
								</div>
    						</div>

    						<div class="form-group row">
      							<label class="col-md-4 col-form-label text-md-right" for="validationCustom04">Username</label>
      							
								<div class="col-md-6">
									<input type="text" class="form-control" id="validationCustom04" name="username" value="<?php echo"$data[username]";?>" required>
									<div class="invalid-feedback">
										Username tidak boleh kosong!
      								</div>
								</div>	
    						</div>
							
    						<div class="form-group row">
      							<label class="col-md-4 col-form-label text-md-right" for="validationCustom05">Password</label>
      							
								<div class="col-md-6">  
									<input type="password" class="form-control" id="validationCustom05" name="password" <?php if($stat=="ubah") { echo "placeholder='Ketik Password Baru'"; } ?> required>
									<div class="invalid-feedback">
										Password tidak boleh kosong!
									</div>
      							</div>
    						</div>

    						<div class="form-group row">
      							<label class="col-md-4 col-form-label text-md-right" for="validationCustom06">Ulangi Password</label>
      							
								<div class="col-md-6">  
									<input type="password" class="form-control" id="validationCustom06" name="password2" <?php if($stat=="ubah") { echo "placeholder='Ketik ulang Password'"; } ?> required>
									<div class="invalid-feedback">
										Ulangi Password tidak boleh kosong!
									</div>
      							</div>
    						</div>

							<div class="form-group row mb-0">
								<div class="col-md-8 offset-md-4">
									<button type="submit" class="btn btn-primary" value="Simpan" name="stat_simpan">Simpan</button>
									<button type="submit" class="btn btn-warning" onclick="window.history.back();" value="Batal">Batal</button>
								</div>
							</div>
						</form>
				</div>
			</div>
		</div>
	</div>
</section>

<script>
(function() {
  'use strict';
  window.addEventListener('load', function() {
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.getElementsByClassName('needs-validation');
    // Loop over them and prevent submission
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();
</script>