<?php
error_reporting(0);
include("header.php");

$stat	= @$_GET['stat'];
$id		= (int)antiinjec(@$_GET['id']);
	
if($stat=="ubah") {
	$hdata=querydb("SELECT id_pasien, no_pasien, nama_lengkap, tempat_lahir, tanggal_lahir, jenis_kelamin, alamat_lengkap, no_telepon, pekerjaan, terdaftar FROM pasien WHERE id_pasien=$id");
	$data=mysql_fetch_array($hdata);
}

if(@$_POST['stat_simpan']) {	
	$id				= (int)antiinjec(@$_POST['id']);
	$no_pasien		= antiinjec(@$_POST['no_pasien']);
	$nama_lengkap	= antiinjec(@$_POST['nama_lengkap']);
	$tempat_lahir	= antiinjec(@$_POST['tempat_lahir']);
	$tanggal_lahir	= antiinjec(@$_POST['tanggal_lahir']);
	$jenis_kelamin	= antiinjec(@$_POST['jenis_kelamin']);
	$alamat_lengkap	= antiinjec(@$_POST['alamat_lengkap']);
	$no_telepon		= antiinjec(@$_POST['no_telepon']);
	$pekerjaan		= antiinjec(@$_POST['pekerjaan']);
	$terdaftar		= date("Y-m-d H:i:s");
	
	if($stat=="tambah") {
		$d_cek=mysql_fetch_array(querydb("SELECT count(*) FROM pasien WHERE no_pasien='$no_pasien'"));
		if($d_cek[0]==0) {
			querydb("INSERT INTO pasien(no_pasien, nama_lengkap, tempat_lahir, tanggal_lahir, jenis_kelamin, alamat_lengkap, no_telepon, pekerjaan, terdaftar)
					 VALUES ('$no_pasien', '$nama_lengkap', '$tempat_lahir', '$tanggal_lahir', '$jenis_kelamin', '$alamat_lengkap', '$no_telepon', '$pekerjaan', '$terdaftar')");
			?>
			<script language="JavaScript">document.location='?page=pasien&con=1'</script>
			<?php
		} else {
			?>
			<script language="JavaScript">alert('Nomor pasien sudah ada.'); history.go(-1); </script>
			<?php
		}
	} elseif($stat=="ubah") {
		$d_cek=mysql_fetch_array(querydb("SELECT count(*) FROM pasien WHERE no_pasien='$no_pasien' AND id_pasien<>$id"));
		if($d_cek[0]==0) {
			querydb("UPDATE pasien SET 
						no_pasien='$no_pasien', nama_lengkap='$nama_lengkap', tempat_lahir='$tempat_lahir', tanggal_lahir='$tanggal_lahir', 
						jenis_kelamin='$jenis_kelamin', alamat_lengkap='$alamat_lengkap', no_telepon='$no_telepon', pekerjaan='$pekerjaan'
					 WHERE id_pasien=$id");
			?>
			<script language="JavaScript">document.location='?page=pasien&con=2'</script>
			<?php
		} else {
			?>
			<script language="JavaScript">alert('Nomor pasien sudah ada.'); history.go(-1); </script>
			<?php
		}
	}
} elseif($stat=="hapus" && $id!="") {
	querydb("DELETE FROM pasien WHERE id_pasien=$id");
	?>
	<script language="JavaScript">document.location='?page=pasien&con=3'</script>
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
        <h1 class="m-0 text-dark">Pasien</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="?page=home">Beranda</a></li>
          <li class="breadcrumb-item">Data Pasien</li>
          <li class="breadcrumb-item active">Lihat Data Pasien</li>
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
          <h2 class="card-title" style="margin-bottom: 1px;"><?php if($stat=="tambah") { echo "Tambah"; } elseif($stat=="ubah") { echo "Ubah"; } ?> Pasien</h2>
        </div>
        <div class="card-body">
          <form class="needs-validation" action="?page=pasien-input&stat=<?php echo $stat; ?>" method="post" enctype="multipart/form-data" name="form1" id="form1" novalidate>
            <input type="hidden" name="stat_simpan" value="set">
            <input type="hidden" name="id" value="<?php echo $id; ?>">

				<div class="form-group row">
					<label for="validationCustom01" class="col-md-4 col-form-label text-md-right">Nomor Pasien</label>
					
					<div class="col-md-6">
						<input type="number" class="form-control" id="validationCustom01" name="no_pasien" value="<?php echo"$data[no_pasien]";?>" required>
						<div class="invalid-feedback">
							Nomor Pasien tidak boleh kosong
						</div>
					</div>
				</div>
							
				<div class="form-group row">
					<label for="validationCustom02" class="col-md-4 col-form-label text-md-right">Nama Lengkap</label>
					
					<div class="col-md-6">
						<input type="text" class="form-control" id="validationCustom02" name="nama_lengkap" value="<?php echo"$data[nama_lengkap]";?>" required>
						<div class="invalid-feedback">
                    		Nama Lengkap tidak boleh kosong
						</div>
					</div>
				</div>

				<div class="form-group row">
					<label for="validationCustom03" class="col-md-4 col-form-label text-md-right">Tempat Lahir</label>
					
					<div class="col-md-6">
						<input type="text" class="form-control" id="validationCustom03" name="tempat_lahir" value="<?php echo"$data[tempat_lahir]";?>" required>
						<div class="invalid-feedback">
							Tempat Lahir tidak boleh kosong
						</div>
					</div>
				</div>

                <div class="form-group row">
					<label for="validationCustom04" class="col-md-4 col-form-label text-md-right">Tanggal Lahir</label>
					
					<div class="col-md-6">
						<input type="date" class="form-control" id="validationCustom04" name="tanggal_lahir" value="<?php echo"$data[tanggal_lahir]";?>" required>
						<div class="invalid-feedback">
							Tanggal Lahir tidak boleh kosong
						</div>
					</div>
				</div>

				<div class="form-group row">
					<label for="validationCustom05" class="col-md-4 col-form-label text-md-right">Jenis Kelamin</label>
					
					<div class="col-md-6">
						<select class="form-control" id="validationCustom05" name="jenis_kelamin" required>
							<option value="">-- Pilih Jenis Kelamin --</option>
							<option value="L" <?php if($data['jenis_kelamin']=="L") { echo "selected"; } ?>>Laki-laki</option>
							<option value="P" <?php if($data['jenis_kelamin']=="P") { echo "selected"; } ?>>Perempuan</option>
						</select>
						<div class="invalid-feedback">
							Mohon pilih Jenis Kelamin Lansia
						</div>
					</div>
				</div>

                <div class="form-group row">
					<label for="validationCustom05" class="col-md-4 col-form-label text-md-right">Alamat Lengkap</label>
					
					<div class="col-md-6">
						<textarea class="form-control" id="validationCustom05" name="alamat_lengkap" required><?php echo"$data[alamat_lengkap]";?></textarea>
						<div class="invalid-feedback">
							Alamat Lengkap tidak boleh kosong
						</div>
					</div>
				</div>

                <div class="form-group row">
					<label for="validationCustom06" class="col-md-4 col-form-label text-md-right">No. Telepon</label>
					
					<div class="col-md-6">
						<input type="number" class="form-control" id="validationCustom06" name="no_telepon" value="<?php echo"$data[no_telepon]";?>" required>
						<div class="invalid-feedback">
							No. Telepon tidak boleh kosong
						</div>
					</div>
				</div>

                <div class="form-group row">
					<label for="validationCustom07" class="col-md-4 col-form-label text-md-right">Pekerjaan</label>
					
					<div class="col-md-6">
						<input type="text" class="form-control" id="validationCustom07" name="pekerjaan" value="<?php echo"$data[pekerjaan]";?>" required>
						<div class="invalid-feedback">
							Pekerjaan tidak boleh kosong
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