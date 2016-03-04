<script src="module/unit/main.js"></script>
<?php
if (isset($_GET['status'])) {
    if ($_GET['status'] == 'sukses') {
        ?>
        <div class="alert alert-success">
            <button unit="button" class="close" data-dismiss="alert">×</button>
            <label class="success">Data berhasil disimpan</label>                
        </div>
        <?php
    } elseif ($_GET['status'] == 'deleted') {
        ?>
        <div class="alert alert-success">
            <button unit="button" class="close" data-dismiss="alert">×</button>
            <label>Data berhasil dihapus</label>                
        </div>
        <?php
    } elseif ($_GET['status'] == 'edited') {
        ?>
        <div class="alert alert-success">
            <button unit="button" class="close" data-dismiss="alert">×</button>
            <label>Data berhasil diubah</label>                
        </div>
        <?php
    } elseif ($_GET['status'] == 'wrong') {
        ?>
        <div class="alert alert-error">
            <button unit="button" class="close" data-dismiss="alert">×</button>
            <label>Maaf data yang anda cari tidak ditemukan</label>                
        </div>
        <?php
    } elseif ($_GET['status'] == 'gagal') {
        ?>
        <div class="alert alert-error">
            <button unit="button" class="close" data-dismiss="alert">×</button>
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
                            <li><a tabindex="-1" href="index.php?r=unit&page=create">Tambah</a></li>
                        </ul>
                    </div>
                </div>
        -->
        <p><button onClick="document.location = 'index.php?r=unit&page=create';" class="btn btn-warning"><i class="icon-plus-sign icon-white"></i> Tambah</button></p>

        <table class="table table-bordered table-striped table-highlight">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Unit</th>
                    <th>No Rangka</th>
                    <th>No Mesin</th>                    
                    <th>Tahun</th>
                    <th>Warna</th>
                    <th>Harga Kosongan Unit</th>
                    <th>Plafon BBN</th>
                    <th>Harga OTR Unit</th>                    
                    <th>Harga Beli</th>
                    <th colspan="3">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = mysql_query("select u.*, c.name as warna from tb_unit u inner join ref_color c on c.id_color = u.id_warna");
                $total = mysql_num_rows($query);

                if ($total > 0) {
                    $no = 1;
                    while ($result = mysql_fetch_array($query)) {
                        ?>
                        <tr>
                            <td><?php echo $no; ?></td>                                                    
                            <td><?php echo $result[name]; ?></td>
                            <td><?php echo $result[no_rangka]; ?></td>
                            <td><?php echo $result[no_mesin]; ?></td>
                            <td><?php echo $result[tahun]; ?></td>
                            <td><?php echo $result[warna]; ?></td>
                            <td style="text-align: right;"><?php echo rupiah($result[hargakosongan]); ?></td>
                            <td style="text-align: right;"><?php echo rupiah($result[plafonbbn]); ?></td>
                            <td style="text-align: right;"><?php echo rupiah($result[hargaotr]); ?></td>                            
                            <td style="text-align: right;"><?php echo rupiah($result[hargabeli]); ?></td>
                            <?php
                            echo "<td style=\"text-align: center;\">
                                        <a href='index.php?r=unit&page=edit&id=$result[id]' title='Edit'><i class='icon-edit'></i></a>
                                        <a href='module/unit/delete.php?id=$result[id]' title='Delete' onClick=\"return confirm ('Are you sure?')\"><i class='icon-remove'></i></a>
                                    </td>                                                   
                                 </tr>";
                            $no++;
                        }
                    } else {
                        echo"<tr><td colspan='4'><label>Data Tidak Ditemukan</label></td></tr>";
                    }
                    ?>
            </tbody>
        </table>
        <?php
    } elseif ($page == 'create') {
        ?>
        <script src="module/biayasr/jquery-1.9.1.min.js"></script>
        <script src="module/biayasr/autoNumeric.js"></script>
        <script type = "text/javascript">
            jQuery(function($) {
                $('#hargakosongan').autoNumeric('init');
                $('#plafonbbn').autoNumeric('init');
                $('#hargaotr').autoNumeric('init');
                $('#hargabeli').autoNumeric('init');
            });
        </script>
        <h2>Tambah Data</h2>
        <form action="module/unit/input.proses.php" method="POST" class="form-horizontal" id="create">

            <div class="row">
                <div class="span6">
                    <div class="control-group">
                        <label class="control-label">Nama Unit *</label>
                        <div class="controls">
                            <input type="text" class="span3" id="name" name="name" value="">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Warna *</label>
                        <div class="controls">
                            <select name="warna" id="warna"  class="input-large">
                                <option value="0">Pilih</option>
                                <?php
                                $q = mysql_query("SELECT * FROM ref_color");
                                while ($r = mysql_fetch_array($q)) {
                                    echo "<option value='$r[id_color]'>$r[name]</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label class="control-label">No Rangka *</label>
                        <div class="controls">
                            <input type="text" class="span3" id="norangka" name="no_rangka" value="">
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">No Mesin *</label>
                        <div class="controls">
                            <input type="text" class="span3" id="nomesin" name="no_mesin" value="">
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">Tahun *</label>
                        <div class="controls">
                            <input type="text" class="span2" id="tahun" name="tahun" value="">
                        </div>
                    </div>
                </div>

                <div class="span6">
                    <div class="control-group">
                        <label class="control-label">Harga Kosongan Unit *</label>
                        <div class="controls">
                            <div class="input-prepend">
                                <span class="add-on">Rp </span>
                                <input style="text-align: right;" type="text" class="span2" id="hargakosongan" name="hargakosongan" value="">
                            </div>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">Plafon BBN *</label>
                        <div class="controls">
                            <div class="input-prepend">
                                <span class="add-on">Rp </span>
                                <input style="text-align: right;" type="text" class="span2" id="plafonbbn" name="plafonbbn" value="">
                            </div>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">Harga OTR Unit*</label>
                        <div class="controls">
                            <div class="input-prepend">
                                <span class="add-on">Rp </span>
                                <input style="text-align: right;" type="text" class="span2" id="hargaotr" name="hargaotr" value="">
                            </div>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">Harga Beli*</label>
                        <div class="controls">
                            <div class="input-prepend">
                                <span class="add-on">Rp </span>
                                <input style="text-align: right;" type="text" class="span2" id="hargabeli" name="hargabeli" value="">
                            </div>
                        </div>
                    </div>
                </div>
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
            $query_edit = mysql_query("select u.*, c.name as warna from tb_unit u inner join ref_color c on c.id_color = u.id_warna where u.id='$id'");
            $a = mysql_fetch_array($query_edit);
            ?>

            <script src="module/biayasr/jquery-1.9.1.min.js"></script>
            <script src="module/biayasr/autoNumeric.js"></script>
            <script type = "text/javascript">
                    jQuery(function($) {
                        $('#hargakosongan').autoNumeric('init');
                        $('#plafonbbn').autoNumeric('init');
                        $('#hargaotr').autoNumeric('init');
                        $('#hargabeli').autoNumeric('init');
                    });
            </script>
            <h2>Edit Data</h2>
            <form action="module/unit/edit.proses.php" method="POST" class="form-horizontal" id="create">

                <div class="row">
                    <div class="span6">
                        <div class="control-group">
                            <label class="control-label">Nama Tipe Motor *</label>
                            <div class="controls">
                                <input type="text" class="span2" id="name" name="name" value="<?php echo $a['name']; ?>" >                                    
                                <input type="hidden" class="span2" id="id" name="id" value="<?php echo $a['id']; ?>">
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Warna *</label>
                            <div class="controls">
                                <select name="warna" id="warna"  class="input-large">
                                    <?php
                                    $q = mysql_query("SELECT * FROM ref_color");
                                    while ($r = mysql_fetch_array($q)) {
                                        if ($a['id_warna'] == $r['id_color']) {
                                            echo "<option value='$r[id_color]' selected>$r[name]</option>";
                                        } else {
                                            echo "<option value='$r[id_color]'>$r[name]</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">No Rangka *</label>
                            <div class="controls">
                                <input type="text" class="span3" id="no_rangka" name="no_rangka" value="<?php echo $a['no_rangka']; ?>">
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">No Mesin *</label>
                            <div class="controls">
                                <input type="text" class="span3" id="no_mesin" name="no_mesin" value="<?php echo $a['no_mesin']; ?>">
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Tahun *</label>
                            <div class="controls">
                                <input type="text" class="span2" id="tahun" name="tahun" value="<?php echo $a['tahun']; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="span6">

                        <div class="control-group">
                            <label class="control-label">Harga Kosongan Unit *</label>
                            <div class="controls">
                                <div class="input-prepend">
                                    <span class="add-on">Rp</span>
                                    <input type="text" style="text-align: right;" class="span2" id="hargakosongan" name="hargakosongan" value="<?php echo $a['hargakosongan']; ?>">
                                </div>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Plafon BBN *</label>
                            <div class="controls">
                                <div class="input-prepend">
                                    <span class="add-on">Rp</span>
                                    <input type="text" style="text-align: right;" class="span2" id="plafonbbn" name="plafonbbn" value="<?php echo $a['plafonbbn']; ?>">
                                </div>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Harga OTR Unit *</label>
                            <div class="controls">
                                <div class="input-prepend">
                                    <span class="add-on">Rp</span>
                                    <input type="text" style="text-align: right;" class="span2" id="hargaotr" name="hargaotr" value="<?php echo $a['hargaotr']; ?>">
                                </div>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Harga Beli *</label>
                            <div class="controls">
                                <div class="input-prepend">
                                    <span class="add-on">Rp</span>
                                    <input type="text" style="text-align: right;" class="span2" id="hargabeli" name="hargabeli" value="<?php echo $a['hargabeli']; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary btn-small" >Simpan</button>
                    <button class="btn btn-small btn-tertiary" id="" type="button" onclick="window.location.href = 'index.php?r=unit&page=view';" >Batal</button> 

                </div>
            </form>
            <?php
        }
    }
}