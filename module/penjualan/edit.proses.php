<?php

include"../../conf/connect.php";
include "../../conf/fungsi_thumb.php";
include"../../conf/library.php";

$params = $_POST['unit'];

$q = "UPDATE penjualan SET tanggal ='$tgl_sekarang',
         subtotal_penjualan ='" . mysql_real_escape_string(trim(htmlentities($_POST['total']))) . "',
         id_leasing = '" . mysql_real_escape_string(trim(htmlentities($_POST['leasing']))) . "'
         WHERE id_penjualan = '$_POST[id_penjualan]'";

$edit = mysql_query($q);

if ($edit) {
    foreach ($params['edit'] as $row) {
        $q = "UPDATE detail_penjualan SET id_unit = '" . mysql_real_escape_string(trim(htmlentities($row['idunit']))) . "',
                             id_detail_unit = '" . mysql_real_escape_string(trim(htmlentities($row['id']))) . "',
                             id_penjualan = '" . mysql_real_escape_string(trim(htmlentities($_POST['id_penjualan']))) . "',
                             uang_muka = '" . mysql_real_escape_string(trim(htmlentities($row['kuantitas']))) . "',
                             diskon = '" . mysql_real_escape_string(trim(htmlentities($row['diskon']))) . "',
                             jumlah = '" . mysql_real_escape_string(trim(htmlentities($row['jumlah']))) . "'
                             WHERE id_penjualan = '$_POST[id_penjualan]' and id_detail_penjualan = '$_POST[iddetailjual]'";
        $execute = mysql_query($q);
    }
    
    $sum = "select sum(u.hargaotr-dp.uang_muka-dp.diskon) as total
                        from tb_unit as u
                        INNER JOIN tb_detail_unit du ON du.id_unit = u.id
                        INNER JOIN detail_penjualan dp ON dp.id_detail_unit = du.id_detail_unit
                        INNER JOIN tb_detail_pemesanan_unit dpu ON dpu.id_unit = u.id
            where dp.id_penjualan ='$_POST[id_penjualan]' and id_detail_penjualan = '$_POST[iddetailjual]'";

    $query = mysql_query($sum);
    $rows = mysql_fetch_array($query);
    mysql_query("update penjualan set subtotal_penjualan = '$rows[total]' where id_penjualan= '$_POST[id_penjualan]'");


    if ($execute) {
        if (isset($params['detail']) && isset($params['delete'])) {
            foreach ($params['detail'] as $rows) {
                $q = "INSERT INTO detail_penjualan SET id_unit = '" . mysql_real_escape_string(trim(htmlentities($rows['idunit']))) . "',
                             id_detail_unit = '" . mysql_real_escape_string(trim(htmlentities($rows['id']))) . "',
                             id_penjualan = '" . mysql_real_escape_string(trim(htmlentities($_POST['id_penjualan']))) . "',
                             uang_muka = '" . mysql_real_escape_string(trim(htmlentities($rows['kuantitas']))) . "',
                             diskon = '" . mysql_real_escape_string(trim(htmlentities($rows['diskon']))) . "',
                             jumlah = '" . mysql_real_escape_string(trim(htmlentities($rows['jumlah']))) . "'";
                $execute2 = mysql_query($q);
            }
            

            foreach ($params['delete'] as $row) {
                $execute3 = mysql_query("delete from detail_penjualan where id_detail_penjualan='$row[delId]' "
                        . "and id_penjualan='$_POST[id_penjualan]'");
            }

            if ($execute3) {
                if ($execute2) {
                    $sum = "select sum(u.hargaotr-dp.uang_muka-dp.diskon) as total
                        from tb_unit as u
                        INNER JOIN tb_detail_unit du ON du.id_unit = u.id
                        INNER JOIN detail_penjualan dp ON dp.id_detail_unit = du.id_detail_unit
                        INNER JOIN tb_detail_pemesanan_unit dpu ON dpu.id_unit = u.id
                        where dp.id_penjualan ='$_POST[id_penjualan]' and id_detail_penjualan = '$_POST[iddetailjual]'";

                    $query = mysql_query($sum);
                    $rows = mysql_fetch_array($query);
                    mysql_query("update penjualan set subtotal_penjualan = '$rows[total]' where id_penjualan= '$_POST[id_penjualan]'");
                    header('Location: ../../index.php?r=penjualan&page=view&status=edited');
                } else {
                    header('Location: ../../index.php?r=penjualan&page=view&status=gagal');
                }
            } else {
                header('Location: ../../index.php?r=penjualan&page=view&status=gagal');
            }
        } elseif (isset($params['delete'])) {
            foreach ($params['delete'] as $row) {
                $execute4 = mysql_query("delete from detail_penjualan where id_detail_penjualan='$row[delId]' "
                        . "and id_penjualan='$_POST[id_penjualan]'");
            }

            if ($execute4) {
                $sum = "select sum(u.hargaotr-dp.uang_muka-dp.diskon) as total
                        from tb_unit as u
                        INNER JOIN tb_detail_unit du ON du.id_unit = u.id
                        INNER JOIN detail_penjualan dp ON dp.id_detail_unit = du.id_detail_unit
                        INNER JOIN tb_detail_pemesanan_unit dpu ON dpu.id_unit = u.id
                        where dp.id_penjualan ='$_POST[id_penjualan]' and id_detail_penjualan = '$_POST[iddetailjual]'";

                    $query = mysql_query($sum);
                    $rows = mysql_fetch_array($query);
                    mysql_query("update penjualan set subtotal_penjualan = '$rows[total]' where id_penjualan= '$_POST[id_penjualan]'");
                header('Location: ../../index.php?r=penjualan&page=view&status=edited');
            } else {
                header('Location: ../../index.php?r=penjualan&page=view&status=gagal');
            }
        } elseif (isset($params['detail'])) {
            foreach ($params['detail'] as $rows) {
                $q5 = "INSERT INTO detail_penjualan SET id_unit = '" . mysql_real_escape_string(trim(htmlentities($rows['idunit']))) . "',
                             id_detail_unit = '" . mysql_real_escape_string(trim(htmlentities($rows['id']))) . "',
                             id_penjualan = '" . mysql_real_escape_string(trim(htmlentities($_POST['id_penjualan']))) . "',
                             uang_muka = '" . mysql_real_escape_string(trim(htmlentities($rows['kuantitas']))) . "',
                             diskon = '" . mysql_real_escape_string(trim(htmlentities($rows['diskon']))) . "',
                             jumlah = '" . mysql_real_escape_string(trim(htmlentities($rows['jumlah']))) . "'";
                $execute5 = mysql_query($q5);
            }

//            echo $q5;
//            die();
            if ($execute5) {
                $sum = "select sum(u.hargaotr-dp.uang_muka-dp.diskon) as total
                        from tb_unit as u
                        INNER JOIN tb_detail_unit du ON du.id_unit = u.id
                        INNER JOIN detail_penjualan dp ON dp.id_detail_unit = du.id_detail_unit
                        INNER JOIN tb_detail_pemesanan_unit dpu ON dpu.id_unit = u.id
                        where dp.id_penjualan ='$_POST[id_penjualan]' and id_detail_penjualan = '$_POST[iddetailjual]'";

                    $query = mysql_query($sum);
                    $rows = mysql_fetch_array($query);
                    mysql_query("update penjualan set subtotal_penjualan = '$rows[total]' where id_penjualan= '$_POST[id_penjualan]'");
                header('Location: ../../index.php?r=penjualan&page=view&status=edited');
            } else {
                header('Location: ../../index.php?r=penjualan&page=view&status=gagal');
            }
        } else {
            header('Location: ../../index.php?r=penjualan&page=view&status=edited');
        }
    } else {
        header('Location: ../../index.php?r=penjualan&page=view&status=gagal');
    }
} else {
    header('Location: ../../index.php?r=penjualan&page=view&status=gagal');
}                   