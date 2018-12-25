<?php
if(session_status()!==2)session_start();//>=php 5.4
if(!isset($_SESSION['SES_LOGIN'])){
	header('location:../home');
 }
require_once "../library/inc.connection.php";
require_once "../library/inc.library.php";
opendb();

$kodeToko =buatKode("ma_toko","TK");


 ?>   
   
		<div class="panel panel-primary alert alert-dissmisable alert-info" id="panelTokoTambah">
			<div class="panel-heading"><span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;TAMBAH DATA TOKO
				<div type="button" class="close" data-dismiss="alert">&times;</div>
			</div>
			<div class="panel-body">
				<form class="form-horizontal" action="" method="post" name="form1" target="" enctype="multipart/form-data" >
					<div class="form-group form-group-sm">
						<label for="kode" class="col-sm-3 control-label pad-right-zero">Kode :</label>
						<div class="col-sm-3">
							<input type="text" class="form-control input-sm" value="<?php $kodeToko?>" id="kodeToko" name="kodeToko" readonly="readonly">
						</div>
					</div>
					<div class="form-group form-group-sm">
						<label for="nama toko" class="col-sm-3 control-label pad-right-zero">Nama Toko :</label>
						<div class="col-sm-9">
							<input type="text" class="form-control input-sm" name="txtNama" id="txtNama" placeholder="Toko Baju Beauty" maxlength="20" data-toggle="tooltip" data-placement="left" title="Maksimum 30 character" required autofocus>
						</div>
					</div>
					<div class="form-group form-group-sm">
						<label for="alamat" class="col-sm-3 control-label pad-right-zero">Alamat :</label>
						<div class="col-sm-9">
							<input type="text" class="form-control input-sm" name="txtAlamat" id="txtAlamat" placeholder="Jl. Cisadane I No 12" maxlength="150" data-toggle="tooltip" data-placement="left" title="Maksimum 150 character" required>
						</div>
					</div>
					
					<div class="form-group form-group-sm">
						<label for="telpon" class="col-sm-3 control-label pad-right-zero">No. Telp :</label>
						<div class="col-sm-6">
							<input type="text" class="form-control input-sm" name="txtPhone" id="txtPhone" placeholder="" maxlength="100">
						</div>
					</div>
					<div class="form-group form-group-sm">
						<label for="fax" class="col-sm-3 control-label pad-right-zero">No. Fax :</label>
						<div class="col-sm-6">
							<input type="text" class="form-control input-sm" name="txtFax" id="txtFax" placeholder="" >
						</div>
					</div>
					<div class="form-group form-group-sm">
						<label for="logo" class="col-sm-3 control-label pad-right-zero">Logo :</label>
						<div class="col-sm-6">
							<input type="file" class="form-control input-sm" name="file_logo" id="file_logo">
						</div>
					</div>
				   
					<div class="col-sm-2 col-sm-offset-3"><input type="submit" name="btnTokoTambah" value=" Simpan " class="btn btn-primary" id="btnTokoTambah"/> </div>
				</form>
			</div><!-- /panel body -->	
		</div><!-- /panel -->

	<script type="text/javascript" charset="utf-8">
	$(document).ready(function(){
		//mengaktifkan tooltip	
		$('[data-toggle="tooltip"]').tooltip();
		
	});	
</script>	