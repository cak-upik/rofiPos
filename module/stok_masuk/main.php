
<script src="module/stok_masuk/main.js"></script>
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
                            <li><a tabindex="-1" href="index.php?r=ro&page=create">Tambah</a></li>
                        </ul>
                    </div>
                </div>
                <br/>-->
        <p><button onClick="document.location = 'index.php?r=ro&page=create';" class="btn btn-warning"><i class="icon-plus-sign icon-white"></i> Tambah</button></p>

        <table class="table table-bordered table-striped table-highlight">
            <thead>
                <tr>
                    <th width="5%">#</th>
                    <th>Nomor Faktur</th>
                    <th>Suplier</th>
                    <th>Nama Rangka</th>
                    <th>Nomor Rangka</th>
                    <th colspan="4" width="5%">&nbsp;</th>
                </tr>
            </thead>
            <tbody> 
                <?php
                $p = new Paging;
                $batas = 15;
                $posisi = $p->cariPosisi($batas);

                $query = mysql_query("select * from tb_stok a 
                                        inner join tb_detail_pemesanan_stok b on a.id_stok=b.id_pemesanan_stok 
                                        LIMIT $posisi,$batas");
                $total = mysql_num_rows($query);

                if ($total > 0) {
                    $no = 1;
                    while ($result = mysql_fetch_array($query)) {
                        $tgl = tgl_indo($result['tgl_masuk']);
                        echo"<tr>
                                <td>$no</td>
                                <td>$result[no_faktur]</td>
                                <td>$result[nama]</td>
                                <td>$tgl</td>
                                <td>
                                    <a href='#' title='Show Detail' class='trigger'><i class='icon-eye-open'></i></a>
                                </td>
                                <td>
                                    <a href='index.php?r=ro&page=edit&id=$result[id_stok_masuk]' title='Edit'><i class='icon-edit'></i></a>
                                </td>
                                <td>
                                    <a href='module/stok_masuk/delete.php?id=$result[id_stok_masuk]' title='Delete' onClick=\"return confirm ('Are you sure?')\"><i class='icon-remove'></i></a>
                                </td>  
                                <td>
                                    <a href='module/stok_masuk/main.php?r=po&page=print&id=$result[id_stok_masuk]' title='Print' target='_blank'><i class='icon-print'></i></a>
                                </td>
                             </tr>
                             <tr class=\"details\" style='display:none;'>
                                <td colspan=\"8\">";
                        $getDetail = mysql_query("select * from tb_detail_stok_masuk a 
                                                inner join tb_sparepart b on a.id_sparepart=b.id_sparepart 
                                                where a.id_stok_masuk='$result[id_stok_masuk]'");
                        ?>
                    <table >
                        <thead>
                            <tr style="background-color:#ddd; color: black;">
                                <th width="5%">#</th>
                                <th>Kode Sparepart</th>
                                <th>Sparepart</th>
                                <th>Kuantitas</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            while ($row1 = mysql_fetch_array($getDetail)) {
                                echo"<tr>
                        <td>$no</td>
                        <td>$row1[kode_sparepart]</td>
                        <td>$row1[nama_sparepart]</td>
                        <td>$row1[kuantitas]</td>
                     </tr>";
                                $no++;
                            }
                            ?>
                        </tbody> 
                    </table>
                    <?php
                    echo"</td>
                                                </tr>   ";
                    $no++;
                }
            } else {
                echo"<tr><td colspan='6'><label>Data Tidak Ditemukan</label></td></tr>";
            }
            ?>
        </tbody>
        </table>
        <?php
        $jmldata = mysql_num_rows(mysql_query("select * from tb_stok_masuk a 
                                        inner join tb_pemesanan_stok b on a.id_pemesanan_stok=b.id_pemesanan_stok"));
        $jmlhalaman = $p->jumlahHalaman($jmldata, $batas);
        $linkHalaman = $p->navHalaman($_GET['halaman'], $jmlhalaman);
        echo "<div class='pagination pagination-centered' id=paging>$linkHalaman</div><br>";
    } elseif ($page == 'create') {
        ?>
        <h2>Tambah Data</h2>

        <form action="module/stok_masuk/input.proses.php" method="POST" class="form-horizontal" id="create">
            <?php
            $kode = roNumber();
            ?>
            <div class="control-group">
                <br/>
                <label class="control-label">Nomor Stok Masuk *</label>
                <div class="controls">
                    <input type="text" class="span4" id="kode_stok_masuk" name="kode_stok_masuk" value="<?php echo $kode; ?>">
                    <input type="hidden" class="span4" id="id_pegawai" name="id_pegawai" value="<?php echo $id_pegawai; ?>">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Nomor Faktur *</label>
                <div class="controls">
                    <select name="no_faktur" id="no_faktur"  class="input-large">
                        <option value="">-- Pilih --</option>
                        <?php
                        $suplier = mysql_query("select id_pemesanan_unit, no_faktur from tb_pemesanan_unit where id_pemesanan_unit ");
                        while ($a = mysql_fetch_array($suplier)) {
                            echo"<option value='$a[id_pemesanan_unit]'>$a[no_faktur]</option>";
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
                    <select name="id_sparepart" id="id_sparepart"  class="input-large">
                        <option value="">-- Pilih --</option>

                    </select>

                    <button class="btn btn-small" id="addPro" type="button" >Tambah List</button> 
                    <button class="btn btn-small" id="delete" type="button" >Hapus List</button>
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
                        </tr>
                    </thead>
                    <tbody id="addProduct">
                        <tr><td colspan="6" align='center'>Tidak  ada data yang dimasukkan.</td></tr>
                    </tbody>
                </table>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary btn-small" >Simpan</button>
                <button class="btn btn-small btn-tertiary" id="" type="button" onclick="window.location.href = 'index.php?r=ro&page=view';" >Batal</button> 

            </div>
        </form>
        <?php
    } elseif ($page == 'edit') {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $query_edit = mysql_query("select * from tb_stok_masuk a inner join tb_pemesanan_stok b on a.id_pemesanan_stok=b.id_pemesanan_stok 
                where a.id_stok_masuk='$id'");
            $a = mysql_fetch_array($query_edit);
            ?>
            <h2>Edit Data</h2>

            <form action="module/stok_masuk/edit.proses.php" method="POST" class="form-horizontal" id="create">
                <div class="control-group">
                    <br/>
                    <label class="control-label">Kode Stok Masuk</label>
                    <div class="controls">
                        <label>: <?php echo $a['kode_stok_masuk']; ?></label>
                        <input type="hidden" class="span4" id="id_stok_masuk" name="id_stok_masuk" value="<?php echo $a['id_stok_masuk']; ?>">
                        <input type="hidden" class="span4" id="id_pegawai" name="id_pegawai" value="<?php echo $id_pegawai; ?>">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Nomor Faktur</label>
                    <div class="controls">
                        <label>: <?php echo $a['no_faktur']; ?></label>
                        <input type="hidden" class="span4" id="no_faktur" name="no_faktur" value="<?php echo $a['id_pemesanan_stok']; ?>">
                    </div>
                </div>
                <div class="control-group" >
                    <label class="control-label"> 
                        Sparepart
                    </label>
                    <div class="controls">
                        <select name="productId" id="productId"  class="input-large">
                            <?php
                            $query = mysql_query("select distinct a.id_sparepart, b.kode_sparepart, b.nama_sparepart 
                                                from tb_detail_pemesanan_stok a inner join tb_sparepart b on a.id_sparepart=b.id_sparepart 
                                                where a.id_pemesanan_stok='$a[id_pemesanan_stok]'");
                            while ($result = mysql_fetch_array($query)) {
                                $base64 = base64_encode(implode('||', array($result['id_sparepart'], $result['nama_sparepart'], $result['kode_sparepart'])));
                                echo"<option value='$base64'>( $result[kode_sparepart] ) $result[nama_sparepart]</option>";
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
                            </tr>
                        </thead>
                        <tbody id="addProductEdit">
                            <?php
                            $edit2 = mysql_query("select t1.*, t2.*, t3.id_sparepart, t3.kode_sparepart, t3.nama_sparepart
                                                            from tb_stok_masuk t1 
                                                            inner join tb_detail_stok_masuk t2
                                                                on t1.id_stok_masuk=t2.id_stok_masuk 
                                                            inner join tb_sparepart t3 on t2.id_sparepart=t3.id_sparepart 
                                                            where t1.id_stok_masuk='$id'");
                            $jumlah_detil = mysql_num_rows($edit2);

                            if ($jumlah_detil > 0) {
                                $no = 1;
                                while ($result_detil = mysql_fetch_array($edit2)) {
                                    $cekQ = mysql_query("select kuantitas from tb_detail_pemesanan_stok 
                                                        where id_sparepart='$result_detil[id_sparepart]' and id_pemesanan_stok='$a[id_pemesanan_stok]'");
                                    $resultQ = mysql_fetch_array($cekQ);
                                    echo"<tr>
                                                            <td><input type='checkbox' id='editCheck_$result_detil[id_sparepart]' value='$result_detil[id_sparepart]'/></td>
                                                            <td><label>$result_detil[kode_sparepart]</label></div>
                                                            <td><label>$result_detil[nama_sparepart]</label>
                        <input name='ro[edit][$no][nama_sparepart]' type='hidden' value='$result_detil[nama_sparepart]' />
                        <input name='ro[edit][$no][id_stok_masuk]' type='hidden' value='$result_detil[id_stok_masuk]' />
                        <input name='ro[edit][$no][id_sparepart]' type='hidden' value='$result_detil[id_sparepart]' id='akses2_$result_detil[id_sparepart]' /></td>
                                                            <td><input name=\"ro[edit][$no][kuantitas]\" id='kuantitas$result_detil[id_sparepart]' type='text' class='span2' value='$result_detil[kuantitas]' onblur='autoComplete($result_detil[id_sparepart], $a[id_pemesanan_stok]);'/>
                                                                <input id=\"filterKuantitas$result_detil[id_sparepart]\" type=\"hidden\" class=\"span2\" value='$resultQ[kuantitas]' /></td>
                                                            
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
                    <button class="btn btn-small btn-tertiary" id="" type="button" onclick="window.location.href = 'index.php?r=ro&page=view';" >Batal</button> 

                </div>
            </form>

            <?php
        }
    }
    elseif ($page == 'detail') {
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
        include"../../conf/connect.php";
        include"../../conf/fungsi_indotgl.php";
        include"../../conf/library.php";


        $query = mysql_query("select a.*, b.*, f.*, sum(g.kuantitas * g.harga) as total 
                    from tb_stok_masuk a inner join tb_pemesanan_stok f on a.id_pemesanan_stok=f.id_pemesanan_stok
                    inner join tb_detail_pemesanan_stok g on f.id_pemesanan_stok=g.id_pemesanan_stok
                    inner join tb_suplier b on f.id_suplier=b.id_suplier 
                    inner join tb_detail_stok_masuk e on a.id_stok_masuk=e.id_stok_masuk 
                    where a.id_stok_masuk='$_GET[id]'");
        $b = mysql_fetch_array($query);
        $tgl = tgl_indo($b['tanggal']);
        ?>
        <div class="content">
            <center><h2> RECEIVED ORDER</h2></center>

            <div class="info1">
                <table cellpadding="5">
                    <tr>
                        <td><b>Nomor RO</b></td>
                        <td>: <?php echo $b['kode_stok_masuk']; ?></td>
                    </tr>
                    <tr>
                    <tr>
                        <td><b>Nomor PO</b></td>
                        <td>: <?php echo $b['no_faktur']; ?></td>
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
                        <thead><tr><th>Suplier :</th></tr></thead>
                        <tbody><tr>
                                <td style="border:2px solid black;"><?php echo $b['nama']; ?><br />
                                    <?php echo $b['alamat']; ?> <br /> INDONESIA      <br /></td>
                            </tr></tbody>
                    </table>
                </span>

                <span class="right">
                    <table class="table" width="300px" border="1" cellpadding="5" cellspacing="0">
                        <thead><tr><th>Faktur :</th></tr></thead>
                        <tbody><tr>
                                <td style="border:2px solid black;"><p>PT ASTRA HONDA MOTOR <br />
                                        Ahass Honda 2626 DilaJaya Motor<br />
                                        Jln. Raya Cangkir 4 - Driyorejo</p>
                                    <p>61177 - Gresik<br />
                                        <br />
                                    </p></td>
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
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query2 = 'SELECT * FROM tb_stok_masuk a 
                                inner join tb_detail_stok_masuk b on a.id_stok_masuk=b.id_stok_masuk 
                                inner join tb_sparepart c on b.id_sparepart=c.id_sparepart
                                where  a.id_stok_masuk=' . $_GET['id'] . '';
                    $rows = mysql_query($query2);
                    $no = 1;
                    while ($row = mysql_fetch_array($rows)) {
                        echo"<tr>
                                            <td style='text-align:center;'>$no</td>
                                            <td>" . $row['kode_sparepart'] . "</td>
                                            <td style='white-space:nowrap; text-align:right;'>" . $row['nama_sparepart'] . "</td>
                                            <td style='white-space:nowrap; text-align:right;'>" . number_format($row['kuantitas'], 2, '.', ',') . "</td>
                                         </tr>";
                        $no++;
                    }
                    ?>

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