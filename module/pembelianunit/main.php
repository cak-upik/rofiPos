<script src="module/pembelianunit/main.js"></script>
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
        <p><button onClick="document.location = 'index.php?r=pembelianunit&page=create';" class="btn btn-warning"><i class="icon-plus-sign icon-white"></i> Tambah</button></p>

        <table id="beliunit" class="table table-bordered table-striped table-highlight">
            <thead>
                <tr>
                    <th width="5%">#</th>
                    <th>Nomor Faktur</th>
                    <th>Suplier</th>
                    <th>Tanggal Masuk</th>
                    <th width="35%">Action</th>
                </tr>
            </thead>
            <tbody> 
                <?php

                $query = mysql_query("select a.* , b.name, c.kuantitas -- , d.sisa_order 
                                        from tb_pemesanan_unit a 
                                        inner join ref_supplier b on a.id_supplier=b.id_supplier 
                                        inner join tb_detail_pemesanan_unit c on c.id_pemesanan_unit = a.id_pemesanan_unit
                                        group by a.id_pemesanan_unit
                                        order by a.id_pemesanan_unit
                                        desc");

//                $query = mysql_query("select a.* , b.name, c.kuantitas, d.sisa_order, e.id_pembelian
//                                    from tb_pemesanan_unit a 
//                                    inner join ref_supplier b on a.id_supplier=b.id_supplier 
//                                    inner join tb_detail_pemesanan_unit c on c.id_pemesanan_unit = a.id_pemesanan_unit
//                                    inner join sisa_po d on d.id_pemesanan_unit = a.id_pemesanan_unit
//                                    left join pembelian e on e.id_pembelian = d.id_pembelian
//                                    left join detail_pembelian f on f.id_pembelian = e.id_pembelian
//                                    group by a.id_pemesanan_unit
//                                    order by a.id_pemesanan_unit");

                $number = 1;
                while ($result = mysql_fetch_array($query)) {
                    $tgl = tgl_indo($result['tanggal']);
                    $date = tgl_indo($result['date']);

                    echo"<tr>
                                <td>$number</td>
                                <td>$result[no_faktur]</td>
                                <td>$result[name]</td>
                                <td>$tgl</td>";
                    echo "<td>
                                    <a href='#myModal" . $number . "' title='Show Detail' data-toggle='modal' id='id_pesan_unit' value='$result[id_pemesanan_unit]' class='btn'><i class='icon-eye-open'></i> Detail</a>
                                    <a href='index.php?r=pembelianunit&page=edit&id=$result[id_pemesanan_unit]' title='Edit' class='btn btn-inverse'><i class='icon-edit'></i> Edit</a>
                                    <a href='module/pembelianunit/delete.php?id=$result[id_pemesanan_unit]' title='Delete' onclick=\"return confirm('Are you sure?')\" class='btn btn-danger'><i class='icon-remove'></i> Delete</a>
                                    <a href='module/pembelianunit/main.php?r=pembelianunit&page=print&id=$result[id_pemesanan_unit]' title='Print' target='_blank' class='btn btn-info'><i class='icon-print'></i> Print</a>
                                </td>
                             </tr>";

                    $number++;
                }
                ?>
            </tbody>
        </table>
        <!--<script src="js/jquery-1.7.2.min.js"></script>--> 
        <script src="js/jquery.dataTables.js"></script>
        <script>
            $(document).ready(function() {
                $('#beliunit').dataTable({
                    "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]]
                });
            });
        </script>
        <?php
        $no = 1;
        $query2 = mysql_query("select a.* , b.name, c.kuantitas 
                                        from tb_pemesanan_unit a 
                                        inner join ref_supplier b on a.id_supplier=b.id_supplier 
                                        inner join tb_detail_pemesanan_unit c on c.id_pemesanan_unit = a.id_pemesanan_unit
                                        group by a.id_pemesanan_unit
                                        order by a.id_pemesanan_unit desc");
        while ($result2 = mysql_fetch_array($query2)) {
            ?>
            <script type="text/javascript">
                $('#myModal<?php echo $no; ?>').on('show', function(event) {
                    var id_unit = document.getElementById('id').value;
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
                    <h4 id="myModalLabel">Detail Pembelian Unit</h4>
                </div>
                <div class="modal-body">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr style="background-color:#ddd; color: black;">
                                <th width="5%">#</th>
                                <th>Nama</th>
                                <th>Qty</th>
                                <th>Qty Yg Terbeli</th>
                                <th>Harga</th>
                                <th width="25px">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $getDetail = mysql_query("SELECT a.* , b.kuantitas as qty, b.harga  , c.name , b.sisa_kuantitas, b.keterangan
                                                FROM tb_pemesanan_unit a
                                                INNER JOIN tb_detail_pemesanan_unit b on b.id_pemesanan_unit = a.id_pemesanan_unit
                                                INNER JOIN tb_unit c on c.id = b.id_unit
                                                WHERE a.id_pemesanan_unit = '" . $result2[id_pemesanan_unit] . "'");
                            $nomor = 1;
                            while ($row1 = mysql_fetch_array($getDetail)) {
                                echo"<tr>
                                        <td>$nomor</td>
                                        <td>$row1[name]</td>
                                        <td>$row1[qty]</td>
                                        <td>$row1[sisa_kuantitas]</td>
                                        <td style='text-align: right;'>" . rupiah($row1[harga]) . "</td>
                                        <td width='25px'>$row1[keterangan]</td>
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
//        $jmldata = mysql_num_rows(mysql_query("select a.* , b.name, c.kuantitas -- , d.sisa_order 
//                                        from tb_pemesanan_unit a 
//                                        inner join ref_supplier b on a.id_supplier=b.id_supplier 
//                                        inner join tb_detail_pemesanan_unit c on c.id_pemesanan_unit = a.id_pemesanan_unit
//                                        -- inner join sisa_po d on d.id_pemesanan_unit = a.id_pemesanan_unit
//                                        group by a.id_pemesanan_unit
//                                        order by a.id_pemesanan_unit "));
//        $jmlhalaman = $p->jumlahHalaman($jmldata, $batas);
//        $linkHalaman = $p->navHalaman($_GET['halaman'], $jmlhalaman);
//        echo "<div class='pagination pagination-centered' id=paging>$linkHalaman</div><br>";
    } elseif ($page == 'create') {
        ?>
        <h2>Tambah Data</h2>
        <form action="module/pembelianunit/input.proses.php" method="POST" name="create" class="form-horizontal" id="create">
            <?php
            $kode = poNumber();
            ?>
            <div class="control-group">
                <br/>
                <label class="control-label">Nomor Faktur *</label>
                <div class="controls">
                    <input type="text" class="span2" id="no_faktur" name="no_faktur" value="<?php echo $kode; ?>" readonly="">
                    <input type="hidden" class="span4" id="id_pegawai" name="id_pegawai" value="<?php echo $id_pegawai; ?>">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Supplier *</label>
                <div class="controls">
                    <select name="id_suplier" id="id_suplier"  class="input-large">
                        <?php
                        $suplier = mysql_query("select * from ref_supplier order by name");
                        while ($a = mysql_fetch_array($suplier)) {
                            echo"<option value='$a[id_supplier]'>$a[name]</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <!--            <div class="control-group">
                            <label class="control-label">Unit *</label>
                            <div class="controls">
                                <select name="unit" id="unit" class="input-large">
            <?php
            $query = mysql_query("select * from tb_unit order by name");
            while ($row = mysql_fetch_array($query)) {
                echo"<option value='$row[id]]'>$row[name]</option>";
            }
            ?>
                                </select>
                            </div>
                        </div>-->
            <div class="control-group" >
                <label class="control-label">Unit *</label>
                <div class="controls">
                    <select name="productId" id="productId"  class="input-large">
                        <?php
                        $query = mysql_query("select * from tb_unit");
                        while ($row = mysql_fetch_array($query)) {
                            $base64 = base64_encode(implode('||', array($row['id'], $row['name'])));
                            echo"<option value='$base64'>$row[name]</option>";
                        }
                        ?>
                    </select>

                    <button class="btn btn-small" id="add" type="button" >Tambah List</button> 
                    <button class="btn btn-small" id="delete" type="button" >Hapus List</button>
                </div>
            </div>
            <div class="well" style="max-height: 250px; overflow: auto;">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <!--<th>Id</th>-->
                            <th>Nama Unit</th>
                            <th>Kuantitas</th>
                            <th>Harga Satuan (Suplier)</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody id="addProduct">
                        <tr><td colspan="6" align='center'>Tidak  ada data yang dimasukkan.</td></tr>
                    </tbody>
                </table>
            </div>
            <div class="form-actions">
                <button type="submit" name="save" class="btn btn-primary btn-small" >Simpan</button>
                <button class="btn btn-small btn-tertiary" id="" type="button" onclick="window.location.href = 'index.php?r=pembelianunit&page=view';" >Batal</button> 

            </div>
        </form>
        <?php
    } elseif ($page == 'edit') {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $query_edit = mysql_query("SELECT a.* FROM tb_pemesanan_unit a
                        INNER JOIN ref_supplier b ON b.id_supplier = a.id_supplier
                        WHERE a.id_pemesanan_unit ='$id'");
            $a = mysql_fetch_array($query_edit);
            ?>
            <h2>Edit Data</h2>

            <form action="module/pembelianunit/edit.proses.php" method="POST" class="form-horizontal" id="edit" name="edit">
                <div class="control-group">
                    <br/>
                    <label class="control-label">Nomor Faktur *</label>
                    <div class="controls">
                        <input type="text" class="span2" id="no_faktur" name="no_faktur" value="<?php echo $a['no_faktur']; ?>" readonly>
                        <input type="hidden" class="span4" id="id_pemesanan_unit" name="id_pemesanan_unit" value="<?php echo $a['id_pemesanan_unit']; ?>">
                        <input type="hidden" class="span4" id="id_pegawai" name="id_pegawai" value="<?php echo $id_pegawai; ?>">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Supplier *</label>
                    <div class="controls">
                        <select name="id_suplier" id="id_suplier"  class="input-large">
                            <?php
                            $suplier = mysql_query("select * from ref_supplier order by name");
                            while ($b = mysql_fetch_array($suplier)) {
                                if ($a['id_supplier'] == $b['id_supplier']) {
                                    echo"<option value='$b[id_supplier]' selected>$b[name]</option>";
                                } else {
                                    echo"<option value='$b[id_supplier]'>$b[name]</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="control-group" >
                    <label class="control-label"> 
                        Unit *
                    </label>
                    <div class="controls">
                        <select name="productId" id="productId"  class="input-large">
                            <?php
                            $query = mysql_query("select * from tb_unit order by name");
                            while ($row = mysql_fetch_array($query)) {
                                $base64 = base64_encode(implode('||', array($row['id'], $row['name'])));
                                echo"<option value='$base64'>$row[name]</option>";
                            }
                            ?>
                        </select>

                        <button class="btn btn-small" id="addEdit" type="button" >Tambah List</button> 
                        <button class="btn btn-small" id="deleteEdit" type="button" >Hapus List</button>
                    </div>
                </div>
                <div class="well" style="max-height: 250px; overflow: auto;">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                            <!--<th>Id</th>-->
                                <th>Nama Unit</th>
                                <th>Kuantitas</th>
                                <th>Harga Satuan (Suplier)</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody id="addProductEdit">
                            <?php
                            $edit2 = mysql_query("SELECT a.*  , b.kuantitas, b.harga , c.id, c.name, b.keterangan
                                                FROM tb_pemesanan_unit  a
                                                INNER JOIN tb_detail_pemesanan_unit b on b.id_pemesanan_unit = a.id_pemesanan_unit
                                                INNER JOIN tb_unit c on c.id = b.id_unit 
                                                            WHERE a.id_pemesanan_unit ='$id'");
                            $jumlah_detil = mysql_num_rows($edit2);

                            if ($jumlah_detil > 0) {
                                $no = 1;
                                while ($result_detil = mysql_fetch_array($edit2)) {
                                    echo"<tr>
                                            <td><input type='checkbox' id='editCheck_$result_detil[id]' value='$result_detil[id]'/></td>
                                                    <td><label>$result_detil[name]</label>
                                            <input name='unit[edit][$no][name]' type='hidden' value='$result_detil[name]' />
                                            <input name='unit[edit][$no][idunit]' type='hidden' value='$result_detil[id]' id='akses2_$result_detil[id]' /></td>
                                            <td><input name=\"unit[edit][$no][quantity]\" id='quantity_$result_detil[id]' type='text' class='span2' value='$result_detil[kuantitas]' /></td>
                                            <td><div class=\"input-prepend\"><span class=\"add-on\">Rp</span><input name=\"unit[edit][$no][price]\" id='price_$result_detil[id]' type=\"text\" class=\"span2\" value='$result_detil[harga]'  style=\"text-align:right;\"/></div></td>
                                            <td><textarea name=\"unit[edit][$no][remark]\" id='remark_$result_detil[id]' class=\"span2\" row=\"4\">$result_detil[keterangan]</textarea></td> 
                                         </tr>";
                                    $no++;
                                }
                            } else {
                                echo"<tr><td colspan='5'>Data kosong</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary btn-small" >Simpan</button>
                    <button class="btn btn-small btn-tertiary" id="" type="button" onclick="window.location.href = 'index.php?r=pembelianunit&page=view';" >Batal</button> 

                </div>
            </form>
            <?php
        }
    } elseif ($page == 'detail') {
        echo json_encode(array('row' => '<tr class="toggle"><td colspan="8">tes
                        </td></tr>'));
    } elseif ($page == 'print') {
        ?>
        <title>Purchase Order</title>
        <style>
            .header{
                margin: 0 auto; width: 800px; text-align: center;
            }
            .content{
                width:800px; margin: 0 auto;
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
        $query = mysql_query("SELECT a.* , SUM(b.kuantitas * b.harga) as subtotal , c.*, d.name as name_supplier, d.addres as supplier_address, 
                            d.phone as supplier_phone, pg.nama
                            FROM tb_pemesanan_unit  a
                            INNER JOIN ref_supplier d on d.id_supplier = a.id_supplier
                            INNER JOIN tb_detail_pemesanan_unit b on b.id_pemesanan_unit = a.id_pemesanan_unit
                            INNER JOIN tb_unit c on c.id = b.id_unit
                            INNER JOIN tb_pegawai pg on pg.id_pegawai = a.id_pegawai
                            where a.id_pemesanan_unit='$_GET[id]'");

        $b = mysql_fetch_array($query);
        $tgl = tgl_indo($b['tanggal']);
        ?>
        <div class="content">
            <center><h2> PURCHASE ORDER</h2></center>

            <div class="info1">
                <table style="width: auto;" cellpadding="5">
                    <tr>
                        <td style="width: 85;"><b>PO Number</b></td>
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
                        <thead><tr><th>Supplier :</th></tr></thead>
                        <tbody><tr>
                                <td style="border:2px solid black;"><?php echo $b['name_supplier']; ?><br />
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
            <table width="100%" class="table" border="2" cellpadding="5" cellspacing="0">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Unit</th>
                        <th>Kuantitas</th>
                        <th>Harga</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query2 = mysql_query("SELECT a.* , (b.kuantitas * b.harga) as total, b.kuantitas, b.harga , c.name, c.name
                                                FROM tb_pemesanan_unit  a
                                                INNER JOIN tb_detail_pemesanan_unit b on b.id_pemesanan_unit = a.id_pemesanan_unit
                                                INNER JOIN tb_unit c on c.id = b.id_unit
                                                WHERE a.id_pemesanan_unit = '$_GET[id]'");
                    $rows = mysql_query($query2);
                    $no = 1;
                    while ($r = mysql_fetch_array($query2)) {
                        echo"<tr>
                                <td style='text-align:center;'>$no.</td>
                                <td>" . $r['name'] . "</td>
                                <td style='white-space:nowrap; text-align:right;'>" . $r['kuantitas'] . "</td>
                                <td style='white-space:nowrap; text-align:right;'>" . rupiah($r['harga']) . "</td>
                                <td style='white-space:nowrap; text-align:right;'>" . rupiah($r['total']) . "</td>
                             </tr>";
                        $no++;
                    }
                    ?>
                    <tr>
                        <td colspan="3" style="border:2px solid black; border-left:hidden;border-bottom:hidden;"></td>
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
                    <td align="right"><strong><?php echo $b['nama']; ?></strong></td>
                </tr>
            </table>
        </div>
        <?php
    } else {
        
    }
}