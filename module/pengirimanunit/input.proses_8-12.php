<?php
include"../../conf/connect.php";
include "../../conf/fungsi_thumb.php";
include"../../conf/library.php";


//if(isset($_POST['save'])){
$param2=$_POST['unit'];

$param3=$_POST['warna'];

//if(isset($_POST['supplier'])){          
$params=$_POST['supplier'];
for($i=0; $i < count($params);$i++){
         $execute="insert into tb_pembelian (no_beli, ref_supplier_id, tb_unit_id, tanggal, norangka, nomesin, tahun, id_color, qty, total) 
             values ('". mysql_real_escape_string(trim(htmlentities($_POST['no_beli']))). "' ,
				'". mysql_real_escape_string(trim(htmlentities($params[$i]['id_supplier']))). "' ,
				'". mysql_real_escape_string(trim(htmlentities($param2[$i]["id"]))). "' ,
                 '$tgl_sekarang' ,
				 '". mysql_real_escape_string(trim(htmlentities($param2[$i]['noRangka']))). "' ,
				 '". mysql_real_escape_string(trim(htmlentities($param2[$i]['noMesin']))). "' ,
				 '". mysql_real_escape_string(trim(htmlentities($param2[$i]['tahun']))). "' ,
				 '". mysql_real_escape_string(trim(htmlentities($param3[$i]['id_color']))). "' ,
				 '". mysql_real_escape_string(trim(htmlentities($param2[$i]['kuantitas']))). "' ,
                 '". mysql_real_escape_string(trim(htmlentities($param2[$i]['jumlah']))) . "') ";
				echo $execute;
				$execute = mysql_query( $execute);
        // $lastId = mysql_insert_id(); 
         //
   
            
         //   $cari=mysql_query("SELECT sum(qty * harga) as harga FROM `tb_pembelian` WHERE id = '$lastId'");
         //   $r=  mysql_fetch_array($cari);
            
          //  mysql_query("update tb_pembelian set jumlah_tagihan='$r[harga]' where id='$lastId'");
}        
	
	if($execute){
                
                header('Location: ../../index.php?r=pembelian&page=view&status=sukses');
            }else{
                header('Location: ../../index.php?r=pembelian&page=view&status=gagal');
            }
   // else header('Location: ../../index.php?r=pembelian&page=view&status=gagal');
    

?>
