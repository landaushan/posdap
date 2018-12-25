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

if(isset($_POST['addUser'])){
	# BACA DATA DALAM FORM, masukkan datake variabel
	//data:{addUser:'',kdUser:kdUser,nmLengkap:namaLengkap,userName:userName,pwrd:password,level:level,active:active},
	
	$kd_user=secure(trim($_POST['kdUser']));	
	$nm_lengkap=ucwords(secure(trim($_POST['nmLengkap'])));
	$nm_user=strtolower(secure(trim($_POST['userName'])));
	$password=secure(trim($_POST['pwrd']));
	$level=secure(trim($_POST['level']));
	$active=secure(trim($_POST['active']));
	
	//$errMsg = $nm_lengkap;
		
	# VALIDASI FORM, jika ada kotak yang kosong, buat pesan error ke dalam kotak $pesanError
	$pesanError = array();
	if (trim($nm_lengkap)=="") {
		$pesanError[] = "Data <b>Nama Lengkap</b> Belum Diisi !";		
	}
	if (trim($nm_user)=="") {
		$pesanError[] = "Data <b>Username</b>  Belum Diisi !";		
	}
	if (strlen($nm_user)<8) {
		$pesanError[] = "Data <b>Username</b> Kurang dari 8 huruf !";		
	}
	if (strlen($nm_user)>15) {
		$pesanError[] = "Data <b>Username</b> Lebih dari 15 huruf !";		
	}
	if (trim($password)=="") {
		$pesanError[] = "Data <b>Password</b> tidak boleh kosong !";		
	}
	if (strlen($password)<8) {
		$pesanError[] = "Data <b>Password</b> Kurang dari 8 huruf !";		
	}
	if (strlen($password)>15) {
		$pesanError[] = "Data <b>Password</b> Lebih dari 15 huruf !";		
	}
	if (trim($level)=="") {
		$pesanError[] = "Data <b>Level Akses</b> tidak boleh kosong !";		
	}
	if (trim($active)=="") {
		$pesanError[] = "Data <b>Active</b> tidak boleh kosong !";		
	}
	# MENAMPILKAN PESAN JIKA ADA ERROR DARI VALIDASI
	if (count($pesanError)>=1 ){
		$errMsg .="<div class=\"alert alert-danger alert-dismissible\" role=\"alert\">";
		$errMsg .="<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>";
			$noPesan=0;
			foreach ($pesanError as $indeks=>$pesan_tampil) { 
			$noPesan++;
				$errMsg.= "&nbsp;&nbsp; $noPesan. $pesan_tampil<br>";	
			} 
		$errMsg .="</div>"; 
		
	}else{
		# SIMPAN DATA KE DATABASE. 
		// Jika tidak menemukan error, simpan data ke database
		$kodeBaru	= buatKode("ma_user", "UID");
		$txtPassword2 = MD5($password);
		
		//Periksa apakah nM user sudah ada atau belum ?
		$qri ="SELECT * FROM ma_user WHERE nm_user='$nm_user'";
		$res = querydb($qri);
		$row = numrows($res);
		
		if($row<1){
			//nama user belum ada -> insert
			$sql  = "INSERT INTO ma_user (id_user, nm_lengkap, nm_user, password,akses,active)
					VALUES ('$kodeBaru','$nm_lengkap' ,'$nm_user','$txtPassword2','$level','$active')";
			$res = querydb($sql);
			if($res){
				$errMsg .="<div class=\"alert alert-success alert-dismissible\" role=\"alert\">";
				$errMsg .= "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>";
				$errMsg .= "SUKSES !!! Data User sudah disimpan !!!";
				$errMsg .= "</div>";
				
			}else{
				$errMsg .="<div class=\"alert alert-danger alert-dismissible\" role=\"alert\">";
				$errMsg .= "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>";
				$errMsg .= "GAGAL !!! Data User tidak bisa disimpan !!!";
				$errMsg .= "</div>";
				
			}
		}else{

			$errMsg .= "<div class=\"alert alert-warning alert-dismissible\" role=\"alert\">";
			$errMsg .= "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>";
			$errMsg .= "User dengan nama <b>$nm_user</b> sudah ada dalam database, gunakan nama yang lain !!!";
			$errMsg .= "</div>"; 
		}
		
	}		
	
	//convert data menjadi json format
	$data = array('msg1'=>$errMsg,'msg2'=>'');
	echo json_encode($data);
}	


IF(isset($_POST['ubahUser'])){
	# BACA DATA DALAM FORM, masukkan datake variabel.
	//data:{ubahUser:'',kdUser:kdUser,nmLengkap:namaLengkap,userName:userName,pwrd:password,level:level,active:active},
	
	$kodeUser = trim($_POST['kdUser']);
	$inpNamaLengkap = ucwords(secure(trim($_POST['nmLengkap'])));
	$inpNamaUser = strtolower(secure(trim($_POST['userName'])));
	$inpPassword = secure(trim($_POST['pwrd']));
	$inpLevel    = secure(trim($_POST['level']));
	$inpActive   = secure(trim($_POST['active']));


	# VALIDASI FORM, jika ada kotak yang kosong, buat pesan error ke dalam kotak $pesanError
	$pesanError = array();
	if (trim($inpNamaLengkap)=="") {
		$pesanError[] = "Data <b>Nama Lengkap</b> Belum Diisi !";		
	}
	if (trim($inpNamaUser)=="") {
		$pesanError[] = "Data <b>Nama User</b> Belum Diisi !";		
	}
	if (strlen($inpNamaUser)<8) {
		$pesanError[] = "Data <b>Username</b> kurang dari 8 huruf !";		
	}
	if (strlen($inpNamaUser)>15) {
		$pesanError[] = "Data <b>Username</b> lebih dari 15 huruf !";		
	}
	if (trim($inpPassword)=="") {
		$pesanError[] = "Data <b>Password</b> tidak boleh kosong !";		
	}
	if (strlen($inpPassword)<8) {
		$pesanError[] = "Data <b>Password</b> kurang dari 8 huruf !";		
	}
	if (strlen($inpPassword)>15) {
		$pesanError[] = "Data <b>Password</b> lebih dari 15 huruf !";		
	}
	if (trim($inpLevel)=="") {
		$pesanError[] = "Data <b>Level Akses</b> tidak boleh kosong !";		
	}
	if (trim($inpActive)=="") {
		$pesanError[] = "Data <b>Active</b> tidak boleh kosong !";		
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
		$txtPassword2 = MD5($inpPassword);
		
		$qry="UPDATE ma_user SET nm_lengkap='$inpNamaLengkap',nm_user='$inpNamaUser',password='$txtPassword2' ,akses='$inpLevel',active='$inpActive'
			 WHERE id_user='$kodeUser'";
		$hsl = querydb($qry);
		if($hsl){
			
				$errMsg .="<div class=\"alert alert-success alert-dismissible\" role=\"alert\">";
				$errMsg .= "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>";
				$errMsg .= "SUKSES !!! Data User sudah diubah !!!";
				$errMsg .= "</div>";		
		}else{
				$errMsg .="<div class=\"alert alert-danger alert-dismissible\" role=\"alert\">";
				$errMsg .= "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>";
				$errMsg .= "GAGAL !!! Data User tidak bisa diubah !!!";
				$errMsg .= "</div>";
		}	
	}
	
	//$errMsg = $inpNamaLengkap;
	//convert data menjadi json format
	$data = array('msg1'=>$errMsg,'msg2'=>'');
	echo json_encode($data);
}

	
//data:{hapusUser;'';kodeRow:kdRow},

if(isset($_POST['hapusUser'])){
	
	$kode=$_POST['kodeRow'];
	$qri="DELETE FROM ma_user WHERE id_user='".$kode."'";	
	$res=querydb($qri);
	if($res){
		$errMsg .="<div class=\"alert alert-success alert-dismissible\" role=\"alert\">";
		$errMsg .= "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>";
		$errMsg .= "SUKSES !!! Data User sudah dihapus!!!";
		$errMsg .= "</div>";
	}else{
		$errMsg .="<div class=\"alert alert-danger alert-dismissible\" role=\"alert\">";
		$errMsg .= "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>";
		$errMsg .= "GAGAL !!! Data User tidak bisa dihapus !!!";
		$errMsg .= "</div>";
	}
	
	//$errMsg = "file user_proses.php";
	//convert data menjadi json format
	$data = array('msg1'=>$errMsg,'msg2'=>'');
	echo json_encode($data);
	
}	
	
?>

