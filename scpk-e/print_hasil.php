<?php
require_once("config/library.php");
require_once("config/koneksi.php");
opendb();
$id=(int)antiinjec(@$_GET['id']);
?>
<html>
<head>
<title>Print Data Hasil</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script type="text/javascript">
function cetak()
{
window.print();
window.close();
}
</script>
<style type="text/css">
<!--
body {
	font-family:Verdana, Geneva, sans-serif; font-size:12px;
	}
h2 { font-weight:600; font-size:20px; text-align:left; }
h3 { font-weight:600; font-size:16px; text-align:left; padding-top:20px; }
table { border-collapse:collapse; width:100%; font-size:13px; }
td { border:1px solid #666; }
th { border:1px solid #666; font-weight:bold; }

.float_r { 
	position:absolute;
	left:75%;
	top:Auto;
	}
</style>
</head>
<body>
<body onLoad="window.print()">

<div style="display:flex; justify-content:center; align-items:center;">
	<h2>Hasil Diagnosa Penyakit Ginjal</h2>
</div>

<hr>
   
<div class="form-style-2">
	<?php 
    $q_var=querydb("SELECT id_variabel, variabel FROM variabel WHERE jenis=1 ORDER BY id_variabel ASC");
	?>
    <h3 style="margin-bottom:10px;">Data Permohonan</h3>
    <table style="font-size: 12px;" width="100%" border="0" cellspacing="0" cellpadding="4">
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
    
    <?php $st_sum_az=""; $st_sum_a=""; ?>
    <h3 style="margin-bottom:10px; margin-top:0px;">Data Rule, Predikat (a) dan Hasil Inferensi (z)</h3>
    <table width="100%" border="0" cellspacing="0" cellpadding="4">
      <tr>
        <td width="3%"><b>No.</b></td>
        <td width="5%" style="background-color:#CCC; color:#000; text-align:center;"><b>Rule</b></td>
        <?php 
		$q_var=querydb("SELECT id_variabel, variabel FROM variabel WHERE jenis=1 ORDER BY id_variabel ASC");
		$jml_var=mysql_num_rows($q_var);
		while($d_var=mysql_fetch_assoc($q_var)) {
		?>
        <td style="text-align:center;"><b>µ<?php echo $d_var['variabel']; ?></b></td>
		<?php 
		}
		?>
        <td style="text-align:center;"><b>(a) MIN</b></td>
        <?php
		$q_var=querydb("SELECT id_variabel, variabel FROM variabel WHERE jenis=2 ORDER BY id_variabel DESC LIMIT 0, 1");
		while($d_var=mysql_fetch_assoc($q_var)) {
		?>
        <td style="text-align:center;"><b>z<?php echo $d_var['variabel']; ?></b></td>
		<?php } ?>
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
    
    <?php
		$h_hasil=querydb("SELECT id_nilai_defuzzy, id_permohonan, nilai, hasil, diupdate 
						  FROM nilai_defuzzy
						  WHERE id_permohonan=$id");
		$d_hasil=mysql_fetch_assoc($h_hasil);
	?>
    <h3 style="margin-bottom:0px; padding-bottom:10px; margin-top:0px;">DeFuzzyfikasi</h3>
    <table width="60%;">
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
</div>
</body>
</html>
<?php closedb(); ?>