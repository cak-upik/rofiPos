<?php

include"../../conf/connect.php";
include "../../conf/fungsi_thumb.php";
include"../../conf/library.php";

$param = $_POST['unit'];
//mysql_query(
$execute = mysql_query("insert into penjualan (no_faktur, tanggal, subtotal_penjualan, id_leasing, id_customer) 
                     values (
                             '" . mysql_real_escape_string(trim(htmlentities($_POST['no_faktur']))) . "',
                             '$tgl_sekarang',
                             '" . mysql_real_escape_string(trim(htmlentities($_POST['subtotal']))) . "',
                             '" . mysql_real_escape_string(trim(htmlentities($_POST['leasing']))) . "',
                             '" . mysql_real_escape_string(trim(htmlentities($_POST['customer']))) . "')");
// echo $execute; die();
$lastId = mysql_insert_id();


if ($execute) {
    foreach ($param['detail'] as $row) {
        $q = "INSERT INTO detail_penjualan SET id_unit = '" . mysql_real_escape_string(trim(htmlentities($row['idunit']))) . "',
                             id_detail_unit = '" . mysql_real_escape_string(trim(htmlentities($row['id']))) . "',
                             id_penjualan = '" . mysql_real_escape_string(trim(htmlentities($lastId))) . "',
                             uang_muka = '" . mysql_real_escape_string(trim(htmlentities($row['kuantitas']))) . "',
                             diskon = '" . mysql_real_escape_string(trim(htmlentities($row['diskon']))) . "',
                             jumlah = '" . mysql_real_escape_string(trim(htmlentities($row['jumlah']))) . "'";
        $r = mysql_query($q);
        
        $query_sisa_po = mysql_query("SELECT * FROM pembelian");
        $q2 = "INSERT INTO stok";
    }

    $query = mysql_query("select sum(u.hargaotr-dp.uang_muka-dp.diskon) as total
                        from tb_unit as u
                        INNER JOIN tb_detail_unit du ON du.id_unit = u.id
                        INNER JOIN detail_penjualan dp ON dp.id_detail_unit = du.id_detail_unit
                        INNER JOIN tb_detail_pemesanan_unit dpu ON dpu.id_unit = u.id
                        where dp.id_penjualan ='$lastId'");

    $rows = mysql_fetch_array($query);
    mysql_query("update penjualan set subtotal_penjualan = '$rows[total]' where id_penjualan= $lastId");

    if ($r) {
        header('Location: ../../index.php?r=penjualan&page=view&status=sukses');
    } else {
        header('Location: ../../index.php?r=penjualan&page=view&status=gagal');
    }
} else {
    header('Location: ../../index.php?r=penjualan&page=view&status=gagal');
}