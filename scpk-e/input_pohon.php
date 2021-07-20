<?php
error_reporting(0);
include("header.php");

$stat	= @$_GET['stat'];
$id		= (int)antiinjec(@$_GET['id']);
	
if($stat=="ubah") {
	$hdata=querydb("SELECT id_kd, pertanyaan, bila_benar, bila_salah, mulai, selesai FROM konsul_diagnosa WHERE id_kd=$id");
	$data=mysql_fetch_array($hdata);
}

if(@$_POST['stat_simpan']) {
	$id						= (int)antiinjec(@$_POST['id']);
	$pertanyaan				= antiinjec(@$_POST['pertanyaan']);
	$bila_benar				= (int)antiinjec(@$_POST['bila_benar']);
	$bila_salah				= (int)antiinjec(@$_POST['bila_salah']);
	$mulai					= antiinjec(@$_POST['mulai']);
	$selesai				= antiinjec(@$_POST['selesai']);
	
	if($stat=="tambah") {
		$d_cek=mysql_fetch_array(querydb("SELECT count(*) FROM konsul_diagnosa WHERE pertanyaan='$pertanyaan'"));
		if($d_cek[0]==0) {
			move_uploaded_file($fileTmpLoc, $folder_ori.$nama_file_unik);
			querydb("INSERT INTO konsul_diagnosa(pertanyaan, bila_benar, bila_salah, mulai, selesai)
					 VALUES ('$pertanyaan', $bila_benar, $bila_salah, '$mulai', '$selesai')");
			?>
			<script language="JavaScript">document.location='?page=pohon&con=1'</script>
			<?php
		} else {
			?>
			<script language="JavaScript">alert('Nama Node sudah terdaftar.'); history.go(-1); </script>
			<?php
		}
	} elseif($stat=="ubah") {
		$d_cek=mysql_fetch_array(querydb("SELECT count(*) FROM konsul_diagnosa WHERE pertanyaan='$pertanyaan' AND id_kd<>$id"));
		if($d_cek[0]==0) {
			querydb("UPDATE konsul_diagnosa SET pertanyaan='$pertanyaan', bila_benar=$bila_benar, bila_salah=$bila_salah, mulai='$mulai', selesai='$selesai' WHERE id_kd=$id");
			?>
			<script language="JavaScript">document.location='?page=pohon&con=2'</script>
			<?php
		} else {
			?>
			<script language="JavaScript">alert('Nama Node sudah terdaftar.'); history.go(-1); </script>
			<?php
		}
	}
} elseif($stat=="hapus" && $id!="") {
	querydb("DELETE FROM konsul_diagnosa WHERE id_kd=$id");
	?>
	<script language="JavaScript">document.location='?page=pohon&con=3'</script>
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
                <h1 class="m-0 text-dark">Pohon Keputusan</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="?page=home">Beranda</a></li>
                    <li class="breadcrumb-item">Data Fuzzy</li>
                    <li class="breadcrumb-item active">Pohon Keputusan</li>
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
					<h2 class="card-title" style="margin-bottom: 1px;"><?php if($stat=="tambah") { echo "Tambah"; } elseif($stat=="ubah") { echo "Ubah"; } ?> Pohon Keputusan </h2>
				</div>
				<div class="card-body">

					<form class="needs-validation" action="?page=pohon-input&stat=<?php echo $stat; ?>" method="post" enctype="multipart/form-data" name="form1" id="form1" novalidate>
						<input type="hidden" name="stat_simpan" value="set">
						<input type="hidden" name="id" value="<?php echo $id; ?>">
						<div class="form-group row">
							<label for="nama_variabel" class="col-md-4 col-form-label text-md-right">Pertanyaan</label>

							<div class="col-md-6">
								<input type="text" class="form-control" name="pertanyaan" value="<?php echo"$data[pertanyaan]";?>" required>
								<div class="invalid-feedback">
									Pertanyaan tidak boleh kosong!
								</div>
							</div>
						</div>
						<div class="form-group row">
							<label for="nama_variabel" class="col-md-4 col-form-label text-md-right">Jika Iya</label>

							<div class="col-md-6">
								<input type="text" class="form-control" name="bila_benar" value="<?php echo"$data[bila_benar]";?>" required>
								<div class="invalid-feedback">
									Kolom tidak boleh kosong!
								</div>
							</div>
						</div>
						<div class="form-group row">
							<label for="nama_variabel" class="col-md-4 col-form-label text-md-right">Jika Tidak</label>

							<div class="col-md-6">
								<input type="text" class="form-control" name="bila_salah" value="<?php echo"$data[bila_salah]";?>" required>
								<div class="invalid-feedback">
									Kolom tidak boleh kosong!
								</div>
							</div>
						</div>
						<div class="form-group row">
							<label for="nama_variabel" class="col-md-4 col-form-label text-md-right">Mulai</label>

							<div class="col-md-6">
								<input type="text" class="form-control" name="mulai" value="<?php echo"$data[mulai]";?>" required>
								<div class="invalid-feedback">
									Kolom mulai tidak boleh kosong!
								</div>
							</div>
						</div>
						<div class="form-group row">
							<label for="nama_variabel" class="col-md-4 col-form-label text-md-right">Selesai</label>

							<div class="col-md-6">
								<input type="text" class="form-control" name="selesai" value="<?php echo"$data[selesai]";?>" required>
								<div class="invalid-feedback">
									Kolom selesai tidak boleh kosong!
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