<?php
/**
 * Created by PhpStorm.
 * User: kic
 * Date: 11/22/13
 * Time: 3:37 PM
 */
include"connect.php";


function createKey($email){
    $time = time();
    $strKey = base64_encode(implode('||', array($email, $time)));

    return $strKey;
}
function emailExist($email){
    $check=mysql_num_rows(mysql_query("select id_pegawai from tb_pegawai where email='$email'"));
    return $check;
}
function checkKey($key){
    $check=mysql_num_rows(mysql_query("select id from tb_expired_link where linkkey='$key'"));
    return $check;
}

?>