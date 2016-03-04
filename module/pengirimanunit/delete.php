<?php

include"../../conf/connect.php";
include "../../conf/fungsi_thumb.php";
include"../../conf/library.php";

//if (isset($_GET['id']) && isset($_GET['dpu']) && isset($_GET['pu']) && isset($_GET['u'])) {
$id = $_GET['id'];
$dpu = $_GET['dpu'];
$pu = $_GET['pu'];
$u = $_GET['u'];


//    echo $result['sisa_kuantitas'];
//    echo $result2['kuantitas'];
//    
//    echo $sisa;
//    die();

$query_cek = mysql_query("SELECT sisa_kuantitas from tb_detail_pemesanan_unit 
                            where id_pemesanan_unit = '$pu' 
                            and id_unit = '$u'");

$result = mysql_fetch_array($query_cek);

$query_cek2 = mysql_query("SELECT dp.kuantitas from detail_pembelian dp
                            INNER JOIN tb_pemesanan_unit pu on pu.id_pemesanan_unit = dp.id_pemesanan_unit
                            INNER JOIN tb_detail_pemesanan_unit dpu ON dpu.id_pemesanan_unit = pu.id_pemesanan_unit
                            where dpu.id_detail_pemesanan_unit = '$dpu' 
                            and pu.id_pemesanan_unit = '$pu'  
                            and dp.id_unit = '$u'  
                            and dp.id_pembelian = '$id'");

$result2 = mysql_fetch_array($query_cek2);

//echo $query_cek;
//echo "<br>";
//echo $query_cek2;
//echo "<br>";
//echo $result['sisa_kuantitas'];
//echo "<br>";
//echo $result2['kuantitas'];
//
//echo "<br>";
$sisa = $result['sisa_kuantitas'] - $result2['kuantitas'];

//echo $sisa;
//die();
$query3 = mysql_query("UPDATE tb_detail_pemesanan_unit set sisa_kuantitas= '$sisa' 
                where id_detail_pemesanan_unit ='$dpu'
                and id_pemesanan_unit = '$pu'");

if ($query3) {
    $delete = mysql_query("delete from pembelian where id_pembelian='$id'");
    mysql_query("delete from detail_pembelian where id_pembelian = '$id'");


//    echo $query3;
//    die();
    header('Location: ../../index.php?r=pengirimanunit&page=view&status=deleted');
} else {
    header('Location: ../../index.php?r=pengirimanunit&page=view&status=gagal');
}
//} else {
//    header('Location: ../../index.php?r=pengirimanunit&page=view&status=gagal');
//}