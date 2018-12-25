<?php
if(session_status()!==2)session_start();//>=php 5.4
if(!isset($_SESSION['SES_LOGIN'])){
	header('location:../home');
 }
require_once "../library/inc.connection.php";
require_once "../library/inc.library.php";
opendb();

$kodeUser =buatKode("ma_user","UID");


 ?>   
		<span id="alertMsg"></span>
		<div class="panel panel-primary alert alert-dissmisable alert-info" id="panelUserTambah">
			<div class="panel-heading"><span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;TAMBAH DATA USER
				<div type="button" class="close" data-dismiss="alert">&times;</div>
			</div>
			<div class="panel-body">
				
				<form class="form-horizontal" action="" method="post" name="formUser" id="formUser" target="" enctype="multipart/form-data" >
					<div class="form-group form-group-sm">
						<label for="kode" class="col-sm-4 control-label pad-right-zero">Kode :</label>
						<div class="col-sm-3">
							<input type="text" class="form-control input-sm" value="<?php echo $kodeUser?>" id="kode" name="kode" readonly="readonly">
						</div>
					</div>
					<div class="form-group form-group-sm">
						<label for="namaKasir" class="col-sm-4 control-label pad-right-zero">Nama Lengkap :</label>
						<div class="col-sm-8">
							<input type="text" class="form-control input-sm" name="txtNamaLengkap" id="txtNamaLengkap" value="" maxlength="30" data-toggle="tooltip" data-placement="left" title="Maksimum 30 character" required autofocus>
						</div>
					</div>
					<div class="form-group form-group-sm">
						<label for="namaKasir" class="col-sm-4 control-label pad-right-zero">Username :</label>
						<div class="col-sm-6">
							<input type="text" class="form-control input-sm" name="txtUsername" id="txtUsername" value="" placeholder="8 s.d 15 character" maxlength="15" data-toggle="tooltip" data-placement="left" title="8 s.d 15 character" required autofocus>
						</div>
					</div>
					<div class="form-group form-group-sm">
						<label for="password" class="col-sm-4 control-label pad-right-zero">Password :</label>
						<div class="col-sm-6">
							<input type="password" class="form-control input-sm" name="txtPassword" id="txtPassword" value="" placeholder="8 s.d 15 character" maxlength="15" required>
						</div>
					</div>
					 <div class="form-group form-group-sm">
						<label for="level" class="col-sm-4 control-label pad-right-zero">Level :</label>
						<div class="col-sm-4">
							<select class="form-control" name="txtLevel" id="txtLevel" required>
								<option value="">---Pilih---</option>	
								  <option value="Admin">Admin</option>
								  <option value="Kasir">Kasir</option>
								  
							</select>
						</div>
					</div>
					
					<div class="form-group form-group-sm">
						<label for="level" class="col-sm-4 control-label pad-right-zero">Active :</label>
						<div class="col-sm-4">
							<select class="form-control" name="txtActive" id="txtActive">
								 <option value="Y">Ya</option>
								  <option value="T">Tidak</option>
							</select>
						</div>
					</div>
					
				   
					<div class="col-sm-2 col-sm-offset-3"><input type="submit" name="btnUserSimpan" id="btnUserSimpan" value=" Simpan " class="btn btn-primary btn-sm" data-id="1"/> </div>
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
