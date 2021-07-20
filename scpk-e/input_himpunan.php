<?php
error_reporting(0);
include("header.php");

$stat	= @$_GET['stat'];
$id		= (int)antiinjec(@$_GET['id']);
	
if($stat=="ubah") {
	$hdata=querydb("SELECT id_variabel_himpunan, himpunan, kode, `range`, kurva, id_variabel FROM himpunan WHERE id_variabel_himpunan=$id");
	$data=mysql_fetch_array($hdata);
}

if(@$_POST['stat_simpan']) {
	$id				= (int)antiinjec(@$_POST['id']);
	$id_variabel	= (int)antiinjec(@$_POST['variabel']);
	$himpunan		= antiinjec(@$_POST['himpunan']);
	$kode			= antiinjec(@$_POST['kode']);
	$range			= antiinjec(@$_POST['range']);
	$kurva			= antiinjec(@$_POST['kurva']);
	
	if($stat=="tambah") {
		$d_cek=mysql_fetch_array(querydb("SELECT count(*) FROM himpunan WHERE id_variabel=$id_variabel AND himpunan='$himpunan'"));
		if($d_cek[0]==0) {
			querydb("INSERT INTO himpunan(himpunan, id_variabel, kode, `range`, kurva)
					 VALUES ('$himpunan', $id_variabel, '$kode', '$range', '$kurva')");
			?>
			<script language="JavaScript">document.location='?page=himpunan&con=1'</script>
			<?php
		} else {
			?>
			<script language="JavaScript">alert('Nama himpunan sudah terdaftar pada variabel.'); history.go(-1); </script>
			<?php
		}
	} elseif($stat=="ubah") {
		$d_cek=mysql_fetch_array(querydb("SELECT count(*) FROM himpunan WHERE himpunan='$himpunan' AND id_variabel_himpunan<>$id"));
		if($d_cek[0]==0) {
			querydb("UPDATE himpunan SET himpunan='$himpunan', id_variabel=$id_variabel, kode='$kode', `range`='$range', kurva='$kurva' WHERE id_variabel_himpunan=$id");
			?>
			<script language="JavaScript">document.location='?page=himpunan&con=2'</script>
			<?php
		} else {
			?>
			<script language="JavaScript">alert('Nama himpunan sudah terdaftar pada variabel.'); history.go(-1); </script>
			<?php
		}
	}
} elseif($stat=="hapus" && $id!="") {
	querydb("DELETE FROM himpunan WHERE id_variabel_himpunan=$id");
	?>
	<script language="JavaScript">document.location='?page=himpunan&con=3'</script>
	<?php
}
?>

<script type="text/javascript">
// Forms Validator
$j(function() {
   $j("#form1").validate();
});
</script>

<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Himpunan</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="?page=home">Beranda</a></li>
          <li class="breadcrumb-item">Data Fuzzy</li>
          <li class="breadcrumb-item active">Himpunan</li>
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
					<h2 class="card-title" style="margin-bottom: 1px;"><?php if($stat=="tambah") { echo "Tambah"; } elseif($stat=="ubah") { echo "Ubah"; } ?> Himpunan Variabel</h2>
				</div>
				<div class="card-body">
					<form class="needs-validation" action="?page=himpunan-input&stat=<?php echo $stat; ?>" method="post" enctype="multipart/form-data" name="form1" id="form1" novalidate>
						<input type="hidden" name="stat_simpan" value="set">
						<input type="hidden" name="id" value="<?php echo $id; ?>">

					<div class="form-group row">
						<label for="variabel" class="col-md-4 col-form-label text-md-right">Variabel</label>
						
						<div class="col-md-6">
							<select class="form-control" name="variabel" required>
							<option value="">-- Pilih Variabel --</option>
								<?php
								$q_drop="SELECT id_variabel, variabel FROM variabel ORDER BY id_variabel ASC";
								$h_drop=querydb($q_drop);
								while($d_drop=mysql_fetch_assoc($h_drop)) {
								?>
								<option value="<?php echo $d_drop['id_variabel']; ?>" <?php if($d_drop['id_variabel']==$data['id_variabel']) { echo "selected"; } ?>><?php echo $d_drop['variabel']; ?></option>
								<?php } ?>
							</select>
							<div class="invalid-feedback">
								Variabel harus dipilih!
							</div>
						</div>
					</div>

					<div class="form-group row">
						<label for="kode" class="col-md-4 col-form-label text-md-right">Kode</label>
						
						<div class="col-md-6">
							<input type="text" class="form-control" name="kode" value="<?php echo"$data[kode]";?>" required>
							<div class="invalid-feedback">
								Kode tidak boleh kosong!
							</div>
						</div>
					</div>
					
					<div class="form-group row">
						<label for="himpunan" class="col-md-4 col-form-label text-md-right">Himpunan</label>
						
						<div class="col-md-6">
							<input type="text" class="form-control" name="himpunan" value="<?php echo"$data[himpunan]";?>" required>
							<div class="invalid-feedback">
								Himpunan tidak boleh kosong!
							</div>
						</div>
					</div>
					
					<div class="form-group row">
						<label for="range" class="col-md-4 col-form-label text-md-right">a-b-c-d</label>
						
						<div class="col-md-6">
							<input type="text" class="form-control" name="range" value="<?php echo"$data[range]";?>" required>
							<div class="invalid-feedback">
								a-b-c-d tidak boleh kosong!
							</div>
						</div>
					</div>

					<div class="form-group row">
						<label for="kurva" class="col-md-4 col-form-label text-md-right">Kurva</label>
						
						<div class="col-md-6">
							<select class="form-control" name="kurva" required>
							<option value="">-- Pilih Kurva --</option>
								<option value="Linear Naik" <?php if($data['kurva']=="Linear Naik") { echo "selected"; } ?>>Linear Naik</option>
								<option value="Linear Turun" <?php if($data['kurva']=="Linear Turun") { echo "selected"; } ?>>Linear Turun</option>
								<option value="Segitiga" <?php if($data['kurva']=="Segitiga") { echo "selected"; } ?>>Segitiga</option>
								<option value="Trapesium" <?php if($data['kurva']=="Trapesium") { echo "selected"; } ?>>Trapesium</option>
								<!--
								<option value="Bahu Kiri" <?php if($data['kurva']=="Bahu Kiri") { echo "selected"; } ?>>Bahu Kiri</option>
								<option value="Bahu Kanan" <?php if($data['kurva']=="Bahu Kanan") { echo "selected"; } ?>>Bahu Kanan</option>
								-->
							</select>
							<div class="invalid-feedback">
								Kurva harus dipilih!
							</div>
						</div>
					</div>
					<div class="form-group row mb-0">
						<div class="col-md-8 offset-md-4">
							<button type="submit" class="btn btn-primary" value="Simpan" name="stat_simpan">Simpan</button>
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