<?php
$stat	= @$_GET['stat'];
$id		= (int)antiinjec(@$_GET['id']);

$folder_ori 	= "../foto_informasi/";
$folder_thumb 	= "../foto_informasi/thumb/";
$folder_crop	= "../foto_informasi/crop/";
	
if($stat=="ubah") {
	$hdata=querydb("SELECT id_informasi, judul, informasi, gambar, tanggal FROM tb_informasi WHERE id_informasi=$id");
	$data=mysql_fetch_array($hdata);
}

if(@$_POST['stat_simpan']) {
	include "../config/fungsi_seo.php";
	include "../config/fungsi_thumb.php";
	
	$id				= (int)antiinjec(@$_POST['id']);
	$judul			= antiinjec(@$_POST['judul']);
	$informasi		= @$_POST['informasi'];
	$link			= seo_x($judul);
	$tanggal		= date("Y-m-d H:i:s");
	$id_admin		= (int)@$_SESSION['sesIdAdmin'];
		
	$fileTmpLoc 	= @$_FILES["gambar"]["tmp_name"]; // File in the PHP tmp folder
	$fileType 		= @$_FILES["gambar"]["type"]; // The type of file it is
	$fileSize 		= @$_FILES["gambar"]["size"]; // File size in bytes
	$JustfileName 	= pathinfo(@$_FILES['gambar']['name'], PATHINFO_FILENAME);
	$JustfileExten 	= pathinfo(@$_FILES['gambar']['name'], PATHINFO_EXTENSION);
	$nama_file_unik = rand(100, 999)."_".$JustfileName.".".$JustfileExten; 
	
	if (!$fileTmpLoc && $status=="tambah"){
		?>
		<script language="JavaScript">alert('Anda belum memilih gambar.'); window.history.back();</script>
		<?php
		exit();
	}
	
	if ($fileSize>2097152) {
		?>
		<script language="JavaScript">alert('Maksimal ukuran gambar 2MB.'); window.history.back();</script>
		<?php
		exit();
	}
	
	if (($fileType != "image/jpg" && $fileType != "image/jpeg" && $fileType != "image/pjpeg" && $fileType != "image/png" && $fileType != "image/PNG") && $fileTmpLoc){
		?>
		<script language="JavaScript">alert('Gambar yang diperbolehkan berformat JPG dan PNG.'); window.history.back();</script>
		<?php
		exit();
	}
	
	if($stat=="tambah") {
		$d_cek=mysql_fetch_array(querydb("SELECT count(*) FROM tb_informasi WHERE link='$link'"));
		if($d_cek[0]==0) {
			move_uploaded_file($fileTmpLoc, $folder_ori.$nama_file_unik);
			image_set(200, 140, $nama_file_unik, $folder_thumb, $folder_ori, 'crop', 90);
			image_set(400, 0, $nama_file_unik, $folder_crop, $folder_ori, 'thum', 90);
			
			querydb("INSERT INTO tb_informasi(judul, link, informasi, gambar, tanggal, id_admin)
					 VALUES ('$judul', '$link', '$informasi', '$nama_file_unik', '$tanggal', '$id_admin')");
			?>
			<script language="JavaScript">document.location='?page=informasi&id=<?php echo $id; ?>&con=1'</script>
			<?php
		} else {
			?>
			<script language="JavaScript">alert('Judul informasi sudah ada.'); history.go(-1); </script>
			<?php
		}
	} elseif($stat=="ubah") {
		$d_cek=mysql_fetch_array(querydb("SELECT count(*) FROM tb_informasi WHERE link='$link' AND id_informasi<>$id"));
		if($d_cek[0]==0) {
			if (!$fileTmpLoc) {
				querydb("UPDATE tb_informasi SET judul='$judul', link='$link', informasi='$informasi' WHERE id_informasi=$id");
				?>
				<script language="JavaScript">document.location='?page=informasi&id=<?php echo $id; ?>&con=2'</script>
				<?php
			} else {
				move_uploaded_file($fileTmpLoc, $folder_ori.$nama_file_unik);
				image_set(200, 140, $nama_file_unik, $folder_thumb, $folder_ori, 'crop', 90);
				image_set(400, 0, $nama_file_unik, $folder_crop, $folder_ori, 'thum', 90);
				
				$foto=mysql_fetch_row(mysql_query("SELECT gambar FROM tb_informasi WHERE id_informasi=$id"));
				querydb("UPDATE tb_informasi SET judul='$judul', link='$link', informasi='$informasi', gambar='$nama_file_unik' WHERE id_informasi=$id");
				
				if (file_exists($folder_ori.$foto[0])) {
					unlink($folder_ori.$foto[0]);
				} 
				if (file_exists($folder_crop.$foto[0])) {
					unlink($folder_crop.$foto[0]);
				} 
				if (file_exists($folder_thumb.$foto[0])) {
					unlink($folder_thumb.$foto[0]);
				} 			
				
				?>
				<script language="JavaScript">document.location='?page=informasi&id=<?php echo $id; ?>&con=2'</script>
				<?php
			}
		} else {
			?>
			<script language="JavaScript">alert('Judul informasi sudah ada.'); history.go(-1); </script>
			<?php
		}
	}
} elseif($stat=="hapus" && $id!="") {
	$foto=mysql_fetch_row(mysql_query("SELECT gambar FROM tb_informasi WHERE id_informasi=$id"));
	
	if (file_exists($folder_ori.$foto[0])) {
		unlink($folder_ori.$foto[0]);
	} 
	if (file_exists($folder_crop.$foto[0])) {
		unlink($folder_crop.$foto[0]);
	} 
	if (file_exists($folder_thumb.$foto[0])) {
		unlink($folder_thumb.$foto[0]);
	} 		
	
	querydb("DELETE FROM tb_informasi WHERE id_informasi=$id");
	?>
	<script language="JavaScript">document.location='?page=informasi&id=<?php echo $id; ?>&con=3'</script>
	<?php
}
?>

<script type="text/javascript">
// Forms Validator
$j(function() {
   $j("#form1").validate();
});
</script>

<h2><?php if($stat=="tambah") { echo "Tambah"; } elseif($stat=="ubah") { echo "Ubah"; } ?> Informasi</h2>
<form action="?page=informasi-input&stat=<?php echo $stat; ?>" method="post" enctype="multipart/form-data" name="form1" id="form1">
  <input type="hidden" name="stat_simpan" value="set">
  <input type="hidden" name="id" value="<?php echo $id; ?>">
<div class="form-style-2" >
  <table border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="180">Judul</td>
          <td width="870"><input type="text" size="50" name="judul" maxlength="50" class="input-field required huruf" value="<?php echo"$data[judul]";?>"></td>
        </tr>
        <tr>
          <td colspan="2"><b>Informasi :</b></td>
        </tr>
        <tr>
          <td colspan="2"><textarea name="informasi" cols="40" rows="3" class="isi input-field required" style="border-radius:3px; border:1px solid #CCC;"><?php echo"$data[informasi]";?></textarea></td>
        </tr>
        <tr>
          <td>Gambar</td>
          <td><input type="file" name="gambar" class="input-field <?php if($stat!="ubah") { echo "required"; } ?>" /></td>
        </tr>
        <?php if($stat=="ubah") { ?>
        <tr>
          <td>&nbsp;</td>
          <td><img src="../foto_informasi/thumb/<?php echo $data['gambar']; ?>" height="100" /></td>
        </tr>
        <?php } ?>
        <tr>
          <td colspan="2">
          <input type="submit" value="Simpan" class="tombol" name="stat_simpan"/>
          <input type='button' class="tombol2" onclick="window.history.back();" value="Batal">
          </td>
        </tr>
  </table>  
</div>    
</form>