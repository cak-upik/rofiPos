
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

if (isset($_GET['page'])) {
    $page = $_GET['page'];
    if ($page == 'view') {
        ?>
        <p><button onClick="document.location = 'index.php?r=pengirimanunit&page=create';" class="btn btn-warning"><i class="icon-plus-sign icon-white"></i> Tambah</button>
            <button onClick="document.location = 'index.php?r=pengirimanunit&page=report';" class="btn btn-info"><i class="icon-list icon-white"></i> Report</button></p>

        <table id="kirimunit" class="table table-bordered table-striped table-highlight">
            <thead>
                <tr>
                    <th>#</th>
                    <th>No Pembelian</th>
                    <th>Nama Supplier</th>
                    <th>Tanggal Beli</th>
                    <th style="width: 25%;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = mysql_query("SELECT pe.*, dpe.kuantitas, rc.`name` as warna, du.no_rangka, du.no_mesin, u.plafonbbn, du.tahun, 
                                    rs.name as customer,dpe.id_detail_unit,dpu.id_detail_pemesanan_unit,pu.id_pemesanan_unit, u.id
                                    FROM pembelian pe
                                    INNER JOIN detail_pembelian dpe ON dpe.id_pembelian = pe.id_pembelian
                                    INNER JOIN tb_unit u ON u.id = dpe.id_unit 
                                    INNER JOIN tb_detail_unit du ON du.id_detail_unit = dpe.id_detail_unit
                                    INNER JOIN ref_color rc ON rc.id_color = du.id_color
                                    INNER JOIN tb_pemesanan_unit pu ON pu.id_pemesanan_unit = dpe.id_pemesanan_unit
                                    INNER JOIN tb_detail_pemesanan_unit dpu ON dpu.id_detail_pemesanan_unit = pu.id_detail_pemesanan_unit
                                    INNER JOIN ref_supplier rs ON rs.id_supplier = dpe.id_supplier
                                    GROUP BY pe.id_pembelian
                                    order by pe.id_pembelian DESC");

                $nom = 1;
                while ($result = mysql_fetch_array($query)) {
                    $tgl = tgl_indo($result['tanggal']);
                    echo"<tr>
                            <td>$nom</td>
                            <td>$result[no_faktur]</td>
                            <td>$result[customer]</td>
                            <td>$tgl</td>
                            <td style='text-align:center;'>
                                <a href='#myModal" . $nom . "' title='Show Detail' data-toggle='modal' id='id_kirim_unit' value='$result[id_pembelian]' class='btn'><i class='icon-eye-open'></i> Detail</a>
                                <a href='index.php?r=pengirimanunit&page=edit&id=$result[id_pembelian]&du=$result[id_detail_unit]' title='Edit' class='btn btn-inverse'><i class='icon-edit'></i> Edit</a>
                                <a href='module/pengirimanunit/delete.php?id=$result[id_pembelian]&dpu=$result[id_detail_pemesanan_unit]&pu=$result[id_pemesanan_unit]&u=$result[id]' title='Delete' onClick=\"return confirm ('Are you sure?')\" class='btn btn-danger'><i class='icon-remove'></i> Delete</a>
                            </td>
                           </tr>";
                    $nom++;
                }
                ?>
            </tbody>
        </table>
        <script src="js/jquery-1.7.2.min.js"></script> 
        <script src="js/jquery.dataTables.js"></script>
        <script>
                $(document).ready(function() {
                    $('#kirimunit').dataTable({
                        "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]]
                    });
                });
        </script>
        <?php
        $no = 1;
        $query2 = mysql_query("SELECT pe.*, dpe.kuantitas, rc.`name` as warna, du.no_rangka, du.no_mesin, u.plafonbbn, du.tahun, 
                                    rs.name as customer,dpe.id_detail_unit,dpu.id_detail_pemesanan_unit,pu.id_pemesanan_unit, u.id
                                    FROM pembelian pe
                                    INNER JOIN detail_pembelian dpe ON dpe.id_pembelian = pe.id_pembelian
                                    INNER JOIN tb_unit u ON u.id = dpe.id_unit 
                                    INNER JOIN tb_detail_unit du ON du.id_detail_unit = dpe.id_detail_unit
                                    INNER JOIN ref_color rc ON rc.id_color = du.id_color
                                    INNER JOIN tb_pemesanan_unit pu ON pu.id_pemesanan_unit = dpe.id_pemesanan_unit
                                    INNER JOIN tb_detail_pemesanan_unit dpu ON dpu.id_detail_pemesanan_unit = pu.id_detail_pemesanan_unit
                                    INNER JOIN ref_supplier rs ON rs.id_supplier = dpe.id_supplier
                                    GROUP BY pe.id_pembelian
                                    order by pe.id_pembelian DESC ");
        while ($result2 = mysql_fetch_array($query2)) {
            ?>
            <script type="text/javascript">
                $('#myModal<?php echo $no; ?>').on('show', function(event) {
                    var id_kirim_unit = document.getElementById('id').value;
                });
            </script>
            <!-- Modal -->
            <style type="text/css">
                .modal{
                    left:50%;
                }
            </style>
            <div id="myModal<?php echo $no; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 id="myModalLabel">Detail Pengiriman Unit</h4>
                </div>
                <div class="modal-body">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr style="background-color:#ddd; color: black;">
                                <th width="5%">#</th>
                                <th>No. Pembelian</th>
                                <th>Unit</th>
                                <!--<th>No Rangka</th>-->
                                <!--<th>No Mesin</th>-->
                                <th>Tahun</th>
                                <th>Warna</th>
                                <th>Kuantitas</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $getDetail = mysql_query("SELECT pe.*, dpe.kuantitas, rc.`name` as warna, du.no_rangka, du.no_mesin, 
                                                u.plafonbbn, du.tahun, u.name as unit, pu.no_faktur, dpe.keterangan
                                                FROM pembelian pe
                                                INNER JOIN detail_pembelian dpe ON dpe.id_pembelian = pe.id_pembelian
                                                INNER JOIN tb_unit u ON u.id = dpe.id_unit 
                                                INNER JOIN tb_detail_unit du ON du.id_detail_unit = dpe.id_detail_unit
                                                INNER JOIN ref_color rc ON rc.id_color = du.id_color
                                                INNER JOIN tb_pemesanan_unit pu ON pu.id_pemesanan_unit = dpe.id_pemesanan_unit
                                                INNER JOIN tb_detail_pemesanan_unit dpu ON dpu.id_detail_pemesanan_unit = pu.id_detail_pemesanan_unit
                                                where pe.id_pembelian = '$result2[id_pembelian]'");
                            $nomor = 1;
                            while ($row1 = mysql_fetch_array($getDetail)) {
                                echo"<tr>
                                        <td>$nomor</td>
                                        <td>$row1[no_faktur]</td>
                                        <td>$row1[unit]</td>
                                        <!--<td>$row1[no_rangka]</td>--> 
                                        <!--<td>$row1[no_mesin]</td>-->
                                        <td>$row1[tahun]</td>
                                        <td>$row1[warna]</td>
                                        <td>$row1[kuantitas]</td>
                                        <td>$row1[keterangan]</td>
                                     </tr>";
                                $nomor++;
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
//        $jmldata = mysql_num_rows(mysql_query("SELECT pe.*, dpe.kuantitas, rc.`name` as warna, du.no_rangka, du.no_mesin, u.plafonbbn, du.tahun, 
//                                    rs.name as customer,dpe.id_detail_unit
//                                    FROM pembelian pe
//                                    INNER JOIN detail_pembelian dpe ON dpe.id_pembelian = pe.id_pembelian
//                                    INNER JOIN tb_unit u ON u.id = dpe.id_unit 
//                                    INNER JOIN tb_detail_unit du ON du.id_detail_unit = dpe.id_detail_unit
//                                    INNER JOIN ref_color rc ON rc.id_color = du.id_color
//                                    INNER JOIN tb_pemesanan_unit pu ON pu.id_pemesanan_unit = dpe.id_pemesanan_unit
//                                    INNER JOIN tb_detail_pemesanan_unit dpu ON dpu.id_detail_pemesanan_unit = pu.id_detail_pemesanan_unit
//                                    INNER JOIN ref_supplier rs ON rs.id_supplier = dpe.id_supplier "));
//        $jmlhalaman = $p->jumlahHalaman($jmldata, $batas);
//        $linkHalaman = $p->navHalaman($_GET['halaman'], $jmlhalaman);
//        echo "<div class='pagination pagination-centered' id=paging>$linkHalaman</div><br>";
    } elseif ($page == 'create') {
        $kode = notaNumber();
        $tglw = tgl_indo($tgl_sekarang);
        ?>
            <script src="module/pengirimanunit/main.js"></script>
        <form action="module/pengirimanunit/input.proses.php" method="POST" class="form-horizontal" id="create">
            <?php
            $kode = notaNumber();
            $tglw = tgl_indo($tgl_sekarang);
            ?>
            <div class="row">
                <div class="span8">
                    <div class="control-group">
                        <label class="control-label">Nomor Pembelian </label>
                        <div class="controls">:
                            <input type="text" class="span2" id="no_beli" name="no_beli" value="<?php echo $kode; ?>" readonly ></label>
                        </div>
                    </div>
                </div>
                <div class="span4">                    
                    <div class="control-group" >
                        <label class="control-label">Tanggal </label>
                        <div class="controls">:
                            <input type="text" class="span2" id="tanggal" name="tanggal" value="<?php echo $tglw; ?>" readonly>
                        </div>
                    </div>
                </div>
            </div>            
            <div class="row-fluid">
                <div class="control-group">
                    <label class="control-label">Supplier * </label>
                    <div class="controls">:
                        <select name="supplier" id="supplier"  class="input-large">
                            <?php
                            $suplier = mysql_query("select * from ref_supplier order by name");
                            while ($a = mysql_fetch_array($suplier)) {
                                $base64 = base64_encode(implode('||', array($a['id_supplier'], $a['name'])));
                                echo"<option value='$base64'> $a[name]</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label span2">No. Faktur Pembelian * </label>
                    <div class="controls">:
                        <select name="faktur_unit" id="unit" class="input-large">
                            <option value="0">Pilih</option>
                            <?php
//                            $q = mysql_query("SELECT * FROM tb_pemesanan_unit
//                                            -- where id_pemesanan_unit not in (select distinct id_pemesanan_unit from detail_pembelian)");
                            $q = mysql_query("SELECT * FROM tb_pemesanan_unit pu
                                            left JOIN tb_detail_pemesanan_unit dpu on dpu.id_pemesanan_unit = pu.id_pemesanan_unit
                                            where NOT(dpu.kuantitas = dpu.sisa_kuantitas) GROUP BY pu.id_pemesanan_unit");
                            while ($r = mysql_fetch_array($q)) {
//                                if ($r['kuantitas'] === $r['sisa'] ) {
//                                    echo"<option value='$r[id_pemesanan_unit]'>$r[no_faktur]</option>";
//                                } else  {
                                echo"<option value='$r[id_pemesanan_unit]'>$r[no_faktur]</option>";
//                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Nama Unit * </label>
                    <div class="controls">:
                        <select name="warna" id="warna" class="input-xlarge">
                        </select>
                        <button class="btn btn-small" id="addPro" type="button" ><i class="icon-plus" style="margin-top: 3px;"></i> Tambah List</button> 
                        <button class="btn btn-small" id="deletePro" type="button" ><i class="icon-minus" style="margin-top: 3px;"></i> Hapus List</button>
                    </div>
                </div>
            </div>

            <div class="well" style="overflow: auto;">               
                <table class="table table-bordered table-striped table-highlight">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Unit</th>								
                            <th>Warna</th>  
                            <!--<th>No Rangka Unit</th>
                            <th>No Mesin Unit</th> -->
                            <th>Tahun</th>      
                            <th>Qty Beli</th>   
                            <th>Qty Kirim</th>  
                            <th>Sisa Qty</th>   
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody id="addProduct">
                        <tr><td colspan="9" class="sys_align_center">Belum ada data yang dimasukkan</td></tr>
                    </tbody>
            <!--                    <tr id="jmlJuaUnit">
                        <td colspan="9" style="text-align: right;"><b>Total : </b></td>
                        <td><div class="input-prepend"><span class="add-on">Rp</span><input class="span2" type="text" name="subtotal" id="jmlUnit" style="text-align: right;" readonly></div></td>
                    </tr>-->
                </table>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary btn-small" id="save" name="save">Simpan</button>
                <button class="btn btn-small btn-tertiary" id="" type="button" onclick="window.location.href = 'index.php?r=pengirimanunit&page=view';" >Batal</button> 

            </div>
        </form>
        <?php
    } elseif ($page == 'edit') {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $query_edit = mysql_query("SELECT pe.*, dpe.kuantitas, rc.`name` as warna, du.no_rangka, du.no_mesin, 
                                                u.plafonbbn, du.tahun, u.name as unit, pu.id_pemesanan_unit
                                                FROM pembelian pe
                                                INNER JOIN detail_pembelian dpe ON dpe.id_pembelian = pe.id_pembelian
                                                INNER JOIN tb_unit u ON u.id = dpe.id_unit 
                                                INNER JOIN tb_detail_unit du ON du.id_detail_unit = dpe.id_detail_unit
                                                INNER JOIN ref_color rc ON rc.id_color = du.id_color
                                                INNER JOIN tb_pemesanan_unit pu ON pu.id_pemesanan_unit = dpe.id_pemesanan_unit
                                                INNER JOIN tb_detail_pemesanan_unit dpu ON dpu.id_detail_pemesanan_unit = pu.id_detail_pemesanan_unit
                                                where pe.id_pembelian='$id'");
            $row = mysql_fetch_array($query_edit);
            ?>
                                                                                                                                                                                                                    <!--<script src="module/pengirimanunit/main_edit.js"></script>-->
            <form action="module/pengirimanunit/edit.proses.php" method="POST" class="form-horizontal" id="creates">
                <div class="row">
                    <div class="span8">
                        <div class="control-group">
                            <label class="control-label">Nomor Pembelian *</label>
                            <div class="controls">:
                                <input type="text" class="span2" id="no_beli" name="no_beli" value="<?php echo $row['no_faktur']; ?>" readonly ></label>
                                <input type="hidden" class="span2" id="id_pembelian" name="id_pembelian" value="<?php echo $id; ?>" readonly >
                            </div>
                        </div>
                    </div>
                    <div class="span4">                    
                        <div class="control-group" >
                            <label class="control-label">Tanggal *</label>
                            <div class="controls">:
                                <input type="text" class="span2" id="tanggal" name="tanggal" value="<?php echo tgl_indo($row['tanggal']); ?>" readonly>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="control-group">
                        <label class="control-label">Supplier * </label>
                        <div class="controls">:
                            <select name="supplier" id="supplier"  class="input-large" disabled="">
                                <?php
                                $suplier = mysql_query("select * from ref_supplier order by name");
                                while ($a = mysql_fetch_array($suplier)) {
                                    if ($a['id_supplier'] == $row['id_supplier']) {
                                        $base64 = base64_encode(implode('||', array($a['id_supplier'], $a['name'])));
                                        echo"<option value='$base64' selected> $a[name]</option>";
                                    } else {
                                        $base64 = base64_encode(implode('||', array($a['id_supplier'], $a['name'])));
                                        echo"<option value='$base64'> $a[name]</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label span2">No. Faktur Pembelian * </label>
                        <div class="controls">:
                            <select name="unit" id="unit" class="input-large">
                                <option value="0">Pilih</option>
                                <?php
//                                $q = mysql_query("SELECT pu.id_pemesanan_unit, pu.no_faktur FROM tb_pemesanan_unit pu
//                                            left JOIN tb_detail_pemesanan_unit dpu on dpu.id_pemesanan_unit = pu.id_pemesanan_unit
//                                            left JOIN detail_pembelian dp on dp.id_pemesanan_unit = pu.id_pemesanan_unit
//                                            left JOIN pembelian p on p.id_pembelian = dp.id_pembelian
//                                            where p.id_pembelian='$row[id_pembelian]' and 
//                                            NOT(dpu.kuantitas = dpu.sisa_kuantitas)");
                                $q = mysql_query("select distinct a.id_pemesanan_unit, a.no_faktur, c.id_pembelian 
                                                from tb_pemesanan_unit a 
                                                inner join detail_pembelian b on b.id_pemesanan_unit=a.id_pemesanan_unit 
                                                inner join pembelian c on c.id_pembelian = b.id_pembelian
                                                where c.id_pembelian = '$row[id_pembelian]'");
                                while ($r = mysql_fetch_array($q)) {
                                    echo"<option value='$r[id_pemesanan_unit]'>$r[no_faktur]</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">No. Rangka * </label>
                        <div class="controls">:
                            <select name="warna" id="warna" class="input-xlarge">
                            </select>

                            <button class="btn btn-mini" id="addEdit" type="button" ><i class="icon-plus" style="margin-top: 3px;"></i></button> 
                            <button class="btn btn-mini" id="deleteEdit" type="button" ><i class="icon-minus" style="margin-top: 3px;"></i></button>
                        </div>
                    </div>
                </div>

                <div class="well" style="overflow: auto;">               
                    <table class="table table-bordered table-striped table-highlight">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Unit</th>								
                                <th>Warna</th>  
                                <!--<th>No Rangka Unit</th>
                                <th>No Mesin Unit</th> -->
                                <th>Tahun</th>      
                                <th>Qty Beli</th>   
                                <th>Qty Kirim</th>  
                                <th>Sisa Qty</th>     
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody id="addProductEdit">
                            <?php
                            $query_unit = mysql_query("SELECT pe.*, dpe.kuantitas, rc.`name` as warna, du.no_rangka, dpe.keterangan,
                                                        du.no_mesin, u.plafonbbn, du.tahun, rs.name as customer, rs.id_supplier,
                                                        u.name as unit, pu.id_pemesanan_unit, du.id_detail_unit, u.id as idunit,
                                                        dpe.id_detail_pembelian, dpu.kuantitas as kuantiti, (dpu.kuantitas - dpe.kuantitas) as qty
                                                        FROM pembelian pe
                                                        INNER JOIN detail_pembelian dpe ON dpe.id_pembelian = pe.id_pembelian
                                                        INNER JOIN tb_unit u ON u.id = dpe.id_unit 
                                                        INNER JOIN tb_detail_unit du ON du.id_detail_unit = dpe.id_detail_unit
                                                        INNER JOIN ref_color rc ON rc.id_color = du.id_color
                                                        INNER JOIN tb_pemesanan_unit pu ON pu.id_pemesanan_unit = dpe.id_pemesanan_unit
                                                        INNER JOIN tb_detail_pemesanan_unit dpu ON dpu.id_detail_pemesanan_unit = pu.id_detail_pemesanan_unit
                                                        INNER JOIN ref_supplier rs ON rs.id_supplier = dpe.id_supplier 
                                                        where pe.id_pembelian='$id'");
                            $jum2 = mysql_num_rows($query_unit);
                            if ($jum2 > 0) {
                                $no2 = 1;
                                while ($row2 = mysql_fetch_array($query_unit)) {
                                    ?>
                                    <tr>
                                        <td><input type="checkbox" id="editCheck_<?php echo $row2l['id_detail_unit']; ?>" value="<?php echo $row2['id_detail_unit']; ?>"/></td>
                                        <td><input name="unit[edit][<?php echo $no2; ?>][supplier]" type="hidden" class="span2" id="nama_supplier" value="<?php echo $row2['customer']; ?>" readonly/> 
                                            <input name="unit[edit][<?php echo $no2; ?>][idsupplier]" type="hidden" class="span2" id="id_supplier" value="<?php echo $row2['id_supplier']; ?>" readonly/>
                                            <input name="unit[edit][<?php echo $no2; ?>][idbeli]" type="hidden" class="span2" id="id_det_beli" value="<?php echo $row2['id_detail_pembelian']; ?>" readonly/>
                                            <input name="unit[edit][<?php echo $no2; ?>][unit]" type="text" class="span2" id="unit" value="<?php echo $row2['unit']; ?>" readonly/></td> 
                                        <td><input name="unit[edit][<?php echo $no2; ?>][nama_warna]" type="text" class="span1" id="nama_warna" value="<?php echo $row2['warna']; ?>" readonly/> 
                                            <input name="unit[edit][<?php echo $no2; ?>][iddetail]" type="hidden" value="<?php echo $row2['id_detail_unit']; ?>" id="akses2_<?php echo $no2; ?>"/>
                                            <input name="unit[edit][<?php echo $no2; ?>][idunit]" type="hidden" value="<?php echo $row2['idunit']; ?>" id="idUnit_<?php echo $no2; ?>"/> 
                                            <input name="unit[edit][<?php echo $no2; ?>][idPesan]" type="hidden" value="<?php echo $row2['id_pemesanan_unit']; ?>" id="idPesan_<?php echo $no2; ?>"/></td> 
                                        <!--<td><input name="unit[edit][<?php echo $no2; ?>][noRangka]" type="text" id="noRangka_<?php echo $no2; ?>_id" class="span2" value="<?php echo $row2['no_rangka']; ?>" readonly/></td> 
                                        <td><input name="unit[edit][<?php echo $no2; ?>][noMesin]" type="text" id="noMesin_<?php echo $no2; ?>_id" class="span2" value="<?php echo $row2['no_mesin']; ?>" readonly/></td> -->
                                        <td><input name="unit[edit][<?php echo $no2; ?>][tahun]" type="text" id="tahun_<?php echo $no2; ?>_id" class="span1" value="<?php echo $row2['tahun']; ?>" readonly/></td> 
                                        <td><input name="unit[edit][<?php echo $no2; ?>][qty_beli]" type="text" class="span1" id="qty_beli_<?php echo $row2['id_detail_unit']; ?>"style="text-align: right;" value="<?php echo $row2['kuantiti']; ?>" readonly=""/></td> 
                                        <td><input name="unit[edit][<?php echo $no2; ?>][kuantitas]" type="text" class="span1" id="kuantitas_<?php echo $row2['id_detail_unit']; ?>" style="text-align: right;" value="<?php echo $row2['kuantitas']; ?>" onkeyup="autoComplete('<?php echo $row2['id_detail_unit']; ?>');"/></td> 
                                        <td><input name="unit[edit][<?php echo $no2; ?>][sisa_qty]" type="text" class="span1" id="sisa_qty_<?php echo $row2['id_detail_unit']; ?>" style="text-align: right;" value="<?php echo $row2['qty']; ?>" readonly=""/></td> 
                                        <td><textarea name="unit[edit][<?php echo $no2; ?>][keterangan]" id="keterangan_<?php echo $no2; ?>_id" class="span2" row="4"><?php echo $row2['keterangan']; ?></textarea></td> 
                                    </tr>
                                    <?php
                                }
                            } else {
                                ?>
                                <tr><td colspan="9" class="sys_align_center">Belum ada data yang dimasukkan</td></tr>
                                <?php
                            }
                            ?>

                        </tbody>
                    </table>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary btn-small" id="save">Simpan</button>
                    <button class="btn btn-small btn-tertiary" id="" type="button" onclick="window.location.href = 'index.php?r=pengirimanunit&page=view';" >Batal</button> 

                </div>
            </form>
            <?php
        }
    } elseif ($page == 'detail') {
        echo json_encode(array('row' => '<tr class="toggle"><td colspan="8">tes
                        </td></tr>'));
    } elseif ($page == 'report') {
        ?>
        <script src="module/pengirimanunit/main.js"></script>
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
        <script type="text/javascript">
                        function cetak() {
                            var bulan = "<?= $_POST['bln_filter']; ?>";
                            var tahun = "<?= $_POST['thn_filter']; ?>";
                            win = window.open('module/pengirimanunit/print.php', 'win', 'width=1500, height=750, menubar=0, scrollbars=1, resizable=0, location=0, toolbar=0, status=0');
                        }
        </script>
        <!--<form name="form" target="_blank" method="POST" action="module/pengirimanunit/print.php?sub=laporan1">-->
        <?php
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
        }
        ?>
        <form name="form" method="POST" action="index.php?r=pengirimanunit&page=report">
            <fieldset>
                <legend><i class="icon icon-filter"></i> Filter Report</legend>
                <div class="well">
                    <?php
                    combonamabln(1, 12, 'bln_filter', $bln_sekarang);
                    combothn($thn_sekarang - 3, $thn_sekarang, 'thn_filter', $thn_sekarang);
                    ?>
                    <button class="btn btn-primary" name="search" type="submit"><i class="icon icon-search"></i> Search</button>
                </div>
            </fieldset>
        </form>
        <?php
        if (isset($_GET['id'])) {
            $id_beli = $_GET['id'];
        }

        $dateMonth = date('m');
        $dateYear = date('Y');
        $bulan = $_POST['bln_filter'];
        $tahun = $_POST['thn_filter'];

        $query = "SELECT pe.id_pembelian, pe.no_faktur, MONTH(pe.tanggal) as bulan, YEAR(pe.tanggal) as tahun, rs.name as customer, 
                            u.name as unit,rs.name as supplier, rs.addres, rs.phone, pg.nama as pegawai
                            FROM pembelian pe
                            INNER JOIN detail_pembelian dpe ON dpe.id_pembelian = pe.id_pembelian
                            INNER JOIN tb_unit u ON u.id = dpe.id_unit 
                            INNER JOIN tb_detail_unit du ON du.id_detail_unit = dpe.id_detail_unit
                            INNER JOIN ref_color rc ON rc.id_color = du.id_color
                            INNER JOIN tb_pemesanan_unit pu ON pu.id_pemesanan_unit = dpe.id_pemesanan_unit
                            INNER JOIN tb_detail_pemesanan_unit dpu ON dpu.id_detail_pemesanan_unit = pu.id_detail_pemesanan_unit
                            INNER JOIN ref_supplier rs ON rs.id_supplier = dpe.id_supplier 
                            inner join tb_pegawai pg on pg.id_pegawai = pu.id_pegawai";
        if (isset($_POST['search'])) {
            $query .= " WHERE MONTH(pe.tanggal) = '$bulan' and YEAR(pe.tanggal) = '$tahun'";
        } else {
            $query .= " WHERE MONTH(pe.tanggal) = '$dateMonth' and YEAR(pe.tanggal) = '$dateYear'";
        }
        
//        echo $query;
//        die();
        $q = mysql_query($query);
        $total = mysql_num_rows($q);
        if ($total > 0) {
                $q2 = "SELECT pe.id_pembelian, pe.tanggal, pe.no_faktur, MONTH(pe.tanggal) as bulan, YEAR(pe.tanggal) as tahun, rs.name as customer, 
                            u.name as unit,rs.name as supplier, rs.addres, rs.phone, pg.nama as pegawai
                            FROM pembelian pe
                            INNER JOIN detail_pembelian dpe ON dpe.id_pembelian = pe.id_pembelian
                            INNER JOIN tb_unit u ON u.id = dpe.id_unit 
                            INNER JOIN tb_detail_unit du ON du.id_detail_unit = dpe.id_detail_unit
                            INNER JOIN ref_color rc ON rc.id_color = du.id_color
                            INNER JOIN tb_pemesanan_unit pu ON pu.id_pemesanan_unit = dpe.id_pemesanan_unit
                            INNER JOIN tb_detail_pemesanan_unit dpu ON dpu.id_detail_pemesanan_unit = pu.id_detail_pemesanan_unit
                            INNER JOIN ref_supplier rs ON rs.id_supplier = dpe.id_supplier
                            inner join tb_pegawai pg on pg.id_pegawai = pu.id_pegawai ";

                if (isset($_POST['search'])) {
                    $q2 .= " WHERE MONTH(pe.tanggal) = '$bulan' and YEAR(pe.tanggal) = '$tahun'";
                } else {
                    $q2 .= " WHERE MONTH(pe.tanggal) = '$dateMonth' and YEAR(pe.tanggal) = '$dateYear'";
                }
                $query2 = mysql_query($q2);
                $row = mysql_fetch_array($query2);
                ?>
                <!--                <div class="row-fluid">
                                    <div class="span10"></div>
                                    <div class="span2">
                                        <form name="print" method="post" target="_blank" action="index.php?r=pengirimanunit&page=print?bulan=<?php echo $bulan; ?>&tahun=<?php echo $tahun; ?>'">
                                            <button class="btn btn-inverse" type="submit"><i class="icon icon-print"></i> Print</button> 
                                            <input type="submit" name="print" class="btn btn-inverse" value="Print">
                                        </form>
                                    </div>
                                </div>-->
                <div class="row-fluid">
                    <div class="span1"></div>
                    <div class="span10">
                        <center><h2> Pengiriman Unit</h2></center>
                        <hr/>
                    </div>
                    <div class="span1"></div>
                </div>

                <div class="content">
                    <table width="100%" class="table table-bordered table-highlight table-striped">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>No. Faktur</th>
                                <th>Unit</th>
                                <th>Warna</th>
                                <th>Tahun</th>
                                <th>Kuantitas</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $q3 = "SELECT pe.*, dpe.kuantitas, rc.`name` as warna, du.no_rangka, dpe.keterangan, 
                                                MONTH(pe.tanggal) as bulan, YEAR(pe.tanggal) as tahun,
                                                du.no_mesin, u.plafonbbn, du.tahun, rs.name as customer, rs.id_supplier,
                                                u.name as unit, pu.id_pemesanan_unit, du.id_detail_unit, u.id as idunit,
                                                dpe.id_detail_pembelian, rs.name as supplier, rs.addres, rs.phone
                                                FROM pembelian pe
                                                INNER JOIN detail_pembelian dpe ON dpe.id_pembelian = pe.id_pembelian
                                                INNER JOIN tb_unit u ON u.id = dpe.id_unit 
                                                INNER JOIN tb_detail_unit du ON du.id_detail_unit = dpe.id_detail_unit
                                                INNER JOIN ref_color rc ON rc.id_color = du.id_color
                                                INNER JOIN tb_pemesanan_unit pu ON pu.id_pemesanan_unit = dpe.id_pemesanan_unit
                                                INNER JOIN tb_detail_pemesanan_unit dpu ON dpu.id_detail_pemesanan_unit = pu.id_detail_pemesanan_unit
                                                INNER JOIN ref_supplier rs ON rs.id_supplier = dpe.id_supplier ";

                            if (isset($_POST['search'])) {
                                $q3 .= " WHERE MONTH(pe.tanggal) = '$bulan' and YEAR(pe.tanggal) = '$tahun'";
                            } else {
                                $q3 .= " WHERE MONTH(pe.tanggal) = '$dateMonth' and YEAR(pe.tanggal) = '$dateYear'";
                            }

                            $query3 = mysql_query($q3);
                            $no = 1;
                            while ($r = mysql_fetch_array($query3)) {
                                echo"<tr>
                                        <td style='text-align:center;'>$no</td>
                                        <td>" . $r['no_faktur'] . "</td>
                                        <td>" . $r['unit'] . "</td>
                                        <td>" . $r['warna'] . "</td>
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
                    <div class="span3"><strong><?php echo $row['pegawai']; ?></strong></div>
                </div>
                <?php
        } else {
            ?>
            <div class="alert alert-info">
                <center><h2>No Transaction!</h2></center>
            </div>
            <?php
        }
        ?>
        <div class="row">
            <div class="form-actions">
                <button class="btn btn-inverse" onclick="window.location.href = 'index.php?r=pengirimanunit&page=view';" >Batal</button> 
            </div>
        </div>
        <?php
    } elseif ($page == 'print') {
        $bulan = $_GET['bulan'];
        $tahun = $_GET['tahun'];
        echo $bulan;
        echo $tahun;
        die();
        $query2 = mysql_query("SELECT pe.id_pembelian, pe.tanggal, pe.no_faktur, MONTH(pe.tanggal) as bulan, YEAR(pe.tanggal) as tahun, 
                            rs.name as customer, u.name as unit,rs.name as supplier, rs.addres, rs.phone, pg.name as pegawai
                            FROM pembelian pe
                            INNER JOIN detail_pembelian dpe ON dpe.id_pembelian = pe.id_pembelian
                            INNER JOIN tb_unit u ON u.id = dpe.id_unit 
                            INNER JOIN tb_detail_unit du ON du.id_detail_unit = dpe.id_detail_unit
                            INNER JOIN ref_color rc ON rc.id_color = du.id_color
                            INNER JOIN tb_pemesanan_unit pu ON pu.id_pemesanan_unit = dpe.id_pemesanan_unit
                            INNER JOIN tb_detail_pemesanan_unit dpu ON dpu.id_detail_pemesanan_unit = pu.id_detail_pemesanan_unit
                            INNER JOIN ref_supplier rs ON rs.id_supplier = dpe.id_supplier
                            INNER JOIN tb_pegawai pg on pg.id_pegawai = pu.id_pegawai 
                            WHERE MONTH(pe.tanggal) = '$bulan' and YEAR(pe.tanggal) = '$tahun'");
        $row = mysql_fetch_array($query2);
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

        <div class="content">
            <table width="100%" class="table table-bordered table-highlight table-striped">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Unit</th>
                        <th>Warna</th>
                        <th>Tahun</th>
                        <th>Kuantiti</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query2 = mysql_query("SELECT pe.*, dpe.kuantitas, rc.`name` as warna, du.no_rangka, dpe.keterangan, 
                                                MONTH(pe.tanggal) as bulan, YEAR(pe.tanggal) as tahun,
                                                du.no_mesin, u.plafonbbn, du.tahun, rs.name as customer, rs.id_supplier,
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
            <div class="span3"><strong><?php echo $b['pegawai']; ?></strong></div>
        </div>
        <?php
//        }
    }
}    