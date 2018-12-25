<?php
if(session_status()!==2)session_start();//>=php 5.4
if(!isset($_SESSION['SES_LOGIN'])){
	header('location:../home');
 }

?>


<div class="main">  
  <div class="main-inner">
    <div class="container">


    		<div class="row">
        <div class="span12">
          <div class="widget">
            <div class="widget-header"> <i class="icon-copy"></i>
              <h3>Data Stock Barang</h3>
              
            </div>
            <!-- /widget-header -->
            <div class="widget-content">
              <div class="shortcuts"> 

				<form class="form-horizontal" action="" method="post" id="formCariStock">
							<div class="control-group">
								<label for="nmKategori" class="span1 ">Kategori :</label>
								<div class="span2">
									<select class="form-control input-sm" name="kategori" id="kategori" required>
									<option value="all">---Semua---</option>
									<?php
										$qri = "SELECT * FROM ma_kategori_barang WHERE active='Y'";
										$hsl = querydb($qri);
										while($rek=arraydb($hsl)){
											
											echo "<option value=\"$rek[kd_kategori]\">".$rek['nm_kategori']."</option>";
										}	
									?>
										
									</select>

								</div>

								

								<label for="stovk" class="span1 control-label pad-right-zero">Stock :</label>
								<div class="span2">
								<select class="form-control input-sm " name="jmlStock" id="jmlStock">
									<option value="3">---Semua---</option>
									<option value="1">0</option>
									<option value="2">dibawah 50</option>
									
								</select>
								</div>

								<label for="nmKategori" class="span1 control-label pad-right-zero"></label>
								<div class="span2">

								<button type="submit" class="btn btn-info btn-sm " name="btnCariStock" id="btnCariStock">Cari Data</button>
								</div>
							</div>
							
							
						</form>
						<div class="row"><div class="col-sm-12">&nbsp;</div></div>
						<div class="table-responsive">
							<span id="tblPlaceHolder">
								<table class="table table-condensed table-bordered">
									<tr>
										<th>No</th>
										<th>Kode Barang</th>
										<th>Nama Barang</th>
										<th>Satuan Barang</th>
										<th>Jumlah Stock</th>
										<th>Harga Beli <br>Rata-Rata</th>
										<th>Harga Jual</th>
									</tr>
									
									
								</table>
							</span>
						</div>
				

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
