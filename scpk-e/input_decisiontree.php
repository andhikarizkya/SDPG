<!-- <script>
	function disp_confirm(){
		var r=confirm("Apakah Anda Akan Mengulangi Konsultasi...!!!")
		if (r==true){
		window.location = "index.php?page=konsul"
		}
	}      
</script> -->
<!-- <?php
// error_reporting(0);
// include("library/koneksi.php");
?> -->

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
						if(!isset($_POST['idtanya'])){
							//tampilkan pertanyaan pertama
							$sqlp = "SELECT * FROM konsul_diagnosa WHERE mulai='Y'";
							$rs=mysql_query($sqlp);
							$data=mysql_fetch_array($rs);
					?>
					<form>
						<div style="width: 70%; height: 80px; margin: 20px; padding: 25px; text-align: left; border: 3px outset #9B9B9B;">
							<a><?php echo $data['gejala_dan_kerusakan']; ?> </a>
						</div>

						<div style="margin: 20px;">
							<label class="container">Ya
								<input type="radio" name="idtanya" value="<?php echo"$data[bila_benar]"; ?>">
								<span class="checkmark" ></span>
							</label>
							<label class="container">Tidak
								<input type="radio" name="idtanya" value="<?php echo"$data[bila_salah]"; ?>">
								<span class="checkmark"></span>
							</label>
						</div>

						<div style="margin: 20px;">
							<input type="submit" class="btn btn-primary" value="Lanjut"></button>
							<input type="button" class="btn btn-warning" onclick="window.history.back();" value="Batal"></button>
						</div>
					</form>

					<?php 
						} else{ 
						$idsolusi=$_POST['idtanya'];
						$sqlp = "SELECT * FROM konsul_diagnosa WHERE id_kd=$idsolusi";
						$rs=mysql_query($sqlp);
						$data=mysql_fetch_array($rs);
						
						$NOIP= $_SERVER['REMOTE_ADDR'];
						$q=mysql_fetch_array(mysql_query("SELECT * FROM pasien ORDER BY id_nasabah DESC LIMIT 1"));	
					?>

					<form method='POST' action='?page=solving_konsulTes'>
						<div style="width: 70%; height: 80px; margin: 20px; padding: 25px; text-align: left; border: 3px outset #9B9B9B;">
							<a><?php echo $data['gejala_dan_kerusakan']; ?> </a>
						</div>

						<?php if($data['selesai']!="Y"){ ?>

						<div style="margin: 20px;">
							<label class="container">Ya
								<input type="radio" name="idtanya" value="<?php echo"$data[bila_benar]"; ?>">
								<span class="checkmark" ></span>
							</label>
							<label class="container">Tidak
								<input type="radio" name="idtanya" value="<?php echo"$data[bila_salah]"; ?>">
								<span class="checkmark"></span>
							</label>
						</div>

						<div style="margin: 20px;">
							<input type="submit" class="btn btn-primary" value="Lanjut"></button>
							<input type="button" class="btn btn-warning" onclick="window.history.back();" value="Batal"></button>
						</div>

						<?php 
							}else{
				
							$query=mysql_query("INSERT INTO menganalisa VALUES('','$q[id_nasabah]','$data[id_kd]',NOW())");
						?>
						<meta http-equiv='refresh' content='0; url=?page=analisa_diagnosa_konsul'>

						<?php } ?>

					</form>

					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</section>

    <!-- if(!isset($_POST['idtanya'])){
        //tampilkan pertanyaan pertama
        $sqlp = "select * from konsul_diagnosa where mulai='Y'";
        $rs=mysql_query($sqlp);
		$data=mysql_fetch_array($rs);
		


        //bentuk pertanyaan
        echo "<form>";
        echo "<CENTER><h2> <font  color='#19bc9c'>Pertanyaan </font></h2> </CENTER>"; 
		echo "<br/><br/><br/>";
        echo $data['gejala_dan_kerusakan']."<br>";
        echo "<input type='radio' name='idtanya' value='".$data['bila_benar']."'>Ya<br>";
        echo "<input type='radio' name='idtanya' value='".$data['bila_salah']."'>Tidak<br>";
        echo "<input type='submit' value='Lanjut >> ' >";
		echo '<input type="button" onclick="disp_confirm()" value="Batal">';
        echo "</form>";
		
		 }else{
		 //tampilkan pertanyaan pertama
			$idsolusi=$_POST['idtanya'];
			$sqlp = "select * from konsul_diagnosa where id_kd=$idsolusi";
			$rs=mysql_query($sqlp);
			$data=mysql_fetch_array($rs);
			
			$NOIP= $_SERVER['REMOTE_ADDR'];
			$q=mysql_fetch_array(mysql_query("select * from tamu order by id_tamu desc limit 1"));
			//bentuk pertanyaan
			
			echo "<form method='POST' action='?page=solving_konsulTes'>";
			echo "<CENTER><h2> <font  color='#19bc9c'>Pertanyaan</font></h2> </CENTER>"; 
			echo "<br/><br/><br/>";
			echo $data['gejala_dan_kerusakan']."<br>";
			if($data['selesai']!="Y"){
			echo "<input type='radio' name='idtanya' value='".$data['bila_benar']."'>Ya<br>";
			echo "<input type='radio' name='idtanya' value='".$data['bila_salah']."'>Tidak<br><br><br>";
			echo "<input type='submit' class='btn btn-danger'  value='Lanjut' > &nbsp&nbsp";
			echo '<input type="button" class="btn btn-danger" onclick="disp_confirm()" value="Batal">';
			
			}else{
			
			$query=mysql_query("insert into menganalisa values('','$q[id_tamu]','$data[id_kd]',NOW())");
			echo "<meta http-equiv='refresh' content='0; url=?page=analisa_diagnosa_konsul'>";
			
			
			//jika ingin menambah pertanyaan
			}
			
			echo "</form>";
			
			}
			
?> -->
