<?php
include"../../conf/connect.php";
include "../../conf/fungsi_thumb.php";
include"../../conf/library.php";


    $params=$_POST['retur'];
    
         
         $execute=mysql_query("insert into tb_retur (nomor_retur, tanggal_retur, jumlah_tagihan, status) 
             values ('". mysql_real_escape_string(trim(htmlentities($_POST['no_retur']))). "' ,
                 '$tgl_sekarang' ,
                 '0' ,
                 'complete') ");
         $lastId = mysql_insert_id();
    
    if($execute){
        foreach ($params['detail'] as $row2) {
            $execute1=mysql_query("insert into tb_detail_retur (id_retur, id_pemesanan_stok, id_sparepart, kuantitas, harga, keterangan) 
                    values (
                        '" . mysql_real_escape_string(trim(htmlentities($lastId))) . "', 
                        '". mysql_real_escape_string(trim(htmlentities($_POST['id_pemesanan_stok']))). "' ,
                        '". mysql_real_escape_string(trim(htmlentities($row2['id_sparepart']))). "' ,
                        '" . mysql_real_escape_string(trim(htmlentities($row2['kuantitas']))) . "',
                        '" . mysql_real_escape_string(trim(htmlentities($row2['harga']))) . "',
                        '" . mysql_real_escape_string(trim(htmlentities($row2['keterangan']))) . "' ) ");    
            
            mysql_query("update tb_stok set 
                            jumlah_stok = jumlah_stok -'".$row2['kuantitas']."'
                         where id_sparepart='$row2[id_sparepart]'");
            
            $cari=mysql_query("SELECT sum(kuantitas * harga) as harga FROM `tb_detail_retur` WHERE id_retur = '$lastId'");
            $r=  mysql_fetch_array($cari);
            
            mysql_query("update tb_retur set jumlah_tagihan='$r[harga]' where id_retur='$lastId'");
        }
        if($execute1){
            
            header('Location: ../../index.php?r=retur&page=view&status=sukses');
        }
        else header('Location: ../../index.php?r=retur&page=view&status=gagal');
    }
    else header('Location: ../../index.php?r=retur&page=view&status=gagal');
    

?>
