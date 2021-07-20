
<?php
$stat	= @$_GET['stat'];
$id		= (int)antiinjec(@$_GET['id']);
	
$h_permohonan=querydb("SELECT a.id_permohonan, a.id_pasien, a.nomor, b.no_pasien, b.nama_lengkap, b.alamat_lengkap, b.no_telepon FROM permohonan as a, pasien as b 
					   WHERE a.id_pasien=b.id_pasien AND a.id_permohonan=$id");
$d_permohonan=mysql_fetch_assoc($h_permohonan);

//TEST : echo $d_permohonan['id_permohonan'];
$arr_derajat=array();

//Ambil list variabel untuk dihitung 
$h_variabel=querydb("SELECT DISTINCT(id_variabel), bobot as bobotnya FROM nilai WHERE id_permohonan=$id AND status=1 GROUP BY id_Variabel ORDER BY id_variabel ASC");
while($d_variabel=mysql_fetch_assoc($h_variabel)) {
	
	$bobot=$d_variabel['bobotnya']; //Nilai bobot variabel Pemohon
	
	//TEST : echo $d_variabel['id_variabel']."-".$d_variabel['bobotnya']."<br>";
	//Ambil Himpunan
	$arr_himpunan=array();
	$h_himpunan=querydb("SELECT id_variabel_himpunan, himpunan, kode, `range`, kurva FROM himpunan WHERE id_variabel=".(int)$d_variabel['id_variabel']."");
	while($d_himpunan=mysql_fetch_assoc($h_himpunan)){
		
		//Hitung derajat keanggotaan
		$derajat=0;
		$rangenya=array();
		$rangenya=explode("-", $d_himpunan['range']);
		
		if($d_himpunan['kurva']=="Linear Turun") {
			if($rangenya[0]<=$bobot && $rangenya[1]>=$bobot){
				if($bobot<=$rangenya[0]) { $derajat=1; }
				elseif($bobot>=$rangenya[1]) { $derajat=0; }
				elseif($bobot>$rangenya[0] && $bobot<$rangenya[1]) { $derajat=($rangenya[1]-$bobot)/($rangenya[1]-$rangenya[0]); }
			}
		} elseif ($d_himpunan['kurva']=="Linear Naik") {
			if($rangenya[0]<=$bobot && $rangenya[1]>=$bobot){
				if($bobot<=$rangenya[0]) { $derajat=0; }
				elseif($bobot>=$rangenya[1]) { $derajat=1; }
				elseif($bobot>$rangenya[0] && $bobot<$rangenya[1]) { $derajat=($bobot-$rangenya[0])/($rangenya[1]-$rangenya[0]); }
			}
		} elseif ($d_himpunan['kurva']=="Segitiga") {
			if($rangenya[0]<=$bobot && $rangenya[2]>=$bobot){
				if($bobot<=$rangenya[0] || $bobot>=$rangenya[2]) { $derajat=0; }
				elseif($bobot>$rangenya[0] && $bobot<=$rangenya[1]) { $derajat=($bobot-$rangenya[0])/($rangenya[1]-$rangenya[0]); }
				elseif($bobot>=$rangenya[1] && $bobot<$rangenya[2]) { $derajat=($rangenya[2]-$bobot)/($rangenya[2]-$rangenya[1]); }
			}
		} elseif ($d_himpunan['kurva']=="Trapesium") {
			if($rangenya[0]<=$bobot && $rangenya[3]>=$bobot){
				if($bobot<=$rangenya[0]) { $derajat=0; }
				elseif($bobot>$rangenya[0] && $bobot<=$rangenya[1]) { $derajat=($bobot-$rangenya[0])/($rangenya[1]-$rangenya[0]); }
				elseif($bobot>=$rangenya[1] && $bobot<=$rangenya[2]) { $derajat=1; }
				elseif($bobot>=$rangenya[2] && $bobot<$rangenya[3]) { $derajat=($rangenya[3]-$bobot)/($rangenya[3]-$rangenya[2]); }
				elseif($bobot>=$rangenya[3]) { $derajat=0; }
			}
		}
		
		$arr_himpunan[$d_himpunan['id_variabel_himpunan']]=$derajat;
		//TEST :  echo "Derajat : ".$d_variabel['himpunan']." : ".$derajat."<br>";
		
	}
	
	$arr_derajat[$d_variabel['id_variabel']]=$arr_himpunan; //Hasil perhitungan derajat keanggotaan 
															//semua himpunan per variabel
}

//print_r($arr_derajat); echo "<hr>";

//Cek semua Rule
querydb("UPDATE nilai_rule SET status=0 WHERE id_permohonan=$id"); //Rollback Nilai Rule
$sum_az=0; $sum_a=0;
$h_rule=querydb("SELECT id_rule, rule, kode FROM rule ORDER BY kode ASC");
while($d_rule=mysql_fetch_assoc($h_rule)){
	
	$him_derajat="";
	$arr_rule=array();
	$q_var=querydb("SELECT id_variabel, variabel FROM variabel WHERE jenis=1 ORDER BY id_variabel ASC");
	while($d_var=mysql_fetch_assoc($q_var)) {
		$rule=array(); $him_arr=array(); $cocok=array(); $him=0;
		$rule=explode(";", $d_rule['rule']);
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
		
		$arr_rule[]=$arr_derajat[$d_var['id_variabel']][$him];
		$him_derajat .= $d_var['id_variabel'].",".$him.",".$arr_derajat[$d_var['id_variabel']][$him].";";
	}
	
	$nilai_min=min($arr_rule); //Hasil MIN dari rule
	$sum_a += $nilai_min;
	//print_r($arr_rule); echo " = $nilai_min<br>";

	if($nilai_min>0) {
		//Cari Nilai z setiap rule
		$q_var=querydb("SELECT id_variabel, variabel FROM variabel WHERE jenis=2 ORDER BY id_variabel DESC LIMIT 0, 1");
		$d_var=mysql_fetch_assoc($q_var);
		$rule=array(); $him_arr=array(); $cocok=array(); $him=0;
		$rule=explode(";", $d_rule['rule']);
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
		
		//Mulai hitung Nilai Z
		$h_himpunan=querydb("SELECT id_variabel_himpunan, himpunan, kode, `range`, kurva FROM himpunan 
							 WHERE id_variabel=".(int)$d_var['id_variabel']." AND id_variabel_himpunan=$him");
		$d_himpunan=mysql_fetch_assoc($h_himpunan);
		//Hitung nilai z
		$z=0;
		$rangenya=array();
		$rangenya=explode("-", $d_himpunan['range']);
		
		if($d_himpunan['kurva']=="Linear Turun") {
			$z=$rangenya[1]-($nilai_min*($rangenya[1]-$rangenya[0]));
		} elseif ($d_himpunan['kurva']=="Linear Naik") {
			$z=($nilai_min*($rangenya[1]-$rangenya[0]))+$rangenya[0];
		}
		
		//echo $z."<hr>";
		$sum_az += $nilai_min * $z;
		
		//Simpan Hasil Untuk Setiap Rule
		$cek=mysql_fetch_assoc(querydb("SELECT id_nilai_rule FROM nilai_rule WHERE id_rule=".$d_rule['id_rule']." AND id_permohonan=$id"));
		if($cek['id_nilai_rule']!="") {
			querydb("UPDATE nilai_rule SET derajat_keanggotaan='$him_derajat', min=$nilai_min, predikat=$z, status=1
					 WHERE id_rule=".$d_rule['id_rule']." AND id_permohonan=$id");
		} else {
			querydb("INSERT INTO nilai_rule (id_permohonan, id_rule, derajat_keanggotaan, min, predikat, status)
					 VALUES ($id, ".$d_rule['id_rule'].", '$him_derajat', $nilai_min, $z, 1)");
		}
	}

}

if($sum_a>0) { //Menjaga jika tidak ada rule yang cocok (nilai 0 Nol)
	$Z=$sum_az/$sum_a; //Hasil Nilai Defuzzy
} else {
	$Z=0;
}

//TENTUKAN KESIMPULAN
$bobot=$Z;

//Fungsi untuk mendapatkan index dari nilai MAX
function max_key($array) {
    foreach ($array as $key => $val) {
        if ($val == max($array)) return $key; 
    }
}

//Ambil Himpunan yang Keputusan
$arr_nama_himpunan=array();
$arr_nilainya=array();
$h_var=querydb("SELECT id_variabel FROM variabel WHERE jenis=2 ORDER BY id_variabel DESC LIMIT 0, 1");
$d_var=mysql_fetch_assoc($h_var);
$h_himpunan=querydb("SELECT id_variabel_himpunan, himpunan, kode, `range`, kurva 
					 FROM himpunan 
					 WHERE id_variabel=".(int)$d_var['id_variabel']."");
					 
while($d_himpunan=mysql_fetch_assoc($h_himpunan)){
	
	//Hitung derajat keanggotaan
	$derajat=0;
	$rangenya=array();
	$rangenya=explode("-", $d_himpunan['range']);
	
	if($d_himpunan['kurva']=="Linear Turun") {
		if($rangenya[0]<=$bobot && $rangenya[1]>=$bobot){
			if($bobot<=$rangenya[0]) { $derajat=1; }
			elseif($bobot>=$rangenya[1]) { $derajat=0; }
			elseif($bobot>$rangenya[0] && $bobot<$rangenya[1]) { $derajat=($rangenya[1]-$bobot)/($rangenya[1]-$rangenya[0]); }
		}
	} elseif ($d_himpunan['kurva']=="Linear Naik") {
		if($rangenya[0]<=$bobot && $rangenya[1]>=$bobot){
			if($bobot<=$rangenya[0]) { $derajat=0; }
			elseif($bobot>=$rangenya[1]) { $derajat=1; }
			elseif($bobot>$rangenya[0] && $bobot<$rangenya[1]) { $derajat=($bobot-$rangenya[0])/($rangenya[1]-$rangenya[0]); }
		}
	} elseif ($d_himpunan['kurva']=="Segitiga") {
		if($rangenya[0]<=$bobot && $rangenya[2]>=$bobot){
			if($bobot<=$rangenya[0] || $bobot>=$rangenya[2]) { $derajat=0; }
			elseif($bobot>$rangenya[0] && $bobot<=$rangenya[1]) { $derajat=($bobot-$rangenya[0])/($rangenya[1]-$rangenya[0]); }
			elseif($bobot>=$rangenya[1] && $bobot<$rangenya[2]) { $derajat=($rangenya[2]-$bobot)/($rangenya[2]-$rangenya[1]); }
		}
	} elseif ($d_himpunan['kurva']=="Trapesium") {
		if($rangenya[0]<=$bobot && $rangenya[3]>=$bobot){
			if($bobot<=$rangenya[0]) { $derajat=0; }
			elseif($bobot>$rangenya[0] && $bobot<=$rangenya[1]) { $derajat=($bobot-$rangenya[0])/($rangenya[1]-$rangenya[0]); }
			elseif($bobot>=$rangenya[1] && $bobot<=$rangenya[2]) { $derajat=1; }
			elseif($bobot>=$rangenya[2] && $bobot<$rangenya[3]) { $derajat=($rangenya[3]-$bobot)/($rangenya[3]-$rangenya[2]); }
			elseif($bobot>=$rangenya[3]) { $derajat=0; }
		}
	}
	
	$arr_nama_himpunan[]=$d_himpunan['himpunan'];
	$arr_nilainya[]=$derajat;
	//TEST :  echo "Derajat : ".$d_variabel['himpunan']." : ".$derajat."<br>";
	
}

$index_nya=max_key($arr_nilainya);

$arr_derajat[$d_variabel['id_variabel']]=$arr_himpunan; //Hasil perhitungan derajat keanggotaan 



//echo "<hr>$sum_az/$sum_a = <b>$Z</b>"
//Simpan Hasil
$cek=mysql_fetch_assoc(querydb("SELECT id_nilai_defuzzy FROM nilai_defuzzy WHERE id_permohonan=$id"));
if($cek['id_nilai_defuzzy']!="") {
	querydb("UPDATE nilai_defuzzy SET nilai=$Z, hasil='".$arr_nama_himpunan[$index_nya]."' WHERE id_permohonan=$id");
} else {
	querydb("INSERT INTO nilai_defuzzy (id_permohonan, nilai, hasil)
			 VALUES ($id, ".$Z.", '".$arr_nama_himpunan[$index_nya]."')");
}
//SELESAI
?>

<!--TAMPILKAN HASIL-->

<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 text-dark" style="margin-bottom: 1px;">Data Hasil</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="?page=home">Beranda</a></li>
					<li class="breadcrumb-item active">Konsultasi</li>
					<li class="breadcrumb-item">Data Hasil Permohonan</li>
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
					<h2 class="card-title" style="margin-bottom: 1px;">Daftar Proses Tingkat Risiko</h2>
				</div>
				<div class="card-body">
					<div class="form-style-2">
						<?php 
						$q_var=querydb("SELECT id_variabel, variabel FROM variabel WHERE jenis=1 ORDER BY id_variabel ASC");
						?>
						<h3 style="margin-bottom:10px;">Data Permohonan</h3>
						<table style="font-size: 12px;" class="table table-striped table-bordered" width="100%" border="0" cellspacing="0" cellpadding="4">
							<tr>
								<td width="3%"><b>No.</b></td>
								<td width="9%" align="center"><b>No. Permohonan</b></td>
								<td width="7%"><b>Tanggal</b></td>
								<td width="6%" align="center"><b>No. Nasabah</b></td>
								<td width="38%"><b>Nama Lengkap</b></td>
								<?php while($d_var=mysql_fetch_assoc($q_var)) { ?>
								<td style="text-align:center;"><b><?php echo $d_var['variabel']; ?></b></td>
								<?php } ?>
							</tr>
							<?php
							$pg = (int)(!isset($_GET["pg"]) ? 1 : @$_GET["pg"]);
							$limit = 10;
							$startpoint = ($pg * $limit) - $limit;
							$no=$startpoint;
							$hquery=querydb("SELECT a.id_permohonan, a.nomor, a.tanggal, b.id_pasien, b.no_pasien, b.nama_lengkap
											FROM permohonan as a, pasien as b
											WHERE a.id_pasien=b.id_pasien AND a.id_permohonan=$id");
							while($data=mysql_fetch_assoc($hquery)){
								$no++;
							?>
							<tr>
								<td><?php echo $no; ?></td>
								<td><?php echo $data['nomor']; ?></td>
								<td><?php echo date("d/m/Y", strtotime($data['tanggal'])); ?></td>
								<td><?php echo $data['no_pasien']; ?></td>
								<td><?php echo $data['nama_lengkap']; ?></td>
								<?php 
								$q_var=querydb("SELECT id_variabel, variabel FROM variabel WHERE jenis=1 ORDER BY id_variabel ASC");
								$jml_var=mysql_num_rows($q_var);
								while($d_var=mysql_fetch_assoc($q_var)) {
									$jml=mysql_fetch_row(querydb("SELECT SUM(bobot) FROM nilai WHERE id_variabel=$d_var[id_variabel] AND id_permohonan=$data[id_permohonan]"));
								?>
								<td style="text-align:center;"><b><?php echo $jml[0]; ?></b></td>
								<?php 
								}
								?>        
							</tr>
						<?php } ?>
						</table>
						<br />
          				<div style="clear:both; height:10px;"></div>
						<?php $st_sum_az=""; $st_sum_a=""; ?>
						<h3 style="margin-bottom:10px; margin-top:0px;">Data Rule, Predikat (α) dan Hasil Inferensi (z)</h3>
						<table class="table table-striped table-bordered" width="100%" border="0" cellspacing="0" cellpadding="4">
							<tr>
								<td width="3%"><b>No.</b></td>
								<td width="5%" style="background-color:#CCC; color:#000; text-align:center;"><b>Rule</b></td>
									<?php 
										$q_var=querydb("SELECT id_variabel, variabel FROM variabel WHERE jenis=1 ORDER BY id_variabel ASC");
										$jml_var=mysql_num_rows($q_var);
										while($d_var=mysql_fetch_assoc($q_var)) {
									?>
								<td style="text-align:center;"><b>µ <?php echo $d_var['variabel']; ?></b></td>
									<?php 
										}
									?>
								<td style="text-align:center;"><b>(α) MIN</b></td>
									<?php
										$q_var=querydb("SELECT id_variabel, variabel FROM variabel WHERE jenis=2 ORDER BY id_variabel DESC LIMIT 0, 1");
										while($d_var=mysql_fetch_assoc($q_var)) {
									?>
								<td style="text-align:center;"><b>z<?php echo $d_var['variabel']; ?></b></td>
									<?php 
										} 
									?>
							</tr>
							<?php
								$no=0;
								$hquery=querydb("SELECT a.id_rule, a.rule, a.kode, b.id_nilai_rule, b.derajat_keanggotaan, b.min, b.predikat
												FROM rule as a, nilai_rule as b
												WHERE a.id_rule=b.id_rule AND b.id_permohonan=$id AND b.status=1 
												ORDER BY a.kode ASC");
								while($data=mysql_fetch_assoc($hquery)){
									$no++;
							?>
							<tr>
								<td><?php echo $no; ?></td>
								<td style="background-color:#CCC; color:#000; text-align:center;"><?php echo $data['kode']; ?></td>
									<?php 
										$q_var=querydb("SELECT id_variabel, variabel FROM variabel WHERE jenis=1 ORDER BY id_variabel ASC");
										while($d_var=mysql_fetch_assoc($q_var)) {
											$rule=array(); $him_arr=array(); $cocok=array(); $him=0;
											$rule=explode(";", $data['derajat_keanggotaan']);
											$cari="$d_var[id_variabel],";
											foreach ($rule as $key=>$value){
												if (strpos($value, $cari) === 0){
													$cocok[] = $value;
												} else if (strcmp($cari, $value) < 0){
													break;
												}
											}
											$him_arr=explode(",", $cocok[0]);
											$him=(int)$him_arr[1]; //id_himpunan
											$q_him=querydb("SELECT id_variabel_himpunan, kode, himpunan FROM himpunan WHERE id_variabel_himpunan=$him");
											$d_him=mysql_fetch_assoc($q_him);
									?>
								<td style="text-align:center;"><?php echo "<u>".$d_him['kode']."</u><br><span style='color:#000;'>".$him_arr[2]."</span>"; ?></td>
									<?php 
										}
									?>
								<td style="text-align:center;"><?php echo $data['min']; ?></td>
									<?php 
										$q_var=querydb("SELECT id_variabel, variabel FROM variabel WHERE jenis=2 ORDER BY id_variabel DESC LIMIT 0, 1");
										$d_var=mysql_fetch_assoc($q_var);
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
										
										$q_him=querydb("SELECT id_variabel_himpunan, kode, himpunan FROM himpunan WHERE id_variabel_himpunan=$him");
										$d_him=mysql_fetch_assoc($q_him);
									?>
								<td style="text-align:center;"><?php echo "<u>".$d_him['kode']."</u><br><span style='color:#000;'>".$data['predikat']."</span>"; ?></td>
							</tr>
							<?php 
								$st_sum_az .= "($data[min] x $data[predikat])+"; 
								$st_sum_a .= "$data[min]+"; 	  
							} 
							?>
						</table>
						<br />
						<div style="clear:both; height:10px;"></div>
						<?php
							$h_hasil=querydb("SELECT id_nilai_defuzzy, id_permohonan, nilai, hasil, diupdate 
											FROM nilai_defuzzy
											WHERE id_permohonan=$id");
							$d_hasil=mysql_fetch_assoc($h_hasil);
						?>
						<h3 style="margin-bottom:0px; padding-bottom:10px; margin-top:0px;">DeFuzzyfikasi</h3>
						<table class="table table-striped table-bordered" width="60%;">
							<tr>
								<td width="9%" style="font-size:18px; font-weight:bold; color:#333;">
									Z = 
								</td>
								<td width="91%" align="center" style="font-size:16px; color:#333;"">
									<?php 
										echo substr($st_sum_az, 0, -1);
										echo "<hr style='padding:0px; margin:0px;'>";
										echo substr($st_sum_a, 0, -1);
									?>
								</td>
							</tr>
							<tr>
								<td width="9%" style="font-size:18px; font-weight:bold; color:#333;">
									Z = 
								</td>
								<td width="91%" align="center" style="font-size:16px; color:#333; font-weight:bold; color:#06C;">
									<?php echo $d_hasil['nilai']; ?>
								</td>
							</tr>
							<tr>
								<td width="9%" style="font-size:18px; font-weight:bold; color:#333;">
									Kesimpulan 
								</td>
								<td width="91%" align="center" style="font-size:16px; color:#333; font-weight:bold; color:#06C;">
									<?php echo $d_hasil['hasil']; ?>
								</td>
							</tr>
						</table>
						<hr />
						<script type="text/javascript">
							var s5_taf_parent = window.location;
							function popup_print() {
								window.open('print_hasil.php?id=<?php echo $id; ?>','page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=600,left=50,top=50,titlebar=yes')
							}
						</script>
						<input type="submit" value="Cetak Hasil" class="btn btn-primary" name="stat_simpan" onclick="popup_print()"/>
						<input type='button' class="btn btn-warning" onclick="window.location='?page=hasil'" value="Kembali">
					</div>
				</div>
			</div>
		</div>
	</div>
</section>