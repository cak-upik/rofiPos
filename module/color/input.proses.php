<?php

include"../../conf/connect.php";
include "../../conf/fungsi_thumb.php";
include"../../conf/library.php";

$execute = mysql_query("insert into ref_color (name) 
                     values ('" . mysql_real_escape_string(trim(htmlentities($_POST['name']))) . "') ");
if ($execute) {

    header('Location: ../../index.php?r=color&page=view&status=sukses');
} else {
    header('Location: ../../index.php?r=color&page=view&status=gagal');
}