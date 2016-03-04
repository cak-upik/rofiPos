<?php

date_default_timezone_set('Asia/Jakarta');
$seminggu = array("Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu");
$hari = date("w");
$hari_ini = $seminggu[$hari];

$tgl_sekarang = date("Y-m-d");
$thn_sekarang = date("Y");
$bln_sekarang = date("m");
$jam_sekarang = date("H:i:s");
$jam_tampil = date("h:i a.", time());
$today = date("d");

$nama_bln = array(1 => "Januari", "Februari", "Maret", "April", "Mei",
    "Juni", "Juli", "Agustus", "September",
    "Oktober", "November", "Desember");
?>
