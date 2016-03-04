<?php

include"../../conf/connect.php";
include"../../conf/library.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $delete = mysql_query("delete from tb_pemesanan_unit where id_pemesanan_unit='$id'");

    if ($delete) {

        header('Location: ../../index.php?r=pembelianunit&page=view&status=deleted');
    } else {
        header('Location: ../../index.php?r=pembelianunit&page=view&status=gagal');
    }
} else {
    header('Location: ../../index.php?r=pembelianunit&page=view&status=gagal');
}

