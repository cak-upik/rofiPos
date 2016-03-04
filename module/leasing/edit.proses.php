<?php

include"../../conf/connect.php";
include "../../conf/fungsi_thumb.php";
include"../../conf/library.php";


$edit = mysql_query("update ref_leasing set 
                            name ='" . mysql_real_escape_string(trim(htmlentities($_POST['name']))) . "',
                            addres ='" . mysql_real_escape_string(trim(htmlentities($_POST['addres']))) . "',
                            phone ='" . mysql_real_escape_string(trim(htmlentities($_POST['phone']))) . "',
                            subleasing ='" . mysql_real_escape_string(trim(htmlentities($_POST['subleasing']))) . "',
                            insentiveleasing ='" . mysql_real_escape_string(trim(htmlentities($_POST['insentiveleasing']))) . "',
                            subAdd ='" . mysql_real_escape_string(trim(htmlentities($_POST['subadd']))) . "'
                         where id='$_POST[id]'");

//echo $edit;
//echo $_POST['subadd'];
//die();

if ($edit) {
    header('Location: ../../index.php?r=leasing&page=view&status=sukses');
} else {
    header('Location: ../../index.php?r=leasing&page=view&status=gagal2');
}
?>
