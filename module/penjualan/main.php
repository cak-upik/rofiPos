
<?php
include"../../conf/connect.php";
include"../../conf/fungsi_indotgl.php";
include"../../conf/library.php";
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
        ?>
        <script src="module/penjualan/main.js"></script>
        <p><button onClick="document.location = 'index.php?r=penjualan&page=create';" class="btn btn-warning"><i class="icon-plus-sign icon-white"></i> Tambah</button></p>

        <table id="jualunit" class="table table-bordered table-striped table-highlight">
            <thead>
                <tr>
                    <th width="5%">#</th>
                    <th>No Penjualan</th>
                    <th>Nama</th>
                    <th>Leasing</th>
                    <th>Tanggal</th>
                    <th width="32%">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = mysql_query("SELECT p.* ,  c.`name` as customer , l.`name` as leasing, u.`name` as unit , 
                                    du.id_detail_unit
                                    FROM penjualan p  
                                    INNER JOIN ref_customer c ON c.id_customer = p.id_customer
                                    INNER JOIN ref_leasing l ON l.id = p.id_leasing
                                    INNER JOIN detail_penjualan dp ON dp.id_penjualan = p.id_penjualan 
                                    INNER JOIN tb_detail_unit du ON du.id_detail_unit = dp.id_detail_unit
                                    INNER JOIN tb_unit u ON dp.id_unit = u.id
                                    GROUP BY p.id_penjualan
                                    order by p.id_penjualan DESC");
                
                    $number = 1;
                    while ($result = mysql_fetch_array($query)) {
                        echo"<tr>
                                <td>$number</td>
                                <td>$result[no_faktur]</td>
                                <td>$result[customer]</td>
                                <td>$result[leasing]</td>
                                <td>" . tgl_indo($result['tanggal']) . "</td>
                                <td>
                                    <a href='#myModal" . $number . "' title='Show Detail' data-toggle='modal' id='id_jual_unit' value='$result[id_penjualan]' class='btn'><i class='icon-eye-open'></i> Detail</a>
                                    <a href='index.php?r=penjualan&page=edit&id=$result[id_penjualan]&du=$result[id_detail_unit]' title='Edit' class='btn btn-inverse'><i class='icon-edit'></i> Edit</a>
                                    <a href='module/penjualan/delete.php?id=$result[id_penjualan]' title='Delete' onClick=\"return confirm ('Are you sure?')\" class='btn btn-danger'><i class='icon-remove'></i> Delete</a>
                                    <a href='module/penjualan/main.php?r=penjualan&page=print&id=$result[id_penjualan]' title='Print' target='_blank' class='btn btn-info'><i class='icon-print'></i> Print</a>
                                </td>
                             </tr>";
                        $number++;
                    }
                ?>
            </tbody>
        </table>
        <script src="js/jquery-1.7.2.min.js"></script> 
        <script src="js/jquery.dataTables.js"></script>
        <script>
                $(document).ready(function() {
                    $('#jualunit').dataTable({
                        "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]]
                    });
                });
        </script>
        <?php
        $no = 1;
        $query2 = mysql_query("SELECT p.* ,  c.`name` as customer , l.`name` as leasing, u.`name` as unit , 
                                    du.id_detail_unit
                                    FROM penjualan p  
                                    INNER JOIN ref_customer c ON c.id_customer = p.id_customer
                                    INNER JOIN ref_leasing l ON l.id = p.id_leasing
                                    INNER JOIN detail_penjualan dp ON dp.id_penjualan = p.id_penjualan 
                                    INNER JOIN tb_detail_unit du ON du.id_detail_unit = dp.id_detail_unit
                                    INNER JOIN tb_unit u ON dp.id_unit = u.id
                                    GROUP BY p.id_penjualan
                                    order by p.id_penjualan DESC");
        while ($result2 = mysql_fetch_array($query2)) {
            ?>
            <script type="text/javascript">
                $('#myModal<?php echo $no; ?>').on('show', function(event) {
                    var id_jual_unit = document.getElementById('id').value;
                });
            </script>
            <!-- Modal -->
            <style type="text/css">
                .modal{
                    left:37%;
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
                                <th>Nama Unit</th>
                                <th>Warna</th>
                                <th>No. Rangka</th>
                                <th>No. Mesin</th>
                                <th>Tahun</th>
                                <th>Harga OTR</th>
                                <th>Uang Muka</th>
                                <th>Diskon</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $getDetail = mysql_query("SELECT d.uang_muka, d.diskon, (u.hargaotr - d.uang_muka + d.diskon) as jml ,u.`name` as unit ,  u.hargakosongan, 
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
//        $jmldata = mysql_num_rows(mysql_query("SELECT p.* ,  c.`name` as customer , l.`name` as leasing, u.`name` as unit , 
//                                    du.id_detail_unit
//                                    FROM penjualan p  
//                                    INNER JOIN ref_customer c ON c.id_customer = p.id_customer
//                                    INNER JOIN ref_leasing l ON l.id = p.id_leasing
//                                    INNER JOIN detail_penjualan dp ON dp.id_penjualan = p.id_penjualan 
//                                    INNER JOIN tb_detail_unit du ON du.id_detail_unit = dp.id_detail_unit
//                                    INNER JOIN tb_unit u ON dp.id_unit = u.id
//                                    GROUP BY p.id_penjualan
//                                    order by p.id_penjualan DESC"));
//        $jmlhalaman = $p->jumlahHalaman($jmldata, $batas);
//        $linkHalaman = $p->navHalaman($_GET['halaman'], $jmlhalaman);
        echo "<div class='pagination pagination-centered' id=paging>$linkHalaman</div><br>";
    } elseif ($page == 'create') {
        ?>

        <script src="module/penjualan/main.js"></script>
        <form action="module/penjualan/input.proses.php" method="POST"s class="form-horizontal" id="create">
            <?php
            $kode = fakturNumber();
            $tglw = tgl_indo($tgl_sekarang);
            ?>
            <div class="row">
                <div class="span5">
                    <div class="control-group">
                        <label class="control-label">Nomor Penjualan</label>
                        <div class="controls">
                            <input type="text" class="span2" id="no_faktur" name="no_faktur" value="<?php echo $kode; ?>"  readonly>
                            <input type="hidden" class="span4" id="id_pegawai" name="id_pegawai" value="<?php echo $id_pegawai; ?>">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Customer *</label>
                        <div class="controls">
                            <select name="customer" id="id_suplier"  class="input-large">
                                <?php
                                $selectCustomer = mysql_query("select * from ref_customer order by name");
                                while ($row = mysql_fetch_array($selectCustomer)) {
                                    echo"<option value='$row[id_customer]'>$row[name]</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Nama Leasing *</label>
                        <div class="controls">
                            <select name="leasing" id="ref_leasing_id" class="input-large">
                                <?php
                                $selectLeasing = mysql_query("select * from ref_leasing order by name");
                                while ($row = mysql_fetch_array($selectLeasing)) {
                                    echo"<option value='$row[id]'>$row[name]</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="span7">
                    <div class="control-group" >
                        <label class="control-label">Tanggal :</label>
                        <div class="controls">    
                            <input type="text" class="span2" id="tanggal" name="tanggal" value="<?php echo $tglw; ?>" readonly>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Unit *</label>
                        <div class="controls">
                            <select name="unit" id="unit" class="input-large">
                                <option value="0">Pilih</option>
                                <?php
                                $query = mysql_query("SELECT * FROM tb_unit");
                                while ($a = mysql_fetch_array($query)) {
                                    echo"<option value='$a[id]'>$a[name]</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">No. Rangka *</label>
                        <div class="controls">
                            <select name="warna" id="warna" class="input-large">

                            </select>
                            <button class="btn btn-small" id="addPro" type="button" ><i class="icon-plus" style="margin-top: 3px;"></i> Tambah List</button> 
                            <button class="btn btn-small" id="deletePro" type="button" ><i class="icon-minus" style="margin-top: 3px;"></i> Hapus List</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="well" style="max-height: auto; overflow: auto;">               
                <table class="table table-bordered table-striped table-highlight">
                    <thead>
                        <tr>
                            <th>#</th>
                            <!--<th>Nama Supplier</th>-->
                            <th>Nama Unit</th>								
                            <th>Warna</th>  
                            <th>No Rangka Unit</th>
                            <th>No Mesin Unit</th> 
                            <th>Tahun</th>     
                            <th>Harga OTR</th>                         
                            <th>Uang Muka</th>	                                 
                            <th>Diskon</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody id="detailUnit">
                        <tr><td colspan="9" class="sys_align_center">Belum ada data yang dimasukkan</td></tr>
                    </tbody>
                    <tr id="jmlJuaUnit">
                        <td colspan="9" style="text-align: right;"><b>Total : </b></td>
                        <td><div class="input-prepend"><span class="add-on">Rp</span><input class="span2" type="text" name="total" id="jmlUnit" style="text-align: right;" readonly></div></td>
                    </tr>
                </table>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary btn-small" id="save" name="save">Simpan</button>
                <button class="btn btn-small btn-tertiary" id="" type="button" onclick="window.location.href = 'index.php?r=penjualan&page=view';" >Batal</button> 

            </div>
        </form>
        <?php
    } elseif ($page == 'edit') {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $query_edit = mysql_query("SELECT p.*,  c.`name` as customer, c.id_customer , l.`name` as leasing,l.id, u.`name` as unit, dp.id_unit 
                                    FROM penjualan p  
                                    INNER JOIN ref_customer c ON c.id_customer = p.id_customer
                                    INNER JOIN ref_leasing l ON l.id = p.id_leasing
                                    INNER JOIN detail_penjualan dp ON dp.id_penjualan = p.id_penjualan                                    
                                    INNER JOIN tb_unit u ON dp.id_unit = u.id 
                                    where p.id_penjualan='$id'");
            $row = mysql_fetch_array($query_edit);
            ?>
            <script src="module/penjualan/main_edit.js"></script>
            <form action="module/penjualan/edit.proses.php" method="POST" class="form-horizontal" id="creates">
                <div class="row">
                    <div class="span5">
                        <div class="control-group">
                            <label class="control-label">Nomor Penjualan :</label>
                            <div class="controls">
                                <input type="hidden" class="span2" id="id_penjualan" name="id_penjualan" value="<?php echo $row['id_penjualan']; ?>"  readonly>
                                <label class="control"><?php echo $row['no_faktur']; ?></label>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Customer * :</label>
                            <div class="controls">
                                <label class="control"><?php echo $row['customer']; ?></label>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Nama Leasing *</label>
                            <div class="controls">
                                <select name="leasing" id="ref_leasing_id" class="input-large">
                                    <?php
                                    $selectLeasing = mysql_query("select * from ref_leasing order by name");
                                    while ($rows = mysql_fetch_array($selectLeasing)) {
                                        if ($row['id_leasing'] == $rows['id']) {
                                            echo"<option value='$rows[id]' selected>$rows[name]</option>";
                                        } else {
                                            echo"<option value='$rows[id]'>$rows[name]</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="span7">
                        <div class="control-group" >
                            <label class="control-label">Tanggal :</label>
                            <div class="controls">    
                                <input type="text" class="span2" id="tanggal" name="tanggal" value="<?php echo tgl_indo($row['tanggal']); ?>" readonly>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Unit *</label>
                            <div class="controls">
                                <select name="unit" id="unit" class="input-large">
                                    <option value="0">Pilih</option>
                                    <?php
                                    $query = mysql_query("SELECT * FROM tb_unit");
                                    while ($a = mysql_fetch_array($query)) {
                                        echo"<option value='$a[id]'>$a[name]</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">No. Rangka *</label>
                            <div class="controls">
                                <select name="warna" id="warna" class="input-large">

                                </select>
                                <button class="btn btn-small" id="addEdit" type="button" ><i class="icon icon-plus"></i> Tambah List</button> 
                                <button class="btn btn-small" id="deleteEdit" type="button" ><i class="icon icon-minus"></i> Hapus List</button>
                            </div>
                        </div>
                    </div>
                    <div class="well" style="max-height: 250px; overflow: auto;">
                        <table class="table table-bordered table-striped table-highlight">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Unit</th>								
                                    <th>Warna</th>  
                                    <th>No Rangka Unit</th>
                                    <th>No Mesin Unit</th> 
                                    <th>Tahun</th>     
                                    <th>Harga OTR</th>                         
                                    <th>Uang Muka</th>	                                 
                                    <th>Diskon</th>
                                    <th>Jumlah</th>
                                </tr>
                            </thead>
                            <tbody id="detailUnit">
                                <?php
                                $query_unit = mysql_query("SELECT p.*, rc.`name` as warna, du.hargabeli, du.no_rangka, du.no_mesin, 
                                                du.tahun, du.id_detail_unit as id, dp.uang_muka,dp.diskon, dp.jumlah, dp.id_unit as idunit, 
                                                dp.id_detail_penjualan, u.name as unit, u.hargaotr
                                                FROM detail_penjualan dp                                                
                                                INNER JOIN penjualan p ON p.id_penjualan = dp.id_penjualan
                                                INNER JOIN tb_unit u ON u.id = dp.id_unit
                                                INNER JOIN tb_detail_unit du ON du.id_detail_unit = dp.id_detail_unit
                                                INNER JOIN ref_color rc ON rc.id_color = du.id_color
                                                WHERE dp.id_penjualan = '$id'");
                                $jum2 = mysql_num_rows($query_unit);
                                if ($jum2 > 0) {
                                    $no2 = 1;
                                    while ($row2 = mysql_fetch_array($query_unit)) {
                                        ?>
                                        <tr>
                                            <td><input type="checkbox" id="editCheck_<?php echo $row2['id']; ?>" value="<?php echo $row2['id']; ?>"/></td>
                                            <td><input name="unit[edit][<?php echo $no2; ?>][nama_unit]" type="text" class="span2" id="unit" value="<?php echo $row2['unit']; ?>" readonly/>
                                                <input name="unit[edit][<?php echo $no2; ?>][idunit]" type="hidden" class="span1" value="<?php echo $row2['idunit']; ?>" id="idunit_<?php echo $row2['id']; ?>"/>
                                                <input name="unit[edit][<?php echo $no2; ?>][id]" type="hidden" class="span1" value="<?php echo $row2['idunit']; ?>" id="iddetailunit_<?php echo $row2['id']; ?>"/>
                                                <input name="iddetailjual" type="hidden" class="span1" value="<?php echo $row2['id_detail_penjualan']; ?>" id="iddetailpenjualan_<?php echo $row2['id']; ?>"/>
                                            </td>
                                            <td><input name="unit[edit][<?php echo $no2; ?>][nama_warna]" type="text" class="span1" id="nama_warna" value="<?php echo $row2['warna']; ?>" readonly/></td>
                                            <td><input name="unit[edit][<?php echo $no2; ?>][noRangka]" type="text" class="span2" id="noRangka" value="<?php echo $row2['no_rangka']; ?>" readonly="">
                                            <td><input name="unit[edit][<?php echo $no2; ?>][noMesin]" type="text" class="span2" id="noMesin" value="<?php echo $row2['no_mesin']; ?>" readonly="">
                                            <td><input name="unit[edit][<?php echo $no2; ?>][tahun]" type="text" class="span1"  id="tahun" value="<?php echo $row2['tahun']; ?>" readonly="">
                                            <td><div class="input-prepend"><span class="add-on">Rp</span><input name="unit[edit][<?php echo $no2; ?>][harga]" type="text" class="span2" id="harga_<?php echo $row2['id']; ?>" value="<?php echo $row2['hargaotr']; ?>" readonly style="text-align: right;"/></div></td>
                                            <td><div class="input-prepend"><span class="add-on">Rp</span><input name="unit[edit][<?php echo $no2; ?>][kuantitas]" type="text" class="span2" id="kuantitas_<?php echo $row2['id']; ?>" value="<?php echo $row2['uang_muka']; ?>" onkeyup="autoComplete(<?php echo $row2['id']; ?>);" style="text-align: right;"/></div></td>
                                            <td><div class="input-prepend"><span class="add-on">Rp</span><input name="unit[edit][<?php echo $no2; ?>][diskon]" type="text" class="span2" id="diskon_<?php echo $row2['id']; ?>" value="<?php echo $row2['diskon']; ?>" onkeyup="autoComplete(<?php echo $row2['id']; ?>);" style="text-align: right;"/></div></td>
                                            <td><div class="input-prepend"><span class="add-on">Rp</span><input name="unit[edit][<?php echo $no2; ?>][jumlah]" type="text" class="span2 txt" id="jumlah_<?php echo $row2['id']; ?>" value="<?php echo $row2['jumlah']; ?>" readonly style="text-align: right;"/></div></td>
                                    <input name="subtotal" type="hidden" class="span1" value="<?php echo $row2['subtotal_penjualan']; ?>" id="subtotal"/>

                                    <?php
                                }
                            } else {
                                ?>
                                <tr><td colspan="9" class="sys_align_center">Belum ada data yang dimasukkan</td></tr>
                                <?php
                            }
                            ?>

                            </tbody>

                            <tr id="EditJmlJualUnit">
                                <td colspan="9" style="text-align: right;"><b>Total : </b></td>
                                <td>
                                    <div class="input-prepend">
                                        <span class="add-on">Rp</span>
                                        <input class="span2" type="text" name="total" id="total" value="<?php echo $row['subtotal_penjualan']; ?>" readonly style="text-align: right;">
                                    </div>
                                </td>
                            </tr>

                        </table>
                    </div>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary btn-small" id="save">Simpan</button>
                    <button class="btn btn-small btn-tertiary" id="" type="button" onclick="window.location.href = 'index.php?r=penjualan&page=view';" >Batal</button> 

                </div>
            </form>
            <?php
        }
    } elseif ($page == 'detail') {
        echo json_encode(array('row' => '<tr class="toggle"><td colspan="8">tes
                        </td></tr>'));
//    } elseif ($page == 'report') {
        ?>
        <!--        <script src="module/penjualan/main.js"></script>
        <form name="form" target="_blank" method="POST" action="module/penjualan/print.php?sub=laporan1">
        <div class="well-small">
        <?php
//                combonamabln(1, 12, 'bln_filter', $bln_sekarang);
//                combothn($thn_sekarang - 3, $thn_sekarang, 'thn_filter', $thn_sekarang);
        ?>
        <input type="submit" name="search" value="Cari" class="btn btn-warning">
        </div>
        </form>
        <div class="span12" style="margin: 0 auto; ">
        <center><img src="img/report.jpg" width="550px"></center>
        </div>-->
        <?php
//    }
//}
    } elseif ($page == 'print') {
        ?>
            <title>Penjualan</title>
        <style>
            .header{
                margin: 0 auto; width: 800px; text-align: center;
            }
            .content{
                width:905px; margin: 0 auto;
                font-family: Arial; 
            }
            table{
                border-collapse:collapse;
            }

            .table{
                font-family: Arial; 
                font-size: 13px;
            }

            .table th{
                border:2px solid black;
                text-align:center;
                text-transform:capitalize;
            }
            .table tr{
                text-transform:capitalize;

            }
            .table td{
                border-right:2px solid black;

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
            .note{
                font-size: 13px;
            }
            .detail{
                border: #039;
            }
        </style>

        <?php
        $query = mysql_query("SELECT p.*,  c.`name` as customer, c.id_customer, c.alamat as supplier_address, 
                                c.phone as supplier_phone , l.`name` as leasing,l.id, u.`name` as unit, dp.id_unit ,
                                sum(dp.jumlah) as subtotal
                                    FROM penjualan p  
                                    INNER JOIN ref_customer c ON c.id_customer = p.id_customer
                                    INNER JOIN ref_leasing l ON l.id = p.id_leasing
                                    INNER JOIN detail_penjualan dp ON dp.id_penjualan = p.id_penjualan                                    
                                    INNER JOIN tb_unit u ON dp.id_unit = u.id 
                                    where p.id_penjualan='$_GET[id]'");

        $b = mysql_fetch_array($query);
        $tgl = tgl_indo($b['tanggal']);
        ?>
        <div class="content">
            <center><h2> PENJUALAN</h2></center>

            <div class="info1">
                <table style="width: auto;" cellpadding="5">
                    <tr>
                        <td style="width: 95;"><b>No. Penjualan</b></td>
                        <td style="width: auto;">: <?php echo $b['no_faktur']; ?></td>
                    </tr>
                    <tr>
                        <td><b>Date</b></td>
                        <td>: <?php echo $tgl; ?></td>
                    </tr>
                </table>
            </div>
            <br />
            <br />
            <br />
            <br />

            <div class="rightleft">
                <span class="left">
                    <table class="table" width="300px" border="1" cellpadding="5" cellspacing="0">
                        <thead><tr><th>Customer :</th></tr></thead>
                        <tbody><tr>
                                <td style="border:2px solid black;"><?php echo $b['customer']; ?><br />
                                    <?php echo $b['supplier_address']; ?> <br />
                                    <?php echo $b['supplier_phone']; ?> <br />
                                    INDONESIA      <no_fakturbr />
                        </td>
                        </tr></tbody>
                    </table>
                </span>

                <span class="right">
                    <table class="table" width="300px" border="1" cellpadding="5" cellspacing="0">
                        <thead><tr><th>Faktur :</th></tr></thead>
                        <tbody><tr>
                                <td style="border:2px solid black;">
                                    PT. Meji Sakti <br />

                                </td>
                            </tr></tbody>
                    </table>
                </span>
            </div>
            <br />
            <table class="table" border="1">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Unit</th>
                        <th>Leasing</th>
                        <th>Warna</th>
                        <th>No. Rangka</th>
                        <th>No. Mesin</th>
                        <th>Tahun</th>
                        <th>Harga OTR</th>
                        <th>Uang Muka</th>
                        <th>Diskon</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
//                    $query2 = mysql_query("SELECT p.*,  c.`name` as customer ,  c.id_customer, l.`name` as leasing,  
//                                                l.id, u.`name` as unit , rc.`name` as warna, du.hargabeli, du.no_rangka, du.no_mesin, 
//                                                du.tahun, du.id_detail_unit as id, dp.uang_muka,dp.diskon, dp.jumlah, dp.id_unit as idunit,
//                                                (dpu.kuantitas * dpu.harga) as harga_beli
//                                                FROM detail_penjualan dp
//                                                INNER JOIN penjualan p ON p.id_penjualan = dp.id_penjualan
//                                                INNER JOIN ref_customer c ON c.id_customer = p.id_customer
//                                                INNER JOIN ref_leasing l ON l.id = p.id_leasing
//                                                INNER JOIN tb_unit u ON u.id = dp.id_unit
//                                                INNER JOIN tb_detail_unit du ON du.id_detail_unit = dp.id_detail_unit
//                                                INNER JOIN ref_color rc ON rc.id_color = du.id_color
//                                                INNER JOIN tb_pemesanan_unit pu ON pu.id_unit = u.id
//                                                INNER JOIN tb_detail_pemesanan_unit dpu ON dpu.id_pemesanan_unit = pu.id_pemesanan_unit
//                                                WHERE p.id_penjualan =' $_GET[id]' GROUP BY dp.id_detail_unit");

                    $query2 = mysql_query("SELECT d.uang_muka, d.diskon, (u.hargaotr - d.uang_muka + d.diskon) as jml ,u.`name` as unit ,  u.hargakosongan, 
                                                u.hargaotr, du.no_mesin, du.no_rangka,du.tahun,c.`name` as color, (dpu.kuantitas * dpu.harga) as harga_beli,
                                                l.name as leasing
                                                FROM detail_penjualan d
                                                INNER JOIN penjualan p ON p.id_penjualan = d.id_penjualan
                                                INNER JOIN tb_unit u ON u.id = d.id_unit
                                                INNER JOIN tb_detail_unit du ON du.id_detail_unit = d.id_detail_unit
                                                INNER JOIN ref_color c ON c.id_color = du.id_color
                                                INNER JOIN ref_leasing l ON l.id = p.id_leasing
                                                Left JOIN tb_pemesanan_unit pu on pu.id_unit = u.id
                                                LEFT JOIN tb_detail_pemesanan_unit dpu on dpu.id_pemesanan_unit = pu.id_pemesanan_unit
                                                WHERE p.id_penjualan =' $_GET[id]'");
                    $rows = mysql_query($query2);
                    $no = 1;
                    while ($r = mysql_fetch_array($query2)) {
                        echo"<tr>
                                <td style='text-align:center;'>$no</td>
                                <td>" . $r['unit'] . "</td>
                                <td>" . $r['leasing'] . "</td>
                                <td>" . $r['color'] . "</td>
                                <td>" . $r['no_rangka'] . "</td>
                                <td>" . $r['no_mesin'] . "</td>
                                <td>" . $r['tahun'] . "</td>
                                <td style='white-space:nowrap; text-align:right;'>" . rupiah($r['hargaotr']) . "</td>
                                <td style='white-space:nowrap; text-align:right;'>" . rupiah($r['uang_muka']) . "</td>
                                <td style='white-space:nowrap; text-align:right;'>" . rupiah($r['diskon']) . "</td>
                                <td style='white-space:nowrap; text-align:right;'>" . rupiah($r['jml']) . "</td>
                             </tr>";
                        $no++;
                    }
                    ?>
                    <tr>
                        <td colspan="9" style="border:2px solid black; border-left:hidden;border-bottom:hidden;"></td>
                        <td class="right_align" style="border-top:2px solid black;"><b>Subtotal</b></td>
                        <td class="right_align" style="white-space:nowrap; text-align:right; border-top:2px solid black;"><?php echo rupiah($b['subtotal']); ?></td>
                    </tr>
                </tbody>
            </table>
            <br/><br/><br/>
            <table width="100%" class="note">
                <tr>

                    <td align="right">Approved by,</td>
                </tr>
                <tr>
                    <td height="73">&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>

                    <td align="right">(Staff Gudang)</td>
                </tr>
            </table>
        </div>
        <?php
    } else {
        
    }
}