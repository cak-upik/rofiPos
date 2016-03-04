<script src="module/stok/main.js"></script>
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
        <div class="input-prepend pull-right">
            <span class="add-on"><i class="icon-search"></i></span><input type="text" id="search" name="search" placeholder="search..">
        </div>
        <table class="table table-bordered table-striped table-highlight">
            <thead>
                <tr>
                    <th width="5%">#</th>
                    <th>UNIT</th>
                    <th>NO. RANGKA</th>
                    <th>NO. MESIN</th>
                    <th>WARNA</th>
                    <th>JUMLAH STOK</th>
                </tr>
            </thead>
            <tbody id="listStok">
                <?php
//                $query = mysql_query("SELECT pm.* FROM pembelian pm
//                                    INNER JOIN tb_unit u ON u.id = pm.id_unit
//                                    INNER JOIN tb_detail_unit du ON du.id_unit = u.id_detail_unit = pm.id_detail_unit
//                                    INNER JOIN ref_supplier rs ON rs.id_supplier = pm.id_supplier
//                                    INNER JOIN tb_pemesanan_unit pu ON pu.id_pemesanan_unit = pm.id_pemesanan_unit
//                                    INNER JOIN detail_pembelian dpm ON dpm.id_detail_pembelian = pm.id_detail_pembelian");
                $query = mysql_query("select * from pembelian p 
                            INNER JOIN detail_pembelian dp on dp.id_pembelian = p.id_pembelian
                            INNER JOIN tb_unit u on u.id = dp.id_unit
                            INNER JOIN tb_detail_unit du on du.id_unit = u.id
                            INNER JOIN tb_pemesanan_unit pu on pu.id_pemesanan_unit = dp.id_pemesanan_unit
                            INNER JOIN tb_detail_pemesanan_unit dpu on dpu.id_pemesanan_unit = pu.id_pemesanan_unit
                            INNER JOIN detail_penjualan dpe on dpe.id_unit = u.id
                            INNER JOIN penjualan pe on pe.id_penjualan = dpe.id_penjualan
                            INNER JOIN ref_color rc on rc.id_color = du.id_color
                            INNER JOIN ref_supplier rs on rs.id_supplier = pu.id_supplier
                            INNER JOIN ref_customer rcs on rcs. id_customer = pe.id_customer
                            INNER JOIN ref_leasing rl on rl.id = pe.id_leasing");
                $total = mysql_num_rows($query);

                if ($total > 0) {
                    $no = 1;
                    while ($result = mysql_fetch_array($query)) {
                        echo"<tr>
                                                    <td>$no</td>
                                                    <td>$result[no_faktur]</td>
                                                    <td>$result[nama_sparepart]</td>
                                                    <td>$result[jumlah_stok]</td>                          
                                                 </tr>";
                        $no++;
                    }
                } else {
                    echo"<tr><td colspan='6'><label>Data Tidak Ditemukan</label></td></tr>";
                }
                ?>
            </tbody>
        </table> 
        <?php
    } elseif ($page == 'create') {
        ?>
        <h2>Tambah Data</h2>
        <form action="module/stok/input.proses.php" method="POST" class="form-horizontal" id="create">

            <div class="control-group">
                <br/>
                <label class="control-label">Nama *</label>
                <div class="controls">
                    <input type="text" class="span4" id="nama" name="nama" value="">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Alamat *</label>
                <div class="controls">
                    <textarea name="alamat" id="alamat" class="span4" row="5"></textarea>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">No Telepon *</label>
                <div class="controls">
                    <input type="text" class="span4" id="no_telp" name="no_telp" value="">
                </div>
            </div>


            <div class="form-actions">
                <button type="submit" class="btn btn-primary btn-small" >Simpan</button>
                <button class="btn btn-small btn-tertiary" id="" type="button" onclick="window.location.href = 'index.php?r=stok&page=view';" >Batal</button> 

            </div>
        </form>
        <?php
    } elseif ($page == 'edit') {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $query_edit = mysql_query("select * from tb_stok where id_stok='$id'");
            $a = mysql_fetch_array($query_edit);
            ?>
            <h2>Edit Data</h2>
            <form action="module/stok/edit.proses.php" method="POST" class="form-horizontal" id="create">

                <div class="control-group">
                    <br/>
                    <label class="control-label">Nama *</label>
                    <div class="controls">
                        <input type="text" class="span4" id="nama" name="nama" value="<?php echo $a['nama']; ?>">
                        <input type="hidden" class="span4" id="id_stok" name="id_stok" value="<?php echo $a['id_stok']; ?>">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Alamat *</label>
                    <div class="controls">
                        <textarea name="alamat" id="alamat" class="span4" row="5"><?php echo $a['alamat']; ?></textarea>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">No Telepon *</label>
                    <div class="controls">
                        <input type="text" class="span4" id="no_telp" name="no_telp" value="<?php echo $a['no_telp']; ?>">
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary btn-small" >Simpan</button>
                    <button class="btn btn-small btn-tertiary" id="" type="button" onclick="window.location.href = 'index.php?r=stok&page=view';" >Batal</button> 

                </div>
            </form>
            <?php
        }
    }
}