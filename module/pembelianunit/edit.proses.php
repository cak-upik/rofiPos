<?php

include"../../conf/connect.php";
include "../../conf/fungsi_thumb.php";
include"../../conf/library.php";

$params = $_POST['unit'];
$edit = mysql_query("update tb_pemesanan_unit set 
                            no_faktur ='" . mysql_real_escape_string(trim(htmlentities($_POST['no_faktur']))) . "',
                            id_supplier ='" . mysql_real_escape_string(trim(htmlentities($_POST['id_suplier']))) . "',
                            jumlah_tagihan ='" . mysql_real_escape_string(trim(htmlentities($_POST['jumlah_tagihan']))) . "',
                            id_pegawai ='" . mysql_real_escape_string(trim(htmlentities($_POST['id_pegawai']))) . "',
                            id_unit = '" . mysql_real_escape_string(trim(htmlentities($_POST['productId']))) . "'
                         where id_pemesanan_unit='$_POST[id_pemesanan_unit]'");

if ($edit) {
    foreach ($params['edit'] as $row5) {
//        
        $execute5 = mysql_query("update tb_detail_pemesanan_unit set 
                            id_unit ='" . mysql_real_escape_string(trim(htmlentities($row5['idunit']))) . "',
                            kuantitas ='" . mysql_real_escape_string(trim(htmlentities($row5['quantity']))) . "',
                            harga ='" . mysql_real_escape_string(trim(htmlentities($row5['price']))) . "',
                            keterangan ='" . mysql_real_escape_string(trim(htmlentities($row5['remark']))) . "'
                         where id_pemesanan_unit='$_POST[id_pemesanan_unit]' and id_unit='$row5[idunit]' ");
        mysql_query("update tb_pemesanan_unit set id_unit ='$row5[idunit]' where id_pemesanan_unit = '$_POST[id_pemesanan_unit]'");
    }
    $cari = mysql_query("SELECT sum(kuantitas * harga) as harga FROM `tb_detail_pemesanan_unit` WHERE id_pemesanan_unit = '$_POST[id_pemesanan_unit]'");
    $r = mysql_fetch_array($cari);
    mysql_query("update tb_pemesanan_unit set jumlah_tagihan='$r[harga]' where id_pemesanan_unit='$_POST[id_pemesanan_unit]'");

    if ($execute5) {
        if (isset($params['detail']) && isset($params['delete'])) {
            foreach ($params['detail'] as $row2) {
                $execute2 = mysql_query("insert into tb_detail_pemesanan_unit SET 
                        id_unit = '" . mysql_real_escape_string(trim(htmlentities($row2['productId']))) . "' , 
                        id_pemesanan_unit = '" . mysql_real_escape_string(trim(htmlentities($_POST['id_pemesanan_unit']))) . "', 
                        kuantitas = '" . mysql_real_escape_string(trim(htmlentities($row2['quantity']))) . "', 
                        harga = '" . mysql_real_escape_string(trim(htmlentities($row2['price']))) . "', 
                        keterangan = '" . mysql_real_escape_string(trim(htmlentities($row2['remark']))) . "'");
            }
            foreach ($params['delete'] as $row) {
                $execute1 = mysql_query("delete from tb_detail_pemesanan_unit where id_unit='$row[delId]' 
                            and id_pemesanan_unit='$_POST[id_pemesanan_unit]'");
            }

            if ($execute1) {
                if ($execute2) {
                    $cari2 = mysql_query("SELECT sum(kuantitas * harga) as harga FROM `tb_detail_pemesanan_unit` WHERE id_pemesanan_unit = '$_POST[id_pemesanan_unit]'");
                    $r2 = mysql_fetch_array($cari2);

                    mysql_query("update tb_pemesanan_unit set jumlah_tagihan='$r2[harga]' where id_pemesanan_unit='$_POST[id_pemesanan_unit]'");
                    header('Location: ../../index.php?r=pembelianunit&page=view&status=edited');
                } else {
                    header('Location: ../../index.php?r=pembelianunit&page=view&status=gagal');
                }
            }
        } elseif (isset($params['delete'])) {
            foreach ($params['delete'] as $row) {
                $execute1 = mysql_query("delete from tb_detail_pemesanan_unit where id_unit='$row[delId]' 
                            and id_pemesanan_unit='$_POST[id_pemesanan_unit]'");
            }
            if ($execute1) {
                header('Location: ../../index.php?r=pembelianunit&page=view&status=edited');
            } else {
                header('Location: ../../index.php?r=pembelianunit&page=view&status=gagal');
            }
        } elseif (isset($params['detail'])) {
            foreach ($params['detail'] as $row2) {

                $execute2 = mysql_query("insert into tb_detail_pemesanan_unit SET 
                        id_unit = '" . mysql_real_escape_string(trim(htmlentities($row2['productId']))) . "' , 
                        id_pemesanan_unit = '" . mysql_real_escape_string(trim(htmlentities($_POST['id_pemesanan_unit']))) . "', 
                        kuantitas = '" . mysql_real_escape_string(trim(htmlentities($row2['quantity']))) . "', 
                        harga = '" . mysql_real_escape_string(trim(htmlentities($row2['price']))) . "', 
                        keterangan = '" . mysql_real_escape_string(trim(htmlentities($row2['remark']))) . "'");
            }
            if ($execute2) {
                $cari2 = mysql_query("SELECT sum(kuantitas * harga) as harga FROM `tb_detail_pemesanan_unit` WHERE id_pemesanan_unit = '$_POST[id_pemesanan_unit]'");
                $r2 = mysql_fetch_array($cari2);

                mysql_query("update tb_pemesanan_unit set jumlah_tagihan='$r2[harga]' where id_pemesanan_unit='$_POST[id_pemesanan_unit]'");
                header('Location: ../../index.php?r=pembelianunit&page=view&status=edited');
            } else {
                header('Location: ../../index.php?r=pembelianunit&page=view&status=gagal');
            }
        } else {
            header('Location: ../../index.php?r=pembelianunit&page=view&status=edited');
        }
    } else {
        header('Location: ../../index.php?r=pembelianunit&page=view&status=gagal');
    }
} else {
    header('Location: ../../index.php?r=pembelianunit&page=view&status=gagal');
}                       