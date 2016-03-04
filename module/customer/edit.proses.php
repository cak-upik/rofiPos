<?php

include"../../conf/connect.php";
include"../../conf/fungsi_thumb.php";
include"../../conf/library.php";


//
//$edit = mysql_query(
//        "update ref_customer set 
//                            name ='" . mysql_real_escape_string(trim(htmlentities($_POST['name']))) . "',
//                            alamat ='" . mysql_real_escape_string(trim(htmlentities($_POST['alamat']))) . "',
//                            phone ='" . mysql_real_escape_string(trim(htmlentities($_POST['phone']))) . "'
//                            no_ktp ='" . mysql_real_escape_string(trim(htmlentities($_POST['no_ktp']))) . "'
//                            tempat_lahir ='" . mysql_real_escape_string(trim(htmlentities($_POST['tempat_lahir']))) . "'
//                            tanggal_lahir ='" . mysql_real_escape_string(trim(htmlentities($_POST['tanggal_lahir']))) . "'
//                            pekerjaan ='" . mysql_real_escape_string(trim(htmlentities($_POST['pekerjaan']))) . "'
//                         where id_customer='" . $_POST['id_customer'] . "'");

$edit = mysql_query("UPDATE `ref_customer` SET `name` = '" . mysql_real_escape_string(trim(htmlentities($_POST[name]))) . "',
                    `alamat` = '" . mysql_real_escape_string(trim(htmlentities($_POST[alamat]))) . "',
                    `phone` = '" . mysql_real_escape_string(trim(htmlentities($_POST[phone]))) . "',
                    `no_ktp` = '" . mysql_real_escape_string(trim(htmlentities($_POST[no_ktp]))) . "',
                    `tempat_lahir` = '" . mysql_real_escape_string(trim(htmlentities($_POST[tempat_lahir]))) . "',
                    `tanggal_lahir` = '" . mysql_real_escape_string(trim(htmlentities($_POST[tanggal_lahir]))) . "',
                    `pekerjaan` = '" . mysql_real_escape_string(trim(htmlentities($_POST[pekerjaan]))) . "' WHERE `id_customer` ='$_POST[id_customer]'");

if ($edit) {
    header('location: ../../index.php?r=customer&page=view&status=sukses');
} else {
    header('location: ../../index.php?r=customer&page=view&status=gagal');
}