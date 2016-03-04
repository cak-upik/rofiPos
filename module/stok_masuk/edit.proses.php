<?php

include"../../conf/connect.php";
include "../../conf/fungsi_thumb.php";
include"../../conf/library.php";
include"service.php";

	$params=$_POST['ro'];
            
            foreach ($params['edit'] as $row5) {
                $cekqw=  mysql_fetch_array(mysql_query("select kuantitas from tb_detail_stok_masuk where id_stok_masuk='$_POST[id_stok_masuk]' 
                                                        and id_sparepart='$row5[id_sparepart]'"));
                mysql_query("update tb_stok set jumlah_stok = ( jumlah_stok -".$cekqw['kuantitas'].") +".$row5['kuantitas']."
                            where id_sparepart='$row5[id_sparepart]'");
                
                $execute5=mysql_query("update tb_detail_stok_masuk set 
                                    kuantitas ='". mysql_real_escape_string(trim(htmlentities($row5['kuantitas']))). "'
                                    where id_stok_masuk='$_POST[id_stok_masuk]' and id_sparepart='$row5[id_sparepart]' ");     
            }
            
            if($execute5){
                if(isset($params['detail']) && isset($params['delete'])){
                    foreach ($params['detail'] as $row2) {        
                        $execute2=mysql_query("insert into tb_detail_stok_masuk (id_sparepart, id_stok_masuk, kuantitas) 
                                            values ('". mysql_real_escape_string(trim(htmlentities($row2['id_sparepart']))). "' ,
                                            '" . mysql_real_escape_string(trim(htmlentities($_POST[id_stok_masuk]))) . "', 
                                            '" . mysql_real_escape_string(trim(htmlentities($row2['kuantitas']))) . "' ) ");    
                        
                        $check=isExist($row2['id_sparepart']);
                        if($check == 0){
                            $execute2=  mysql_query("insert into tb_stok (id_sparepart, jumlah_stok, keterangan) 
                                values ('". mysql_real_escape_string(trim(htmlentities($row2[id_sparepart]))). "' ,
                                    '" . mysql_real_escape_string(trim(htmlentities($row2['kuantitas']))) . "', 
                                    ' ' ) ");
                        }else{
                            $execute2=  mysql_query("update tb_stok set 
                                        jumlah_stok = jumlah_stok +'".$row2['kuantitas']."'
                                     where id_sparepart='$row2[id_sparepart]'");
                        }
                    }

                    foreach ($params['delete'] as $row) {         
                        $execute1=mysql_query("delete from tb_detail_stok_masuk where id_sparepart='$row[id_sparepart]' 
                            and id_stok_masuk='$_POST[id_stok_masuk]'");
                        
                        mysql_query("update tb_stok set 
                                    jumlah_stok = jumlah_stok -'".$row['kuantitas']."'
                                    where id_sparepart='$row[id_sparepart]'");
                    }

                    if($execute1){
                        if($execute2){
                            header('Location: ../../index.php?r=ro&page=view&status=edited');
                        }else{
                            header('Location: ../../index.php?r=ro&page=view&status=gagal2');
                        }       
                    }
                    else header('Location: ../../index.php?r=ro&page=view&status=gagal1');
                }

                elseif(isset($params['delete'])){
                    foreach ($params['delete'] as $row) {
                        $execute1=mysql_query("delete from tb_detail_stok_masuk where id_sparepart='$row[id_sparepart]' 
                            and id_stok_masuk='$_POST[id_stok_masuk]'");
                        
                        mysql_query("update tb_stok set 
                                    jumlah_stok = jumlah_stok -'".$row['kuantitas']."'
                                    where id_sparepart='$row[id_sparepart]'");
                    }
                    if($execute1){  
                            header('Location: ../../index.php?r=ro&page=view&status=edited');
                    }
                    else header('Location: ../../index.php?r=ro&page=view&status=gagal1');
                }

                elseif(isset($params['detail'])){
                    foreach ($params['detail'] as $row2) {         
                        $execute2=mysql_query("insert into tb_detail_stok_masuk (id_sparepart, id_stok_masuk, kuantitas) 
                                            values ('". mysql_real_escape_string(trim(htmlentities($row2['id_sparepart']))). "' ,
                                            '" . mysql_real_escape_string(trim(htmlentities($_POST[id_stok_masuk]))) . "', 
                                            '" . mysql_real_escape_string(trim(htmlentities($row2['kuantitas']))) . "' ) ");  
                        
                        $check=isExist($row2['id_sparepart']);
                        if($check == 0){
                            $execute2=  mysql_query("insert into tb_stok (id_sparepart, jumlah_stok, keterangan) 
                                values ('". mysql_real_escape_string(trim(htmlentities($row2[id_sparepart]))). "' ,
                                    '" . mysql_real_escape_string(trim(htmlentities($row2['kuantitas']))) . "', 
                                    ' ' ) ");
                        }else{
                            $execute2=  mysql_query("update tb_stok set 
                                        jumlah_stok = jumlah_stok +'".$row2['kuantitas']."'
                                     where id_sparepart='$row2[id_sparepart]'");
                        }
                    }
                    if($execute2){    
                            header('Location: ../../index.php?r=ro&page=view&status=edited');
                    }
                    else header('Location: ../../index.php?r=ro&page=view&status=gagal1');
                }else header('Location: ../../index.php?r=ro&page=view&status=edited');
            }
            else header('Location: ../../index.php?r=ro&page=view&status=gagal');
                           		
    

?>
