<style>
    .header{
        margin: 0 auto; width: 800px; text-align: center;
    }
    .content{
        width:1000px; margin: 0 auto;
        font-family: monospace; 
    }
    .content2{
        width:800px; margin: 0 auto;
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
//include"service.php";

if (isset($_GET['sub'])) {
    $sub = $_GET['sub'];
    if ($sub == 'laporan1') {
        ?>
        <div class="content2" style="margin-top:30px;">
            <center><h2> <img src="../../img/1c.gif" width="126" height="111" align="left" />Laporan Bulanan Penjualan Sparepart</h2>
            </center>
            <center><h3>Bulan <?php echo nmbulan($_POST['bln_filter']); ?> / Tahun <?php echo $_POST['thn_filter']; ?></h3>
                <p>&nbsp;</p>
            </center>

            <table width="100%" class="table" border="1" cellpadding="8" cellspacing="0">
                <thead>
                    <tr>
                        <th width="5%">#</th>
                        <th>Nota</th>
                        <th>Tanggal</th>
                        <th>Kode Sparepart</th>
                        <th>Nama Sparepart</th>
                        <th>Harga Satuan</th>
                        <th>Kuantitas</th>
                        <th>Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = mysql_query("SELECT a.id_pelayanan, a.nomor_pelayanan, b.id_penjualan, b.id_sparepart, 
                                        b.kuantitas, b.total_harga, c.id_pembayaran, c.nomor_pembayaran, c.tanggal, d.kode_sparepart, 
                                        d.nama_sparepart, e.harga_jual_satuan FROM tb_pelayanan a 
                                        inner join tb_penjualan b on a.id_pelayanan=b.id_pelayanan 
                                        inner join tb_pembayaran c on b.id_pelayanan=c.id_pelayanan 
                                        inner join tb_sparepart d on b.id_sparepart=d.id_sparepart
                                        inner join tb_stok e on d.id_sparepart=e.id_sparepart where substr(a.tanggal,6,2)= '$_POST[bln_filter]' 
                                            and substr(a.tanggal,1,4)= '$_POST[thn_filter]' and substr(a.tanggal,9,2)= '$_POST[tgl_filter]'
                                        order by nomor_pelayanan");
                    $total = mysql_num_rows($query);

                    if ($total > 0) {
                        $no = 1;
                        while ($result = mysql_fetch_array($query)) {
                            echo"<tr>
                                                    <td>$no</td>
                                                    <td>$result[nomor_pembayaran]</td>
                                                    <td>" . tgl_indo($result['tanggal']) . "</td>
                                                    <td>$result[kode_sparepart]</td>
                                                    <td>$result[nama_sparepart]</td>
                                                    <td style='text-align:right;'>Rp. " . number_format($result['harga_jual_satuan'], 2, '.', ',') . "</td>
                                                    <td style='text-align:right;'>$result[kuantitas]</td>
                                                    <td style='text-align:right;'>Rp. " . number_format($result['total_harga'], 2, '.', ',') . "</td>
                                                 </tr>";
                            $no++;
                        }
                    } else {
                        echo"<tr><td colspan='8'><label>Data Tidak Ditemukan</label></td></tr>";
                    }
                    ?>
                </tbody>
            </table>

            <?php
        }
        elseif ($sub == 'laporan2') {
            ?>
            <div class="content2" style="margin-top:30px;">
                <center><h2> <img src="../../img/1c.gif" width="116" align="left" /> Laporan Penjualan Sparepart Tanggal 
                        <?php echo $_POST['tanggal'] ?>-<?php echo $bln_sekarang ?>-<?php echo $thn_sekarang ?></h2>
                </center>
                <br/>
                <table width="100%" class="table" border="1" cellpadding="8" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="5%">#</th>
                            <th>Nota</th>
                            <th>Tanggal</th>
                            <th>Kode Sparepart</th>
                            <th>Nama Sparepart</th>
                            <th>Harga Satuan</th>
                            <th>Kuantitas</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = mysql_query("SELECT a.id_pelayanan, a.nomor_pelayanan, b.id_penjualan, b.id_sparepart, 
                                        b.kuantitas, b.total_harga, c.id_pembayaran, c.nomor_pembayaran, c.tanggal, d.kode_sparepart, 
                                        d.nama_sparepart, e.harga_jual_satuan FROM tb_pelayanan a 
                                        inner join tb_penjualan b on a.id_pelayanan=b.id_pelayanan 
                                        inner join tb_pembayaran c on b.id_pelayanan=c.id_pelayanan 
                                        inner join tb_sparepart d on b.id_sparepart=d.id_sparepart
                                        inner join tb_stok e on d.id_sparepart=e.id_sparepart where substr(a.tanggal,6,2)= '$bln_sekarang' 
                                            and substr(a.tanggal,1,4)= '$thn_sekarang' and substr(a.tanggal,9,2)= '$_POST[tanggal]'
                                        order by nomor_pelayanan");
                        $total = mysql_num_rows($query);

                        if ($total > 0) {
                            $no = 1;
                            while ($result = mysql_fetch_array($query)) {
                                echo"<tr>
                                                    <td>$no</td>
                                                    <td>$result[nomor_pembayaran]</td>
                                                    <td>" . tgl_indo($result['tanggal']) . "</td>
                                                    <td>$result[kode_sparepart]</td>
                                                    <td>$result[nama_sparepart]</td>
                                                    <td style='text-align:right;'>Rp. " . number_format($result['harga_jual_satuan'], 2, '.', ',') . "</td>
                                                    <td style='text-align:right;'>$result[kuantitas]</td>
                                                    <td style='text-align:right;'>Rp. " . number_format($result['total_harga'], 2, '.', ',') . "</td>
                                                 </tr>";
                                $no++;
                            }
                        } else {
                            echo"<tr><td colspan='8'><label>Data Tidak Ditemukan</label></td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
        <?php
    }
}
?>

    </div>
