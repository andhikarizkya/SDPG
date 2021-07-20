<?php
error_reporting(0);
include("header.php");

$stat	= @$_GET['stat'];
$id		= (int)antiinjec(@$_GET['id']);
	
if($stat=="ubah") {
	$hdata=querydb("SELECT id_variabel_parameter, parameter, id_variabel, bobot FROM bobot WHERE id_variabel_parameter=$id");
	$data=mysql_fetch_array($hdata);
}

if(@$_POST['stat_simpan']) {
	$id				= (int)antiinjec(@$_POST['id']);
	$id_variabel	= (int)antiinjec(@$_POST['variabel']);
	$parameter		= antiinjec(@$_POST['parameter']);
	$bobot			= antiinjec(@$_POST['bobot']);
	
	if($stat=="tambah") {
		$d_cek=mysql_fetch_array(querydb("SELECT count(*) FROM bobot WHERE parameter='$parameter' AND id_variabel=$id_variabel"));
		if($d_cek[0]==0) {
			querydb("INSERT INTO bobot(parameter, id_variabel, bobot)
					 VALUES ('$parameter', $id_variabel, $bobot)");
			?>
			<script language="JavaScript">document.location='?page=parameter&con=1'</script>
			<?php
		} else {
			?>
			<script language="JavaScript">alert('Nama parameter sudah terdaftar.'); history.go(-1); </script>
			<?php
		}
	} elseif($stat=="ubah") {
		$d_cek=mysql_fetch_array(querydb("SELECT count(*) FROM bobot WHERE parameter='$parameter' AND id_variabel=$id_variabel AND id_variabel_parameter<>$id"));
		if($d_cek[0]==0) {
			querydb("UPDATE bobot SET bobot='$bobot', parameter='$parameter', id_variabel=$id_variabel WHERE id_variabel_parameter=$id");
			?>
			<script language="JavaScript">document.location='?page=parameter&con=2'</script>
			<?php
		} else {
			?>
			<script language="JavaScript">alert('Nama parameter sudah terdaftar.'); history.go(-1); </script>
			<?php
		}
	}
} elseif($stat=="hapus" && $id!="") {
	querydb("DELETE FROM bobot WHERE id_variabel_parameter=$id");
	?>
	<script language="JavaScript">document.location='?page=parameter&con=3'</script>
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
                <h1 class="m-0 text-dark">Parameter</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="?page=home">Beranda</a></li>
                    <li class="breadcrumb-item">Data Fuzzy</li>
                    <li class="breadcrumb-item active">Data Parameter</li>
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
					<h2 class="card-title" style="margin-bottom: 1px;"><?php if($stat=="tambah") { echo "Tambah"; } elseif($stat=="ubah") { echo "Ubah"; } ?> Parameter Variabel</h2>
				</div>
				<div class="card-body">

					<form class="needs-validation" action="?page=parameter-input&stat=<?php echo $stat; ?>" method="post" enctype="multipart/form-data" name="form1" id="form1" novalidate>
						<input type="hidden" name="stat_simpan" value="set">
						<input type="hidden" name="id" value="<?php echo $id; ?>">
						<div class="form-style-2" >
							<div class="form-group row">
								<label class="col-md-4 col-form-label text-md-right">Variabel</label>

								<div class="col-md-6">
									<select name="variabel" class="form-control" required>
										<option value="">-- Pilih Variabel --</option>
										<?php
										$q_drop="SELECT id_variabel, variabel FROM variabel WHERE jenis=1 ORDER BY id_variabel ASC";
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
								<label class="col-md-4 col-form-label text-md-right">Nama Parameter</label>
							
								<div class="col-md-6">
									<input type="text" size="50" name="parameter" maxlength="50" class="form-control" value="<?php echo"$data[parameter]";?>" required>
									<div class="invalid-feedback">
										Nama Parameter tidak boleh kosong!
									</div>
								</div>
							</div>

							<div class="form-group row">
								<label class="col-md-4 col-form-label text-md-right">Bobot</label>
							
								<div class="col-md-6">
									<input type="number" size="10" step="0.01" style="width:100px;" name="bobot" maxlength="6" class="form-control" value="<?php echo"$data[bobot]";?>" required>
									<div class="invalid-feedback">
										Bobot tidak boleh kosong!
									</div>
								</div>
							</div>

							<div class="form-group row mb-0">
								<div class="col-md-8 offset-md-4">
									<input type="submit" value="Simpan" class="btn btn-primary" name="stat_simpan"/>
								</div>
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