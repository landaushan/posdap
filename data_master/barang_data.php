<?php
if(session_status()!==2)session_start();//>=php 5.4
if(!isset($_SESSION['SES_LOGIN'])){
	header('location:../home');
 }
require_once "library/inc.library.php";


//Menentukan batas, cek halaman dan posisi data
		$batas= 7;//Jumlah tampilan record per halaman minimum
		if(isset($_GET['halaman']))$halaman = $_GET['halaman'];
		if (empty($halaman)){$posisi=0; $halaman=1;} else {$posisi=($halaman-1) * $batas;} 
		
		$qry2 ="SELECT * FROM ma_barang";
		$hsl2 = querydb($qry2);
		$jml_data = numrows($hsl2);
	
		$jml_hal = ceil($jml_data/$batas);
		if ($jml_hal>20) {$jml_hal=20 AND $batas=ceil($jml_data/$jml_hal);$posisi=($halaman-1) * $batas;}
		//$file="page.php?open=data_master/barang_data.php";
		$file="page.php?open=barang_data";

?>


<div class="main">  
  <div class="main-inner">
    <div class="container">
    	<span id="dataTambahUbah"></span>

    		<div class="row">
        <div class="span12">
          <div class="widget">
            <div class="widget-header"> <i class="icon-copy"></i>
              <h3>Data Barang</h3>
              <button class="btn btn-info btn-sm" id="btnBarangTambah">Tambah Data</button>
            </div>
            <!-- /widget-header -->
            <div class="widget-content">
              <div class="shortcuts"> 

				<div class="clearfix"></div>
				<p></p>
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-condensed table-hover">
						<tr>
							<th>No.</th>
							<th>Kode Barang</th>
							<th>Nama Barang</th>
							<th>Satuan</th>
							<th>Kategori</th>
							<th>Harga Jual</th>
							<th>Harga Beli</th>
							<th>Status</th>
							<th colspan="3" align="center">Pilihan</th>
						</tr>
						<?php
							$c=1;
							$qri = "SELECT a.*,b.nm_satuan,c.nm_kategori FROM ma_barang a LEFT JOIN ma_satuan_barang b ON b.kd_satuan=a.kd_satuan LEFT JOIN ma_kategori_barang c ON c.kd_kategori=a.kd_kategori ORDER BY nm_barang ASC LIMIT $posisi, $batas";
							$hsl = querydb($qri);
							while($rek = arraydb($hsl)){
								if($rek['active']=="Y"){$klsBaris="";$stat="<span class='label label-info'>Active</span>";}else{$klsBaris="danger";$stat="<span class='label label-danger'>Non Active</span>";}
							 echo "<tr class=\"$klsBaris\">";
							 echo "<td align='center'>".$c."</td>";
							 echo "<td align='center'>".$rek['kd_barang']."</td>";
							 echo "<td align='left'>".$rek['nm_barang']."</td>";
							 echo "<td align='center'>".$rek['nm_satuan']."</td>";
							 echo "<td align='center'>".$rek['nm_kategori']."</td>";
							 echo "<td align='center'>".number_format($rek['hrg_jual'],0,",",".")."</td>";
							 echo "<td align='center'>".number_format($rek['hrg_beli'],0,",",".")."</td>";
							 echo "<td align='center'>".$stat."</td>";
							
							 echo "<td align='center'><button class=\"btn btn-warning btn-xs btnBarangUbah\" data-val=\"$rek[kd_barang]\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Edit Data\"><span class=\"shortcut-icon icon-pencil\"></span></button></td>";
							 
							 echo "<td align='center'><button class=\"btn btn-danger btn-xs btnBarangHapus\" data-val=\"$rek[kd_barang]\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Hapus Data\" ><span class=\"shortcut-icon icon-remove\"></span></button></td>";
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
				</ul>
				</nav>

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


<script>
	// $('li:disabled').prop('disabled',true);
	
	
</script>