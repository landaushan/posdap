<?php
if(session_status()!==2)session_start();//>=php 5.4
if(!isset($_SESSION['SES_LOGIN'])){
	header('location:../home');
 }
require_once "library/inc.library.php";
 
opendb();

//Menentukan batas, cek halaman dan posisi data
		$batas= 8;//Jumlah tampilan record per halaman minimum
		if(isset($_GET['halaman']))$halaman = $_GET['halaman'];
		if (empty($halaman)){$posisi=0; $halaman=1;} else {$posisi=($halaman-1) * $batas;} 
		
		$qry2 ="SELECT * FROM ma_kategori_barang";
		$hsl2 = querydb($qry2);
		$jml_data = numrows($hsl2);
		
		$jml_hal = ceil($jml_data/$batas);
		if ($jml_hal>20) {$jml_hal=20 AND $batas=ceil($jml_data/$jml_hal);$posisi=($halaman-1) * $batas;}
		//$file="page.php?open=data_master/kategori_data.php";
		$file="page.php?open=kategori_data";
		
?>


<div class="main">  
  <div class="main-inner">
    <div class="container">
    	<span id="dataTambahUbah"></span>

    		<div class="row">
        <div class="span12">
          <div class="widget">
            <div class="widget-header"> <i class="icon-copy"></i>
              <h3>Data Kategori</h3>
              <button class="btn btn-info btn-sm" id="btnKategoriTambah">Tambah Data</button>
            </div>
            <!-- /widget-header -->
            <div class="widget-content">
              <div class="shortcuts"> 

				<div class="clearfix"></div>
				<p></p>
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-condensed table-hover">
						<tr>
							<th>No</th>
							<th>Kode Kategori</th>
							<th>Nama Kategori Barang</th>
							<th>Status</th>
							<th colspan="2" align="center">Pilihan</th>
						</tr>
						<?php
							$c=1+$posisi;
							$qri = "SELECT a.* FROM ma_kategori_barang a ORDER BY nm_kategori ASC LIMIT $posisi, $batas";
							$hsl = querydb($qri);
							while($rek = arraydb($hsl)){
								if($rek['active']=="Y"){$klsBaris="";$stat="<span class='label label-info'>Active</span>";}else{$klsBaris="danger";$stat="<span class='label label-danger'>Non Active</span>";}
							 echo "<tr class=\"$klsBaris\">";
							 echo "<td align='center'>".$c."</td>";
							 echo "<td align='center'>".$rek['kd_kategori']."</td>";
							 echo "<td align='left'>".$rek['nm_kategori']."</td>";
							 echo "<td align='center'>".$stat."</td>";
							 echo "<td align='center'><button class=\"btn btn-warning btn-xs btnKategoriUbah\" data-val=\"$rek[kd_kategori]\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Edit Data\"><span class=\"shortcut-icon icon-pencil\"></span></button></td>";
							 echo "<td align='center'><button class=\"btn btn-danger btn-xs btnKategoriHapus\" data-val=\"$rek[kd_kategori]\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Hapus Data\"><span class=\"shortcut-icon icon-remove\"></span></button></td>";
							 echo "<tr>";
							 $c++;
							}
						?>
					</table>
				</div><!-- /class responsive -->
				<!-- pagination -->
				<nav><ul class="pagination pagination-sm">
					<?php
					if($halaman >1){$prev=$halaman-1; echo "<li><a href=$file&halaman=1>&laquo;</a><a href=$file&halaman=$prev>&lt;</a></li>";}
					else {echo "<li class='disabled'><a href='#'>&laquo;</a><a href='#'>&lt;</a></li>";} 
					for ($i=1; $i<=$jml_hal; $i++)
					if ($i!=$halaman){echo "<li><a href=$file&halaman=$i>$i</a></li>";} 
					else {echo"&nbsp;<li class='active'><a href='#'>$i</a></li>";};
					if($halaman < $jml_hal) {$next=$halaman+1; echo "<li><a href=$file&halaman=$next>&gt;</a>  <a href=$file&halaman=$jml_hal>&raquo;</a></li>";}
					else {echo "<li class='disabled'><a href='#'>&gt;</a>  <a href='#'>&raquo;</a></li>";}
					?>
				</ul></nav>

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
