<?php

include"../../conf/connect.php";
include "../../conf/fungsi_thumb.php";
include"../../conf/library.php";


$params = $_POST['unit'];
//
$execute = mysql_query("insert into pembelian SET no_faktur = '" . mysql_real_escape_string(trim(htmlentities($_POST['no_beli']))) . "' ,
                        tanggal = '$tgl_sekarang'");
$lastId = mysql_insert_id();

if ($execute) {
    foreach ($params['detail'] as $row2) {
//        mysql_query(
        $execute = "insert into detail_pembelian SET 
                        id_unit = '" . mysql_real_escape_string(trim(htmlentities($row2['idunit']))) . "' , 
                        id_detail_unit = '" . mysql_real_escape_string(trim(htmlentities($row2['iddetail']))) . "' , 
                        id_pembelian = '" . mysql_real_escape_string(trim(htmlentities($lastId))) . "', 
                        id_supplier = '" . mysql_real_escape_string(trim(htmlentities($row2['idsupplier']))) . "', 
                        id_pemesanan_unit = '" . mysql_real_escape_string(trim(htmlentities($row2['idPesan']))) . "', 
                        kuantitas = '" . mysql_real_escape_string(trim(htmlentities($row2['kuantitas']))) . "', 
                        sisa_kuantiti = '" . mysql_real_escape_string(trim(htmlentities($row2['sisa_qty']))) . "', 
                        keterangan = '" . mysql_real_escape_string(trim(htmlentities($row2['keterangan']))) . "'";
        $execute1 = mysql_query($execute);

//        $id = mysql_insert_id();

        $cek_query_pesan_unit = mysql_query("SELECT sisa_kuantitas from tb_detail_pemesanan_unit 
                      where id_pemesanan_unit = '" . mysql_real_escape_string(trim(htmlentities($row2['idPesan']))) . "'
                      and id_unit = '" . mysql_real_escape_string(trim(htmlentities($row2['idunit']))) . "' ");

        $r = mysql_fetch_array($cek_query_pesan_unit);
        if ($r['sisa_kuantitas'] == 0) {
            $update_pembelian_unit = "UPDATE tb_detail_pemesanan_unit SET 
                sisa_kuantitas = '" . mysql_real_escape_string(trim(htmlentities($row2['kuantitas']))) . "'
                where id_pemesanan_unit = '" . mysql_real_escape_string(trim(htmlentities($row2['idPesan']))) . "'
                      and id_unit = '" . mysql_real_escape_string(trim(htmlentities($row2['idunit']))) . "'";
            $result = mysql_query($update_pembelian_unit);
        } else if ($r['sisa_kuantitas'] > 0) {
            $sisa_total = $r['sisa_kuantitas'] + $row2['kuantitas'];
            $update_pembelian_unit = "UPDATE tb_detail_pemesanan_unit SET 
                sisa_kuantitas = '$sisa_total'
                where id_pemesanan_unit = '" . mysql_real_escape_string(trim(htmlentities($row2['idPesan']))) . "'
                      and id_unit = '" . mysql_real_escape_string(trim(htmlentities($row2['idunit']))) . "'";
            $result = mysql_query($update_pembelian_unit);
        }
    }

//        $query_pemesanan_unit = "SELECT (dpu.kuantitas - 1) as qty FROM detail_pembelian dp
//                                INNER JOIN pembelian p ON p.id_pembelian = dp.id_pembelian
//                                INNER JOIN tb_pemesanan_unit pu ON pu.id_pemesanan_unit = dp.id_pemesanan_unit
//                                INNER JOIN tb_detail_pemesanan_unit dpu ON dpu.id_detail_pemesanan_unit = pu.id_detail_pemesanan_unit
//                                where pu.id_pemesanan_unit='" . mysql_real_escape_string(trim(htmlentities($row2['idPesan']))) . "' GROUP BY pu.id_pemesanan_unit";
//        
//        $q2 = mysql_query($query_pemesanan_unit);
//        $result = mysql_fetch_array($q2);
//
//        $qty = $result['qty'];
//
//        $q1 = "insert into sisa_po (id_pemesanan_unit, id_pembelian, id_detail_pembelian, sisa_order) 
//            values ('" . mysql_real_escape_string(trim(htmlentities($row2['idPesan']))) . "' ,
//                   '" . mysql_real_escape_string(trim(htmlentities($lastId))) . "' ,
//                   '" . mysql_real_escape_string(trim(htmlentities($id))) . "' ,
//                   ('" . mysql_real_escape_string(trim(htmlentities($qty))) . "'));";
//
//        $query = mysql_query($q1);
//        
//        $q3 = "update tb_detail_pemesanan_unit set kuantitas = '$qty' where id_detail_pemesanan_unit = '" . mysql_real_escape_string(trim(htmlentities($row2['idDetPeU']))) . "'";
//        
//        mysql_query($q3);
}


//    echo $update_pembelian_unit;
//    die();
//if ($row2['kuantitas'] > $r['sisa_kuantitas']) {
    if ($execute1) {
        header('Location: ../../index.php?r=pengirimanunit&page=view&status=sukses');
    } else {
        header('Location: ../../index.php?r=pengirimanunit&page=view&status=gagal');
    }
//} else {
//    header('Location: ../../index.php?r=pengirimanunit&page=view&status=gagal');
//}