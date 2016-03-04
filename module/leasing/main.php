<script src="module/leasing/main.js"></script>
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
        <p><button onClick="document.location = 'index.php?r=leasing&page=create';" class="btn btn-warning"><i class="icon-plus-sign icon-white"></i> Tambah</button></p>

        <table id="leasing" class="table table-bordered table-striped table-highlight">
            <thead>
                <tr>
                    <th width="5%">#</th>
                    <th>Nama leasing</th>
                    <th>Alamat</th>
                    <th>No Telp</th>
                    <th>Subsidi Leasing</th>
                    <th>Insentive Leasing</th>
                    <th>Tambahan Subsidi Leasing</th>
                    <th width="20%">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = mysql_query("select * from ref_leasing where name>'' and addres>'' and phone>'' and subLeasing>'' and insentiveLeasing>'' and subAdd>'' order by name");

                $no = 1;
                while ($result = mysql_fetch_array($query)) {
                    ?>
                    <tr>
                        <td><?php echo $no; ?></td>
                        <td><?php echo $result[name]; ?></td>
                        <td><?php echo $result[addres]; ?></td>
                        <td><?php echo $result[phone]; ?></td>
                        <td style='text-align: right'><?php echo rupiah($result[subLeasing]); ?></td>
                        <td style='text-align: right'><?php echo rupiah($result[insentiveLeasing]); ?></td>
                        <td style='text-align: right'><?php echo rupiah($result[subAdd]); ?></td>

                        <?php
                        echo "<td>
                            <a href='index.php?r=leasing&page=edit&id=$result[id]' title='Edit' class='btn btn-inverse'><i class='icon-edit'></i> Edit</a>
                            <a href='module/leasing/delete.php?id=$result[id]' title='Delete' onClick=\"return confirm ('Are you sure?')\" class='btn btn-danger'><i class='icon-remove'></i> Delete</a>
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
                $('#leasing').dataTable({
                    "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]]
                });
            });
        </script>
        <?php
    } elseif ($page == 'create') {
        ?>
        <h2>Tambah Data</h2>
        <form action="module/leasing/input.proses.php" method="POST" class="form-horizontal" id="create">

            <div class="control-group">
                <br/>
                <label class="control-label">Nama leasing *</label>
                <div class="controls">
                    <input type="text" class="span4" id="name" name="name" value="">
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Alamat</label>
                <div class="controls">
                    <textarea name="addres" id="addres" class="span4"></textarea>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">No Telp</label>
                <div class="controls">
                    <input type="text" class="span4" id="phone" name="phone" value="">
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Subsidi Leasing</label>
                <div class="controls">
                    <input type="text" class="span4" id="subleasing" name="subleasing" value="">
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Insentive Leasing</label>
                <div class="controls">
                    <input type="text" class="span4" id="insentiveleasing" name="insentiveleasing" value="">
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Tambahan Subsidi Leasing</label>
                <div class="controls">
                    <input type="text" class="span4" id="subadd" name="subadd" value="">
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary btn-small" >Simpan</button>
                <button class="btn btn-small btn-tertiary" id="" type="button" onclick="window.location.href = 'index.php?r=leasing&page=view';
                        " >Batal</button> 

            </div>
        </form>
        <?php
    } elseif ($page == 'edit') {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $query_edit = mysql_query("select * from ref_leasing where id = '$id'");
            $a = mysql_fetch_array($query_edit);
            ?>
            <h2>Edit Data</h2>
            <form action="module/leasing/edit.proses.php" method="POST" class="form-horizontal" id="create">


                <div class="control-group">
                    <br/>
                    <label class="control-label">Nama leasing *</label>
                    <div class="controls">
                        <input type="text" class="span4" id="name" name="name" value="<?php echo $a['name']; ?>">
                        <input type="hidden" class="span4" id="id" name="id" value="<?php echo $a['id']; ?>">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Alamat</label>
                    <div class="controls">
                        <textarea name="addres" id="addres" class="span4" ><?php echo $a['addres']; ?></textarea>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">No Telp</label>
                    <div class="controls">
                        <input type="text" class="span4" id="phone" name="phone" value="<?php echo $a['phone']; ?>">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Subsidi Leasing</label>
                    <div class="controls">
                        <input type="text" class="span4" id="subleasing" name="subleasing" value="<?php echo $a['subLeasing']; ?>">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Insentive Leasing</label>
                    <div class="controls">
                        <input type="text" class="span4" id="insentiveleasing" name="insentiveleasing" value="<?php echo $a['insentiveLeasing']; ?>">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Tambahan Subsidi Leasing</label>
                    <div class="controls">
                        <input type="text" class="span4" id="subadd" name="subadd" value="<?php echo $a['subAdd']; ?>">
                    </div>
                </div>


                <div class="form-actions">
                    <button type="submit" class="btn btn-primary btn-small" >Simpan</button>
                    <button class="btn btn-small btn-tertiary" id="" type="button" onclick="window.location.href = 'index.php?r=leasing&page=view';" >Batal</button> 

                </div>
            </form>
            <?php
        }
    }
}    