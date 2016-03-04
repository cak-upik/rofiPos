<?php

include"../../conf/connect.php";
include "../../conf/fungsi_thumb.php";
include"../../conf/library.php";

if (isset($_POST["save"])) {

//    $params = $_POST['master'];
//
    $execute = mysql_query("insert into tb_unit SET
                        name = '" . mysql_real_escape_string(trim(htmlentities($_POST['nama_unit']))) . "',
                        hargakosongan = '" . mysql_real_escape_string(trim(htmlentities($_POST['hargakosongan']))) . "',
                        plafonbbn = '" . mysql_real_escape_string(trim(htmlentities($_POST['plafonbbn']))) . "',
                        hargaotr = '" . mysql_real_escape_string(trim(htmlentities($_POST['hargaotr']))) . "'");

//    $lastId = mysql_insert_id();
//    if ($execute) {
//        foreach ($params['detail'] as $row2) {
//            $execute1 = mysql_query("insert into tb_detail_unit SET 
//                        id_color = '" . mysql_real_escape_string(trim(htmlentities($row2['productId']))) . "',
//                        id_unit = '" . mysql_real_escape_string(trim(htmlentities($lastId))) . "',
//                        no_mesin = '" . mysql_real_escape_string(trim(htmlentities($row2['no_mesin']))) . "',
//                        no_rangka = '" . mysql_real_escape_string(trim(htmlentities($row2['no_rangka']))) . "',
//                        tahun = '" . mysql_real_escape_string(trim(htmlentities($row2['tahun']))) . "',
//                        hargaotr = '" . mysql_real_escape_string(trim(htmlentities($row2['hargaotr']))) . "',
//                        hargakosongan = '" . mysql_real_escape_string(trim(htmlentities($row2['hargakosongan']))) . "',
//                        hargabeli = '" . mysql_real_escape_string(trim(htmlentities($row2['hargabeli']))) . "',
//                        plafonbbn = '" . mysql_real_escape_string(trim(htmlentities($row2['plafonbbn']))) . "'");
//
//            $id_detail_unit = mysql_insert_id();
//            mysql_query("update tb_unit set id_detail_unit='$id_detail_unit' where id='$lastId'");
//        }
//    echo $execute;
//    echo "<br/>";
//    echo $execute1;
//    die();

    if (!empty($execute)) {
        header('Location: ../../index.php?r=unit&page=view&status=sukses');
    } else {
//        mysql_query("delete from tb_unit where id=$lastId");
        header('Location: ../../index.php?r=unit&page=view&status=gagal2');
    }
} else {
    header('Location: ../../index.php?r=unit&page=view&status=gagal');
}
//}