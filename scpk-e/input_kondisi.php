<?php
$stat		= @$_GET['stat'];
$id			= (int)antiinjec(@$_GET['id']);
$variabel	= (int)antiinjec(@$_GET['variabel']);
	
if($stat=="ubah") {
	$hdata=querydb("SELECT a.id_variabel_kondisi, a.kondisi, a.bobot, b.id_variabel_parameter 
					FROM ft_variabel_kondisi as a, bobot as b 
					WHERE a.id_variabel_parameter=b.id_variabel_parameter AND a.id_variabel_kondisi=$id");
	$data=mysql_fetch_array($hdata);
}

if(@$_POST['stat_simpan']) {
	$id				= (int)antiinjec(@$_POST['id']);
	$parameter		= (int)antiinjec(@$_POST['parameter']);
	$kondisi		= antiinjec(@$_POST['kondisi']);
	$bobot			= antiinjec(@$_POST['bobot']);
	
	if($stat=="tambah") {
		$d_cek=mysql_fetch_array(querydb("SELECT count(*) FROM ft_variabel_kondisi WHERE kondisi='$kondisi' AND id_variabel_parameter=$parameter"));
		if($d_cek[0]==0) {
			querydb("INSERT INTO ft_variabel_kondisi(id_variabel_parameter, kondisi, bobot)
					 VALUES ($parameter, '$kondisi', $bobot)");
			?>
			<script language="JavaScript">document.location='?page=kondisi&variabel=<?php echo $variabel; ?>&con=1'</script>
			<?php
		} else {
			?>
			<script language="JavaScript">alert('Nama kondisi sudah terdaftar pada parameter.'); history.go(-1); </script>
			<?php
		}
	} elseif($stat=="ubah") {
		$d_cek=mysql_fetch_array(querydb("SELECT count(*) FROM ft_variabel_kondisi WHERE kondisi='$kondisi' AND id_variabel_parameter=$parameter AND id_variabel_kondisi<>$id"));
		if($d_cek[0]==0) {
			querydb("UPDATE ft_variabel_kondisi SET id_variabel_parameter=$parameter, kondisi='$kondisi', bobot=$bobot WHERE id_variabel_kondisi=$id");
			?>
			<script language="JavaScript">document.location='?page=kondisi&variabel=<?php echo $variabel; ?>&con=2'</script>
			<?php
		} else {
			?>
			<script language="JavaScript">alert('Nama kondisi sudah terdaftar pada parameter.'); history.go(-1); </script>
			<?php
		}
	}
} elseif($stat=="hapus" && $id!="") {
	querydb("DELETE FROM ft_variabel_kondisi WHERE id_variabel_kondisi=$id");
	?>
	<script language="JavaScript">document.location='?page=kondisi&variabel=<?php echo $variabel; ?>&con=3'</script>
	<?php
}
?>

<script type="text/javascript">
// Forms Validator
$j(function() {
   $j("#form1").validate();
});
</script>

<h1><?php if($stat=="tambah") { echo "Tambah"; } elseif($stat=="ubah") { echo "Ubah"; } ?> Kondisi Parameter dan Bobot</h1>
<form action="?page=kondisi-input&variabel=<?php echo $variabel; ?>&stat=<?php echo $stat; ?>" method="post" enctype="multipart/form-data" name="form1" id="form1">
  <input type="hidden" name="stat_simpan" value="set">
  <input type="hidden" name="id" value="<?php echo $id; ?>">
<div class="form-style-2" >
  <table border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="180"><b>Variabel</b></td>
          <td width="870">
          <b>
            	<?php
				$q_drop="SELECT id_variabel, variabel FROM variabel WHERE id_variabel=$variabel";
				$h_drop=querydb($q_drop);
				$d_drop=mysql_fetch_assoc($h_drop);
            	echo $d_drop['variabel']; 
				?>
          </b>
          </td>
        </tr>
        <tr>
          <td style="vertical-align:top;">Parameter</td>
          <td>
          	<select name="parameter" class="input-field required" style="padding:6px 5px; border:1px solid #CCC; border-radius:3px;">
            	<option value="">- Pilih Parameter -</option>
					<?php
						$q_drop="SELECT id_variabel_parameter, parameter FROM bobot WHERE id_variabel=$variabel ORDER BY id_variabel_parameter ASC";
						$h_drop=querydb($q_drop);
						while($d_drop=mysql_fetch_assoc($h_drop)) {
					?>
            	<option value="<?php echo $d_drop['id_variabel_parameter']; ?>" <?php if($d_drop['id_variabel_parameter']==$data['id_variabel_parameter']) { echo "selected"; } ?>><?php echo $d_drop['parameter']; ?></option>
            	<?php } ?>
            </select>  
          </td>
        </tr>
        <tr>
          <td>Kondisi</td>
          <td><input type="text" size="30" name="kondisi" maxlength="50" class="input-field required" value="<?php echo"$data[kondisi]";?>"></td>
        </tr>
        <tr>
          <td>Bobot</td>
          <td><input type="number" size="10" step="0.01" style="width:100px;" name="bobot" maxlength="6" class="input-field required" value="<?php echo"$data[bobot]";?>"></td>
        </tr>
        <tr>
          <td colspan="2">
          <input type="submit" value="Simpan" class="tombol" name="stat_simpan"/>
          <input type='button' class="tombol2" onclick="window.history.back();" value="Batal">
          </td>
        </tr>
  </table>  
</div>    
</form>