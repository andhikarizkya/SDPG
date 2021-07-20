<?php
error_reporting(0);
include("header.php");

$stat	= @$_GET['stat'];
$id		= (int)antiinjec(@$_GET['id']);
	
if($stat=="ubah") {
	$hdata=querydb("SELECT id_relasi, id_node, id_resiko FROM relasi WHERE id_relasi=$id");
	$data=mysql_fetch_array($hdata);
}

if(@$_POST['stat_simpan']) {
	$id				= (int)antiinjec(@$_POST['id']);
    $id_node	    = (int)antiinjec(@$_POST['id_node']);
    $id_resiko   	= (int)antiinjec(@$_POST['id_resiko']);
	
	if($stat=="tambah") {
		$d_cek=mysql_fetch_array(querydb("SELECT count(*) FROM relasi WHERE id_node=$id_node"));
		if($d_cek[0]==0) {
			move_uploaded_file($fileTmpLoc, $folder_ori.$nama_file_unik);
			querydb("INSERT INTO relasi(id_node, id_resiko)
					 VALUES ($id_node, $id_resiko)");
			?>
			<script language="JavaScript">document.location='?page=relasi&con=1'</script>
			<?php
		} else {
			?>
			<script language="JavaScript">alert('Relasi sudah terdaftar.'); history.go(-1); </script>
			<?php
		}
	} elseif($stat=="ubah") {
		$d_cek=mysql_fetch_array(querydb("SELECT count(*) FROM relasi WHERE id_node=$id_node AND id_relasi<>$id"));
		if($d_cek[0]==0) {
			querydb("UPDATE relasi SET id_node=$id_node, id_resiko=$id_resiko WHERE id_relasi=$id");
			?>
			<script language="JavaScript">document.location='?page=relasi&con=2'</script>
			<?php
		} else {
			?>
			<script language="JavaScript">alert('Relasi sudah terdaftar.'); history.go(-1); </script>
			<?php
		}
	}
} elseif($stat=="hapus" && $id!="") {
	querydb("DELETE FROM relasi WHERE id_relasi=$id");
	?>
	<script language="JavaScript">document.location='?page=relasi&con=3'</script>
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
                <h1 class="m-0 text-dark">Relasi</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="?page=home">Beranda</a></li>
                    <li class="breadcrumb-item">Data Fuzzy</li>
                    <li class="breadcrumb-item active">Data Relasi</li>
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
					<h2 class="card-title" style="margin-bottom: 1px;"><?php if($stat=="tambah") { echo "Tambah"; } elseif($stat=="ubah") { echo "Ubah"; } ?> Daftar relasi </h2>
				</div>
				<div class="card-body">

					<form class="needs-validation" action="?page=relasi-input&stat=<?php echo $stat; ?>" method="post" enctype="multipart/form-data" name="form1" id="form1" novalidate>
						<input type="hidden" name="stat_simpan" value="set">
						<input type="hidden" name="id" value="<?php echo $id; ?>">
						<div class="form-group row">
							<label for="nama_Node" class="col-md-4 col-form-label text-md-right">Id Node</label>

							<div class="col-md-6">
                                <select name="id_node" class="form-control" required>
                                    <option value="">-- Pilih Id Node --</option>
                                    <?php
                                    $q_drop="SELECT id_kd, pertanyaan FROM konsul_diagnosa ORDER BY id_kd ASC";
                                    $h_drop=querydb($q_drop);
                                    while($d_drop=mysql_fetch_assoc($h_drop)) {
                                    ?>
                                    <option value="<?php echo $d_drop['id_kd']; ?>" <?php if($d_drop['id_kd']==$data['id_node']) { echo "selected"; } ?>><?php echo $d_drop['id_kd']." - ".$d_drop['pertanyaan']; ?></option>
                                    <?php } ?>
                                </select> 
								<div class="invalid-feedback">
									Mohon pilih Id Node!
								</div>
                            </div>
						</div>
                        <div class="form-group row">
							<label for="nama_Kriteria" class="col-md-4 col-form-label text-md-right">Id Kriteria</label>

							<div class="col-md-6">
                                <select name="id_resiko" class="form-control" required>
                                    <option value="">-- Pilih Id Risiko --</option>
                                    <?php
                                    $q_drop="SELECT id_resiko, resiko FROM resiko ORDER BY id_resiko ASC";
                                    $h_drop=querydb($q_drop);
                                    while($d_drop=mysql_fetch_assoc($h_drop)) {
                                    ?>
                                    <option value="<?php echo $d_drop['id_resiko']; ?>" <?php if($d_drop['id_resiko']==$data['id_resiko']) { echo "selected"; } ?>><?php echo $d_drop['id_resiko']." - ".$d_drop['resiko']; ?></option>
                                    <?php } ?>
                                </select> 
								<div class="invalid-feedback">
									Mohon pilih Id Risiko!
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