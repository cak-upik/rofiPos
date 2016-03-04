<?php

include"../../conf/connect.php";
include "../../conf/fungsi_thumb.php";
include"../../conf/library.php";

$query = "update detail_penjualan set subsidi = '" . mysql_real_escape_string(trim(htmlentities($_POST['subsidi']))) . "',
                            tambah_subsidi = '" . mysql_real_escape_string(trim(htmlentities($_POST['tambah_subsidi']))) . "',
                            `real` = '" . mysql_real_escape_string(trim(htmlentities($_POST['real']))) . "',
                            profit = '" . mysql_real_escape_string(trim(htmlentities($_POST['profit']))) . "',
                            up_price = '" . mysql_real_escape_string(trim(htmlentities($_POST['up_price']))) . "',
                            diskon_stsj = '" . mysql_real_escape_string(trim(htmlentities($_POST['diskon_stsj']))) . "',
                            insentif = '" . mysql_real_escape_string(trim(htmlentities($_POST['insentif']))) . "',
                            hadiah = '" . mysql_real_escape_string(trim(htmlentities($_POST['hadiah']))) . "',
                            jaket = '" . mysql_real_escape_string(trim(htmlentities($_POST['jaket']))) . "',
                            lain_lain = '" . mysql_real_escape_string(trim(htmlentities($_POST['lain_lain']))) . "',
                            bonus = '" . mysql_real_escape_string(trim(htmlentities($_POST['bonus']))) . "',
                            laba_kotor = '" . mysql_real_escape_string(trim(htmlentities($_POST['laba_kotor']))) . "',
                            average = '" . mysql_real_escape_string(trim(htmlentities($_POST['average']))) . "'
                            where id_penjualan = '" . mysql_real_escape_string(trim(htmlentities($_POST['id_penjualan']))) . "' and 
                            id_detail_penjualan = '" . mysql_real_escape_string(trim(htmlentities($_POST['id_detail']))) . "'";

$result = mysql_query($query);

if ($result) {
    header('Location: ../../index.php?r=lap_penjualan&page=laba&status=edited');
} else {
    header('Location: ../../index.php?r=lap_penjualan&page=laba&status=gagal');
}        
