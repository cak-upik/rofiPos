<?php

include"../../conf/connect.php";
include "../../conf/fungsi_thumb.php";
include"../../conf/library.php";


$edit = mysql_query("update tb_hak_akses set 
                            hak_akses ='" . mysql_real_escape_string(trim(htmlentities($_POST['hak_akses']))) . "'
                         where id_hak_akses='$_POST[id_hak_akses]'");

if ($edit) {
    header('Location: ../../index.php?r=hak_akses&page=view&status=sukses');
} else {
    header('Location: ../../index.php?r=hak_akses&page=view&status=gagal');
}

