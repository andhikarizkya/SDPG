<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Variabel</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="?page=home">Beranda</a></li>
                    <li class="breadcrumb-item">Data Fuzzy</li>
                    <li class="breadcrumb-item active">Variabel</li>
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
          <h2 class="card-title" style="margin-bottom: 1px;">Daftar Variabel</h2>
        </div>

        <div class="card-body">
          <div style="float: right;">
            <a href="?page=variabel-input&stat=tambah" class="btn btn-primary"><i class="icon ion-android-add-circle"></i> Tambah</a>
          </div>

          <br />
          <div style="clear:both; height:10px;"></div>
          <div class="form-style-2">
              <table class="table table-striped table-bordered" width="100%" border="0" cellspacing="0" cellpadding="4">
                <thead>
                  <tr>
                    <td width="5%"><b>No.</b></td>
                    <td width="25%"><b>Variabel</b></td>
                    <td width="25%"><b>Sifat</b></td>
                    <td width="25%"><b>Jenis</b></td>
                    <td width="20%" style="text-align:center"><b>Aksi</b></td>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $pg = (int)(!isset($_GET["pg"]) ? 1 : @$_GET["pg"]);
                    $limit = 10;
                    $startpoint = ($pg * $limit) - $limit;
                    $no=$startpoint;
                    $hquery=querydb("SELECT id_variabel, variabel, sifat, jenis FROM variabel ORDER BY id_variabel ASC LIMIT {$startpoint}, {$limit}");
                    while($data=mysql_fetch_array($hquery)){
                    $no++;
                    if($data['jenis']==1) { $jenis="Kriteria"; }
                    elseif($data['jenis']==2) { $jenis="Keputusan"; }
                  ?>
                  <tr>
                    <td><?php echo $no; ?></td>
                    <td><?php echo $data['variabel']; ?></td>
                    <td><?php echo $data['sifat'];; ?></td>
                    <td><?php echo $jenis; ?></td>

                    <td width="5%" style="text-align:center;">
                    <script type="text/javascript">
                        function konfirmasi<?php echo $data[0]; ?>() {
                            var answer = confirm("Anda yakin akan menghapus data (<?php echo $data['variabel']; ?>) ini ?")
                            if (answer){
                                window.location = "?page=variabel-input&stat=hapus&id=<?php echo"$data[0]"; ?>";
                            }
                        }
                        </script>
                        <a href="?page=variabel-input&stat=ubah&id=<?php echo $data['id_variabel']; ?>" class="btn btn-warning"><i class="icon ion-android-create"></i> Ubah</a>
                        <a class="btn btn-danger" style="color:white" onclick="konfirmasi<?php echo $data[0]; ?>()"><i class="icon ion-trash-a"></i> Hapus</a>
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
                <tbody>
              </table>
              <br />
                <div style="float: right;">
                  <?php
                    $cari=""; $url="";
                    $url=(trim($cari=="") ? $url="?page=variabel&" : $url="?page=variabel&cari=$cari&");
                    $query="SELECT id_variabel FROM variabel";
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