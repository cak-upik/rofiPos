<?php

include"../../conf/connect.php";
include "../../conf/fungsi_thumb.php";
include"../../conf/library.php";


$execute = mysql_query("insert into ref_leasing (name, addres, phone, subleasing, insentiveleasing, subadd) 
                     values (
                             '" . mysql_real_escape_string(trim(htmlentities($_POST['name']))) . "',
							 '" . mysql_real_escape_string(trim(htmlentities($_POST['addres']))) . "',
							 '" . mysql_real_escape_string(trim(htmlentities($_POST['phone']))) . "',
							 '" . mysql_real_escape_string(trim(htmlentities($_POST['subleasing']))) . "',
							 '" . mysql_real_escape_string(trim(htmlentities($_POST['insentiveleasing']))) . "',
                             '" . mysql_real_escape_string(trim(htmlentities($_POST['subadd']))) . "') ");
//$lastId = mysql_insert_id();	
if ($execute) {

    header('Location: ../../index.php?r=leasing&page=view&status=sukses');
} else {
    header('Location: ../../index.php?r=leasing&page=create&status=gagal');
}
?>
