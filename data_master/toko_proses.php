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

//if(isset($_POST['btnTokoUbahSimpan'])){
	$kd_toko=secure(trim($_POST['kodeToko']));	
	$nm_toko=secure(trim($_POST['txtNama']));
	$alamat=secure(trim($_POST['txtAlamat']));
	$kota=ucwords(secure(trim($_POST['txtKota'])));
	$telepon=secure(trim($_POST['txtPhone']));
	$fax=secure(trim($_POST['txtFax']));
	$logo = secure(trim($_FILES['file_logo']['name']));
	$errMsg="";
	
	$pesanError = array();
	
	if(!empty($logo)){
		//$error=false;
		$folder="../img/";
		$file_type=array('jpg','jpeg','png','gif');
		$max_size=3000000;
		$file_name=$_FILES['file_logo']['name'];
		$file_size=$_FILES['file_logo']['size'];
		$explode=explode('.',$file_name);
		$extensi=$explode[count($explode)-1];
		if(!in_array($extensi,$file_type)){
		//$error=true;
		$pesanError[] ="Type file tidak sesuai";}
		if($file_size>$max_size){
		//$error=true;
		$pesanError[] ="Ukuran file melebihi maximum";}
		
		//$inpLogo=",logo='$logo'";
	
	}
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
			
			$temp1=$_FILES['file_logo']['tmp_name'];
			$name1=$_FILES['file_logo']['name'];
			$name1=stripslashes($name1);
			$name1=str_replace("'","",$name1);
			move_uploaded_file($temp1,"../img/".$name1);
			
			##### resize the image #####
			function getExtension($str) {
			 $i = strrpos($str,".");
			 if (!$i) { return ""; }
			 $l = strlen($str) - $i;
			 $ext = substr($str,$i+1,$l);
			 return $ext;
			}
			function resizePng($im, $dst_width, $dst_height) {
				$width = imagesx($im);
				$height = imagesy($im);
				$dst_width= ($width/$height)*$dst_height;
				
				$newImg = imagecreatetruecolor($dst_width, $dst_height);

				imagealphablending($newImg, false);
				imagesavealpha($newImg, true);
				$transparent = imagecolorallocatealpha($newImg, 255, 255, 255, 127);
				imagefilledrectangle($newImg, 0, 0, $width, $height, $transparent);
				imagecopyresampled($newImg, $im, 0, 0, 0, 0, $dst_width, $dst_height, $width, $height);

				return $newImg;
			}
	
			if(!empty($logo))
			{	
				$filename = "../img/".$logo;
				$ext = getExtension($filename);
				if($ext=="jpg" || $ext=="jpeg" ){$src = imagecreatefromjpeg($filename);}else if($ext=="png"){$src = $filename;}
				else {$src = imagecreatefromgif($filename);}
				list($width, $height) = getimagesize($filename);
				$new_height = 40;
				$new_width = ($width/$height) * $new_height;
				// Resample
				$imageNew = imagecreatetruecolor($new_width, $new_height);
				imagecopyresampled($imageNew, $src, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

				// Output
				$newFileName = $logo;
				if($ext=="jpg" || $ext=="jpeg"){imagejpeg($imageNew, '../img/'.$newFileName, 100);}
				elseif($ext=="png"){$newImg = resizePng($filename,0,40);}
				elseif($ext=="gif"){imagegif($imageNew, '../img/'.$newFileName);}
				else{imagewbmp($imageNew, '../img/'.$newFileName);}
				//clear memory
				imagedestroy($src);
				imagedestroy($imageNew); 
		
			}
			#######################################
			if(!empty($logo)){$inpLogo=",logo='$newFileName'";}else{$inpLogo="";}
			
			##### save the image name in database #####
			$qry="UPDATE ma_toko SET nm_toko='$nm_toko',almt_toko='$alamat',kota='$kota',tlp_toko='$telepon',fax_toko='$fax' $inpLogo WHERE kd_toko='$kd_toko'";
			$hsl = querydb($qry);
			
			if($hsl){
					$errMsg .= "<div class=\"alert alert-success alert-dismissible\" role=\"alert\">";
					$errMsg .= "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>";
					$errMsg .= "SUKSESS !!! Data sudah diubah !!!";
					$errMsg .= "</div>";
				
			}else{
					$errMsg .= "<div class=\"alert alert-danger alert-dismissible\" role=\"alert\">";
					$errMsg .= "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>";
					$errMsg .= "GAGAL !!! Data gagal diubah !!!";
					$errMsg .= "</div>";
			}
		
		}
	
	//echo $errMsg;
	//convert data menjadi json format
	$data = array('msg1'=>$errMsg,'msg2'=>'');
	echo json_encode($data);
//}
?>
