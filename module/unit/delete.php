<?php

include"../../conf/connect.php";
include"../../conf/library.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $delete = mysql_query("delete from tb_unit where id='$id'");

    if ($delete) {
        header('Location: ../../index.php?r=unit&page=view&status=deleted');
    } else {
        header('Location: ../../index.php?r=unit&page=view&status=gagal');
    }
} else {
    header('Location: ../../index.php?r=unit&page=view&status=gagal');
}
