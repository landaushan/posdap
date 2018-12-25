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

#mencari data satuan dan harga dari item barang
if(isset($_POST['kodeBarang'])){

	//cari data yang dibawa oleh ajax
	$kdBarang = trim($_POST['kodeBarang']);
	//list($kdBarang,$nmBarang) = explode("&",$codeBarang);
	

	$qry="SELECT a.*,b.nm_satuan FROM ma_barang a LEFT JOIN ma_satuan_barang b ON b.kd_satuan=a.kd_satuan WHERE a.kd_barang='$kdBarang'";
	$res=querydb($qry);
	$rek=arraydb($res);
		//siapkan output data untuk harga beli standar. 
		$hargaBeli = $rek['hrg_beli'];
	
	//siapkan output dari ajax untuk satuan barang
	$slct  = "<select class=\"form-control input-sm\" name=\"txtSatuan\" id=\"txtSatuan\" required>";
	$slct .= "<option value=\"\">---Pilih---</option>";
	
	$qri2 = "SELECT * FROM ma_satuan_barang WHERE active='Y'";
	$hsl2 = querydb($qri2);
	while($rek2=arraydb($hsl2)){
		if($rek['kd_satuan']==$rek2['kd_satuan']){$plh='selected';}else{$plh='';}
		$slct .= "<option value='".$rek2['kd_satuan']."' ".$plh.">$rek2[nm_satuan]</option>";	
		
	}
	$slct .= "</select>";
	
	//convert data menjadi json format
	$data = array('msg1'=>$slct,'msg2'=>$hargaBeli);
	echo json_encode($data);
	
}	
# menambahkan item barang yang dibeli 
if(isset($_POST['addItem'])){
	
	# BACA DATA DALAM FORM, masukkan datake variabel
	$kdBarang = trim($_POST['codeBarang']);
	$kdSatuan = trim($_POST['kodeSatuan']);
	$harga		= secure(trim($_POST['hrgBeli']));
	$jumlah		= secure(trim($_POST['qty']));
	
	$errMsg="";
	$errMsg2="";
	$tbl="";
	
	# VALIDASI FORM, jika ada kotak yang kosong, buat pesan error ke dalam kotak $pesanError
	$pesanError = array();
	if (trim($kdBarang)=="") {
		$pesanError[] = "Data <b>Nama Barang</b> Belum Dipilih !";		
	}
	if (trim($kdSatuan)=="") {
		$pesanError[] = "Data <b>Satuan Barang</b> Belum Dipilih !";		
	}
	if (trim($harga)=="") {
		$pesanError[] = "Data <b>Harga Barang</b> Belum Diisi !";		
	}
	if (trim($jumlah)<=0) {
		$pesanError[] = "Data <b>Jumlah Barang</b> Belum Diisi !";		
	}
	
	# MENAMPILKAN PESAN JIKA ADA ERROR DARI VALIDASI
	if (count($pesanError)>=1 ){
		$errMsg  = "<div class=\"alert alert-danger alert-dismissible\" role=\"alert\">";
		$errMsg .= "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>";
			$noPesan=0;
			foreach ($pesanError as $indeks=>$pesan_tampil) { 
			$noPesan++;
				$errMsg .= "&nbsp;&nbsp; $noPesan. $pesan_tampil<br>";	
				//echo "<script>alert('".$noPesan. $pesan_tampil."')</script>";
			} 
		$errMsg .= "</div>"; 
	}else{
			
		$rowId = buatKode("pembelian_tmp","");
	
		$qri = "INSERT INTO pembelian_tmp (row_id,kd_barang,kd_satuan,jumlah,harga,user_id) 
				VALUES('$rowId','$kdBarang','$kdSatuan','$jumlah','$harga','$user_id')";
		$res = querydb($qri);
		
		if($res){

			$tbl .="<table class=\"table table-bordered table-condensed table-hover table-striped\" style=\"background:#fff;\" id=\"tblPembelian\">";
			$tbl .="<tr>";
			$tbl .="<th>No.</th>";
			$tbl .="<th>Kode Barang</th>";
			$tbl .="<th>Nama Barang</th>";
			$tbl .="<th>Satuan</th>";
			$tbl .="<th>Harga<br>(Rp)</th>";
			$tbl .="<th>Jumlah<br>(Item)</th>";
			$tbl .="<th>Sub Total<br>(Rp)</th>";
			$tbl .="<th>Pilih</th>";
			$tbl .="</tr>";
			
			
			$c=1;$ttlItem=0;$ttlHarga=0;
			$qri4="SELECT a.*,b.nm_barang,c.nm_satuan
					FROM pembelian_tmp a 
					LEFT JOIN ma_barang b ON b.kd_barang=a.kd_barang 
					LEFT JOIN ma_satuan_barang c ON c.kd_satuan=a.kd_satuan
					WHERE user_id='$user_id'";
			$res4=querydb($qri4);	
			while($rek4=arraydb($res4)){
								
				$subTtl = $rek4['jumlah'] * $rek4['harga'];
				$tbl .="<tr>";
				$tbl .="<td align='center'>".$c."</td>";
				$tbl .="<td>".$rek4['kd_barang']."</td>";
				$tbl .="<td>".$rek4['nm_barang']."</td>";
				$tbl .="<td align='center'>".$rek4['nm_satuan']."</td>";
				$tbl .="<td align='center'>".number_format($rek4['harga'],0,",",".")."</td>";
				$tbl .="<td align='center'>".number_format($rek4['jumlah'],0,",",".")."</td>";
				$tbl .="<td align='right'>".number_format($subTtl,0,",",".")."</td>";
				$tbl .= "<td align='center'><a type='button' data-toggle=\"tooltip\" data-placement=\"top\" title=\"Hapus Data Item\" class='btn btn-danger btn-xs' href=\"gudang/pembelian_proses.php?act=hapusItem&id=".$rek4['row_id']."\">Hapus</a></td>";
				//$tbl .="<td align='center'><button class='btn btn-danger btn-xs btnHapus' data-val='$rek4[row_id]'>Hapus</button></td>";
				$tbl .="</tr>";		
				$ttlItem = $ttlItem + $rek4['jumlah'];
				$ttlHarga = $ttlHarga + $subTtl;
				$c++;
			}
			
			$tbl .="<tr height=\"30\">
				<td colspan='5' align='center' style='font-color:#fff;'><b>Total</b></td>
				<td align='center'><b>".number_format($ttlItem,0,",",".")."</b></td>
				<td align='right'><b>".number_format($ttlHarga,0,",",".")."</b></td>
				<td></td>
				</tr>";
			$tbl .="</table>";
			
			
		}else{
			
			$errMsg2  = "<div class=\"alert alert-danger alert-dismissible\" role=\"alert\">";
			$errMsg2 .= "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>";
			$noPesan=0;
			foreach ($pesanError as $indeks=>$pesan_tampil) { 
				$noPesan++;
					$errMsg2 .= "&nbsp;&nbsp; $noPesan. $pesan_tampil<br>";	
					//echo "<script>alert('".$noPesan. $pesan_tampil."')</script>";
			} 
			$errMsg2 .= "</div>"; 	
		}	
			
	}
		
	if(!empty($errMsg) || !empty($errMsg2)){
		//convert data menjadi json format
		$data = array('msg1'=>$errMsg,'msg2'=>$errMsg2);
		
	}else{
		//convert data menjadi json format
		$data = array('msg1'=>$errMsg,'msg2'=>$errMsg2, 'msg3'=>$tbl);
	}	
	echo json_encode($data);
}

#menghapus item barang yang batal dibeli

if($_GET['act']=="hapusItem")
{
	$id = trim($_GET['id']);
	
	//echo $id;		
	//hapus data pembelian berdasarkan $kdRow
	$sql = "DELETE FROM pembelian_tmp WHERE row_id='$id'";
	$hsl = querydb($sql);	
	if($hsl)
	{
		header('location: ../page.php?open=pembelian');
	}

}
	
	

#periksa no faktur
if(isset($_POST['checkFaktur'])){

	$noFaktur = trim($_POST['noFaktur']);
	
	$qri = "SELECT no_faktur FROM pembelian WHERE no_faktur='$noFaktur'";
	$hsl = querydb($qri);
	$row = numrows($hsl);
	if($row>=1){
	
			$errMsg  = "<div class=\"alert alert-danger alert-dismissible\" role=\"alert\">";
			//$errMsg .= "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>";
			$errMsg .= " No. Faktur : <b>$noFaktur</b> sudah ada dalam database, gunakan nomor yang lain !"; 
			$errMsg .= "</div>";
			
		//convert data menjadi json format
		$data = array('msg1'=>$errMsg,'msg2'=>'');
		echo json_encode($data);	
			
	}	
	
}

# simpan data pembelian
if(isset($_POST['simpanBeli'])){
	# BACA DATA DALAM FORM, masukkan datake variabel
	$tgl = secure(trim($_POST['tgl']));
		$tglSql = InggrisTgl($tgl);
	$noFaktur = secure(trim($_POST['noFaktur']));
	$supl	= secure(trim($_POST['kdSupl']));
	
	$errMsg="";
	$errMsg2="";
	$errMsg3="";
	
	# VALIDASI FORM, jika ada kotak yang kosong, buat pesan error ke dalam kotak $pesanError
	$pesanError = array();
	if (trim($tgl)=="") {
		$pesanError[] = "Data <b>Tanggal</b> Belum Diisi !";		
	}
	if (trim($noFaktur)=="") {
		$pesanError[] = "Data <b>No. Faktur</b> Belum Diisi !";		
	}
	if (trim($supl)=="") {
		$pesanError[] = "Data <b>Nama Supplier</b> Belum Dipilih !";		
	}
	# MENAMPILKAN PESAN JIKA ADA ERROR DARI VALIDASI
	if (count($pesanError)>=1 ){
		$errMsg  = "<div class=\"alert alert-danger alert-dismissible\" role=\"alert\">";
		$errMsg .= "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>";
			$noPesan=0;
			foreach ($pesanError as $indeks=>$pesan_tampil) { 
			$noPesan++;
				$errMsg .= "&nbsp;&nbsp; $noPesan. $pesan_tampil<br>";	
			} 
		$errMsg .= "</div>"; 
	}else{

		//periksa apakah ada data detail pembelian
		$c=1;$ttlBeli=0;
		$qri = "SELECT * FROM pembelian_tmp WHERE user_id='$user_id'";
		$res = querydb($qri);
		$row = numrows($res);
		if($row<1){
			
			$pesanError[] = "Data Item Barang Tidak Ada, Silahkan Isi Terlebih Dahulu !";	
			$errMsg  = "<div class=\"alert alert-danger alert-dismissible\" role=\"alert\">";
			$errMsg .= "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>";
				$noPesan=0;
				foreach ($pesanError as $indeks=>$pesan_tampil) { 
				$noPesan++;
					$errMsg .= "&nbsp;&nbsp; $noPesan. $pesan_tampil<br>";	
				} 
			$errMsg .= "</div>"; 	
		
		}
		ELSE
		{
			// set autocommit to off //
			$mysqli->autocommit(FALSE);
			$noTrans = getNoTrans()+1;
			
			// Insert data dari tabel pembelian_tmp /
			while($rek=arraydb($res)){
		
				$subTtl = $rek['jumlah']*$rek['harga'];
				if($c==1){
					$qri = "INSERT INTO pembelian_detail (no_transaksi,kd_barang,kd_satuan,jumlah,harga,sub_total) 
					VALUES ('$noTrans', '$rek[kd_barang]','$rek[kd_satuan]','$rek[jumlah]','$rek[harga]','$subTtl');";
				}elseif($c<$row){
					$qri .= "INSERT INTO pembelian_detail (no_transaksi,kd_barang,kd_satuan,jumlah,harga,sub_total) 
					VALUES ('$noTrans', '$rek[kd_barang]','$rek[kd_satuan]','$rek[jumlah]','$rek[harga]','$subTtl');";
				}else{
					$qri .= "INSERT INTO pembelian_detail (no_transaksi,kd_barang,kd_satuan,jumlah,harga,sub_total) 
					VALUES ('$noTrans', '$rek[kd_barang]','$rek[kd_satuan]','$rek[jumlah]','$rek[harga]','$subTtl')";
				}	
				$c++;	
				$ttlBeli = $ttlBeli + $subTtl;
			}
				
				// execute multi query /
				if($mysqli->multi_query($qri))
				{
					do
					{
						$result = $mysqli->store_result();
					}
							
					while ($mysqli->next_result());
				}else{$errors[] = $mysqli->error;}	
			
				//insert data ke tabel pembelian. 
				//$id=buatKode("pembelian","");
					
					$qri2="INSERT INTO pembelian (no_transaksi,no_faktur,kd_supplier,tgl_pembelian,total_pembelian,id_user) 
						VALUES('$noTrans','$noFaktur','$supl','$tglSql','$ttlBeli','$user_id')";
					$res2=$mysqli->query($qri2);
					if(!$res2){$errors[] = $mysqli->error;}
					
					//hapus data di tabel pembelian_tmp
					$qri3="DELETE FROM pembelian_tmp WHERE user_id='$user_id'";
					$res3=$mysqli->query($qri3);
					if(!$res3){$errors[] = $mysqli->error;}
				
			if(count($errors) == 0) {
				$mysqli->commit();
				updateNoTrans($noTrans);
				updateStockBarang($noTrans,1);
						
				$errMsg2  = "<div class=\"alert alert-success alert-dismissible\" role=\"alert\">";
				$errMsg2 .= "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>";
				$errMsg2 .= "SUKSESS !!! Data telah Disimpan."; 
				$errMsg2 .= "</div>";
			
			}
			else 
			{
				$mysqli->rollback();
				$errMsg3  = "<div class=\"alert alert-danger alert-dismissible\" role=\"alert\">";
				$errMsg3 .= "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>";
				$errMsg3 .= "GAGAL !!! Data Tidak Bisa Disimpan."; 
				$errMsg3 .= "</div>";
			}

			# close connection #
			$mysqli->close();
			
		
		}	
		
	}	

	//$errMsg="SUKSESS!!!";
	//convert data menjadi json format
	
	$data = array('msg1'=>$errMsg,'msg2'=>$errMsg2,'msg3'=>$errMsg3);
	//$data = array('msg1'=>$errMsg);
	echo json_encode($data);

	
}

#mencari stock
if(isset($_POST['cariStock'])){
	//data:{cariStock:'',kategori:kategori,jmlStock:jmlStock},
	$kategori = trim($_POST['kategori']);
	$jmlStock = trim($_POST['jmlStock']);

	if($kategori=="all"){$filtKategori="";}else{$filtKategori="AND b.kd_kategori='$kategori'";};
	if($jmlStock=="3"){$filtStock="";}elseif($jmlStock=="0"){$filtStock="AND jumlah='$jmlStock'";}elseif($jmlStock=="dibawah 50"){$filtStock="AND jumlah<50";};
	
	
	$tbl  = "<table class=\"table table-condensed table-bordered\">";
	$tbl .= "<tr>";
	$tbl .= "<th>No</th>";
	$tbl .= "<th>Kode Barang</th>";
	$tbl .= "<th>Nama Barang</th>";
	$tbl .= "<th>Satuan Barang</th>";
	$tbl .= "<th>Jumlah Stock</th>";
	$tbl .= "<th>Harga Beli Rata2</th>";
	$tbl .= "<th>Harga Jual</th>";
	$tbl .= "</tr>";
	$c=1;
	
	$sql = "SELECT a.*,b.*,c.nm_satuan
		FROM stock_barang a 
		LEFT JOIN ma_barang b ON b.kd_barang=a.kd_barang
		LEFT JOIN ma_satuan_barang c ON c.kd_satuan=b.kd_satuan
		WHERE 1  $filtKategori $filtStock";
	$hsl = $mysqli->query($sql);
	//$hsl ->store_result();
	$row = $hsl->num_rows;
	
	if($row>=1){
		while($rek=$hsl->fetch_assoc()){
											
			$tbl .= "<tr>";
			$tbl .= "<td align='center'>".$c."</td>";
			$tbl .= "<td>".$rek['kd_barang']."</td>";
			$tbl .= "<td>".$rek['nm_barang']."</td>";
			$tbl .= "<td>".$rek['nm_satuan']."</td>";
			$tbl .= "<td align=\"center\">".number_format($rek['jumlah'],0,",",".")."</td>";
			$tbl .= "<td align=\"center\">".number_format($rek['hrg_beli_rata2'],0,".",",")."</td>";
			$tbl .= "<td align=\"center\">".number_format($rek['hrg_jual'],0,",",".")."</td>";
			$tbl .= "</tr>";
			$c++;
		}
	}else{
		
		$tbl .= "<tr height='200px'>";
		$tbl .= "<td colspan='7' align='center'> DATA TIDAK ADA !!!</td>";
		$tbl .= "</tr>";
		
	}	
	
	
	$tbl .= "</table>";
	
	
	//convert data menjadi json format
	$data = array('msg1'=>$tbl);
	echo json_encode($data);
	

}
	
?>

