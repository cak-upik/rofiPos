
<?php
include"../../conf/connect.php";
include"../../conf/library.php";

if(isset($_GET['id'])){
        $id=$_GET['id'];
        $delete=  mysql_query("delete from ref_supplier where id_supplier='$id'");
        
        if($delete){
            
            header('Location: ../../index.php?r=suplier&page=view&status=deleted');
        }
        else header('Location: ../../index.php?r=suplier&page=view&status=gagal');
    }
    else header('Location: ../../index.php?r=suplier&page=view&status=gagal');
?>


