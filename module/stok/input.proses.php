<?php
include"../../conf/connect.php";
include "../../conf/fungsi_thumb.php";
include"../../conf/library.php";


        $execute=mysql_query("insert into tb_mekanik (nama, alamat, no_telp) 
                     values (
                             '". mysql_real_escape_string(trim(htmlentities($_POST['nama']))) . "',
                             '". mysql_real_escape_string(trim(htmlentities($_POST['alamat']))) . "',
                             '". mysql_real_escape_string(trim(htmlentities($_POST['no_telp']))) . "') ");
       //$lastId = mysql_insert_id();	
            if($execute){
                
                header('Location: ../../index.php?r=mekanik&page=create&status=sukses');
            }else{
                header('Location: ../../index.php?r=mekanik&page=create&status=gagal');
            }
    

?>
