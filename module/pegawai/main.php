<script src="module/pegawai/main.js"></script>
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
    } elseif ($_GET['status'] == 'gagal1') {
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
            Proses gagal 2, coba lagi!              
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
        <p><button onClick="document.location = 'index.php?r=pegawai&page=create';" class="btn btn-warning"><i class="icon-plus-sign icon-white"></i> Tambah</button></p>

        <table id="pegawai" class="table table-striped table-bordered table-highlight">
            <thead>
                <tr>
                    <th width="5%">#</th>
                    <th>Nama</th>
                    <th>Tempat</th>
                    <th>Tanggal Lahir</th>
                    <th>Alamat</th>
                    <th>Telp</th>
                    <th>Jabatan</th>
                    <th>Email</th>
                    <th>Username</th>
                    <th width="17%">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = mysql_query("select a.*, b.nama_jabatan from tb_pegawai a 
                                    inner join tb_jabatan b on a.id_jabatan=b.id_jabatan 
                                    order by nama");

                $no = 1;
                while ($result = mysql_fetch_array($query)) {
                    $pass = base64_decode($result['password']);
                    $born = date('d-m-Y', $result['tgl_lahir']);

                    echo"<tr>
                                <td>$no</td>
                                <td>$result[nama]</td>
                                <td>$result[tempat]</td>
                                <td>$born</td>
                                <td>$result[alamat]</td>
                                <td>$result[no_telp]</td>
                                <td>$result[nama_jabatan]</td>
                                <td>$result[email]</td>
                                <td>$result[username]</td>
                                <td>
                                    <a href='index.php?r=pegawai&page=edit&id=$result[id_pegawai]' title='Edit' class='btn btn-inverse'><i class='icon-edit'></i> Edit</a>
                                    <a href='module/pegawai/delete.php?id=$result[id_pegawai]' title='Delete' onClick=\"return confirm ('Are you sure?')\" class='btn btn-danger'><i class='icon-remove'></i> Delete</a>
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
                $('#pegawai').dataTable({
                    "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]]
                });
            });
        </script>
        <?php
//        $jmldata = mysql_num_rows(mysql_query("select * from tb_pegawai"));
//        $jmlhalaman = $p->jumlahHalaman($jmldata, $batas);
//        $linkHalaman = $p->navHalaman($_GET['halaman'], $jmlhalaman);
//        echo "<div id=paging>$linkHalaman</div><br>";
    } elseif ($page == 'create') {
        ?>
        <h2>Tambah Data</h2>
        <form action="module/pegawai/input.proses.php" method="POST" class="form-horizontal" id="create_pegawai" enctype="multipart/form-data">

            <div class="control-group">
                <br/>
                <label class="control-label">Nama *</label>
                <div class="controls">
                    <input type="text" class="span4" id="nama" name="nama" value="">
                    <input type="hidden" class="span4" id="id_pegawai" name="id_pegawai" value="<?php echo $id_pegawai; ?>">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Tempat, Tgl Lahir *</label>
                <div class="controls">
                    <input type="text" class="span2" id="tempat" name="tempat" value="">, 
                    <input type="date" class="span2" id="tgl_lahir" name="tgl_lahir" value="">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Alamat *</label>
                <div class="controls">
                    <textarea class="span4" id="alamat" name="alamat" ></textarea>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Jabatan *</label>
                <div class="controls">
                    <select name="id_jabatan" id="id_jabatan" class="input-large">
                        <option value="">-- Pilih --</option>
                        <?php
                        $q = mysql_query("select * from tb_jabatan order by nama_jabatan");
                        while ($row = mysql_fetch_array($q)) {
                            echo"<option value='$row[id_jabatan]'>$row[nama_jabatan]</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Nomor Telepon *</label>
                <div class="controls">
                    <input type="text" class="span4" id="no_telp" name="no_telp" value="">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Email</label>
                <div class="controls">
                    <input type="text" class="span4" id="email" name="email" value="">
                </div>
            </div>


            <br/>

            <div class="control-group">
                <label class="control-label">Username *</label>
                <div class="controls">
                    <input type="text" class="input-xlarge" id="username" name="username" >
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Password *</label>
                <div class="controls">
                    <input type="password" class="input-xlarge" id="password" name="password" >
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Ulangi Password</label>
                <div class="controls">
                    <input type="password" class="input-xlarge" id="cpwd" name="cpwd" >
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Foto</label>
                <div class="controls">
                    <input name="image" size="25" maxlength="512" type="file">
                </div>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary btn-small" >Simpan</button>
                <button class="btn btn-tertiary btn-small" id="" type="button" onclick="window.location.href = 'index.php?r=pegawai&page=view';" >Batal</button> 

            </div>
        </form>
        <?php
    } elseif ($page == 'edit') {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $query_edit = mysql_query("select * from tb_pegawai a inner join tb_jabatan b on a.id_jabatan=b.id_jabatan where a.id_pegawai='$id'");
            $a = mysql_fetch_array($query_edit);
            ?>
            <h2>Edit Data</h2>
            <form action="module/pegawai/edit.proses.php" method="POST" class="form-horizontal" id="create_pegawai" enctype="multipart/form-data">

                <div class="control-group">
                    <br/>
                    <label class="control-label">Nama *</label>
                    <div class="controls">
                        <input type="text" class="span4" id="nama" name="nama" value="<?php echo $a['nama']; ?>">
                        <input type="hidden" class="span4" id="id_pegawai" name="id_pegawai" value="<?php echo $a['id_pegawai']; ?>">
                        <input type="hidden" class="span4" id="pegawai" name="pegawai" value="<?php echo $id_pegawai; ?>">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Tempat, Tanggal Lahir *</label>
                    <div class="controls">
                        <input type="text" class="span2" id="tempat" name="tempat" value="<?php echo $a['tempat']; ?>">, 
                        <input type="date" class="span2" id="tgl_lahir" name="tgl_lahir" value="<?php echo $a['tgl_lahir']; ?>">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Alamat *</label>
                    <div class="controls">
                        <textarea class="span4" id="alamat" name="alamat" ><?php echo $a['alamat']; ?></textarea>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Jabatan *</label>
                    <div class="controls">
                        <select name="id_jabatan" id="id_jabatan" class="input-large">
                            <?php
                            $q = mysql_query("select * from tb_jabatan order by nama_jabatan");
                            while ($row = mysql_fetch_array($q)) {
                                if ($a['id_jabatan'] == $row['id_jabatan']) {
                                    echo"<option value='$row[id_jabatan]' selected>$row[nama_jabatan]</option>";
                                } else
                                    echo"<option value='$row[id_jabatan]'>$row[nama_jabatan]</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Nomor Telepon *</label>
                    <div class="controls">
                        <input type="text" class="span4" id="no_telp" name="no_telp" value="<?php echo $a['no_telp']; ?>">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Email</label>
                    <div class="controls">
                        <input type="text" class="span4" id="email" name="email" value="<?php echo $a['email']; ?>">
                    </div>
                </div>


                <br/>

                <div class="control-group">
                    <label class="control-label">Username *</label>
                    <div class="controls">
                        <input type="text" class="span4" id="username" name="username" value="<?php echo $a['username']; ?>">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Password *)</label>
                    <div class="controls">
                        <input type="password" class="input-xlarge" id="password" name="password" >
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Foto</label>
                    <div class="controls">
                        <input name="image" size="25" maxlength="512" type="file">
                    </div>
                </div>
                <div class="control-group">

                    <div class="controls">
                        <img src="module/pegawai/img/thumb_<?php echo $a['foto']; ?>" alt="" class="" />
                    </div>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary btn-small" >Simpan Perubahan</button>
                    <button class="btn btn-tertiary btn-small" id="" type="button" onclick="window.location.href = 'index.php?r=pegawai&page=view';" >Batal</button> 
                </div>
            </div>
            </form>
            <?php
        }
    }
}
?>