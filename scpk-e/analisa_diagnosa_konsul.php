<script>
  function disp_confirm(){
    var r=confirm("Apakah Anda Akan Mengulangi Konsultasi...!!!")
    if (r==true){
      document.location='?page=permohonan'
    }
  }      
</script>

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
					<h2 class="card-title" style="margin-bottom: 1px;">Permohonan</h2>
				</div>
				<div class="card-body">
          <?php 
           error_reporting(0);
           $cn=mysql_connect("localhost","root","");
           mysql_select_db("scpk");

           $z= mysql_query("SELECT b.resiko AS resiko, c.tanggal AS tanggal, c.id_ahd AS id_ahd
	              FROM resiko b, menganalisa c , relasi d WHERE b.id_resiko=d.id_resiko and d.id_node=c.id_kd  order by c.id_ahd desc limit 1");
          
            $query= mysql_query("SELECT * FROM pasien");
            $q = mysql_fetch_array($z);
            $id=$q['id_ahd'];
          ?>

          <form  method='post' action='diagnosa/cetak.php'>  
            
            <div style="margin: 20px; font-size: 20px;">
              <b>Hasil :</b>
            </div>

            <div style="margin: 20px; width: 70%; height: 80px; margin: 20px; padding: 25px; text-align: left; border: 3px outset #9B9B9B;">
              <b><?php echo $q['resiko'] ?></b>
            </div>

            <div style="margin: 20px;">	
                <input type="button" class="btn btn-warning" onclick="disp_confirm()" value="kembali" &nbsp;&nbsp;>
            </div>
            
          </form>   

        </div>
      </div>
    </div>
  </div>
</section>


