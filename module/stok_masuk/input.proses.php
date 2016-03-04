<?php

include"../../conf/connect.php";
include"../../conf/fungsi_thumb.php";
include"../../conf/library.php";
include"service.php";


$params = $_POST['ro'];


$execute = mysql_query("insert into tb_stok_masuk (id_pemesanan_stok, kode_stok_masuk, tgl_masuk) 
             values ('" . mysql_real_escape_string(trim(htmlentities($_POST['no_faktur']))) . "' ,
                 '" . mysql_real_escape_string(trim(htmlentities($_POST['kode_stok_masuk']))) . "' ,
                 '$tgl_sekarang' ) ");
$lastId = mysql_insert_id();

if ($execute) {
    foreach ($params['detail'] as $row2) {
        $execute1 = mysql_query("insert into tb_detail_stok_masuk (id_sparepart, id_stok_masuk, kuantitas) 
                    values ('" . mysql_real_escape_string(trim(htmlentities($row2['id_sparepart']))) . "' ,
                        '" . mysql_real_escape_string(trim(htmlentities($lastId))) . "', 
                        '" . mysql_real_escape_string(trim(htmlentities($row2['kuantitas']))) . "' ) ");

        $check = isExist($row2['id_sparepart']);
        $price = getPrice($_POST['no_faktur'], $row2['id_sparepart']);
        if ($check == 0) {


            $execute2 = mysql_query("insert into tb_stok (id_sparepart, jumlah_stok, harga_jual_satuan, keterangan) 
                    values ('" . mysql_real_escape_string(trim(htmlentities($row2[id_sparepart]))) . "' ,
                        '" . mysql_real_escape_string(trim(htmlentities($row2['kuantitas']))) . "', 
                        '" . mysql_real_escape_string(trim(htmlentities($price))) . "', 
                        ' ' ) ");
        } else {
            $execute2 = mysql_query("update tb_stok set 
                            jumlah_stok = jumlah_stok +'" . $row2['kuantitas'] . "',
                            harga_jual_satuan = '" . $price . "'
                         where id_sparepart='$row2[id_sparepart]'");
        }

        // $cari=mysql_query("SELECT sum(kuantitas * harga) as harga FROM `tb_detail_pemesanan_stok` WHERE id_pemesanan_stok = '$lastId'");
        //$r=  mysql_fetch_array($cari);
        // mysql_query("update tb_pemesanan_stok set jumlah_tagihan='$r[harga]' where id_pemesanan_stok='$lastId'");
    }
    if ($execute1) {

        header('Location: ../../index.php?r=ro&page=view&status=sukses');
    }
    else
        header('Location: ../../index.php?r=ro&page=view&status=gagal');
}
else
    header('Location: ../../index.php?r=ro&page=view&status=gagal');
?>
