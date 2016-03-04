<?php

include"../../conf/connect.php";
include "../../conf/fungsi_thumb.php";
include"../../conf/library.php";


$image = stripslashes($_FILES['image']['name']);
if ($image) {
    require_once "edit.proses.image.php";
} else {
    if ($_POST['password'] == '') {
        $edit = mysql_query("update tb_pegawai set 
                nama ='" . mysql_real_escape_string(trim(htmlentities($_POST['nama']))) . "' ,
                alamat ='" . mysql_real_escape_string(trim(htmlentities($_POST['alamat']))) . "' ,
                tempat ='" . mysql_real_escape_string(trim(htmlentities($_POST['tempat']))) . "' ,
                tgl_lahir ='" . mysql_real_escape_string(trim(htmlentities($_POST['tgl_lahir']))) . "' ,
                no_telp ='" . mysql_real_escape_string(trim(htmlentities($_POST['no_telp']))) . "' ,
                email ='" . mysql_real_escape_string(trim(htmlentities($_POST['email']))) . "' ,
                username ='" . mysql_real_escape_string(trim(htmlentities($_POST['username']))) . "' ,
                id_jabatan ='" . mysql_real_escape_string(trim(htmlentities($_POST['id_jabatan']))) . "' 
             where id_pegawai='$_POST[id_pegawai]'");
    } else {
        $edit = mysql_query("update tb_pegawai set 
                nama ='" . mysql_real_escape_string(trim(htmlentities($_POST['nama']))) . "' ,
                alamat ='" . mysql_real_escape_string(trim(htmlentities($_POST['alamat']))) . "' ,
                tempat ='" . mysql_real_escape_string(trim(htmlentities($_POST['tempat']))) . "' ,
                tgl_lahir ='" . mysql_real_escape_string(trim(htmlentities($_POST['tgl_lahir']))) . "' ,
                no_telp ='" . mysql_real_escape_string(trim(htmlentities($_POST['no_telp']))) . "' ,
                email ='" . mysql_real_escape_string(trim(htmlentities($_POST['email']))) . "' ,
                username ='" . mysql_real_escape_string(trim(htmlentities($_POST['username']))) . "' ,
                password ='" . mysql_real_escape_string(trim(htmlentities(base64_encode($_POST['password'])))) . "' ,
                id_jabatan ='" . mysql_real_escape_string(trim(htmlentities($_POST['id_jabatan']))) . "' 
             where id_pegawai='$_POST[id_pegawai]'");
    }

    if ($edit) {
        header('Location: ../../index.php?r=pegawai&page=view&status=sukses');
    } else {
        header('Location: ../../index.php?r=pegawai&page=view&status=gagal2');
    }
}
?>
