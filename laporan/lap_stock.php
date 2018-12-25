<?php
if(session_status()!==2)session_start();//>=php 5.4
if(!isset($_SESSION['SES_LOGIN'])){
	header('location:../home');
 }
$user_id=$_SESSION['SES_LOGIN'];
opendb();

$tgl = date("d-m-Y");
?>



<div class="main">  
  <div class="main-inner">
    <div class="container">
	<span id="alertMsg"></span>
    	<span id="dataTambahUbah"></span>

    		<div class="row">
        <div class="span12">
          <div class="widget">
            <div class="widget-header"> <i class="icon-copy"></i>
              <h3>Laporan Stock</h3>
              
            </div>
            <!-- /widget-header -->
            <div class="widget-content">
              <div class="shortcuts"> 

				<form class="form-inline hidden-print" action="" method="post" id="formLaporanStock">
					<div class="form-group">
						<label for="kategori" class="span1">Kategori :</label>
						<select class="form-control input-sm" name="kategori" id="kategori" required>
							<option value="">---Pilih---</option>
						<?php
							$qri = "SELECT * FROM ma_kategori_barang WHERE active='Y'";
							$hsl = querydb($qri);
							while($rek=arraydb($hsl)){
								
								echo "<option value=\"$rek[kd_kategori]\">".$rek['nm_kategori']."</option>";
							}	
						?>
							<option value="all" selected>---Semua---</option>
						</select>
					</div>&nbsp;&nbsp;
					<div class="form-group">
						<label for="stock" class="span1">Stock :</label>
						<select class="form-control input-sm" name="jmlStock" id="jmlStock">
							<option value="">---Pilih---</option>
							<option value="1">0</option>
							<option value="2">dibawah 50</option>
							<option value="3">---Semua---</option>
						</select>
					</div>&nbsp;&nbsp;

					<div class="form-group">
						<label for="stock" class="span1"></label>
						<button class="btn btn-info btn-sm" id="btnLapStockShow"><span class="glyphicon glyphicon-blackboard"></span>&nbsp;Tampilkan</button>
						<button class="btn btn-info btn-sm" id="btnLapStockPrint" onclick="print();"><span class="glyphicon glyphicon-print"></span>&nbsp;&nbsp;Cetak</button>
					</div>&nbsp;&nbsp;

				
				</form>
				
				<br>
				<span id="tblPlaceHolder"></span>
              </div>
              <!-- /shortcuts --> 
            </div>
            <!-- /widget-content --> 
          </div>
        </div>
        <!-- span -->
      </div>
    	
    </div> <!-- /container -->
  </div> <!-- /main-inner -->
</div> <!-- /main -->
