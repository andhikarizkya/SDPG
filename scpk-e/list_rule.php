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
					<h2 class="card-title" style="margin-bottom: 1px;">Daftar Rule</h2>
				</div>
				<div class="card-body">
					<div style="float: right;">
						<a href="?page=rule-input&stat=tambah" class="btn btn-primary"><i class="icon ion-android-add-circle"></i> Tambah</a>
					</div>

					<br />
          			<div style="clear:both; height:10px;"></div>
					<div class="form-style-2">
						<table class="table table-striped table-bordered" width="100%" border="0" cellspacing="0" cellpadding="4">
							<thead>
								<tr>
									<td width="3%"><b>No.</b></td>
									<td width="5%" style="background-color:#CCC; color:#000; text-align:center;"><b>Rule</b></td>
										<?php 
											$q_var=querydb("SELECT id_variabel, variabel FROM variabel WHERE jenis=1 ORDER BY id_variabel ASC");
											$jml_var=mysql_num_rows($q_var);
											while($d_var=mysql_fetch_assoc($q_var)) {
										?>
									<td style="text-align:center;"><b><?php echo $d_var['variabel']; ?></b></td>
										<?php 
											}
											$q_var=querydb("SELECT id_variabel, variabel FROM variabel WHERE jenis=2 ORDER BY id_variabel DESC LIMIT 0, 1");
											while($d_var=mysql_fetch_assoc($q_var)) {
										?>
									<td><b><?php echo $d_var['variabel']; ?></b></td>
									<?php } ?>
									<td width="19%" style="text-align:center"><b>Aksi</b></td>
								</tr>
							</thead>
							<tbody>
									<?php
										$pg = (int)(!isset($_GET["pg"]) ? 1 : @$_GET["pg"]);
										$limit = 10;
										$startpoint = ($pg * $limit) - $limit;
										$no=$startpoint;
										$hquery=querydb("SELECT id_rule, rule, kode
														FROM rule 
														ORDER BY kode ASC LIMIT {$startpoint}, {$limit}");
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
												$rule=explode(";", $data['rule']);
												$cari="k,$d_var[id_variabel]";
												//$him_in=array_search("k,$d_var[id_variabel]",$rule);
												foreach ($rule as $key=>$value){
													if (strpos($value, $cari) === 0){
														$cocok[] = $value;
													} else if (strcmp($cari, $value) < 0){
														break;
													}
												}
												//print_r($matches);
												//echo $him_in;
												$him_arr=explode(",", $cocok[0]);
												$him=(int)$him_arr[2]; //id_himpunan
												//echo $him."-";
												$q_him=querydb("SELECT id_variabel_himpunan, kode, himpunan FROM himpunan WHERE id_variabel_himpunan=$him");
												$d_him=mysql_fetch_assoc($q_him);
										?>
									<td style="text-align:center;"><?php echo $d_him['kode']; ?></td>
										<?php } ?>
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
									<td style="text-align:center;"><?php echo $d_him['kode']; ?></td>
									<td width="6%" style="text-align:center;">
										<script type="text/javascript">
										function konfirmasi<?php echo $data['id_rule']; ?>() {
											var answer = confirm("Anda yakin akan menghapus data (<?php echo $data['kode']; ?>) ini ?")
											if (answer){
												window.location = "?page=rule-input&stat=hapus&id=<?php echo"$data[id_rule]"; ?>";
											}
										}
										</script>
										<a href="?page=rule-input&stat=ubah&id=<?php echo $data['id_rule']; ?>" class="btn btn-warning"><i class="icon ion-android-create"></i> Ubah</a>
										<a style="color:white" class="btn btn-danger" onclick="konfirmasi<?php echo $data['id_rule']; ?>()"><i class="icon ion-trash-a"></i> Hapus</a>
									</td>
								</tr>
								<?php } if(@$_GET['con']!="") { ?>
								<tr>
									<td colspan="<?php echo $jml_var+4; ?>" style="color:#360; font-weight:600; font-size:14px;">
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
									$url=(trim($cari=="") ? $url="?page=rule&" : $url="?page=rule&cari=$cari&");
									$query="SELECT id_rule FROM rule";
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