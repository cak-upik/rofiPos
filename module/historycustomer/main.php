<script src="module/lap_penjualan/main.js"></script>
<?php
include"../../conf/pengkodean.php";
if (isset($_GET['page'])) {
    $page = $_GET['page'];
    if ($page == 'view') {
        ?>
                                                                                <!--        <p><button onClick="document.location = 'index.php?r=lap_penjualan&page=laporanhari';" class="btn btn-primary"><i class="icon-file icon-white"></i> Laporan Hari Ini</button>
                                                                                            <button onClick="document.location = 'index.php?r=lap_penjualan&page=print';" class="btn btn-inverse"><i class="icon-print icon-white"></i> Cetak Laporan </button>
                                                                                            <button onClick="document.location = 'index.php?r=lap_penjualan&page=laba';" class="btn"><i class="icon-money"></i> Laba Penjualan</button></p>-->

        <legend><i class="icon icon-filter"></i> Filter</legend>
        <form name="form" class="form-horizontal" method="POST" action="index.php?r=historycustomer&page=view">
            <?php
            $date_start = begin_date_month();
            $date_end = last_date_month();
            ?>
        <!--            <script type="text/javascript">
                        $(document).ready(function() {
                $('#leasing').change(function() {
                var poid = $(this).val();
                        $.ajax({
                        url: "module/lap_penjualan/service.php",
                                data: "getproduct=" + poid,
                                cache: false,
                                success: function(msg) {
                                console.log(poid);
                                        $('#customer').html(msg);
                                        //                        tbody.html(emptyText);
                                }

                        });
                });
                });</script>-->
            <div class="row-fluid">
                <div class="span12">
                    <div class="control-group">
                        <label class="control-label">Tanggal </label>
                        <div class="controls"> 
                            <div class="input-daterange" id="event_period">
                                <input type="date" name="date1" class="input-medium" value="<?php echo $date_start; ?>" />
                                <span class="add-on"> Sampai </span>
                                <input type="date" name="date2" class="input-medium" value="<?php echo $date_end; ?>" />
                            </div>
                        </div>
                    </div>
                    <!--                    <div class="control-group" >
                                            <label class="control-label">Leasing </label>
                                            <div class="controls">
                                                <select name="leasing" id="leasing" class="input-xxlarge">
                                                    <option value="0">-Pilih-</option>
                                                    <option value="all">ALL</option>
                    <?php
//                    $selectLeasing = mysql_query("select * from ref_leasing order by name");
//                    while ($row = mysql_fetch_array($selectLeasing)) {
//                        echo"<option value='$row[id]'>$row[name]</option>";
//                    }
                    ?>
                                                </select>
                                            </div>
                                        </div>-->
                    <div class="control-group" >
                        <label class="control-label">Customer </label>
                        <div class="controls">
                            <select name="customer" id="customer" class="input-xxlarge">
                                <option value="all">All</option>
                                <?php
                                $selectcustomer = mysql_query("select * from ref_customer order by name");
                                while ($row = mysql_fetch_array($selectcustomer)) {
                                    echo"<option value='$row[id_customer]'>$row[name]</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <button class="btn btn-primary" name="search" type="submit"> Submit</button>
                    </div>
                </div>
                <!--</div>-->
            </div>
            <!--</div>-->
            <!--</fieldset>--><legend></legend>
        </form>

        <table class="table table-bordered table-striped table-highlight">
            <thead>
                <tr>
                    <th>#</th>
                    <th>No. Penjualan</th>
                    <th>Customer</th>
                    <th>Alamat Customer</th>
                    <th>Leasing</th>
                    <th>Tanggal</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $p = new Paging;
                $batas = 15;
                $posisi = $p->cariPosisi($batas);

                $customer = $_POST['customer'];
                $q = "SELECT p.* ,  c.`name` as customer , c.alamat, l.`name` as leasing, u.`name` as unit , 
                    du.id_detail_unit
                    FROM penjualan p  
                    INNER JOIN ref_customer c ON c.id_customer = p.id_customer
                    INNER JOIN ref_leasing l ON l.id = p.id_leasing
                    INNER JOIN detail_penjualan dp ON dp.id_penjualan = p.id_penjualan 
                    INNER JOIN tb_detail_unit du ON du.id_detail_unit = dp.id_detail_unit
                    INNER JOIN tb_unit u ON dp.id_unit = u.id
                    where p.tanggal >= '$date_start' and p.tanggal <= '$date_end'";

                if ($customer != "" && $customer != "all") {
                    $q .= " and c.id_customer = '$customer' ";
                }
                $q .= "GROUP BY p.id_penjualan order by p.id_penjualan DESC LIMIT $posisi,$batas";

                $query = mysql_query($q);
                $total = mysql_num_rows($query);

                if ($total > 0) {
                    $no = 1;
                    while ($result = mysql_fetch_array($query)) {
                        echo"<tr>
                                <td>$no</td>
                                <td>$result[no_faktur]</td>
                                <td>$result[customer]</td>
                                <td>$result[alamat]</td>
                                <td>$result[leasing]</td>
                                <td>" . tgl_indo($result['tanggal']) . "</td>
                                <td>
                                    <a href='#myModal" . $no . "' title='Show Detail' data-toggle='modal' id='id_jual_unit' value='$result[id_penjualan]'><i class='icon-eye-open'></i></a>
                                </td>
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
        $no = 1;
        $q2 = "SELECT p.* ,  c.`name` as customer , l.`name` as leasing, u.`name` as unit , 
                    du.id_detail_unit
                    FROM penjualan p  
                    INNER JOIN ref_customer c ON c.id_customer = p.id_customer
                    INNER JOIN ref_leasing l ON l.id = p.id_leasing
                    INNER JOIN detail_penjualan dp ON dp.id_penjualan = p.id_penjualan 
                    INNER JOIN tb_detail_unit du ON du.id_detail_unit = dp.id_detail_unit
                    INNER JOIN tb_unit u ON dp.id_unit = u.id
                    where p.tanggal >= '$date_start' and p.tanggal <= '$date_end'";

        if ($customer != "" && $customer != "all") {
            $q2 .= " and c.id_customer = '$customer' ";
        }
        $q2 .= "GROUP BY p.id_penjualan order by p.id_penjualan DESC";

        $query2 = mysql_query($q2);
        while ($result2 = mysql_fetch_array($query2)) {
            ?>
            <script type="text/javascript">
                        $('#myModal<?php echo $no; ?>').on('show', function(event) {
                var id_jual_unit = document.getElementById('id').value;
                });</script>
            <!-- Modal -->
            <style type="text/css">
                .modal{
                    left:35%;
                }
            </style>
            <div id="myModal<?php echo $no; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 id="myModalLabel">Detail Penjualan Unit</h4>
                </div>
                <div class="modal-body">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr style="background-color:#ddd; color: black;">
                                <th width="5%">#</th>
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
                            $getDetail = mysql_query("SELECT d.uang_muka, d.diskon, d.jumlah as jml ,u.`name` as unit ,  u.hargakosongan, 
                                                u.hargaotr, du.no_mesin, du.no_rangka,du.tahun,c.`name` as color
                                                FROM detail_penjualan d
                                                INNER JOIN penjualan p ON p.id_penjualan = d.id_penjualan
                                                INNER JOIN tb_unit u ON u.id = d.id_unit
                                                INNER JOIN tb_detail_unit du ON du.id_detail_unit = d.id_detail_unit
                                                INNER JOIN ref_color c ON c.id_color = du.id_color
                                                WHERE d.id_penjualan = '$result2[id_penjualan]'");
                            $num = 1;
                            while ($row1 = mysql_fetch_array($getDetail)) {
                                echo"<tr>
                                        <td>$num</td>
                                        <td>$row1[unit]</td>
                                        <td>$row1[color]</td>
                                        <td>$row1[no_rangka]</td>
                                        <td>$row1[no_mesin]</td>
                                        <td>$row1[tahun]</td>
                                        <td style='text-align: right;'>" . rupiah($row1[hargaotr]) . "</td>
                                        <td style='text-align: right;'>" . rupiah($row1[uang_muka]) . "</td>
                                        <td style='text-align: right;'>" . rupiah($row1[diskon]) . "</td>
                                        <td style='text-align: right;'>" . rupiah($row1[jml]) . "</td>
                                     </tr>";
                                $num++;
                            }
                            ?>
                        </tbody> 
                    </table>
                </div>
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                </div>
            </div>
            <?php
            $no++;
        }
        $jmldata = mysql_num_rows(mysql_query("SELECT p.*, dp.uang_muka, dp.diskon, du.tahun, u.`name` as unit, (dp.uang_muka + dp.diskon) as jml, c.name as warna,
                                    rc.`name` as customer, rl.`name` as leasing, du.no_rangka, du.no_mesin, u.hargaotr
                                    FROM penjualan p 
                                    INNER JOIN detail_penjualan dp ON dp.id_penjualan = p.id_penjualan
                                    INNER JOIN ref_customer rc ON rc.id_customer = p.id_customer
                                    INNER JOIN ref_leasing rl ON rl.id = p.id_leasing
                                    INNER JOIN tb_unit u ON u.id = dp.id_detail_unit
                                    INNER JOIN tb_detail_unit du ON du.id_detail_unit = dp.id_detail_unit 
                                    INNER JOIN ref_color c ON c.id_color = du.id_color"));
        $jmlhalaman = $p->jumlahHalaman($jmldata, $batas);
        $linkHalaman = $p->navHalaman($_GET['halaman'], $jmlhalaman);
        echo "<div class='pagination pagination-centered' id=paging>$linkHalaman</div><br>";
    } elseif ($page == 'print') {
        ?>
        <script src="module/lap_penjualan/main.js"></script>
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
        <!--<form name="form" target="_blank" method="POST" action="module/lap_penjualan/print.php?sub=laporan1">-->

        <legend><i class="icon icon-filter"></i> Filter</legend>
        <form name="form" class="form-horizontal" method="POST" action="index.php?r=lap_penjualan&page=print">
            <?php
            $date_start = begin_date_month();
            $date_end = last_date_month();
            ?>
            <script type="text/javascript">
                        $(document).ready(function() {
                $('#leasing').change(function() {
                var poid = $(this).val();
                        $.ajax({
                        url: "module/lap_penjualan/service.php",
                                data: "getproduct=" + poid,
                                cache: false,
                                success: function(msg) {
                                console.log(poid);
                                        $('#customer').html(msg);
                                        //                        tbody.html(emptyText);
                                }

                        });
                });
                });</script>
            <div class="row-fluid">
                <div class="span12">
                    <div class="control-group">
                        <label class="control-label">Tanggal </label>
                        <div class="controls"> 
                            <div class="input-daterange" id="event_period">
                                <input type="date" name="date1" class="input-medium" value="<?php echo $date_start; ?>" />
                                <span class="add-on"> Sampai </span>
                                <input type="date" name="date2" class="input-medium" value="<?php echo $date_end; ?>" />
                            </div>
                        </div>
                    </div>
                    <div class="control-group" >
                        <label class="control-label">Leasing </label>
                        <div class="controls">
                            <select name="leasing" id="leasing" class="input-xxlarge">
                                <option value="0">-Pilih-</option>
                                <!--<option value="all">ALL</option>-->
                                <?php
                                $selectLeasing = mysql_query("select * from ref_leasing order by name");
                                while ($row = mysql_fetch_array($selectLeasing)) {
                                    echo"<option value='$row[id]'>$row[name]</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="control-group" >
                        <label class="control-label">Customer </label>
                        <div class="controls">
                            <select name="customer" id="customer" class="input-xxlarge">
                            </select>
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <button class="btn btn-primary" name="search" type="submit"> Submit</button>
                    </div>
                </div>
                <!--</div>-->
            </div>
            <!--</div>-->
            <!--</fieldset>--><legend></legend>
        </form>

        <?php
        $tgl1 = $_POST['date'];
        $tgl2 = $_POST['date2'];
        $customer = $_POST['customer'];
        $leasing = $_POST['leasing'];
//        echo $date_start;
//        echo $date_end;

        $q = "SELECT p.*, dp.uang_muka, dp.diskon, (dp.uang_muka + dp.diskon) as jml, c.name as warna,
                                    rc.`name` as customer, rl.`name` as leasing , du.no_rangka, du.no_mesin, u.hargaotr, du.tahun, u.`name` as unit
                                    FROM penjualan p 
                                    INNER JOIN detail_penjualan dp ON dp.id_penjualan = p.id_penjualan
                                    INNER JOIN ref_customer rc ON rc.id_customer = p.id_customer
                                    INNER JOIN ref_leasing rl ON rl.id = p.id_leasing
                                    INNER JOIN tb_unit u on u.id = dp.id_unit
                                    INNER JOIN tb_detail_unit du on du.id_unit = u.id
                                    INNER JOIN ref_color c on c.id_color = du.id_color 
                                    where p.tanggal >= '$date_start' and p.tanggal <= '$date_end'";

        if ($customer != "" && $customer != "all") {
            $q .= "and rc.id_customer = '$customer' ";
        }
        if ($leasing != "" && $leasing != "all") {
            $q .= " and rl.id = '$leasing' ";
        }

        $q .= " GROUP by p.id_penjualan order by p.id_penjualan";


        $query = mysql_query($q);
//        echo $q;
//        die();
        $total = mysql_num_rows($query);
        if ($total > 0) {
            $q2 = "SELECT p.*, dp.uang_muka, dp.diskon, (dp.uang_muka + dp.diskon) as jml, c.name as warna,
                                    rc.`name` as customer, rl.`name` as leasing , du.no_rangka, du.no_mesin, u.hargaotr, du.tahun, u.`name` as unit
                                    FROM penjualan p 
                                    INNER JOIN detail_penjualan dp ON dp.id_penjualan = p.id_penjualan
                                    INNER JOIN ref_customer rc ON rc.id_customer = p.id_customer
                                    INNER JOIN ref_leasing rl ON rl.id = p.id_leasing
                                    INNER JOIN tb_unit u on u.id = dp.id_unit
                                    INNER JOIN tb_detail_unit du on du.id_unit = u.id
                                    INNER JOIN ref_color c on c.id_color = du.id_color 
                                    where p.tanggal >= '$date_start' and p.tanggal <= '$date_end'";
//            $q2 = "SELECT p.*, dp.uang_muka, dp.diskon, (dp.uang_muka + dp.diskon) as jml, c.name as warna,
//                                    rc.`name` as customer, rl.`name` as leasing , du.no_rangka, du.no_mesin, u.hargaotr, du.tahun, u.`name` as unit
//                                    FROM penjualan p  
//                                    INNER JOIN ref_customer rc ON rc.id_customer = p.id_customer
//                                    INNER JOIN ref_leasing l ON l.id = p.id_leasing
//                                    INNER JOIN detail_penjualan dp ON dp.id_penjualan = p.id_penjualan 
//                                    INNER JOIN tb_detail_unit du ON du.id_detail_unit = dp.id_detail_unit
//                                    INNER JOIN tb_unit u ON dp.id_unit = u.id
//                                    INNER JOIN ref_color r on rc.id_color = du.id_color";

            if ($customer != "" && $customer != "all") {
                $q2 .= "and rc.id_customer = '$customer' ";
            }
            if ($leasing != "" && $leasing != "all") {
                $q2 .= " and rl.id = '$leasing' ";
            }

            $q2 .= " GROUP by p.id_penjualan order by p.id_penjualan";

            $query2 = mysql_query($q2);

            $row = mysql_fetch_array($query2);
            ?>
            <div class="row-fluid">
                <!--<div class="span1"></div>-->
                <div class="span12">
                    <center><h2> Laporan Penjualan Unit</h2></center>
                    <center><h3>Bulan <?php echo nmbulan($_POST['bln_filter']); ?> / Tahun <?php echo $_POST['thn_filter']; ?></h3></center>
                    <hr/>
                </div>
                <table class="table table-bordered table-highlight table-striped">
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
                        $q3 = "SELECT p.*, dp.uang_muka, dp.diskon, (dp.uang_muka + dp.diskon) as jml, c.name as warna,
                                    rc.`name` as customer, rl.`name` as leasing , du.no_rangka, du.no_mesin, u.hargaotr, du.tahun, u.`name` as unit
                                    FROM penjualan p 
                                    INNER JOIN detail_penjualan dp ON dp.id_penjualan = p.id_penjualan
                                    INNER JOIN ref_customer rc ON rc.id_customer = p.id_customer
                                    INNER JOIN ref_leasing rl ON rl.id = p.id_leasing
                                    INNER JOIN tb_unit u on u.id = dp.id_unit
                                    INNER JOIN tb_detail_unit du on du.id_unit = u.id
                                    INNER JOIN ref_color c on c.id_color = du.id_color 
                                    where p.tanggal >= '$date_start' and p.tanggal <= '$date_end'";
                        if ($customer != "" && $customer != "all") {
                            $q3 .= "and rc.id_customer = '$customer' ";
                        }
                        if ($leasing != "" && $leasing != "all") {
                            $q3 .= " and rl.id = '$leasing' ";
                        }

                        $q3 .= " GROUP by p.id_penjualan order by p.id_penjualan";

//                        echo $q3;
//                        die();
                        $query = mysql_query($q3);

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
                                    <td style = 'text-align:right;'>" . rupiah($row['hargaotr']) . "</td>
                                    <td style = 'text-align:right;'>" . rupiah($row['uang_muka']) . "</td>
                                    <td style = 'text-align:right;'>" . rupiah($row['diskon']) . "</td>
                                    <td style = 'text-align:right;'>" . rupiah($row['jml']) . "</td>
                                    </tr>";
                                $no++;
                            }
                            ?>
                        </tbody>
                    </table>
                    <?php
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
                        <button class="btn btn-inverse" onclick="window.location.href = 'index.php?r=lap_penjualan&page=view';" >Kembali</button> 
                    </div>
                </div>
            </div>
            <?php
        } elseif ($page == 'laba') {
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
            ?>            

            <legend><i class="icon icon-filter"></i> Filter Laba  
                <div class="btn-group pull-right">
                    <button class="btn btn-danger dropdown-toggle" data-toggle="dropdown"><i class="icon-signal icon-white"></i> Grafik Penjualan <span class="caret"></span></button>
                    <ul class="dropdown-menu">
                        <li><a href="index.php?r=lap_penjualan&page=labagrafikDate"><i class="icon-align-left"></i> Laba Per Tanggal</a></li>
                        <li class="divider"></li>
                        <li><a href="index.php?r=lap_penjualan&page=labagrafikMonth"><i class="icon-align-left"></i> Laba Per Bulan</a></li>
                        <!--                        <li class="divider"></li>
                                                <li><a href="index.php?r=lap_penjualan&page=labagrafikYear"><i class="icon-list"></i> Laba Per Tahun</a></li>-->
                    </ul>
                </div>
                <!--<p class="pull-right"><button onClick="document.location = 'index.php?r=lap_penjualan&page=labagrafik';" class="btn btn-tertiary"><i class="icon-signal icon-white"></i> Laba Grafik</button></p>-->
            </legend>
            <form name="form" class="form-horizontal" method="POST" action="index.php?r=lap_penjualan&page=laba">
                <?php
                $date_start = begin_date_month();
                $date_end = last_date_month();
                combonamabln(1, 12, 'bln_filter', $bln_sekarang);
                combothn($thn_sekarang - 3, $thn_sekarang, 'thn_filter', $thn_sekarang);
                ?>    
                <button class="btn btn-primary" name="search" type="submit"> Submit</button>
            </form>
            <legend></legend>

            <?php
            $month = $_POST['bln_filter'];
            $year = $_POST['thn_filter'];

            $p = new Paging;
            $batas = 15;
            $posisi = $p->cariPosisi($batas);
            $q = "SELECT p.*, dp.uang_muka, dp.diskon, u.`name` as unit, u.hargaotr, rl.name as leasing,
                                        (u.hargaotr - dp.uang_muka + dp.diskon) as jml, c.`name` as warna, rc.name as customer, rc.alamat, rc.phone, du.no_rangka, du.no_mesin,
                                        du.tahun, u.plafonbbn, dp.uang_muka, dp.diskon, dp.subsidi, dp.tambah_subsidi, dp.real, dp.profit, dp.up_price, dp.diskon_stsj,
                                        dp.insentif, dp.hadiah, dp.jaket, dp.lain_lain, dp.bonus, dp.average,
                                        (dp.diskon_stsj + dp.subsidi + dp.profit + dp.insentif - dp.diskon + dp.up_price + dp.subsidi - dp.hadiah - dp.jaket - dp.lain_lain - dp.bonus) as laba_kotor
                                        FROM penjualan p
                                        INNER JOIN detail_penjualan dp ON dp.id_penjualan = p.id_penjualan
                                        INNER JOIN ref_customer rc ON rc.id_customer = p.id_customer
                                        INNER JOIN ref_leasing rl ON rl.id = p.id_leasing
                                        INNER JOIN tb_unit u ON u.id = dp.id_detail_unit
                                        INNER JOIN tb_detail_unit du ON du.id_detail_unit = dp.id_detail_unit
                                        INNER JOIN ref_color c ON c.id_color = du.id_color";

//                    if (isset($_POST['search']) == true) {
            $q.= " where substr(p.tanggal,6,2)= '$month' and substr(p.tanggal,1,4) = '$year'";
            $q.= "group by p.id_penjualan order by p.id_penjualan desc";
//                    } else {
//                        $q.= "group by p.id_penjualan order by p.id_penjualan desc";
//                    }
            $query = mysql_query($q);
            $total = mysql_num_rows($query);

            if ($total > 0) {
                ?>
                <center><h2>Laporan Laba Penjualan</h2></center>
                <table class="table table-bordered table-striped table-highlight">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nota</th>
                            <th>Customer</th>
                            <th>Tanggal</th> 
                            <th>Leasing</th>
                            <th>Unit Nama</th>
                            <th>Warna</th>
                            <th>Rangka</th>
                            <th>Mesin</th>
                            <th>Tahun</th>
                            <th rowspan="2" colspan="2">Act</th> 
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        while ($row = mysql_fetch_array($query)) {
                            echo"<tr>
                        <td>$no</td>
                        <td>$row[no_faktur]</td>
                        <td>$row[customer]</td>
                        <td>" . tgl_indo($row['tanggal']) . "</td>
                        <td>$row[leasing]</td>
                        <td>$row[unit]</td>
                        <td>$row[warna]</td>
                        <td>$row[no_rangka]</td>
                        <td>$row[no_mesin]</td>
                        <td>$row[tahun]</td>
                        <td>
                        <a href = '#myModal" . $no . "' title = 'Show Detail' data-toggle = 'modal' id = 'id_lap_jual' value = '$row[id_penjualan]'><i class = 'icon-eye-open'></i></a>
                        </td>";

                            if ($row['subsidi'] == 0 || $row['tambah_subsidi'] == 0 || $row['real'] == 0 || $row['profit'] == 0 ||
                                    $row['up_price'] == 0 || $row['diskon_stsj'] == 0 || $row['insentif'] == 0 || $row['hadiah'] == 0 ||
                                    $row['jaket'] == 0 || $row['lain_lain'] == 0 || $row['bonus'] == 0) {
                                ?>
                                                                                                                                                                                                                            <!--<td style='text-align:right;'>" . rupiah($row['average']) . "</td>-->
                            <td><a href="index.php?r=lap_penjualan&page=editlaba&id=<?php echo $row['id_penjualan'];
                                ?>"/><i class="icon-edit"></i></td>
                                   <?php
                               } else {
                                   echo "<td>-</td>";
                               }
                               echo "</tr>";
                               $no++;
                           }

                           $query_total = mysql_query("SELECT (dp.diskon_stsj + dp.subsidi + dp.profit + dp.insentif - dp.diskon + dp.up_price + dp.subsidi - dp.hadiah - 
                        dp.jaket - dp.lain_lain - dp.bonus) as laba_kotor, sum(dp.average) as rata_rata, sum(laba_kotor) as laba FROM penjualan p 
                        INNER JOIN detail_penjualan dp ON dp.id_penjualan = p.id_penjualan 
                        INNER JOIN ref_customer rc ON rc.id_customer = p.id_customer 
                        INNER JOIN ref_leasing rl ON rl.id = p.id_leasing 
                        INNER JOIN tb_unit u ON u.id = dp.id_detail_unit 
                        INNER JOIN tb_detail_unit du ON du.id_detail_unit = dp.id_detail_unit 
                        INNER JOIN ref_color c ON c.id_color = du.id_color 
                        order by p.id_penjualan desc");

                           $result = mysql_fetch_array($query_total);
                           ?>
            <!--                <tr>
            <td style="text-align:right;" colspan="24"><b>Total :</b></td>
            <td style="text-align:right;" colspan="1"><?php echo rupiah($result['laba']) ?></td>
            <td style="text-align:right;" colspan="1"><?php echo rupiah($result['rata_rata']) ?></td>
            <td></td>
            </tr>-->
                    </tbody>
                </table>
                <!--</div>-->
                <?php
                $no = 1;
                $query2 = mysql_query("SELECT p.*, dp.uang_muka, dp.diskon, u.`name` as unit, u.hargaotr, rl.name as leasing,
                                    (u.hargaotr - dp.uang_muka + dp.diskon) as jml, c.`name` as warna, rc.name as customer, rc.alamat, rc.phone, du.no_rangka, du.no_mesin,
                                    du.tahun, u.plafonbbn,dp.uang_muka, dp.diskon,dp.subsidi, dp.tambah_subsidi,dp.real,dp.profit,dp.up_price,dp.diskon_stsj,
                                    dp.insentif,dp.hadiah,dp.jaket,dp.lain_lain,dp.bonus,dp.average,
                                    (dp.diskon_stsj + dp.subsidi + dp.profit + dp.insentif - dp.diskon + dp.up_price + dp.subsidi - dp.hadiah - dp.jaket - dp.lain_lain - dp.bonus) as laba_kotor
                                    FROM penjualan p 
                                    INNER JOIN detail_penjualan dp ON dp.id_penjualan = p.id_penjualan
                                    INNER JOIN ref_customer rc ON rc.id_customer = p.id_customer
                                    INNER JOIN ref_leasing rl ON rl.id = p.id_leasing
                                    INNER JOIN tb_unit u ON u.id = dp.id_detail_unit
                                    INNER JOIN tb_detail_unit du ON du.id_detail_unit = dp.id_detail_unit 
                                    INNER JOIN ref_color c ON c.id_color = du.id_color
                                    order by p.id_penjualan desc");
                while ($result2 = mysql_fetch_array($query2)) {
                    ?>
                    <script type="text/javascript">
                                $('#myModal<?php echo $no; ?>').on('show', function(event) {
                        var id_lap_jual = document.getElementById('id').value;
                        });</script>
                    <!-- Modal -->
                    <style type="text/css">
                        .modal{
                            left:21%;
                        }
                    </style>
                    <div id="myModal<?php echo $no; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h4 id="myModalLabel">Detail Laporan Penjualan Unit</h4>
                        </div>
                        <div class="modal-body">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr style="background-color:#ddd; color: black;">
                                        <th width="1%">#</th>
                                        <th>Uang Muka</th>
                                        <th>Subsidi</th>      
                                        <th>Tambah Subsidi</th>      
                                        <th>Diskon</th>    
                                        <th>Diskon STSJ</th>
                                        <th>Insentif</th>
                                        <th>PlafonBBn</th>
                                        <th>Real</th>
                                        <th>Profit</th>
                                        <th>UP-Price</th>
                                        <th>Jaket</th>
                                        <th>Lain-lain</th>
                                        <th>Hadiah</th> 
                                        <th>Bonus</th>  
                    <!--                                <th>Laba Kotor</th>
                                        <th>Rata-Rata</th>-->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $getDetail = mysql_query("SELECT p.*, dp.uang_muka, dp.diskon, u.`name` as unit, u.hargaotr, rl.name as leasing,
                                        (u.hargaotr - dp.uang_muka + dp.diskon) as jml, c.`name` as warna, rc.name as customer, rc.alamat, rc.phone, du.no_rangka, du.no_mesin,
                                        du.tahun, u.plafonbbn,dp.uang_muka, dp.diskon,dp.subsidi, dp.tambah_subsidi,dp.real,dp.profit,dp.up_price,dp.diskon_stsj,
                                        dp.insentif,dp.hadiah,dp.jaket,dp.lain_lain,dp.bonus,dp.average,
                                        (dp.diskon_stsj + dp.subsidi + dp.profit + dp.insentif - dp.diskon + dp.up_price + dp.subsidi - dp.hadiah - dp.jaket - dp.lain_lain - dp.bonus) as laba_kotor
                                        FROM penjualan p 
                                        INNER JOIN detail_penjualan dp ON dp.id_penjualan = p.id_penjualan
                                        INNER JOIN ref_customer rc ON rc.id_customer = p.id_customer
                                        INNER JOIN ref_leasing rl ON rl.id = p.id_leasing
                                        INNER JOIN tb_unit u ON u.id = dp.id_detail_unit
                                        INNER JOIN tb_detail_unit du ON du.id_detail_unit = dp.id_detail_unit 
                                        INNER JOIN ref_color c ON c.id_color = du.id_color
                                        WHERE p.id_penjualan = '$result2[id_penjualan]'");
                                    $num = 1;
                                    while ($row1 = mysql_fetch_array($getDetail)) {
                                        echo"<tr>
                                        <td>$num</td>
                                        <td style='text-align: right;'>" . rupiah($row1[uang_muka]) . "</td>
                                        <td style='text-align: right;'>" . rupiah($row1[subsidi]) . "</td>
                                        <td style='text-align: right;'>" . rupiah($row1[tambah_subsidi]) . "</td>
                                        <td style='text-align: right;'>" . rupiah($row1[diskon]) . "</td>
                                        <td style='text-align: right;'>" . rupiah($row1[diskon_stsj]) . "</td>
                                        <td style='text-align: right;'>" . rupiah($row1[insentif]) . "</td>
                                        <td style='text-align: right;'>" . rupiah($row1[plafonbbn]) . "</td>
                                        <td style='text-align: right;'>" . rupiah($row1[real]) . "</td>
                                        <td style='text-align: right;'>" . rupiah($row1[profit]) . "</td>
                                        <td style='text-align: right;'>" . rupiah($row1[up_price]) . "</td>                                            
                                        <td style='text-align: right;'>" . rupiah($row1[jaket]) . "</td>
                                        <td style='text-align: right;'>" . rupiah($row1[lain_lain]) . "</td>
                                        <td style='text-align: right;'>" . rupiah($row1[hadiah]) . "</td>
                                        <td style='text-align: right;'>" . rupiah($row1[bonus]) . "</td>
                                       </tr>";
                                        $num++;
                                    }
                                    ?>
                                </tbody> 
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                        </div>
                    </div>


                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <!--                                <th>Diskon STSJ</th>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <th>Insentif</th>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <th>PlafonBBn</th>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <th>Real</th>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <th>Profit</th>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <th>UP-Price</th>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <th>Jaket</th>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <th>Lain-lain</th>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <th>Hadiah</th> 
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <th>Bonus</th>  
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <th>Laba Kotor</th>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <th>Rata-Rata</th>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <td style='text-align: right;'>" . rupiah($row1[diskon_stsj]) . "</td>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <td style='text-align: right;'>" . rupiah($row1[insentif]) . "</td>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <td style='text-align: right;'>" . rupiah($row1[plafonbbn]) . "</td>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <td style='text-align: right;'>" . rupiah($row1[real]) . "</td>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <td style='text-align: right;'>" . rupiah($row1[profit]) . "</td>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <td style='text-align: right;'>" . rupiah($row1[up_price]) . "</td>                                            
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <td style='text-align: right;'>" . rupiah($row1[jaket]) . "</td>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <td style='text-align: right;'>" . rupiah($row1[lain_lain]) . "</td>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <td style='text-align: right;'>" . rupiah($row1[hadiah]) . "</td>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <td style='text-align: right;'>" . rupiah($row1[bonus]) . "</td>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <td style='text-align: right;'>" . rupiah($row1[laba_kotor]) . "</td>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <td style='text-align: right;'>" . rupiah($row1[average]) . "</td>-->
                    <?php
                    $no++;
                }
                $jmldata = mysql_num_rows(mysql_query("SELECT p.*, dp.uang_muka, dp.diskon, u.`name` as unit, u.hargaotr, dp.uang_muka, dp.diskon, rl.name as leasing,
                                    (u.hargaotr - dp.uang_muka + dp.diskon) as jml, c.`name` as warna, rc.name as customer, rc.alamat, rc.phone, du.no_rangka, du.no_mesin,
                                    du.tahun
                                    FROM penjualan p 
                                    INNER JOIN detail_penjualan dp ON dp.id_penjualan = p.id_penjualan
                                    INNER JOIN ref_customer rc ON rc.id_customer = p.id_customer
                                    INNER JOIN ref_leasing rl ON rl.id = p.id_leasing
                                    INNER JOIN tb_unit u ON u.id = dp.id_detail_unit
                                    INNER JOIN tb_detail_unit du ON du.id_detail_unit = dp.id_detail_unit 
                                    INNER JOIN ref_color c ON c.id_color = du.id_color"));
                $jmlhalaman = $p->jumlahHalaman($jmldata, $batas);
                $linkHalaman = $p->navHalaman($_GET['halaman'], $jmlhalaman);
                echo "<div class='pagination pagination-centered' id=paging>$linkHalaman</div><br>";
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
                        <button class="btn btn-inverse" onclick="window.location.href = 'index.php?r=lap_penjualan&page=view';" >Kembali</button> 
                    </div>
                </div>
            </div>
            <?php
        } elseif ($page == 'editlaba') {
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $query_edit = mysql_query("SELECT p.*, dp.uang_muka, dp.diskon, u.`name` as unit, u.hargaotr, rl.name as leasing,dp.id_detail_penjualan,
                                    (u.hargaotr - dp.uang_muka + dp.diskon) as jml, c.`name` as warna, rc.name as customer, rc.alamat, rc.phone, du.no_rangka, du.no_mesin,
                                    du.tahun, u.plafonbbn,dp.uang_muka, dp.diskon,dp.subsidi, dp.tambah_subsidi,dp.real,dp.profit,dp.up_price,dp.diskon_stsj,
                                    dp.insentif,dp.hadiah,dp.jaket,dp.lain_lain,dp.bonus,dp.average,
                                    (dp.diskon_stsj + dp.subsidi + dp.profit + dp.insentif - dp.diskon + dp.up_price + dp.subsidi - dp.hadiah - dp.jaket - dp.lain_lain - dp.bonus) as laba_kotor
                                    FROM penjualan p 
                                    INNER JOIN detail_penjualan dp ON dp.id_penjualan = p.id_penjualan
                                    INNER JOIN ref_customer rc ON rc.id_customer = p.id_customer
                                    INNER JOIN ref_leasing rl ON rl.id = p.id_leasing
                                    INNER JOIN tb_unit u ON u.id = dp.id_detail_unit
                                    INNER JOIN tb_detail_unit du ON du.id_detail_unit = dp.id_detail_unit 
                                    INNER JOIN ref_color c ON c.id_color = du.id_color
                                    where p.id_penjualan='$id'");
                $row = mysql_fetch_array($query_edit);
                ?>

                <script type="text/javascript">
                            function sum() {
                            var uangmuka = document.getElementById('uangmuka').value;
                                    var plafonbbn = document.getElementById('plafonbbn').value;
                                    var tambah_subsidi = document.getElementById('tambah_subsidi').value;
                                    var diskon_stsj = document.getElementById('diskon_stsj').value;
                                    var subsidi = document.getElementById('subsidi').value;
                                    var real = document.getElementById('real').value;
                                    //                    var profit = document.getElementById('profit').value;                     var insentif = document.getElementById('insentif').value;
                                    var diskon = document.getElementById('diskon').value;
                                    var up_price = document.getElementById('up_price').value;
                                    var insentif = document.getElementById('insentif').value;
                                    var subsidi = document.getElementById('subsidi').value;
                                    var hadiah = document.getElementById('hadiah').value;
                                    var jaket = document.getElementById('jaket').value;
                                    var lain_lain = document.getElementById('lain_lain').value;
                                    var bonus = document.getElementById('bonus').value;
                                    var counts = parseFloat(plafonbbn) - parseFloat(real);
                                    var result = (parseFloat(diskon_stsj) + parseFloat(subsidi) + parseFloat(counts) + parseFloat(insentif) - parseFloat(diskon) + parseFloat(up_price) +
                                            parseFloat(tambah_subsidi) - parseFloat(hadiah) - parseFloat(jaket) - parseFloat(lain_lain) - parseFloat(bonus));
                                    var avg = (result + parseFloat(uangmuka) + parseFloat(plafonbbn) + parseFloat(tambah_subsidi)) / 14;
                                    //parseFloat(value.replace(',', '.'))).toFixed(2)
                                    if (!isNaN(result) && !isNaN(avg)) {
                            document.getElementById('profit').value = counts;
                                    document.getElementById('laba_kotor').value = result;
                                    document.getElementById('average').value = avg;
                            }
                            }
                </script>
                <h2>Edit Laba Penjualan</h2>
                <script src="module/lap_penjualan/main.js"></script>                                                                                                                                                                 <!--<script src="module/pengirimanunit/main_edit.js"></script>-->
                <form action="module/lap_penjualan/edit.proses.php" method="POST" class="form-horizontal" id="creates">
                    <div class="row">
                        <div class="span4">
                            <div class="control-group">
                                <label class="control-label">Nomor Penjualan</label>
                                <div class="controls">:
                                    <input type="text" class="span2" id="no_beli" name="no_beli" value="<?php echo $row['no_faktur']; ?>" readonly >
                                    <input type="hidden" class="span2" id="id_penjualan" name="id_penjualan" value="<?php echo $id; ?>" readonly >
                                    <input type="hidden" class="span2" id="id_detail" name="id_detail" value="<?php echo $row['id_detail_penjualan']; ?>" readonly >
                                </div>
                            </div>
                        </div>
                        <div class="span4">                    
                            <div class="control-group" >
                                <label class="control-label">Tanggal</label>
                                <div class="controls">:
                                    <input type="text" class="span2" id="tanggal" name="tanggal" value="<?php echo tgl_indo($row['tanggal']); ?>" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="span4">
                            <div class="control-group">
                                <label class="control-label">Customer </label>
                                <div class="controls">:
                                    <input type="text" class="span2" id="customer" name="customer" value="<?php echo $row['customer']; ?>" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="well">               
                        <legend>Leasing</legend>
                        <div class="row-fluid">
                            <div class="span6">
                                <div class="control-group" >
                                    <label class="control-label">Leasing </label>
                                    <div class="controls">:
                                        <input type="text" class="span6" id="leasing" name="leasing" value="<?php echo $row['leasing']; ?>" readonly>
                                    </div>
                                </div>
                                <div class="control-group" >
                                    <label class="control-label">Subsidi* </label>
                                    <div class="controls">:
                                        <div class="input-prepend">                                
                                            <span class="add-on">Rp</span>
                                            <input type="text" class="span8" id="subsidi" name="subsidi" value="<?php echo $row['subsidi']; ?>"  style="text-align: right;" onkeyup="sum();" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="span6">
                                <div class="control-group" >
                                    <label class="control-label">Uang Muka </label>
                                    <div class="controls">:
                                        <div class="input-prepend">                                
                                            <span class="add-on">Rp</span>
                                            <input type="text" class="span8" id="uangmuka" name="uangmuka" value="<?php echo $row['uang_muka']; ?>"  style="text-align: right;" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="control-group" >
                                    <label class="control-label">Tambah Subsidi * </label>
                                    <div class="controls">:
                                        <div class="input-prepend">                                
                                            <span class="add-on">Rp</span>
                                            <input type="text" class="span8" id="tambah_subsidi" name="tambah_subsidi" value="<?php echo $row['tambah_subsidi']; ?>" onkeyup="sum();" style="text-align: right;" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <legend>Unit</legend>
                    <div class="row-fluid">
                        <div class="span6">
                            <div class="control-group" >
                                <label class="control-label">Nama </label>
                                <div class="controls">:
                                    <input type="text" class="span6" id="nama_unit" name="nama_unit" value="<?php echo $row['unit']; ?>" readonly>
                                </div>
                            </div>
                            <div class="control-group" >
                                <label class="control-label">Warna </label>
                                <div class="controls">:
                                    <input type="text" class="span6" id="warna" name="warna" value="<?php echo $row['warna']; ?>" readonly>
                                </div>
                            </div>
                            <div class="control-group" >
                                <label class="control-label">Rangka </label>
                                <div class="controls">:
                                    <input type="text" class="span6" id="no_rangka" name="no_rangka" value="<?php echo $row['no_rangka']; ?>" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="span6">
                            <div class="control-group" >
                                <label class="control-label">Mesin</label>
                                <div class="controls">:
                                    <input type="text" class="span6" id="no_mesin" name="no_rangka" value="<?php echo $row['no_rangka']; ?>"  readonly>
                                </div>
                            </div>
                            <div class="control-group" >
                                <label class="control-label">Tahun </label>
                                <div class="controls">:
                                    <input type="text" class="span6" id="tahun" name="tahun" value="<?php echo $row['tahun']; ?>"  readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="well">

                        <legend>Biaya</legend>
                        <div class="row-fluid">
                            <div class="span6">
                                <div class="control-group" >
                                    <label class="control-label">Jaket * </label>
                                    <div class="controls">:
                                        <div class="input-prepend">                                
                                            <span class="add-on">Rp</span>
                                            <input type="text" class="span8" id="jaket" name="jaket" value="<?php echo $row['jaket']; ?>" onkeyup="sum();" style="text-align: right;" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="span6">
                                <div class="control-group" >
                                    <label class="control-label">Lain-Lain * </label>
                                    <div class="controls">:
                                        <div class="input-prepend">                                
                                            <span class="add-on">Rp</span>
                                            <input type="text" class="span8" id="lain_lain" name="lain_lain" value="<?php echo $row['lain_lain']; ?>" onkeyup="sum();" style="text-align: right;" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row-fluid">
                        <div class="span6">
                            <div class="control-group" >
                                <label class="control-label">Diskon STSJ * </label>
                                <div class="controls">:
                                    <div class="input-prepend">                                
                                        <span class="add-on">Rp</span>
                                        <input type="text" class="span8" id="diskon_stsj" name="diskon_stsj" value="<?php echo $row['diskon_stsj']; ?>" onkeyup="sum();" style="text-align: right;" required>
                                    </div>
                                </div>
                            </div>
                            <div class="control-group" >
                                <label class="control-label">Insentif * </label>
                                <div class="controls">:
                                    <div class="input-prepend">                                
                                        <span class="add-on">Rp</span>
                                        <input type="text" class="span8" id="insentif" name="insentif" value="<?php echo $row['insentif']; ?>" onkeyup="sum();" style="text-align: right;" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="span6">
                            <div class="control-group" >
                                <label class="control-label">Diskon * </label>
                                <div class="controls">:
                                    <div class="input-prepend">                                
                                        <span class="add-on">Rp</span>
                                        <input type="text" class="span8" id="diskon" name="diskon" value="<?php echo $row['diskon']; ?>" onkeyup="sum();" style="text-align: right;" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Hadiah * </label>
                                <div class="controls">:
                                    <div class="input-prepend">                                
                                        <span class="add-on">Rp</span>
                                        <input type="text" class="span8" id="hadiah" name="hadiah" value="<?php echo $row['hadiah']; ?>" onkeyup="sum();" style="text-align: right;" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="well">
                        <legend>BBn</legend>
                        <div class="row-fluid">
                            <div class="span6">
                                <div class="control-group" >
                                    <label class="control-label">Plafon </label>
                                    <div class="controls">:
                                        <div class="input-prepend">                                
                                            <span class="add-on">Rp</span>
                                            <input type="text" class="span8" id="plafonbbn" name="plafonbbn" value="<?php echo $row['plafonbbn']; ?>" onkeyup="sum();" style="text-align: right;" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Real * </label>
                                    <div class="controls">:
                                        <div class="input-prepend">                                
                                            <span class="add-on">Rp</span>
                                            <input type="text" class="span8" id="real" name="real" value="<?php echo $row['real']; ?>" onkeyup="sum();" style="text-align: right;" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="span6">
                                <div class="control-group" >
                                    <label class="control-label">Profit * </label>
                                    <div class="controls">:
                                        <div class="input-prepend">                                
                                            <span class="add-on">Rp</span>
                                            <input type="text" class="span8" id="profit" name="profit" value="<?php echo $row['profit']; ?>" onkeyup="sum();" style="text-align: right;" readonly="">
                                        </div>
                                    </div>
                                </div>
                                <div class="control-group" >
                                    <label class="control-label">Up Price * </label>
                                    <div class="controls">:
                                        <div class="input-prepend">                                
                                            <span class="add-on">Rp</span>
                                            <input type="text" class="span8" id="up_price" name="up_price" value="<?php echo $row['up_price']; ?>" onkeyup="sum();" style="text-align: right;" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row-fluid">
                        <div class="control-group" >
                            <label class="control-label">Bonus * </label>
                            <div class="controls">:
                                <div class="input-prepend">                                
                                    <span class="add-on">Rp</span>
                                    <input type="text" class="span8" id="bonus" name="bonus" value="<?php echo $row['bonus']; ?>" onkeyup="sum();" style="text-align: right;" required>
                                </div>
                            </div>
                        </div>
                        <div class="control-group" >
                            <label class="control-label">Laba Kotor</label>
                            <div class="controls">:
                                <div class="input-prepend">                                
                                    <span class="add-on">Rp</span>
                                    <input type="text" class="span8" id="laba_kotor" name="laba_kotor" value="<?php echo $row['laba_kotor']; ?>"  style="text-align: right;" readonly>
                                </div>
                            </div>
                        </div>                
                        <div class="control-group" >
                            <label class="control-label">Rata-Rata</label>
                            <div class="controls">:
                                <div class="input-prepend">                                
                                    <span class="add-on">Rp</span>
                                    <input type="text" class="span10" id="average" name="average" value="<?php echo $row['average']; ?>"  style="text-align: right;" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary btn-small" id="save">Simpan</button>
                        <button class="btn btn-small btn-tertiary" id="" type="button" onclick="window.location.href = 'index.php?r=lap_penjualan&page=laba';" >Batal</button> 
                    </div>
                </form>
                <?php
            }
        } elseif ($page == 'labagrafikDate') {
            ?>
            <center><h2> Grafik Penjualan Unit Per Tanggal</h2></center>
        <!--            <legend><i class="icon icon-filter"></i> Filter  </legend>
            <form name="form" class="form-horizontal" method="POST" action="index.php?r=lap_penjualan&page=labagrafikDate">
            <?php
            combonamabln(1, 12, 'bln_filter', $bln_sekarang);
            combothn($thn_sekarang - 3, $thn_sekarang, 'thn_filter', $thn_sekarang);
            ?>    
                <button class="btn btn-primary" name="search" type="submit"> Submit</button>
            </form>
            <legend></legend>-->
            <script type="text/javascript" src="module/lap_penjualan/jquery.1.7.1-min.js"></script>
            <script type="text/javascript" src="module/lap_penjualan/highchart.js"></script>
            <script type="text/javascript" src="module/lap_penjualan/exporting.js"></script>

            <script type="text/javascript">
                                    var chart1; // globally available
                                    $(document).ready(function() {
                            chart1 = new Highcharts.Chart({
                            chart: {
                            renderTo: 'container',
                                    type: 'column'
                            },
                                    title: {
                                    text: 'Grafik Kendaraan Masuk '
                                    },
                                    xAxis: {
                                    categories: ['Banyak']
                                    },
                                    yAxis: {
                                    title: {
                                    text: 'Kendaraan '
                                    }
                                    },
                                    series:
                                    [
        <?php
        $sql = "SELECT p.tanggal,sum(laba_kotor) as laba
FROM penjualan p  
INNER JOIN ref_customer c ON c.id_customer = p.id_customer
INNER JOIN ref_leasing l ON l.id = p.id_leasing
INNER JOIN detail_penjualan dp ON dp.id_penjualan = p.id_penjualan 
INNER JOIN tb_detail_unit du ON du.id_detail_unit = dp.id_detail_unit
INNER JOIN tb_unit u ON dp.id_unit = u.id
INNER JOIN ref_leasing rl ON rl.id = p.id_leasing
INNER JOIN ref_customer rc ON rc.id_customer = p.id_customer WHERE MONTH(p.tanggal) >= '01' and MONTH(p.tanggal) <= '12'
GROUP BY p.id_penjualan";
        $query = mysql_query($sql) or die(mysql_error());
        while ($ret = mysql_fetch_array($query)) {
            $tanggal = $ret['tanggal'];
            $jml = $ret['laba'];
            ?>
                                        {
                                        name: '<?php echo tgl_indo($tanggal); ?>',
                                                data: [<?php echo $jml; ?>]
                                        },
        <?php } ?>
                                    ]
                            });
                            });</script>
            <div id='container'></div>
            <div class="row-fluid">
                <div class="span12">
                    <div class="form-actions">
                        <button class="btn btn-inverse" onclick="window.location.href = 'index.php?r=lap_penjualan&page=laba';" >Kembali</button> 
                    </div>
                </div>
            </div>
            <?php
        } elseif ($page == 'labagrafikMonth') {
            ?>
            <center><h2> Grafik Penjualan Unit Per Bulan</h2></center>
            <legend><i class="icon icon-filter"></i> Filter  </legend>
            <form name="form" class="form-horizontal" method="POST" action="index.php?r=lap_penjualan&page=labagrafikMonth">
                <?php
                combonamabln(1, 12, 'bln_filter', $bln_sekarang);
                combothn($thn_sekarang - 3, $thn_sekarang, 'thn_filter', $thn_sekarang);
                ?>    
                <button class="btn btn-primary" name="search" type="submit"> Submit</button>
            </form>
            <legend></legend>
            <script type="text/javascript" src="module/lap_penjualan/jquery.1.7.1-min.js"></script>
            <script type="text/javascript" src="module/lap_penjualan/highchart.js"></script>
            <script type="text/javascript" src="module/lap_penjualan/exporting.js"></script>

            <?php
            $mnt_now = date('m');
            $year_now = date('Y');
            $month = $_POST['bln_filter'];
            $year = $_POST['thn_filter'];

            $sql = "SELECT p.tanggal,sum(laba_kotor) as laba,sum(average) as avg
        FROM penjualan p  
        INNER JOIN ref_customer c ON c.id_customer = p.id_customer
        INNER JOIN ref_leasing l ON l.id = p.id_leasing
        INNER JOIN detail_penjualan dp ON dp.id_penjualan = p.id_penjualan 
        INNER JOIN tb_detail_unit du ON du.id_detail_unit = dp.id_detail_unit
        INNER JOIN tb_unit u ON dp.id_unit = u.id
        INNER JOIN ref_leasing rl ON rl.id = p.id_leasing
        INNER JOIN ref_customer rc ON rc.id_customer = p.id_customer";

            if (!isset($_POST['search'])) {
                $sql .= " where MONTH(p.tanggal)= '$mnt_now' and YEAR(p.tanggal) = '$year_now'";
            } else {
                $sql .= " where MONTH(p.tanggal)= '$month' and YEAR(p.tanggal) = '$year'";
            }

            $query = mysql_query($sql);

            $laba = mysql_fetch_array($query);

            if ($laba['avg'] != "" && $laba['laba'] != "") {
                ?>

                <div class="row">
                    <div class="span12">
                        <ul class="thumbnails">
                            <li class="span6">
                                <div class="thumbnail">
                                    <div id="chart2"></div>
                                </div>
                            </li>
                            <li class="span6">
                                <div class="thumbnail">
                                    <div id="chart3"></div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <script type="text/javascript">
                                    var chart2 = new Highcharts.Chart({
                                    chart: {
                                    renderTo: 'chart2',
                                            type: 'column'
                                    },
                                            title: {
                                            text: 'Laba Penjualan Unit '
                                            },
                                            xAxis: {
                                            categories: ['<?php echo date('F'); ?>']
                                            },
                                            yAxis: {
                                            title: {
                                            text: 'Value '
                                            }
                                            },
                                            colors: ['#50B432'],
                                            tooltip: {
                                            pointFormat: "Rp {point.y:,f}"
                                            },
                                            series: [
                                            {
                                            name: ['Laba Kotor'],
                                                    data: [<?php echo $laba['laba'] ?>]
                                            }]

                                    });
                                    var chart2 = new Highcharts.Chart({
                                    chart: {
                                    renderTo: 'chart3',
                                            type: 'column'
                                    },
                                            title: {
                                            text: 'Rata-Rata Penjualan Unit '
                                            },
                                            xAxis: {
                                            categories: ['<?php echo date('F'); ?>']
                                            },
                                            yAxis: {
                                            title: {
                                            text: 'Value '
                                            }
                                            },
                                            tooltip: {
                                            pointFormat: "Rp {point.y:,f}"
                                            },
                                            series: [{
                                            name: ['Rata-Rata'],
                                                    data: [<?php echo $laba['avg'] ?>]
                                            }]
                                    });</script>
            <?php } else { ?>
                <div class = "row">
                    <div class = "span12">
                        <div class = "alert alert-info">
                            <center><h2>No Transaction!</h2></center>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
            <div class="row-fluid">
                <div class="span12">
                    <div class="form-actions">
                        <button class="btn btn-inverse" onclick="window.location.href = 'index.php?r=lap_penjualan&page=laba';" >Kembali</button> 
                    </div>
                </div>
            </div>
        <?php } elseif ($page == 'labagrafikYear') {
            ?>
            <center><h2> Grafik Penjualan Unit Per Tahun</h2></center>
            <legend><i class="icon icon-filter"></i> Filter  </legend>
            <form name="form" class="form-horizontal" method="POST" action="index.php?r=lap_penjualan&page=labagrafikYear">
                <?php
                combothn($thn_sekarang - 3, $thn_sekarang, 'thn_filter', $thn_sekarang);
                ?>    
                <button class="btn btn-primary" name="search" type="submit"> Submit</button>
            </form>
            <legend></legend>
            <script type="text/javascript" src="module/lap_penjualan/jquery.1.7.1-min.js"></script>
            <script type="text/javascript" src="module/lap_penjualan/highchart.js"></script>
            <script type="text/javascript" src="module/lap_penjualan/exporting.js"></script>

            <?php
            $year_now = date('Y');
            $year = $_POST['thn_filter'];


            $sql = "SELECT p.tanggal,sum(laba_kotor) as laba,sum(average) as avg
        FROM penjualan p  
        INNER JOIN ref_customer c ON c.id_customer = p.id_customer
        INNER JOIN ref_leasing l ON l.id = p.id_leasing
        INNER JOIN detail_penjualan dp ON dp.id_penjualan = p.id_penjualan 
        INNER JOIN tb_detail_unit du ON du.id_detail_unit = dp.id_detail_unit
        INNER JOIN tb_unit u ON dp.id_unit = u.id
        INNER JOIN ref_leasing rl ON rl.id = p.id_leasing
        INNER JOIN ref_customer rc ON rc.id_customer = p.id_customer";

            if (!isset($_POST['search'])) {
                $sql .= " where YEAR(p.tanggal) = '$year_now'";
            } else {
                $sql .= " where YEAR(p.tanggal) = '$year_now'";
            }

            $query = mysql_query($sql);

            $laba = mysql_fetch_array($query);

            if ($laba['avg'] != "" && $laba['laba'] != "") {
                ?>

                <!--                <div class="row">
                                    <div class="span12">
                                        <ul class="thumbnails">
                                            <li class="span6">
                                                <div class="thumbnail">-->
                <div id="chart2"></div>
                <!--                                </div>
                                            </li>
                                            <li class="span6">
                                                <div class="thumbnail">
                                                    <div id="chart3"></div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>-->
                <script type="text/javascript">
                                    var chart2 = new Highcharts.Chart({
                                    chart: {
                                    renderTo: 'chart2',
                                            //                                        type: 'column'
                                    },
                                            title: {
                                            text: 'Laba Penjualan Unit '
                                            },
                                            xAxis: {
                                            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
                                            },
                                            yAxis: {
                                            title: {
                                            text: 'Value '
                                            }
                                            },
                                            colors: ['#ED561B'],
                                            tooltip: {
                                            pointFormat: "Rp {point.y:,f}"
                                            },
                                            series: [
                                            {
                                            name: ['Laba Kotor'],
            <?php
            $sql2 = "SELECT p.tanggal,sum(laba_kotor) as laba,sum(average) as avg
FROM penjualan p  
INNER JOIN ref_customer c ON c.id_customer = p.id_customer
INNER JOIN ref_leasing l ON l.id = p.id_leasing
INNER JOIN detail_penjualan dp ON dp.id_penjualan = p.id_penjualan 
INNER JOIN tb_detail_unit du ON du.id_detail_unit = dp.id_detail_unit
INNER JOIN tb_unit u ON dp.id_unit = u.id
INNER JOIN ref_leasing rl ON rl.id = p.id_leasing
INNER JOIN ref_customer rc ON rc.id_customer = p.id_customer";

            if (!isset($_POST['search'])) {
                $sql2 .= " where YEAR(p.tanggal) = '$year_now'";
            } else {
                $sql2 .= " where YEAR(p.tanggal) = '$year_now'";
            }

            $result = mysql_query($sql2);

            $data = array();
            ?>
                                            data: [<?php
            while ($row = mysql_fetch_array($result)) {
                array_unshift($data, $row['laba']);
//                echo "$data,$row['laba']";
            }
            ?>]
                                            }]

                                    });
                                    var chart2 = new Highcharts.Chart({
                                    chart: {
                                    renderTo: 'chart3',
                                            type: 'column'
                                    },
                                            title: {
                                            text: 'Rata-Rata Penjualan Unit '
                                            },
                                            xAxis: {
                                            categories: ['<?php echo date('F'); ?>']
                                            },
                                            yAxis: {
                                            title: {
                                            text: 'Value '
                                            }
                                            },
                                            tooltip: {
                                            pointFormat: "Rp {point.y:,f}"
                                            },
                                            series: [{
                                            name: ['Rata-Rata'],
                                                    data: [<?php echo $laba['avg'] ?>]
                                            }]
                                    });</script>
            <?php } else { ?>
                <div class = "row">
                    <div class = "span12">
                        <div class = "alert alert-info">
                            <center><h2>No Transaction!</h2></center>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
            <div class="row-fluid">
                <div class="span12">
                    <div class="form-actions">
                        <button class="btn btn-inverse" onclick="window.location.href = 'index.php?r=lap_penjualan&page=laba';" >Kembali</button> 
                    </div>
                </div>
            </div>
        <?php } elseif ($page == 'laporanhari') {
            ?>
            <form name="form" target="_blank" method="POST" action="module/lap_penjualan/print.php?sub=laporan2">
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
            <center><h2>Laporan Penjualan Unit Hari Ini</h2></center>
            <br/>
            <table class="table table-bordered table-striped table-highlight">
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
                    $p = new Paging;
                    $batas = 15;
                    $posisi = $p->cariPosisi($batas);
                    $hariini = date("d");

                    $query = mysql_query("SELECT p.*, dp.uang_muka, dp.diskon, du.tahun, u.`name` as unit, (dp.uang_muka + dp.diskon) as jml, c.name as warna,
                                    rc.`name` as customer, rl.`name` as leasing, du.no_rangka, du.no_mesin, u.hargaotr
                                    FROM penjualan p 
                                    INNER JOIN detail_penjualan dp ON dp.id_penjualan = p.id_penjualan
                                    INNER JOIN ref_customer rc ON rc.id_customer = p.id_customer
                                    INNER JOIN ref_leasing rl ON rl.id = p.id_leasing
                                    INNER JOIN tb_unit u ON u.id = dp.id_detail_unit
                                    INNER JOIN tb_detail_unit du ON du.id_detail_unit = dp.id_detail_unit 
                                    INNER JOIN ref_color c ON c.id_color = du.id_color
                                    where substr(p.tanggal,9,2)= '$hariini'
                                        Group by p.id_penjualan
                         LIMIT $posisi,$batas");
                    $total = mysql_num_rows($query);

                    if ($total > 0) {
                        $no = $posisi + 1;
                        while ($result = mysql_fetch_array($query)) {
                            echo"<tr>
                                <td>$no</td>
                                <td>$result[no_faktur]</td>
                                <td>$result[customer]</td>
                                <td>$result[leasing]</td>
                                <td>" . tgl_indo($result['tanggal']) . "</td>
                                <td>$result[unit]</td>
                                <td>$result[warna]</td>
                                <td>$result[no_rangka]</td>
                                <td>$result[no_mesin]</td>
                                <td>$result[tahun]</td>
                                <td style='text-align:right;'>" . rupiah($result['hargaotr']) . "</td>
                                <td style='text-align:right;'>" . rupiah($result['uang_muka']) . "</td>
                                <td style='text-align:right;'>" . rupiah($result['diskon']) . "</td>
                                <td style='text-align:right;'>" . rupiah($result['jml']) . "</td>
                             </tr>";
                            $no++;
                        }
                    } else {
                        echo"<tr><td colspan='15'><label>Data Tidak Ditemukan</label></td></tr>";
                    }
                    ?>
                </tbody>
            </table>
            <?php
            $jmldata = mysql_num_rows(mysql_query("SELECT p.*, dp.uang_muka, dp.diskon, du.tahun, u.`name` as unit, (dp.uang_muka + dp.diskon) as jml, c.name as warna,
                                    rc.`name` as customer, rl.`name` as leasing, du.no_rangka, du.no_mesin, u.hargaotr
                                    FROM penjualan p 
                                    INNER JOIN detail_penjualan dp ON dp.id_penjualan = p.id_penjualan
                                    INNER JOIN ref_customer rc ON rc.id_customer = p.id_customer
                                    INNER JOIN ref_leasing rl ON rl.id = p.id_leasing
                                    INNER JOIN tb_unit u ON u.id = dp.id_detail_unit
                                    INNER JOIN tb_detail_unit du ON du.id_detail_unit = dp.id_detail_unit 
                                    INNER JOIN ref_color c ON c.id_color = du.id_color
                                    where substr(p.tanggal,9,2)= '$hariini'"));
            $jmlhalaman = $p->jumlahHalaman($jmldata, $batas);
            $linkHalaman = $p->navHalaman($_GET['halaman'], $jmlhalaman);
            echo "<div class='pagination pagination-centered' id=paging>$linkHalaman</div><br>";
            ?>
            <div class="row">
                <div class="span12">
                    <div class="form-actions">
                        <button class="btn btn-inverse" onclick="window.location.href = 'index.php?r=lap_penjualan&page=view';" >Kembali</button> 
                    </div>
                </div>
            </div>
            <?php
        }
    }        