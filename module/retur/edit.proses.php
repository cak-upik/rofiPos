<?php

include"../../conf/connect.php";
include "../../conf/fungsi_thumb.php";
include"../../conf/library.php";

	$params=$_POST['retur'];
        $edit=  mysql_query("update tb_retur set 
                            nomor_retur ='". mysql_real_escape_string(trim(htmlentities($_POST['nomor_retur']))). "',
                            tanggal_retur ='". mysql_real_escape_string(trim(htmlentities($tgl_sekarang))). "',
                            jumlah_tagihan ='". mysql_real_escape_string(trim(htmlentities($_POST['jumlah_tagihan']))). "',
                            status ='complete'
                         where id_retur='$_POST[id_retur]'");
	                             		
        if($edit){
            foreach ($params['edit'] as $row5) {     
                    $cekqw=  mysql_fetch_array(mysql_query("select kuantitas from tb_detail_retur where id_retur='$_POST[id_retur]' 
                                                        and id_sparepart='$row5[id_sparepart]'"));
                    
                    mysql_query("update tb_stok set jumlah_stok = ( jumlah_stok +".$cekqw['kuantitas'].") -".$row5['kuantitas']."
                            where id_sparepart='$row5[id_sparepart]'");
                    
                    
                    $execute5=mysql_query("update tb_detail_retur set 
                            id_pemesanan_stok ='". mysql_real_escape_string(trim(htmlentities($_POST['id_pemesanan_stok']))). "',
                            id_sparepart ='". mysql_real_escape_string(trim(htmlentities($row5['id_sparepart']))). "',
                            kuantitas ='". mysql_real_escape_string(trim(htmlentities($row5['kuantitas']))). "',
                            harga ='". mysql_real_escape_string(trim(htmlentities($row5['harga']))). "',
                            keterangan ='". mysql_real_escape_string(trim(htmlentities($row5['keterangan']))). "'
                         where id_retur='$_POST[id_retur]' and id_sparepart='$row5[id_sparepart]' ");     
                    
                    
            }
            $cari=mysql_query("SELECT sum(kuantitas * harga) as harga FROM `tb_detail_retur` WHERE id_retur = '$_POST[id_retur]'");
            $r=  mysql_fetch_array($cari);
            
            mysql_query("update tb_retur set jumlah_tagihan='$r[harga]' where id_retur='$_POST[id_retur]'");
            
            if($execute5){
                if(isset($params['detail']) && isset($params['delete'])){
                    foreach ($params['detail'] as $row2) {         
                        $execute2=mysql_query("insert into tb_detail_retur (id_retur, id_pemesanan_stok, id_sparepart, kuantitas, harga, keterangan) 
                    values (
                        '" . mysql_real_escape_string(trim(htmlentities($_POST[id_retur]))) . "', 
                        '". mysql_real_escape_string(trim(htmlentities($_POST['id_pemesanan_stok']))). "' ,
                        '". mysql_real_escape_string(trim(htmlentities($row2['id_sparepart']))). "' ,
                        '" . mysql_real_escape_string(trim(htmlentities($row2['kuantitas']))) . "',
                        '" . mysql_real_escape_string(trim(htmlentities($row2['harga']))) . "',
                        '" . mysql_real_escape_string(trim(htmlentities($row2['keterangan']))) . "' ) ");    
            
                        mysql_query("update tb_stok set 
                                        jumlah_stok = jumlah_stok -'".$row2['kuantitas']."'
                                     where id_sparepart='$row2[id_sparepart]'");  
                    }

                    foreach ($params['delete'] as $row) {         
                        $execute1=mysql_query("delete from tb_detail_retur where id_sparepart='$row[id_sparepart]' 
                                and id_retur='$_POST[id_retur]'");
                        //}
                            mysql_query("update tb_stok set 
                                        jumlah_stok = jumlah_stok +'".$row['kuantitas']."'
                                     where id_sparepart='$row[id_sparepart]'");
                    }

                    if($execute1){
                            $cari3=mysql_query("SELECT sum(kuantitas * harga) as harga FROM `tb_detail_retur` WHERE id_retur = '$_POST[id_retur]'");
                            $r3=  mysql_fetch_array($cari3);

                            mysql_query("update tb_retur set jumlah_tagihan='$r3[harga]' where id_retur='$_POST[id_retur]'");
                            //header('Location: ../../index.php?r=retur&page=view&status=edited');
                            
                        if($execute2){
                            $cari5=mysql_query("SELECT sum(kuantitas * harga) as harga FROM `tb_detail_retur` WHERE id_retur = '$_POST[id_retur]'");
                            $r5=  mysql_fetch_array($cari5);

                            mysql_query("update tb_retur set jumlah_tagihan='$r5[harga]' where id_retur='$_POST[id_retur]'");
                            header('Location: ../../index.php?r=retur&page=view&status=edited');
                        }else{
                            header('Location: ../../index.php?r=retur&page=view&status=gagal2');
                        }       
                    }
                    else header('Location: ../../index.php?r=retur&page=view&status=gagal1');
                }

                elseif(isset($params['delete'])){
                    foreach ($params['delete'] as $row) {
                        //if($row['delId'] > 1){
                            $execute1=mysql_query("delete from tb_detail_retur where id_sparepart='$row[id_sparepart]' 
                                and id_retur='$_POST[id_retur]'");
                        //}
                            mysql_query("update tb_stok set 
                                        jumlah_stok = jumlah_stok +'".$row['kuantitas']."'
                                     where id_sparepart='$row[id_sparepart]'");
                    }
                    if($execute1){            
                            $cari3=mysql_query("SELECT sum(kuantitas * harga) as harga FROM `tb_detail_retur` WHERE id_retur = '$_POST[id_retur]'");
                            $r3=  mysql_fetch_array($cari3);

                            mysql_query("update tb_retur set jumlah_tagihan='$r3[harga]' where id_retur='$_POST[id_retur]'");
                            header('Location: ../../index.php?r=retur&page=view&status=edited');
                    }
                    else header('Location: ../../index.php?r=retur&page=view&status=gagal1');
                }

                elseif(isset($params['detail'])){
                    foreach ($params['detail'] as $row2) {         
                        $execute2=mysql_query("insert into tb_detail_retur (id_retur, id_pemesanan_stok, id_sparepart, kuantitas, harga, keterangan) 
                    values (
                        '" . mysql_real_escape_string(trim(htmlentities($_POST[id_retur]))) . "', 
                        '". mysql_real_escape_string(trim(htmlentities($_POST['id_pemesanan_stok']))). "' ,
                        '". mysql_real_escape_string(trim(htmlentities($row2['id_sparepart']))). "' ,
                        '" . mysql_real_escape_string(trim(htmlentities($row2['kuantitas']))) . "',
                        '" . mysql_real_escape_string(trim(htmlentities($row2['harga']))) . "',
                        '" . mysql_real_escape_string(trim(htmlentities($row2['keterangan']))) . "' ) ");    
            
                        mysql_query("update tb_stok set 
                                        jumlah_stok = jumlah_stok -'".$row2['kuantitas']."'
                                     where id_sparepart='$row2[id_sparepart]'");

                        
                    }
                    if($execute2){    
                            $cari5=mysql_query("SELECT sum(kuantitas * harga) as harga FROM `tb_detail_retur` WHERE id_retur = '$_POST[id_retur]'");
                            $r5=  mysql_fetch_array($cari5);

                            mysql_query("update tb_retur set jumlah_tagihan='$r5[harga]' where id_retur='$_POST[id_retur]'");
                            header('Location: ../../index.php?r=retur&page=view&status=edited');
                    }
                    else header('Location: ../../index.php?r=retur&page=view&status=gagal1');
                }else header('Location: ../../index.php?r=retur&page=view&status=edited');
            }
            else header('Location: ../../index.php?r=retur&page=view&status=gagal');
            
        }else{
                header('Location: ../../index.php?r=retur&page=view&status=gagal');
        }                        		
    

?>
