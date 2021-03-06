<?php
if(session_status()!==2)session_start();//>=php 5.4
if(!isset($_SESSION['SES_LOGIN'])){
	header('location:../home');
 }
	$user_id=$_SESSION['SES_LOGIN'];

	$tgl = date("d-m-Y");

	//hitung total penjualan saat ini	
	$ttlJual = ttlJual($user_id);
	$_SESSION['ttlJualSesi'] = $ttlJual;

	
	//buat no faktur
	$thn = date("y");
	$bln = date("m");
	$hri = date("d");

	$qri = "SELECT MAX(no_faktur) AS no_faktur FROM penjualan";
	$hsl = querydb($qri);
	$rek = arraydb($hsl);
		$noFaktur1 = substr($rek['no_faktur'],6);
		$noFaktur2 = $noFaktur1 + 1;
		if(strlen($noFaktur2)<5){
			$noFaktur3 = sprintf("%05s",$noFaktur2);
		}
		$noFaktur4 = $thn.$bln.$hri.$noFaktur3;	
		
	//hitung kembalian	
	if(isset($_POST['cash'])){
		$cash=$_POST['cash'];
		if($cash>=1){
			$kembali=($cash-$ttlJual);
		}else{
			$kembali=0;
		}
	}
	else{
		$kembali=0;
	}

	// Voucher
	$disc = false;
	$voucherStatus = "t";
	if(isset($_POST['btnDiscount'])){
		$code_voucher = $_POST['code'];
		$qri = "SELECT * FROM voucher WHERE code = '$code_voucher'";
		$hsl = querydb($qri);
		if(numrows($hsl) > 0){
			$disc = $ttlJual * 0.2;
			$_SESSION['disc'] = $disc;
			$ttlJual -= $disc;
			$voucherStatus = "y";
		}else {
			echo "<script>alert('Code voucher tidak ada!')</script>";
		}
	}

	//cari data user
	$qri2 = "SELECT * FROM ma_user WHERE id_user='$user_id'";
	$hsl2 = querydb($qri2);
	$rek2 = arraydb($hsl2);
		$namaLengkap = $rek2['nm_lengkap'];
		$username    = $rek2['nm_user'];
		$akses		=  $rek2['akses'];

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
              <h3>Form Penjualan</h3>
              
            </div>
            <!-- /widget-header -->
            <div class="widget-content">
              <div class="shortcuts"> 
              	<div class="table-responsive">

				<table class="table table-condensed" id="tblKasir">
					<tr>
						<td><h3>TOTAL</h3></td>
						<td align="right"><h3>Rp</h3></td>
						<td align="right"><h3><?php echo number_format($ttlJual,0,",",".")?></h3></td>
					</tr>
					<tr>
						<td><h3>DISCOUNT</h3></td>
						<td align="right"><h3>Rp</h3></td>
						<td align="right"><h3><?php echo number_format($disc,0,",",".")?></h3></td>
					</tr>
					<!-- <tr>
						<td><h3>KEMBALI</h3></td>
						<td align="right"><h3>Rp</h3></td>
						<td align="right"><h3><?php //echo number_format($kembali,0,",",".")?></h3></td>
					</tr> -->
				</table>
				</div>
				&nbsp;
				<!-- <form name="formKembali" id="formKembali" action="" method="POST">
				<input type="text" placeholder="cash" name="cash" id="cash">&nbsp;<input type="submit" name="btnKembali" id="btnKembali" class="btn btn-xs btn-info" value="hitung">
				</form> -->

				<form id="formDiscount" action="" method="POST">
				<input type="text" placeholder="voucher code" name="code" id="code">&nbsp;<input type="submit" name="btnDiscount" id="btnDiscount" class="btn btn-xs btn-info" value="discount">
				</form>


				<div class="panel panel-primary alert-info" id="panelPenjualan1">
			<div class="panel-body">
				<form class="form-horizontal" name="formNoFaktur">
					<p>Kode Barang&nbsp;&nbsp;&nbsp;: <input type="text" name="inpKodeBarang" id="inpKodeBarang" data-toggle="tooltip" data-placement="top" title="Tekan ENTER setelah mengisi kode barang" autofocus></p>
					<p>Nomor Faktur&nbsp;&nbsp;: <input type="text" value="<?php echo $noFaktur4?>" name="inpNoFaktur" id="inpNoFaktur" readonly="readonly"></p>
					<p>Voucher&nbsp;&nbsp;: <input type="text" value="<?php echo $voucherStatus;; ?>" name="voucherStatus" id="voucherStatus" readonly="readonly"></p>
					<p>Total Belanja&nbsp;&nbsp;&nbsp;: <input type="text" value="<?php echo number_format($ttlJual,0,",",".")?>" readonly="readonly"></p>
					<input type="button" value="Cetak Faktur" id="btnCetakFaktur" class="btn btn-xs btn-info" onclick="popup()">&nbsp;&nbsp;<input type="button" value="Selesai" name="btnJualSimpan" id="btnJualSimpan" class="btn btn-xs btn-primary">
				</form>
			</div>
		</div><!-- /panel -->


		<div class="table-responsive">
				<table class="table table-bordered table-condensed table-hover" style="background:#fff;" id="tblPembelian">
						<tr>
							<th>Kode Barang</th>
							<th>Nama Barang</th>
							<th>Harga<br>(Rp)</th>
							<th>Jumlah<br>(Item)</th>
							<th>Sub Total<br>(Rp)</th>
							<th></th>
						</tr>
						<?php 
							$ttlItem=0;$ttlJual=0;
							$qri="SELECT a.*,b.nm_barang FROM penjualan_tmp a LEFT JOIN ma_barang b ON b.kd_barang=a.kd_barang WHERE a.user='$user_id'";
							$hsl=querydb($qri);
							while($rek=arraydb($hsl)){
								echo "<tr>";
								echo "<td>".$rek['kd_barang']."</td>";
								echo "<td>".$rek['nm_barang']."</td>";
								echo "<td align='center'>".number_format($rek['harga'],0,",",".")."</td>";
								echo "<td align='center'>".$rek['jumlah']."</td>";
								echo "<td align='right'>".number_format($rek['sub_total'],0,",",".")."</td>";
								echo "<td align='center'><button class=\"btn btn-danger btn-xs btnHapusJual\" data-val=\"$rek[id]\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Hapus Data\" ><span class=\"shortcut-icon icon-remove\"></span></button></td>";
								echo "</tr>";
								$ttlItem = $ttlItem + $rek['jumlah'];
								$ttlJual = $ttlJual + $rek['sub_total'];
							}
						?>
						<tr>
							<td colspan='3' align='center'><b>Total</b></td>
							<td align='center'><b><?php echo number_format($ttlItem,0,",",".")?></b></td>
							<td align='right'><b><?php echo number_format($ttlJual,0,",",".")?></b></td>
							<td></td>
						</tr>
				</table>

				<table class="table table-condensed" id="tblKasir">
					<tr>
						<td>ID User</td>
						<td>:</td>
						<td align="left"><?php echo $user_id?></td>
					</tr>
					<tr>
						<td>Nama User</td>
						<td>:</td>
						<td><?php echo $username?></td>
					</tr>
					<tr>
						<td>Tanggal Akses</td>
						<td>:</td>
						<td><?php echo $tgl?></td>
					</tr>
					<tr>
						<td>Hak Akses</td>
						<td>:</td>
						<td><?php echo $akses?></td>
					</tr>
				</table>
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

<script type="text/javascript">
var mywin; 
function popup(){
mywin=window.open("kasir/faktur_penjualan.php?no_faktur=<?php echo $noFaktur4; ?>&cash=<?php echo $cash; ?>","_blank",	"toolbar=yes,location=yes,menubar=yes,copyhistory=yes,directories=no,status=no,resizable=no,width=500, height=400"); mywin.moveTo(100,100);}
</script>
