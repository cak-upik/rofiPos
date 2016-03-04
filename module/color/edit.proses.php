<?php

include"../../conf/connect.php";
include "../../conf/fungsi_thumb.php";
include"../../conf/library.php";


$query = "update ref_color set name ='" . mysql_real_escape_string(trim(htmlentities($_POST['name']))) . "'
where id_color='$_POST[id_color]'";

$edit = mysql_query($query);
if ($edit) {
    header('Location: ../../index.php?r=color&page=view&status=sukses');
} else {
    header('Location: ../../index.php?r=color&page=view&status=gagal');
}
