<?php

include"../../conf/connect.php";
include"../../conf/library.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $delete = mysql_query("delete from ref_customer where id_customer='$id'");

    if ($delete) {

        header('Location: ../../index.php?r=customer&page=view&status=deleted');
    } else
        header('Location: ../../index.php?r=customer&page=view&status=gagal');
} else
    header('Location: ../../index.php?r=customer&page=view&status=gagal');
?>
