
<script src="module/pemesanan_stok/main.js"></script>
<?php
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

        <!--        <div class="well-small">
                    <div class="btn-group">
                        <a class="btn dropdown-toggle btn-tertiary" data-toggle="dropdown" href="#">
                            Action <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a tabindex="-1" href="index.php?r=pembelianunit&page=create">Tambah</a></li>
                        </ul>
                    </div>
                </div>
                <br/>-->
        <p><button onClick="document.location = 'index.php?r=pembelianunit&page=create';" class="btn btn-warning"><i class="icon-plus-sign icon-white"></i> Tambah</button></p>

        <table class="table table-bordered table-striped table-highlight">
            <thead>
                <tr>
                    <th width="5%">#</th>
                    <th>Nomor Faktur</th>
                    <th>Suplier</th>
                    <th>Tanggal</th>
                    <th colspan="4" width="5%">Action</th>
                </tr>
            </thead>
            <tbody> 
                <?php
                $p = new Paging;
                $batas = 15;
                $pembelianunitsisi = $p->cariPosisi($batas);

                $query = mysql_query("select * from tb_pemesanan_unit a 
                                        inner join ref_supplier b on a.id_supplier=b.id_supplier order by tanggal desc LIMIT $pembelianunitsisi,$batas");
                $total = mysql_num_rows($query);

                if ($total > 0) {
                    $no = $pembelianunitsisi + 1;
                    while ($result = mysql_fetch_array($query)) {
                        $tgl = tgl_indo($result['tanggal']);
                        echo"<tr>
                                <td>$no</td>
                                <td>$result[no_faktur]</td>
                                <td>$result[name]</td>
                                <td>$tgl</td>
                                           <td><a href='index.php?r=pembelianunit&page=detail&id=$result[id_pemesanan_unit]' title='Show Detail' class='trigger'><i class='icon-eye-open'></i></a></td>
                        <td>
                                    <a href='index.php?r=pembelianunit&page=edit&id=$result[id_pemesanan_unit]' title='Edit'><i class='icon-edit'></i></a>
                                </td>
                                <td>
                                    <a href='module/pembelianunit/delete.php?id=$result[id_pemesanan_unit]' title='Delete' onClick=\"return confirm ('Are you sure?')\"><i class='icon-remove'></i></a>
                                </td>  
                                <td>
                                    <a href='module/pembelianunit/main.php?r=pembelianunit&page=print&id=$result[id_pemesanan_unit]' title='Print' target='_blank'><i class='icon-print'></i></a>
                                </td>
                             </tr>";


                        echo"<tr class=\"details\" style='display:none;'>
                                                    <td colspan=\"8\">";
                        $getDetail = mysql_query("select * from tb_detail_pemesanan_stok a 
                                                                    inner join tb_unit b on a.id=b.id 
                                                                    where a.id_pemesanan_unit='$result[id_pemesanan_unit]'");
                        ?>
                    <table >
                        <thead>
                            <tr style="background-color:#ddd; color: black;">
                                <th width="5%">#</th>
                                <th>Kode Sparepart</th>
                                <th>Sparepart</th>
                                <th>Kuantitas</th>
                                <th>Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            while ($row1 = mysql_fetch_array($getDetail)) {
                                echo"<tr>
                                        <td>$no</td>
                                        <td>$row1[kode_sparepart]</td>
                                        <td>$row1[name]</td>
                                        <td>$row1[kuantitas]</td>
                                        <td>$row1[harga]</td>
                                     </tr>";
                                $no++;
                            }
                            ?>
                        </tbody> 
                    </table>
                    <?php
                    echo"</td>"
                    . "</tr>";
                    $no++;
                }
            } else {
                echo"<tr><td colspan='6'><label>Data Tidak Ditemukan</label></td></tr>";
            }
            ?>
        </tbody>
        </table>
        <?php
        $jmldata = mysql_num_rows(mysql_query("select * from tb_pemesanan_unit a 
                                        inner join ref_supplier b on a.id_supplier=b.id_supplier"));
        $jmlhalaman = $p->jumlahHalaman($jmldata, $batas);
        $linkHalaman = $p->navHalaman($_GET['halaman'], $jmlhalaman);
        echo "<div class='pagination pagination-centered' id=paging>$linkHalaman</div><br>";
    } elseif ($page == 'create') {
        ?>
        <h2>Tambah Data</h2>
        <form action="module/pembelianunit/input.proses.php" method="POST" class="form-horizontal" id="create">
            <?php
            $kode = poNumber();
            ?>
            <div class="control-group">
                <br/>
                <label class="control-label">Nomor Faktur *</label>
                <div class="controls">
                    <input type="text" class="span4" id="no_faktur" name="no_faktur" value="<?php echo $kode; ?>">
                    <input type="hidden" class="span4" id="id_pegawai" name="id_pegawai" value="<?php echo $id_pegawai; ?>">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Supplier *</label>
                <div class="controls">
                    <select name="id_supplier" id="id_supplier"  class="input-large">
                        <?php
                        $suplier = mysql_query("select * from ref_supplier order by name");
                        while ($a = mysql_fetch_array($suplier)) {
                            echo"<option value='$a[id_supplier]'>$a[name]</option>";
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
                    <select name="unitId" id="unitId" class="input-large">
                        <?php
                        $query = mysql_query("select * from tb_unit order by name");
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
                            <th>&nbsp;</th>
                            <th>Id</th>
                            <th>Nama Unit</th>
                            <th>Kuantitas</th>
                            <th>Harga Satuan (Suplier)</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody id="addProduct">
                        <tr><td colspan="6" align='center'>Tidak  ada data yang dimasukkan.</td></tr>
                    </tbody>
                </table>pemesananunit
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary btn-small" >Simpan</button>
                <button class="btn btn-small btn-tertiary" id="" type="button" onclick="window.location.href = 'index.php?r=unit&page=view';" >Batal</button> 

            </div>
        </form>
        <?php
    } elseif ($page == 'edit') {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $query_edit = mysql_query("select * from tb_pemesanan_unit where id_pemesanan_unit='$id'");
            $a = mysql_fetch_array($query_edit);
            ?>
            <h2>Edit Data</h2>

            <form action="module/pemesanan_stok/edit.proses.php" method="POST" class="form-horizontal" id="create">
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
                    <label class="control-label">Suplier *</label>
                    <div class="controls">
                        <select name="id_supplier" id="id_supplier" class="input-large">
                            <?php
                            $suplier = mysql_query("select * from ref_supplier order by nama");
                            while ($b = mysql_fetch_array($suplier)) {
                                if ($a['id_supplier'] == $b['id_supplier']) {
                                    echo"<option value='$b[id_supplier]' selected>$b[nama]</option>";
                                } else
                                    echo"<option value='$b[id_supplier]'>$b[nama]</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="control-group" >
                    <label class="control-label"> 
                        Sparepart
                    </label>
                    <div class="controls">
                        <select name="unitId" id="unitId" class="input-large">
                            <?php
                            $query = mysql_query("select * from tb_unit order by name");
                            while ($row = mysql_fetch_array($query)) {
                                $base64 = base64_encode(implode('||', array($row['id'], $row['name'], $row['kode_sparepart'])));
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
                                <th>&nbsp;</th>
                                <th>Kode Sparepart</th>
                                <th>Nama Sparepart</th>
                                <th>Kuantitas</th>
                                <th>Harga</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody id="addProductEdit">
                            <?php
                            $edit2 = mysql_query("select t1.*, t2.*, t3.id, t3.kode_sparepart, t3.name
                                                            from tb_pemesanan_unit t1 
                                                            inner join tb_detail_pemesanan_stok t2
                                                                on t1.id_pemesanan_unit=t2.id_pemesanan_unit 
                                                            inner join tb_unit t3 on t2.id=t3.id 
                                                            where t1.id_pemesanan_unit='$id'");
                            $jumlah_detil = mysql_num_rows($edit2);

                            if ($jumlah_detil > 0) {
                                $no = 1;
                                while ($result_detil = mysql_fetch_array($edit2)) {
                                    echo"<tr>
                                                            <td><input type='checkbox' id='editCheck_$result_detil[id]' value='$result_detil[id]'/></td>
                                                            <td><label>$result_detil[kode_sparepart]</label></div>
                                                            <td><label>$result_detil[name]</label>
                        <input name='pembelianunit[edit][$no][name]' type='hidden' value='$result_detil[name]' />
                        <input name='pembelianunit[edit][$no][id]' type='hidden' value='$result_detil[id]' id='akses2_$result_detil[id]' /></td>
                                                            <td><input name=\"pembelianunit[edit][$no][quantity]\" id='quantity_$result_detil[id]' type='text' class='span2' value='$result_detil[kuantitas]' /></td>
                                                            <td><input name=\"pembelianunit[edit][$no][price]\" id='price_$result_detil[id]' type=\"text\" class=\"span2\" value='$result_detil[harga]'/></td>
                                                            <td><textarea name=\"pembelianunit[edit][$no][remark]\" id='remark_$result_detil[id]' class=\"span2\" row=\"4\">$result_detil[keterangan]</textarea></td> 
                                                         </tr>";
                                    $no++;
                                }
                            } else
                                echo"<tr><td colspan='5'>Data kosong</td></tr>";
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
    }
    else if ($page == 'detail') {
        echo json_encode(array('row' => '<tr class="toggle"><td colspan="8">tes
                        </td></tr>'));
    } else if ($page == 'print') {
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
        include"../../conf/connect.php";
        include"../../conf/fungsi_indotgl.php";
        include"../../conf/library.php";


        $query = mysql_query("SELECT a . * , b . * , SUM( kuantitas * harga ) AS total
                        FROM tb_pemesanan_unit a
                        INNER JOIN ref_supplier b ON a.id_supplier = b.id_supplier
                        INNER JOIN tb_detail_pemesanan_unit e ON a.id_pemesanan_unit = e.id_pemesanan_stok
                    where a.id_pemesanan_unit='$_GET[id]'");
        $b = mysql_fetch_array($query);
        $tgl = tgl_indo($b['tanggal']);
        ?>
        <div class="content">
            <center><h2> PURCHASE ORDER</h2></center>

            <div class="info1">
                <table width="250" cellpadding="2">
                    <tr>
                        <td width="84"><b>PO Number</b></td>
                        <td width="auto">: <?php echo $b['no_faktur']; ?></td>
                    </tr>
                    <tr>
                        <td><b>Date</b></td>
                        <td>: <?php echo $tgl; ?></td>
                    </tr>
                </table>
            </div>
            <br />
            <br />
            <br/>

            <div class="rightleft">
                <span class="left">
                    <table class="table" width="300px" border="1" cellpadding="5" cellspacing="0">
                        <thead><tr><th>Suplier :</th></tr></thead>
                        <tbody><tr>
                                <td style="border:2px solid black;"><?php echo $b['nama']; ?><br />
                                    <?php echo $b['alamat']; ?> <br />INDONESIA      <br /></td>
                            </tr></tbody>
                    </table>
                </span>

                <span class="right">
                    <table class="table" width="300px" border="1" cellpadding="5" cellspacing="0">
                        <thead><tr><th>Faktur :</th></tr></thead>
                        <tbody><tr>
                                <td style="border:2px solid black;">
                                    PT ASTRA HONDA MOTOR <br />
                                    Ahass Honda 2626 DilaJaya Motor<br />
                                    Jln. Raya Cangkir 4 - Driyorejo<br />
                                    61177 - Gresik<br />
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
                        <th>Kode Sparepart</th>
                        <th>Nama Sparepart</th>
                        <th>Kuantitas</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query2 = 'SELECT *, (kuantitas * harga) as total FROM tb_pemesanan_unit a 
                                inner join tb_detail_pemesanan_stok b on a.id_pemesanan_unit=b.id_pemesanan_unit 
                                inner join tb_unit c on b.id=c.id
                                where  a.id_pemesanan_unit=' . $_GET['id'] . '';
                    $rows = mysql_query($query2);
                    $no = 1;
                    while ($row = mysql_fetch_array($rows)) {
                        echo"<tr>
                                            <td style='text-align:center;'>$no</td>
                                            <td>" . $row['kode_sparepart'] . "</td>
                                            <td>" . $row['name'] . "</td>
                                            <td>" . $row['kuantitas'] . "</td>
                                            <td style='white-space:nowrap; text-align:right;'>" . number_format($row['harga'], 2, '.', ',') . "</td>
                                            <td style='white-space:nowrap; text-align:right;'>" . number_format($row['total'], 2, '.', ',') . "</td>
                                         </tr>";
                        $no++;
                    }
                    ?>
                    <tr>
                        <td colspan="4" style="border:2px solid black; border-left:hidden;border-bottom:hidden;"></td>
                        <td class="right_align" style="border-top:2px solid black;"><b>Total</b></td>
                        <td class="right_align" style="white-space:nowrap; text-align:right; border-top:2px solid black;"><?php echo number_format($b['total'], 2, '.', ','); ?></td>
                    </tr>
                </tbody>
            </table>
            <br/><br/><br/>
            <table width="100%" class="note">
                <tr>
                    <td>Prepared by,</td>
                    <td align="right">Approved by,</td>
                </tr>
                <tr>
                    <td height="73">&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>(Staff Gudang)</td>
                    <td align="right">(Supplier PT. AHM)</td>
                </tr>
            </table>
        </div>

        <?php
    } else {
        
    }
}
?>