<?php

 if(!isset($_SESSION['SES_LOGIN'])){
	header('location:home');
 }
require_once "library/inc.connection.php";
require_once "library/inc.library.php";
opendb();
//cari data toko
   $qri = "SELECT * FROM ma_toko";
   $res = querydb($qri);
   $rec = arraydb($res);
   $namaToko = $rec['nm_toko'];
   $alamatToko = $rec['almt_toko'];
   $kota = $rec['kota'];
   $logoToko   = $rec['logo'];
   $telpToko   = $rec['tlp_toko'];
   $faxToko   = $rec['fax_toko'];
?>	
    
	

	<div class="row">
        <div class="span12">
          <div class="widget">
            <div class="widget-header"> <i class="icon-copy"></i>
              <h3>Data Master</h3>
            </div>
            <!-- /widget-header -->
            <div class="widget-content">
              <div class="shortcuts"> 

                <a href="?open=toko_data" class="shortcut">
                  <i class="shortcut-icon icon-home"></i>
                  <span class="shortcut-label">Data Toko</span> 
                </a>

                <a href="?open=user_data" class="shortcut">
                  <i class="shortcut-icon icon-user"></i>
                  <span class="shortcut-label">Data User</span> 
                </a>

                <a href="?open=barang_data" class="shortcut">
                  <i class="shortcut-icon icon-list-alt"></i>
                  <span class="shortcut-label">Data Barang</span> 
                </a>

                <a href="?open=kategori_data" class="shortcut">
                  <i class="shortcut-icon icon-asterisk"></i>
                  <span class="shortcut-label">Data Kategori Barang</span> 
                </a>

                <a href="?open=satuan_data" class="shortcut">
                  <i class="shortcut-icon icon-copy"></i>
                  <span class="shortcut-label">Data Satuan Barang</span> 
                </a>

                <a href="?open=supplier_data" class="shortcut">
                  <i class="shortcut-icon icon-paper-clip"></i>
                  <span class="shortcut-label">Data Supplier</span> 
                </a>


              </div>
              <!-- /shortcuts --> 
            </div>
            <!-- /widget-content --> 
          </div>
        </div>
        <!-- span -->
      </div>



	
