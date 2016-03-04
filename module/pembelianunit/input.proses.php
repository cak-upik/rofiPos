<?php

include"../../conf/connect.php";
include "../../conf/fungsi_thumb.php";
include"../../conf/library.php";

if (isset($_POST["save"])) {

    $params = $_POST['unit'];
//
    $execute = mysql_query("insert into tb_pemesanan_unit SET no_faktur = '" . mysql_real_escape_string(trim(htmlentities($_POST['no_faktur']))) . "' ,
                        id_supplier = '" . mysql_real_escape_string(trim(htmlentities($_POST['id_suplier']))) . "' ,
                        tanggal = '$tgl_sekarang' ,
                        jumlah_tagihan = '',
                        id_pegawai = '" . mysql_real_escape_string(trim(htmlentities($_POST['id_pegawai']))) . "',
                        id_unit = '" . mysql_real_escape_string(trim(htmlentities($_POST['id']))) . "'");
    $lastId = mysql_insert_id();

    if ($execute) {
        foreach ($params['detail'] as $row2) {
            $execute1 = mysql_query("insert into tb_detail_pemesanan_unit SET 
                        id_unit = '" . mysql_real_escape_string(trim(htmlentities($row2['productId']))) . "' , 
                        id_pemesanan_unit = '" . mysql_real_escape_string(trim(htmlentities($lastId))) . "', 
                        kuantitas = '" . mysql_real_escape_string(trim(htmlentities($row2['quantity']))) . "', 
                        harga = '" . mysql_real_escape_string(trim(htmlentities($row2['price']))) . "', 
                        keterangan = '" . mysql_real_escape_string(trim(htmlentities($row2['remark']))) . "'");
        }
        $cari = mysql_query("SELECT sum(kuantitas * harga) as 'harga' FROM `tb_pemesanan_unit` WHERE id_pemesanan_unit = '$lastId'");
        $r = mysql_fetch_array($cari);

        $id_detail_pemesanan = mysql_insert_id();
        mysql_query("update tb_pemesanan_unit set jumlah_tagihan='$r[harga]', id_detail_pemesanan_unit = $id_detail_pemesanan where id_pemesanan_unit='$lastId'");

//    echo $execute;
//    echo "<br/>";
//    echo $execute1;
//    die();


        if ($execute1) {
            header('Location: ../../index.php?r=pembelianunit&page=view&status=sukses');
        } else {
            header('Location: ../../index.php?r=pembelianunit&page=view&status=gagal');
        }
    } else {
        header('Location: ../../index.php?r=pembelianunit&page=view&status=gagal');
    }
}