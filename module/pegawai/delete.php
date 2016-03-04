<?php
include"../../conf/connect.php";
include "../../conf/fungsi_thumb.php";
include"../../conf/library.php";


if(isset($_GET['id'])){
        $id=$_GET['id'];
        $id_pegawai=$_GET['id_pegawai'];
        $delete=  mysql_query("delete from tb_pegawai where id_pegawai='$id'");
        
        if($delete){
            header('Location: ../../index.php?r=pegawai&page=view&status=deleted');
        }
        else header('Location: ../../index.php?r=pegawai&page=view&status=gagal');
    }
    else header('Location: ../../index.php?r=pegawai&page=view&status=gagal');
?>
