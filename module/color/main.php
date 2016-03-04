<script src="module/color/main.js"></script>
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
        <p><button onClick="document.location = 'index.php?r=color&page=create';" class="btn btn-warning"><i class="icon-plus-sign icon-white"></i> Tambah</button></p>

        <table id="color" class="table table-striped table-bordered table-highlight">
            <thead>
                <tr>
                    <th width="5%">#</th>
                    <th>Warna Unit</th>
                    <th width="20%">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = mysql_query("select * from ref_color");
                $no = 1;
                while ($result = mysql_fetch_array($query)) {
                    echo"<tr>
                        <td>$no</td>                                                    
                            <td>$result[name]</td>
                        <td>
                            <a href='index.php?r=color&page=edit&id=$result[id_color]' title='Edit' class='btn btn-inverse'><i class='icon-edit'></i> Edit</a>
                            <a href='module/color/delete.php?id=$result[id_color]' title='Delete' onClick=\"return confirm ('Are you sure?')\" class='btn btn-danger'><i class='icon-remove'></i> Delete</a>
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
                $('#color').dataTable({
                    "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]]
                });
            });
        </script>
        <?php
    } elseif ($page == 'create') {
        ?>
        <h2>Tambah Data</h2>
        <form action="module/color/input.proses.php" method="POST" class="form-horizontal" id="create">

            <div class="control-group">
                <br/>
                <label class="control-label">Nama Unit *</label>
                <div class="controls">
                    <input unit="text" class="span4" id="name" name="name" value="">
                </div>
            </div>

            <div class="form-actions">
                <button unit="submit" class="btn btn-primary btn-small" >Simpan</button>
                <button class="btn btn-small btn-tertiary" id="" type="button" onclick="document.location = 'index.php?r=color&page=view';" >Batal</button>
                <!--<button class="btn btn-small btn-tertiary" id="" unit="button" onclick="document.location = 'index.php?r=color&page=view';" >Batal</button>--> 

            </div>
        </form>
        <?php
    } elseif ($page == 'edit') {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $query_edit = mysql_query("select * from ref_color where id_color='$id'");
            $a = mysql_fetch_array($query_edit);
            ?>
            <h2>Edit Data</h2>
            <form action="module/color/edit.proses.php" method="POST" class="form-horizontal" id="create">

                <div class="control-group">
                    <label class="control-label">Warna *</label>
                    <div class="controls">
                        <input type="text" class="span4" id="name" name="name" value="<?php echo $a['name']; ?>">
                        <input type="hidden" class="span4" id="id" name="id_color" value="<?php echo $a['id_color']; ?>">
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary btn-small" >Simpan</button>
                    <button class="btn btn-small btn-tertiary" id="" type="button" onclick="document.location = 'index.php?r=color&page=view';" >Batal</button> 

                </div>
            </form>
            <?php
        }
    }
}