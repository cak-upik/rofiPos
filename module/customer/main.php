<script src="module/customer/main.js"></script>
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
        <p><button onClick="document.location = 'index.php?r=customer&page=create';" class="btn btn-warning"><i class="icon-plus-sign icon-white"></i> Tambah</button></p>

        <table id="customer" class="table table-bordered table-striped table-highlight">
            <thead>
                <tr>
                    <th width="5%">#</th>
                    <th>Nama Customer</th>
                    <th>Alamat</th>
                    <th>Nomor Telepon</th>
                    <th>No KTP</th>
                    <!--<th>Tempat Lahir</th>
                    <th>Tanggal Lahir</th>-->
                    <th>Pekerjaan</th>
                    <th width="45%">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = mysql_query("select * from ref_customer");
                
                    $no = 1;
                    while ($result = mysql_fetch_array($query)) {
                        $born = date('d-m-Y', $result['tanggal_lahir']);
                        echo"<tr>
                        <td>$no</td>
                        <td>$result[name]</td>
                        <td>$result[alamat]</td>
                        <td>$result[phone]</td>
                        <td>$result[no_ktp]</td>
                        <td>$result[pekerjaan]</td>
                        <td>
                            <a href='index.php?r=customer&page=edit&id=$result[id_customer]' title='Edit' class='btn btn-inverse'><i class='icon-edit'></i> Edit</a>
                            <a href='module/customer/delete.php?id=$result[id_customer]' title='Delete' onClick=\"return confirm ('Are you sure?')\" class='btn btn-danger'><i class='icon-remove'></i> Delete</a>
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
                $('#customer').dataTable({
                    "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]]
                });
            });
        </script>
        <?php
//        $jmldata = mysql_num_rows(mysql_query("select * from ref_customer"));
//        $jmlhalaman = $p->jumlahHalaman($jmldata, $batas);
//        $linkHalaman = $p->navHalaman($_GET['halaman'], $jmlhalaman);
//        echo "<div class='pagination pagination-centered' id=paging>$linkHalaman</div><br>";
    }
    elseif ($page == 'create') {
        ?>
        <h2>Tambah Data</h2>
        <form action="module/customer/input.proses.php" method="POST" class="form-horizontal" id="create">

            <div class="control-group">
                <br/>
                <label class="control-label">Nama Customer *</label>
                <div class="controls">
                    <input type="text" class="span4" id="name" name="name" value="">
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Alamat *</label>
                <div class="controls">
                    <input type="text" class="span4" id="alamat" name="alamat" value="">
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">No Telepon *</label>
                <div class="controls">
                    <input type="text" class="span4" id="phone" name="phone" value="">
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">No KTP *</label>
                <div class="controls">
                    <input type="text" class="span4" id="no_ktp" name="no_ktp" value="">
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Tempat, Tanggal Lahir *</label>
                <div class="controls">
                    <input type="text" class="span2" id="tempat_lahir" name="tempat_lahir" value="">, 
                    <input type="date" class="span2" id="tanggal_lahir" name="tanggal_lahir" value="">
                </div>
            </div>



            <div class="control-group">
                <label class="control-label">Pekerjaan *</label>
                <div class="controls">
                    <input type="text" class="span4" id="pekerjaan" name="pekerjaan" value="">
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary btn-small" >Simpan</button>
                <button class="btn btn-small btn-tertiary" id="" type="button" onclick="window.location.href = 'index.php?r=customer&page=view';" >Batal</button> 

            </div>
        </form>
        <?php
    } elseif ($page == 'edit') {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $query_edit = mysql_query("select * from ref_customer where id_customer='$id'");
            $a = mysql_fetch_array($query_edit);
            ?>
            <h2>Edit Data</h2>
            <form action="module/customer/edit.proses.php" method="POST" class="form-horizontal" id="create">

                <div class="control-group">
                    <br/>
                    <label class="control-label">Nama Customer *</label>
                    <div class="controls">
                        <input type="text" class="span4" id="name" name="name" value="<?php echo $a['name']; ?>">
                        <input type="hidden" class="span4" id="id_customer" name="id_customer" value="<?php echo $a['id_customer']; ?>">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Alamat *</label>
                    <div class="controls">
                        <input type="text" class="span4" id="alamat" name="alamat" value="<?php echo $a['alamat']; ?>">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">No Telepon *</label>
                    <div class="controls">
                        <input type="text" class="span4" id="phone" name="phone" value="<?php echo $a['phone']; ?>">
                    </div>
                </div>                            

                <div class="control-group">
                    <label class="control-label">No KTP *</label>
                    <div class="controls">
                        <input type="text" class="span4" id="no_ktp" name="no_ktp" value="<?php echo $a['no_ktp']; ?>">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Tempat, Tanggal Lahir *</label>
                    <div class="controls">
                        <input type="text" class="span2" id="tempat_lahir" name="tempat_lahir" value="<?php echo $a['tempat_lahir']; ?>">, 
                        <input type="date" class="span2" id="tanggal_lahir" name="tanggal_lahir" value="<?php echo $a['tanggal_lahir']; ?>">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Pekerjaan *</label>
                    <div class="controls">
                        <input type="text" class="span4" id="pekerjaan" name="pekerjaan" value="<?php echo $a['pekerjaan']; ?>">
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary btn-small" >Simpan</button>
                    <button class="btn btn-small btn-tertiary" id="" type="button" onclick="window.location.href = 'index.php?r=customer&page=view';" >Batal</button> 

                </div>
            </form>
            <?php
        }
    }
}
?>