<?php

if(!empty($_GET['open'])){$open=trim($_GET['open']);}else{$open="";}


	switch($open)  
	{
		case '' : include 'index.php'; break;
		case 'home' : include 'home.php'; break;
		case 'pembelian' : include 'gudang/pembelian.php'; break;
		case 'stock' : include 'gudang/stok_barang.php'; break;
		
		case 'penjualan' : include 'kasir/penjualan.php'; break;
		case 'setoran' : include 'kasir/setoran_kasir.php'; break;
		
		
		case 'toko_data' : include 'data_master/toko_data.php'; break;
		case 'user_data' : include 'data_master/user_data.php'; break;
		case 'barang_data' : include 'data_master/barang_data.php'; break;
		case 'kategori_data' : include 'data_master/kategori_data.php'; break;
		case 'satuan_data' : include 'data_master/satuan_data.php'; break;
		case 'supplier_data' : include 'data_master/supplier_data.php'; break;
		case 'customer_data' : include 'data_master/customer_data.php'; break;
		
		case 'logout' : include 'logout.php'; break;
		
		
	}


?>
