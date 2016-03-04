<?php

include"../../conf/connect.php";
include"../../conf/class_paging.php";
include"../../conf/fungsi_indotgl.php";
include"../../conf/library.php";

if (isset($_GET['getname'])) {
    $query = mysql_query("select hargaotr from tb_unit where id='$_GET[getname]'");
    $result = mysql_fetch_array($query);

    echo $result['hargaotr'];
} elseif (isset($_GET['ref_unit_id'])) {
    $query = mysql_query("select hargaotr from tb_unit where id='$_GET[ref_unit_id]'");
    $result = mysql_fetch_array($query);

    echo $result['hargaotr'];
} elseif (isset($_GET['disc'])) {
    $idunit = $_GET['disc'];

    echo $result['disc'];
} elseif (isset($_GET['nett'])) {
    $idunit = $_GET['nett'];
    $query = mysql_query("select tu.hargaotr as jml from tb_penjualan tp INNER JOIN tb_unit tu on tp.id = tu.id");
    $result = mysql_fetch_array($query);

    echo $result['jml'];
} elseif (isset($_GET['extra'])) {
    $idpeg = $_GET['extra'];
    $query = mysql_query("select b.ongkos from tb_pelayanan a inner join tb_pekerjaan b on a.id_pelayanan=b.id_pelayanan 
        where b.tb_unit='$idpeg' and substr(a.tanggal,6,2) = '$bln_sekarang' and substr(a.tanggal,1,4) = '$thn_sekarang'");
    $result = mysql_fetch_array($query);

    if ($result['ongkos'] > 5000) {
        $ex = $result['ongkos'] - 5000;
    } else {
        $ex = 0;
    }
    echo $ex;
} elseif (isset($_GET['getproduct'])) {
//    $query = mysql_query("select distinct a.id_detail_unit, a.no_mesin, a.id_unit as idunit, a.no_rangka, a.no_mesin,  
//                        b.hargakosongan, b.hargaotr ,  a.tahun, c.id_color, c.`name` as warna, b.`name` as unit , 
//                       dpu.kuantitas, dpu.harga, (dpu.kuantitas * dpu.harga) as harga_beli
//                        from tb_detail_unit a 
//                        inner join tb_unit b on a.id_unit=b.id 
//                        inner join ref_color c on c.id_color = a.id_color
//                        INNER JOIN tb_detail_pemesanan_unit dpu ON dpu.id_unit = b.id
//                        INNER JOIN tb_pemesanan_unit pu ON pu.id_detail_pemesanan_unit = dpu.id_detail_pemesanan_unit
//                        where b.id='$_GET[getproduct]'");
    $query = mysql_query("select 
                        a.id_detail_unit, a.no_mesin, a.id_unit as idunit, a.no_rangka, a.no_mesin, b.hargakosongan, b.hargaotr ,  a.tahun, c.id_color, 
                        c.`name` as warna, b.`name` as unit 
                        from tb_detail_unit a 
                        INNER JOIN tb_unit b on a.id_unit=b.id 
                        inner join ref_color c on c.id_color = a.id_color
                        where b.id='$_GET[getproduct]' and a.id_unit = '$_GET[getproduct]'
                        ");
                        // and a.id_detail_unit not in (select DISTINCT id_detail_unit FROM detail_penjualan)
    while ($result = mysql_fetch_array($query)) {
        $base64 = base64_encode(implode('||', array($result['id_detail_unit'], $result['unit'], $result['warna'], $result['no_mesin'], $result['no_rangka'], $result['hargaotr'], $result['tahun'], $result['idunit'], $result['id_penjualan'])));
        echo"<option value='$base64'>$result[no_rangka] - Warna [$result[warna]]</option>";
    }
} elseif (isset($_GET['getquantity'])) {
    $query = mysql_query("select hargaotr from tb_unit where id_unit='$_GET[getquantity]' and id_detail_unit='$_GET[id]'");
    $result = mysql_fetch_array($query);

    echo $result['hargaotr'];
} elseif (isset($_GET['harga'])) {
    $q = mysql_query("SELECT hargaotr from tb_unit where id_detail_unit='$_GET[harga]'");
    $r = mysql_fetch_array($q);
    echo $r['hargaotr'];
} 