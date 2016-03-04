<?php

include"../../conf/connect.php";
include "../../conf/fungsi_thumb.php";
include"../../conf/library.php";


$edit = mysql_query("update tb_jabatan set 
                            nama_jabatan ='" . mysql_real_escape_string(trim(htmlentities($_POST['nama_jabatan']))) . "',
                            gaji_pokok ='" . mysql_real_escape_string(trim(htmlentities($_POST['gaji_pokok']))) . "'
                         where id_jabatan='$_POST[id_jabatan]'");

if ($edit) {
    header('Location: ../../index.php?r=jabatan&page=view&status=sukses');
} else {
    header('Location: ../../index.php?r=jabatan&page=view&status=gagal');
}
?>
