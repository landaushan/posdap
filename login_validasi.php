<?php
require_once "library/inc.connection.php";
require_once "library/inc.library.php";
opendb();

if(isset($_POST['checkUser']))
{	
	
	$userName = secure(trim($_POST['uid']));
	$pwd=secure(trim($_POST['pwrd']));
	$pwd2 = md5($pwd);
	
		//$sql = "SELECT * FROM ma_user WHERE nm_user='$userName'";
		//$hsl = querydb($sql);
		//$rek = arraydb($hsl);
		//$row  = numrows($hsl);
		$stmt = $mysqli->prepare("SELECT id_user,nm_user,password,akses FROM ma_user WHERE nm_user=?");
		$stmt->bind_param('s',$userName);
		$stmt->execute();
		$stmt->store_result();
		$row = $stmt->num_rows;
		
		if($row<1)
		{

			echo "<div class=\"alert alert-danger alert-dismissible\" role=\"alert\">";
			echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>";
			echo "Nama user tidak ada !";
			echo "</div>";
					
		}
		else
		{
			$stmt->bind_result($uid,$name, $pw,$akses);
			$rek = $stmt->fetch();
			
			if($pw!==$pwd2)
			{
				echo "<div class=\"alert alert-danger alert-dismissible\" role=\"alert\">";
				echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>";
				echo "Password salah ! ";
				echo "</div>";
				
			
			}
			else
			{	
			
				session_start();
				$_SESSION['SES_LOGIN'] = $uid; 
				$_SESSION['USER_LEVEL'] = $akses;
				$_SESSION['USERNAME'] = $name;
				
				echo "<script>document.location.href='page.php?open=home'</script>";
				//header('location : page.php');
			}
			
				
		}	
	
}else{
	echo "<script>document.location.href='index.php'</script>";
}	
?>