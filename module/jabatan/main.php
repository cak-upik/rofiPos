<script src="module/jabatan/main.js"></script>
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
        <p><button onClick="document.location = 'index.php?r=jabatan&page=create';" class="btn btn-warning"><i class="icon-plus-sign icon-white"></i> Tambah</button></p>
        <table id="jabatan" class="contents table table-bordered table-highlight table-striped">
            <thead>
                <tr>
                    <th width="5%">#</th>
                    <th>Nama Jabatan</th>
                    <th width="25%" style="text-align: center">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = mysql_query("select * from tb_jabatan order by nama_jabatan");
                $total = mysql_num_rows($query);

                $no = 1;
                while ($result = mysql_fetch_array($query)) {
                    echo"<tr>
                                <td>$no</td>
                                <td>$result[nama_jabatan]</td>
                                <td style='text-align:center'>
                                    <a href='index.php?r=jabatan&page=edit&id=$result[id_jabatan]' title='Edit' class='btn btn-inverse'><i class='icon-edit'></i> Edit</a>
                                    <a href='module/jabatan/delete.php?id=$result[id_jabatan]' title='Delete' onClick=\"return confirm ('Are you sure?')\" class='btn btn-danger'><i class='icon-remove'></i> Delete</a>
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
                $('#jabatan').dataTable({
                    "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]]
                });
            });
        </script>
        <?php
    } elseif ($page == 'create') {
        ?>
        <h2>Tambah Data</h2>
        <form action="module/jabatan/input.proses.php" method="POST" class="form-horizontal" id="create">

            <div class="control-group">
                <br/>
                <label class="control-label">Nama Jabatan *</label>
                <div class="controls">
                    <input type="text" class="span4" id="nama_jabatan" name="nama_jabatan" value="">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Gaji Pokok *</label>
                <div class="controls">
                    <input type="text" class="span4" id="gaji_pokok" name="gaji_pokok" value="">
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary btn-small" >Simpan</button>
                <button class="btn btn-small btn-tertiary" id="" type="button" onclick="window.location.href = 'index.php?r=jabatan&page=view';" >Batal</button> 

            </div>
        </form>
        <?php
    } elseif ($page == 'edit') {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $query_edit = mysql_query("select * from tb_jabatan where id_jabatan='$id'");
            $a = mysql_fetch_array($query_edit);
            ?>
            <h2>Edit Data</h2>
            <form action="module/jabatan/edit.proses.php" method="POST" class="form-horizontal" id="create">
                <div class="control-group">
                    <br/>
                    <label class="control-label">Nama Jabatan *</label>
                    <div class="controls">
                        <input type="text" class="span4" id="nama_type" name="nama_jabatan" value="<?php echo $a['nama_jabatan']; ?>">
                        <input type="hidden" class="span4" id="id_jabatan" name="id_jabatan" value="<?php echo $a['id_jabatan']; ?>">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Gaji Pokok *</label>
                    <div class="controls">
                        <input type="text" class="span4" id="gaji_pokok" name="gaji_pokok" value="<?php echo $a['gaji_pokok']; ?>">
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary btn-small" >Simpan</button>
                    <button class="btn btn-small btn-tertiary" id="" type="button" onclick="window.location.href = 'index.php?r=jabatan&page=view';" >Batal</button> 

                </div>
            </form>
            <?php
        }
    }
}
?>