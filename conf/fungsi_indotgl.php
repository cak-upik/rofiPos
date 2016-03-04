<?php

function deadline($tgl) {
    $tanggal = substr($tgl, 8, 2);
    $th = substr($tgl, 0, 4);
    $w = $tanggal - 2;
    if ($w < 10) {
        $t = getTgl($w);
    } else {
        $t = $w;
    }
    $bulan = substr($tgl, 5, 2);
    $tahun = $th + 1;
    return $tahun . '-' . $bulan . '-' . $t;
}

function notifex($tgln) {
    $tanggaln = substr($tgln, 8, 2);
    $thn = substr($tgln, 0, 4);
    $wn = $tanggaln - 2;
    if ($wn < 10) {
        $tn = getTgl($wn);
    } else {
        $tn = $wn;
    }
    $bulan = substr($tgln, 5, 2);

    return $thn . '-' . $bulan . '-' . $tn;
}

function tgl_indo($tgl) {
    $tanggal = substr($tgl, 8, 2);
    $bulanx = substr($tgl, 5, 2);
    $tahun = substr($tgl, 0, 4);
    return $tanggal . '-' . $bulanx . '-' . $tahun;
}

function pukul_indo($pukul) {
    $jam = substr($pukul, 0, 2);
    $menit = substr($pukul, 3, 2);
    $detik = substr($pukul, 7, 2);
    return $jam . ':' . $menit;
}

function nmbulan($tgl) {
    $a = substr($tgl, 5, 2);
    getBulan($a);
    //return $bulans;		 
}

function namaHari($d) {
    if ($d == 'Monday') {
        return 'Senin';
    } elseif ($d == 'Tuesday') {
        return 'Selasa';
    } elseif ($d == 'Wednesday') {
        return 'Rabu';
    } elseif ($d == 'Thursday') {
        return 'Kamis';
    } elseif ($d == 'Friday') {
        return 'Jumat';
    } elseif ($d == 'Saturday') {
        return 'Sabtu';
    } elseif ($d == 'Sunday') {
        return 'Minggu';
    } else {
        return 'ERROR!';
    }
}

function bulan($tgl) {
    $bulan = substr($tgl, 5, 2);
    return $bulan;
}

function triwulan($tgl) {
    $bulan = substr($tgl, 5, 2);
    $bulanx = getTri($bulan);

    return $bulanx;
}

function getTgl($bln) {
    switch ($bln) {
        case 1:
            return "01";
            break;
        case 2:
            return "02";
            break;
        case 3:
            return "03";
            break;
        case 4:
            return "04";
            break;
        case 5:
            return "05";
            break;
        case 6:
            return "06";
            break;
        case 7:
            return "07";
            break;
        case 8:
            return "08";
            break;
        case 9:
            return "09";
            break;

        case 10:
            return "10";
            break;
        case 11:
            return "11";
            break;
        case 12:
            return "12";
            break;
    }
}

function getBulan($bln) {
    switch ($bln) {
        case 01:
            return "Januari";
            break;
        case 02:
            return "Februari";
            break;
        case 03:
            return "Maret";
            break;
        case 04:
            return "April";
            break;
        case 05:
            return "Mei";
            break;
        case 06:
            return "Juni";
            break;
        case 07:
            return "Juli";
            break;
        case 08:
            return "Agustus";
            break;
        case 09:
            return "September";
            break;
        case 10:
            return "Oktober";
            break;
        case 11:
            return "November";
            break;
        case 12:
            return "Desember";
            break;
    }
}

function getTri($bln) {
    switch ($bln) {
        case 1:
            return "1";
            break;
        case 2:
            return "1";
            break;
        case 3:
            return "1";
            break;
        case 4:
            return "2";
            break;
        case 5:
            return "2";
            break;
        case 6:
            return "2";
            break;
        case 7:
            return "3";
            break;
        case 8:
            return "3";
            break;
        case 9:
            return "3";
            break;
        case 10:
            return "4";
            break;
        case 11:
            return "4";
            break;
        case 12:
            return "4";
            break;
    }
}

?>
