<?php
include"../../conf/connect.php";
include"../../conf/library.php";

if(isset($_GET['id'])){
        $id=$_GET['id'];
        $delete=  mysql_query("delete from tb_mekanik where id_mekanik='$id'");
        
        if($delete){
            
            header('Location: ../../index.php?r=mekanik&page=view&status=deleted');
        }
        else header('Location: ../../index.php?r=mekanik&page=view&status=gagal');
    }
    else header('Location: ../../index.php?r=mekanik&page=view&status=gagal');
?>
