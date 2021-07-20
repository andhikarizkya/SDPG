<h2>Daftar Informasi</h2>
<div class="form-style-2">
    <table width="100%" border="0" cellspacing="0" cellpadding="4">
      <tr>
        <td width="3%"><b>No.</b></td>
        <td width="81%"><b>Judul Informasi</b></td>
        <td width="11%"><b>Tanggal</b></td>
        <td width="5%"><a href="?page=informasi-input&stat=tambah" class="tombol_mini3">Tambah</a></td>
      </tr>
      <?php
	  $pg = (int)(!isset($_GET["pg"]) ? 1 : @$_GET["pg"]);
	  $limit = 10;
	  $startpoint = ($pg * $limit) - $limit;
	  $no=$startpoint;
	  $hquery=querydb("SELECT id_informasi, judul, tanggal FROM tb_informasi ORDER BY id_informasi DESC LIMIT {$startpoint}, {$limit}");
	  while($data=mysql_fetch_array($hquery)){
		 $no++;
	  ?>
      <tr>
        <td><?php echo $no; ?></td>
        <td><?php echo $data['judul']; ?></td>
        <td><?php echo date("d-m-Y", strtotime($data['tanggal'])); ?></td>
        <td width="5%" style="text-align:center;">
			<script type="text/javascript">
            function konfirmasi<?php echo $data[0]; ?>() {
                var answer = confirm("Anda yakin akan menghapus data (<?php echo $data['judul']; ?>) ini ?")
                if (answer){
                    window.location = "?page=informasi-input&stat=hapus&id=<?php echo"$data[0]"; ?>";
                }
            }
            </script>
            <a href="?page=informasi-input&stat=ubah&id=<?php echo $data['id_informasi']; ?>" class="tombol_mini1">Ubah</a>
            <a class="tombol_mini2" onclick="konfirmasi<?php echo $data[0]; ?>()">Hapus</a>
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
	$url=(trim($cari=="") ? $url="?page=informasi&" : $url="?page=informasi&cari=$cari&");
	$query="SELECT id_informasi FROM tb_informasi";
	echo pagination($query,$limit,$pg,$url); 
	?>
    <br />
</div>