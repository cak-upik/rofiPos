<?php

include"../../conf/connect.php";
include "../../conf/fungsi_thumb.php";
include"../../conf/library.php";


$execute = mysql_query("insert into tb_hak_akses (hak_akses) 
                     values (
                             '" . mysql_real_escape_string(trim(htmlentities($_POST['hak_akses']))) . "') ");
//$lastId = mysql_insert_id();	
if ($execute) {

    header('Location: ../../index.php?r=hak_akses&page=view&status=sukses');
} else {
    header('Location: ../../index.php?r=hak_akses&page=view&status=gagal');
}

