<?php
include"../../conf/connect.php";
include"../../conf/class_paging.php";
include"../../conf/fungsi_indotgl.php";
include"../../conf/library.php";
                        
if(isset($_GET['getname'])){
    $query = mysql_query("select name from tb_unit where id='$_GET[getname]'");
    $result = mysql_fetch_array($query);

    echo $result['name'];
}

elseif(isset($_GET['getproduct'])){
    $query=mysql_query("select distinct a.id_sparepart, b.kode_sparepart, b.nama_sparepart 
        from tb_detail_pemesanan_stok a inner join tb_sparepart b on a.id_sparepart=b.id_sparepart 
        where a.id_pemesanan_stok='$_GET[getproduct]'");
    echo"<option value=''>-- Pilih --</option>";
    while($result=  mysql_fetch_array($query)){
        $base64=base64_encode(implode('||', array($result['id_sparepart'],$result['nama_sparepart'], $result['kode_sparepart'])));
        echo"<option value='$base64'>( $result[kode_sparepart] ) $result[nama_sparepart]</option>";
    }
    
    
}
elseif(isset($_GET['getquantity'])){
    $query=mysql_query("select kuantitas from tb_detail_pemesanan_stok where id_sparepart='$_GET[getquantity]' and id_pemesanan_stok='$_GET[id]'");
    $result=  mysql_fetch_array($query);
    
    echo $result['kuantitas'];
}


function isExist($id){
            $prodid=mysql_fetch_array(mysql_query("select count(id_sparepart) as tot from tb_stok where id_sparepart='$id'"));
                //$this->renderText($name['productName']) ;
                return $prodid['tot'];
            //return '14794';
			 
	}

function getPrice($id, $sparepart){
            $a=mysql_fetch_array(mysql_query("select harga from tb_detail_pemesanan_stok where id_pemesanan_stok='$id' and id_sparepart='$sparepart'"));
            $tot=$a['harga'] * 20 / 100;
            $jum=$a['harga'] + $tot;
                //$this->renderText($name['productName']) ;
                return $jum;
            //return '14794';
			 
}
