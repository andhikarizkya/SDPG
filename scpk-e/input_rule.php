<?php
error_reporting(0);
include("header.php");

$stat	= @$_GET['stat'];
$id		= (int)antiinjec(@$_GET['id']);
	
if($stat=="ubah") {
	$hdata=querydb("SELECT id_rule, rule, kode FROM rule WHERE id_rule=$id");
	$data=mysql_fetch_array($hdata);
}

if(@$_POST['stat_simpan']) {
	$id				= (int)antiinjec(@$_POST['id']);
	$variabel		= (int)antiinjec(@$_POST['variabel']);
	$him_a			= @$_POST['him_a'];
	$him_b			= @$_POST['him_b'];
	$var_a			= @$_POST['var_a'];
	$var_b			= @$_POST['var_b'];
	$kode			= antiinjec(@$_POST['kode']);
	
	//Konstruksi Rule String
	$str_rule="";
	$jml=count($var_a);
	for($i=0; $i<$jml; $i++) {
		$str_rule .= "k,".$var_a[$i].",".$him_a[$i].";";
	}
	$str_rule .= "p,".$var_b.",".$him_b;
	
	if($stat=="tambah") {
		$d_cek=mysql_fetch_array(querydb("SELECT count(*) FROM rule WHERE kode='$kode' OR rule='$str_rule'"));
		if($d_cek[0]==0) {
			querydb("INSERT INTO rule(rule, kode)
					 VALUES ('$str_rule', '$kode')");
			?>
			<script language="JavaScript">document.location='?page=rule&con=1'</script>
			<?php
		} else {
			?>
			<script language="JavaScript">alert('Rule atau Kode sudah terdaftar.'); history.go(-1); </script>
			<?php
		}
	} elseif($stat=="ubah") {
		$d_cek=mysql_fetch_array(querydb("SELECT count(*) FROM rule WHERE (kode='$kode' OR rule='$rule') AND id_rule<>$id"));
		if($d_cek[0]==0) {
			querydb("UPDATE rule SET rule='$str_rule', kode='$kode' WHERE id_rule=$id");
			?>
			<script language="JavaScript">document.location='?page=rule&con=2'</script>
			<?php
		} else {
			?>
			<script language="JavaScript">alert('Rule atau Kode sudah terdaftar.'); history.go(-1); </script>
			<?php
		}
	}
} elseif($stat=="hapus" && $id!="") {
	querydb("DELETE FROM rule WHERE id_rule=$id");
	?>
	<script language="JavaScript">document.location='?page=rule&con=3'</script>
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
				<h1 class="m-0 text-dark" style="margin-bottom: 1px;">Rule</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="?page=home">Beranda</a></li>
					<li class="breadcrumb-item">Data Fuzzy</li>
					<li class="breadcrumb-item active">Data Rule</li>
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
					<h2 class="card-title" style="margin-bottom: 1px;"><?php if($stat=="tambah") { echo "Tambah"; } elseif($stat=="ubah") { echo "Ubah"; } ?> <i>Rule</i></h2>
				</div>
				<div class="card-body">
					<?php if($stat=="tambah") { ?>
					<form class="needs-validation" action="?page=rule-input&stat=<?php echo $stat; ?>" method="post" enctype="multipart/form-data" name="form1" id="form1" novalidate>
						<input type="hidden" name="stat_simpan" value="set">
						<input type="hidden" name="id" value="<?php echo $id; ?>">
					
					<div class="form-group row">
						<label for="kode" class="col-md-4 col-form-label text-md-right">Kode</label>

						<div class="col-md-6">
							<input type="text" class="form-control required" name="kode" value="<?php echo"$data[kode]";?>" required>
							<div class="invalid-feedback">
								Kode tidak boleh kosong!
							</div>
						</div>
					</div>
					
					<?php
					$q_var=querydb("SELECT id_variabel, variabel FROM variabel WHERE jenis=1 ORDER BY id_variabel ASC");
					while($d_var=mysql_fetch_assoc($q_var)) {
					?>

					<div class="form-group row">
						<label for="variabel" class="col-md-4 col-form-label text-md-right"><?php echo $d_var['variabel']; ?></label>
						
						<div class="col-md-6">
							<input type="hidden" name="var_a[]" value="<?php echo $d_var['id_variabel']; ?>" />
							<select class="form-control required" name="him_a[]" required>
								<option value=""> </option>
								<?php
								$q_drop="SELECT id_variabel_himpunan, kode, himpunan FROM himpunan WHERE id_variabel=$d_var[id_variabel] ORDER BY id_variabel_himpunan ASC";
								$h_drop=querydb($q_drop);
								while($d_drop=mysql_fetch_assoc($h_drop)) {
								?>
								<option value="<?php echo $d_drop['id_variabel_himpunan']; ?>"><?php echo $d_drop['kode']." - ".$d_drop['himpunan']; ?></option>
								<?php } ?>
							</select>
							<div class="invalid-feedback">
								Data rule tidak boleh kosong!
							</div>
						</div>
					</div>
					<?php } ?> 
					
					<div class="form-group row mb-0">
						<div class="col-md-8 offset-md-4">
							&nbsp;
							Maka
							&nbsp;
						</div>
					</div>

					<?php
					$q_var=querydb("SELECT id_variabel, variabel FROM variabel WHERE jenis=2 ORDER BY id_variabel DESC LIMIT 0, 1");
					while($d_var=mysql_fetch_assoc($q_var)) {
					?>

					<div class="form-group row">
						<label for="variabel" class="col-md-4 col-form-label text-md-right"><?php echo $d_var['variabel']; ?></label>
						
						<div class="col-md-6">
							<input type="hidden" name="var_b" value="<?php echo $d_var['id_variabel']; ?>" />
							<select class="form-control required" name="him_b" required>
								<option value=""> </option>
								<?php
								$q_drop="SELECT id_variabel_himpunan, kode, himpunan FROM himpunan WHERE id_variabel=$d_var[id_variabel] ORDER BY id_variabel_himpunan ASC";
								$h_drop=querydb($q_drop);
								while($d_drop=mysql_fetch_assoc($h_drop)) {
								?>
								<option value="<?php echo $d_drop['id_variabel_himpunan']; ?>"><?php echo $d_drop['kode']." - ".$d_drop['himpunan']; ?></option>
								<?php } ?>
							</select>
							<div class="invalid-feedback">
								Risiko tidak boleh kosong!
							</div>
						</div>
					</div>
					<?php } ?> 

					<div class="form-group row mb-0">
						<div class="col-md-8 offset-md-4">
							<button type="submit" class="btn btn-primary" value="Simpan" name="stat_simpan">Simpan</button>
						</div>
					</div>
					</form>

					<?php } elseif($stat=="ubah") { ?>
					<form action="?page=rule-input&stat=<?php echo $stat; ?>" method="post" enctype="multipart/form-data" name="form1" id="form1">
						<input type="hidden" name="stat_simpan" value="set">
						<input type="hidden" name="id" value="<?php echo $id; ?>">

					<div class="form-group row">
						<label for="kode" class="col-md-4 col-form-label text-md-right">Kode</label>
						
						<div class="col-md-6">
							<input type="text" class="form-control required" name="kode" value="<?php echo"$data[kode]";?>">
						</div>
					</div>

					<?php
						$q_var=querydb("SELECT id_variabel, variabel FROM variabel WHERE jenis=1 ORDER BY id_variabel ASC");
						while($d_var=mysql_fetch_assoc($q_var)) {
							$rule=array(); $him_arr=array(); $cocok=array(); $him=0;
							$rule=explode(";", $data['rule']);
							$cari="k,$d_var[id_variabel]";
							foreach ($rule as $key=>$value){
								if (strpos($value, $cari) === 0){
									$cocok[] = $value;
								} else if (strcmp($cari, $value) < 0){
								break;
								}
							}
							$him_arr=explode(",", $cocok[0]);
							$him=(int)$him_arr[2]; //id_himpunan
					?>

					<div class="form-group row">
						<label for="variabel" class="col-md-4 col-form-label text-md-right"><?php echo $d_var['variabel']; ?></label>
						
						<div class="col-md-6">
							<input type="hidden" name="var_a[]" value="<?php echo $d_var['id_variabel']; ?>" />
							<select class="form-control required" name="him_a[]">
								<option value=""> </option>
									<?php
									$q_drop="SELECT id_variabel_himpunan, kode, himpunan FROM himpunan WHERE id_variabel=$d_var[id_variabel] ORDER BY id_variabel_himpunan ASC";
									$h_drop=querydb($q_drop);
									while($d_drop=mysql_fetch_assoc($h_drop)) {
									?>
								<option value="<?php echo $d_drop['id_variabel_himpunan']; ?>" <?php if($d_drop['id_variabel_himpunan']==$him) { echo "selected"; } ?>><?php echo $d_drop['kode']." - ".$d_drop['himpunan']; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<?php } ?> 

					<div class="form-group row mb-0">
						<div class="col-md-8 offset-md-4">
							&nbsp;
							Maka
						</div>
					</div>

					<?php
					$q_var=querydb("SELECT id_variabel, variabel FROM variabel WHERE jenis=2 ORDER BY id_variabel DESC LIMIT 0, 1");
						while($d_var=mysql_fetch_assoc($q_var)) {
						$rule=array(); $him_arr=array(); $cocok=array(); $him=0;
						$rule=explode(";", $data['rule']);
						$cari="p,$d_var[id_variabel]";
						foreach ($rule as $key=>$value){
							if (strpos($value, $cari) === 0){
								$cocok[] = $value;
							} else if (strcmp($cari, $value) < 0){
								break;
							}
						}
						$him_arr=explode(",", $cocok[0]);
						$him=(int)$him_arr[2]; //id_himpunan
					?>

					<div class="form-group row">
						<label for="variabel" class="col-md-4 col-form-label text-md-right"><?php echo $d_var['variabel']; ?></label>
						
						<div class="col-md-6">
							<input type="hidden" name="var_b" value="<?php echo $d_var['id_variabel']; ?>" />
							<select class="form-control required" name="him_b">
								<?php
									$q_drop="SELECT id_variabel_himpunan, kode, himpunan FROM himpunan WHERE id_variabel=$d_var[id_variabel] ORDER BY id_variabel_himpunan ASC";
									$h_drop=querydb($q_drop);
										while($d_drop=mysql_fetch_assoc($h_drop)) {
								?>
								<option value="<?php echo $d_drop['id_variabel_himpunan']; ?>" <?php if($d_drop['id_variabel_himpunan']==$him) { echo "selected"; } ?>><?php echo $d_drop['kode']." - ".$d_drop['himpunan']; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<?php } ?> 

					<div class="form-group row mb-0">
						<div class="col-md-8 offset-md-4">
							<button type="submit" class="btn btn-primary" value="Simpan" name="stat_simpan">Simpan</button>
						</div>
					</div>
					
					</form>
						<?php } ?>
				</div>  
			</div>  
		</div>  
	</div>  
</section>  