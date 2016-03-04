<?php

//$idx = $_SESSION[id_perusahaan];
//$jalan = mysql_query("update usr set last_login=NOW() where id_usr='$idx'");
session_start();
session_destroy();
//if(($levelx=='admin') or ($levelx=='admin'))
//{

header('location:./');
echo "<script>alert('anda telah logout');</script>";
//}
//else
//{
//echo"maaf anda terjadi kesalahan, halaman yang anda tuju tidak ada";
//}