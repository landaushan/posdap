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

if(isset($_POST['addSupplier'])){
	$inpKode=secure(trim($_POST['dtaKode']));	
	$inpNama=strtoupper(secure(trim($_POST['dtaNama'])));
	$inpAlamat=ucwords(secure(trim($_POST['dtaAlamat'])));
	$inpTelp=secure(trim($_POST['dtaTelp']));
	$inpFax=secure(trim($_POST['dtaFax']));
	$inpKontak=ucwords(secure(trim($_POST['dtaKontak'])));
	$inpActive=trim($_POST['dtaActive']);
	
	# VALIDASI FORM, jika ada kotak yang kosong, buat pesan error ke dalam kotak $pesanError
	$pesanError = array();
	
	if (trim($inpNama)=="") {
		$pesanError[] = "Data <b>Nama Supplier</b> Belum Diisi !";		
	}
	if (trim($inpAlamat)=="") {
		$pesanError[] = "Data <b>Alamat Supplier</b> Belum Diisi !";		
	}
	if (trim($inpTelp)=="") {
		$pesanError[] = "Data <b>Nomor Telp</b> Belum Diisi !";		
	}
	if (trim($inpKontak)=="") {
		$pesanError[] = "Data <b>Nama Kontak Fax</b> Belum Diisi !";		
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
		$kodeBaru	= buatKode("ma_supplier", "SUP");
		//$txtPassword2 = MD5($password);
		//$kodeBaru	= $inpKode;
		
		//Periksa apakah nM barang sudah ada atau belum ?
		$qri ="SELECT * FROM ma_supplier WHERE nm_supplier='$inpNama'";
		$res = querydb($qri);
		$row = numrows($res);
		
		if($row<1){
			//nama belum ada -> insert
			$sql="INSERT INTO ma_supplier (kd_supplier, nm_supplier,almt_supplier,tlp_supplier,fax_supplier,atas_nama,active)
					VALUES ('$kodeBaru', '$inpNama','$inpAlamat','$inpTelp','$inpFax','$inpKontak','$inpActive')";
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

			$errMsg .= "<div class=\"alert alert-warning alert-dismissible\" role=\"alert\">";
			$errMsg .= "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>";
			$errMsg .= "Data dengan nama <b>$inpNama</b> sudah ada dalam database, gunakan nama yang lain !!!";
			$errMsg .= "</div>"; 
		}
		
	}	
	
	//$errMsg = $inpKode;
	//convert data menjadi json format
	$data = array('msg1'=>$errMsg,'msg2'=>'');
	echo json_encode($data);
	
}	

//data:{ubahSupplier:'',dtaKode:kode,dtaNama:nama,dtaAlamat:alamat,dtaTelp:telp,dtaFax:fax,dtaKontak:kontak,dtaActive:active},
if(isset($_POST['ubahSupplier'])){
	
	$inpKode=secure(trim($_POST['dtaKode']));	
	$inpNama=strtoupper(secure(trim($_POST['dtaNama'])));
	$inpAlamat=ucwords(secure(trim($_POST['dtaAlamat'])));
	$inpTelp=secure(trim($_POST['dtaTelp']));
	$inpFax=secure(trim($_POST['dtaFax']));
	$inpKontak=ucwords(secure(trim($_POST['dtaKontak'])));
	$inpActive=trim($_POST['dtaActive']);
	
	# VALIDASI FORM, jika ada kotak yang kosong, buat pesan error ke dalam kotak $pesanError
	$pesanError = array();
	
	if (trim($inpNama)=="") {
		$pesanError[] = "Data <b>Nama Supplier</b> Belum Diisi !";		
	}
	if (trim($inpAlamat)=="") {
		$pesanError[] = "Data <b>Alamat Supplier</b> Belum Diisi !";		
	}
	if (trim($inpTelp)=="") {
		$pesanError[] = "Data <b>Nomor Telp</b> Belum Diisi !";		
	}
	if (trim($inpFax)=="") {
		$pesanError[] = "Data <b>Nomor Fax</b> Belum Diisi !";		
	}
	
	# MENAMPILKAN PESAN JIKA ADA ERROR DARI VALIDASI
	if (count($pesanError)>=1 ){
		$errMsg .="<div class=\"alert alert-danger alert-dismissible\" role=\"alert\">";
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
		//$kodeBaru	= buatKode("ma_supplier", "SUP");
		//$txtPassword2 = MD5($password);
		//$kodeBaru	= $inpKode;
		
		
		
		
			$sql="UPDATE ma_supplier SET nm_supplier='$inpNama',almt_supplier='$inpAlamat',tlp_supplier='$inpTelp',fax_supplier='$inpFax',atas_nama='$inpKontak',active='$inpActive' 
				  WHERE kd_supplier='$inpKode'";
			$res = querydb($sql);
			if($res){
				$errMsg .= "<div class=\"alert alert-success alert-dismissible\" role=\"alert\">";
				$errMsg .= "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>";
				$errMsg .= "SUKSES !!! Data sudah diubah !!!";
				$errMsg .= "</div>";			
			}else{
				$errMsg .= "<div class=\"alert alert-danger alert-dismissible\" role=\"alert\">";
				$errMsg .= "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>";
				$errMsg .= "GAGAL !!! Data gagal diubah !!!";
				$errMsg .= "</div>";
				
			}
		
	}	
	//$errMsg = $inpKode;	
	//convert data menjadi json format
	$data = array('msg1'=>$errMsg,'msg2'=>'');
	echo json_encode($data);
}	

if(isset($_POST['hapusSupplier'])){
	
	$kode=$_POST['kodeRow'];
	
	$qri="DELETE FROM ma_supplier WHERE kd_supplier='".$kode."'";	
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
