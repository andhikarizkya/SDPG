<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="?page=home">Beranda</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->


    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
        <?php if($tipe_adm==1) { ?>
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
              <?php 
                $totalpermohonan=mysql_query("SELECT count(*) as total from permohonan");
                $jumlahpermohonan=mysql_fetch_assoc($totalpermohonan); 
              ?>
                <h3><?php echo $jumlahpermohonan["total"]; ?></h3>

                <p>Data Rekam Medis</p>
              </div>
              <div class="icon">
                <i class="ion ion-ios-medical"></i>
              </div>
              <a href="?page=hasil" class="small-box-footer">Buka Tautan <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
              <?php 
                $totalpermohonan=mysql_query("SELECT count(*) as total from permohonan");
                $jumlahpermohonan=mysql_fetch_assoc($totalpermohonan); 
              ?>
                <h3><?php echo $jumlahpermohonan["total"]; ?></h3>

                <p>Data Permohonan</p>
              </div>
              <div class="icon">
                <i class="ion ion-ios-pulse-strong"></i>
              </div>
              <a href="?page=permohonan" class="small-box-footer">Buka Tautan <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-secondary">
              <div class="inner">
                <h3>8</h3>

                <p>Data Master</p>
              </div>
              <div class="icon">
                <i class="ion ion-ios-medkit"></i>
              </div>
              <a class="small-box-footer">Buka Tautan <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
              <?php 
                $totalpasien=mysql_query("SELECT count(*) as total from pasien");
                $jumlahpasien=mysql_fetch_assoc($totalpasien); 
              ?>
                <h3><?php echo $jumlahpasien["total"]; ?></h3>

                <p>Data Pasien</p>
              </div>
              <div class="icon">
                <i class="ion ion-person"></i>
              </div>
              <a href="?page=pasien" class="small-box-footer">Buka Tautan <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        <?php } elseif($tipe_adm==2) { ?>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
              <?php 
                $totalpasien=mysql_query("SELECT count(*) as total from pasien");
                $jumlahpasien=mysql_fetch_assoc($totalpasien); 
              ?>
                <h3><?php echo $jumlahpasien["total"]; ?></h3>

                <p>Data Pasien</p>
              </div>
              <div class="icon">
                <i class="ion ion-person"></i>
              </div>
              <a href="?page=pasien" class="small-box-footer">Buka Tautan <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        <?php } ?>
        </div>

        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
          <ol class="carousel-indicators">
            <li data-target="#carousel-example-generic" data-slide-to="0" class=""></li>
            <li data-target="#carousel-example-generic" data-slide-to="1" class=""></li>
            <li data-target="#carousel-example-generic" data-slide-to="2" class="active"></li>
          </ol>
          <div class="carousel-inner">
            <div class="item active">
              <img src="img/background.png" alt="First slide">
              <div class="carousel-caption">
              </div>
            </div>
          </div>
        </div>
        <!-- /.row -->
        <!-- Main row -->
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>