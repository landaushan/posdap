<?php
 session_start();
 if(!isset($_SESSION['SES_LOGIN'])){
	header('location:home');
	
 }
 require_once "library/inc.connection.php";
 require_once "library/inc.library.php";
 opendb();
//cari data toko
   $qri = "SELECT * FROM ma_toko";
   $res = querydb($qri);
   $rec = arraydb($res);
   $namaToko = $rec['nm_toko'];
   $alamatToko = $rec['almt_toko'];
   $kota = $rec['kota'];
   $logoToko   = $rec['logo'];
   $telpToko   = $rec['tlp_toko'];
   $faxToko   = $rec['fax_toko'];

 //cari data user 
 $_SESSION['SES_LOGIN'] ? $user_id = trim($_SESSION['SES_LOGIN']) : $user_id="";
 $_SESSION['USER_LEVEL'] ? $levelAkses = trim($_SESSION['USER_LEVEL']) : $levelAkses="";

 
?>

<!DOCTYPE html>
<html lang="en">
  
<head>
    <meta charset="utf-8">
    <title><?php echo $namaToko ?> - POS</title>
		<link rel="shortcut icon" href="fav.png" />
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">    
    
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-responsive.min.css" rel="stylesheet">
    <link href="css/bootstrap-table.css" rel="stylesheet">
    
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">
    <link href="css/font-awesome.css" rel="stylesheet">
    <link rel="shortcut icon" href="img/<?php echo $logoToko ?>" />	
    <link href="css/style.css" rel="stylesheet">
   


    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

  </head>

<body>
	<div class="navbar navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container">
			<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</a>
			<a class="brand" href="?open=home">
				<?php echo $namaToko ?>
			</a>
			
			<div class="nav-collapse pull-right">
				<ul class="nav pull-right">			
					<li class="dropdown">						
						
						<ul class="dropdown-menu">
							<li><a href="#">Profile</a></li>
						</ul>						
					</li>
					<li><a href="#" id="bootbox-confirm" style="color: red;"><i class="icon-off"></i><span> Keluar</span> </a> </li>
				</ul>	
			</div><!--/.nav-collapse -->	
	
		</div> <!-- /container -->
	</div> <!-- /navbar-inner -->
</div> <!-- /navbar -->	


<div class="subnavbar">
  <div class="subnavbar-inner">
    <div class="container">
      <ul class="mainnav">
        <li class=""><a href="?open=home"><i class="icon-dashboard"></i><span>Dashboard</span> </a> </li>
        
        <li><a href="#"><i class="icon-user"></i><span>Pengguna: <?php echo $_SESSION['USERNAME']; ?></span> </a></li>
        <li><a href="#"><i class="icon-user"></i><span>Tingkat: <?php echo $_SESSION['USER_LEVEL']; ?></span> </a></li>
        <?php 
        if($_SESSION['USER_LEVEL']=="Super"){
        ?>
        <li><a href="?open=user_data" ><i class="icon-group"></i><span>Hak Akses</span> </a> </li>
        <?php 
    	}
        ?>
      </ul>
    </div>
    <!-- /container --> 
  </div>
  <!-- /subnavbar-inner --> 
</div>





        	<?php 
			include"page_control.php";
			?>




<div class="footer">
  <div class="footer-inner">
    <div class="container">
      <div class="row">
        <div class="span12"> &copy; <?php echo date('Y'); ?> || <a href="">CV DWI ABADI PRATAMA</a></div>
        <!-- /span12 --> 
      </div>
      <!-- /row --> 
    </div>
    <!-- /container --> 
  </div>
  <!-- /footer-inner --> 
</div>
	<script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<!--<script src="js/bootstrap-datepicker.js"></script>!-->

	<script src="js/bootstrap.min.js"></script>
	<script src="js/bootbox.min.js"></script>
	<script type="text/javascript">
		jQuery(
		  function($) {
				$( "#bootbox-confirm" ).click(function() {
					bootbox.confirm("Apakah anda yakin ingin keluar?", function(result) {
						if(result) {
							window.location = 'logout.php';
						}
					});
				});
				$('[data-toggle="tooltip"]').tooltip(); 
			}
		  
		);

	
	</script>

	<script src="js/fungsi.js"></script>
</body>

</html>
