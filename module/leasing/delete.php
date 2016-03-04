<?php

include"../../conf/connect.php";
include"../../conf/library.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $delete = mysql_query("DELETE FROM `ref_leasing` WHERE `id` = $id");

    if ($delete) {
        header('Location: ../../index.php?r=leasing&page=view&status=deleted');
    } else {
        header('Location: ../../index.php?r=leasing&page=view&status=gagal');
    }
} else {
    header('Location: ../../index.php?r=leasing&page=view&status=gagal');
}