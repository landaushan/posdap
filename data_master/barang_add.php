<?php
if(session_status()!==2)session_start();//>=php 5.4
if(!isset($_SESSION['SES_LOGIN'])){
	header('location:../home');
 }
require_once "../library/inc.connection.php";
require_once "../library/inc.library.php";
 
opendb();

$kode =buatKode("ma_barang","");

//Cari data satuan barang
$qri = "SELECT * FROM ma_satuan_barang WHERE active='Y' ORDER BY nm_satuan ASC";
$hsl = querydb($qri);

//cari data kategori
$qri2 = "SELECT * FROM ma_kategori_barang WHERE active='Y' ORDER BY nm_kategori ASC";
$hsl2 = querydb($qri2);

 ?>   
   
		<div class="panel panel-primary alert alert-dissmisable alert-info" id="panelBarangTambah">
			<div class="panel-heading"><span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;TAMBAH DATA BARANG
				<div type="button" class="close" data-dismiss="alert">&times;</div>
			</div>
			<div class="panel-body">
				<form class="form-horizontal" action="" method="post" name="formBarang" id="formBarang" target="" enctype="multipart/form-data" >
					<div class="form-group form-group-sm">
						<label for="kode" class="col-sm-3 control-label pad-right-zero">Kode :</label>
						<div class="col-sm-5">
							<input type="text" class="form-control input-sm" value="<?php echo $kode?>" id="kode" name="kode" readonly="readonly">
						</div>
					</div>
					<div class="form-group form-group-sm">
						<label for="nama barang" class="col-sm-3 control-label pad-right-zero">Nama Barang :</label>
						<div class="col-sm-9">
							<input type="text" class="form-control input-sm" name="txtNama" id="txtNama" value="" maxlength="50" data-toggle="tooltip" data-placement="left" title="Maksimum 50 character" required autofocus>
						</div>
					</div>
					<div class="form-group form-group-sm">
						<label for="satuan" class="col-sm-3 control-label pad-right-zero">Satuan :</label>
						<div class="col-sm-5">
							<select class="form-control" name="txtSatuan" id="txtSatuan" required>
								<option value="">---Pilih---</option>
								<?php
									while($rek=arraydb($hsl)){
								
										echo "<option value=\"".$rek['kd_satuan']."\">".$rek['nm_satuan']."</option>";
									}
								?>
							</select>
						</div>
					</div>
					<div class="form-group form-group-sm">
						<label for="kategori" class="col-sm-3 control-label pad-right-zero">Kategori :</label>
						<div class="col-sm-5">
							<select class="form-control" name="txtKategori" id="txtKategori" required>
								<option value="">---Pilih---</option>
								<?php
									while($rek2=arraydb($hsl2)){
								
										echo "<option value=\"".$rek2['kd_kategori']."\">".$rek2['nm_kategori']."</option>";
									}
								?>
							</select>
						</div>
					</div>
					<div class="form-group form-group-sm">
						<label for="harga jual" class="col-sm-3 control-label pad-right-zero">Harga Jual :</label>
						<div class="col-sm-5">
							<div class="input-group">
								<div class="input-group-addon">Rp</div>
								<input type="number" class="form-control input-sm" name="txtHargaJual" id="txtHargaJual" VALUE="" required>
							</div>
						</div>
					</div>
					<div class="form-group form-group-sm">
						<label for="harga beli" class="col-sm-3 control-label pad-right-zero">Harga Beli :</label>
						<div class="col-sm-5">
							<div class="input-group">
								<div class="input-group-addon">Rp</div>
								<input type="number" class="form-control input-sm" name="txtHargaBeli" id="txtHargaBeli" value=""  required>
							</div>
						</div>
					</div>
					 
					
					<div class="form-group form-group-sm">
						<label for="level" class="col-sm-3 control-label pad-right-zero">Active :</label>
						<div class="col-sm-4">
							<select class="form-control" name="txtActive" id="txtActive">
								 <option value="Y">Ya</option>
								  <option value="T">Tidak</option>
							</select>
						</div>
					</div>
					
				   
					<div class="col-sm-2 col-sm-offset-3"><input type="submit" name="btnBarangSimpan" id="btnBarangSimpan" value=" Simpan " class="btn btn-primary btn-sm" data-id="1" /> </div>
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
