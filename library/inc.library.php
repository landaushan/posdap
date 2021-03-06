<?php

 
opendb();
# Pengaturan tanggal komputer
date_default_timezone_set("Asia/Jakarta");

//**************** FUNGSI ANTI INJECTION DAN XSS *************************//

function secure($inp) {

	$xss= stripslashes(strip_tags(htmlspecialchars($inp,ENT_QUOTES)));
	//$sql = mysql_real_escape_string($xss);
	$sql = mysqli_real_escape_string(opendb(),$xss);
	return $sql;}
/*********************************************************************/

# Fungsi untuk membuat kode automatis
function buatKode($tabel, $inisial){
		
	//Mencari nama dan panjang kolom pertama (kode)
	$hsl1 = querydb("SELECT * FROM $tabel LIMIT 1"); 
	$klm1 = mysqli_fetch_field_direct($hsl1,0);
	//$hsl1 = $msysqli->query("SELECT * FROM $tabel LIMIT 1");
	//$klm1 = $hsl1->fetch_fields_direct(0);
	$klmNama1 = $klm1->name;
	$klmLenght1 = $klm1->length;
	
	$hsl22	= querydb("SELECT max(".$klmNama1.") FROM ".$tabel);
	//$hsl22   = querydb($qry2);
	$row	= arraydb($hsl22);
	
	if(empty($row[0])) {
		$angka=0;
	}
	else {
		$angka	= substr($row[0],strlen($inisial));
		//$angka = $row[0];;
	}
	
	$angka  = $angka + 1;
 	$angka	=strval($angka); 
	//Membuat angka 0 untuk mengisi digit yang kosong
 	$tmp	="";
 	for($i=1; $i<=($klmLenght1-strlen($inisial)-strlen($angka)); $i++) {
		$tmp=$tmp."0";	
	}
 	return $inisial.$tmp.$angka;
	//return $klmLenght1;
}


function unformat($angkaF){
	
	$angkaF	= trim($angkaF);
	if(isset ($angkaF))
	{	
		if($angkaF!='')
		{
			list($a1,$a2)=explode(",",$angkaF); //pisahkan menjadi 2, grup non decimal dengan decimal
			$x1 = str_replace(".","",$a1); //buang semua tanda titik pada grup non decimal 
			if($a2==''){$angkaUF=$x1;}else{$angkaUF=$x1.".".$a2;}
		}
		
	}
	
	return $angkaUF;
}

#fungsi untuk memperoleh no transaksi
function getNoTrans(){

	$qri = "SELECT * FROM trans_ctr ";
	$hsl = querydb($qri);
	$rek = arraydb($hsl);
		$noTrans = $rek['counter'];
		return $noTrans;
}

function updateNoTrans($no){
		
	$noTrans = trim($no);
	
	$qri = "UPDATE trans_ctr SET counter='$noTrans' WHERE id='1'";
	querydb($qri);
	
}	

function no_id($tabel){
	//Fungsi membuat no id dg menggunakan mysqlii_*
	$hsl = querydb("SELECT * FROM $tabel LIMIT 1"); 
	$klm = mysqli_fetch_field_direct($hsl,0);
	$klmNama = $klm->name;
	
	$qry	= querydb("SELECT max(".$klmNama.") FROM $tabel");
	$row	= arraydb($qry);
	
	if ($row[0]=="")
		{	
			$no_id=0;
		}	
		else 
		{
			$no_id	= ($row[0]);
		}
		$no_id++;
		$no_id=strval($no_id);
		
	return $no_id;
	
}

#fungsi untuk mengupdate data stok barang
function updateStockBarang($noTrans,$type){
	
	//$type=1 -> pembelian, type=2 -> penjualan
	
	$noTrans = trim($noTrans);
	$type = trim($type);	
	
	if($type==1){$tbl="pembelian_detail";$x=1;}else{$tbl="penjualan_detail";$x=-1;}
		
		$qri4 = "SELECT *,SUM(jumlah) AS ttl_item FROM $tbl WHERE no_transaksi='$noTrans' GROUP BY kd_barang";
		$hsl4 = querydb($qri4);
		while($rek4=arraydb($hsl4)){
			
			$qri5 = "SELECT * FROM stock_barang WHERE kd_barang='$rek4[kd_barang]'";	
			$hsl5 = querydb($qri5);
			$row5 = numrows($hsl5);
			$rek5 = arraydb($hsl5);
			$kd_barang = $rek5['kd_barang'];
			$tambahBarang = $rek4['ttl_item']*$x; //x=1 klau pembelian, x=-1 kalau penjualan.
			
			
			if($row5>0){
												
				$jmlStock = $rek5['jumlah'];
				$stockBaru = $jmlStock + $tambahBarang;
				
				//update stock baru
				$qri6="UPDATE stock_barang SET jumlah='$stockBaru' WHERE kd_barang='$kd_barang' ";
				$hsl6=querydb($qri6);
				//if(!$hsl6){$errors[] = $mysqli->error;}
							
			}else{
				if($type==1){
					$rowId = buatKode("stock_barang","");
					$qri6="INSERT INTO stock_barang (id,kd_barang,jumlah,hrg_beli_rata2) VALUES('$rowId','$rek4[kd_barang]','$tambahBarang','$rek4[harga]');";
					$hsl6 = querydb($qri6);
				}
			}
			
			IF($type==1){
				//hitung harga beli rata-rata
				$qri7 = "SELECT a.*, SUM(jumlah) AS ttlJumlah, SUM(sub_total) AS ttlHarga FROM pembelian_detail a WHERE kd_barang='$kd_barang'";
				$res7 = querydb($qri7);
				$rek7 = arraydb($res7);
					$ttlHarga = strval($rek7['ttlHarga']*1);
					$ttlJumlah= strval($rek7['ttlJumlah']*1);
					$hrgAvg = $ttlHarga/$ttlJumlah;
					
				//update harga rata-rata di table stock barang
				$qri8 = "UPDATE stock_barang SET hrg_beli_rata2='$hrgAvg' WHERE kd_barang='$kd_barang'";
				$res8 = querydb($qri8);	
			}	
		}	
		
			
	
	
}

#fungsi untuk mencari total penjualan di kasir. 
function ttlJual($user){
		
	$user=trim($user);	
	$qri="SELECT *,SUM(sub_total) AS ttl_jual FROM penjualan_tmp WHERE user='$user' ";
	$hsl=querydb($qri);
	$rek=arraydb($hsl);
	
	$ttlJual = $rek['ttl_jual'];
	return $ttlJual;
	
}	

# merubah tanggal format indonesia ke format database.
function tglsql($thn,$bln,$hri) {
	
	$stamp = mktime(11,59,59,$bln,$hri,$thn);
	$tanggal = date("Y-m-d",$stamp);
	return $tanggal;
}


# Fungsi untuk membalik tanggal dari format Indo (d-m-Y) -> English (Y-m-d)
function InggrisTgl($tanggal){
	$tgl=substr($tanggal,0,2);
	$bln=substr($tanggal,3,2);
	$thn=substr($tanggal,6,4);
	$tanggal="$thn-$bln-$tgl";
	return $tanggal;
}

# Fungsi untuk membalik tanggal dari format English (Y-m-d) -> Indo (d-m-Y)
function IndonesiaTgl($tanggal){
	$tgl=substr($tanggal,8,2);
	$bln=substr($tanggal,5,2);
	$thn=substr($tanggal,0,4);
	$tanggal="$tgl-$bln-$thn";
	return $tanggal;
}

// fungsi tidak digunakan //
# Fungsi untuk membalik tanggal dari format English (Y-m-d) -> Indo (d-m-Y)
function Indonesia2Tgl($tanggal){
	$namaBln = array("01" => "Januari", "02" => "Februari", "03" => "Maret", "04" => "April", "05" => "Mei", "06" => "Juni", 
					 "07" => "Juli", "08" => "Agustus", "09" => "September", "10" => "Oktober", "11" => "November", "12" => "Desember");
					 
	$tgl=substr($tanggal,8,2);
	$bln=substr($tanggal,5,2);
	$thn=substr($tanggal,0,4);
	$tanggal ="$tgl ".$namaBln[$bln]." $thn";
	return $tanggal;
}

function hitungHari($myDate1, $myDate2){
        $myDate1 = strtotime($myDate1);
        $myDate2 = strtotime($myDate2);
 
        return ($myDate2 - $myDate1)/ (24 *3600);
}

# Fungsi untuk membuat format rupiah pada angka (uang)
function format_angka($angka) {
	$hasil =  number_format($angka,0, ",",".");
	return $hasil;
}

# Fungsi untuk format tanggal, dipakai plugins Callendar
function form_tanggal($nama,$value=''){
	echo" <input type='text' name='$nama' id='$nama' size='11' maxlength='20' value='$value'/>&nbsp;
	<img src='images/calendar-add-icon.png' align='top' style='cursor:pointer; margin-top:7px;' alt='kalender'onclick=\"displayCalendar(document.getElementById('$nama'),'dd-mm-yyyy',this)\"/>			
	";
}

function angkaTerbilang($x){
  $abil = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
  if ($x < 12)
    return " " . $abil[$x];
  elseif ($x < 20)
    return angkaTerbilang($x - 10) . " belas";
  elseif ($x < 100)
    return angkaTerbilang($x / 10) . " puluh" . angkaTerbilang($x % 10);
  elseif ($x < 200)
    return " seratus" . angkaTerbilang($x - 100);
  elseif ($x < 1000)
    return angkaTerbilang($x / 100) . " ratus" . angkaTerbilang($x % 100);
  elseif ($x < 2000)
    return " seribu" . angkaTerbilang($x - 1000);
  elseif ($x < 1000000)
    return angkaTerbilang($x / 1000) . " ribu" . angkaTerbilang($x % 1000);
  elseif ($x < 1000000000)
    return angkaTerbilang($x / 1000000) . " juta" . angkaTerbilang($x % 1000000);
}
?>