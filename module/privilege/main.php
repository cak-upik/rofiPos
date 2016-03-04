<script src="module/privilege/main.js"></script>
<div class="row-fluid">
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
</div>

<div class="row-fluid">
    <div class="block">
        <?php
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
            if ($page == 'view') {
                ?>
                <p><button onClick="document.location = 'index.php?r=privilege&page=create';" class="btn btn-warning"><i class="icon-plus-sign icon-white"></i> Tambah</button></p>

                <table id="previlage" class="contents table table-bordered table-highlight table-striped">
                    <thead>
                        <tr>
                            <th width="5%">#</th>
                            <th>Nama User</th>
                            <th width="25%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = mysql_query("select distinct b.* from tb_detail_hak_akses a inner join tb_jabatan b on a.id_jabatan=b.id_jabatan");
                        $total = mysql_num_rows($query);

                        $no = 1;
                        while ($result = mysql_fetch_array($query)) {
                            echo"<tr>
                                    <td>$no</td>
                                    <td>$result[nama_jabatan]<input type='hidden' value='$result[id_jabatan]' name='param' id='param'></td>
                                    <td>
                                        <a href='index.php?r=privilege&page=detail&id=$result[id_jabatan]' title='Detail' id='view' class='btn'><i class='icon-eye-open'></i> Detail</a>
                                        <a href='index.php?r=privilege&page=edit&id=$result[id_jabatan]' title='Edit' class='btn btn-inverse'><i class='icon-edit'></i> Edit</a>
                                        <a href='module/privilege/action.php?act=delete&id=$result[id_jabatan]' title='Delete' onClick=\"return confirm ('Are you sure?')\" class='btn btn-danger'><i class='icon-remove'></i> Delete</a>
                                    </td>
                                 </tr>";
                            $no++;
                        }
                        ?>
                    </tbody>
                </table>
                <script src="js/jquery-1.7.2.min.js"></script> 
                <script src="js/jquery.dataTables.js"></script>
                <script>
                    $(document).ready(function() {
                        $('#previlage').dataTable({
                            "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]]
                        });
                    });
                </script>
                <?php
            } elseif ($page == 'create') {
                ?>
                <h2>Tambah Data</h2>
                <form action="module/privilege/action.php?act=save" method="POST" class="form-horizontal" id="createpriv">

                    <div id="tablewidget" class="block-body collapse in">
                        <div class="control-group">
                            <label class="control-label">User</label>
                            <div class="controls">
                                <select name="id_jabatan" id="id_jabatan" class="input-large">
                                    <option value="">Pilih</option>
                                    <?php
                                    $selectUser = mysql_query("select * from tb_jabatan where id_jabatan not in 
                                                (select distinct id_jabatan from tb_detail_hak_akses)");
                                    while ($result = mysql_fetch_array($selectUser)) {
                                        echo"<option value='$result[id_jabatan]'>$result[nama_jabatan]</option>";
                                    }
                                    ?>
                                </select>                                   
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Hak Akses</label>
                            <div class="controls">
                                <select name="hak_akses" id="hak_akses" class="input-large">
                                    <option value="">Pilih</option>
                                    <?php
                                    $selectHak_akses = mysql_query("select * from tb_hak_akses order by hak_akses");
                                    while ($result2 = mysql_fetch_array($selectHak_akses)) {
                                        $base64 = base64_encode(implode('||', array($result2['id_hak_akses'], $result2['hak_akses'])));
                                        echo"<option value='$base64'>$result2[hak_akses]</option>";
                                    }
                                    ?>
                                </select>    
                                <button class="btn btn-small" id="addDetil" type="button" >Tambah</button> 
                                <button class="btn btn-small" id="deleteDetil" type="button" >Hapus</button>
                            </div>
                        </div>
                        <div class="well" style="max-height: 250px; overflow: auto;">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th width="20">&nbsp;</th>
                                        <th>Hak Akses</th>
                                    </tr>
                                </thead>
                                <tbody id="masterprivilege" >
                                    <tr><td colspan="2" align='center'>No data added...</td></tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary btn-small" >Simpan</button>
                            <button class="btn btn-small btn-tertiary" id="" type="button" onclick="window.location.href = 'index.php?r=privilege&page=view';" >Batal</button> 

                        </div>
                    </div>
                </form>
                <?php
            } elseif ($page == 'edit') {
                if (isset($_GET['id'])) {
                    $id = $_GET['id'];
                    $edit = mysql_query("select * from tb_jabatan where id_jabatan='$id'");
                    $jumlah = mysql_num_rows($edit);

                    if ($jumlah > 0) {
                        $result = mysql_fetch_array($edit);
                        ?>
                        <h2>Edit Data</h2>
                        <form action="module/privilege/action.php?act=edit" method="POST" class="form-horizontal">

                            <br/>
                            <div class="control-group">
                                <label class="control-label">User</label>
                                <div class="controls">
                                    <input type="text" class="span4" id="nama_jabatan" name="nama_jabatan" value="<?php echo $result['nama_jabatan']; ?>" readonly>
                                    <input type="hidden" class="span4" id="id_jabatan" name="id_jabatan" value="<?php echo $result['id_jabatan']; ?>">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Hak Akses</label>
                                <div class="controls">
                                    <select name="hak_akses" id="edithak_akses" class="input-large">
                                        <option value="0">Pilih</option>
                                        <?php
                                        $selectHak_akses = mysql_query("select * from tb_hak_akses");
                                        while ($result2 = mysql_fetch_array($selectHak_akses)) {
                                            $base64 = base64_encode(implode('||', array($result2['id_hak_akses'], $result2['hak_akses'])));
                                            echo"<option value='$base64'>$result2[hak_akses]</option>";
                                        }
                                        ?>
                                    </select>    
                                    <button class="btn btn-small" id="editDetil" type="button" >Tambah</button> 
                                    <button class="btn btn-small" id="deleteEditDetil" type="button" >Hapus</button>
                                </div>
                            </div>

                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>&nbsp;</th>
                                        <th>Hak Akses</th>
                                    </tr>
                                </thead> 
                                <tbody id="masterEditprivilege">
                                    <?php
                                    $edit2 = mysql_query("select * from tb_hak_akses t1 
                                                            inner join tb_detail_hak_akses t2
                                                                on t1.id_hak_akses=t2.id_hak_akses 
                                                            inner join tb_jabatan t3 on t2.id_jabatan=t3.id_jabatan where t3.id_jabatan='$id'");
                                    $jumlah_detil = mysql_num_rows($edit2);

                                    if ($jumlah_detil > 0) {
                                        $no = 1;
                                        while ($result_detil = mysql_fetch_array($edit2)) {
                                            echo"<tr>
                                                            <td><input type='checkbox' id='editCheck_$result_detil[id_hak_akses]' value='$result_detil[id_hak_akses]'/></td>
                                                            <td><label>$result_detil[hak_akses]</label>
                        <input name='master_privilege[edit][$no][nama_hak_akses]' type='hidden' value='$result_detil[hak_akses]' />
                        <input name='master_privilege[edit][$no][id_hak_akses]' type='hidden' value='$result_detil[id_hak_akses]' id='akses2_$result_detil[id_hak_akses]' /></td>
                                                         </tr>";
                                            $no++;
                                        }
                                    } else
                                        echo"<tr><td colspan='2'>Data kosong</td></tr>";
                                    ?>
                                </tbody>
                            </table>
                            <div class="well ">
                                <button type="submit" class="btn btn-primary btn-small" >Simpan Perubahan</button>
                                <button class="btn btn-small btn-tertiary" id="" type="button" onclick="window.location.href = 'index.php?r=privilege&page=view';" >Batal</button> 

                            </div>

                        </form>
                        <?php
                    }
                    else {
                        ?>
                        <div class="alert alert-error error-container">                    
                            <label>Maaf data yang anda cari tidak ditemukan, <a href="index.php?r=privilege&page=view" class="error">Kembali</a></label>                
                        </div>
                        <?php
                    }
                }
                ?>

                <?php
            } elseif ($page == 'detail') {
                if (isset($_GET['id'])) {
                    $id = $_GET['id'];
                    $qq = mysql_fetch_array(mysql_query("select * from tb_jabatan where id_jabatan='$id'"))
                    ?>
                    <h2>Detail</h2>
                    <form action="#" method="POST" class="form-horizontal" >
                        <div class="control-group">
                            <label class="control-label"><b>Nama User :</b></label>
                            <div class="controls">
                                <label style="margin-top: 5px;"><?php echo $qq['nama_jabatan']; ?></label>
                            </div>
                        </div>  
                        <div class="well"  style="max-height: 300px; overflow: auto;">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>&nbsp;</th>
                                        <th>Hak Akses</th>
                                    </tr>
                                </thead> 
                                <tbody>
                                    <?php
                                    $edit2 = mysql_query("select * from tb_hak_akses t1 
                                            inner join tb_detail_hak_akses t2 on t1.id_hak_akses=t2.id_hak_akses 
                                            inner join tb_jabatan t3 on t2.id_jabatan=t3.id_jabatan where t3.id_jabatan='$id'");
                                    $jumlah_detil = mysql_num_rows($edit2);

                                    if ($jumlah_detil > 0) {
                                        $no = 1;
                                        while ($result_detil = mysql_fetch_array($edit2)) {
                                            echo"<tr>
                                   <td>$no</td>
                                   <td>$result_detil[hak_akses]</td>
                                </tr>";
                                            $no++;
                                        }
                                    } else
                                        echo"<tr><td colspan='2'>Data kosong</td></tr>";
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </form>
                    <?php
                }
            }
        }
        ?>
    </div>
</div>



