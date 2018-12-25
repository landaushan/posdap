<?php
if(session_status()!==2)session_start();//>=php 5.4
if(!isset($_SESSION['SES_LOGIN'])){
	header('location:../home');
 }

?>

<div class="main">  
  <div class="main-inner">
    <div class="container">
    	<span id="dataTambahUbah"></span>

    		<div class="row">
        <div class="span12">
          <div class="widget">
            <div class="widget-header"> <i class="icon-copy"></i>
              <h3>Data Toko</h3>
            </div>
            <!-- /widget-header -->
            <div class="widget-content">
              <div class="shortcuts"> 

              	<div class="table-responsive">
					<table class="table table-condensed table-bordered">
						<tr>
							<th>Kode Toko</th>
							<th>Nama Toko</th>
							<th>Alamat</th>
							<th>Telepon</th>
							<th>Fax</th>
							<th>Logo</th>
							<th align="center">Pilihan</th>
						</tr>
						<?php
							$qri = "SELECT * FROM ma_toko";
							$hsl = querydb($qri);
							while($rek = arraydb($hsl)){
							
							 echo "<tr>";
							 echo "<td align='center'>".$rek['kd_toko']."</td>";
							 echo "<td align='center'>".$rek['nm_toko']."</td>";
							 echo "<td align='left'>".$rek['almt_toko']."</td>";
							 echo "<td align='center'>".$rek['tlp_toko']."</td>";
							 echo "<td align='center'>".$rek['fax_toko']."</td>";
							 echo "<td align='center'>".$rek['logo']."</td>";
							 echo "<td align='center'><button class='btn btn-xs btn-warning' data-val='$rek[kd_toko]' id='btnTokoUbah' data-toggle=\"tooltip\" data-placement=\"top\" title=\"Edit Data\"><span class=\"shortcut-icon icon-pencil\"></span></button></td>";
							// echo "<td align='center'><a href='?open=data_master/toko_data.php&kd_toko=$rek[kd_toko]' data-toggle=\"tooltip\" data-placement=\"top\" title=\"Hapus Data Toko\" onclick=\"return confirm('ANDA YAKIN AKAN MENGHAPUS DATA TOKO INI ... ?')\"><span class=\"glyphicon glyphicon-remove\"></span></td>";
							 echo "<tr>";
							}
						?>
					</table>
				</div><!-- /class responsive -->

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


