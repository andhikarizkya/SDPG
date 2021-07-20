<?php
$simpan=@$_POST['simpan'];
$stat=@$_POST['stat'];
?>
<script type="text/javascript">
$j(function() { $j("#form1").validate(); });
</script>

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

<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Ubah Password</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="?page=home">Beranda</a></li>
          <li class="breadcrumb-item">Ubah Password</li>
          <li class="breadcrumb-item active">Form Ubah Password</li>
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
					<h2 class="card-title" style="margin-bottom: 1px;">Form Ubah Password User</h2>
				</div>
				<div class="card-body">
					<div class="form-style-2" >
						<form class="needs-validation" method="post" action="?page=password" enctype="multipart/form-data" name="form1" id="form1" novalidate>
							<input name="stat" type="hidden" value="ubah1">

							<div class="form-group row">
								<label for="validationCustom01" class="col-md-4 col-form-label text-md-right">Password Sekarang</label>
									
								<div class="col-md-6">
									<input type="password" class="form-control required" id="validationCustom01" name="satu" value="" title=" * Password Saat ini harus diisi" required>
									<div class="invalid-feedback">
										Password Saat ini harus diisi!
									</div>
								</div>
							</div>
								
							<div class="form-group row">
								<label for="validationCustom02" class="col-md-4 col-form-label text-md-right">Password Baru</label>
									
								<div class="col-md-6">
									<input type="password" class="form-control required" id="validationCustom02" name="dua" value="" title=" * Password Baru tidak boleh kosong" required>
									<div class="invalid-feedback">
										Password Baru tidak boleh kosong!
									</div>
								</div>
							</div>

							<div class="form-group row">
								<label for="validationCustom03" class="col-md-4 col-form-label text-md-right">Ulangi Password Baru</label>
									
								<div class="col-md-6">	
									<input type="password" class="form-control required" id="validationCustom03" name="tiga" value="" title=" * Password Baru tidak boleh kosong" required>
									<div class="invalid-feedback">
										Password Baru tidak boleh kosong!
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
	</div>
</section>

<?php
//0. Ambil data yang didapat dari Form Pendaftaran
$stat=@$_POST['stat'];

$satu=md5(antiinjec(@$_POST['satu']));
$dua=md5(antiinjec(@$_POST['dua']));
$tiga=md5(antiinjec(@$_POST['tiga']));
if ($stat=="ubah1") {
	$pass_lama=mysql_fetch_assoc(querydb("SELECT password FROM user WHERE id_user=".@$_SESSION['sesIdUser'].""));
	if ($satu<>$pass_lama['password'])
	{ ?>
		<script language="JavaScript">alert('Password lama salah.');
		document.location='?page=password'</script>
	<?php }
	else
	{
		if (($dua<>$tiga) or ($dua=="") or ($tiga==""))
		{ ?>
			<script language="JavaScript">alert('Pasword Baru dan Ulangi Password Baru harus sama.');
			document.location='?page=password'</script>
		<?php }
		else
		{
			$query="UPDATE user SET password='$dua' WHERE id_user=".@$_SESSION['sesIdUser']."";
			querydb($query);
			?>
			<script language="JavaScript">alert('Perubahan password berhasil disimpan. Sistem logout.');
			document.location='logout.php'</script>
			<?php
		}
	}
}
?>