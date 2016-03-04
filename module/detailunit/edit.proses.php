<?php

include"../../conf/connect.php";
include "../../conf/fungsi_thumb.php";
include"../../conf/library.php";

if (isset($_POST['save'])) {
    $params = $_POST['master'];

    $q = "update tb_unit set name ='" . mysql_real_escape_string(trim(htmlentities($_POST['name_unit']))) . "' where id ='$_POST[id_unit]'";
    $edit = mysql_query($q);
    
    if ($edit) {
        foreach ($params['edit'] as $row5) {
            $q5 = "update tb_detail_unit set 
                    id_color = '" . mysql_real_escape_string(trim(htmlentities($row5['warna']))) . "',
                    id_unit = '" . mysql_real_escape_string(trim(htmlentities($_POST['id_unit']))) . "',
                    no_mesin = '" . mysql_real_escape_string(trim(htmlentities($row5['nomesin']))) . "',
                    no_rangka = '" . mysql_real_escape_string(trim(htmlentities($row5['norangka']))) . "',
                    tahun = '" . mysql_real_escape_string(trim(htmlentities($row5['tahun']))) . "'
                    where id_detail_unit='$row5[iddetailunit]' and id_color='$row5[warna]' and id_unit='$_POST[id_unit]'";

            $execute5 = mysql_query($q5);
        }
        
//        echo $params;
//        echo $row5;
//        echo $q5;
//        die();

        if (isset($params['delete']) == TRUE) {
            foreach ($params['delete'] as $row) {
                $q = "delete from tb_detail_unit where id_detail_unit='$row[delId]' and id_unit='$_POST[id_unit]'";
                $execute1 = mysql_query($q);
            }
        }

        if ($execute5) {
            if (isset($params['detail']) && isset($params['delete'])) {
                foreach ($params['detail'] as $row2) {
                    $query = "insert into tb_detail_unit SET 
                        id_color = '" . mysql_real_escape_string(trim(htmlentities($row2['productId']))) . "',
                        id_unit = '" . mysql_real_escape_string(trim(htmlentities($_POST['id_unit']))) . "',
                        no_mesin = '" . mysql_real_escape_string(trim(htmlentities($row2['no_mesin']))) . "',
                        no_rangka = '" . mysql_real_escape_string(trim(htmlentities($row2['no_rangka']))) . "',
                        tahun = '" . mysql_real_escape_string(trim(htmlentities($row2['tahun']))) . "'";

                    $execute2 = mysql_query($query);
//                $id_detail_unit = mysql_insert_id();
//                mysql_query("update tb_unit set id_detail_unit='$id_detail_unit' where id='$_POST[id_unit]'");
                }

                foreach ($params['delete'] as $row) {
                    $q = "delete from tb_detail_unit where id_detail_unit='$row[delId]' and id_unit='$_POST[id_unit]'";
                    $execute1 = mysql_query($q);
                }

                if ($execute1) {
                    if ($execute2) {
                        header('Location: ../../index.php?r=detailunit&page=view&status=edited');
                    } else {
                        header('Location: ../../index.php?r=detailunit&page=view&status=gagal');
                    }
                }
            } elseif (isset($params['delete'])) {
                foreach ($params['delete'] as $row) {
                    $q = "delete from tb_detail_unit where id_detail_unit='$row[delId]' and id_unit='$_POST[id_unit]'";
                    $execute1 = mysql_query($q);
                }
                if ($execute1) {
                    header('Location: ../../index.php?r=detailunit&page=view&status=edited');
                } else {
                    header('Location: ../../index.php?r=detailunit&page=view&status=gagal');
                }
            } elseif (isset($params['detail'])) {
                foreach ($params['detail'] as $row2) {
                    $query = "insert into tb_detail_unit SET 
                        id_color = '" . mysql_real_escape_string(trim(htmlentities($row2['productId']))) . "',
                        id_unit = '" . mysql_real_escape_string(trim(htmlentities($_POST['id_unit']))) . "',
                        no_mesin = '" . mysql_real_escape_string(trim(htmlentities($row2['no_mesin']))) . "',
                        no_rangka = '" . mysql_real_escape_string(trim(htmlentities($row2['no_rangka']))) . "',
                        tahun = '" . mysql_real_escape_string(trim(htmlentities($row2['tahun']))) . "'";

                    $execute2 = mysql_query($query);
//                $id_detail_unit = mysql_insert_id();
//                mysql_query("update tb_unit set id_detail_unit='$id_detail_unit' where id='$_POST[id_unit]'");
                }

                if ($execute2) {
                    header('Location: ../../index.php?r=detailunit&page=view&status=edited');
                } else {
                    header('Location: ../../index.php?r=detailunit&page=view&status=gagal');
                }
            }
            header('Location: ../../index.php?r=detailunit&page=view&status=edited');
        } else {
            header('Location: ../../index.php?r=detailunit&page=view&status=gagal');
        }
    } else {
        header('Location: ../../index.php?r=detailunit&page=view&status=gagal');
    }
}