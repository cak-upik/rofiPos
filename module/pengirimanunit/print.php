<?php
if (isset($_GET['id'])) {
    $bulan = $_POST['bln_filter'];
    $tahun = $_POST['thn_filter'];
}
$bulan = $_POST['bln_filter'];
$tahun = $_POST['thn_filter'];

$query = "SELECT pe.id_pembelian, pe.no_faktur, MONTH(pe.tanggal) as bulan, YEAR(pe.tanggal) as tahun, rs.name as customer, 
                            u.name as unit,rs.name as supplier, rs.addres, rs.phone
                            FROM pembelian pe
                            INNER JOIN detail_pembelian dpe ON dpe.id_pembelian = pe.id_pembelian
                            INNER JOIN tb_unit u ON u.id = dpe.id_unit 
                            INNER JOIN tb_detail_unit du ON du.id_detail_unit = dpe.id_detail_unit
                            INNER JOIN ref_color rc ON rc.id_color = du.id_color
                            INNER JOIN tb_pemesanan_unit pu ON pu.id_pemesanan_unit = dpe.id_pemesanan_unit
                            INNER JOIN tb_detail_pemesanan_unit dpu ON dpu.id_detail_pemesanan_unit = pu.id_detail_pemesanan_unit
                            INNER JOIN ref_supplier rs ON rs.id_supplier = dpe.id_supplier 
                            WHERE MONTH(pe.tanggal) = '$bulan' and YEAR(pe.tanggal) = '$tahun'";

$q = mysql_query($query);
$total = mysql_num_rows($q);
if ($total > 0) {
    if (isset($_POST['search'])) {
        $query2 = mysql_query("SELECT pe.id_pembelian, pe.tanggal, pe.no_faktur, MONTH(pe.tanggal) as bulan, YEAR(pe.tanggal) as tahun, rs.name as customer, 
                            u.name as unit,rs.name as supplier, rs.addres, rs.phone
                            FROM pembelian pe
                            INNER JOIN detail_pembelian dpe ON dpe.id_pembelian = pe.id_pembelian
                            INNER JOIN tb_unit u ON u.id = dpe.id_unit 
                            INNER JOIN tb_detail_unit du ON du.id_detail_unit = dpe.id_detail_unit
                            INNER JOIN ref_color rc ON rc.id_color = du.id_color
                            INNER JOIN tb_pemesanan_unit pu ON pu.id_pemesanan_unit = dpe.id_pemesanan_unit
                            INNER JOIN tb_detail_pemesanan_unit dpu ON dpu.id_detail_pemesanan_unit = pu.id_detail_pemesanan_unit
                            INNER JOIN ref_supplier rs ON rs.id_supplier = dpe.id_supplier 
                            WHERE MONTH(pe.tanggal) = '$bulan' and YEAR(pe.tanggal) = '$tahun'");
        while ($row = mysql_fetch_array($query2)) {
            ?>
            <div class="row-fluid">
                <div class="span10"></div>
                <div class="span2"><button type="submit" name="print" class="btn btn-warning" onclick="window.print();"><i class="icon icon-print"></i> Print</button></div>
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
                        <strong>Supplier :</strong><br>
                        <?php echo $row['supplier']; ?><br />
                        <?php echo $row['addres']; ?> <br />
                        <abbr title="Phone">P:</abbr> <?php echo $row['phone']; ?> <br />
                        INDONESIA      <br />
                    </address>
                </div>
                <div class="span3">
                    <strong>Perusahaan : </strong></br>PT. Meji Sakti 
                </div>
            </div>

            <div class="content">
                <table width="100%" class="table table-bordered table-highlight table-striped">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Unit</th>
                            <th>Warna</th>
                            <th>No. Rangka</th>
                            <th>No. Mesin</th>
                            <th>Tahun</th>
                            <th>Kuantiti</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query2 = mysql_query("SELECT pe.*, dpe.kuantitas, rc.`name` as warna, du.no_rangka, dpe.keterangan, 
                                                MONTH(pe.tanggal) as bulan, YEAR(pe.tanggal) as tahun,
                                                du.no_mesin, du.plafonbbn, du.tahun, rs.name as customer, rs.id_supplier,
                                                u.name as unit, pu.id_pemesanan_unit, du.id_detail_unit, u.id as idunit,
                                                dpe.id_detail_pembelian, rs.name as supplier, rs.addres, rs.phone
                                                FROM pembelian pe
                                                INNER JOIN detail_pembelian dpe ON dpe.id_pembelian = pe.id_pembelian
                                                INNER JOIN tb_unit u ON u.id = dpe.id_unit 
                                                INNER JOIN tb_detail_unit du ON du.id_detail_unit = dpe.id_detail_unit
                                                INNER JOIN ref_color rc ON rc.id_color = du.id_color
                                                INNER JOIN tb_pemesanan_unit pu ON pu.id_pemesanan_unit = dpe.id_pemesanan_unit
                                                INNER JOIN tb_detail_pemesanan_unit dpu ON dpu.id_detail_pemesanan_unit = pu.id_detail_pemesanan_unit
                                                INNER JOIN ref_supplier rs ON rs.id_supplier = dpe.id_supplier 
                                                WHERE MONTH(pe.tanggal) = '$bulan' and YEAR(pe.tanggal) = '$tahun'");

                        $rows = mysql_query($query2);
                        $no = 1;
                        while ($r = mysql_fetch_array($query2)) {
                            echo"<tr>
                                        <td style='text-align:center;'>$no</td>
                                        <td>" . $r['unit'] . "</td>
                                        <td>" . $r['warna'] . "</td>
                                        <td>" . $r['no_rangka'] . "</td>
                                        <td>" . $r['no_mesin'] . "</td>
                                        <td>" . $r['tahun'] . "</td>
                                        <td>" . $r['kuantitas'] . "</td>
                                        <td>" . $r['keterangan'] . "</td>
                                     </tr>";
                            $no++;
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
        }
    }
}