<?php
include"../../conf/connect.php";
include "../../conf/fungsi_thumb.php";
include"../../conf/library.php";


    $params=$_POST['po'];
    
         
         $execute=mysql_query("insert into tb_pemesanan_stok (no_faktur, id_suplier, tanggal, jumlah_tagihan, id_pegawai) 
             values ('". mysql_real_escape_string(trim(htmlentities($_POST['no_faktur']))). "' ,
                 '". mysql_real_escape_string(trim(htmlentities($_POST['id_suplier']))). "' ,
                 '$tgl_sekarang' ,
                 '0' ,
                 '" . mysql_real_escape_string(trim(htmlentities($_POST['id_pegawai']))) . "') ");
         $lastId = mysql_insert_id();
    
    if($execute){
        foreach ($params['detail'] as $row2) {
            $execute1=mysql_query("insert into tb_detail_pemesanan_stok (id_sparepart, id_pemesanan_stok, kuantitas, harga, keterangan) 
                    values ('". mysql_real_escape_string(trim(htmlentities($row2[productId]))). "' ,
                        '" . mysql_real_escape_string(trim(htmlentities($lastId))) . "', 
                        '" . mysql_real_escape_string(trim(htmlentities($row2['quantity']))) . "',
                        '" . mysql_real_escape_string(trim(htmlentities($row2['price']))) . "',
                        '" . mysql_real_escape_string(trim(htmlentities($row2['remark']))) . "' ) ");      
            
            $cari=mysql_query("SELECT sum(kuantitas * harga) as harga FROM `tb_detail_pemesanan_stok` WHERE id_pemesanan_stok = '$lastId'");
            $r=  mysql_fetch_array($cari);
            
            mysql_query("update tb_pemesanan_stok set jumlah_tagihan='$r[harga]' where id_pemesanan_stok='$lastId'");
        }
        if($execute1){
            header('Location: ../../index.php?r=po&page=view&status=sukses');
        }
        else header('Location: ../../index.php?r=po&page=view&status=gagal');
    }
    else header('Location: ../../index.php?r=po&page=view&status=gagal');
    

?>
