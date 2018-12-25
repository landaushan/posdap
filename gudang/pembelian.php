<?php
if(session_status()!==2)session_start();//>=php 5.4
if(!isset($_SESSION['SES_LOGIN'])){
	header('location:../home');
 }
$user_id=$_SESSION['SES_LOGIN'];

//CARI DATA SUPPLIER
$qri="SELECT * FROM ma_supplier WHERE active='Y'";
$res= querydb($qri);

//CARI DATA BARANG
$qri2="SELECT * FROM ma_barang WHERE active='Y' ORDER BY nm_barang ASC";
$res2=querydb($qri2);

//CARI DATA SATUAN
$qri3="SELECT * FROM ma_satuan_barang WHERE active='Y'";
$res3=querydb($qri3);

$tgl = date("d-m-Y");

?>


<div class="main">  
  <div class="main-inner">
    <div class="container">
		<span id="alertMsg"></span>
		<span id="alertMsg2"></span>
		<span id="alertMsg3"></span>

    		<div class="row">
        <div class="span12">
          <div class="widget">
            <div class="widget-header"> <i class="icon-copy"></i>
              <h3>Form Pembelian</h3>
             
            </div>
            <!-- /widget-header -->
            <div class="widget-content">
               
              	<form class="form-horizontal" action="" method="post" name="formPembelian" id="formPembelian" target="" enctype="multipart/form-data">	


					<div class="control-group">
						<label for="tanggal" class="span1">Tanggal :</label>
						<div class="span2">
							<input type="text" class="form-control input-sm" value="<?php echo $tgl?>" id="txtTgl" name="txtTgl" >
						</div>
						<label for="no faktur" class="span1 control-label pad-right-zero">No Faktur :</label>
						<div class="span2">
							<input type="text" class="form-control input-sm" value="" id="txtNoFaktur" name="txtNoFaktur" >
						</div>
						<label for="supplier" class="span1 control-label pad-right-zero">Supplier :</label>
						<div class="span2">
							<select class="form-control input-sm" name="txtSupplier" id="txtSupplier">
								 <option value="">--Pilih--</option>
								 <?php while($rek=arraydb($res)){
									
									echo "<option value='".$rek['kd_supplier']."'>".$rek['nm_supplier']."</option>";
								   }	
								 ?>
								  
							</select>
						</div>
					</div>
					
					
					<div class="control-group"><!-- test inline group -->
						<label for="nama barang" class="span1">Nama Barang :</label>
						<div class="span2">
							<select class="form-control input-sm" name="txtBarang" id="txtBarang">
								 <option value="">--Pilih--</option>
								 
								 <?php while($rek2=arraydb($res2)){
									
									echo "<option value='$rek2[kd_barang]'>".$rek2['nm_barang']."</option>";
								   }	
								 ?>
								 
							</select>
						</div>
						<label for="satuan" class="span1 control-label pad-right-zero">Satuan :</label>
						<div class="span2">
							<div id="satuanBarang">
								<select class="form-control input-sm" name="txtSatuan" id="txtSatuan" ></select>
							</div>
						</div>
						<label for="harga satuan" class="span1 control-label pad-right-zero">Harga Satuan :</label>
						<div class="span1">
							<div class="input-group">
								<!--div class="input-group-addon">Rp</div-->
								<input type="number" class="form-control input-sm" value="" name="txtHarga" id="txtHarga">
							</div>
						</div>
						
					</div><!-- /inline group -->

					<div class="control-group">
					<label for="jumlah" class="span1 ">Jumlah :</label>
						<div class="span1">
							<input type="number" class="form-control input-sm" name="txtJumlah" id="txtJumlah" min="1">
						</div>
					<label for="userName" class="span1 control-label"></label>
						<div class="span1">
							<button name="btnAddItem" class="btn btn-primary btn-sm" id="btnAddItem"/><span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;Tambah Item</button><!-- btn add -->
						</div>
					</div>

					<div class="table-responsive">
					<span id="tblArea">
						<table class="table table-bordered table-condensed table-hover" style="background:#fff;" id="tblPembelian">
							<tr>
								<th>No.</th>
								<th>Kode Barang</th>
								<th>Nama Barang</th>
								<th>Satuan</th>
								<th>Harga<br>(Rp)</th>
								<th>Jumlah<br>(Item)</th>
								<th>Sub Total<br>(Rp)</th>
								<th>Pilih</th>
							</tr>
							<?php
								//periksa apakah ada data item barang di tabel pembelian_tmp atas nama user tsb. 
								$c=1;$ttlItem=0;$ttlHarga=0;
								$qri4="SELECT a.*,b.nm_barang,c.nm_satuan
										FROM pembelian_tmp a 
										LEFT JOIN ma_barang b ON b.kd_barang=a.kd_barang 
										LEFT JOIN ma_satuan_barang c ON c.kd_satuan=a.kd_satuan
										WHERE user_id='$user_id'";
								$res4=querydb($qri4);
								$row4=numrows($res4);
								if($row4>=1){
									while($rek4=arraydb($res4)){
														
										$subTtl = $rek4['jumlah'] * $rek4['harga'];
										echo "<tr>";
										echo"<td align='center'>".$c."</td>";
										echo"<td>".$rek4['kd_barang']."</td>";
										echo"<td>".$rek4['nm_barang']."</td>";
										echo"<td align='center'>".$rek4['nm_satuan']."</td>";
										echo"<td align='center'>".number_format($rek4['harga'],0,",",".")."</td>";
										echo"<td align='center'>".number_format($rek4['jumlah'],0,",",".")."</td>";
										echo"<td align='right'>".number_format($subTtl,0,",",".")."</td>";
										echo"<td align='center'><a type='button' data-toggle=\"tooltip\" data-placement=\"top\" title=\"Hapus Data Item\" class='btn btn-danger btn-xs' href=\"gudang/pembelian_proses.php?act=hapusItem&id=".$rek4['row_id']."\">Hapus</a></td>";
										echo"</tr>";		
										$ttlItem = $ttlItem + $rek4['jumlah'];
										$ttlHarga = $ttlHarga + $subTtl;
										$c++;
									}
								}else{
										echo"<tr>";
										echo"<td>&nbsp;</td>";
										echo"<td></td>";
										echo"<td></td>";
										echo"<td></td>";
										echo"<td></td>";
										echo"<td></td>";
										echo"<td></td>";
										echo"<td></td>";
										echo"</tr>";	
									
									
								}	
								
							?>
							<tr>
								<td colspan='5' align='center'><b>Total</b></td>
								<td align='center'><b><?php echo number_format($ttlItem,0,",",".")?></b></td>
								<td align='right'><b><?php echo number_format($ttlHarga,0,",",".")?></b></td>
								<td></td>
							</tr>
						</table>
					</span>
				</div><!-- /class responsive -->
				
				
				<center>
					<br>
					<button type="submit" class="btn btn-primary btn-sm center-block" id="btnPembelianSimpan"><span class="glyphicon glyphicon-floppy-save"></span>&nbsp;&nbsp;Simpan Data Pembelian</button>
				<center>

			
				
				
				</form>
				<div class="clearfix"></div>
				<p></p>
				

            
              <!-- /shortcuts --> 
            </div>
            <!-- /widget-content --> 
          </div>
        </div>
        <!-- span -->
      </div>
    	
    </div> <!-- /container -->
  </div> <!-- /main-inner -->
</div> <!-- /main -->


	<div class="modal fade" id="modalPembelian">
		  <div class="modal-dialog modal-sm">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h5 class="modal-title">ERROR !!!</h5>
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