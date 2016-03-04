<script src="module/lap_pengirimanunit/main.js"></script>
<?php
if (isset($_GET['status'])) {
    if ($_GET['status'] == 'sukses') {
        ?>
        <div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <label class="success">Data berhasil disimpan</label>                
        </div>
        <?php
    } elseif ($_GET['status'] == 'deleted') {
        ?>
        <div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <label>Data berhasil dihapus</label>                
        </div>
        <?php
    } elseif ($_GET['status'] == 'edited') {
        ?>
        <div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <label>Data berhasil diubah</label>                
        </div>
        <?php
    } elseif ($_GET['status'] == 'wrong') {
        ?>
        <div class="alert alert-error">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <label>Maaf data yang anda cari tidak ditemukan</label>                
        </div>
        <?php
    } elseif ($_GET['status'] == 'gagal') {
        ?>
        <div class="alert alert-error">
            <button type="button" class="close" data-dismiss="alert">×</button>
            Proses gagal, coba lagi!              
        </div>
        <?php
    }
}

if (isset($_GET['page'])) {
    $page = $_GET['page'];
    if ($page == 'view') {
        ?>
        <p><button onClick="document.location = 'index.php?r=lap_pengirimanunit&page=laporanhari';" class="btn btn-primary"><i class="icon-file icon-white"></i> Laporan Hari Ini</button>
            <button onClick="document.location = 'index.php?r=lap_pengirimanunit&page=print';" class="btn btn-inverse"><i class="icon-print icon-white"></i> Cetak Laporan </button>
            <!--<button onClick="document.location = 'index.php?r=lap_pengirimanunit&page=laba';" class="btn"><i class="icon-money"></i> Laba Pembelian</button></p>-->

        <table class="table table-bordered table-striped table-highlight">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nota</th>
                    <th>Supplier</th>
                    <th>Tanggal</th>
                    <th>Unit</th>
                    <th>Warna</th>
                    <!--<th>No. Rangka</th>
                    <th>No. Mesin</th>-->
                    <th>Tahun</th>
                    <th>Kuantiti</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $p = new Paging;
                $batas = 15;
                $posisi = $p->cariPosisi($batas);

                $query = mysql_query("SELECT pe.*, dpe.kuantitas, rc.`name` as warna, du.no_rangka, du.no_mesin, u.plafonbbn, du.tahun, 
                                    rs.name as supplier,dpe.id_detail_unit, u.name as unit, du.no_rangka, du.no_mesin, du.tahun,dpe.keterangan
                                    FROM pembelian pe
                                    INNER JOIN detail_pembelian dpe ON dpe.id_pembelian = pe.id_pembelian
                                    INNER JOIN tb_unit u ON u.id = dpe.id_unit 
                                    INNER JOIN tb_detail_unit du ON du.id_detail_unit = dpe.id_detail_unit
                                    INNER JOIN ref_color rc ON rc.id_color = du.id_color
                                    INNER JOIN tb_pemesanan_unit pu ON pu.id_pemesanan_unit = dpe.id_pemesanan_unit
                                    INNER JOIN tb_detail_pemesanan_unit dpu ON dpu.id_detail_pemesanan_unit = pu.id_detail_pemesanan_unit
                                    INNER JOIN ref_supplier rs ON rs.id_supplier = dpe.id_supplier
                                    LIMIT $posisi,$batas");
                $total = mysql_num_rows($query);

                if ($total > 0) {
                    $no = $posisi + 1;
                    while ($result = mysql_fetch_array($query)) {
                        echo"<tr>
                                <td>$no</td>
                                <td>$result[no_faktur]</td>
                                <td>$result[supplier]</td>
                                <td>" . tgl_indo($result['tanggal']) . "</td>
                                <td>$result[unit]</td>
                                <td>$result[warna]</td>
                                <!--<td>$result[no_rangka]</td>
                                <td>$result[no_mesin]</td>-->
                                <td>$result[tahun]</td>
                                <td style='text-align:right;'>$result[kuantitas]</td>
                                <td>$result[keterangan]</td>
                             </tr>";
                        $no++;
                    }
                } else {
                    echo"<tr><td colspan='11'><label>Data Tidak Ditemukan</label></td></tr>";
                }
                ?>
            </tbody>
        </table>
        <?php
        $jmldata = mysql_num_rows(mysql_query("SELECT pe.*, dpe.kuantitas, rc.`name` as warna, du.no_rangka, du.no_mesin, u.plafonbbn, du.tahun, 
                                    rs.name as supplier,dpe.id_detail_unit, u.name as unit, du.no_rangka, du.no_mesin, du.tahun,dpe.keterangan
                                    FROM pembelian pe
                                    INNER JOIN detail_pembelian dpe ON dpe.id_pembelian = pe.id_pembelian
                                    INNER JOIN tb_unit u ON u.id = dpe.id_unit 
                                    INNER JOIN tb_detail_unit du ON du.id_detail_unit = dpe.id_detail_unit
                                    INNER JOIN ref_color rc ON rc.id_color = du.id_color
                                    INNER JOIN tb_pemesanan_unit pu ON pu.id_pemesanan_unit = dpe.id_pemesanan_unit
                                    INNER JOIN tb_detail_pemesanan_unit dpu ON dpu.id_detail_pemesanan_unit = pu.id_detail_pemesanan_unit
                                    INNER JOIN ref_supplier rs ON rs.id_supplier = dpe.id_supplier"));
        $jmlhalaman = $p->jumlahHalaman($jmldata, $batas);
        $linkHalaman = $p->navHalaman($_GET['halaman'], $jmlhalaman);
        echo "<div class='pagination pagination-centered' id=paging>$linkHalaman</div><br>";
    } elseif ($page == 'print') {
        ?>
        <style>
            .header{
                margin: 0 auto; width: 800px; text-align: center;
            }
            .content{
                width:975px; 
                margin: 0 auto;
                font-family: Arial; 
            }
            .note{
                font-size: 13px;
            }
            .detail{
                border: #039;
            }
            hr{
                border: #000 1px solid;
            }
        </style>
        <!--<form name="form" method="POST" action="module/lap_pengirimanunit/print.php?sub=laporan1">-->
        <form name="form" class="form-horizontal" method="POST" action="index.php?r=lap_pengirimanunit&page=print">
            <fieldset>
                <legend><i class="icon icon-filter"></i> Filter Cetak Laporan Pengiriman Unit</legend>
                <div class="well">
                    <?php
                    $date_start = begin_date_month();
                    $date_end = last_date_month();
//                    combotgl(1, 31, 'tgl_filter', $today);
//                    combonamabln(1, 12, 'bln_filter', $bln_sekarang);
//                    combothn($thn_sekarang - 3, $thn_sekarang, 'thn_filter', $thn_sekarang);
                    ?>
                    <!--                    <div class="control-group" >
                                            <label class="control-label">Tanggal </label>
                                            <input type="date" name="date" value="<?php echo date("m-d-Y"); ?>"/> -<input type="date" name="date2" value="<?php echo date("m-d-Y"); ?>"/>
                                            <button class="btn btn-primary" name="search" type="submit"><i class="icon icon-print"></i> Submit</button>
                                        </div>-->
                    <!--<div class="control-group">-->
                    <label>Tanggal </label>
                    <!--<div class="controls">--> 
                    <div class="input-daterange" id="event_period">
                        <input type="date" name="date1" class="input-medium" value="<?php echo $date_start; ?>" />
                        <span class="add-on"> Sampai </span>
                        <input type="date" name="date2" class="input-medium" value="<?php echo $date_end; ?>" />
                        <button class="btn btn-primary" name="search" type="submit"> Submit</button>
                        <!--</div>-->
                    </div>
                </div>
            </fieldset>
        </form>

        <?php
//        $tgl = $_POST['tgl_filter'];
        $bulan = $_POST['bln_filter'];
        $tahun = $_POST['thn_filter'];
        $month = $bulan . "-" . $tahun;
//        $tgl1 = $_POST['date1'];
//        $tgl2 = $_POST['date2'];

        $query = mysql_query("SELECT pe.*, dpe.kuantitas, rc.`name` as warna, du.no_rangka, du.no_mesin, u.plafonbbn, du.tahun, 
                                    rs.name as supplier,dpe.id_detail_unit
                                    FROM pembelian pe
                                    INNER JOIN detail_pembelian dpe ON dpe.id_pembelian = pe.id_pembelian
                                    INNER JOIN tb_unit u ON u.id = dpe.id_unit 
                                    INNER JOIN tb_detail_unit du ON du.id_detail_unit = dpe.id_detail_unit
                                    INNER JOIN ref_color rc ON rc.id_color = du.id_color
                                    INNER JOIN tb_pemesanan_unit pu ON pu.id_pemesanan_unit = dpe.id_pemesanan_unit
                                    INNER JOIN tb_detail_pemesanan_unit dpu ON dpu.id_detail_pemesanan_unit = pu.id_detail_pemesanan_unit
                                    INNER JOIN ref_supplier rs ON rs.id_supplier = dpe.id_supplier
                                    where pe.tanggal >= '$date_start' and pe.tanggal <= '$date_end'
                                        order by pe.id_pembelian");

        $total = mysql_num_rows($query);
        if ($total > 0) {
            $query2 = mysql_query("SELECT pe.*, dpe.kuantitas, rc.`name` as warna, du.no_rangka, du.no_mesin, u.plafonbbn, du.tahun, 
                                    rs.name as supplier,rs.phone,rs.addres,dpe.id_detail_unit
                                    FROM pembelian pe
                                    INNER JOIN detail_pembelian dpe ON dpe.id_pembelian = pe.id_pembelian
                                    INNER JOIN tb_unit u ON u.id = dpe.id_unit 
                                    INNER JOIN tb_detail_unit du ON du.id_detail_unit = dpe.id_detail_unit
                                    INNER JOIN ref_color rc ON rc.id_color = du.id_color
                                    INNER JOIN tb_pemesanan_unit pu ON pu.id_pemesanan_unit = dpe.id_pemesanan_unit
                                    INNER JOIN tb_detail_pemesanan_unit dpu ON dpu.id_detail_pemesanan_unit = pu.id_detail_pemesanan_unit
                                    INNER JOIN ref_supplier rs ON rs.id_supplier = dpe.id_supplier
                                    where pe.tanggal >= '$date_start' and pe.tanggal <= '$date_end' order by pe.id_pembelian");

            $row = mysql_fetch_array($query2);
            ?>
            <div class="row-fluid">
                <!--<div class="span1"></div>-->
                <div class="span12">
                    <center><h2> Laporan Pengiriman Unit</h2></center>
                    <center><h3>Bulan <?php echo nmbulan($_POST['bln_filter']); ?> / Tahun <?php echo $_POST['thn_filter']; ?></h3></center>
                    <hr/>
                </div>
                <!--<div class="span1"></div>-->
            </div>

            <!--<div class="content">-->
            <table class="table table-bordered table-highlight table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nota</th>
                        <th>Supplier</th>
                        <th>Tanggal</th>
                        <th>Unit</th>
                        <th>Warna</th>
                        <!--<th>No. Rangka</th>
                        <th>No. Mesin</th>-->
                        <th>Tahun</th>
                        <th>Kuantiti</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = mysql_query("SELECT pe.*, dpe.kuantitas, rc.`name` as warna, du.no_rangka, du.no_mesin, u.plafonbbn, du.tahun, 
                                    rs.name as supplier,dpe.id_detail_unit, u.name as unit, du.no_rangka, du.no_mesin, du.tahun,dpe.keterangan
                                    FROM pembelian pe
                                    INNER JOIN detail_pembelian dpe ON dpe.id_pembelian = pe.id_pembelian
                                    INNER JOIN tb_unit u ON u.id = dpe.id_unit 
                                    INNER JOIN tb_detail_unit du ON du.id_detail_unit = dpe.id_detail_unit
                                    INNER JOIN ref_color rc ON rc.id_color = du.id_color
                                    INNER JOIN tb_pemesanan_unit pu ON pu.id_pemesanan_unit = dpe.id_pemesanan_unit
                                    INNER JOIN tb_detail_pemesanan_unit dpu ON dpu.id_detail_pemesanan_unit = pu.id_detail_pemesanan_unit
                                    INNER JOIN ref_supplier rs ON rs.id_supplier = dpe.id_supplier
                                    where pe.tanggal >= '$date_start' and pe.tanggal <= '$date_end'
                                        order by pe.id_pembelian");

                    $total = mysql_num_rows($query);

                    if ($total > 0) {
                        $no = 1;
                        while ($row = mysql_fetch_array($query)) {
                            echo"<tr>
                                        <td>$no</td>
                                        <td>$row[no_faktur]</td>
                                        <td>$row[supplier]</td>
                                        <td>" . tgl_indo($row['tanggal']) . "</td>
                                        <td>$row[unit]</td>
                                        <td>$row[warna]</td>
                                       <!-- <td>$row[no_rangka]</td>
                                        <td>$row[no_mesin]</td>-->
                                        <td>$row[tahun]</td>
                                        <td style='text-align:right;'>$row[kuantitas]</td>
                                        <td>$row[keterangan]</td>
                                     </tr>";
                            $no++;
                        }
                        ?>
                    </tbody>
                </table>
                <?php
//                }
            }
        } else {
            ?>
            <div class="row">
                <div class="span12">
                    <div class="alert alert-info">
                        <center><h2>No Transaction!</h2></center>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
        <div class="row">
            <div class="span12">
                <div class="form-actions">
                    <button class="btn btn-inverse" onclick="window.location.href = 'index.php?r=lap_pengirimanunit&page=view';" >Kembali</button> 
                </div>
            </div>
        </div>
        <?php
    } elseif ($page == 'laba') {
        ?>
        <table class="table table-bordered table-striped table-highlight">
            <thead>
                <tr>
                    <th width="5%">#</th>
                    <th>Tanggal</th>
                    <th>Kode Sparepart</th>
                    <th>Nama Sparepart</th>
                    <th>Kuantitas Terjual</th>
                    <th>Harga Jual Satuan</th>
                    <th>Harga Jual Suplier</th>
                    <th>Laba Satuan</th>
                    <th>Jumlah Laba</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $p = new Paging;
                $batas = 15;
                $posisi = $p->cariPosisi($batas);

                $q1 = mysql_query("select distinct tanggal from tb_lap_pengirimanunit a inner join tb_pelayanan b on a.id_pelayanan=b.id_pelayanan order by tanggal desc LIMIT $posisi,$batas");
                $no = 1;
                while ($row1 = mysql_fetch_array($q1)) {
                    $q2 = mysql_query("select distinct a.id_sparepart, c.nama_sparepart, c.kode_sparepart from tb_lap_pengirimanunit a 
                                        inner join tb_pelayanan b on a.id_pelayanan = b.id_pelayanan 
                                        inner join tb_sparepart c on a.id_sparepart = c.id_sparepart where b.tanggal='$row1[tanggal]'");

                    while ($row2 = mysql_fetch_array($q2)) {
                        $q_jual = mysql_query("select distinct sum(a.kuantitas) as q_jual from tb_lap_pengirimanunit a 
                                                                inner join tb_pelayanan b on a.id_pelayanan = b.id_pelayanan 
                                                                where b.tanggal='$row1[tanggal]' and a.id_sparepart='$row2[id_sparepart]'");
                        $row3 = mysql_fetch_array($q_jual);

                        //harga satuan
                        $hsatuan = mysql_query("select a.harga_jual_satuan, b.harga, (a.harga_jual_satuan-b.harga) as laba from tb_stok a 
                                                inner join tb_detail_pemesanan_stok b on a.id_sparepart=b.id_sparepart 
                                                where a.id_sparepart='$row2[id_sparepart]' order by b.id_pemesanan_stok desc limit 1");
                        $row4 = mysql_fetch_array($hsatuan);

                        $jum_laba = $row3['q_jual'] * $row4['laba'];
                        $arrlaba[] = $jum_laba;

                        echo"<tr>
                                                    <td>$no</td>
                                                    <td>" . tgl_indo($row1['tanggal']) . "</td>
                                                    <td>$row2[kode_sparepart]</td>
                                                    <td>$row2[nama_sparepart]</td>
                                                    <td>$row3[q_jual]</td>
                                                    <td style='text-align:right;'>Rp. " . number_format($row4['harga_jual_satuan'], 2, '.', ',') . "</td>
                                                    <td style='text-align:right;'>Rp. " . number_format($row4['harga'], 2, '.', ',') . "</td>
                                                    <td style='text-align:right;'>Rp. " . number_format($row4['laba'], 2, '.', ',') . "</td>
                                                    <td style='text-align:right;'>Rp. " . number_format($jum_laba, 2, '.', ',') . "</td>
                                                 </tr>";
                        $no++;
                    }
                }
                ?>
                <?php
                $totlab = array_sum($arrlaba);
                //var_dump($totlab1);
                //exit();
                ?>
                <tr>
                    <td colspan="7">&nbsp;</td>
                    <td style="text-align:right;"><b>Total :</b></td>
                    <td style="text-align:right;">Rp. <?php echo number_format($totlab, 2, '.', ',') ?></td>
                </tr>
            </tbody>
        </table>
        <?php
        $jmldata = mysql_num_rows(mysql_query("SELECT pe.*, dpe.kuantitas, rc.`name` as warna, du.no_rangka, du.no_mesin, u.plafonbbn, du.tahun, 
                                    rs.name as supplier,dpe.id_detail_unit, u.name as unit, du.no_rangka, du.no_mesin, du.tahun,dpe.keterangan
                                    FROM pembelian pe
                                    INNER JOIN detail_pembelian dpe ON dpe.id_pembelian = pe.id_pembelian
                                    INNER JOIN tb_unit u ON u.id = dpe.id_unit 
                                    INNER JOIN tb_detail_unit du ON du.id_detail_unit = dpe.id_detail_unit
                                    INNER JOIN ref_color rc ON rc.id_color = du.id_color
                                    INNER JOIN tb_pemesanan_unit pu ON pu.id_pemesanan_unit = dpe.id_pemesanan_unit
                                    INNER JOIN tb_detail_pemesanan_unit dpu ON dpu.id_detail_pemesanan_unit = pu.id_detail_pemesanan_unit
                                    INNER JOIN ref_supplier rs ON rs.id_supplier = dpe.id_supplier"));
        $jmlhalaman = $p->jumlahHalaman($jmldata, $batas);
        $linkHalaman = $p->navHalaman($_GET['halaman'], $jmlhalaman);
        echo "<div class='pagination pagination-centered' id=paging>$linkHalaman</div><br>";
    } elseif ($page == 'laporanhari') {
        ?>
        <form name="form" target="_blank" method="POST" action="module/lap_pengirimanunit/print.php?sub=laporan2">
            <fieldset>
                <legend><i class="icon icon-filter"></i> Filter</legend>
                <div class="well">
                    <?php
                    $hariini = date("d");

                    echo"Cetak Berdasarkan tanggal: ";
                    combotgl(1, $hariini, 'tanggal', $hariini);
                    ?>
                    <input type="submit" name="search" value="Cetak" class="btn btn-warning">
                </div>
            </fieldset>
        </form>
        <center><h2>Laporan Pengiriman Unit Hari Ini</h2></center>
        <br/>
        <table class="table table-bordered table-striped table-highlight">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nota</th>
                    <th>Supplier</th>
                    <th>Tanggal</th>
                    <th>Unit</th>
                    <th>Warna</th>
                    <!--<th>No. Rangka</th>
                    <th>No. Mesin</th>-->
                    <th>Tahun</th>
                    <th>Kuantiti</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $p = new Paging;
                $batas = 15;
                $posisi = $p->cariPosisi($batas);

                $today = date("d");

                $query = mysql_query("SELECT pe.*, dpe.kuantitas, rc.`name` as warna, du.no_rangka, du.no_mesin, u.plafonbbn, du.tahun, 
                                    rs.name as supplier,dpe.id_detail_unit, u.name as unit, du.no_rangka, du.no_mesin, du.tahun,dpe.keterangan
                                    FROM pembelian pe
                                    INNER JOIN detail_pembelian dpe ON dpe.id_pembelian = pe.id_pembelian
                                    INNER JOIN tb_unit u ON u.id = dpe.id_unit 
                                    INNER JOIN tb_detail_unit du ON du.id_detail_unit = dpe.id_detail_unit
                                    INNER JOIN ref_color rc ON rc.id_color = du.id_color
                                    INNER JOIN tb_pemesanan_unit pu ON pu.id_pemesanan_unit = dpe.id_pemesanan_unit
                                    INNER JOIN tb_detail_pemesanan_unit dpu ON dpu.id_detail_pemesanan_unit = pu.id_detail_pemesanan_unit
                                    INNER JOIN ref_supplier rs ON rs.id_supplier = dpe.id_supplier
                                    where substr(pe.tanggal,9,2)= '$today'
                                     order by pe.id_pembelian LIMIT $posisi,$batas");
                $total = mysql_num_rows($query);

                if ($total > 0) {
                    $no = $posisi + 1;
                    while ($result = mysql_fetch_array($query)) {
                        echo"<tr>
                                <td>$no</td>
                                <td>$result[no_faktur]</td>
                                <td>$result[supplier]</td>
                                <td>" . tgl_indo($result['tanggal']) . "</td>
                                <td>$result[unit]</td>
                                <td>$result[warna]</td>
                                <!--<td>$result[no_rangka]</td>
                                <td>$result[no_mesin]</td>-->
                                <td>$result[tahun]</td>
                                <td style='text-align:right;'>$result[kuantitas]</td>
                                <td>$result[keterangan]</td>
                             </tr>";
                        $no++;
                    }
                } else {
                    echo"<tr><td colspan='11'><label>Data Tidak Ditemukan</label></td></tr>";
                }
                ?>
            </tbody>
        </table>
        <?php
        $jmldata = mysql_num_rows(mysql_query("SELECT pe.*, dpe.kuantitas, rc.`name` as warna, du.no_rangka, du.no_mesin, u.plafonbbn, du.tahun, 
                                    rs.name as supplier,dpe.id_detail_unit, u.name as unit, du.no_rangka, du.no_mesin, du.tahun,dpe.keterangan
                                    FROM pembelian pe
                                    INNER JOIN detail_pembelian dpe ON dpe.id_pembelian = pe.id_pembelian
                                    INNER JOIN tb_unit u ON u.id = dpe.id_unit 
                                    INNER JOIN tb_detail_unit du ON du.id_detail_unit = dpe.id_detail_unit
                                    INNER JOIN ref_color rc ON rc.id_color = du.id_color
                                    INNER JOIN tb_pemesanan_unit pu ON pu.id_pemesanan_unit = dpe.id_pemesanan_unit
                                    INNER JOIN tb_detail_pemesanan_unit dpu ON dpu.id_detail_pemesanan_unit = pu.id_detail_pemesanan_unit
                                    INNER JOIN ref_supplier rs ON rs.id_supplier = dpe.id_supplier"));
        $jmlhalaman = $p->jumlahHalaman($jmldata, $batas);
        $linkHalaman = $p->navHalaman($_GET['halaman'], $jmlhalaman);
        echo "<div class='pagination pagination-centered' id=paging>$linkHalaman</div><br>";
        ?>
        <div class="row">
            <div class="span12">
                <div class="form-actions">
                    <button class="btn btn-inverse" onclick="window.location.href = 'index.php?r=lap_pengirimanunit&page=view';" >Kembali</button> 
                </div>
            </div>
        </div>
        <?php
    }
}