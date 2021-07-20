<h1>Daftar Kondisi Parameter dan Bobot</h1>
<div class="form-style-2">
    <?php 
	$variabel=(int)@$_REQUEST['variabel']; 
	if($variabel==0) {
		$q_var="SELECT id_variabel, variabel FROM variabel WHERE jenis=1 ORDER BY id_variabel ASC LIMIT 0, 1";
		$h_var=querydb($q_var);
		$d_var=mysql_fetch_assoc($h_var);
		$variabel=$d_var['id_variabel'];
	}
	?>
    <form method="get" action="">
    <input type="hidden" name="page" value="kondisi" />
	<b>Variabel :</b>
    <select name="variabel" class="input-field required" onchange="this.form.submit()" style="padding:6px 5px; border:1px solid #CCC; border-radius:3px;">
        <?php
        $q_drop="SELECT id_variabel, variabel FROM variabel WHERE jenis=1 ORDER BY id_variabel ASC";
        $h_drop=querydb($q_drop);
        while($d_drop=mysql_fetch_assoc($h_drop)) {
        ?>
        <option value="<?php echo $d_drop['id_variabel']; ?>" <?php if($d_drop['id_variabel']==$variabel) { echo "selected"; } ?>><?php echo $d_drop['variabel']; ?></option>
        <?php } ?>
    </select> 
    </form>
    <div style="clear:both; height:10px;"></div>
    <table width="100%" border="0" cellspacing="0" cellpadding="4">
      <tr>
        <td width="3%"><b>No.</b></td>
        <td width="29%"><b>Parameter</b></td>
        <td width="24%"><b>Kondisi</b></td>
        <td width="38%"><b>Bobot</b></td>
        <td width="6%"><a href="?page=kondisi-input&stat=tambah&variabel=<?php echo $variabel; ?>" class="tombol_mini3">Tambah</a></td>
      </tr>
      <?php
	  $pg = (int)(!isset($_GET["pg"]) ? 1 : @$_GET["pg"]);
	  $limit = 10;
	  $startpoint = ($pg * $limit) - $limit;
	  $no=$startpoint;
	  $hquery=querydb("SELECT b.id_variabel_kondisi, a.parameter, b.kondisi, b.bobot 
	  				   FROM bobot as a, ft_variabel_kondisi as b 
					   WHERE a.id_variabel_parameter=b.id_variabel_parameter AND a.id_variabel=$variabel 
					   ORDER BY a.id_variabel_parameter ASC, b.id_variabel_kondisi ASC LIMIT {$startpoint}, {$limit}");
	  while($data=mysql_fetch_assoc($hquery)){
		 $no++;
	  ?>
      <tr>
        <td><?php echo $no; ?></td>
        <td><?php echo $data['parameter']; ?></td>
        <td><?php echo $data['kondisi']; ?></td>
        <td><?php echo $data['bobot']; ?></td>
        <td width="6%" style="text-align:center;">
			<script type="text/javascript">
            function konfirmasi<?php echo $data['id_variabel_kondisi']; ?>() {
                var answer = confirm("Anda yakin akan menghapus data (<?php echo $data['kondisi']; ?>) ini ?")
                if (answer){
                    window.location = "?page=kondisi-input&variabel=<?php echo $variabel; ?>&stat=hapus&id=<?php echo"$data[id_variabel_kondisi]"; ?>";
                }
            }
            </script>
            <a href="?page=kondisi-input&stat=ubah&variabel=<?php echo $variabel; ?>&id=<?php echo $data['id_variabel_kondisi']; ?>" class="tombol_mini1">Ubah</a>
            <a class="tombol_mini2" onclick="konfirmasi<?php echo $data['id_variabel_kondisi']; ?>()">Hapus</a>
        </td>
      </tr>
      <?php } if(@$_GET['con']!="") { ?>
      <tr>
        <td colspan="8" style="color:#360; font-weight:600; font-size:14px;">
			<?php 
				if(@$_GET['con']==1) { echo "Data berhasil ditambahkan."; }
				elseif(@$_GET['con']==2) { echo "Data berhasil diubah."; }
				elseif(@$_GET['con']==3) { echo "Data berhasil dihapus."; }
			?>
      </tr>
      <?php } ?>
    </table>
    <br />
    <?php
	$cari=""; $url="";
	$url=(trim($cari=="") ? $url="?page=kondisi&" : $url="?page=kondisi&cari=$cari&");
	$query="SELECT id_variabel_kondisi FROM ft_variabel_kondisi as a, bobot as b 
			WHERE a.id_variabel_parameter=b.id_variabel_parameter AND b.id_variabel=$variabel";
	echo pagination($query,$limit,$pg,$url); 
	?>
    <br />
</div>