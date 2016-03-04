<?php

include"../../conf/connect.php";
include"../../conf/library.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $delete = mysql_query("delete from tb_detail_unit where id_detail_unit='$id'");

    if ($delete) {
        header('Location: ../../index.php?r=detailunit&page=view&status=deleted');
    } else {
        header('Location: ../../index.php?r=detailunit&page=view&status=gagal');
    }
} else {
    header('Location: ../../index.php?r=detailunit&page=view&status=gagal');
}
