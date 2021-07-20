<?php
error_reporting(0);
include("header.php");

$stat	= @$_GET['stat'];
$id		= (int)antiinjec(@$_GET['id']);
	
if($stat=="ubah") {
	$hdata=querydb("SELECT id_kriteria, kriteria FROM kriteria WHERE id_kriteria=$id");
	$data=mysql_fetch_array($hdata);
}

if(@$_POST['stat_simpan']) {
	$id						= (int)antiinjec(@$_POST['id']);
	$kriteria				= antiinjec(@$_POST['kriteria']);
	
	if($stat=="tambah") {
		$d_cek=mysql_fetch_array(querydb("SELECT count(*) FROM kriteria WHERE kriteria='$kriteria'"));
		if($d_cek[0]==0) {
			move_uploaded_file($fileTmpLoc, $folder_ori.$nama_file_unik);
			querydb("INSERT INTO kriteria(kriteria)
					 VALUES ('$kriteria')");
			?>
			<script language="JavaScript">document.location='?page=kriteria&con=1'</script>
			<?php
		} else {
			?>
			<script language="JavaScript">alert('Nama Kriteria sudah terdaftar.'); history.go(-1); </script>
			<?php
		}
	} elseif($stat=="ubah") {
		$d_cek=mysql_fetch_array(querydb("SELECT count(*) FROM kriteria WHERE kriteria='$kriteria' AND id_kriteria<>$id"));
		if($d_cek[0]==0) {
			querydb("UPDATE kriteria SET kriteria='$kriteria' WHERE id_kriteria=$id");
			?>
			<script language="JavaScript">document.location='?page=kriteria&con=2'</script>
			<?php
		} else {
			?>
			<script language="JavaScript">alert('Nama Kriteria sudah terdaftar.'); history.go(-1); </script>
			<?php
		}
	}
} elseif($stat=="hapus" && $id!="") {
	querydb("DELETE FROM kriteria WHERE id_kriteria=$id");
	?>
	<script language="JavaScript">document.location='?page=kriteria&con=3'</script>
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
                <h1 class="m-0 text-dark">Kriteria</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="?page=home">Beranda</a></li>
                    <li class="breadcrumb-item">Data Fuzzy</li>
                    <li class="breadcrumb-item active">Data Kriteria</li>
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
					<h2 class="card-title" style="margin-bottom: 1px;"><?php if($stat=="tambah") { echo "Tambah"; } elseif($stat=="ubah") { echo "Ubah"; } ?> Daftar Kriteria </h2>
				</div>
				<div class="card-body">

					<form class="needs-validation" action="?page=kriteria-input&stat=<?php echo $stat; ?>" method="post" enctype="multipart/form-data" name="form1" id="form1" novalidate>
						<input type="hidden" name="stat_simpan" value="set">
						<input type="hidden" name="id" value="<?php echo $id; ?>">
						<div class="form-group row">
							<label for="nama_kriteria" class="col-md-4 col-form-label text-md-right">Nama Kriteria</label>

							<div class="col-md-6">
								<input type="text" class="form-control" name="kriteria" value="<?php echo"$data[kriteria]";?>" required>
								<div class="invalid-feedback">
									Nama Kriteria tidak boleh kosong!
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