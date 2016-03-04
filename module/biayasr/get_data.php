<?php
include"../../conf/connect.php";
include "../../conf/fungsi_thumb.php";
include"../../conf/library.php";


if(isset($_GET['id_prov'])){
    $id=$_GET['id_prov'];
    $q=  mysql_query("select * from tb_kota where id_provinsi='$id'");
    while ($row = mysql_fetch_array($q)) {
        echo"<option value='$row[id_kota]'>$row[nama_kota]</option>";
    }
}
?>
