<?php

include"../../conf/connect.php";
include "../../conf/fungsi_thumb.php";
include"../../conf/library.php";


$fotocopy1 = preg_replace("/[^0-9.]/", "", $_POST['fotocopy']);
$lainlain1 = preg_replace("/[^0-9.]/", "", $_POST['lainlain']);
$iklan1 = preg_replace("/[^0-9.]/", "", $_POST['iklan']);
$konsumsi1 = preg_replace("/[^0-9.]/", "", $_POST['konsumsi']);
$bahanbakar1 = preg_replace("/[^0-9.]/", "", $_POST['bahanbakar']);
$atk1 = preg_replace("/[^0-9.]/", "", $_POST['atk']);
$parkirtol1 = preg_replace("/[^0-9.]/", "", $_POST['parkirtol']);
$keamanan1 = preg_replace("/[^0-9.]/", "", $_POST['keamanan']);
$minuman1 = preg_replace("/[^0-9.]/", "", $_POST['minuman']);
$rektelp1 = preg_replace("/[^0-9.]/", "", $_POST['rektelp']);
$rekair1 = preg_replace("/[^0-9.]/", "", $_POST['rekair']);
$listrik1 = preg_replace("/[^0-9.]/", "", $_POST['listrik']);
$komisi1 = preg_replace("/[^0-9.]/", "", $_POST['komisi']);
$gaji1 = preg_replace("/[^0-9.]/", "", $_POST['gaji']);
$pajak1 = preg_replace("/[^0-9.]/", "", $_POST['pajak']);
$sumbangan1 = preg_replace("/[^0-9.]/", "", $_POST['sumbangan']);
$pemeliharaan1 = preg_replace("/[^0-9.]/", "", $_POST['pemeliharaan']);
$materai1 = preg_replace("/[^0-9.]/", "", $_POST['materai']);

$fotocopy = str_replace(".00", "", $fotocopy1);
$lainlain = str_replace(".00", "", $lainlain1);
$iklan = str_replace(".00", "", $iklan1);
$konsumsi = str_replace(".00", "", $konsumsi1);
$bahanbakar = str_replace(".00", "", $bahanbakar1);
$atk = str_replace(".00", "", $atk1);
$parkirtol = str_replace(".00", "", $parkirtol1);
$keamanan = str_replace(".00", "", $keamanan1);
$minuman = str_replace(".00", "", $minuman1);
$rektelp = str_replace(".00", "", $rektelp1);
$rekair = str_replace(".00", "", $rekair1);
$listrik = str_replace(".00", "", $listrik1);
$komisi = str_replace(".00", "", $komisi1);
$gaji = str_replace(".00", "", $gaji1);
$pajak = str_replace(".00", "", $pajak1);
$sumbangan = str_replace(".00", "", $sumbangan1);
$pemeliharaan = str_replace(".00", "", $pemeliharaan1);
$materai = str_replace(".00", "", $materai1);

$q = "UPDATE `ref_biaya_sr` SET `fotocopy` = '" . mysql_real_escape_string(trim(htmlentities($fotocopy))) . "',
                `lainlain` = '" . mysql_real_escape_string(trim(htmlentities($lainlain))) . "',
                `iklan` = '" . mysql_real_escape_string(trim(htmlentities($iklan))) . "',
                `konsumsi` = '" . mysql_real_escape_string(trim(htmlentities($konsumsi))) . "',
                `bahanbakar` = '" . mysql_real_escape_string(trim(htmlentities($bahanbakar))) . "',
                `atk` = '" . mysql_real_escape_string(trim(htmlentities($atk))) . "',
                `parkir_tol` = '" . mysql_real_escape_string(trim(htmlentities($parkirtol))) . "',
                `keamanan` = '" . mysql_real_escape_string(trim(htmlentities($keamanan))) . "',
                `minuman` = '" . mysql_real_escape_string(trim(htmlentities($minuman))) . "',
                `rektelp` = '" . mysql_real_escape_string(trim(htmlentities($rektelp))) . "',
                `rekair` = '" . mysql_real_escape_string(trim(htmlentities($rekair))) . "',
                `listrik` = '" . mysql_real_escape_string(trim(htmlentities($listrik))) . "',
                `komisi` = '" . mysql_real_escape_string(trim(htmlentities($komisi))) . "',
                `gaji` = '" . mysql_real_escape_string(trim(htmlentities($gaji))) . "',
                `pajak` = '" . mysql_real_escape_string(trim(htmlentities($pajak))) . "',
                `sumbangan` = '" . mysql_real_escape_string(trim(htmlentities($sumbangan))) . "',
                `pemeliharaan` = '" . mysql_real_escape_string(trim(htmlentities($pemeliharaan))) . "',
                `materai` = '" . mysql_real_escape_string(trim(htmlentities($materai))) . "' WHERE `ref_biaya_sr`.`id` =$_POST[id]";

$edit = mysql_query($q);

if ($edit) {
    header('Location: ../../index.php?r=biayasr&page=view&status=sukses');
} else {
    header('Location: ../../index.php?r=biayasr&page=view&status=gagal');
}