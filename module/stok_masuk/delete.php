<?php
include"../../conf/connect.php";
include"../../conf/library.php";

if(isset($_GET['id'])){
        $id=$_GET['id'];
        
        $smDetai=  mysql_query("select id_sparepart, kuantitas from tb_detail_stok_masuk where id_stok_masuk='$id'");
        while($r=  mysql_fetch_array($smDetai)){
            $exe=  mysql_query("update tb_stok set jumlah_stok = jumlah_stok -'$r[kuantitas]' where id_sparepart='$r[id_sparepart]'");
        }
        
        $delete=  mysql_query("delete from tb_stok_masuk where id_stok_masuk='$id'");
        
        if($delete and $exe){
            
            header('Location: ../../index.php?r=ro&page=view&status=deleted');
        }
        else header('Location: ../../index.php?r=ro&page=view&status=gagal');
    }
    else header('Location: ../../index.php?r=ro&page=view&status=gagal');
?>
