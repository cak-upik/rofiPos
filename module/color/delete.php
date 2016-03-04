<?php

include"../../conf/connect.php";
include"../../conf/library.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $delete = mysql_query("delete from ref_color where id_color='$id'");

    if ($delete) {

        header('Location: ../../index.php?r=color&page=view&status=deleted');
    } else {
        header('Location: ../../index.php?r=color&page=view&status=gagal');
    }
} else {
    header('Location: ../../index.php?r=color&page=view&status=gagal');
}
?>
