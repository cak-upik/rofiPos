<script src="module/penjualan/main.js"></script>
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
                            <li><a tabindex="-1" href="index.php?r=penjualan&page=create">Tambah</a></li>
                        </ul>
                    </div>
                </div>
                <br/>-->
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
                } else
                    echo"<tr><td colspan='7'><label>Data Tidak Ditemukan</label></td></tr>";
                ?>
            </tbody>
        </table>
        <?php
        $jmldata = mysql_num_rows(mysql_query("select * from tb_penjualan"));
        $jmlhalaman = $p->jumlahHalaman($jmldata, $batas);
        $linkHalaman = $p->navHalaman($_GET['halaman'], $jmlhalaman);
        echo "<div class='pagination pagination-centered' id=paging>$linkHalaman</div><br>";
    }
    elseif ($page == 'create') {
        ?>
        <form action="module/penjualan/input.proses.php" method="POST" class="form-horizontal" id="create">
            <?php
            $kode = notaNumber();
            $tglw = tgl_indo($tgl_sekarang);
            ?>
            <div class="row">
                <div class="span6">
                    <div class="control-group">
                        <label class="control-label">Nomor penjualan :</label>
                        <div class="controls">
                            <input type="text" class="span2" id="no_jual" name="no_jual" value="<?php echo $kode; ?>" readonly ></label>
                        </div>
                    </div>
                </div>
                <div class="span6">
                    <div class="control-group" >
                        <label class="control-label">Tanggal :</label>
                        <div class="controls">    
                            <input type="text" class="span2" id="tanggal" name="tanggal" value="<?php
                            echo $tglw;
                            ?>" readonly>
                        </div>
                    </div>
                </div>
            </div>
            <div class="control-group">                               
                <label class="control-label">Nama Customer *</label>
                <div class="controls">                                   
                    <select name="id_customer" id="id_customer" class="input-large">
                        <option value="">Pilih</option>
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
                <label class="control-label">Nama Unit *</label>
                <div class="controls">
                    <select name="ref_unit_id" id="ref_unit_id" class="input-large">
                        <option value="">Pilih</option>
                        <?php
                        $selectUnit = mysql_query("select * from tb_unit order by name");
                        while ($row = mysql_fetch_array($selectUnit)) {
                            echo"<option value='$row[id]'>$row[name]</option>";
                        }
                        ?>
                    </select>                                   
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Nama Leasing *</label>
                <div class="controls">
                    <select name="ref_leasing_id" id="ref_leasing_id" class="input-large">
                        <option value="">Pilih</option>
                        <?php
                        $selectLeasing = mysql_query("select * from ref_leasing order by name");
                        while ($row = mysql_fetch_array($selectLeasing)) {
                            echo"<option value='$row[id]'>$row[name]</option>";
                        }
                        ?>
                    </select>

                    <button class="btn btn-small" id="add" type="button" >Tambah List</button> 
                    <button class="btn btn-small" id="delete" type="button" >Hapus List</button>
                </div>
            </div>
            <div class="well" style="max-height: auto; overflow: auto;">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <!--<th>Id</th>-->
                            <th>Harga Jual Unit</th>
                            <th>Uang Muka</th>
                            <th>Diskon</th>
                            <th>Total Pembelian</th>
                        </tr>
                    </thead>
                    <tbody id="addProduct">
                        <tr><td colspan="6" align='center'>Tidak  ada data yang dimasukkan.</td></tr>
                    </tbody>
                </table>
            </div>
            <div class="control-group">                               
                <label class="control-label">Harga Jual Unit *</label>
                <div class="controls">
                    <div class="input-prepend input-append">
                        <span class="add-on">Rp</span>
                        <input type="text" class="span2 penjualan" style="text-align: right;" id="hargaotr" name="hargaotr" value="" readonly>
                        <span class="add-on">.-</span>
                    </div>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Uang Muka</label>
                <div class="controls">
                    <div class="input-prepend input-append">
                        <span class="add-on">Rp</span>
                        <input type="text" class="span2" style="text-align: right;" id="uangmuka" name="uangmuka" value="">
                        <span class="add-on">.-</span>
                    </div>
                </div>                                               
            </div>
            <div class="control-group">
                <label class="control-label">Diskon</label>
                <div class="controls span7">
                    <div class="input-append">
                        <input type="text" class="span1" style="text-align: right;" id="disc" name="disc" value="">
                        <span class="add-on">%</span>
                    </div>
                </div>
            </div> 
            <div class="control-group">
                <label class="control-label">Total Pembelian</label>
                <div class="controls">
                    <div class="input-prepend input-append">
                        <span class="add-on">Rp</span>
                        <input type="text" class="span2" style="text-align: right;" id="nett" name="nett" value="" readonly>
                        <span class="add-on">.-</span>
                    </div>
                </div>
            </div>
        </div>

        <!--            <div class="control-group">                               
                        <label class="control-label">Kuantiti</label>
                        <div class="controls">
                            <input type="text" class="span4" id="kuantiti" name="kuantiti" value="">
                        </div>
                    </div>-->

        <!--</div>-->

        <!--</div>-->

        <div class="form-actions">
            <button type="submit" class="btn btn-primary btn-small" >Simpan</button>
            <button class="btn btn-small btn-tertiary" id="" type="button" onclick="window.location.href = 'index.php?r=penjualan&page=view';" >Batal</button> 

        </div>
        </form>

        <?php
    } elseif ($page == 'edit') {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $query_edit = mysql_query("select * from tb_penjualan a 
                                    inner join tb_pelanggan b on a.id_pelanggan=b.id_pelanggan 
                                    inner join tb_pekerjaan c on a.id_penjualan=c.id_penjualan 
                                    inner join tb_type_motor d on b.id_type_motor=d.id_type_motor
                                    where a.id_penjualan='$id'");
            $row = mysql_fetch_array($query_edit);
            ?>
            <form action="module/penjualan/input.proses.php" method="POST" class="form-horizontal" id="create">
                <?php
                $kode = notaNumber();
                $tglw = tgl_indo($tgl_sekarang);
                ?>
                <div class="row">
                    <div class="span6">

                        <div class="control-group">
                            <label class="control-label">Nomor penjualan :</label>
                            <div class="controls">
                                <input type="text" class="span3" id="no_jual" name="no_jual" value="<?php echo $kode; ?>" readonly ></label>
                            </div>
                        </div>
                        <div class="control-group">                               
                            <label class="control-label">Nama Customer *</label>
                            <div class="controls">                                   
                                <select name="id_customer" id="id_customer" class="input-large">
                                    <option value="">Pilih</option>
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
                            <label class="control-label">Nama Unit</label>
                            <div class="controls">
                                <select name="ref_unit_id" id="ref_unit_id" class="input-large">
                                    <option value="">Pilih</option>
                                    <?php
                                    $selectUnit = mysql_query("select * from tb_unit order by name");
                                    while ($row = mysql_fetch_array($selectUnit)) {
                                        echo"<option value='$row[id]'>$row[name]</option>";
                                    }
                                    ?>
                                </select>                                   
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Nama Leasing</label>
                            <div class="controls">
                                <select name="ref_leasing_id" id="ref_leasing_id" class="input-large">
                                    <option value="">Pilih</option>
                                    <?php
                                    $selectLeasing = mysql_query("select * from ref_leasing order by name");
                                    while ($row = mysql_fetch_array($selectLeasing)) {
                                        echo"<option value='$row[id]'>$row[name]</option>";
                                    }
                                    ?>
                                </select>                                    
                            </div>
                        </div>                    
                        <div class="control-group">                               
                            <label class="control-label">Harga Jual Unit *</label>
                            <div class="controls">
                                <div class="input-prepend input-append">
                                    <span class="add-on">Rp</span>
                                    <input type="text" class="penjualan span3" style="text-align: right;" id="hargaotr" name="hargaotr" value="" readonly>
                                    <span class="add-on">.-</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--</div>-->

                    <div class="span6">
                        <div class="control-group" >
                            <label class="control-label">Tanggal :</label>
                            <div class="controls">    
                                <input type="text" class="span3" id="tanggal" name="tanggal" value="<?php
                                echo $tglw;
                                ?>" readonly>
                            </div>
                        </div>

                        <!--            <div class="control-group">                               
                                        <label class="control-label">Kuantiti</label>
                                        <div class="controls">
                                            <input type="text" class="span4" id="kuantiti" name="kuantiti" value="">
                                        </div>
                                    </div>-->

                        <div class="control-group">
                            <label class="control-label">Uang Muka</label>
                            <div class="controls">
                                <div class="input-prepend input-append">
                                    <span class="add-on">Rp</span>
                                    <input type="text" class="span3" style="text-align: right;" id="uangmuka" name="uangmuka" value="">
                                    <span class="add-on">.-</span>
                                </div>
                            </div>                                               
                        </div>
                        <div class="control-group">
                            <label class="control-label">Diskon</label>
                            <div class="controls">
                                <div class="input-prepend input-append">
                                    <span class="add-on"></span>
                                    <input type="text" class="span1" id="disc" name="disc" value="">
                                    <span class="add-on">%</span>
                                </div>
                            </div>
                        </div> 
                        <div class="control-group">
                            <label class="control-label">Total Pembelian</label>
                            <div class="controls">
                                <div class="input-prepend input-append">
                                    <span class="add-on">Rp</span>
                                    <input type="text" class="span3" style="text-align: right;" id="nett" name="nett" value="" readonly>
                                    <span class="add-on">.-</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary btn-small" >Simpan</button>
                    <button class="btn btn-small btn-tertiary" id="" type="button" onclick="window.location.href = 'index.php?r=penjualan&page=view';" >Batal</button> 

                </div>
            </form>
            <?php
        }
    } elseif ($page == 'report') {
        ?>
        <script src="module/penjualan/main.js"></script>
        <form name="form" target="_blank" method="POST" action="module/penjualan/print.php?sub=laporan1">
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
?>