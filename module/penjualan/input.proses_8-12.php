<?php

include"../../conf/connect.php";
include "../../conf/fungsi_thumb.php";
include"../../conf/library.php";

$param = $_POST['unit'];
$execute = mysql_query("insert into tb_penjualan (no_jual, id_customer, ref_unit_id, ref_leasing_id, date, hargaotr, kuantiti, uangmuka, disc, nett ) 
                     values (
                             '" . mysql_real_escape_string(trim(htmlentities($_POST['no_jual']))) . "',
                             '" . mysql_real_escape_string(trim(htmlentities($_POST['id_customer']))) . "',
                             '" . mysql_real_escape_string(trim(htmlentities($_POST['ref_unit_id']))) . "',
                             '" . mysql_real_escape_string(trim(htmlentities($_POST['ref_leasing_id']))) . "',
                             '" . $tgl_sekarang . "',
                             '" . mysql_real_escape_string(trim(htmlentities($_POST['hargaotr']))) . "',
                             '" . mysql_real_escape_string(trim(htmlentities($_POST['kuantiti']))) . "',
                             '" . mysql_real_escape_string(trim(htmlentities($_POST['uangmuka']))) . "',
                             '" . mysql_real_escape_string(trim(htmlentities($_POST['disc']))) . "',
                             '" . mysql_real_escape_string(trim(htmlentities($_POST['nett']))) . "') ");
// echo $execute; die();
//$lastId = mysql_insert_id();	
if ($execute) {

    header('Location: ../../index.php?r=penjualan&page=create&status=sukses');
} else {
    header('Location: ../../index.php?r=penjualan&page=create&status=gagal');
}
?>
