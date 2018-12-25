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


if(isset($_POST['addBarang'])){
	# BACA DATA DALAM FORM, masukkan datake variabel
	$inpKode=secure(trim($_POST['kdBarang']));	
	$inpNama=strtoupper(secure(trim($_POST['nmBarang'])));
	$inpSatuan=secure(trim($_POST['satuan']));
	$inpKategori=secure(trim($_POST['kategori']));
	$inpHrgJual=secure(trim($_POST['hrgJual']));
	$inpHrgBeli=secure(trim($_POST['hrgBeli']));
	$inpActive=secure(trim($_POST['active']));
		
	# VALIDASI FORM, jika ada kotak yang kosong, buat pesan error ke dalam kotak $pesanError
	$pesanError = array();
	if (trim($inpKode)=="") {
		$pesanError[] = "Data <b>Kode Barang</b> Belum Diisi !";		
	}
	if (trim($inpNama)=="") {
		$pesanError[] = "Data <b>Nama Barang</b> Belum Diisi !";		
	}
	if (trim($inpSatuan)=="") {
		$pesanError[] = "Data <b>Satuan Barang</b> tidak boleh kosong !";		
	}
	if (trim($inpKategori)=="") {
		$pesanError[] = "Data <b>Kategori Barang</b> tidak boleh kosong !";		
	}
	if (trim($inpHrgJual)=="") {
		$pesanError[] = "Data <b>Harga Jual</b> tidak boleh kosong !";		
	}
	if (trim($inpHrgBeli)=="") {
		$pesanError[] = "Data <b>Harga Beli</b> tidak boleh kosong !";		
	}
	# MENAMPILKAN PESAN JIKA ADA ERROR DARI VALIDASI
	if (count($pesanError)>=1 ){
		$errMsg .="<div class=\"alert alert-danger alert-dismissible\" role=\"alert\">";
		$errMsg .="<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>";
			$noPesan=0;
			foreach ($pesanError as $indeks=>$pesan_tampil) { 
			$noPesan++;
				$errMsg .="&nbsp;&nbsp; $noPesan. $pesan_tampil<br>";	
			} 
		$errMsg .="</div>"; 
	}else{
		# SIMPAN DATA KE DATABASE. 
		// Jika tidak menemukan error, simpan data ke database
		//$kodeBaru	= buatKode("ma_barang", "");
		//$txtPassword2 = MD5($password);
		$kodeBaru	= $inpKode;
		
		//Periksa apakah nM barang sudah ada atau belum ?
		$qri ="SELECT * FROM ma_barang WHERE nm_barang='$inpNama'";
		$res = querydb($qri);
		$row = numrows($res);
		
		if($row<1){
			//nama barang belum ada -> insert
			$sql  = "INSERT INTO ma_barang (kd_barang, nm_barang, kd_satuan,kd_kategori,hrg_jual,hrg_beli,active)
					VALUES ('$kodeBaru', '$inpNama','$inpSatuan','$inpKategori','$inpHrgJual','$inpHrgBeli','$inpActive')";
			$res = querydb($sql);
			if($res){
				
				$errMsg .= "<div class=\"alert alert-success alert-dismissible\" role=\"alert\">";
				$errMsg .= "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>";
				$errMsg .= "SUKSESS !!! Data sudah disimpan !!!";
				$errMsg .= "</div>";
				
			}else{
				$errMsg .= "<div class=\"alert alert-danger alert-dismissible\" role=\"alert\">";
				$errMsg .= "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>";
				$errMsg .= "GAGAL !!! Data tidak bisa disimpan !!!";
				$errMsg .= "</div>";
				
			}
		}else{

			$errMsg .= "<div class=\"alert alert-warning alert-dismissible\" role=\"alert\">";
			$errMsg .= "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>";
			$errMsg .= "Barang dengan nama <b>$inpNama</b> sudah ada dalam database, gunakan nama yang lain !!!";
			$errMsg .= "</div>"; 
		}
		
	}		
	//$errMsg = $inpNama;
	//convert data menjadi json format
	$data = array('msg1'=>$errMsg,'msg2'=>'');
	echo json_encode($data);
}	

IF(isset($_POST['ubahBarang'])){
	# BACA DATA DALAM FORM, masukkan datake variabel
	$inpKode = strtoupper(secure(trim($_POST['kdBarang'])));
	$inpNama = strtoupper(secure(trim($_POST['inpNamaBarang'])));
	$inpSatuan = secure(trim($_POST['inpSatuan']));
	$inpKategori= secure(trim($_POST['inpKategori']));
	$inpHrgJual= unformat(secure(trim($_POST['inpHrgJual'])));
	$inpHrgBeli= unformat(secure(trim($_POST['inpHrgBeli'])));
	$inpActive   = secure(trim($_POST['inpActive']));
	
	# VALIDASI FORM, jika ada kotak yang kosong, buat pesan error ke dalam kotak $pesanError
	$pesanError = array();
	if (trim($inpNama)=="") {
		$pesanError[] = "Data <b>Nama Barang</b> Belum Diisi !";		
	}
	
	if (trim($inpSatuan)=="") {
		$pesanError[] = "Data <b>Satuan Barang</b> tidak boleh kosong !";		
	}
	if (trim($inpKategori)=="") {
		$pesanError[] = "Data <b>Kategori</b> tidak boleh kosong !";		
	}
	if (trim($inpHrgJual)=="") {
		$pesanError[] = "Data <b>Harga Jual</b> belum diisi !";		
	}
	if (trim($inpHrgBeli)=="") {
		$pesanError[] = "Data <b>Harga Beli</b> tidak boleh kosong !";		
	}
	
	# MENAMPILKAN PESAN JIKA ADA ERROR DARI VALIDASI
	if (count($pesanError)>=1 ){
		$errMsg .="<div class=\"alert alert-danger alert-dismissible\" role=\"alert\">";
		$errMsg .="<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>";
			$noPesan=0;
			foreach ($pesanError as $indeks=>$pesan_tampil) { 
			$noPesan++;
				$errMsg .="&nbsp;&nbsp; $noPesan. $pesan_tampil<br>";	
			} 
		 $errMsg .="</div>"; 
	}else{	
		# SIMPAN DATA KE DATABASE. 
		// Jika tidak menemukan error, simpan data ke database
		//$kodeBaru	= buatKode("ma_user", "UID");
		//$txtPassword2 = MD5($inpPassword);
		
		$qry="UPDATE ma_barang SET nm_barang='$inpNama',kd_satuan='$inpSatuan',kd_kategori='$inpKategori',hrg_jual='$inpHrgJual',hrg_beli='$inpHrgBeli',active='$inpActive'
			 WHERE kd_barang='$inpKode'";
		$hsl = querydb($qry);
		if($hsl){
			
			
			$errMsg .= "<div class=\"alert alert-success alert-dismissible\" role=\"alert\">
						<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>
						SUKSES !!! Data Sudah Dirubah !
					</div>
				";
			
			//echo "<script>window.location.replace('page.php?open=data_master/barang_data.php');</script>";
			//header("location:./page.php");		
		}
		else{
				
			$errMsg .="
					<div class=\"alert alert-danger alert-dismissible\" role=\"alert\">
						<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>
						GAGAL !!! Data Tidak Bisa Dirubah, harap ulang input data!
					</div>
				";	
		}	
	}
	
	
	//convert data menjadi json format
	$data = array('msg1'=>$errMsg,'msg2'=>'');
	echo json_encode($data);
}	

if(isset($_POST['hapusBarang'])){
	
	$kode=$_POST['kodeRow'];
	
	$qri="DELETE FROM ma_barang WHERE kd_barang='".$kode."'";	
	$res=querydb($qri);
	if($res){
		$errMsg .="<div class=\"alert alert-success alert-dismissible\" role=\"alert\">";
		$errMsg .= "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>";
		$errMsg .= "SUKSES !!! Data sudah dihapus!!!";
		$errMsg .= "</div>";
	}else{
		$errMsg .="<div class=\"alert alert-danger alert-dismissible\" role=\"alert\">";
		$errMsg .= "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>";
		$errMsg .= "GAGAL !!! Data tidak bisa dihapus !!!";
		$errMsg .= "</div>";
	}
	
	//convert data menjadi json format
	$data = array('msg1'=>$errMsg,'msg2'=>'');
	echo json_encode($data);
	
}
?>
