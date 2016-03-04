<?php

include"../../conf/connect.php";
include"../../conf/class_paging.php";
include"../../conf/fungsi_indotgl.php";
include"../../conf/library.php";

if (isset($_GET['search'])) {
    $query = mysql_query("SELECT pm.*, u.name as unit FROM pembelian pm
                                    INNER JOIN tb_unit u ON u.id = pm.id_unit
                                    INNER JOIN tb_detail_unit du ON du.id_unit = u.id_detail_unit = pm.id_detail_unit
                                    INNER JOIN ref_supplier rs ON rs.id_supplier = pm.id_supplier
                                    INNER JOIN tb_pemesanan_unit pu ON pu.id_pemesanan_unit = pm.id_pemesanan_unit
                                    INNER JOIN detail_pembelian dpm ON dpm.id_detail_pembelian = pm.id_detail_pembelian
                where u.unit like '%$_GET[search]%'");
//     -- or b.nama_sparepart like '%$_GET[search]%'
    $no = 1;
    while ($result = mysql_fetch_array($query)) {
        echo "<tr>
                <td>$no</td>
                <td>$result[kode_sparepart]</td>
                <td>$result[nama_sparepart]</td>
                <td>$result[jumlah_stok]</td>
             </tr>";
        $no++;
    }
}
