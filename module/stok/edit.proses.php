<?php

include"../../conf/connect.php";
include "../../conf/fungsi_thumb.php";
include"../../conf/library.php";

	  
        $edit=  mysql_query("update tb_mekanik set 
                            nama ='". mysql_real_escape_string(trim(htmlentities($_POST['nama']))). "',
                             alamat ='". mysql_real_escape_string(trim(htmlentities($_POST['alamat']))). "',
                             no_telp ='". mysql_real_escape_string(trim(htmlentities($_POST['no_telp']))). "'
                         where id_mekanik='$_POST[id_mekanik]'");
	                             		
        if($edit){
                header('Location: ../../index.php?r=mekanik&page=view&status=sukses');
        }else{
                header('Location: ../../index.php?r=mekanik&page=view&status=gagal');
        }                        		
    

?>
