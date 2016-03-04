<?php

include"../../conf/connect.php";
include "../../conf/fungsi_thumb.php";
include"../../conf/library.php";


$param2 = $_POST['unit'];

//$edit = mysql_query("update pembelian set no_faktur = '" . mysql_real_escape_string(trim(htmlentities($_POST['no_beli']))) . "' ,
//                        tanggal = '$tgl_sekarang' where id_pembelian ='$_POST[id_pembelian]'");
//
//if ($edit) {
    foreach ($param2['edit'] as $row2) {
        $edit2 = "update detail_pembelian SET 
                        id_unit = '" . mysql_real_escape_string(trim(htmlentities($row2['idunit']))) . "' , 
                        id_detail_unit = '" . mysql_real_escape_string(trim(htmlentities($row2['iddetail']))) . "' , 
                        id_pembelian = '" . mysql_real_escape_string(trim(htmlentities($_POST['id_pembelian']))) . "', 
                        id_supplier = '" . mysql_real_escape_string(trim(htmlentities($row2['idsupplier']))) . "', 
                        id_pemesanan_unit = '" . mysql_real_escape_string(trim(htmlentities($row2['idPesan']))) . "', 
                        kuantitas = '" . mysql_real_escape_string(trim(htmlentities($row2['kuantitas']))) . "', 
                        keterangan = '" . mysql_real_escape_string(trim(htmlentities($row2 ['keterangan']))) . "'
                        Where id_detail_pembelian='$row2[idbeli]' and id_pembelian = '$_POST[id_pembelian]'";
        $execute = mysql_query($edit2);
    }

    if ($execute) {
        if (isset($param2['detail']) && isset($param2['delete'])) {
            foreach ($param2['detail'] as $row2) {
                $execute1 = mysql_query("insert into detail_pembelian SET 
                        id_unit = '" . mysql_real_escape_string(trim(htmlentities($row2['idunit']))) . "' , 
                        id_detail_unit = '" . mysql_real_escape_string(trim(htmlentities($row2['iddetail']))) . "' , 
                        id_pembelian = '" . mysql_real_escape_string(trim(htmlentities($_POST[id_pembelian]))) . "', 
                        id_supplier = '" . mysql_real_escape_string(trim(htmlentities($row2['idsupplier']))) . "', 
                        id_pemesanan_unit = '" . mysql_real_escape_string(trim(htmlentities($row2 ['idPesan']))) . "', 
                        kuantitas = '" . mysql_real_escape_string(trim(htmlentities($row2 ['kuantitas']))) . "', 
                        keterangan = '" . mysql_real_escape_string(trim(htmlentities($row2['keterangan']))) . "'");
            }

            foreach ($param2['delete'] as $row) {
                $execute2 = mysql_query("delete from detail_pembelian where id_detail_pembelian = '$row[delId]' and id_pembelian = '$_POST[id_pembelian]'");
            }

            if ($execute2) {
                if ($execute1) {
                    header('Location: ../../index.php?r=pengirimanunit&page=view&status=edited');
                } else {
                    header('Location: ../../index.php?r=pengirimanunit&page=view&status=gagal');
                }
            }
        } elseif (isset($params['delete'])) {
            foreach ($params['delete'] as $row) {
                $execute3 = mysql_query("delete from detail_pembelian where id_detail_pembelian = '$row[delId]' and id_pembelian = '$_POST[id_pembelian]'");
            }
            if ($execute3) {
                header('Location: ../../index.php?r=pengirimanunit&page=view&status=edited');
            } else {
                header('Location: ../../index.php?r=pengirimanunit&page=view&status=gagal');
            }
        } elseif (isset($param2['detail'])) {
            foreach ($param2['detail'] as $row2) {
                $execute4 = mysql_query("insert into detail_pembelian SET 
                        id_unit = '" . mysql_real_escape_string(trim(htmlentities($row2['idunit']))) . "' , 
                        id_detail_unit = '" . mysql_real_escape_string(trim(htmlentities($row2['iddetail']))) . "' , 
                        id_pembelian = '" . mysql_real_escape_string(trim(htmlentities($_POST[id_pembelian]))) . "', 
                        id_supplier = '" . mysql_real_escape_string(trim(htmlentities($row2['idsupplier']))) . "', 
                        id_pemesanan_unit = '" . mysql_real_escape_string(trim(htmlentities($row2['idPesan']))) . "', 
                        kuantitas = '" . mysql_real_escape_string(trim(htmlentities($row2['kuantitas']))) . "', 
                        keterangan = '" . mysql_real_escape_string(trim(htmlentities($row2 ['keterangan']))) . "'");
            }
            if ($execute4) {
                header('Location: ../../index.php?r=pengirimanunit&page=view&status=edited');
            } else {
                header('Location: ../../index.php?r=pengirimanunit&page=view&status=gagal');
            }
        } else {
            header('Location: ../../index.php?r=pengirimanunit&page=view&status=edited');
        }
    } else {
        header('Location: ../../index.php?r=pengirimanunit&page=view&status=gagal');
    }
//} else {
//    header('Location: ../../index.php?r=pengirimanunit&page=view&status=gagal');
//}                  