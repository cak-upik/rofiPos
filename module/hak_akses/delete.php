<?php
include"../../conf/connect.php";
include"../../conf/library.php";

if(isset($_GET['id'])){
        $id=$_GET['id'];
        $delete=  mysql_query("delete from tb_hak_akses where id_hak_akses='$id'");
        
        if($delete){
            
            header('Location: ../../index.php?r=hak_akses&page=view&status=deleted');
        }
        else header('Location: ../../index.php?r=hak_akses&page=view&status=gagal');
    }
    else header('Location: ../../index.php?r=hak_akses&page=view&status=gagal');
?>
