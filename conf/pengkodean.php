<?php

/* function kodeSparepart(){
  $query=mysql_query("SELECT kode_sparepart, (substr(kode_sparepart,7,3) + 1) as id_sparepart FROM `tb_sparepart` order by id_sparepart desc limit 1 ");
  $row=  mysql_fetch_array($query);

  $depan=substr($row['kode_sparepart'],0,5);
  $belakang=$row['id_sparepart'];
  if($belakang == '') $bel='00';
  else $bel=$belakang;
  return $depan.'-'.$bel;
  } */

function kodeTypeMotor() {
    $query = mysql_query("SELECT kode_type_motor, (substr(kode_type_motor,4,2) + 1) as kode_type FROM `tb_type_motor` order by id_type_motor desc limit 1 ");
    $row = mysql_fetch_array($query);

    $depan = substr($row['kode_type_motor'], 0, 2);
    $belakang = getMo($row['kode_type']);
    if ($belakang == '')
        $bel = '00';
    else
        $bel = $belakang;
    return $depan . '-' . $bel;
}

function poNumber() {
    $query = mysql_query("SELECT (substr(no_faktur,14,2) + 1) as kode_po FROM `tb_pemesanan_unit` order by id_pemesanan_unit desc limit 1 ");
    $row = mysql_fetch_array($query);

    $depan = 'PO';
    $tengah = date("dmY");
    $belakang = getMo($row['kode_po']);
    if ($belakang == '')
        $bel = '00';
    else
        $bel = $belakang;
    return $depan . '-' . $tengah . '-' . $bel;
}

function roNumber() {
    $query = mysql_query("SELECT (substr(kode_stok_masuk,14,2) + 1) as kode_ro FROM `tb_stok_masuk` order by id_stok_masuk desc limit 1 ");
    $row = mysql_fetch_array($query);

    $depan = 'RO';
    $tengah = date("dmY");
    $belakang = getMo($row['kode_ro']);
    if ($belakang == '')
        $bel = '00';
    else
        $bel = $belakang;
    return $depan . '-' . $tengah . '-' . $bel;
}

function notaNumber() {
    $query = mysql_query("SELECT (substr(no_faktur,14,2) + 1) as notaNumber FROM `pembelian` order by id_pembelian desc limit 1 ");
    $row = mysql_fetch_array($query);

    $depan = 'PJ';
    $tengah = date("dmY");
    $belakang = getMo($row['notaNumber']);
    if ($belakang == '') {
        $bel = '00';
    } else if ($belakang != '') {
        $bel = $belakang;
    }
    return $depan . '-' . $tengah . '-' . $bel;
}

function fakturNumber() {
    $query = mysql_query("SELECT (substr(no_faktur,14,2) + 1) as notaNumber FROM `penjualan` order by id_penjualan desc limit 1 ");
    $row = mysql_fetch_array($query);

    $depan = 'FA';
    $tengah = date("dmY");
    $belakang = getMo($row['notaNumber']);
    if ($belakang == '') {
        $bel = '00';
    } else if ($belakang != '') {
        $bel = $belakang;
    }
    return $depan . '-' . $tengah . '-' . $bel;
}

function kodeJenisPek() {
    $query = mysql_query("SELECT (substr(kode_jenis_pekerjaan,4,2) + 1) as kode_jenis_pekerjaan FROM `tb_jenis_pekerjaan`
                 order by id_jenis_pekerjaan desc limit 1 ");
    $row = mysql_fetch_array($query);

    $depan = 'JP';
    $belakang = getMo($row['kode_jenis_pekerjaan']);
    if ($belakang == '') {
        $bel = '00';
    } else {
        $bel = $belakang;
    }
    return $depan . '-' . $bel;
}

function returNumber() {
    $query = mysql_query("SELECT (substr(nomor_retur,14,2) + 1) as returNumber FROM `tb_retur` order by id_retur desc limit 1 ");
    $row = mysql_fetch_array($query);

    $depan = 'NR';
    $tengah = date("dmY");
    $belakang = getMo($row['returNumber']);
    if ($belakang == '')
        $bel = '00';
    else {
        $bel = $belakang;
    }
    return $depan . '-' . $tengah . '-' . $bel;
}

function kodeSlip() {
    $query = mysql_query("SELECT (substr(kode_slip_gaji,14,2) + 1) as kodeSlip FROM `tb_gaji` order by id_gaji desc limit 1 ");
    $row = mysql_fetch_array($query);

    $depan = 'SG';
    $tengah = date("dmY");
    $belakang = getMo($row['kodeSlip']);
    if ($belakang == '')
        $bel = '00';
    else
        $bel = $belakang;
    return $depan . '-' . $tengah . '-' . $bel;
}

function getMo($no) {
    if ($no == 1) {
        return "01";
    } elseif ($no == 2) {
        return "02";
    } elseif ($no == 3) {
        return "03";
    } elseif ($no == 4) {
        return "04";
    } elseif ($no == 5) {
        return "05";
    } elseif ($no == 6) {
        return "06";
    } elseif ($no == 7) {
        return "07";
    } elseif ($no == 8) {
        return "08";
    } elseif ($no == 9) {
        return "09";
    } else {
        return $no;
    }
}

function rupiah($nilai) {
    if ($nilai != '') {
        $jadi = "Rp " . number_format($nilai, 0, ',', '.');
    } else {
        $jadi = "Rp -";
    }
    return $jadi;
}

function rupiah1($nilai) {
    if ($nilai != '') {
        $jadi = "". number_format($nilai, 0, ',', '.');
    } else {
        $jadi = "";
    }
    return $jadi;
}

function day_count($month = '', $year = '') {
    if (empty($month)) {
        $month = date('m');
    }
    if (empty($year)) {
        $year = date('Y');
    }
    return date('d', mktime(0, 0, 0, $month + 1, 0, $year));
}

function begin_date_month() {
    $d1 = "01";
    $m1 = Date('m');
    $y1 = Date('Y');
    $date1 = $y1 . "-" . $m1 . "-" . $d1;
    return $date1;
}

function last_date_month() {
    $d2 = day_count();
    $m2 = Date('m');
    $y2 = Date('Y');
    $date2 = $y2 . "-" . $m2 . "-" . $d2;
    return $date2;
}