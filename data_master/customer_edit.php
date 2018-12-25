<?php
if(session_status()!==2)session_start();//>=php 5.4
if(!isset($_SESSION['SES_LOGIN'])){
	header('location:../home');
 }
require_once "../library/inc.connection.php";
require_once "../library/inc.library.php";
opendb();

	
	$kode = trim($_POST['kode']);
	
	$qri = "SELECT * FROM ma_customer WHERE id_customer='$kode'";
	$hsl = querydb($qri);
	$rek = arraydb($hsl);
	$dtaNama = $rek['nm_customer'];
	$dtaAlamat = $rek['alamat_customer'];
	$dtaKota   = $rek['kota_customer'];
	$dtaTelp = $rek['tlp_customer'];
	$dtaEmail = $rek['email_customer'];
	$dtaActive = $rek['status'];
	

	
?>
	
	
			<div class="panel panel-primary alert alert-dissmisable alert-warning" id="panelUbahData">
				<div class="panel-heading"><span class="glyphicon glyphicon-refresh"></span>&nbsp;UBAH DATA CUSTOMER
					<div type="button" class="close" data-dismiss="alert">&times;</div>
				</div>
				<div class="panel-body">
					<form class="form-horizontal" action="" method="post" name="formCustomerUbah" id="formCustomerUbah" target="" enctype="multipart/form-data" >
						<div class="form-group form-group-sm">
							<label for="kode" class="col-sm-4 control-label pad-right-zero">Kode :</label>
							<div class="col-sm-4">
								<input type="text" class="form-control input-sm" value="<?php echo $kode?>" id="kode" name="kode" readonly="readonly">
							</div>
						</div>
						<div class="form-group form-group-sm">
							<label for="nama supplier" class="col-sm-4 control-label pad-right-zero">Nama Customer :</label>
							<div class="col-sm-8">
								<input type="text" class="form-control input-sm" name="txtNama" id="txtNama" value="<?php echo $dtaNama?>"  maxlength="20" data-toggle="tooltip" data-placement="left" title="Maksimum 30 character" required autofocus>
							</div>
						</div>
						<div class="form-group form-group-sm">
							<label for="alamat" class="col-sm-4 control-label pad-right-zero">Alamat :</label>
							<div class="col-sm-8">
								<input type="text" class="form-control input-sm" name="txtAlamat" id="txtAlamat" value="<?php echo $dtaAlamat?>"  maxlength="150" data-toggle="tooltip" data-placement="left" title="Maksimum 150 character" required>
							</div>
						</div>
						<div class="form-group form-group-sm">
							<label for="alamat" class="col-sm-4 control-label pad-right-zero">Kota :</label>
							<div class="col-sm-8">
								<input type="text" class="form-control input-sm" name="txtKota" id="txtKota" value="<?php echo $dtaKota?>"  maxlength="150" data-toggle="tooltip" data-placement="left" title="Maksimum 150 character" required>
							</div>
						</div>
						<div class="form-group form-group-sm">
							<label for="telpon" class="col-sm-4 control-label pad-right-zero">No. Telp :</label>
							<div class="col-sm-6">
								<input type="text" class="form-control input-sm" name="txtPhone" id="txtPhone" value="<?php echo $dtaTelp?>" placeholder="" maxlength="100">
							</div>
						</div>
						<div class="form-group form-group-sm">
							<label for="fax" class="col-sm-4 control-label pad-right-zero">Email :</label>
							<div class="col-sm-6">
								<input type="text" class="form-control input-sm" name="txtEmail" id="txtEmail" value="<?php echo $dtaEmail?>" >
							</div>
						</div>
				   <div class="form-group form-group-sm">
						<label for="active" class="col-sm-4 control-label pad-right-zero">Active :</label>
						<div class="col-sm-4">
							<select class="form-control" id="txtActive" name="txtActive">
								<?php if($dtaActive=="Y"){$plh1='selected';$plh2='';}else{$plh1='';$plh2='selected';} ?>
								 <option value="Y" <?php echo $plh1?>>Ya</option>
								  <option value="T" <?php echo $plh2?>>Tidak</option>
							</select>
						</div>
					</div>
					   
						<div class="col-sm-2 col-sm-offset-3"><input type="submit" name="btnUbahCustomerSimpan" value=" Simpan " class="btn btn-primary" id="btnUbahCustomerSimpan"/> </div>
					</form>
				</div><!-- /panel body -->	
			</div><!-- /panel -->
			<div class="modal fade" id="modalUser">
		  <div class="modal-dialog modal-sm">
			<div class="modal-content">
			  <div class="modal-header">
				<!--button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button-->
				<!--h4 class="modal-title">Modal title</h4-->
			  </div>
			  <div class="modal-body">
				<p></p>
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<!--button type="button" class="btn btn-primary">Save changes</button-->
			  </div>
			</div><!-- /.modal-content -->
		  </div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
		
<script type="text/javascript" charset="utf-8">
	$(document).ready(function(){
		//mengaktifkan tooltip	
		$('[data-toggle="tooltip"]').tooltip();
		
	});	
</script>		