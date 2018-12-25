<?php
error_reporting(0);
if(session_status()!==2)session_start();//>=php 5.4
if(!isset($_SESSION['SES_LOGIN'])){
	header('location:../home');
 }
require_once "../library/inc.connection.php";
require_once "../library/inc.library.php";
$user_id=$_SESSION['SES_LOGIN'];
opendb();




//data:{lapJual:'',tglAwal:tglAwal,blnAwal:blnAwal,thnAwal:thnAwal,tglAkhir:tglAkhir,blnAkhir:blnAkhir,thnAkhir:thnAkhir},






#Lap. stock barang
if(isset($_POST['cariStock'])){

	$tgl = date("d-m-Y");
	$kategori = trim($_POST['kategori']);
	$jumlStock = trim($_POST['jumlStcok']);

	if($kategori=="all"){$filtKategori="";}else{$filterKategori="AND b.kd_kategori='$kategori'";};
	if($jmlStock=="3"){$filtStock="";}elseif($jmlStock=="0"){$filtStock="AND jumlah='$jmlStock'";}elseif($jmlStock=="dibawah 50"){$filtStock="AND jumlah<50";};
	
	//cari data toko
	$qri = "SELECT * FROM ma_toko";
	$hsl = $mysqli->query($qri);
	$rek = $hsl->fetch_assoc();
		$namaToko = $rek['nm_toko'];
		$almtToko = $rek['almt_toko'];
		$kota = $rek['kota'];
		$telp = "Telp. : ".$rek['tlp_toko'];
		$fax = "Fax : ".$rek['fax_toko'];
		
		
	
	$tbl .= "<div class='col-md-3 col-md-offset-2'><span id='namaToko'>".$namaToko."</span><br>".$almtToko.", ".$kota."<br>".$telp."&nbsp;".$fax."</div>";
	$tbl .= "<div class='col-md-3'><span id='judulLaporan'>Laporan Stock Barang</span><br>Tanggal : ".$tgl."</div>";

	$tbl .= "<div class='table-responsive'>";	
	$tbl .= "<table class=\"table table-condensed table-bordered\">";
	$tbl .= "<tr>";
	$tbl .= "<th>No</th>";
	$tbl .= "<th>Kode Barang</th>";
	$tbl .= "<th>Nama Barang</th>";
	$tbl .= "<th>Satuan <br>Barang</th>";
	$tbl .= "<th>Jumlah <br>Stock</th>";
	$tbl .= "<th>Harga Jual</th>";
	$tbl .= "<th>Harga Beli <br>Rata-Rata</th>";
	$tbl .= "</tr>";
	
	$c=1;
	$qri = "SELECT a.*,b.*,c.nm_satuan FROM stock_barang a LEFT JOIN ma_barang b ON b.kd_barang=a.kd_barang LEFT JOIN ma_satuan_barang c ON c.kd_satuan=b.kd_satuan WHERE 1 $filterKategori $filtStock";
	$hsl = $mysqli->query($qri);
	while($rek=$hsl->fetch_assoc()){
										
		$tbl .= "<tr>";
		$tbl .= "<td align='center'>".$c."</td>";
		$tbl .= "<td>".$rek['kd_barang']."</td>";
		$tbl .= "<td>".$rek['nm_barang']."</td>";
		$tbl .= "<td>".$rek['nm_satuan']."</td>";
		$tbl .= "<td align=\"center\">".number_format($rek['jumlah'],0,",",".")."</td>";
		$tbl .= "<td align=\"center\">".number_format($rek['hrg_jual'],0,",",".")."</td>";
		$tbl .= "<td align=\"center\">".number_format($rek['hrg_beli_rata2'],0,",",".")."</td>";
		$tbl .= "</tr>";
		$c++;
	}
	
	$tbl .= "";
	$tbl .= "</table>";
	$tbl .= "</div><br>";
	
	//convert data menjadi json format
	$data = array('msg1'=>$tbl,'msg2'=>'');
	echo json_encode($data);
	

}	




?>
