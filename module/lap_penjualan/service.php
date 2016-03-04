<?php

include"../../conf/connect.php";
include"../../conf/class_paging.php";
include"../../conf/fungsi_indotgl.php";
include"../../conf/library.php";

if (isset($_GET['getproduct'])) {
    $query = mysql_query("SELECT p.*, dp.uang_muka, dp.diskon, (dp.uang_muka + dp.diskon) as jml, rc.`name` as customer, rl.`name` as leasing,rc.id_customer
                                    FROM penjualan p 
                                    INNER JOIN detail_penjualan dp ON dp.id_penjualan = p.id_penjualan
                                    INNER JOIN ref_customer rc ON rc.id_customer = p.id_customer
                                    INNER JOIN ref_leasing rl ON rl.id = p.id_leasing
                                    where rl.id = '$_GET[getproduct]' group by rc.id_customer");
    while ($result = mysql_fetch_array($query)) {
        echo"<!--<option value='all'>ALL</option>-->
                    <option value='$result[id_customer]'>$result[customer]</option>";
    }
}