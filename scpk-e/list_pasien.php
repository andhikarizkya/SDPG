<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Pasien</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="?page=home">Beranda</a></li>
                    <li class="breadcrumb-item">Data Pasien</li>
                    <li class="breadcrumb-item active">Lihat Data Pasien</li>
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
                    <h2 class="card-title" style="margin-bottom: 1px;">Daftar Pasien</h2>
                </div>
                <div class="card-body">
                    <?php
                        $cari=@$_GET['cari'];
                    ?>
                    <div class="form-style-2">
                        <form class="form-inline ml" style="display: inline-block;" method="get" action="">
                            <input type="hidden" name="page" value="pasien" />
                            <div class="input-group mb-3">
                                <input class="form-control" type="text" name="cari" placeholder="Pencarian" aria-label="Pencarian" value="<?php echo $cari; ?>">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="submit" value="Cari">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                        <?php if($tipe_adm==1) { ?>
                        <div style="float: right;">
                            <a href="?page=pasien-input&stat=tambah" class="btn btn-primary"><i class="icon ion-android-add-circle"></i> Tambah</a>
                        </div>
                        <?php } ?>
                        
                        <br />
                        <div style="clear:both; height:10px;"></div>
                        <table class="table table-striped table-bordered" width="100%" border="0" cellspacing="0" cellpadding="4">
                            <thead>
                                <tr>
                                    <td width="3%"><b>No.</b></td>
                                    <td width="11%"><b>No. Pasien</b></td>
                                    <td width="26%"><b>Nama Lengkap</b></td>
                                    <td width="15%"><b>No. Telepon</b></td>
                                    <td width="13%"><b>Pekerjaan</b></td>
                                    <td width="12%"><b>Terdaftar</b></td>
                                        <?php if($tipe_adm==1) { ?>
                                    <td width="20%" style="text-align:center"><b>Aksi</b></td>
                                        <?php } elseif($tipe_adm==2) { ?>
                                    <td width="6%" style="text-align:center"><b>Detail<b></td>
                                        <?php } ?>
                                </tr>
                            </thead>
                            <tbody>
                                    <?php
                                        $pg = (int)(!isset($_GET["pg"]) ? 1 : @$_GET["pg"]);
                                        $limit = 10;
                                        $startpoint = ($pg * $limit) - $limit;
                                        $no=$startpoint;
                                        $hquery=querydb("SELECT id_pasien, no_pasien, nama_lengkap, tempat_lahir, tanggal_lahir, jenis_kelamin, alamat_lengkap, no_telepon, pekerjaan, terdaftar
                                                        FROM pasien
                                                        WHERE no_pasien LIKE '%".$cari."%' OR nama_lengkap LIKE '%".$cari."%' 
                                                        ORDER BY id_pasien ASC LIMIT {$startpoint}, {$limit}");
                                        while($data=mysql_fetch_assoc($hquery)){
                                            $no++;
                                    ?>
                                <tr>
                                    <td><?php echo $no; ?></td>
                                    <td><?php echo $data['no_pasien']; ?></td>
                                    <td><?php echo $data['nama_lengkap']; ?></td>
                                    <td><?php echo $data['no_telepon']; ?></td>
                                    <td><?php echo $data['pekerjaan']; ?></td>
                                    <td><?php echo date("d-m-Y", strtotime($data['terdaftar'])); ?></td>
                                    <?php if($tipe_adm==1) { ?>
                                        <td width="6%" style="text-align:center;">
                                        <script type="text/javascript">
                                        function konfirmasi<?php echo $data['id_pasien']; ?>() {
                                            var answer = confirm("Anda yakin akan menghapus data pasien no : <?php echo $data['no_pasien']; ?> ini ?")
                                            if (answer){
                                                window.location = "?page=pasien-input&stat=hapus&id=<?php echo"$data[id_pasien]"; ?>";
                                            }
                                        }
                                        </script>
                                        <a href="?page=pasien-input&stat=ubah&id=<?php echo $data['id_pasien']; ?>" class="btn btn-warning"><i class="icon ion-android-create"></i> Ubah</a>
                                        <a style="color:white" class="btn btn-danger" onclick="konfirmasi<?php echo $data['id_pasien']; ?>()"><i class="icon ion-trash-a"></i> Hapus</a>
                                    </td>
                                    <?php } else { ?>
                                    <td width="6%" style="text-align:center;">
                                        <a href="?page=pasien-view&id=<?php echo $data['id_pasien']; ?>" class="btn btn-primary">Detail</a>
                                    </td>
                                    <?php } ?>
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
                            <div style="float: right;">
                                <?php
                                    $cari=""; $url="";
                                    $url=(trim($cari=="") ? $url="?page=pasien&" : $url="?page=pasien&cari=$cari&");
                                    $query="SELECT id_pasien FROM pasien WHERE no_pasien LIKE '%".$cari."%' OR nama_lengkap LIKE '%".$cari."%'";
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