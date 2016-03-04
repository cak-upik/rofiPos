<script src="module/unit/main.js"></script>
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
    } elseif ($_GET['status'] == 'gagal2') {
        ?>
        <div class="alert alert-error">
            <button type="button" class="close" data-dismiss="alert">×</button>
            Proses gagal, Field tidak boleh kosong!             
        </div>
        <?php
    }
}

if (isset($_GET['page'])) {
    $page = $_GET['page'];
    if ($page == 'view') {
        ?>
        <p><button onClick="document.location = 'index.php?r=unit&page=create';" class="btn btn-warning"><i class="icon-plus-sign icon-white"></i> Tambah</button></p>
        
        <table id="unit" class="contents table table-bordered table-highlight table-striped">
            <thead>
                <tr>
                    <th width="5%">#</th>
                    <th>Nama Unit</th>
                    <th width="20%" style="text-align: center">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                $query = mysql_query("SELECT * FROM tb_unit");
                while ($result = mysql_fetch_array($query)) {
                    echo "<tr>";
                    echo "<td>$no</td>";
                    echo "<td>$result[name]</td>";
                    echo "<td style='text-align: center'><a href='index.php?r=unit&page=edit&id=$result[id]' title='Edit' class='btn btn-inverse'><i class='icon-edit'></i> Edit</a>
                            <a href='module/unit/delete.php?id=$result[id]' title='Delete' onClick=\"return confirm ('Are you sure?')\" class='btn btn-danger'><i class='icon-remove'></i> Delete</a></td>";
                    echo "</tr>";
                    $no++;
                }
                ?>
            </tbody>
        </table>
        <script src="js/jquery-1.7.2.min.js"></script> 
        <script src="js/jquery.dataTables.js"></script>
        <script>
            $(document).ready(function() {
                $('#unit').dataTable({
                    "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]]
                });
            });
        </script>

        <?php
//        $jmldata = mysql_num_rows(mysql_query("select u.* from tb_unit u "));
//        $jmlhalaman = $p->jumlahHalaman($jmldata, $batas);
//        $linkHalaman = $p->navHalaman($_GET['halaman'], $jmlhalaman);
//        echo "<div class='pagination pagination-centered' id=paging>$linkHalaman</div><br>";
    } elseif ($page == 'create') {
        ?>
        <h2>Tambah Data</h2>
        <!--<script src="module/unit/main.js"></script>-->
        <script type = "text/javascript">
            jQuery(function($) {
                //                $('#hargakosongan').autoNumeric('init');
                //                $('#plafonbbn').autoNumeric('init');
                //                $('#hargaotr').autoNumeric('init');

                $(".span2").keyup(function() {
                    var val1 = +parseFloat($("#hargakosongan").val());
                    var val2 = +parseFloat($("#plafonbbn").val());
                    $("#hargaotr").val(val1 + val2);
                });

            });
        </script>
        <form action="module/unit/input.proses.php" method="POST" name="create" class="form-horizontal" id="create">
            <div class="row">
                <div class="span6">
                    <div class="control-group">
                        <label class="control-label">Nama Unit *</label>
                        <div class="controls">
                            <input type="text" class="span3" id="nama_unit" name="nama_unit" value="" required="">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Harga Kosongan *</label>
                        <div class="controls">
                            <div class="input-prepend">
                                <span class="add-on">Rp</span>
                                <input type="text" class="span2" id="hargakosongan" style="text-align: right" name="hargakosongan" value="" required="">
                            </div>
                        </div>
                    </div>     
                    <div class="control-group">
                        <label class="control-label">Harga Plafon BBn *</label>
                        <div class="controls">
                            <div class="input-prepend">
                                <span class="add-on">Rp</span>
                                <input type="text" class="span2" id="plafonbbn" style="text-align: right" name="plafonbbn" value="" required="">
                            </div>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Harga OTR *</label>
                        <div class="controls">
                            <div class="input-prepend">
                                <span class="add-on">Rp</span>
                                <input type="text" class="span2" id="hargaotr" style="text-align: right" name="hargaotr" value="" readonly="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-actions">
                <button type="submit" name="save" class="btn btn-primary btn-small" >Simpan</button>
                <button class="btn btn-small btn-tertiary" id="" type="button" onclick="window.location.href = 'index.php?r=unit&page=view';" >Batal</button> 
            </div>
        </form>
        <?php
    } elseif ($page == 'edit') {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $query_edit = mysql_query("SELECT * FROM tb_unit WHERE id ='$id'");
            $a = mysql_fetch_array($query_edit);
            ?>
            <h2>Edit Data</h2>
            <script src="module/unit/main_edit.js"></script>
            <script type = "text/javascript">
                    jQuery(function($) {
                        $(".span2").keyup(function() {
                            var val1 = +parseFloat($("#hargakosongan").val());
                            var val2 = +parseFloat($("#plafonbbn").val());
                            $("#hargaotr").val(val1 + val2);
                        });

                    });
            </script>
            <form action="module/unit/edit.proses.php" method="POST" name="edit" class="form-horizontal" id="edit">

                <div class="row">
                    <div class="span6">
                        <div class="control-group">
                            <label class="control-label">Nama Unit *</label>
                            <div class="controls">
                                <input type="text" class="span3" id="nama_unit" name="nama_unit" value="<?php echo $a['name']; ?>" >                                    
                                <input type="hidden" class="span3" id="id_unit" name="id_unit" value="<?php echo $a['id']; ?>">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Harga Kosongan *</label>
                            <div class="controls">
                                <div class="input-prepend">
                                    <span class="add-on">Rp</span>
                                    <input type="text" class="span2" id="hargakosongan" style="text-align: right" name="hargakosongan" value="<?php echo $a['hargakosongan']; ?>" required="">
                                </div>
                            </div>
                        </div>     
                        <div class="control-group">
                            <label class="control-label">Harga Plafon BBn *</label>
                            <div class="controls">
                                <div class="input-prepend">
                                    <span class="add-on">Rp</span>
                                    <input type="text" class="span2" id="plafonbbn" style="text-align: right" name="plafonbbn" value="<?php echo $a['plafonbbn']; ?>" required="">
                                </div>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Harga OTR *</label>
                            <div class="controls">
                                <div class="input-prepend">
                                    <span class="add-on">Rp</span>
                                    <input type="text" class="span2" id="hargaotr" style="text-align: right" name="hargaotr" value="<?php echo $a['hargaotr']; ?>" readonly="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-actions">                                    
                    <button type="submit" name="save" class="btn btn-primary btn-small" >Simpan</button>
                    <button class="btn btn-small btn-tertiary" id="" type="button" onclick="window.location.href = 'index.php?r=unit&page=view';" >Batal</button> 
                </div>
            </form>
            <?php
        }
    } elseif ($page == "table") {
        ?>
        <p><button onClick="document.location = 'index.php?r=unit&page=create';" class="btn btn-warning"><i class="icon-plus-sign icon-white"></i> Tambah</button></p>
        <table id="contoh" class="contents table table-bordered table-highlight table-striped">
            <thead>
                <tr>
                    <th width="5%">#</th>
                    <th>Nama Unit</th>
                    <th width="20%" style="text-align: center">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                $query = mysql_query("SELECT * FROM tb_unit");
                while ($data = mysql_fetch_array($query)) {
                    echo "<tr>";
                    echo "<td>$no</td>";
                    echo "<td>$data[name]</td>";
                    echo "<td style='text-align: center'><a href='index.php?r=unit&page=edit&id=$result[id]' title='Edit' class='btn btn-inverse'><i class='icon-edit'></i>Edit</a>
                            <a href='module/unit/delete.php?id=$result[id]' title='Delete' onClick=\"return confirm ('Are you sure?')\" class='btn btn-danger'><i class='icon-remove'></i>Delete</a></td>";
                    echo "</tr>";
                    $no++;
                }
                ?>
            </tbody>
        </table>

                                                                                                                                <!--<script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>--> 
        <script src="js/jquery-1.7.2.min.js"></script> 
        <script src="js/jquery.dataTables.js"></script>
        <script>
            $(document).ready(function() {
                $('#contoh').dataTable(); // Menjalankan plugin DataTables pada id contoh. id contoh merupakan tabel yang kita gunakan untuk menampilkan data
            });
        </script>



        <?php
    }
}