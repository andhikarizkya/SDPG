<?php 
include "../config/koneksi.php";
include "../config/library.php";
opendb();
$id=antiinjec(@$_GET['id']);
if(strlen($id)>=3) {
	$query="";
	$query="SELECT id_pasien, nama_lengkap, alamat_lengkap, no_telepon FROM pasien WHERE no_pasien='".$id."'";
	$h_query=querydb($query);
	$d_query=mysql_fetch_assoc($h_query);
	if($d_query['id_pasien']!="") {
		?>
		<style>
            table.tabel_dalam  { border-collapse:collapse; border:0px; padding:0px; }
            table.tabel_dalam tr { border:0px; }
            table.tabel_dalam tr td { border:0px; }
        </style>
        <table class="tabel_dalam">
            <tr>
                  <td width="300">
                        <a style="margin-left: 160px; font-size: 15px; float: right;">Nama Pasien</a>
                  </td>
                  <td width="760">
                        <div class="col-md-6">
                              : <?php echo $d_query['nama_lengkap']; ?>
                              <input type='hidden' name='id_pasien' class='input-field required' value='<?php echo $d_query['id_pasien']; ?>' title='Belum ada data Nasabah Terpilih.'>
                        </div>
                  </td>
            </tr>
            <tr>
                  <td>
                        <a style="margin-left: 160px; font-size: 15px; float: right;">No. Telepon</a>
                  </td>
                  <td>
                        <div class="col-md-6">
                              : <?php echo $d_query['no_telepon']; ?>
                        </div>
                  </td>
            </tr>
            <tr>
                  <td>  
                        <a style="margin-left: 160px; font-size: 15px; float: right;">Alamat</a>
                  </td>
                  <td>
                        <div class="col-md-6">
                              : <?php echo $d_query['alamat_lengkap']; ?>
                        </div>
                  </td>
            </tr>
        </table>
		<?php
	} else {
		?>
		<style>
            table.tabel_dalam  { border-collapse:collapse; border:0px; padding:0px; }
            table.tabel_dalam tr { border:0px; }
            table.tabel_dalam tr td { border:0px; }
        </style>
        <table class="tabel_dalam">
            <tr>
                  <td width="300">
                  </td>
                  <td width="760" style="color:#F30;">
                        <div class="col-md-8">
                              <b>Data Pasien Tidak Ditemukan</b>
                              <br />
                              Silahkan periksa lagi Nomor Pasien yang Anda masukkan
                        </div>
                  </td>
            </tr>
            <tr>
                  <td>
                        <a style="margin-left: 160px; font-size: 15px; float: right;">Nama Pasien</a>
                  </td>
                  <td>
                        <div class="col-md-6">
                              : Tidak ditemukan <input type='hidden' name='id_pasien' class='input-field required' title='[ Belum ada data Nasabah Terpilih. ]'>
                        </div>
                  </td>
            </tr>
            <tr>
                  <td>
                        <a style="margin-left: 160px; font-size: 15px; float: right;">No. Telepon</a>
                  </td>
                  <td>
                        <div class="col-md-6">
                              : Tidak ditemukan
                        </div>
                  </td>
            </tr>
            <tr>
                  <td>
                        <a style="margin-left: 160px; font-size: 15px; float: right;">Alamat</a>
                  </td>
                  <td>
                        <div class="col-md-6">
                              : Tidak ditemukan
                        </div>
                  </td>
            </tr>
        </table>
        <?php
	}
} else {
?>
	<style>
        table.tabel_dalam  { border-collapse:collapse; border:0px; padding:0px; }
        table.tabel_dalam tr { border:0px; }
        table.tabel_dalam tr td { border:0px; }
    </style>
    <table class="tabel_dalam">
            <tr>
                  <td width="300">
                        <a style="margin-left: 160px; font-size: 15px; float: right;">Nama Pasien</a>
                  </td>
                  <td width="760">
                        <div class="col-md-6">
                              : - <input type='hidden' name='id_pasien' class='input-field required' title=' [ Belum ada data Nasabah Terpilih. ]'>
                        </div>
                  </td>
            </tr>
            <tr>
                  <td>
                        <a style="margin-left: 160px; font-size: 15px; float: right;">No. Telepon</a>
                  </td>
                  <td>
                        <div class="col-md-6">
                              : -
                        </div>
                  </td>
            </tr>
            <tr>
                  <td>
                        <a style="margin-left: 160px; font-size: 15px; float: right;">Alamat<a>
                  </td>
                  <td>
                        <div class="col-md-6">
                              : -
                        </div>
                  </td>
            </tr>
    </table>
<?php	
}
closedb();
?>