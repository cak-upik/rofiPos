<?php

include"../../conf/connect.php";
include"../../conf/class_paging.php";
include"../../conf/fungsi_indotgl.php";
include"../../conf/library.php";

//if (isset($_GET['getname'])) {
//    $query = mysql_query("select judul from tb_sparepart where id_sparepart='$_GET[getname]'");
//    $result = mysql_fetch_array($query);
//
//    echo $result['judul'];
//} elseif (isset($_GET['getproduct'])) {
//    $query = mysql_query("select distinct select distinct a.id_pemesanan_unit, a.no_faktur , b.kuantitas, b.harga  , 
//                        du.id_detail_unit, du.no_mesin, du.id_unit, du.no_rangka, du.no_mesin, du.hargabeli, 
//                        du.hargakosongan, du.hargaotr, du.tahun, rc.id_color, rc.`name` as warna
//                        FROM tb_pemesanan_unit  a
//                        INNER JOIN tb_detail_pemesanan_unit b on b.id_pemesanan_unit = a.id_pemesanan_unit
//                        INNER JOIN tb_unit c on c.id = b.id_unit
//                        INNER JOIN tb_detail_unit du ON du.id_detail_unit = c.id_detail_unit
//                        INNER JOIN ref_color rc on rc.id_color = du.id_color
//                        where a.id_pemesanan_unit='$_GET[getproduct]'");
//    echo"<option value=''>-- Pilih --</option>";
//    while ($result = mysql_fetch_array($query)) {
//        $base64 = base64_encode(implode('||', array($result['id_detail_unit'], $result['warna'], $result['no_mesin'], $result['no_rangka'], $result['hargabeli'], $result['tahun'], $result['id_unit'])));
//        echo"<option value='$base64'>$result[unit] - warna[$result[warna]] - no. mesin[$result[no_mesin]]</option>";
//    }
//} elseif (isset($_GET['jenis'])) {
//    $jenis = $_GET['jenis'];
//    if ($jenis == 'Satuan') {
//        $qKerja = mysql_query("select * from tb_jenis_pekerjaan order by jenis_pekerjaan");
//        while ($rKerja = mysql_fetch_array($qKerja)) {
//            $base64 = base64_encode(implode('||', array($rKerja['id_jenis_pekerjaan'], $rKerja['jenis_pekerjaan'], $rKerja['tarif_kerja'])));
//            echo"<option value='$base64'>$rKerja[jenis_pekerjaan]</option>";
//        }
//    } else {
//        $qKerja = mysql_query("select * from tb_kategori_pekerjaan order by nama_kategori");
//        while ($rKerja = mysql_fetch_array($qKerja)) {
//            $base64 = base64_encode(implode('||', array($rKerja['id_kategori_pekerjaan'], $rKerja['nama_kategori'], $rKerja['tarif_kerja'])));
//            echo"<option value='$base64'>$rKerja[nama_kategori]</option>";
//        }
//    }
//} elseif (isset($_GET['getquantity'])) {
//    $query = mysql_query("select kuantitas from tb_detail_pemesanan_stok where id_sparepart='$_GET[getquantity]' and id_pemesanan_stok='$_GET[id]'");
//    $result = mysql_fetch_array($query);
//
//    echo $result['kuantitas'];
//}
//
//function getharga($id) {
//    $get = mysql_query("select harga_jual_satuan from tb_sparepart a inner join tb_stok b on a.id_sparepart=b.id_sparepart where a.id_sparepart='$id'");
//    $res = mysql_fetch_array($get);
//
//    return $res['harga_jual_satuan'];
//}
//
//function getOngkos($id) {
//    $get = mysql_query("select sum(b.tarif_kerja) as ongkos from tb_detail_pembelian a 
//                    inner join tb_jenis_pekerjaan b on a.id_jenis_pekerjaan=b.id_jenis_pekerjaan  where id_pembelian='$id'");
//    $res = mysql_fetch_array($get);
//
//    return $res['ongkos'];
//}
//
//function getOngkos2($id) {
//    $dd = mysql_fetch_array(mysql_query("select keterangan from tb_pembelian where id_pembelian='$id'"));
////if($dd['keterangan'] ==)
//    $parts = explode(' ', $dd['keterangan']);
//    $get = mysql_query("select sum(tarif_kerja) as ongkos from tb_kategori_pekerjaan where nama_kategori='$parts[1]'");
//    $res = mysql_fetch_array($get);
//
//    return $res['ongkos'];
//}
//
//function checkJob($id) {
//    $dd = mysql_fetch_array(mysql_query("select keterangan from tb_pembelian where id_pembelian='$id'"));
////if($dd['keterangan'] ==)
//
//    return $dd['keterangan'];
//}
//
//function getJumlahpembelian($kategori, $bulan, $tahun, $tipe) {
//    $get = mysql_query("select count(a.id_pembelian) as a from tb_pembelian a 
//        inner join tb_detail_pembelian b on a.id_pembelian=b.id_pembelian 
//        inner join tb_jenis_pekerjaan c on b.id_jenis_pekerjaan=c.id_jenis_pekerjaan 
//        inner join tb_kategori_pekerjaan d on c.id_kategori_pekerjaan=d.id_kategori_pekerjaan 
//        inner join tb_pelanggan e on a.id_pelanggan=e.id_pelanggan where substr(tanggal,1,4)='$tahun' 
//        and substr(tanggal,6,2)='$bulan' and d.id_kategori_pekerjaan='$kategori' and e.id_type_motor='$tipe'");
//    $res = mysql_fetch_array($get);
//
//    return $res['a'];
//}
//
//function getJumlahSatuan($bulan, $tahun, $tipe) {
//    $dd = mysql_fetch_array(mysql_query("select count(t1.id_pembelian) as a from tb_pembelian t1
//        inner join tb_pelanggan t2 on t1.id_pelanggan=t2.id_pelanggan where substr(t1.tanggal,1,4)='$tahun' 
//        and substr(t1.tanggal,6,2)='$bulan' and t2.id_type_motor='$tipe' and t1.keterangan='Satuan'"));
////if($dd['keterangan'] ==)
//
//    return $dd['a'];
//}
//
//function getJumlahPaket($bulan, $tahun, $tipe) {
//    $dd = mysql_fetch_array(mysql_query("select count(t1.id_pembelian) as a from tb_pembelian t1
//        inner join tb_pelanggan t2 on t1.id_pelanggan=t2.id_pelanggan where substr(t1.tanggal,1,4)='$tahun' 
//        and substr(t1.tanggal,6,2)='$bulan' and t2.id_type_motor='$tipe' and t1.keterangan!='Satuan'"));
////if($dd['keterangan'] ==)
//
//    return $dd['a'];
//}

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
    $query = mysql_query("select distinct a.id_pemesanan_unit, a.no_faktur , b.harga  , b.id_detail_pemesanan_unit,
                        du.id_detail_unit, du.no_mesin, du.id_unit, du.no_rangka, du.no_mesin, du.hargabeli, 
                        c.hargakosongan, c.hargaotr, du.tahun, rc.id_color, rc.`name` as warna, c.`name` as unit, c.id,
                        (b.kuantitas-b.sisa_kuantitas) as qty, b.kuantitas, b.sisa_kuantitas
                        FROM tb_pemesanan_unit  a
                        INNER JOIN tb_detail_pemesanan_unit b on b.id_pemesanan_unit = a.id_pemesanan_unit
                        INNER JOIN tb_unit c on c.id = b.id_unit
                        INNER JOIN tb_detail_unit du ON du.id_detail_unit = c.id
                        INNER JOIN ref_color rc on rc.id_color = du.id_color
                        where a.id_pemesanan_unit='$_GET[getproduct]' and NOT(b.kuantitas = b.sisa_kuantitas)");
    while ($result = mysql_fetch_array($query)) {
//        if ($result['kuantitas'] == $result['sisa_kuantitas']) {
//            
//        } else if ($result['kuantitas'] != $result['sisa_kuantitas']) {
            $base64 = base64_encode(implode('||', array($result['id_detail_unit'], $result['unit'], $result['warna'], $result['no_mesin'], $result['no_rangka'], $result['hargabeli'], $result['tahun'], $result['id'], $result['qty'], $result['id_pemesanan_unit'], $result['id_detail_pemesanan_unit'])));
            echo"<option value='$base64'>[$result[id]] $result[unit] - Warna [$result[warna]] - Qty [$result[qty]]</option>";
//        }
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