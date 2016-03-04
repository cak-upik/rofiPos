<script src="module/pembelian/main.js"></script>
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
        <p><button onClick="document.location = 'index.php?r=pembelian&page=create';" class="btn btn-warning"><i class="icon-plus-sign icon-white"></i> Tambah</button>
            <button onClick="document.location = 'index.php?r=pembelian&page=report';" class="btn btn-inverse"><i class="icon-file icon-white"></i> Report</button></p>

        <table class="table table-bordered table-striped table-highlight">
            <thead>
                <tr>
                    <th>#</th>
                    <th>No Pembelian</th>
                    <th>Nama Supplier</th>
                    <th>Tanggal Beli</th>
                    <th>Nama Unit</th>
                    <th>Harga Beli</th>
                    <th>Qty</th>
                    <th style="width: auto;">Jumlah</th>
                    <th colspan="3" style="width: 6%;">Action</th>
                </tr>
            </thead>



            <tbody> 
                <?php
                $p = new Paging;
                $batas = 15;
                $posisi = $p->cariPosisi($batas);
                $query = mysql_query("select tp.id AS id,
                                                tp.no_beli AS No_Pembelian,
                                                rs.`name` AS Nama_Supplier,
                                                tp.tanggal,
                                                tu.name AS Nama_item,
                                                tp.noRangka AS No_Rangka,
                                                tp.noMesin AS No_Mesin,
                                                tp.tahun as Tahun,
                                                rc.`name` AS Nama_Warna,						
                                                tu.hargabeli AS Harga_Beli,
                                                tp.qty,
                                                tp.total
                                                from ((tb_pembelian tp
                                                INNER JOIN tb_unit tu
                                                on ((tu.id = tp.tb_unit_id)))
                                                INNER JOIN ref_supplier rs
                                                on ((rs.id_supplier = tp.ref_supplier_id))
                                                INNER JOIN ref_color rc
                                                on ((rc.id_color = tp.id_color)))
                        order by tanggal desc LIMIT $posisi,$batas");

                $total = mysql_num_rows($query);

                if ($total > 0) {
                    $no = 1;
                    while ($result = mysql_fetch_array($query)) {
                        $tgl = tgl_indo($result['tanggal']);
                        echo"<tr>
                            <td>$no</td>
                            <td>$result[No_Pembelian]</td>
                            <td>$result[Nama_Supplier]</td>
                            <td>$tgl</td>
                            <td>$result[Nama_item]</td>
                            <td style='text-align:right;'>" . rupiah($result['Harga_Beli']) . "</td>
                            <td>$result[qty]</td>
                            <td style='text-align:right;'>" . rupiah($result['total']) . "</td>
                            <td style='text-align:center;'>
                                <a href='#' title='Show Detail' class='trigger'><i class='icon-eye-open'></i></a>                             
                                <a href='index.php?r=pembelian&page=edit&id=$result[id]' title='Edit'><i class='icon-edit'></i></a>
                                <a href='module/pembelian/delete.php?id=$result[id]' title='Delete' onClick=\"return confirm ('Are you sure?')\"><i class='icon-remove'></i></a>
                            </td>
                           </tr>
                           <tr class=\"details\" style='display:none;'>
                                <td colspan=\"8\">";
                        $getDetail = mysql_query("SELECT tp.id AS id, tp.no_beli AS No_Pembelian, rs.`name` AS Nama_Supplier,
                                        tp.tanggal,tu. NAME AS Nama_item, tp.noRangka AS No_Rangka, tp.noMesin AS No_Mesin,
                                        tp.tahun AS Tahun, rc.`name` AS Nama_Warna,tu.hargabeli AS Harga_Beli,
                                        tp.qty,tp.total
                                FROM ((tb_pembelian tp INNER JOIN tb_unit tu ON ((tu.id = tp.tb_unit_id)))
                                                INNER JOIN ref_supplier rs ON ((rs.id_supplier = tp.ref_supplier_id))
                                                INNER JOIN ref_color rc ON ((rc.id_color = tp.id_color)))
                                where tp.id = '$result[id]'");
                        ?>
                    <table class="table table-striped span4">
                        <thead>
                            <tr style="background-color:#ddd; color: black;">
                                <th width="5%">#</th>
                                <th>No Rangka</th>
                                <th>No Mesin</th>
                                <th>Tahun</th>
                                <th>Warna</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $number = 1;
                            while ($row1 = mysql_fetch_array($getDetail)) {
                                echo"<tr>
                                        <td>$number</td>
                                        <td>$row1[No_Rangka]</td>
                                        <td>$row1[No_Mesin]</td>                                            
                                        <td>$row1[Tahun]</td>
                                        <td>$row1[Nama_Warna]</td>
                                     </tr>";
                                $number++;
                            }
                            ?>
                        </tbody> 
                    </table>
                    <?php
                    echo"</td></tr>   ";
                    $no++;
                }
            } else {
                echo"<tr><td colspan='6'><label>Data Tidak Ditemukan</label></td></tr>";
            }
            ?>
        </tbody>
        </table>
        <?php
        $jmldata = mysql_num_rows(mysql_query("select * from tb_pembelian"));
        $jmlhalaman = $p->jumlahHalaman($jmldata, $batas);
        $linkHalaman = $p->navHalaman($_GET['halaman'], $jmlhalaman);
        echo "<div class='pagination pagination-centered' id=paging>$linkHalaman</div><br>";
    } elseif ($page == 'create') {
        ?>
        <form action="module/pembelian/input.proses.php" method="POST" class="form-horizontal" id="create">
            <div class="control-group" >
                <?php
                $kode = notaNumber();
                ?>
                <label class="pull-right">Tanggal :
                    <input type="text" class="span2" id="tanggal" name="tanggal" value="<?php
                    $tglw = tgl_indo($tgl_sekarang);
                    echo $tglw;
                    ?>" readonly></label>
                <label class=""></label>
                <label class="control-label">Nomor Pembelian :</label>
                <div class="controls">
                    <input type="text" class="span2" id="no_beli" name="no_beli" value="<?php echo $kode; ?>" readonly ></label>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Supplier *</label>
                <div class="controls">
                    <select name="supplier" id="supplier"  class="input-large">
                        <?php
                        $suplier = mysql_query("select * from ref_supplier order by name");
                        while ($a = mysql_fetch_array($suplier)) {
                            $base64 = base64_encode(implode('||', array($a['id_supplier'], $a['name'])));
                            echo"<option value='$base64'>[$a[id_supplier]] $a[name]</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Warna *</label>
                <div class="controls">
                    <select name="warna" id="warna"  class="input-large">
                        <?php
                        $warna = mysql_query("select id_color, name as nama_warna from ref_color ORDER BY id_color ASC");
                        while ($a = mysql_fetch_array($warna)) {
                            $base64 = base64_encode(implode('||', array($a['id_color'], $a['nama_warna'])));
                            echo"<option value='$base64'>[$a[id_color]] $a[nama_warna]</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="control-group">            
                <label class="control-label">Pembelian Unit</label>
                <div class="controls">
                    <select name="unit" id="unit" class="input-large">
                        <?php
                        //   $qUnit = mysql_query("SELECT tu.id 'id_unit',rs.id_supplier, rs.`name` as Nama_Supplier, tu.name as nama_item, tu.hargabeli, tu.plafonBbn, tu.hargaOtr,tp.tb_unit_id FROM tb_unit tu INNER JOIN tb_pembelian as tp ON tp.id = tu.id INNER JOIN ref_supplier rs ON tp.id = rs.id_supplier");
                        $qUnit = mysql_query("SELECT name as nama_unit, id, hargabeli FROM tb_unit ORDER BY id ASC");
                        while ($rUnit = mysql_fetch_array($qUnit)) {
                            //$base642 = base64_encode(implode('||', array($rUnit['id_unit'],$rUnit['Nama_Supplier'], $rUnit['nama'], $rUnit['hargabeli'], $rUnit['id_supplier'])));
                            $base642 = base64_encode(implode('||', array($rUnit['id'], $rUnit['nama_unit'], $rUnit['hargabeli'])));
                            echo"<option value='$base642'>[$rUnit[id]] $rUnit[nama_unit]</option>";
                        }
                        ?>
                    </select>
                    <button class="btn btn-mini" id="addPro" type="button" ><i class="icon-plus" style="margin-top: 3px;"></i></button> 
                    <button class="btn btn-mini" id="deletePro" type="button" ><i class="icon-minus" style="margin-top: 3px;"></i></button>
                </div>
                <br/>
                <div class="well" style="max-height: 250px; overflow: auto;">               
                    <table class="table table-bordered table-striped table-highlight">
                        <thead>
                            <tr>
                                <th width="5%">#</th>
                                <!--<th>Nama Supplier</th>-->
                                <th>Nama Unit</th>
                                <th>Harga Beli</th>
                                <th>No Rangka Unit</th>
                                <th>No Mesin Unit</th> 
                                <th>Tahun</th>									
                                <th>Warna</th>                                   
                                <th>Kuantitas</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody id="detailUnit">
                            <tr><td colspan="8" class="sys_align_center">Belum ada data yang dimasukkan</td></tr>
                        </tbody>
                        <tr id="jmlJuaUnit">
                            <td colspan="8" style="text-align: right;"><b>Total : </b></td>
                            <td><input class="span2" type="text" name="jmlUnit" id="jmlUnit" readonly></td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary btn-small" id="save" name="save">Simpan</button>
                <button class="btn btn-small btn-tertiary" id="" type="button" onclick="window.location.href = 'index.php?r=pembelian&page=view';" >Batal</button> 

            </div>
        </form>
        <?php
    } elseif ($page == 'edit') {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $query_edit = mysql_query("select * from tb_pembelian a 
                                    inner join tb_unit b on a.tb_unit_id=b.id 
                                    inner join ref_supplier c on a.ref_supplier_id=c.id_supplier 
                                    inner join ref_color d on b.id=d.id_color
                                    where a.id='$id'");
            $row = mysql_fetch_array($query_edit);
            ?>
            <script src="module/pembelian/main_edit.js"></script>
            <form action="module/pembelian/edit.proses.php" method="POST" class="form-horizontal" id="creates">
                <div class="control-group" >
                    <label class="pull-right">Tanggal :
                        <input type="text" class="span2" id="tanggal" name="tanggal" value="<?php echo tgl_indo($row['tanggal']); ?>" readonly></label>
                    <label class=""></label>

                    <label class="control-label">Nomor Pembelian :</label>
                    <div class="controls">
                        <input type="text" class="span2" id="no_beli" name="no_beli" value="<?php echo $row['no_beli']; ?>" readonly ></label>
                        <input type="hidden" class="span2" id="id" name="id" value="<?php echo $id; ?>" readonly >
                    </div>
                </div>



                <div class="control-group">
                    <label class="control-label">Supplier *</label>
                    <div class="controls">
                        <select name="supplier" id="supplier"  class="input-large">
                            <?php
                            $suplier = mysql_query("select * from ref_supplier order by name");
                            while ($a = mysql_fetch_array($suplier)) {
                                $base64 = base64_encode(implode('||', array($a['id_supplier'], $a['name'])));
                                echo"<option value='$base64'>$a[name]</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Warna *</label>
                    <div class="controls">
                        <select name="warna" id="warna"  class="input-large">
                            <?php
                            $warna = mysql_query("select id_color, name as nama_warna from ref_color ORDER BY id_color ASC");
                            while ($a = mysql_fetch_array($warna)) {
                                $base64 = base64_encode(implode('||', array($a['id_color'], $a['nama_warna'])));
                                echo"<option value='$base64'>[$a[id_color]] $a[nama_warna]</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="control-group">            
                    <label class="control-label">Pembelian Unit</label>
                    <div class="controls">
                        <select name="unit" id="unit" class="input-large">
                            <?php
                            //   $qUnit = mysql_query("SELECT tu.id 'id_unit',rs.id_supplier, rs.`name` as Nama_Supplier, tu.name as nama_item, tu.hargabeli, tu.plafonBbn, tu.hargaOtr,tp.tb_unit_id FROM tb_unit tu INNER JOIN tb_pembelian as tp ON tp.id = tu.id INNER JOIN ref_supplier rs ON tp.id = rs.id_supplier");
                            $qUnit = mysql_query("SELECT name as nama_unit, id, hargabeli FROM tb_unit ORDER BY id ASC");
                            while ($rUnit = mysql_fetch_array($qUnit)) {
                                //$base642 = base64_encode(implode('||', array($rUnit['id_unit'],$rUnit['Nama_Supplier'], $rUnit['nama'], $rUnit['hargabeli'], $rUnit['id_supplier'])));
                                $base642 = base64_encode(implode('||', array($rUnit['id'], $rUnit['nama_unit'], $rUnit['hargabeli'])));
                                echo"<option value='$base642'>[$rUnit[id]] $rUnit[nama_unit]</option>";
                            }
                            ?>
                        </select>


                        <button class="btn btn-mini" id="addPro" type="button" ><i class="icon-plus" style="margin-top: 3px;"></i></button> 
                        <button class="btn btn-mini" id="deletePro" type="button" ><i class="icon-minus" style="margin-top: 3px;"></i></button>
                    </div>
                    <br/>
                    <div class="well" style="max-height: 250px; overflow: auto;">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th>Nama Supplier</th>
                                    <th>Nama Unit</th>
                                    <th>Harga Beli</th>
                                    <th>No Rangka Unit</th>
                                    <th>No Mesin Unit</th> 
                                    <th>Tahun</th>									
                                    <th>Warna</th>                                   
                                    <th>Kuantitas</th>
                                    <th>Jumlah</th>
                                </tr>
                            </thead>
                            <tbody id="detailUnit">
                                <?php
                                $query_unit = mysql_query("select tp.id AS id,
									tp.no_beli,
									rs.`name`,
									tp.tanggal,
									tu.name AS nama_unit,
									tp.noRangka,
									tp.noMesin,
									tp.tahun,
									rc.`name` as nama_warna,						
									tu.hargabeli,
									tp.qty as kuantitas,
									tp.total
									from ((tb_pembelian tp
									INNER JOIN tb_unit tu
									on ((tu.id = tp.tb_unit_id)))
									INNER JOIN ref_supplier rs
									on ((rs.id_supplier = tp.ref_supplier_id))
									INNER JOIN ref_color rc
									on ((rc.id_color = tp.id_color))) 
                                                                where tp.id='$id'");
                                $jum2 = mysql_num_rows($query_unit);
                                if ($jum2 > 0) {
                                    $no2 = 1;
                                    while ($row2 = mysql_fetch_array($query_unit)) {
                                        ?>
                                        <tr>
                                            <td><input type="checkbox" /></td>
                                            <td>
                                                <input name="supplier[edit][<?php echo $no2; ?>][name]" type="text" class="span2" id="name" value="<?php echo $row2['name']; ?>" readonly/>		

                                                <input name="supplier[edit][<?php echo $no2; ?>][id_supplier]" type="hidden" value="<?php echo $row2['id_supplier']; ?>" id="supplier_'<?php echo $row2['id_supplier']; ?>"/></td>

                                            <td><input name="unit[edit][<?php echo $no2; ?>][nama_unit]" type="text" class="span1" id="unit" value="<?php echo $row2['nama_unit']; ?>" readonly/>
                                                <input name="unit[edit][<?php echo $no2; ?>][id]" type="hidden" class="span1" value="<?php echo $row2['id']; ?>" id="akses2_<?php echo $row2['id']; ?>"/></td>


                                            <td><input name="unit[edit][<?php echo $no2; ?>][hargabeli]" type="text" class="span2" id="harga_<?php echo $row2['id']; ?>" value="<?php echo $row2['hargabeli']; ?>" readonly/></td>



                                            <td><input name="unit[edit][<?php echo $no2; ?>][noRangka]" type="text" class="span2" id="noRangka" value="<?php echo $row2['noRangka']; ?>">

                                            <td><input name="unit[edit][<?php echo $no2; ?>][noMesin]" type="text" class="span2" id="noMesin" value="<?php echo $row2['noMesin']; ?>">

                                            <td><input name="unit[edit][<?php echo $no2; ?>][tahun]" type="text" class="span2"  id="tahun" value="<?php echo $row2['tahun']; ?>">
                                            <td><input name="warna[edit][<?php echo $no2; ?>][nama_warna]" type="text" class="span2" id="nama_warna" value="<?php echo $row2['nama_warna']; ?>" readonly/>
                                                <input name="warna[edit][<?php echo $no2; ?>][id_color]" type="hidden" value="<?php echo $row2['id_color']; ?>" id="id_color"/>


                                            <td><input name="unit[edit][<?php echo $no2; ?>][kuantitas]" type="text" class="span1" id="kuantitas_<?php echo $row2['id']; ?>" value="<?php echo $row2['kuantitas']; ?>" onkeyup="autoComplete(<?php echo $row2['id']; ?>);"/></td>
                                            <td><input name="unit[edit][<?php echo $no2; ?>][jumlah]" type="text" class="span2 txt" id="jumlah_<?php echo $row2['id']; ?>" value="<?php echo $row2['total']; ?>" readonly/>

                                                <?php
                                            }
                                        } else {
                                            ?>
                                    <tr><td colspan="3" class="sys_align_center">Belum ada data yang dimasukkan</td></tr>
                                    <?php
                                }
                                ?>

                            </tbody>

                            <tr id="EditJmlJualUnit">
                                <td colspan="4" style="text-align: right;"><b>Total : </b></td>
                                <td><input class="span2" type="text" name="jmlUnit" id="jmlUnit" value="<?php echo $row['total']; ?>" readonly></td>
                            </tr>

                        </table>
                    </div>
                </div>


                <div class="form-actions">
                    <button type="submit" class="btn btn-primary btn-small" id="save">Simpan</button>
                    <button class="btn btn-small btn-tertiary" id="" type="button" onclick="window.location.href = 'index.php?r=pembelian&page=view';" >Batal</button> 

                </div>
            </form>
            <?php
        }
    } elseif ($page == 'detail') {
        echo json_encode(array('row' => '<tr class="toggle"><td colspan="8">tes
                        </td></tr>'));
    } elseif ($page == 'report') {
        ?>
        <script src="module/pembelian/main.js"></script>
        <form name="form" target="_blank" method="POST" action="module/pembelian/print.php?sub=laporan1">
            <div class="well-small">
                <?php
                combonamabln(1, 12, 'bln_filter', $bln_sekarang);
                combothn($thn_sekarang - 3, $thn_sekarang, 'thn_filter', $thn_sekarang);
                ?>
                <input type="submit" name="search" value="Cari" class="btn btn-warning">
            </div>
        </form>
        <div class="span12" style="margin: 0 auto; ">
            <center><img src="img/report.jpg" width="550px"></center>
        </div>
        <?php
    }
}