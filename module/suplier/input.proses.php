<?php

include"../../conf/connect.php";
include "../../conf/fungsi_thumb.php";
include"../../conf/library.php";


$execute = mysql_query("insert into ref_supplier (name, addres, phone) 
                     values (
                             '" . mysql_real_escape_string(trim(htmlentities($_POST['name']))) . "',
							 '" . mysql_real_escape_string(trim(htmlentities($_POST['addres']))) . "',
                             '" . mysql_real_escape_string(trim(htmlentities($_POST['phone']))) . "') ");
//$lastId = mysql_insert_id();	
if ($execute) {

    header('Location: ../../index.php?r=suplier&page=view&status=sukses');
} else {
    header('Location: ../../index.php?r=suplier&page=view&status=gagal');
}
