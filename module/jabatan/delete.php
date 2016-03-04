<?php
include"../../conf/connect.php";
include"../../conf/library.php";

if(isset($_GET['id'])){
        $id=$_GET['id'];
        $delete=  mysql_query("delete from tb_jabatan where id_jabatan='$id'");
        
        if($delete){
            
            header('Location: ../../index.php?r=jabatan&page=view&status=deleted');
        }
        else header('Location: ../../index.php?r=jabatan&page=view&status=gagal');
    }
    else header('Location: ../../index.php?r=jabatan&page=view&status=gagal');
?>
