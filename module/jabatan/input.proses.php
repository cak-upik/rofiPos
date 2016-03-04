<?php

include"../../conf/connect.php";
include "../../conf/fungsi_thumb.php";
include"../../conf/library.php";


$execute = mysql_query("insert into tb_jabatan (nama_jabatan, gaji_pokok) 
                     values (
                             '" . mysql_real_escape_string(trim(htmlentities($_POST['nama_jabatan']))) . "',
                             '" . mysql_real_escape_string(trim(htmlentities($_POST['gaji_pokok']))) . "') ");
//$lastId = mysql_insert_id();	
if ($execute) {

    header('Location: ../../index.php?r=jabatan&page=view&status=sukses');
} else {
    header('Location: ../../index.php?r=jabatan&page=create&status=gagal');
}
?>
