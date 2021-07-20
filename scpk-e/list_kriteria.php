<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Kriteria</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="?page=home">Beranda</a></li>
                    <li class="breadcrumb-item">Data Fuzzy</li>
                    <li class="breadcrumb-item active">Data kriteria</li>
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
					<h2 class="card-title" style="margin-bottom: 1px;">Daftar Kriteria</h2>
				</div>
				<div class="card-body">
					<div style="float: right;">
						<a href="?page=kriteria-input&stat=tambah" class="btn btn-primary"><i class="icon ion-android-add-circle"></i> Tambah</a>
					</div>

					<?php
						$pg = (int)(!isset($_GET["pg"]) ? 1 : @$_GET["pg"]);
						$limit = 10;
						$startpoint = ($pg * $limit) - $limit;
						$no=$startpoint;
						$hquery=querydb("SELECT * FROM kriteria ORDER BY id_kriteria ASC LIMIT {$startpoint}, {$limit}");		
					?>
					<div style="clear:both; height:10px;"></div>
					<div class="form-style-2">
						<form method="post">
							<table class="table table-striped table-bordered" width="100%" border="0" cellspacing="0" cellpadding="4">
								<thead class="cf">
									<tr>
										<th width="3%">No</th>
										<th width="30%" style="text-align:center">Kriteria</th>
										<th width="25%" style="text-align:center">Action</th>
									</tr>
								</thead>
								<tbody>

								<?php
									while($data=mysql_fetch_assoc($hquery)) {
										$no++;
								?>

									<tr>
										<td><?php echo $no; ?></td>
										<td><?php echo $data['kriteria']; ?></td>
										<td width="5%" style="text-align:center;">
											<script type="text/javascript">
											function konfirmasi<?php echo $data['id_kriteria']; ?>() {
												var answer = confirm("Anda yakin akan menghapus data (<?php echo $data['kriteria']; ?>) ini ?")
												if (answer){
													window.location = "?page=kriteria-input&stat=hapus&id=<?php echo"$data[id_kriteria]"; ?>";
												}
											}
											</script>
											<a href="?page=kriteria-input&stat=ubah&id=<?php echo $data['id_kriteria']; ?>" class="btn btn-warning"><i class="icon ion-android-create"></i> Ubah</a>
											<a style="color:white" class="btn btn-danger" onclick="konfirmasi<?php echo $data['id_kriteria']; ?>()"><i class="icon ion-trash-a"></i> Hapus</a>
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
								</tbody>
							</table>
							<br />
								<div style="float: right;">
									<?php
										$cari=""; $url="";
										$url=(trim($cari=="") ? $url="?page=kriteria&" : $url="?page=kriteria&cari=$cari&");
										$query="SELECT id_kriteria FROM kriteria";
										echo pagination($query,$limit,$pg,$url); 
									?>
								</div>
							<br />
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>