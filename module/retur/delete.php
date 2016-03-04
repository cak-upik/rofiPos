<?php
include"../../conf/connect.php";
include"../../conf/library.php";

if(isset($_GET['id'])){
        $id=$_GET['id'];
        
        $get=  mysql_query("select * from tb_retur a inner join tb_detail_retur b on a.id_retur=b.id_retur where a.id_retur='$id'");
        while ($row1 = mysql_fetch_array($get)) {
            mysql_query("update tb_stok set 
                         jumlah_stok = jumlah_stok +'".$row1['kuantitas']."'
                         where id_sparepart='$row1[id_sparepart]'");
        }
        $delete=  mysql_query("delete from tb_retur where id_retur='$id'");
        if($delete){
            
            header('Location: ../../index.php?r=retur&page=view&status=deleted');
        }
        else header('Location: ../../index.php?r=retur&page=view&status=gagal');
    }
    else header('Location: ../../index.php?r=retur&page=view&status=gagal');
?>
