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

//data:{addSatuan:'',dtaKode:kode,dtaNama:nama,dtaActive:active},
if(isset($_POST['addSatuan'])){
	# BACA DATA DALAM FORM, masukkan datake variabel
	$inpKode=secure(trim($_POST['dtaKode']));	
	$inpNama=strtoupper(secure(trim($_POST['dtaNama'])));
	$inpActive=secure(trim($_POST['dtaActive']));
		
	# VALIDASI FORM, jika ada kotak yang kosong, buat pesan error ke dalam kotak $pesanError
	$pesanError = array();
	
	if (trim($inpNama)=="") {
		$pesanError[] = "Data <b>Nama Satuan</b> Belum Diisi !";		
	}
	
	# MENAMPILKAN PESAN JIKA ADA ERROR DARI VALIDASI
	if (count($pesanError)>=1 ){
		$errMsg .= "<div class=\"alert alert-danger alert-dismissible\" role=\"alert\">";
		$errMsg .= "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>";
			$noPesan=0;
			foreach ($pesanError as $indeks=>$pesan_tampil) { 
			$noPesan++;
				$errMsg .= "&nbsp;&nbsp; $noPesan. $pesan_tampil<br>";	
			} 
		$errMsg .= "</div>"; 
	}else{
		# SIMPAN DATA KE DATABASE. 
		// Jika tidak menemukan error, simpan data ke database
		$kodeBaru	= buatKode("ma_satuan_barang", "S");
		//$txtPassword2 = MD5($password);
		//$kodeBaru	= $inpKode;
		
		//Periksa apakah nM barang sudah ada atau belum ?
		$qri ="SELECT * FROM ma_satuan_barang WHERE nm_satuan='$inpNama'";
		$res = querydb($qri);
		$row = numrows($res);
		
		if($row<1){
			//nama barang belum ada -> insert
			$sql="INSERT INTO ma_satuan_barang (kd_satuan, nm_satuan,active)
					VALUES ('$kodeBaru', '$inpNama','$inpActive')";
			$res = querydb($sql);
			if($res){
				$errMsg .= "<div class=\"alert alert-success alert-dismissible\" role=\"alert\">";
				$errMsg .= "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>";
				$errMsg .= "SUKSES !!! Data sudah disimpan !!!";
				$errMsg .= "</div>";
				
				
			}else{
				$errMsg .= "<div class=\"alert alert-danger alert-dismissible\" role=\"alert\">";
				$errMsg .= "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>";
				$errMsg .= "GAGAL !!! Data tidak bisa disimpan !!!";
				$errMsg .= "</div>";
				
			}
		}else{

			$errMsg .= "<div class=\"alert alert-danger alert-dismissible\" role=\"alert\">";
			$errMsg .= "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>";
			$errMsg .= "Data dengan nama <b>$inpNama</b> sudah ada dalam database, gunakan nama yang lain !!!";
			$errMsg .= "</div>"; 
		}
		
	}		
	//convert data menjadi json format
	$data = array('msg1'=>$errMsg,'msg2'=>'');
	echo json_encode($data);	
}	


IF(isset($_POST['ubahSatuan'])){
	# BACA DATA DALAM FORM, masukkan datake variabel
	$inpKode = ucwords(secure(trim($_POST['dtaKode'])));
	$inpNama = strtoupper(secure(trim($_POST['dtaNama'])));
	$inpActive   = secure(trim($_POST['dtaActive']));
	
	# VALIDASI FORM, jika ada kotak yang kosong, buat pesan error ke dalam kotak $pesanError
	$pesanError = array();
	if (trim($inpNama)=="") {
		$pesanError[] = "Data <b>Nama Satuan</b> Belum Diisi !";		
	}
	
	# MENAMPILKAN PESAN JIKA ADA ERROR DARI VALIDASI
	if (count($pesanError)>=1 ){
		$errMsg .= "<div class=\"alert alert-danger alert-dismissible\" role=\"alert\">";
		$errMsg .= "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>";
			$noPesan=0;
			foreach ($pesanError as $indeks=>$pesan_tampil) { 
			$noPesan++;
				$errMsg .= "&nbsp;&nbsp; $noPesan. $pesan_tampil<br>";	
			} 
		$errMsg .= "</div>"; 
	}else{	
		# SIMPAN DATA KE DATABASE. 
		// Jika tidak menemukan error, simpan data ke database
		//$kodeBaru	= buatKode("ma_kategori_barang", "K");
		//$txtPassword2 = MD5($inpPassword);
		
		$qry="UPDATE ma_satuan_barang SET nm_satuan='$inpNama',active='$inpActive'
			 WHERE kd_satuan='$inpKode'";
		$hsl = querydb($qry);
		if($hsl){
			
				$errMsg .= "<div class=\"alert alert-success alert-dismissible\" role=\"alert\">";
				$errMsg .= "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>";
				$errMsg .= "SUKSES !!! Data sudah diubah !!!";
				$errMsg .= "</div>";
		}
		else{
				
				$errMsg .= "<div class=\"alert alert-danger alert-dismissible\" role=\"alert\">";
				$errMsg .= "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>";
				$errMsg .= "GAGAL !!! Data tidak bisa diubah !!!";
				$errMsg .= "</div>";	
		}	
	}
	//convert data menjadi json format
	$data = array('msg1'=>$errMsg,'msg2'=>'');
	echo json_encode($data);	
}

if(isset($_POST['hapusSatuan'])){
	
	$kode=$_POST['kodeRow'];
	$qri="DELETE FROM ma_satuan_barang WHERE kd_satuan='".$kode."'";	
	$res=querydb($qri);
	if($res){
				$errMsg .= "<div class=\"alert alert-success alert-dismissible\" role=\"alert\">";
				$errMsg .= "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>";
				$errMsg .= "SUKSES !!! Data sudah dihapus !!!";
				$errMsg .= "</div>";
	}else{
		
				$errMsg .= "<div class=\"alert alert-danger alert-dismissible\" role=\"alert\">";
				$errMsg .= "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>";
				$errMsg .= "GAGAL !!! Data gagal dihapus !!!";
				$errMsg .= "</div>";
		
	}	
	//convert data menjadi json format
	$data = array('msg1'=>$errMsg,'msg2'=>'');
	echo json_encode($data);	
}	
?>
