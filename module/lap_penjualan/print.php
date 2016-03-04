<!--<title>Laporan Penjualan</title>-->
<style>
    .header{
        margin: 0 auto; width: 800px; text-align: center;
    }
    .content{
        width:1000px; margin: 0 auto;
        font-family: monospace; 
    }
    .content2{
        /*width:1255px;*/ 
        /*margin: 0 auto;*/
        margin-left: 50px;
        margin-right: 50px;
        font-family: arial; 
    }
    table{
        border-collapse:collapse;
    }
    .table, .tableb{


        font-family: Arial; 
        font-size: 13px;
    }

    .table th{
        border:1px solid black;
        text-align:center;
        text-transform:capitalize;
    }
    .table tr{
        text-transform:capitalize;

    }
    .table td{
        border-right:1px solid black;
        border-left:1px solid black;
    }
    .info2{
        float:left;
        margin-bottom: 30px;
    }
    .info2 ol table {

        font-size: 12px;
    }
    .info1{
        font-weight:bold;
        float:left;
    }
    .info1 tr{
        font-size: 12px;
    }
    .rightleft{
        height:150px;

    }
    .rightleft .left{
        float:left

    }
    .rightleft .right{
        float:right;}
    .note2{
        font-size: 13px;
    }
    .note2{
        font-size: 12px;
        float: right;
    }
    .detail{
        border: #039;
    }
</style>

<?php
include"../../conf/connect.php";
include"../../conf/class_paging.php";
include"../../conf/fungsi_indotgl.php";
include"../../conf/library.php";
include"../../conf/pengkodean.php";
//include"service.php";

if (isset($_GET['sub'])) {
    $sub = $_GET['sub'];
    if ($sub == 'laporan1') {
        ?>
        <div class="content2" style="margin-top:30px;">
            <center> <img src="../../img/logo.png" class="right" />
                <h2>Laporan Bulanan Penjualan UNIT</h2>
            </center>
            <center><h3>Bulan <?php echo nmbulan($_POST['bln_filter']); ?> / Tahun <?php echo $_POST['thn_filter']; ?></h3>
            </center>
            <div class="row-fluid">
                <div class="span10"></div>
                <div class="span2">
                    <form name="print" method="post" target="_blank" action="index.php?r=pengirimanunit&page=print?bulan=<?php echo $bulan; ?>&tahun=<?php echo $tahun; ?>'">
                        <!--<button class="btn btn-inverse" type="submit"><i class="icon icon-print"></i> Print</button>--> 
                        <input type="submit" name="print" class="btn btn-inverse" value="Print">
                    </form>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span1"></div>
                <div class="span10">
                    <center><h2> Pengiriman Unit</h2></center>
                    <hr/>
                </div>
                <div class="span1"></div>
            </div>
            <div class="row-fluid">
                <div class="span1"></div>
                <div class="span8"><strong>No. Pengiriman : <?php echo $row['no_faktur']; ?></strong></div>
                <div class="span3"><strong>Date : <?php echo tgl_indo($row['tanggal']); ?></strong></div>
            </div>
            <div class="row-fluid">
                <div class="span1"></div>
                <div class="span8">
                    <address>
                        
                    </address>
                </div>
                <div class="span3">
                    <strong>Perusahaan : </strong></br>PT. Meji Sakti 
                </div>
            </div>

            <div class="content">
                <table class="table table-bordered table-highlight table-striped">
                    <thead>
                        <tr>
                            <th width="5%">#</th>
                            <th>No. Faktur</th>
                            <th>Tanggal</th>
                            <th>Unit</th>
                            <th>Warna</th>
                            <th>Harga OTR</th>
                            <th>Uang Muka</th>
                            <th>Diskon</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = mysql_query("SELECT p.*, dp.uang_muka, dp.diskon, u.`name` as unit, u.hargaotr, dp.uang_muka, dp.diskon, 
                                    (u.hargaotr - dp.uang_muka + dp.diskon) as jml, c.`name` as warna 
                                    FROM penjualan p 
                                    INNER JOIN detail_penjualan dp ON dp.id_penjualan = p.id_penjualan
                                    INNER JOIN ref_customer rc ON rc.id_customer = p.id_customer
                                    INNER JOIN ref_leasing rl ON rl.id = p.id_leasing
                                    INNER JOIN tb_unit u ON dp.id_unit = u.id
                                    INNER JOIN tb_detail_unit du ON du.id_detail_unit = dp.id_detail_unit AND du.id_unit = u.id
                                    INNER JOIN ref_color c ON c.id_color = du.id_color 
                                    where substr(p.tanggal,6,2)= '$_POST[bln_filter]' 
                            and substr(p.tanggal,1,4)= '$_POST[thn_filter]' and substr(p.tanggal,9,2)= '$_POST[tgl_filter]'
                                        order by nomor_pelayanan");
                        $total = mysql_num_rows($query);

                        if ($total > 0) {
                            $no = 1;
                            while ($row = mysql_fetch_array($query)) {
                                echo"<tr>
                                <td>$no</td>
                                <td>$row[no_faktur]</td>
                                <td>" . tgl_indo($row['tanggal']) . "</td>
                                <td>$row[unit]</td>
                                <td>$row[warna]</td>
                                <td style='text-align:right;'>" . rupiah($row[hargaotr]) . "</td>
                                <td style='text-align:right;'>" . rupiah($row[uang_muka]) . "</td>
                                <td style='text-align:right;'>" . rupiah($row[diskon]) . "</td>
                                <td style='text-align:right;'>" . rupiah($row[jml]) . "</td>
                             </tr>";
                                $no++;
                            }
                        } else {
                            echo"<tr><td colspan='8'><label>Data Tidak Ditemukan</label></td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="row-fluid">
                <div class="span1"></div>
                <div class="span8"></div>
                <div class="span3">Approved By,</div>
            </div>
            <div class="row">
                <div class="span1"></div>
                <div class="span8"></div>
                <div class="span3">(Staff Gudang)</div>
            </div>

            <?php
        } elseif ($sub == 'laporan2') {
            ?>
            <div class="content2" style="margin-top:30px;">
                <center><img src="../../img/logo.png" class="right" />
                    <h2>  Laporan Penjualan UNIT Tanggal 
                        <?php echo $_POST['tanggal'] ?>-<?php echo $bln_sekarang ?>-<?php echo $thn_sekarang ?></h2>
                </center>
                <center>
                    <table class="table" border="1" cellpadding="8" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nota</th>
                                <th>Customer</th>
                                <th>Leasing</th>
                                <th>Tanggal</th>
                                <th>Unit</th>
                                <th>Warna</th>
                                <th>No. Rangka</th>
                                <th>No. Mesin</th>
                                <th>Tahun</th>
                                <th>HargaOTR</th>
                                <th>Uang Muka</th>
                                <th>Diskon</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $today = date("d");
                            $hari = $_POST['tanggal'];
//                            echo $hari;
                            //and substr(p.tanggal,6,2)= '$_POST[bln_filter]' and substr(p.tanggal,1,4)= '$_POST[thn_filter]'

                            $query = mysql_query("SELECT p.*, dp.uang_muka, dp.diskon, du.tahun, u.`name` as unit, (dp.uang_muka + dp.diskon) as jml, c.name as warna,
                                    rc.`name` as customer, rl.`name` as leasing, du.no_rangka, du.no_mesin, u.hargaotr
                                    FROM penjualan p 
                                    INNER JOIN detail_penjualan dp ON dp.id_penjualan = p.id_penjualan
                                    INNER JOIN ref_customer rc ON rc.id_customer = p.id_customer
                                    INNER JOIN ref_leasing rl ON rl.id = p.id_leasing
                                    INNER JOIN tb_unit u ON dp.id_unit = u.id
                                    INNER JOIN tb_detail_unit du ON du.id_detail_unit = dp.id_detail_unit 
                                    INNER JOIN ref_color c ON c.id_color = du.id_color
                                    where substr(p.tanggal,9,2)= '$hari'
                                    order by p.id_penjualan");

                            $total = mysql_num_rows($query);

                            if ($total > 0) {
                                $no = 1;
                                while ($row = mysql_fetch_array($query)) {
                                    echo"<tr>
                                        <td>$no</td>
                                        <td>$row[no_faktur]</td>
                                        <td>$row[customer]</td>
                                        <td>$row[leasing]</td>
                                        <td>" . tgl_indo($row['tanggal']) . "</td>
                                        <td>$row[unit]</td>
                                        <td>$row[warna]</td>
                                        <td>$row[no_rangka]</td>
                                        <td>$row[no_mesin]</td>
                                        <td>$row[tahun]</td>
                                        <td style='text-align:right;'>" . rupiah($row['hargaotr']) . "</td>
                                        <td style='text-align:right;'>" . rupiah($row['uang_muka']) . "</td>
                                        <td style='text-align:right;'>" . rupiah($row['diskon']) . "</td>
                                        <td style='text-align:right;'>" . rupiah($row['jml']) . "</td>
                                     </tr>";
                                    $no++;
                                }
                            } else {
                                echo"<tr><td colspan='14'><label>Data Tidak Ditemukan</label></td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </center>
                <?php
            }
        }
        ?>
    </div>