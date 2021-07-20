<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Himpunan</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="?page=home">Beranda</a></li>
          <li class="breadcrumb-item">Data Fuzzy</li>
          <li class="breadcrumb-item active">Himpunan</li>
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
          <h2 class="card-title" style="margin-bottom: 1px;">Daftar Himpunan</h2>
        </div>
        <div class="card-body">
          <div style="float: right;">
            <a href="?page=himpunan-input&stat=tambah" class="btn btn-primary"><i class="icon ion-android-add-circle"></i> Tambah</a>
          </div>

          <br />
          <div style="clear:both; height:10px;"></div>
          <div class="form-style-2">
            <table class="table table-striped table-bordered" width="100%" border="0" cellspacing="0" cellpadding="4">
              <thead>
                <tr>
                  <td width="3%"><b>No.</b></td>
                  <td width="20%"><b>Variabel</b></td>
                  <td width="9%"><b>Kode</b></td>
                  <td width="15%"><b>Himpunan</b></td>
                  <td width="15%"><b>a-b-c-d</b></td>
                  <td width="19%"><b>Kurva</b></td>
                  <td width="19%" style="text-align:center"><b>Aksi</b></td>
                </tr>
              </thead>
              <tbody>
                  <?php
                    $pg = (int)(!isset($_GET["pg"]) ? 1 : @$_GET["pg"]);
                    $limit = 10;
                    $startpoint = ($pg * $limit) - $limit;
                    $no=$startpoint;
                    $hquery=querydb("SELECT a.id_variabel_himpunan, a.himpunan, a.id_variabel, a.kode, a.himpunan, a.range, a.kurva, b.variabel 
                              FROM himpunan as a, variabel as b 
                            WHERE a.id_variabel=b.id_variabel 
                            ORDER BY b.id_variabel ASC, a.id_variabel_himpunan ASC LIMIT {$startpoint}, {$limit}");
                    while($data=mysql_fetch_assoc($hquery)){
                    $no++;
                  ?>
                <tr>
                  <td><?php echo $no; ?></td>
                  <td><?php echo $data['variabel']; ?></td>
                  <td><?php echo $data['kode']; ?></td>
                  <td><?php echo $data['himpunan']; ?></td>
                  <td><?php echo $data['range']; ?></td>
                  <td><?php echo $data['kurva']; ?></td>
                  <td width="6%" style="text-align:center;">
                <script type="text/javascript">
                      function konfirmasi<?php echo $data['id_variabel_himpunan']; ?>() {
                          var answer = confirm("Anda yakin akan menghapus data (<?php echo $data['variabel']." - ".$data['himpunan']; ?>) ini ?")
                          if (answer){
                              window.location = "?page=himpunan-input&stat=hapus&id=<?php echo"$data[id_variabel_himpunan]"; ?>";
                          }
                      }
                      </script>
                      <a href="?page=himpunan-input&stat=ubah&id=<?php echo $data['id_variabel_himpunan']; ?>" class="btn btn-warning"><i class="icon ion-android-create"></i> Ubah</a>
                      <a style="color:white" class="btn btn-danger" onclick="konfirmasi<?php echo $data['id_variabel_himpunan']; ?>()"><i class="icon ion-trash-a"></i> Hapus</a>
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
              <br/>
                <div style="float: right;">
                  <?php
                    $cari=""; $url="";
                    $url=(trim($cari=="") ? $url="?page=himpunan&" : $url="?page=himpunan&cari=$cari&");
                    $query="SELECT id_variabel_himpunan FROM himpunan";
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