<?php

$host = "localhost";
$user = "root";
$pass = "root1234";

$db = "kara";

$konek = mysql_connect($host, $user, $pass);
$dbx = mysql_select_db($db, $konek);

if (!$konek) {
    echo "gagal";
}
if (!$dbx) {
    echo"gagal koneksi database";
}