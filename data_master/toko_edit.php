<?php
if(session_status()!==2)session_start();//>=php 5.4
if(!isset($_SESSION['SES_LOGIN'])){
	header('location:../home');
 }
require_once "../library/inc.connection.php";
require_once "../library/inc.library.php";

if(isset($_POST['kodeToko'])){
	
	$kodeToko = trim($_POST['kodeToko']);
	
	$qri = "SELECT * FROM ma_toko WHERE kd_toko='$kodeToko'";
	$res = querydb($qri);
	$rek = arraydb($res);
	
	$namaToko = $rek['nm_toko'];
	$almtToko = $rek['almt_toko'];
	$kota = $rek['kota'];
	$noTelp	  = $rek['tlp_toko'];
	$noFax	  = $rek['fax_toko'];
	$logo	  = $rek['logo'];
	
	
}


?>	
			<div class="panel panel-primary alert alert-dissmisable alert-warning" id="panelUbahData" >
				<div class="panel-heading"><span class="glyphicon glyphicon-refresh"></span>&nbsp;UBAH DATA TOKO
					<div type="button" class="close" data-dismiss="alert">&times;</div>
				</div>
				<div class="panel-body">
					<form class="form-horizontal" action="" method="POST" name="formTokoUbah" id="formTokoUbah" target="" enctype="multipart/form-data" >
						<div class="form-group form-group-sm">
							<label for="kode" class="col-sm-3 control-label pad-right-zero">Kode :</label>
							<div class="col-sm-3">
								<input type="text" class="form-control input-sm" value="<?php echo $kodeToko?>" id="kodeToko" name="kodeToko" readonly="readonly">
							</div>
						</div>
						<div class="form-group form-group-sm">
							<label for="nama toko" class="col-sm-3 control-label pad-right-zero">Nama Toko :</label>
							<div class="col-sm-9">
								<input type="text" class="form-control input-sm" name="txtNama" id="txtNama" value="<?php echo $namaToko?>"  maxlength="20" data-toggle="tooltip" data-placement="left" title="Maksimum 30 character" required autofocus>
							</div>
						</div>
						<div class="form-group form-group-sm">
							<label for="alamat" class="col-sm-3 control-label pad-right-zero">Alamat :</label>
							<div class="col-sm-9">
								<input type="text" class="form-control input-sm" name="txtAlamat" id="txtAlamat" value="<?php echo $almtToko?>"  maxlength="150" data-toggle="tooltip" data-placement="left" title="Maksimum 150 character" required>
							</div>
						</div>
						<div class="form-group form-group-sm">
							<label for="kota" class="col-sm-3 control-label pad-right-zero">Kota :</label>
							<div class="col-sm-7">
								<input type="text" class="form-control input-sm" name="txtKota" id="txtKota" value="<?php echo $kota?>"  maxlength="30" data-toggle="tooltip" data-placement="left" title="Maksimum 30 character" required>
							</div>
						</div>
						
						<div class="form-group form-group-sm">
							<label for="telpon" class="col-sm-3 control-label pad-right-zero">No. Telp :</label>
							<div class="col-sm-7">
								<input type="text" class="form-control input-sm" name="txtPhone" id="txtPhone" value="<?php echo $noTelp?>" placeholder="" maxlength="100">
							</div>
						</div>
						<div class="form-group form-group-sm">
							<label for="fax" class="col-sm-3 control-label pad-right-zero">No. Fax :</label>
							<div class="col-sm-7">
								<input type="text" class="form-control input-sm" name="txtFax" id="txtFax" value="<?php echo $noFax?>" >
							</div>
						</div>
						<div class="form-group form-group-sm">
							<label for="logo" class="col-sm-3 control-label pad-right-zero">Logo :</label>
							<div class="col-sm-7">
								<input type="file" class="form-control input-sm" name="file_logo" id="file_logo" value="<?php echo $logo?>">
								
							</div>
							<div class="col-sm-9 col-sm-offset-3">
								<span id="helpBlock" class="help-block">Ukuran Logo : lebar 125px, tinggi 40px.</span>
								<span id="helpBlock" class="help-block">Gunakan Logo dengan format *.jpg,*jpeg,*.png, dan *.gif</span>
							</div>
						</div>
					   
						<div class="col-sm-2 col-sm-offset-3"><input type="submit" name="btnTokoUbahSimpan" id="btnTokoUbahSimpan" value=" Simpan " class="btn btn-primary" id="btnSimpan"/> </div>
					</form>
				</div><!-- /panel body -->	
			</div><!-- /panel -->
	
<script type="text/javascript" charset="utf-8">
	$(document).ready(function(){
		//mengaktifkan tooltip	
		$('[data-toggle="tooltip"]').tooltip();
		
	});	
</script>