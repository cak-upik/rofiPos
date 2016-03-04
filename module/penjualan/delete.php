<?php

include"../../conf/connect.php";
include "../../conf/fungsi_thumb.php";
include"../../conf/library.php";


if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $delete = mysql_query("delete from tb_penjualan where id_penjualan='$id'");

    if ($delete) {
        mysql_query("delete from detail_penjualan where id_penjualan='$id'");
        header('Location: ../../index.php?r=penjualan&page=view&status=deleted');
    } else {
        header('Location: ../../index.php?r=penjualan&page=view&status=gagal');
    }
} else {
    header('Location: ../../index.php?r=penjualan&page=view&status=gagal');
}