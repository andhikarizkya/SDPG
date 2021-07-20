<?php
$cari=@$_GET['cari'];
?>

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
					<h2 class="card-title" style="margin-bottom: 1px;">Daftar Permohonan</h2>
				</div>
				<div class="card-body">
                    <div class="form-style-2">
                        <form class="form-inline ml" style="display: inline-block;" method="get" action="">
                            <input type="hidden" name="page" value="permohonan" />
                            <div class="input-group mb-3">
                                <input class="form-control" type="text" name="cari" placeholder="Pencarian" aria-label="Pencarian" value="<?php echo $cari; ?>">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="submit" value="Cari">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                        <div style="float: right;">
                            <!-- <a href="?page=solving-konsul&idtanya=2" class="btn btn-primary"><i class="icon ion-android-add-circle"></i> Tambah</a> -->
                            <a href="?page=permohonan-input&stat=tambah" class="btn btn-primary"><i class="icon ion-android-add-circle"></i> Tambah</a>
                        </div>
                        
                    <br />
                    <div style="clear:both; height:10px;"></div>
                            <?php 
                                $q_var=querydb("SELECT id_variabel, variabel FROM variabel WHERE jenis=1 ORDER BY id_variabel ASC");
                                $jml_var=mysql_num_rows($q_var);
                            ?>
                        <table class="table table-striped table-bordered" width="100%" border="0" cellspacing="0" cellpadding="4">
                            <thead>
                                <tr style="font-size: 12px;">
                                    <td width="1%" rowspan="2" ><b>No.</b></td>
                                    <td width="5%" rowspan="2" align="center"><b>No. Permohonan</b></td>
                                    <td width="6%" rowspan="2" align="center"><b>No. Pasien</b></td>
                                    <td width="5%" rowspan="2" style="text-align:center"><b>Nama Lengkap</b></td>
                                    <td width="1%" colspan="<?php echo $jml_var; ?>" style="text-align:center; font-size: 15px;"><b>BOBOT</b></td>
                                    <td width="1%" rowspan="2" style="text-align:center; font-size: 13px;"><b>Tanggal</b></td>
                                    <td width="80%" rowspan="2" style="text-align:center; font-size: 13px;"><b>Aksi</b></td>
                                </tr>
                                <tr style="font-size: 12px;">
                                    <?php 
                                        while($d_var=mysql_fetch_assoc($q_var)) {
                                    ?>
                                    <td style="text-align:center;"><b><?php echo $d_var['variabel']; ?></b></td>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $pg = (int)(!isset($_GET["pg"]) ? 1 : @$_GET["pg"]);
                                    $limit = 10;
                                    $startpoint = ($pg * $limit) - $limit;
                                    $no=$startpoint;
                                    $hquery=querydb("SELECT a.id_permohonan, a.nomor, a.tanggal, b.id_pasien, b.no_pasien, b.nama_lengkap
                                                    FROM permohonan as a, pasien as b
                                                    WHERE a.id_pasien=b.id_pasien AND 
                                                            (b.no_pasien LIKE '%".$cari."%' OR b.nama_lengkap LIKE '%".$cari."%')
                                                    ORDER BY a.id_permohonan DESC LIMIT {$startpoint}, {$limit}");
                                    while($data=mysql_fetch_assoc($hquery)){
                                        $no++;
                                ?>
                                <tr style="font-size: 12px;">
                                    <td><?php echo $no; ?></td>
                                    <td><?php echo $data['nomor']; ?></td>
                                    <td><?php echo $data['no_pasien']; ?></td>
                                    <td><?php echo $data['nama_lengkap']; ?></td>
                                        <?php 
                                            $q_var=querydb("SELECT id_variabel, variabel FROM variabel WHERE jenis=1 ORDER BY id_variabel ASC");
                                            $jml_var=mysql_num_rows($q_var);
                                            while($d_var=mysql_fetch_assoc($q_var)) {
                                                $jml=mysql_fetch_row(querydb("SELECT SUM(bobot) FROM nilai WHERE id_variabel=$d_var[id_variabel] AND id_permohonan=$data[id_permohonan]"));
                                        ?>
                                    <td style="text-align:center;"><b><?php echo $jml[0]; ?></b></td>
                                        <?php } ?>        
                                    <td><?php echo date("d/m/Y", strtotime($data['tanggal'])); ?></td>
                                    <td width="6%" style="text-align:center;">
                                        <script type="text/javascript">
                                        function konfirmasi<?php echo $data['id_permohonan']; ?>() {
                                            var answer = confirm("Anda yakin akan menghapus data permohonan nomor : <?php echo $data['nomor']; ?> ini ?")
                                            if (answer){
                                                window.location = "?page=permohonan-input&stat=hapus&id=<?php echo"$data[id_permohonan]"; ?>";
                                            }
                                        }
                                        </script>
                                        <a style="font-size: 12px;" href="?page=permohonan-input&stat=ubah&id=<?php echo $data['id_permohonan']; ?>" class="btn btn-warning"><i class="icon ion-android-create"></i> Ubah</a>
                                        <a style="color:white; font-size: 12px;" class="btn btn-danger" onclick="konfirmasi<?php echo $data['id_permohonan']; ?>()"><i class="icon ion-trash-a"></i> Hapus</a>
                                    </td>
                                </tr>
                                <?php } if(@$_GET['con']!="") { ?>
                                <tr style="font-size: 12px;">
                                    <td colspan="<?php echo $jml_var+6; ?>" style="color:#360; font-weight:600; font-size:14px;">
                                        <?php 
                                            if(@$_GET['con']==1) { echo "Data berhasil ditambahkan."; }
                                            elseif(@$_GET['con']==2) { echo "Data berhasil diubah."; }
                                            elseif(@$_GET['con']==3) { echo "Data berhasil dihapus."; }
                                        ?>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <br />
                            <div style="float: right;">
                                <?php
                                    $cari=""; $url="";
                                    $url=(trim($cari=="") ? $url="?page=permohonan&" : $url="?page=permohonan&cari=$cari&");
                                    $query="SELECT a.id_permohonan FROM permohonan as a, pasien as b WHERE a.id_pasien=b.id_pasien AND (b.no_pasien LIKE '%".$cari."%' OR b.nama_lengkap LIKE '%".$cari."%')";
                                    echo pagination($query,$limit,$pg,$url); 
                                ?>
                            </div>
                        <br />
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>