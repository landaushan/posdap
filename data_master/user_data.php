<?php
if(session_status()!==2)session_start();//>=php 5.4
if(!isset($_SESSION['SES_LOGIN'])){
	header('location:../home');
 }
 
	//Menentukan batas, cek halaman dan posisi data
		$batas= 10;//Jumlah tampilan record per halaman minimum
		if(isset($_GET['halaman']))$halaman = $_GET['halaman'];
		if (empty($halaman)){$posisi=0; $halaman=1;} else {$posisi=($halaman-1) * $batas;} 
		
		$qry2 ="SELECT * FROM ma_user";
		$hsl2 = querydb($qry2);
		$jml_data = numrows($hsl2);
		$jml_hal = ceil($jml_data/$batas);
		if ($jml_hal>20) {$jml_hal=20 AND $batas=ceil($jml_data/$jml_hal);$posisi=($halaman-1) * $batas;}
		$file="page.php?open=data_master/user_data.php";
		//$file="page.php?open=user_data";
?>

<div class="main">  
  <div class="main-inner">
    <div class="container">
    	<span id="dataTambahUbah"></span>

    		<div class="row">
        <div class="span12">
          <div class="widget">
            <div class="widget-header"> <i class="icon-copy"></i>
              <h3>Data User</h3>
              <button class="btn btn-info btn-sm" id="btnUserTambah">Tambah Data</button>
            </div>
            <!-- /widget-header -->
            <div class="widget-content">
              <div class="shortcuts"> 

				<div class="clearfix"></div>
				<p></p>
				<div class="table-responsive">
					<table class="table table-striped table-bordered  table-condensed ">
						<tr>
							<th>Kode User</th>
							<th>Nama Lengkap</th>
							<th>Username</th>
							<th>Level Akses</th>
							<th>Status</th>
							<th colspan="2" align="center">Pilihan</th>
						</tr>
						<?php
							$qri = "SELECT * FROM ma_user LIMIT $posisi, $batas";
							$hsl = querydb($qri);
							while($rek = arraydb($hsl)){
								if($rek['active']=="Y"){$klsBaris="";$stat="<span class='label label-info'>Active</span>";}else{$klsBaris="danger";$stat="<span class='label label-danger'>Non Active</span>";}
							 echo "<tr class=\"$klsBaris\">";
							 echo "<td align='center'>".$rek['id_user']."</td>";
							 echo "<td align='left'>".$rek['nm_lengkap']."</td>";
							 echo "<td align='left'>".$rek['nm_user']."</td>";
							 echo "<td align='center'>".$rek['akses']."</td>";
							 echo "<td align='center'>".$stat."</td>";
							
							 echo "<td align='center'><button class=\"btn btn-xs btn-warning btnUserUbah\" data-val='$rek[id_user]' data-toggle=\"tooltip\" data-placement=\"top\" title=\"Edit Data\"><span class=\"shortcut-icon icon-pencil\"></span></button></td>";
							 echo "<td align='center'><button class=\"btn btn-xs btn-danger btnUserHapus\" data-val='$rek[id_user]' data-toggle=\"tooltip\" data-placement=\"top\" title=\"Hapus Data\" ><span class=\"shortcut-icon icon-remove\"></span></button></td>";
							 echo "<tr>";
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