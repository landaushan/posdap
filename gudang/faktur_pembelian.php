<?php

if(session_status()!==2)session_start();//>=php 5.4
if(!isset($_SESSION['SES_LOGIN'])){
	header('location:../home');
 }
require_once "../library/inc.connection.php";
require_once "../library/inc.library.php";
$user_id=$_SESSION['SES_LOGIN'];
opendb();

IF(isset($_GET['no_faktur'])){
	
	$noFaktur = trim($_GET['no_faktur']);
	
	$qri="SELECT * FROM pembelian WHERE no_faktur='$noFaktur'";
	$hsl=querydb($qri);
	$rek=arraydb($hsl);
		$noTrans = $rek['no_transaksi'];
		$kdSupplier = $rek['kd_supplier'];
		$tglBeli = $rek['tgl_pembelian'];
			$tglBeli2=IndonesiaTgl($tglBeli);
			$tglNota =Indonesia2Tgl($tglBeli);
		$ttlBeli = $rek['total_pembelian'];
		$userId = $rek['id_user'];
	
	//cari data supplier
	$qri2 = "SELECT * FROM ma_supplier WHERE kd_supplier='$kdSupplier'";
	$hsl2 = querydb($qri2);
	$rek2 = arraydb($hsl2);
		$nmSupplier = $rek2['nm_supplier'];
		$kontak = $rek2['atas_nama'];
		
	//cari data pembelian detail
	$qri3 = "SELECT a.*,b.nm_barang,b.kd_satuan,c.nm_satuan 
			FROM pembelian_detail a 
			LEFT JOIN ma_barang b ON b.kd_barang=a.kd_barang 
			LEFT JOIN ma_satuan_barang c ON c.kd_satuan=b.kd_satuan 
			WHERE a.no_transaksi='$noTrans'";
	$hsl3 = querydb($qri3);
	
	//cari data toko
	$qri4 = "SELECT kota FROM ma_toko";
	$hsl4 = querydb($qri4);
	$rek4 = arraydb($hsl4);
		$kota = $rek4['kota'];
	
}	



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
#faktur{
	height: 465px; width: 100%; overflow: scroll;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;}
#tabel_faktur{
	background-color: #FFF; margin-top: 20px;}
.tr_info{
	color: #000; font-weight: bold;}
.tr_header_footer{
	color: #000; font-weight: bold;
	background-color: #CCC;}
.tr_item{
	color: #000; background-color: #FFF;}
</style>
</head>

<body onload="print();window.close(); return false">
<div id="faktur"><table width="500" border="0" align="center" id="tabel_faktur">
  <tr>
    <td width="66"><span class="tr_info">NO FAKTUR</span></td>
    <td width="10"><span class="tr_info">:</span></td>
    <td width="163"><?php echo $noFaktur; ?>&nbsp;</td>
    <td width="89"><span class="tr_info">KODE SUPPLIER</span></td>
    <td width="10"><span class="tr_info">:</span></td>
    <td width="136"><?php echo $kdSupplier; ?>&nbsp;</td>
  </tr>
  <tr>
    <td><span class="tr_info">TGL FAKTUR</span></td>
    <td><span class="tr_info">:</span></td>
    <td><?php echo $tglBeli2; ?>&nbsp;</td>
    <td><span class="tr_info">SUPPLIER</span></td>
    <td><span class="tr_info">:</span></td>
    <td><?php echo $nmSupplier; ?>&nbsp;</td>
  </tr>
  <tr>
    <td><span class="tr_info">ID USER</span></td>
    <td><span class="tr_info">:</span></td>
    <td><?php echo $userId; ?>&nbsp;</td>
    <td><span class="tr_info">ATAS NAMA</span></td>
    <td><span class="tr_info">:</span></td>
    <td><?php echo $kontak; ?>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="6"><table width="100%" border="0" align="center">
      <tr class="tr_header_footer">
        <td><div align="center">Kode Barang </div></td>
        <td><div align="center">Nama Barang </div></td>
        <td><div align="center">Satuan</div></td>
        <td><div align="center">Jumlah</div></td>
        <td><div align="center">Harga</div></td>
        <td><div align="center">Sub Total </div></td>
      </tr>
      <?php 
$total_item=0;
while($rek3=arraydb($hsl3)){
$kd_brg=$rek3['kd_barang'];
$nm_brg=$rek3['nm_barang'];
$sat=$rek3['nm_satuan'];
$jml=$rek3['jumlah'];
$hrg=$rek3['harga'];
$sub_ttl=$rek3['sub_total'];
$total_item=$jml+$total_item;
	  ?>
      <tr class="tr_item">
        <td><?php echo $kd_brg; ?>&nbsp;</td>
        <td><?php echo $nm_brg; ?>&nbsp;</td>
        <td><div align="left"><?php echo $sat; ?>&nbsp;</div></td>
        <td><div align="center"><?php echo $jml; ?>&nbsp;</div></td>
        <td align="center"><?php echo number_format($hrg,0,",","."); ?></td>
        <td align="right"><?php echo number_format($sub_ttl,0,",","."); ?></td>
      </tr>
<?php } ?>
      <tr class="tr_header_footer">
        <td>TOTAL</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><div align="center"><?php echo $total_item ?>&nbsp;Items</div></td>
        <td>&nbsp;</td>
        <td align="right"><?php echo number_format($ttlBeli,0,",","."); ?></td>
      </tr>
      <tr class="tr_info">
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="3"><div align="center"><?=$kota?>,&nbsp;<?php echo $tglNota; ?></div>          </td>
      </tr>
      <tr class="tr_info">
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="3"><div align="center">TTD</div></td>
      </tr>
      <tr class="tr_info">
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="3"><p align="center">&nbsp;</p>
				<p>&nbsp;</p>
          <p>&nbsp;</p>
          
          <p align="center">(____________________ )</p></td>
        </tr>
    </table></td>
    </tr>
</table>
</div>
</body>
</html>