<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Data User</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="?page=home">Beranda</a></li>
          <li class="breadcrumb-item">Data Fuzzy</li>
          <li class="breadcrumb-item active">Data User</li>
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
          <h2 class="card-title" style="margin-bottom: 1px;">Daftar Aturan</h2>
        </div>
        <div class="card-body">
          <div style="float: right;">
            <a href="?page=user-input&stat=tambah" class="btn btn-primary"><i class="icon ion-android-add-circle"></i> Tambah</a>
          </div>

          <br />
          <div style="clear:both; height:10px;"></div>
          <div class="csstable" >
            <table class="table table-striped table-bordered" width="100%" border="0" cellspacing="0" cellpadding="4">
              <thead>
                <tr>
                  <td width="3%"><b>No.</b></td>
                  <td width="23%"><b>Nama Lengkap</b></td>
                  <td width="14%"><b>No. Telepon</b></td>
                  <td width="15%"><b>Username</b></td>
                  <td width="13%"><b>Tipe</b></td>
                  <td width="13%"><b>Terdaftar</b></td>
                  <td width="19%" style="text-align:center"><b>Aksi</b></td>
                </tr>
              </thead>
              <tbody>
                  <?php
                    $pg = (int)(!isset($_GET["pg"]) ? 1 : @$_GET["pg"]);
                    $limit = 10;
                    $startpoint = ($pg * $limit) - $limit;
                    $no=$startpoint;
                    $hquery=querydb("SELECT id_user, nama_lengkap, no_telepon, username, tipe_akses, terdaftar FROM user ORDER BY id_user ASC LIMIT {$startpoint}, {$limit}");
                    while($data=mysql_fetch_array($hquery)){
                    $no++;
                    if($data['tipe_akses']==1) { $tipe_akses_usr="Kader"; }
                    elseif($data['tipe_akses']==2) { $tipe_akses_usr="Administrator"; }
                  ?>
                <tr>
                  <td><?php echo $no; ?></td>
                  <td><?php echo $data['nama_lengkap']; ?></td>
                  <td><?php echo $data['no_telepon']; ?></td>
                  <td><?php echo $data['username']; ?></td>
                  <td><?php echo $tipe_akses_usr; ?></td>
                  <td><?php echo date("d-m-Y", strtotime($data['terdaftar'])); ?></td>
                  <td width="6%" style="text-align:center;">
                    <script type="text/javascript">
                      function konfirmasi<?php echo $data[0]; ?>() {
                          var answer = confirm("Anda yakin akan menghapus data (<?php echo $data['username']; ?>) ini ?")
                          if (answer){
                              window.location = "?page=user-input&stat=hapus&id=<?php echo"$data[0]"; ?>";
                          }
                      }
                      </script>
                      <a href="?page=user-input&stat=ubah&id=<?php echo $data['id_user']; ?>" class="btn btn-warning"><i class="icon ion-android-create"></i> Ubah</a>
                      <a style="color:white" class="btn btn-danger" onclick="konfirmasi<?php echo $data[0]; ?>()"><i class="icon ion-trash-a"></i> Hapus</a>
                  </td>
                </tr>
                  <?php } if(@$_GET['con']!="") { ?>
                <tr>
                  <td colspan="7" style="color:#360; font-weight:600; font-size:14px;">
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
              <?php
                $cari=""; $url="";
                $url=(trim($cari=="") ? $url="?page=user&" : $url="?page=user&cari=$cari&");
                $query="SELECT id_user FROM user";
                echo pagination($query,$limit,$pg,$url); 
              ?>
            <br />
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
