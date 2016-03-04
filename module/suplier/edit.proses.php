<?php

include"../../conf/connect.php";
include "../../conf/fungsi_thumb.php";
include"../../conf/library.php";

	  
        $edit=  mysql_query("update ref_supplier set 
                            name ='". mysql_real_escape_string(trim(htmlentities($_POST['name']))). "',
							addres ='". mysql_real_escape_string(trim(htmlentities($_POST['addres']))). "',
                            phone ='". mysql_real_escape_string(trim(htmlentities($_POST['phone']))). "'
                         where id_supplier='$_POST[id_supplier]'");
	                             		
        if($edit){
                header('Location: ../../index.php?r=suplier&page=view&status=sukses');
        }else{
                header('Location: ../../index.php?r=suplier&page=view&status=gagal2');
        }                        		
    

?>
