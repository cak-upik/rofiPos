<!--<script src="module/biayasr/main.js"></script>-->

<?php
include"../../conf/pengkodean.php";
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

<?php
if (isset($_GET['page'])) {
    $page = $_GET['page'];
    if ($page == 'view') {
        $date_today = date('d');
        if ($date_today == '1' || $date_today == '2' || $date_today == '3' || $date_today == '4' || $date_today == '5' || $date_today == '6' || $date_today == '7') {
            ?>
            <p>
                <button onClick="document.location = 'index.php?r=biayasr&page=create';" class="btn btn-warning right_align"><i class="icon-plus-sign icon-white"></i> Tambah</button>
            </p>
            <?php
        }
        ?>
        <form name="form" method="POST" action="index.php?r=biayasr&page=view">
            <fieldset>
                <legend><i class="icon icon-filter"></i> Filter</legend>               
                <div class="well">      
                    <?php
//                    combotgl(1, 31, 'tgl_filter', $today);
                    combonamabln(1, 12, 'bln_filter', $bln_sekarang);
                    combothn($thn_sekarang - 3, $thn_sekarang, 'thn_filter', $thn_sekarang);
                    ?>
                    <button class="btn btn-primary" name="search" type="submit"> Submit</button>
                </div>
            </fieldset>
        </form>

        <?php
//        $tgl = $_POST['tgl_filter'];

        $dateMonth = date('m');
        $dateYear = date('Y');
        $bulan = $_POST['bln_filter'];
        $tahun = $_POST['thn_filter'];

        $q = "select * from ref_biaya_sr";

        if (isset($_POST['search'])) {
            $q .=" where substr(tanggal, 6, 2) = '$bulan' and substr(tanggal,1,4)= '$tahun'";
        } else {
            $q .=" where substr(tanggal, 6, 2) = '$dateMonth' and substr(tanggal,1,4)= '$dateYear'";
        }

        $query = mysql_query($q);
        $total = mysql_num_rows($query);

        if ($total > 0) {
            $q2 = "select * from ref_biaya_sr";

            if (isset($_POST['search'])) {
                $q2 .=" where substr(tanggal, 6, 2) = '$bulan' and substr(tanggal,1,4)= '$tahun'";
            } else {
                $q2 .=" where substr(tanggal, 6, 2) = '$dateMonth' and substr(tanggal,1,4)= '$dateYear'";
            }
            
            $query2 = mysql_query($q2);
            $row = mysql_fetch_array($query2);
            ?>
            <div class="row-fluid">
                <div class="span10"></div>
                <div class="span2">
                    <button onclick="document.location = 'index.php?r=biayasr&page=edit&id=<?php echo $row['id']; ?>';" title='Edit' class="btn btn-info"><i class='icon-edit'></i> Edit</button>
                </div>
            </div>
            <br/>
            <div class="form-horizontal">
                <div class="row">
                    <div class="span6">
                        <div class="control-group">
                            <label class="control-label">Fotocopy</label>
                            <div class="controls">                            
                                <div class="input-prepend">                                
                                    <span class="add-on">Rp</span>
                                    <input type="text" class="span2" style="text-align: right;" id="fotocopy" name="fotocopy" value="<?php echo number_format($row['fotocopy']); ?>" readonly>
                                    <input type="hidden" class="span2" id="id" name="id" value="<?php echo $row['id']; ?>" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Lain - Lain</label>
                            <div class="controls">                            
                                <div class="input-prepend">                                
                                    <span class="add-on">Rp</span>
                                    <input type="text" class="span2" style="text-align: right;" id="lainlain" name="lainlain" value="<?php echo number_format($row['lainlain']); ?>" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Iklan</label>
                            <div class="controls">                            
                                <div class="input-prepend">                                
                                    <span class="add-on">Rp</span>
                                    <input type="text" class="span2" style="text-align: right;" id="iklan" name="iklan" value="<?php echo number_format($row['iklan']); ?>" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Konsumsi</label>
                            <div class="controls">                            
                                <div class="input-prepend">                                
                                    <span class="add-on">Rp</span>
                                    <input type="text" class="span2" style="text-align: right;" id="konsumsi" name="konsumsi" value="<?php echo number_format($row['konsumsi']); ?>" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Bahan Bakar</label>
                            <div class="controls">                            
                                <div class="input-prepend">                                
                                    <span class="add-on">Rp</span>
                                    <input type="text" class="span2" style="text-align: right;" id="bahanbakar" name="bahanbakar" value="<?php echo number_format($row['bahanbakar']); ?>" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Alat Tulis Kantor</label>
                            <div class="controls">                            
                                <div class="input-prepend">                                
                                    <span class="add-on">Rp</span>
                                    <input type="text" class="span2" style="text-align: right;" id="atk" name="atk" value="<?php echo number_format($row['atk']); ?>" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Parkir dan Tol</label>
                            <div class="controls">                            
                                <div class="input-prepend">                                
                                    <span class="add-on">Rp</span>
                                    <input type="text" class="span2" style="text-align: right;" id="parkirtol" name="parkirtol" value="<?php echo number_format($row['parkir_tol']); ?>" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Keamanan</label>
                            <div class="controls">                            
                                <div class="input-prepend">                                
                                    <span class="add-on">Rp</span>
                                    <input type="text" class="span2" style="text-align: right;" id="keamanan" name="keamanan" value="<?php echo number_format($row['keamanan']); ?>" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Minuman</label>
                            <div class="controls">                            
                                <div class="input-prepend">                                
                                    <span class="add-on">Rp</span>
                                    <input type="text" class="span2" style="text-align: right;" id="minuman" name="minuman" value="<?php echo number_format($row['minuman']); ?>" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="span6">
                        <div class="control-group">
                            <label class="control-label">Rek. Telp</label>
                            <div class="controls">                            
                                <div class="input-prepend">                                
                                    <span class="add-on">Rp</span>
                                    <input type="text" class="span2" style="text-align: right;" id="rektelp" name="rektelp" value="<?php echo number_format($row['rektelp']); ?>" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Rek. Air</label>
                            <div class="controls">                            
                                <div class="input-prepend">                                
                                    <span class="add-on">Rp</span>
                                    <input type="text" class="span2" style="text-align: right;" id="rekair" name="rekair" value="<?php echo number_format($row['rekair']); ?>" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Rek. Listrik</label>
                            <div class="controls">                            
                                <div class="input-prepend">                                
                                    <span class="add-on">Rp</span>
                                    <input type="text" class="span2" style="text-align: right;" id="listrik" name="listrik" value="<?php echo number_format($row['listrik']); ?>" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Komisi</label>
                            <div class="controls">                            
                                <div class="input-prepend">                                
                                    <span class="add-on">Rp</span>
                                    <input type="text" class="span2" style="text-align: right;" id="komisi" name="komisi" value="<?php echo number_format($row['komisi']); ?>" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Gaji</label>
                            <div class="controls">                            
                                <div class="input-prepend">                                
                                    <span class="add-on">Rp</span>
                                    <input type="text" class="span2" style="text-align: right;" id="gaji" name="gaji" value="<?php echo number_format($row['gaji']); ?>" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Pajak</label>
                            <div class="controls">                            
                                <div class="input-prepend">                                
                                    <span class="add-on">Rp</span>
                                    <input type="text" class="span2" style="text-align: right;" id="pajak" name="pajak" value="<?php echo number_format($row['pajak']); ?>" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Sumbangan</label>
                            <div class="controls">                            
                                <div class="input-prepend">                                
                                    <span class="add-on">Rp</span>
                                    <input type="text" class="span2" style="text-align: right;" id="sumbangan" name="sumbangan" value="<?php echo number_format($row['sumbangan']); ?>" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Pemeliharaan</label>
                            <div class="controls">                            
                                <div class="input-prepend">                                
                                    <span class="add-on">Rp</span>
                                    <input type="text" class="span2" style="text-align: right;"  id="pemeliharaan" name="pemeliharaan" value="<?php echo number_format($row['pemeliharaan']); ?>" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Materai</label>
                            <div class="controls">                            
                                <div class="input-prepend">                                
                                    <span class="add-on">Rp</span>
                                    <input type="text" class="span2" style="text-align: right;" id="materai" name="materai" value="<?php echo number_format($row['materai']); ?>" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>            
            <?php
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
        <!--
                <div class="well" style="max-height: auto; overflow: auto;">
                    <table class="table table-bordered table-striped table-highlight">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Fotocopy</th>
                                <th>Lain-Lain</th>
                                <th>Iklan</th>
                                <th>Konsumsi</th>
                                <th>Bahan Bakar</th>
                                <th>Alat Tulis Kantor</th>
                                <th>Parkir dan Tol</th>
                                <th>Keamanan</th>
                                <th>Minuman</th>
                                <th>Telepon</th>
                                <th>Rek. Air</th>
                                <th>Rek. Listrik</th>
                                <th>Komisi</th>
                                <th>Gaji</th>
                                <th>Pajak</th>
                                <th>Sumbangan</th>
                                <th>Pemeliharaan</th>
                                <th>Materai</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
        <?php
//                    $query = mysql_query("select * from ref_biaya_sr");
//                    $total = mysql_num_rows($query);
//
//                    if ($total > 0) {
//                        $no = 1;
//                        while ($result = mysql_fetch_array($query)) {
//                            echo"<tr>
//                                    <td>$no</td>
//                                    <td style='text-align:right;'>" . rupiah($result[fotocopy]) . "</td>
//                                    <td style='text-align:right;'>" . rupiah($result[lainlain]) . "</td>
//                                    <td style='text-align:right;'>" . rupiah($result[iklan]) . "</td>
//                                    <td style='text-align:right;'>" . rupiah($result[konsumsi]) . "</td>
//                                    <td style='text-align:right;'>" . rupiah($result[bahanbakar]) . "</td>
//                                    <td style='text-align:right;'>" . rupiah($result[atk]) . "</td>
//                                    <td style='text-align:right;'>" . rupiah($result[parkir_tol]) . "</td>
//                                    <td style='text-align:right;'>" . rupiah($result[keamanan]) . "</td>
//                                    <td style='text-align:right;'>" . rupiah($result[minuman]) . "</td>
//                                    <td style='text-align:right;'>" . rupiah($result[rektelp]) . "</td>
//                                    <td style='text-align:right;'>" . rupiah($result[rekair]) . "</td>
//                                    <td style='text-align:right;'>" . rupiah($result[listrik]) . "</td>
//                                    <td style='text-align:right;'>" . rupiah($result[komisi]) . "</td>
//                                    <td style='text-align:right;'>" . rupiah($result[gaji]) . "</td>
//                                    <td style='text-align:right;'>" . rupiah($result[pajak]) . "</td>
//                                    <td style='text-align:right;'>" . rupiah($result[sumbangan]) . "</td>
//                                    <td style='text-align:right;'>" . rupiah($result[pemeliharaan]) . "</td>
//                                    <td style='text-align:right;'>" . rupiah($result[materai]) . "</td>
//                                    <td style='text-align:center;'>
//                                        <a href='index.php?r=biayasr&page=edit&id=$result[id]' title='Edit'><i class='icon-edit'></i></a>
//                                        <a href='module/biayasr/delete.php?id=$result[id]' title='Delete' onClick=\"return confirm ('Are you sure?')\"><i class='icon-remove'></i></a>
//                                    </td>                                                   
//                                 </tr>";
//                            $no++;
//                        }
//                    } else {
//                        echo"<tr><td colspan='7'><label>Data Tidak Ditemukan</label></td></tr>";
//                    }
        ?>
                        </tbody>
                    </table>-->
        </div>
        <?php
    } elseif ($page == 'create') {
        ?>
        <script src="module/biayasr/jquery-1.9.1.min.js"></script>
        <script src="module/biayasr/autoNumeric.js"></script>
        <script type = "text/javascript">
                        jQuery(function($) {
                            $('#fotocopy').autoNumeric('init');
                            $('#lainlain').autoNumeric('init');
                            $('#iklan').autoNumeric('init');
                            $('#konsumsi').autoNumeric('init');
                            $('#bahanbakar').autoNumeric('init');
                            $('#atk').autoNumeric('init');
                            $('#parkirtol').autoNumeric('init');
                            $('#keamanan').autoNumeric('init');
                            $('#minuman').autoNumeric('init');
                            $('#rektelp').autoNumeric('init');
                            $('#rekair').autoNumeric('init');
                            $('#listrik').autoNumeric('init');
                            $('#komisi').autoNumeric('init');
                            $('#gaji').autoNumeric('init');
                            $('#pajak').autoNumeric('init');
                            $('#sumbangan').autoNumeric('init');
                            $('#pemeliharaan').autoNumeric('init');
                            $('#materai').autoNumeric('init');
                        });
        </script>
        <h2>Tambah Data</h2>
        <form action="module/biayasr/input.proses.php" method="POST" class="form-horizontal" id="create">

            <div class="row">
                <div class="span1"></div>
                <div class="span5">
                    <div class="control-group">
                        <label class="control-label">Fotocopy</label>
                        <div class="controls">                            
                            <div class="input-prepend">                                
                                <span class="add-on">Rp</span>
                                <input type="text" class="span2" style="text-align: right;" id="fotocopy" name="fotocopy" value="">
                            </div>
                        </div>
                    </div>

                    <div class="control-group">                        
                        <label class="control-label">Lain - Lain</label>
                        <div class="controls">                            
                            <div class="input-prepend">                                
                                <span class="add-on">Rp</span>
                                <input type="text" class="span2" style="text-align: right;" id="lainlain" name="lainlain" value="">
                            </div>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">Iklan</label>
                        <div class="controls">                            
                            <div class="input-prepend">                                
                                <span class="add-on">Rp</span>
                                <input type="text" class="span2" style="text-align: right;" id="iklan" name="iklan" value="">
                            </div>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">Konsumsi</label>
                        <div class="controls">                            
                            <div class="input-prepend">                                
                                <span class="add-on">Rp</span>
                                <input type="text" class="span2" style="text-align: right;" id="konsumsi" name="konsumsi" value="">
                            </div>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">Bahan Bakar</label>
                        <div class="controls">                            
                            <div class="input-prepend">                                
                                <span class="add-on">Rp</span>
                                <input type="text" class="span2" style="text-align: right;" id="bahanbakar" name="bahanbakar" value="">
                            </div>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">Alat Tulis Kantor</label>
                        <div class="controls">                            
                            <div class="input-prepend">                                
                                <span class="add-on">Rp</span>
                                <input type="text" class="span2" style="text-align: right;" id="atk" name="atk" value="">
                            </div>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">Parkir dan Tol</label>
                        <div class="controls">                            
                            <div class="input-prepend">                                
                                <span class="add-on">Rp</span>
                                <input type="text" class="span2" style="text-align: right;" id="parkirtol" name="parkirtol" value="">
                            </div>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">Keamanan</label>
                        <div class="controls">                            
                            <div class="input-prepend">                                
                                <span class="add-on">Rp</span>
                                <input type="text" class="span2" style="text-align: right;" id="keamanan" name="keamanan" value="">
                            </div>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">Minuman</label>
                        <div class="controls">                            
                            <div class="input-prepend">                                
                                <span class="add-on">Rp</span>
                                <input type="text" class="span2" style="text-align: right;" id="minuman" name="minuman" value="">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="span6">
                    <div class="control-group">
                        <label class="control-label">Rek. Telp</label>
                        <div class="controls">                            
                            <div class="input-prepend">                                
                                <span class="add-on">Rp</span>
                                <input type="text" class="span2" style="text-align: right;" id="rektelp" name="rektelp" value="">
                            </div>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">Rek. Air</label>
                        <div class="controls">                            
                            <div class="input-prepend">                                
                                <span class="add-on">Rp</span>
                                <input type="text" class="span2" style="text-align: right;" id="rekair" name="rekair" value="">
                            </div>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">Rek. Listrik</label>
                        <div class="controls">                            
                            <div class="input-prepend">                                
                                <span class="add-on">Rp</span>
                                <input type="text" class="span2" style="text-align: right;" id="listrik" name="listrik" value="">
                            </div>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">Komisi</label>
                        <div class="controls">                            
                            <div class="input-prepend">                                
                                <span class="add-on">Rp</span>
                                <input type="text" class="span2" style="text-align: right;" id="komisi" name="komisi" value="">
                            </div>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">Gaji</label>
                        <div class="controls">                           
                            <div class="input-prepend">                                
                                <span class="add-on">Rp</span>
                                <input type="text" class="span2" style="text-align: right;" id="gaji" name="gaji" value="">
                            </div>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">Pajak</label>
                        <div class="controls">                            
                            <div class="input-prepend">                                
                                <span class="add-on">Rp</span>
                                <input type="text" class="span2" style="text-align: right;" id="pajak" name="pajak" value="">
                            </div>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">Sumbangan</label>
                        <div class="controls">                            
                            <div class="input-prepend">                                
                                <span class="add-on">Rp</span>
                                <input type="text" class="span2" style="text-align: right;" id="sumbangan" name="sumbangan" value="">
                            </div>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">Pemeliharaan</label>
                        <div class="controls">                            
                            <div class="input-prepend">                                
                                <span class="add-on">Rp</span>
                                <input type="text" class="span2" style="text-align: right;" id="pemeliharaan" name="pemeliharaan" value="">
                            </div>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">Materai</label>
                        <div class="controls">                            
                            <div class="input-prepend">                                
                                <span class="add-on">Rp</span>
                                <input type="text" class="span2" style="text-align: right;" id="materai" name="materai" value="">
                            </div>
                        </div>
                    </div>
                </div>
                <!--<div class="span1"></div>-->
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary btn-small" >Simpan</button>
                <button class="btn btn-small btn-tertiary" id="" type="button" onclick="window.location.href = 'index.php?r=biayasr&page=view';" >Batal</button> 

            </div>
        </form>
        <?php
    } elseif ($page == 'edit') {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $query_edit = mysql_query("select * from ref_biaya_sr where id='$id'");
            $a = mysql_fetch_array($query_edit);
            ?>

            <script src="module/biayasr/jquery-1.9.1.min.js"></script>
            <script src="module/biayasr/autoNumeric.js"></script>
            <script type = "text/javascript">
                    jQuery(function($) {
                        $('#fotocopy').autoNumeric('init');
                        $('#lainlain').autoNumeric('init');
                        $('#iklan').autoNumeric('init');
                        $('#konsumsi').autoNumeric('init');
                        $('#bahanbakar').autoNumeric('init');
                        $('#atk').autoNumeric('init');
                        $('#parkirtol').autoNumeric('init');
                        $('#keamanan').autoNumeric('init');
                        $('#minuman').autoNumeric('init');
                        $('#rektelp').autoNumeric('init');
                        $('#rekair').autoNumeric('init');
                        $('#listrik').autoNumeric('init');
                        $('#komisi').autoNumeric('init');
                        $('#gaji').autoNumeric('init');
                        $('#pajak').autoNumeric('init');
                        $('#sumbangan').autoNumeric('init');
                        $('#pemeliharaan').autoNumeric('init');
                        $('#materai').autoNumeric('init');
                    });
            </script>
            <h2>Edit Data</h2>
            <form action="module/biayasr/edit.proses.php" method="POST" class="form-horizontal" id="create">

                <div class="row">
                    <div class="span1"></div>
                    <div class="span5">
                        <div class="control-group">
                            <label class="control-label">Fotocopy</label>
                            <div class="controls">                            
                                <div class="input-prepend">                                
                                    <span class="add-on">Rp</span>
                                    <input type="text" class="span2" style="text-align: right;" id="fotocopy" name="fotocopy" value="<?php echo $a['fotocopy']; ?>">
                                    <input type="hidden" class="span2" id="id" name="id" value="<?php echo $a['id']; ?>">
                                </div>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Lain - Lain</label>
                            <div class="controls">                            
                                <div class="input-prepend">                                
                                    <span class="add-on">Rp</span>
                                    <input type="text" class="span2" style="text-align: right;" id="lainlain" name="lainlain" value="<?php echo $a['lainlain']; ?>">
                                </div>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Iklan</label>
                            <div class="controls">                            
                                <div class="input-prepend">                                
                                    <span class="add-on">Rp</span>
                                    <input type="text" class="span2" style="text-align: right;" id="iklan" name="iklan" value="<?php echo $a['iklan']; ?>">
                                </div>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Konsumsi</label>
                            <div class="controls">                            
                                <div class="input-prepend">                                
                                    <span class="add-on">Rp</span>
                                    <input type="text" class="span2" style="text-align: right;" id="konsumsi" name="konsumsi" value="<?php echo $a['konsumsi']; ?>">
                                </div>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Bahan Bakar</label>
                            <div class="controls">                            
                                <div class="input-prepend">                                
                                    <span class="add-on">Rp</span>
                                    <input type="text" class="span2" style="text-align: right;" id="bahanbakar" name="bahanbakar" value="<?php echo $a['bahanbakar']; ?>">
                                </div>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Alat Tulis Kantor</label>
                            <div class="controls">                            
                                <div class="input-prepend">                                
                                    <span class="add-on">Rp</span>
                                    <input type="text" class="span2" style="text-align: right;" id="atk" name="atk" value="<?php echo $a['atk']; ?>">
                                </div>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Parkir dan Tol</label>
                            <div class="controls">                            
                                <div class="input-prepend">                                
                                    <span class="add-on">Rp</span>
                                    <input type="text" class="span2" style="text-align: right;" id="parkirtol" name="parkirtol" value="<?php echo $a['parkir_tol']; ?>">
                                </div>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Keamanan</label>
                            <div class="controls">                            
                                <div class="input-prepend">                                
                                    <span class="add-on">Rp</span>
                                    <input type="text" class="span2" style="text-align: right;" id="keamanan" name="keamanan" value="<?php echo $a['keamanan']; ?>">
                                </div>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Minuman</label>
                            <div class="controls">                            
                                <div class="input-prepend">                                
                                    <span class="add-on">Rp</span>
                                    <input type="text" class="span2" style="text-align: right;" id="minuman" name="minuman" value="<?php echo $a['minuman']; ?>">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="span6">
                        <div class="control-group">
                            <label class="control-label">Rek. Telp</label>
                            <div class="controls">                            
                                <div class="input-prepend">                                
                                    <span class="add-on">Rp</span>
                                    <input type="text" class="span2" style="text-align: right;" id="rektelp" name="rektelp" value="<?php echo $a['rektelp']; ?>">
                                </div>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Rek. Air</label>
                            <div class="controls">                            
                                <div class="input-prepend">                                
                                    <span class="add-on">Rp</span>
                                    <input type="text" class="span2" style="text-align: right;" id="rekair" name="rekair" value="<?php echo $a['rekair']; ?>">
                                </div>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Rek. Listrik</label>
                            <div class="controls">                            
                                <div class="input-prepend">                                
                                    <span class="add-on">Rp</span>
                                    <input type="text" class="span2" style="text-align: right;" id="listrik" name="listrik" value="<?php echo $a['listrik']; ?>">
                                </div>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Komisi</label>
                            <div class="controls">                            
                                <div class="input-prepend">                                
                                    <span class="add-on">Rp</span>
                                    <input type="text" class="span2" style="text-align: right;" id="komisi" name="komisi" value="<?php echo $a['komisi']; ?>">
                                </div>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Gaji</label>
                            <div class="controls">                            
                                <div class="input-prepend">                                
                                    <span class="add-on">Rp</span>
                                    <input type="text" class="span2" style="text-align: right;" id="gaji" name="gaji" value="<?php echo $a['gaji']; ?>">
                                </div>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Pajak</label>
                            <div class="controls">                            
                                <div class="input-prepend">                                
                                    <span class="add-on">Rp</span>
                                    <input type="text" class="span2" style="text-align: right;" id="pajak" name="pajak" value="<?php echo $a['pajak']; ?>">
                                </div>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Sumbangan</label>
                            <div class="controls">                            
                                <div class="input-prepend">                                
                                    <span class="add-on">Rp</span>
                                    <input type="text" class="span2" style="text-align: right;" id="sumbangan" name="sumbangan" value="<?php echo $a['sumbangan']; ?>">
                                </div>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Pemeliharaan</label>
                            <div class="controls">                            
                                <div class="input-prepend">                                
                                    <span class="add-on">Rp</span>
                                    <input type="text" class="span2" style="text-align: right;"  id="pemeliharaan" name="pemeliharaan" value="<?php echo $a['pemeliharaan']; ?>">
                                </div>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Materai</label>
                            <div class="controls">                            
                                <div class="input-prepend">                                
                                    <span class="add-on">Rp</span>
                                    <input type="text" class="span2" style="text-align: right;" id="materai" name="materai" value="<?php echo $a['materai']; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary btn-small" >Simpan</button>
                    <button class="btn btn-small btn-tertiary" id="" type="button" onclick="window.location.href = 'index.php?r=biayasr&page=view';" >Batal</button> 

                </div>
            </form>
            <?php
        }
    }
}    