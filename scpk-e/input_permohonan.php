<?php
error_reporting(0);
include("header.php");

$stat	= @$_GET['stat'];
$id		= (int)antiinjec(@$_GET['id']);
	
if($stat=="ubah") {
	$hdata=querydb("SELECT a.id_permohonan, a.id_pasien, a.nomor, b.no_pasien, b.nama_lengkap, b.alamat_lengkap, b.no_telepon FROM permohonan as a, pasien as b 
					WHERE a.id_pasien=b.id_pasien AND a.id_permohonan=$id");
	$data=mysql_fetch_array($hdata);
}

if(@$_POST['stat_simpan']) {
	$id				= (int)antiinjec(@$_POST['id']);
	$id_pasien		= (int)antiinjec(@$_POST['id_pasien']);
	$var_a			= @$_POST['var_a'];
	// $para			= @$_POST['para'];
	$bobot			= @$_POST['bobot'];
	$tgl			= date("Y-m-d");
	
	//Konstruksi Rule String
	$str_rule="";
	$jml=count($var_a);
	for($i=0; $i<$jml; $i++) {
		$str_rule .= "k,".$var_a[$i].",".$him_a[$i].";";
	}
	$str_rule .= "p,".$var_b.",".$him_b;
	
	if($stat=="tambah") {
		$d_cek=mysql_fetch_array(querydb("SELECT count(*) FROM permohonan WHERE id_pasien=$id_pasien AND tanggal='$tgl'"));
		if($d_cek[0]==0) {
			$no_kd="";
			$q_cek="SELECT nomor FROM permohonan ORDER BY nomor DESC limit 0, 1";
			$h_cek=querydb($q_cek);
			$d_cek=mysql_fetch_row($h_cek);
			if($d_cek[0]=="") {
				$no_kd=sprintf("%010d", 1);
			} else {
				$no_kd=$d_cek[0];
				$no_kd=intval($no_kd)+1;
				$no_kd=sprintf("%010d", $no_kd);
			}

			querydb("INSERT INTO permohonan(id_pasien, nomor, tanggal)
					 VALUES ($id_pasien, '$no_kd', '$tgl')");
			$permohonan=mysql_fetch_assoc(querydb("SELECT id_permohonan FROM permohonan WHERE nomor='".$no_kd."'"));
			for($i=0; $i<count($var_a); $i++){
				$arr_kondisi=array();
				$arr_kondisi=explode("+", $bobot[$i]);
				querydb("INSERT INTO nilai(id_permohonan, id_variabel, id_variabel_parameter, bobot, status)
						 VALUES (".(int)$permohonan['id_permohonan'].", ".(int)$var_a[$i].", ".(int)$arr_kondisi[0].", ".$arr_kondisi[1].", 1)");
				
				// querydb("INSERT INTO ft_value(id_permohonan, id_variabel, bobot, status)
				// 	VALUES (".(int)$permohonan['id_permohonan'].", ".(int)$var_a[$i].", ".$arr_kondisi[0].", 1)");
		}
			?>
			<script language="JavaScript">document.location='?page=solving-konsul&idtanya=2'</script>
			<?php
		} else {
			?>
			<script language="JavaScript">alert('Pasien sudah melakukan permohonan hari ini.'); history.go(-1); </script>
			<?php
		}
	} elseif($stat=="ubah") {
		$d_cek=mysql_fetch_array(querydb("SELECT count(*) FROM permohonan WHERE (id_pasien=$id_pasien AND tanggal='$tgl') AND id_permohonan<>$id"));
		if($d_cek[0]==0) {
			querydb("UPDATE permohonan SET id_pasien=".$id_pasien." WHERE id_permohonan=$id");
			querydb("UPDATE nilai SET status=0 WHERE id_permohonan=$id");
			for($i=0; $i<count($var_a); $i++){
				$arr_kondisi=array();
				$arr_kondisi=explode("+", $bobot[$i]);
				$cek=mysql_num_rows(querydb("SELECT id_nilai FROM nilai WHERE id_permohonan=$id AND id_variabel=".(int)$var_a[$i].""));
				if($cek==0) {
					querydb("INSERT INTO nilai(id_permohonan, id_variabel, id_variabel_parameter, bobot, status)
							 VALUES ($id, ".(int)$var_a[$i].", ".(int)$arr_kondisi[0].", ".$arr_kondisi[1].", 1)");
				} else {
					querydb("UPDATE nilai SET id_variabel_parameter=".(int)$arr_kondisi[0].", bobot=".$arr_kondisi[1].", status=1
							 WHERE id_permohonan=$id AND id_variabel=".(int)$var_a[$i]."");
				}
			}
			?>
			<script language="JavaScript">document.location='?page=permohonan&con=2'</script>
			<?php
		} else {
			?>
			<script language="JavaScript">alert('Pasien sudah melakukan permohonan dan terdaftar hari ini.'); history.go(-1); </script>
			<?php
		}
	}
} elseif($stat=="hapus" && $id!="") {
	querydb("DELETE FROM permohonan WHERE id_permohonan=$id");
	querydb("DELETE FROM nilai WHERE id_permohonan=$id");
	?>
	<script language="JavaScript">document.location='?page=permohonan&con=3'</script>
	<?php
}
?>

<script src="ajax/cek_nasabah.js"></script>
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
				<h1 class="m-0 text-dark" style="margin-bottom: 1px;">Data Permohonan</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="?page=home">Beranda</a></li>
					<li class="breadcrumb-item">Konsultasi</li>
					<li class="breadcrumb-item active">Data Permohonan</li>
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
					<h2 class="card-title" style="margin-bottom: 1px;"><?php if($stat=="tambah") { echo "Tambah"; } elseif($stat=="ubah") { echo "Ubah"; } ?> Permohonan</h2>
				</div>
				<div class="card-body">

					<?php if($stat=="tambah") { ?>
					<form class="needs-validation" action="?page=permohonan-input&stat=<?php echo $stat; ?>" method="post" enctype="multipart/form-data" name="form1" id="form1" novalidate>
						<input type="hidden" name="stat_simpan" value="set">
						<div class="form-style-2" >
							<table border="0" cellpadding="0" cellspacing="0">
								<tr>
									<th width="300">
										<a style="margin-left: 160px; font-size: 15px; float: right;">Nomor Pasien</a>
									</th>
									<th width="760">
										<div class="col-md-6">
											<input style="line-height: 3;" type='text' name='no_pasien' id='no_pasien' size='15' minlength='3' maxlength='16' class='form-control required' onkeyup='showRate(this.value);' title='Masukkan dahulu nomor nasabah'>
										</div>	
									</th>
								</tr>
								<tr>
									<td colspan="2">
										<div id="txtHint">
											<style>
												table.tabel_dalam  { border-collapse:collapse; border:0px; padding:0px; }
												table.tabel_dalam tr { border:0px; }
												table.tabel_dalam tr td { border:0px; }
											</style>
											<table class="tabel_dalam">
												<tr>
													<td width="300">
														<a style="margin-left: 160px; font-size: 15px; float: right;">Nama Pasien</a>
													</td>
													<td width="760">
														<div class="col-md-6">
															: - <input type='hidden' name='id_pasien' class='form-control required' title=' [ Belum ada data Nasabah Terpilih. ]'>
														</div>
													</td>
												</tr>
												<tr>
													<td>
														<a style="margin-left: 160px; font-size: 15px; float: right;">No. Telepon</a>
													</td>
													<td>
														<div class="col-md-6">
															: -
														</div>
													</td>
												</tr>
												<tr>
													<td><a style="margin-left: 160px; font-size: 15px; float: right;">Alamat</a></td>
													<td>
														<div class="col-md-6">
															: -
														</div>
													</td>
												</tr>
											</table>
										</div>
									</td>
								</tr>
									<?php
										$q_var=querydb("SELECT id_variabel, variabel FROM variabel WHERE jenis=1 ORDER BY id_variabel ASC");
										while($d_var=mysql_fetch_assoc($q_var)) {
									?>
								<tr>
									<th width="300">
										<a style="font-size: 15px; margin-top: 15px; float: right;"><?php echo $d_var['variabel']; ?></a>
									</th>
									
									<td width="760">
										<input type="hidden" name="var_a[]" value="<?php echo $d_var['id_variabel']; ?>" required/>
										<div class="col-md-6">
											<select name="bobot[]" class="input-field" style="padding:6px 5px; border:1px solid #CCC; border-radius:3px;" required>
												<option value=""> </option>
												<?php
													$q_par=querydb("SELECT id_variabel_parameter, parameter, bobot FROM bobot WHERE id_variabel=".$d_var['id_variabel']." ORDER BY id_variabel_parameter ASC");
													// $h_drop=querydb($q_par);
													while($d_par=mysql_fetch_assoc($q_par)) {
												?>
												<option value="<?php echo $d_par['id_variabel_parameter']."+".$d_par['bobot']; ?>"><?php echo $d_par['parameter']; ?></option>
												<?php } ?>
											</select>  
											<div class="invalid-feedback">
												Data pemeriksaan tidak boleh kosong!
											</div>
										</div>
									<td>
								</tr>
								<?php } ?>
								<tr>
									<td colspan="2">
										<div class="col-md-4" style="margin-left: 297px; margin-top: 10px;">
											<input type="submit" value="Simpan" class="btn btn-primary" name="stat_simpan"/>
											<input type='button' class="btn btn-warning" onclick="window.history.back();" value="Batal">
										</div>
									</td>
								</tr>
							</table>  
						</div>    
					</form>

					<?php } elseif($stat=="ubah") { ?>
					<form action="?page=permohonan-input&stat=<?php echo $stat; ?>" method="post" enctype="multipart/form-data" name="form1" id="form1">
						<input type="hidden" name="stat_simpan" value="set">
						<input type="hidden" name="id" value="<?php echo $id; ?>">
						<div class="form-style-2" >
							<table border="0" cellpadding="0" cellspacing="0">
								<tr>
									<th width="300">
										<a style="margin-left: 160px; font-size: 15px; float: right;">Nomor Permohonan<a>
									</th>
									<th width="760">
										<div class="col-md-6">
											<input style="margin-bottom: 8px;" type='text' name='nomor' id='nomor' disabled="disabled" value='<?php echo $data['nomor']; ?>' size='15' minlength='3' class='form-control' maxlength='16'>
										</div>
									</th>
								</tr>
								<tr>
									<th width="300">
										<a style="margin-left: 160px; font-size: 15px; float: right;">Nomor Pasien</a>
									</th>
									<th width="760">
										<div class="col-md-6">
											<input style="margin-bottom: 5px;" type='text' name='no_pasien' id='no_pasien' value='<?php echo $data['no_pasien']; ?>' size='15' minlength='3' maxlength='16' class='form-control required' onkeyup='showRate(this.value);' title='Masukkan dahulu nomor nasabah'>
										</div>
									</th>
								</tr>
								<tr>
									<td colspan="2">
										<div id="txtHint">
											<style>
												table.tabel_dalam  { border-collapse:collapse; border:0px; padding:0px; }
												table.tabel_dalam tr { border:0px; }
												table.tabel_dalam tr td { border:0px; }
											</style>
											<table class="tabel_dalam">
												<tr>
													<td width="300">
														<a style="margin-left: 160px; font-size: 15px; float: right;">Nama Pasien</a>
													</td>
													<td width="760">
														<div class="col-md-6">
															: <?php echo $data['nama_lengkap']; ?> <input type='hidden' name='id_pasien' value='<?php echo $data['id_pasien']; ?>' class='input-field required' title=' [ Belum ada data Nasabah Terpilih. ]'>
														</div>
													</td>
												</tr>
												<tr>
													<td>
														<a style="margin-left: 160px; font-size: 15px; float: right;">No. Telepon</a>
													</td>
													<td>
														<div class="col-md-6">
															: <?php echo $data['no_telepon']; ?>
														</div>
													</td>
												</tr>
												<tr>
													<td>
														<a style="margin-left: 160px; font-size: 15px; float: right;">Alamat</a>
													</td>
													<td>
														<div class="col-md-6">
															: <?php echo $data['alamat_lengkap']; ?>
														</div>
													</td>
												</tr>
											</table>
										</div>
									</td>
								</tr>
								<?php
									$q_var=querydb("SELECT id_variabel, variabel FROM variabel WHERE jenis=1 ORDER BY id_variabel ASC");
									while($d_var=mysql_fetch_assoc($q_var)) {
								?>
								<tr>
									<th width="300">
										<a style="margin-left: 100px; font-size: 15px; line-height: 3; float: right;">
											<?php echo $d_var['variabel']; ?>
										</a>
									</th>
									<td width="760">
										<input type="hidden" name="var_a[]" value="<?php echo $d_var['id_variabel']; ?>" required/>
										<!-- <?php
											// $q_drop="SELECT id_nilai, bobot FROM ft_value WHERE id_variabel=".$d_var['id_variabel']." AND id_permohonan=".(int)$data['id_permohonan']." AND status=1";
											// $h_drop=querydb($q_drop);
											// while($d_drop=mysql_fetch_assoc($h_drop)) {
										?> -->

										<div class="col-md-6">
											<select name="bobot[]" class="form-control" required>
												<?php
												$q_par=querydb("SELECT id_variabel_parameter, bobot, parameter FROM bobot WHERE id_variabel=".$d_var['id_variabel']." ORDER BY id_variabel_parameter ASC");
												while($d_par=mysql_fetch_assoc($q_par)) {
													$q_kondisi="SELECT * FROM nilai  
																WHERE id_variabel_parameter=".(int)$d_par['id_variabel_parameter']." AND
																	id_permohonan=".(int)$data['id_permohonan']." AND status=1";
													$h_kondisi=querydb($q_kondisi);
													$d_kondisi=mysql_fetch_assoc($h_kondisi);
	
													//echo $q_kondisi."<hr>";
												?>
												<option value="<?php echo $d_par['id_variabel_parameter']."+".$d_par['bobot']; ?>" <?php if($d_par['id_variabel_parameter']==$d_kondisi['id_variabel_parameter']) { echo "selected"; } ?>><?php echo $d_par['parameter']; ?></option>												
												<?php } ?>
											</select>
											<div class="invalid-feedback">
												Data pemeriksaan tidak boleh kosong!
											</div>
										</div>
										
									<td>
								</tr>
								<?php } ?> 
								<tr>
									<td colspan="2">
										<div class="col-md-4" style="margin-left: 297px; margin-top: 10px;">
											<input type="submit" value="Simpan" class="btn btn-primary" name="stat_simpan"/>
											<input type='button' class="btn btn-warning" onclick="window.history.back();" value="Batal">
										</div>
									</td>
								</tr>
							</table>  
						</div>    
					</form>
					<?php } ?>
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