<?php

include"../../conf/connect.php";
include"../../conf/class_paging.php";
include"../../conf/fungsi_indotgl.php";
include"../../conf/library.php";

if (isset($_GET['getname'])) {
    $query = mysql_query("select name from tb_unit where id='$_GET[getname]'");
    $result = mysql_fetch_array($query);

    echo $result['name'];
}