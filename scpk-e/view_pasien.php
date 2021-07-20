<?php
$id		= (int)antiinjec(@$_GET['id']);
$hdata=querydb("SELECT id_pasien, no_pasien, nama_lengkap, tempat_lahir, tanggal_lahir, jenis_kelamin, alamat_lengkap, no_telepon, pekerjaan, terdaftar FROM pasien WHERE id_pasien=$id");
$data=mysql_fetch_array($hdata);
?>

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
          <li class="breadcrumb-item active">Lihat Detail Data Pasien</li>
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
					<h2 class="card-title" style="margin-bottom: 1px;">Detail Data Pasien</h2>
				</div>
				<div class="card-body">
                <form>
                  <div class="form-group row">
                  <label for="no_pasien" class="col-sm-2 col-form-label">Nomor Pasien</label>
                  <div class="col-sm-10">
                    <input type="text" readonly class="form-control-plaintext" id="staticNo" value="<?php echo"$data[no_pasien]";?>">
                  </div>
                  </div>

                  <div class="form-group row">
                  <label for="nama_lengkap" class="col-sm-2 col-form-label">Nama Lengkap</label>
                  <div class="col-sm-10">
                    <input type="text" readonly class="form-control-plaintext" id="staticNama" value="<?php echo"$data[nama_lengkap]";?>">
                  </div>
                  </div>
                
                  <div class="form-group row">
                  <label for="tempat_lahir" class="col-sm-2 col-form-label">Tempat Lahir</label>
                  <div class="col-sm-10">
                    <input type="text" readonly class="form-control-plaintext" id="staticTempat_lahir" value="<?php echo"$data[tempat_lahir]";?>">
                  </div>
                  </div>

                  <div class="form-group row">
                  <label for="tanggal_lahir" class="col-sm-2 col-form-label">Tanggal Lahir</label>
                  <div class="col-sm-10">
                    <input type="text" readonly class="form-control-plaintext" id="staticTanggal_lahir" value="<?php echo date("d-m-Y", strtotime($data['tanggal_lahir']));?>">
                  </div>
                  </div>

                  <div class="form-group row">
                  <label for="jenis_kelamin" class="col-sm-2 col-form-label">Jenis Kelamin</label>
                  <div class="col-sm-10">
                    <input type="text" readonly class="form-control-plaintext" id="staticJenis_kelamin" value="<?php if($data['jenis_kelamin']=="L") { echo "Laki-laki"; } elseif($data['jenis_kelamin']=="P") { echo "Perempuan"; } ?>">
                  </div>
                  </div>

                  <div class="form-group row">
                  <label for="alamat_lengkap" class="col-sm-2 col-form-label">Alamat Lengkap</label>
                  <div class="col-sm-10">
                    <input type="text" readonly class="form-control-plaintext" id="staticAlamat_Lengkap" value="<?php echo"$data[alamat_lengkap]";?>">
                  </div>
                  </div>

                  <div class="form-group row">
                  <label for="no_telepon" class="col-sm-2 col-form-label">No Telepon</label>
                  <div class="col-sm-10">
                    <input type="text" readonly class="form-control-plaintext" id="staticNo_telepon" value="<?php echo"$data[no_telepon]";?>">
                  </div>
                  </div>

                  <div class="form-group row">
                  <label for="pekerjaan" class="col-sm-2 col-form-label">Pekerjaan</label>
                  <div class="col-sm-10">
                    <input type="text" readonly class="form-control-plaintext" id="staticPekerjaan" value="<?php echo"$data[pekerjaan]";?>">
                  </div>
                  </div>
            <br />
            <div class="form-group row">
            <div class="col-sm-10">
              <button type="submit" class="btn btn-warning" onclick="window.history.back();" value="Kembali">Kembali</button>
            </div>
            </div>
          </form>
				</div>
			</div>
		</div>
	</div>
</section>