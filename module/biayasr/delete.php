<?php

include"../../conf/connect.php";
include"../../conf/library.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $delete = mysql_query("delete from ref_biaya_sr where id='$id'");

    if ($delete) {

        header('Location: ../../index.php?r=biayasr&page=view&status=deleted');
    } else {
        header('Location: ../../index.php?r=biayasr&page=view&status=gagal');
    }
} else {
    header('Location: ../../index.php?r=biayasr&page=view&status=gagal');
}