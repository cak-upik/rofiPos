<script src="module/penjualan/main.js"></script>
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
        <p><button onClick="document.location = 'index.php?r=penjualan&page=create';" class="btn btn-warning"><i class="icon-plus-sign icon-white"></i> Tambah</button></p>

        <table class="table table-bordered table-striped table-highlight">
            <thead>
                <tr>
                    <th width="5%">#</th>
                    <th>No Penjualan</th>
                    <th>Nama</th>
                    <th>Tipe Unit</th>
                    <th>Leasing</th>
                    <th>Tanggal</th>
                    <th>Harga</th>
                    <th>Uang Muka</th>
                    <th>Diskon</th>
                    <th>Kuantitas</th>
                    <th>Total Nett</th>
                    <th colspan="3" width="5%">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $p = new Paging;
                $batas = 15;
                $posisi = $p->cariPosisi($batas);

                $query = mysql_query("SELECT tp.id as id,
                                    tp.no_jual as NoPenjualan,
                                    rc.`name` as NamaCustomer,
                                    tu.`name` as Nama_Unit,
                                    ls.`name` as Leasing,
                                    tp.date as Tanggal,
                                    tu.hargaotr as HargaJual,
                                    tp.kuantiti as Qty,
                                    tp.uangmuka as Uang_Muka,
                                    tp.disc as Diskon,
                                    tp.nett as Total_Nett
                                    FROM tb_penjualan tp
                                    INNER JOIN tb_unit tu
                                    ON tp.id = tu.id
                                    INNER JOIN ref_leasing ls
                                    ON ls.id = tp.ref_leasing_id
                                    INNER JOIN ref_customer rc
                                    on tp.id_customer = rc.id_customer	
                                        order by id LIMIT $posisi,$batas");
                $total = mysql_num_rows($query);

                if ($total > 0) {
                    $no = $posisi + 1;
                    while ($result = mysql_fetch_array($query)) {
                        echo"<tr>
                                                    <td>$no</td>
                                                    <td>$result[NoPenjualan]</td>
                                                    <td>$result[NamaCustomer]</td>
                                                    <td>$result[Nama_Unit]</td>
                                                    <td>$result[Leasing]</td>
                                                    <td>" . tgl_indo($result['Tanggal']) . "</td>
                                                    <td style='text-align:right;'>" . rupiah($result['HargaJual']) . "</td>
                                                    <td style='text-align:right;'>" . rupiah($result['Uang_Muka']) . "</td>
                                                    <td style='text-align:right;'>" . rupiah($result['Diskon']) . "</td>
                                                    <td>$result[Qty]</td>
                                                    <td style='text-align:right;'>" . rupiah($result['Total_Nett']) . "</td>";
//                                                    <td>
//                                                        <a href='index.php?r=penjualan&page=create&id=$result[id]' title='Isi/Tambah penjualan'><i class='icon-plus'></i></a>
//                                                    </td>
                        echo "<td>
                                                        <a href='index.php?r=penjualan&page=edit&id=$result[id]' title='Edit'><i class='icon-edit'></i></a>
                                                    </td>
                                                    <td>
                                                        <a href='module/penjualan/delete.php?id=$result[id]' title='Delete' onClick=\"return confirm ('Are you sure?')\"><i class='icon-remove'></i></a>
                                                    </td>
                                                 </tr>";
                        $no++;
                    }
                } else {
                    echo"<tr><td colspan='7'><label>Data Tidak Ditemukan</label></td></tr>";
                }
                ?>
            </tbody>
        </table>
        <?php
        $jmldata = mysql_num_rows(mysql_query("select * from tb_penjualan"));
        $jmlhalaman = $p->jumlahHalaman($jmldata, $batas);
        $linkHalaman = $p->navHalaman($_GET['halaman'], $jmlhalaman);
        echo "<div class='pagination pagination-centered' id=paging>$linkHalaman</div><br>";
    } elseif ($page == 'create') {
        ?>
        <form action="module/penjualan/input.proses.php" method="POST" class="form-horizontal" id="create">
            <?php
            $kode = notaNumber();
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
                            <select name="id_suplier" id="id_suplier"  class="input-large">
                                <option value="0">-- Pilih --</option>
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
                            <select name="ref_leasing_id" id="ref_leasing_id" class="input-large">
                                <option value="0">-- Pilih --</option>
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
                    <div class="control-group" >
                        <label class="control-label"> Unit *</label>
                        <div class="controls">
                            <select name="unit" id="unit"  class="input-large">
                                <option value="0">-- Pilih --</option>
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
                        <label class="control-label">No Mesin *</label>
                        <div class="controls">
                            <select name="mesin" id="mesin" class="input-xlarge">
                                <option value="0">-- Pilih --</option>
                            </select>

                            <button class="btn btn-small" id="addPro" type="button" >Tambah List</button> 
                            <button class="btn btn-small" id="delete" type="button" >Hapus List</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="well" style="max-height: 250px; overflow: auto;">
                <table class="table table-striped table-bordered">
                    <!--<thead>-->
                    <tr>
                        <th>#</th>
                        <th>Nama Unit</th>
                        <th>Warna</th>
                        <th>No. Mesin</th>
                        <th>No. Rangka</th>
                        <th>Harga Jual Unit</th>
                        <th>Uang Muka</th>
                        <th>Diskon</th>
                        <th>Jumlah Pembelian</th>
                    </tr>
                    <!--</thead>-->

                    <tbody id="addProduct">
                        <tr><td colspan="9" align='center'>Tidak  ada data yang dimasukkan.</td></tr>
                    </tbody>
                    <tr id="jmljualunit">
                        <td colspan="8" style="text-align: right;"><b>Total : </b></td>
                        <td><div class="input-prepend"><span class="add-on">Rp</span><input class="span2" type="text" name="jmlSparepart" id="jmlSparepart" readonly></div></td>
                    </tr>
                </table>
            </div>
            <div class="form-actions">
                <button type="submit" name="save" class="btn btn-primary btn-small" >Simpan</button>
                <button class="btn btn-small btn-tertiary" id="" type="button" onclick="window.location.href = 'index.php?r=penjualan&page=view';" >Batal</button> 

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

            <form action="module/penjualan/edit.proses.php" method="POST" class="form-horizontal" id="edit" name="edit">
                <div class="control-group">
                    <br/>
                    <label class="control-label">Nomor Faktur *</label>
                    <div class="controls">
                        <input type="text" class="span4" id="no_faktur" name="no_faktur" value="<?php echo $a['no_faktur']; ?>" readonly>
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
                        Unit
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
                            $edit2 = mysql_query("SELECT a.* , b.kuantitas, b.harga , c.id, c.name, c.hargakosongan, c.plafonbbn, c.hargaotr, c.hargabeli
                                                FROM tb_pemesanan_unit  a
                                                INNER JOIN tb_detail_pemesanan_unit b on b.id_pemesanan_stok = a.id_pemesanan_unit
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
                                            <input name='unit[edit][$no][id]' type='hidden' value='$result_detil[id]' id='akses2_$result_detil[id]' /></td>
                                            <td><input name=\"unit[edit][$no][quantity]\" id='quantity_$result_detil[id]' type='text' class='span2' value='$result_detil[kuantitas]' /></td>
                                            <td><input name=\"unit[edit][$no][price]\" id='price_$result_detil[id]' type=\"text\" class=\"span2\" value='$result_detil[harga]'/></td>
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
                    <button class="btn btn-small btn-tertiary" id="" type="button" onclick="window.location.href = 'index.php?r=penjualan&page=view';" >Batal</button> 

                </div>
            </form>
            <?php
        }
    } elseif ($page == 'detail') {
        echo json_encode(array('row' => '<tr class="toggle"><td colspan="8">tes
                        </td></tr>'));
    } elseif ($page == 'print') {
        ?>
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
        $query = mysql_query("SELECT a.* , SUM(b.kuantitas * b.harga) as subtotal , c.*, d.name as name_supplier, d.addres as supplier_address, d.phone as supplier_phone
                            FROM tb_pemesanan_unit  a
                            INNER JOIN ref_supplier d on d.id_supplier = a.id_supplier
                            INNER JOIN tb_detail_pemesanan_unit b on b.id_pemesanan_stok = a.id_pemesanan_unit
                            INNER JOIN tb_unit c on c.id = b.id_unit
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
                        <thead><tr><th>Penerbit :</th></tr></thead>
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
                                    CV. FENROSS BOOK <br />

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
                    $query2 = mysql_query("SELECT a.* , (b.kuantitas * b.harga) as total, b.kuantitas, b.harga , c.name, hargakosongan, c.name
                                                FROM tb_pemesanan_unit  a
                                                INNER JOIN tb_detail_pemesanan_unit b on b.id_pemesanan_stok = a.id_pemesanan_unit
                                                INNER JOIN tb_unit c on c.id = b.id_unit
                                                WHERE a.id_pemesanan_unit = '$_GET[id]'");
                    $rows = mysql_query($query2);
                    $no = 1;
                    while ($r = mysql_fetch_array($query2)) {
                        echo"<tr>
                                <td style='text-align:center;'>$no</td>
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

                    <td align="right">(Staff Gudang)</td>
                </tr>
            </table>
        </div>
        <?php
    } else {
        
    }
}