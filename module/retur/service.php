<?php
include"../../conf/connect.php";
include"../../conf/class_paging.php";
include"../../conf/fungsi_indotgl.php";
include"../../conf/library.php";
                        
if(isset($_GET['getproduct'])){
    //$query=mysql_query("select nama_sparepart from tb_sparepart where id_sparepart='$_GET[getname]'");
    //$result=  mysql_fetch_array($query);
    $query=  mysql_query("select * from tb_detail_pemesanan_stok  a 
        inner join tb_sparepart b on a.id_sparepart=b.id_sparepart 
        where a.id_pemesanan_stok='$_GET[getproduct]'
        order by nama_sparepart");
    while ($row = mysql_fetch_array($query)) {
       $base64=base64_encode(implode('||', array($row['id_sparepart'],$row['nama_sparepart'], $row['kode_sparepart'], $row['harga'])));
       echo"<option value='$base64'>$row[nama_sparepart] </option>";
    }
    //echo $result['nama_sparepart'];
}
elseif(isset($_GET['getquantity'])){
    $query=mysql_query("select kuantitas from tb_detail_pemesanan_stok where id_sparepart='$_GET[getquantity]' and id_pemesanan_stok='$_GET[id]'");
    $result=  mysql_fetch_array($query);
    
    echo $result['kuantitas'];
}

elseif(isset($_GET['getquantity2'])){
    $query=mysql_query("select kuantitas from tb_detail_pemesanan_stok where id_sparepart='$_GET[getquantity2]' and id_pemesanan_stok='$_GET[id]'");
    $result=  mysql_fetch_array($query);
    
    echo $result['kuantitas'];
}
    

?>
