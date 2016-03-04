<?php

include"../../conf/connect.php";
include"../../conf/class_paging.php";
include"../../conf/fungsi_indotgl.php";
include"../../conf/library.php";

if (isset($_GET['getname'])) {
    $query = mysql_query("select name from ref_color where id_color='$_GET[getname]'");
    $result = mysql_fetch_array($query);

    echo $result['name'];
} else if (isset($_GET['detail'])) {
    $getDetail = mysql_query("SELECT du.no_rangka, du.no_mesin,du.tahun,du.id_color, du.id_unit, c.name as warna, u.* FROM tb_unit u 
                        inner join tb_detail_unit du on du.id_unit = u.id
                        inner join ref_color c on c.id_color = du.id_color
                    WHERE u.id = '$_GET[detail]'"); 
    $nomor = 1;
    while ($row1 = mysql_fetch_array($getDetail)) {
        echo"<tr>
                <td>$nomor</td>
                <td>$row1[warna]</td>
                <td>$row1[no_rangka]</td>
                <td>$row1[no_mesin]</td>
                <td>$row1[tahun]</td>
                <td style='text-align: right;'>" . rupiah($row1[hargakosongan]) . "</td>
                <td style='text-align: right;'>" . rupiah($row1[plafonbbn]) . "</td>
                <td style='text-align: right;'>" . rupiah($row1[hargaotr]) . "</td>
             </tr>";
        $nomor++;
    }
}