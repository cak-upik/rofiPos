<script src="module/hak_akses/main.js"></script>
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
//if (isset($_GET['page'])) {
//    $page = $_GET['page'];
//    if ($page == 'view') {
        ?>
        <!--        <p><button onClick="document.location = 'index.php?r=hak_akses&page=create';" class="btn btn-warning"><i class="icon-plus-sign icon-white"></i> Tambah</button></p>-->
        <div class="alert alert-info">
            <button id="btnTambah" class="btn btn-warning">Tambah</button>
        </div>

        <div id="frmTambah" style="display: none">
            <h2>Tambah Data</h2>
            <form action="module/hak_akses/input.proses.php" method="POST" class="form-horizontal" id="create">

                <div class="control-group">
                    <br/>
                    <label class="control-label">Hak Akses *</label>
                    <div class="controls">
                        <input type="text" class="span4" id="hak_akses" name="hak_akses" value="">
                    </div>
                </div>


                <div class="form-actions">
                    <input type="submit" class="btn btn-primary btn-large" value="Simpan" />

                </div>
            </form>
        </div>

        <div id="table-hakakses">
            <table id="hakakses" class="contents table table-bordered table-highlight table-striped">
                <thead>
                    <tr>
                        <th width="5%">#</th>
                        <th>Hak Akses</th>
                        <th width="20%" style="text-align: center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = mysql_query("select * from tb_hak_akses order by hak_akses");
                    $total = mysql_num_rows($query);

                    $no = $posisi + 1;
                    while ($result = mysql_fetch_array($query)) {
                        echo"<tr>
                            <td>$no</td>
                            <td>$result[hak_akses]</td>
                            <td style='text-align: center'>
                                <input type='hidden' id='id_hakses' value='<?php echo $result[id_hak_akses] ?>'>
                                <button id='btnEdit' class='btn btn-inverse'><i class='icon-edit'></i> Edit</button>
                                <a href='module/hak_akses/delete.php?id=$result[id_hak_akses]' title='Delete' onClick=\"return confirm ('Are you sure?')\" class='btn btn-danger'><i class='icon-remove'></i> Delete</a>
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
                        $('#hakakses').dataTable({
                            //lengthMenu : [[value], [label-value]] 
                            "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]]
                        });
                    });
                </script>
            </div>

            <?php
//        } elseif ($page == 'edit') {
//            if (isset($_GET['id'])) {
//                $id = $_GET['id'];
//                $query_edit = mysql_query("select * from tb_hak_akses where id_hak_akses='$id'");
//                $a = mysql_fetch_array($query_edit);
//                ?>
<!--                <h2>Edit Data</h2>
                <form action="module/hak_akses/edit.proses.php" method="POST" class="form-horizontal" id="create">
                    <div class="control-group">
                        <br/>
                        <label class="control-label">Hak Akses *</label>
                        <div class="controls">
                            <input type="text" class="span4" id="hak_akses" name="hak_akses" value="//<?php //echo $a['hak_akses']; ?>">
                            <input type="hidden" class="span4" id="id_hak_akses" name="id_hak_akses" value="//<?php //echo $a['id_hak_akses']; ?>">
                        </div>
                    </div>


                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary btn-small" >Simpan</button>
                        <button class="btn btn-small btn-tertiary" id="" type="button" onclick="window.location.href = 'index.php?r=hak_akses&page=view';" >Batal</button> 

                    </div>
                </form> -->
                <?php
//            }
//        }
//    }
    ?>