<script>
	function disp_confirm(){
		var r=confirm("Apakah Anda Akan Mengulangi Konsultasi...!!!")
		if (r==true){
			document.location='?page=solving-konsul&idtanya=2'
		}
	}      
</script>

<style>
/* The container */
.container {
  display: inline-block;
  position: relative;
  padding-left: 35px;
  margin-bottom: 12px;
  cursor: pointer;
  font-size: 22px;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

/* Hide the browser's default radio button */
.container input {
  position: absolute;
  opacity: 0;
  cursor: pointer;
}

/* Create a custom radio button */
.checkmark {
  position: absolute;
  top: 0;
  left: 0;
  height: 25px;
  width: 25px;
  background-color: #eee;
  border-radius: 50%;
}

/* On mouse-over, add a grey background color */
.container:hover input ~ .checkmark {
  background-color: #ccc;
}

/* When the radio button is checked, add a blue background */
.container input:checked ~ .checkmark {
  background-color: #2196F3;
}

/* Create the indicator (the dot/circle - hidden when not checked) */
.checkmark:after {
  content: "";
  position: absolute;
  display: none;
}

/* Show the indicator (dot/circle) when checked */
.container input:checked ~ .checkmark:after {
  display: block;
}

/* Style the indicator (dot/circle) */
.container .checkmark:after {
 	top: 9px;
	left: 9px;
	width: 8px;
	height: 8px;
	border-radius: 50%;
	background: white;
}
</style>

<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 text-dark" style="margin-bottom: 1px;">Data Permohonan</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
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
						
						if(!isset($_POST['idtanya'])){
							//tampilkan pertanyaan pertama
							$sqlp = "SELECT * FROM konsul_diagnosa WHERE mulai='Y'";
							$rs=mysql_query($sqlp);
							$data=mysql_fetch_array($rs);
					?>

					<form>

						<?php echo $data['pertanyaan']; ?>
						<input type="radio" name="idtanya" value="<?php echo"$data[bila_benar]"; ?>">Ya<br>
						<input type="radio" name="idtanya" value="<?php echo"$data[bila_salah]"; ?>">Tidak<br>

						<input type='submit' value='Lanjut >> ' >
						<input type="button" onclick="disp_confirm()" value="Batal">

						<!-- <div style="width: 70%; height: 80px; margin: 20px; padding: 25px; text-align: left; border: 3px outset #9B9B9B;">
							<a> </a>
						</div>

						<div style="margin: 20px;">
							<label class="container">Ya
								
								<span class="checkmark" ></span>
							</label>
							<label class="container">Tidak
								
								<span class="checkmark"></span>
							</label>
						</div>

						<div style="margin: 20px;">
							<input type="submit" class="btn btn-primary" value="Lanjut"></button>
						</div> -->
					</form>

					<?php 
						}else{
						//tampilkan pertanyaan pertama
							$idsolusi=$_POST['idtanya'];
							$sqlp = "SELECT * FROM konsul_diagnosa WHERE id_kd=$idsolusi";
							$rs=mysql_query($sqlp);
							$data=mysql_fetch_array($rs);
							
							$NOIP= $_SERVER['REMOTE_ADDR'];
							$q=mysql_fetch_array(mysql_query("SELECT * FROM pasien ORDER BY id_pasien DESC LIMIT 1"));
					?>

						<form method='POST' action='?page=solving-konsulTes'>
							<div style="margin: 20px; font-size: 20px;">
								<b>Pertanyaan :</b>
							</div>

							<div style="margin: 20px; width: 70%; height: 80px; margin: 20px; padding: 25px; text-align: left; border: 3px outset #9B9B9B;">
								<?php echo $data['pertanyaan']; ?>
							</div>

							<!-- <div style="width: 70%; height: 80px; margin: 20px; padding: 25px; text-align: left; border: 3px outset #9B9B9B;">
								<a> </a>
							</div> -->

							<?php if($data['selesai']!="Y"){ ?>

							<div style="margin: 20px;">	
								<label class="container">Ya
									<input type="radio" name="idtanya" value="<?php echo"$data[bila_benar]"; ?>">
									<span class="checkmark" ></span>
								</label>
								<label class="container">Tidak
									<input type="radio" name="idtanya" value="<?php echo"$data[bila_salah]"; ?>">
									<span class="checkmark" ></span>
								</label>
							</div>

							<div style="margin: 20px;">
								<div style="clear:both; height:10px;"></div>

								<input type='submit' class='btn btn-primary'  value='Lanjut' >
								<input type="button" class="btn btn-warning" onclick="disp_confirm()" value="Batal">
							</div>

								

							<!-- <div style="margin: 20px;">
								<label class="container">Ya
									
									<span class="checkmark" ></span>
								</label>
								<label class="container">Tidak
									
									<span class="checkmark"></span>
								</label>
							</div>

							<div style="margin: 20px;">
								<input type="submit" class="btn btn-primary" value="Lanjut">
								<input type="button" class="btn btn-warning" onclick="disp_confirm()" value="Batal">
							</div> -->

							<?php 
								}else{			
									$query=mysql_query("INSERT INTO menganalisa VALUES('','$q[id_pasien]','$data[id_kd]',NOW())");
									
									//jika ingin menambah pertanyaan								
							?>

						<meta http-equiv='refresh' content='0; url=?page=analisa-diagnosa-konsul'>		
						
							<?php } ?>
					
					</form>
					
					<?php } ?>

				</div>
			</div>
		</div>
	</div>
</section>