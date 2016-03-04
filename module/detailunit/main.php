<script src="module/detailunit/main.js"></script>
<?php
// include"conf/connect.php";
// include"conf/fungsi_indotgl.php";
// include"conf/library.php";
// include"conf/pengkodean.php";

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
        <p><button onClick="document.location = 'index.php?r=detailunit&page=create';" class="btn btn-warning"><i class="icon-plus-sign icon-white"></i> Tambah</button></p>

        <table id="detailunit" class="contents table table-bordered table-highlight table-striped">
            <thead>
                <tr>
                    <th width="5%">#</th>
                    <th>Nama Unit</th>
                    <th width="25%" style="text-align: center">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = mysql_query("SELECT du.*,u.* FROM tb_unit u INNER JOIN tb_detail_unit du ON du.id_unit = u.id GROUP BY u.id");
                $total = mysql_num_rows($query);

                $no = 1;
                while ($result = mysql_fetch_array($query)) {
                    ?>
                    <tr>
                        <td style="text-align: center;"><?php echo $no; ?></td>                                                    
                        <td><?php echo $result['name']; ?></td>
                        <?php
                        echo "<td>
                                <a href='#myModal" . $no . "' title='Show Detail' data-toggle='modal' id='id_unit' value='$result[id]' class='btn'><i class='icon-eye-open'></i> Detail</a>
                                <a href='index.php?r=detailunit&page=edit&id=$result[id]' title='Edit' class='btn btn-inverse'><i class='icon-edit'></i> Edit</a>
                                <a href='module/detailunit/delete.php?id=$result[id]' title='Delete' onClick=\"return confirm ('Are you sure?')\" class='btn btn-danger'><i class='icon-remove'></i> Delete</a>
                              </td>";
                        $no++;
                    }
                    ?>
                </tr>
            </tbody>
        </table>
        <script src="js/jquery-1.7.2.min.js"></script> 
        <script src="js/jquery.dataTables.js"></script>
        <script>
            $(document).ready(function() {
                $('#detailunit').dataTable({
                    "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]]
                });
            });
        </script>
        <?php
        $nom = 1;
        $query2 = mysql_query("SELECT du.*,u.* FROM tb_unit u INNER JOIN tb_detail_unit du ON du.id_unit = u.id GROUP BY u.id");
        while ($result2 = mysql_fetch_array($query2)) {
            ?>
                            <!--<script src="module/detailunit/modal_bootstrap.js"></script>-->
            <script type="text/javascript">
                $('#myModal<?php echo $no; ?>').on('show', function(event) {
                    var id_unit = document.getElementById('id').value;
                });
            </script>
            <!-- Modal -->
            <style type="text/css">
                .modal{
                    left:45%;
                }
            </style>
            <div id="myModal<?php echo $nom; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 id="myModalLabel">Detail Unit</h4>
                </div>
                <div class="modal-body">
                    <!--<p>One fine body…</p>-->
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr style="background-color:#ddd; color: black;">
                                <th width="5%">#</th>
                                <th>Warna</th>
                                <th>No. Rangka</th>
                                <th>No. Mesin</th>
                                <th>Tahun</th>
                                <th>Harga Kosongan</th>
                                <th>Plafon BBn</th>
                                <th>Harga OTR</th>
                                <!--<th>Harga Beli</th>-->
                            </tr>
                        </thead>
                        <tbody id="dataunit">
                            <?php
                            $getDetail = mysql_query("SELECT du.no_rangka, du.no_mesin,du.tahun,du.id_color, du.id_unit, c.name as warna, u.* FROM tb_unit u 
                                                    inner join tb_detail_unit du on du.id_unit = u.id
                                                    inner join ref_color c on c.id_color = du.id_color
                                                WHERE u.id = '" . $result2['id'] . "'");
                            $nomor = 1;
                            while ($row1 = mysql_fetch_array($getDetail)) {
                                echo"<tr>
                                        <td>$nomor</td>
                                        <td>$row1[warna]</td>
                                        <td>$row1[no_rangka]</td>
                                        <td>$row1[no_mesin]</td>
                                        <td>$row1[tahun]</td>
                                        <td style='text-align: right;'>" . rupiah($row1['hargakosongan']) . "</td>
                                        <td style='text-align: right;'>" . rupiah($row1['plafonbbn']) . "</td>
                                        <td style='text-align: right;'>" . rupiah($row1['hargaotr']) . "</td>
                                     </tr>";
                                $nomor++;
                            }
                            ?>
                        </tbody> 
                    </table>
                </div>
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                </div>
            </div>
            <?php
            $nom++;
        }

//        $jmldata = mysql_num_rows(mysql_query("SELECT du.*,u.* FROM tb_unit u INNER JOIN tb_detail_unit du ON du.id_unit = u.id GROUP BY u.id"));
//        $jmlhalaman = $p->jumlahHalaman($jmldata, $batas);
//        $linkHalaman = $p->navHalaman($_GET['halaman'], $jmlhalaman);
//        echo "<div class='pagination pagination-centered' id=paging>$linkHalaman</div><br>";
    } elseif ($page == 'create') {
        ?>
        <h2>Tambah Data</h2>
        <script src="module/detailunit/main.js"></script>
        <form action="module/detailunit/input.proses.php" method="POST" name="create" class="form-horizontal" id="create">
            <div class="row">
                <div class="span7">
                    <div class="control-group">
                        <label class="control-label">Nama Unit *</label>
                        <div class="controls">
                            <select name="nama_unit" id="nama_unit" class="input-large">
                                <?php
                                $query = mysql_query("select * from tb_unit order by name");
                                while ($row = mysql_fetch_array($query)) {
                                    $base64 = base64_encode(implode('||', array($row['id'], $row['name'], $row['hargakosongan'], $row['plafonbbn'], $row['hargaotr'])));
                                    echo"<option value='$base64'>$row[name]</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Warna *</label>
                        <div class="controls">
                            <select name="productId" id="productId" class="input-large">
                                <?php
                                $query = mysql_query("select * from ref_color order by name");
                                while ($row = mysql_fetch_array($query)) {
                                    $base64 = base64_encode(implode('||', array($row['id_color'], $row['name'])));
                                    echo"<option value='$base64'>$row[name]</option>";
                                }
                                ?>
                            </select>
                            <button class="btn btn-small" id="add" type="button" >Tambah List</button> 
                            <button class="btn btn-small" id="delete" type="button" >Hapus List</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="well" style="max-height: auto; overflow: auto;">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Warna</th>
                            <th>No Rangka</th>
                            <th>No Mesin</th>
                            <th>Tahun</th>
                            <th>Harga Kosongan Unit</th>
                            <th>Plafon BBN</th>
                            <th>Harga OTR Unit</th>
                            <!--<th>Harga Beli</th>-->
                        </tr>
                    </thead>
                    <tbody id="addProduct">
                        <tr><td colspan="9" align='center'>Tidak  ada data yang dimasukkan.</td></tr>                        
                    </tbody>
                </table>
            </div>
            <div class="form-actions">
                <button type="submit" name="save" class="btn btn-primary btn-small" >Simpan</button>
                <button class="btn btn-small btn-tertiary" id="" type="button" onclick="window.location.href = 'index.php?r=detailunit&page=view';" >Batal</button> 
            </div>
        </form>
        <?php
    } elseif ($page == 'edit') {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $query_edit = mysql_query("SELECT u.id, u.name as unit, c.id_color,du.id_detail_unit
                                        FROM tb_unit u 
                                        INNER JOIN tb_detail_unit du ON du.id_unit = u.id
                                        INNER JOIN ref_color c ON c.id_color = du.id_color
                                        WHERE u.id ='$id'");
            $a = mysql_fetch_array($query_edit);
            ?>
            <h2>Edit Data</h2>
            <script src="module/detailunit/main_edit.js"></script>
            <form action="module/detailunit/edit.proses.php" method="POST" name="edit" class="form-horizontal" id="edit">
                <div class="row">
                    <div class="span7">
                        <div class="control-group">
                            <label class="control-label">Nama Unit *</label>
                            <div class="controls">
                                <select name="nama_unit" id="nama_unit" class="input-large" disabled="">
                                    <?php
                                    $query = mysql_query("select * from tb_unit order by name");
                                    while ($row = mysql_fetch_array($query)) {
                                        if ($a['id'] == $row['id']) {
                                            $base64 = base64_encode(implode('||', array($row['id'], $row['name'], $row['hargakosongan'], $row['plafonbbn'], $row['hargaotr'])));
                                            echo"<option value='$base64' selected>$row[name]</option>";
                                        } else {
                                            $base64 = base64_encode(implode('||', array($row['id'], $row['name'], $row['hargakosongan'], $row['plafonbbn'], $row['hargaotr'])));
                                            echo"<option value='$base64'>$row[name]</option>";
                                        }
                                    }
                                    ?>
                                </select>
                                <input type="hidden" class="span2" id="id_detailunit" name="id_detail_unit" value="<?php echo $a['id_detail_unit']; ?>">
                                <input type="hidden" class="span2" id="name_unit" name="name_unit" value="<?php echo $a['unit']; ?>">                           
                                <input type="hidden" class="span2" id="id_unit" name="id_unit" value="<?php echo $a['id']; ?>">                           
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Warna *</label>
                            <div class="controls">
                                <select name="productId" id="productId" class="input-large">
                                    <?php
                                    $query = mysql_query("select * from ref_color order by name");
                                    while ($row = mysql_fetch_array($query)) {
                                        if ($a['id_color'] == $row['id_color']) {
                                            $base64 = base64_encode(implode('||', array($row['id_color'], $row['name'])));
                                            echo"<option value='$base64' selected>$row[name]</option>";
                                        } else {
                                            $base64 = base64_encode(implode('||', array($row['id_color'], $row['name'])));
                                            echo"<option value='$base64'>$row[name]</option>";
                                        }
                                    }
                                    ?>
                                </select>
                                <button class="btn btn-small" id="addEdit" type="button" >Tambah List</button> 
                                <button class="btn btn-small" id="deleteEdit" type="button" >Hapus List</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="well" style="max-height: auto; overflow: auto;">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Warna</th>
                                <th>No Rangka</th>
                                <th>No Mesin</th>
                                <th>Tahun</th>
                                <th>Harga Kosongan Unit</th>
                                <th>Plafon BBN</th>
                                <th>Harga OTR Unit</th>
                                <!--<th>Harga Beli</th>-->
                            </tr>
                        </thead>
                        <tbody id="addProductEdit">
                            <?php
                            $edit2 = mysql_query("SELECT u.id, du.no_rangka, du.id_detail_unit as detailunit, du.no_mesin, 
                                                    du.tahun, u.id,u.name as nama_unit, u.hargakosongan, u.plafonbbn, u.hargaotr, 
                                                    c.id_color,c.name as warna
                                                    FROM tb_detail_unit du 
                                                    inner join tb_unit u on u.id = du.id_unit
                                                    inner join ref_color c on c.id_color = du.id_color
                                                WHERE u.id ='$id'");
                            $jumlah_detil = mysql_num_rows($edit2);

                            if ($jumlah_detil > 0) {
                                $number = 0;
                                while ($result_detil = mysql_fetch_array($edit2)) {
                                    ?><tr>
                                        <td><input type='checkbox' name='detailunit' id='editCheck_<?php echo $result_detil['detailunit']; ?>' value='<?php echo $result_detil['detailunit']; ?>'/></td>
                                        <td><label><?php echo $result_detil['warna']; ?></label>
                                            <input name='master[edit][<?php echo $number; ?>][warna]' id='colors' type='hidden' value='<?php echo $result_detil['id_color']; ?>' />
                                            <input name='master[edit][<?php echo $number; ?>][iddetailunit]' id='iddetailpenjualan_<?php echo $result_detil['id']; ?>' type='hidden' value='<?php echo $result_detil['detailunit']; ?>' />
                                        <td><input name="master[edit][<?php echo $number; ?>][norangka]" id='no_rangka_<?php echo $result_detil['id']; ?>' type='text' class='span2' value='<?php echo $result_detil['no_rangka']; ?>' /></td>
                                        <td><input name="master[edit][<?php echo $number; ?>][nomesin]" id='no_mesin_<?php echo $result_detil['id']; ?>' type='text' class='span2' value='<?php echo $result_detil['no_mesin']; ?>' /></td>
                                        <td><input name="master[edit][<?php echo $number; ?>][tahun]" id='tahun_<?php echo $result_detil['id']; ?>' type='text' class='span1' value='<?php echo $result_detil['tahun']; ?>' /></td>
                                        <td><div class="input-prepend"><span class="add-on">Rp</span><input name="master[edit][<?php echo $number; ?>][hargakosongan]" id="hargakosongan_<?php echo $result_detil['id']; ?>" type="text" class="span2" value="<?php echo $result_detil['hargakosongan']; ?>" style="text-align:right;" readonly/></div></td>
                                        <td><div class="input-prepend"><span class="add-on">Rp</span><input name="master[edit][<?php echo $number; ?>][plafonbbn]" id="plafonbbn_<?php echo $result_detil['id']; ?>" type="text" class="span2" value="<?php echo $result_detil['plafonbbn']; ?>" style="text-align:right;" readonly/></div></td>
                                        <td><div class="input-prepend"><span class="add-on">Rp</span><input name="master[edit][<?php echo $number; ?>][hargaotr]" id="hargaotr_<?php echo $result_detil['id']; ?>" type="text" class="span2 txt" value="<?php echo $result_detil['hargaotr']; ?>" style="text-align:right;" readonly/></div></td>
                                    </tr>
                                    <?php
                                    $number++;
                                }
                            } else {
                                echo"<tr><td colspan='5'>Data kosong</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="form-actions">
                    <input name='jmldetailunit' type='hidden' value="" id="" />                                            
                    <button type="submit" name="save" class="btn btn-primary btn-small" >Simpan</button>
                    <button class="btn btn-small btn-tertiary" id="" type="button" onclick="window.location.href = 'index.php?r=detailunit&page=view';" >Batal</button> 
                </div>
            </form>
            <?php
        }
    }
}