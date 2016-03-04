<?php

include"../../conf/connect.php";
include "../../conf/fungsi_thumb.php";
include"../../conf/library.php";

//$params = $_POST['master'];

$q = "update tb_unit set name ='" . mysql_real_escape_string(trim(htmlentities($_POST['nama_unit']))) . "',
                            hargakosongan = '" . mysql_real_escape_string(trim(htmlentities($_POST['hargakosongan']))) . "',
                            plafonbbn = '" . mysql_real_escape_string(trim(htmlentities($_POST['plafonbbn']))) . "',
                            hargaotr = '" . mysql_real_escape_string(trim(htmlentities($_POST['hargaotr']))) . "'
                            where id ='$_POST[id_unit]'";

$edit = mysql_query($q);

//if ($edit) {
//    foreach ($params['edit'] as $row5) {
//        $execute5 = mysql_query("update tb_detail_unit set 
//                            id_color = '" . mysql_real_escape_string(trim(htmlentities($row5['warna']))) . "',
//                            id_unit = '" . mysql_real_escape_string(trim(htmlentities($_POST['id_unit']))) . "',
//                            no_mesin = '" . mysql_real_escape_string(trim(htmlentities($row5['no_mesin']))) . "',
//                            no_rangka = '" . mysql_real_escape_string(trim(htmlentities($row5['no_rangka']))) . "',
//                            tahun = '" . mysql_real_escape_string(trim(htmlentities($row5['tahun']))) . "',
//                            hargaotr = '" . mysql_real_escape_string(trim(htmlentities($row5['hargaotr']))) . "',
//                            hargakosongan = '" . mysql_real_escape_string(trim(htmlentities($row5['hargakosongan']))) . "',
//                            plafonbbn = '" . mysql_real_escape_string(trim(htmlentities($row5['plafonbbn']))) . "'
//                            where id_detail_unit='$row5[iddetailunit]' and id_color='$row5[warna]' and id_unit='$_POST[id_unit]'");
//    }
//
//    if (isset($params['delete']) == TRUE) {
//        foreach ($params['delete'] as $row) {
//            $q = "delete from tb_detail_unit where id_detail_unit='$row[delId]' and id_unit='$_POST[id_unit]'";
//            $execute1 = mysql_query($q);
//        }
//    }
//
//    if ($execute5) {
//        if (isset($params['detail']) && isset($params['delete'])) {
//            foreach ($params['detail'] as $row2) {
//                $query = "insert into tb_detail_unit SET 
//                        id_color = '" . mysql_real_escape_string(trim(htmlentities($row2['productId']))) . "',
//                        id_unit = '" . mysql_real_escape_string(trim(htmlentities($_POST['idUnit']))) . "',
//                        no_mesin = '" . mysql_real_escape_string(trim(htmlentities($row2['no_mesin']))) . "',
//                        no_rangka = '" . mysql_real_escape_string(trim(htmlentities($row2['no_rangka']))) . "',
//                        tahun = '" . mysql_real_escape_string(trim(htmlentities($row2['tahun']))) . "',
//                        hargaotr = '" . mysql_real_escape_string(trim(htmlentities($row2['hargaotr']))) . "',
//                        hargakosongan = '" . mysql_real_escape_string(trim(htmlentities($row2['hargakosongan']))) . "',
//                        plafonbbn = '" . mysql_real_escape_string(trim(htmlentities($row2['plafonbbn']))) . "'";
//
//                $execute2 = mysql_query($query);
////                $id_detail_unit = mysql_insert_id();
////                mysql_query("update tb_unit set id_detail_unit='$id_detail_unit' where id='$_POST[id_unit]'");
//            }
//
//            foreach ($params['delete'] as $row) {
//                $q = "delete from tb_detail_unit where id_detail_unit='$row[delId]' and id_unit='$_POST[id_unit]'";
//                $execute1 = mysql_query($q);
//            }
//
//            if ($execute1) {
//                if ($execute2) {
//                    header('Location: ../../index.php?r=unit&page=view&status=edited');
//                } else {
//                    header('Location: ../../index.php?r=unit&page=view&status=gagal');
//                }
//            }
//        } elseif (isset($params['delete'])) {
//            foreach ($params['delete'] as $row) {
//                $q = "delete from tb_detail_unit where id_detail_unit='$row[delId]' and id_unit='$_POST[id_unit]'";
//                $execute1 = mysql_query($q);
//            }
//            if ($execute1) {
//                header('Location: ../../index.php?r=unit&page=view&status=edited');
//            } else {
//                header('Location: ../../index.php?r=unit&page=view&status=gagal');
//            }
//        } elseif (isset($params['detail'])) {
//            foreach ($params['detail'] as $row2) {
//                $query = "insert into tb_detail_unit SET 
//                        id_color = '" . mysql_real_escape_string(trim(htmlentities($row2['productId']))) . "',
//                        id_unit = '" . mysql_real_escape_string(trim(htmlentities($_POST['idUnit']))) . "',
//                        no_mesin = '" . mysql_real_escape_string(trim(htmlentities($row2['no_mesin']))) . "',
//                        no_rangka = '" . mysql_real_escape_string(trim(htmlentities($row2['no_rangka']))) . "',
//                        tahun = '" . mysql_real_escape_string(trim(htmlentities($row2['tahun']))) . "',
//                        hargaotr = '" . mysql_real_escape_string(trim(htmlentities($row2['hargaotr']))) . "',
//                        hargakosongan = '" . mysql_real_escape_string(trim(htmlentities($row2['hargakosongan']))) . "',
//                        plafonbbn = '" . mysql_real_escape_string(trim(htmlentities($row2['plafonbbn']))) . "'";
//
//                $execute2 = mysql_query($query);
////                $id_detail_unit = mysql_insert_id();
////                mysql_query("update tb_unit set id_detail_unit='$id_detail_unit' where id='$_POST[id_unit]'");
//            }

if ($edit) {
//                header('Location: ../../index.php?r=unit&page=view&status=edited');
//            } else {
//                header('Location: ../../index.php?r=unit&page=view&status=gagal');
//            }
//        }
    header('Location: ../../index.php?r=unit&page=view&status=edited');
} else {
    header('Location: ../../index.php?r=unit&page=view&status=gagal');
}
//} else {
//    header('Location: ../../index.php?r=unit&page=view&status=gagal');
//}