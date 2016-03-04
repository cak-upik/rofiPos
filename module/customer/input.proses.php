<?php

include"../../conf/connect.php";
include "../../conf/fungsi_thumb.php";
include"../../conf/library.php";


$execute = mysql_query("insert into ref_customer (name, alamat, phone, no_ktp, tempat_lahir, tanggal_lahir, pekerjaan) 
                     values (
                             '" . mysql_real_escape_string(trim(htmlentities($_POST['name']))) . "',
                            '" . mysql_real_escape_string(trim(htmlentities($_POST['alamat']))) . "',
                            '" . mysql_real_escape_string(trim(htmlentities($_POST['phone']))) . "',
                            '" . mysql_real_escape_string(trim(htmlentities($_POST['no_ktp']))) . "',
                            '" . mysql_real_escape_string(trim(htmlentities($_POST['tempat_lahir']))) . "',
                            '" . mysql_real_escape_string(trim(htmlentities($_POST['tanggal_lahir']))) . "',
                             '" . mysql_real_escape_string(trim(htmlentities($_POST['pekerjaan']))) . "') ");
//        echo $execute;
//        die();
//$lastId = mysql_insert_id();	
if ($execute) {

    header('Location: ../../index.php?r=customer&page=view&status=sukses');
} else {
    header('Location: ../../index.php?r=customer&page=view&status=gagal');
}
?>
