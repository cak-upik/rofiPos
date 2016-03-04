<script src="module/penjualan/main.js"></script>
<?php
    if(isset($_GET['status'])){
        if($_GET['status'] == 'sukses'){
            ?>
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <label class="success">Data berhasil disimpan</label>                
            </div>
            <?php
        }
        elseif($_GET['status'] == 'deleted'){
            ?>
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <label>Data berhasil dihapus</label>                
            </div>
            <?php
        }
        elseif($_GET['status'] == 'edited'){
            ?>
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <label>Data berhasil diubah</label>                
            </div>
            <?php
        }
        elseif($_GET['status'] == 'wrong'){
            ?>
            <div class="alert alert-error">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <label>Maaf data yang anda cari tidak ditemukan</label>                
            </div>
            <?php
        }
        elseif($_GET['status'] == 'gagal'){
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
if (isset($_GET['page'])){
    $page=$_GET['page'];
    if($page == 'view'){
        ?>
        <div class="well-small">
            <div class="btn-group">
                <a class="btn dropdown-toggle btn-tertiary" data-toggle="dropdown" href="#">
                    Action <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <li><a tabindex="-1" href="index.php?r=penjualan&page=create">Tambah</a></li>
                </ul>
            </div>
        </div>
                <br/>
                       <table class="table table-bordered table-striped table-highlight">
                            <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th>Nama</th>
                                    <th>Tipe Unit</th>
                                    <th>Leasing</th>
                                    <th>Tanggal</th>
                                    <th>Harga</th>
                                    <th>Uang Muka</th>
                                    <th>Diskon</th>
                                    <th>Kuantitas</th>
                                    <th>Total Nett</th>
									<th colspan="3" width="5%">&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $p      = new Paging;
                                    $batas  = 15;
                                    $posisi = $p->cariPosisi($batas);
                                    
                                    $query=  mysql_query("SELECT tp.id as id,
														tp.`name` as Nama,
														tu.`name` as Nama_Unit,
														ls.`name` as Leasing,
														tp.date as Tanggal,
														tp.price as Harga_Jual,
														tp.kuantiti as Qty,
														tp.uangmuka as Uang_Muka,
														tp.disc as Diskon,
														tp.nett as Total_Nett
														FROM tb_penjualan tp
														INNER JOIN tb_unit tu
														ON tp.id = tu.id
														INNER JOIN ref_leasing ls
														ON ls.id = tp.ref_leasing_id	
                                        order by id LIMIT $posisi,$batas");
                                    $total=  mysql_num_rows($query);

                                    if($total > 0){
                                        $no=$posisi+1;
                                        while($result=  mysql_fetch_array($query)){
                                            echo"<tr>
                                                    <td>$no</td>
                                                    <td>$result[Nama]</td>
													<td>$result[Nama_Unit]</td>
													<td>$result[Leasing]</td>
                                                    <td>".tgl_indo($result['Tanggal'])."</td>
                                                    <td style='text-align:right;'>Rp. ".number_format( $result['Harga_Jual'] , 2 , '.' , ',' )."</td>
													<td style='text-align:right;'>Rp. ".number_format( $result['Uang_Muka'] , 2 , '.' , ',' )."</td>
													<td style='text-align:right;'>Rp. ".number_format( $result['Diskon'] , 2 , '.' , ',' )."</td>
													<td>$result[Qty]</td>
                                                    <td style='text-align:right;'>Rp. ".number_format( $result['Total_Nett'] , 2 , '.' , ',' )."</td>
													<td>
                                                        <a href='index.php?r=penjualan&page=create&id=$result[id]' title='Isi/Tambah penjualan'><i class='icon-plus'></i></a>
                                                    </td>
                                                    <td>
                                                        <a href='index.php?r=penjualan&page=edit&id=$result[id]' title='Edit'><i class='icon-edit'></i></a>
                                                    </td>
                                                    <td>
                                                        <a href='module/penjualan/delete.php?id=$result[id]' title='Delete'><i class='icon-remove'></i></a>
                                                    </td>
                                                 </tr>";
                                            $no++;
                                        }                    
                                    }else echo"<tr><td colspan='7'><label>Data Tidak Ditemukan</label></td></tr>";
                                 ?>
                            </tbody>
                        </table>
    <?php 
                        $jmldata=mysql_num_rows(mysql_query("select * from tb_penjualan"));
                        $jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);
                        $linkHalaman = $p->navHalaman($_GET['halaman'], $jmlhalaman);
                        echo "<div class='pagination pagination-centered' id=paging>$linkHalaman</div><br>";
    }
    elseif ($page == 'create') {
        ?>
        
        <form action="module/penjualan/input.proses.php" method="POST" class="form-horizontal" id="create">
            <div class="control-group" >
                <?php
                $kode = notaNumber();
                ?>
                <label class="pull-right">Tanggal :
                    <input type="text" class="span2" id="tanggal" name="tanggal" value="<?php $tglw = tgl_indo($tgl_sekarang);
                echo $tglw; ?>" readonly></label>
                <label class=""></label>
                <label class="control-label">Nomor penjualan :</label>
                <div class="controls">
                    <input type="text" class="span2" id="no_beli" name="no_beli" value="<?php echo $kode; ?>" readonly ></label>
                </div>
            </div>
<!--
            <div class="control-group">
                <label class="control-label">Plat No Kendaraan *</label>
                <div class="controls">
                    <input type="text" class="span4" id="nopol" name="nopol" value="">
                    <input type="hidden" class="span4" id="id_pegawai" name="id_pegawai" value="<?php echo $id_pegawai; ?>">
                </div>
            </div>
            <div class="well" style="max-height: 250px; overflow: auto;">
                <div id="detailPelanggan">

                </div>
            </div>
            <br/>
            <div class="control-group">
                <label class="control-label">Status</label>
                <div class="controls">
                    <label class="radio">
                        <input type="radio" name="status" id="validateRadio1" value="OPEN" checked>
                        OPEN
                    </label>
                    <label class="radio">
                        <input type="radio" name="status" id="validateRadio2" value="CLOSE" >
                        CLOSE
                    </label>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Keluhan</label>
                <div class="controls">
                    <textarea name="keluhan" id="keluhan" class="span8" row="5"></textarea>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Catatan</label>
                <div class="controls">
                    <textarea name="catatan" id="catatan" class="span8" row="5"></textarea>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Mekanik *</label>
                <div class="controls">
                    <select name="id_mekanik" id="id_mekanik"   class="input-large">
                        <?php
                       // $qMekanik = mysql_query("select * from tb_pegawai where id_jabatan='1' order by nama");
                        //while ($row = mysql_fetch_array($qMekanik)) {
                          //  echo"<option value='$row[id_pegawai]'>$row[nama]</option>";
                        //}
                        ?>
                    </select>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Jenis Service</label>
                <div class="controls">
                    <label class="radio inline">
                        <input type="radio" name="jenser" id="jenser1" value="Satuan">
                        Satuan
                    </label>
                    <label class="radio inline">
                        <input type="radio" name="jenser" id="jenser2" value="Paket">
                        Paket
                    </label>

                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Pekerjaan</label>
                <div class="controls">
                    <select name="pekerjaan" id="pekerjaan"  class="input-large">
                        <option value="">Pilih</option>-->
                        <?php
                        /*
                          $qKerja=  mysql_query("select * from tb_jenis_pekerjaan a
                          inner join tb_kategori_pekerjaan b on a.id_kategori_pekerjaan=b.id_kategori_pekerjaan");
                          while ($rKerja = mysql_fetch_array($qKerja)) {
                          $base64=base64_encode(implode('||', array($rKerja['id_jenis_pekerjaan'],$rKerja['jenis_pekerjaan'], $rKerja['tarif_kerja'])));
                          echo"<option value='$base64'>$rKerja[jenis_pekerjaan]</option>";
                          }
                         * 
                         */
                        ?>
<!--                    </select>
                    <button class="btn btn-mini" id="addWork" type="button" ><i class="icon-plus" style="margin-top: 3px;"></i></button> 
                    <button class="btn btn-mini" id="deleteWork" type="button" ><i class="icon-minus" style="margin-top: 3px;"></i></button>
                </div>
                <br/>
                <div class="well" style="max-height: 250px; overflow: auto;">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th style="width: 3%;">#</th>
                                <th>Pekerjaan</th>
                                <th>Tarif Pekerjaan</th>
                            </tr>
                        </thead>
                        <tbody id="detailPekerjaan">
                            <tr><td colspan="2" class="sys_align_center">Belum ada data yang dimasukkan</td></tr>

                        </tbody>
                        <tr id="jmlOngkosPekerjaan">
                            <td colspan="2" style="text-align: right;"><b>Total : </b></td>
                            <td><input class="span2" type="text" name="jmlPekerjaan" id="jmlPekerjaan" readonly></td>
                        </tr>
                    </table>
                </div>
            </div>-->

            <div class="control-group">
            
                <label class="control-label">Penjualan Unit</label>
                <div class="controls">
                    <select name="penjualan" id="penjualan" class="input-large">
                        <?php
//                        $qPenjualan = mysql_query("select a.*, b.*, c.nama_type from tb_penjualan a 
//                                                            inner join tb_stok b on a.id_penjualan=b.id_penjualan 
//                                                            inner join tb_type_motor c on a.id_type_motor=c.id_type_motor
//                                                    where jumlah_stok > 0 order by nama_penjualan");
                    //    $qPenjualan = mysql_query("SELECT tu.id 'id_penjualan', tu.name as nama_item, tu.hargaKosongan, tu.plafonBbn, tu.hargaOtr FROM tb_penjualan tu INNER JOIN tb_penjualan as tp ON tp.id = tu.id");
                      //  while ($rPenjualan = mysql_fetch_array($qPenjualan)) {
                        //    $base642 = base64_encode(implode('||', array($rPenjualan['id_penjualan'], $rPenjualan['nama_item'], $rPenjualan['hargaKosongan'])));
                          //  echo"<option value='$base642'>[$rPenjualan[id_penjualan]] $rPenjualan[nama_item] ($rPenjualan[hargaKosongan])</option>";
                       // }
					   
					   $qPenjualan = mysql_query("SELECT tu.id 'id_penjualan', tu.name as nama_item, tu.hargaKosongan, tu.plafonBbn, tu.hargaOtr FROM tb_unit tu INNER JOIN tb_penjualan as tp ON tp.id = tu.id");
                        while ($rPenjualan = mysql_fetch_array($qPenjualan)) {
                            $base642 = base64_encode(implode('||', array($rPenjualan['nama_item'])));
                            echo"<option value='$base642'>$rPenjualan[nama_item]</option>";
                        }
                        ?>
                    </select>
                    <button class="btn btn-mini" id="addPro" type="button" ><i class="icon-plus" style="margin-top: 3px;"></i></button> 
                    <button class="btn btn-mini" id="deletePro" type="button" ><i class="icon-minus" style="margin-top: 3px;"></i></button>
                </div>
                <br/>
                <div class="well" style="max-height: 250px; overflow: auto;">               
                       <table class="table table-bordered table-striped table-highlight">
                                <thead>
                                     <tr>
                                    <th width="5%">#</th>
                                    <th>Nama Supplier</th>
                                    <th>Tanggal Beli</th>
                                    <th>Nama penjualan</th>
                                    <th>No Rangka penjualan</th>
                                    <th>No Mesin penjualan</th>
                                    <th>Harga Beli</th>                                    
                                    <th>Kuantitas</th>
                                    <th>Jumlah</th>
                                </tr>
                                </thead>
                        <tbody id="detailpenjualan">
                            <tr><td colspan="8" class="sys_align_center">Belum ada data yang dimasukkan</td></tr>
                        </tbody>
                        <tr id="jmlJuapenjualan">
                            <td colspan="8" style="text-align: right;"><b>Total : </b></td>
                            <td><input class="span2" type="text" name="jmlpenjualan" id="jmlpenjualan" readonly></td>
                        </tr>
                    </table>
                </div>
            </div>

<!--            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th colspan="4">Perhitungan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Ongkos Kerja</td><td><input class="span2 jumlah" type="hidden" name="jmlPekerjaan2" id="jmlPekerjaan2"><label id='jmlPekerjaanLabel'></label></td>
                        <td rowspan='4' width='40%'>
                            Jumlah tagihan : <h2><label id='JumlahTotalLabel'></label></h2><br/>
                            Kembalian : <h2><label id='JumlahKembalianLabel'></label></h2>
                        </td>
                    </tr>
                    <tr><td>Biaya Parts</td><td><input class="span2 jumlah" type="hidden" name="jmlSparepart2" id="jmlSparepart2"><label id='jmlpenjualanLabel'></label></td></tr>
                    <tr><td>Total</td><td><input class="span2" type="hidden" name="totalSemua" id="totalSemua"><label id='totalSemuaLabel'></label></td></tr>
                    <tr><td>Setor Customer</td><td><input class="span2" type="text" name="setor" id="setor"></td></tr>
                </tbody>
            </table>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary btn-small" id="save">Simpan</button>
                <button class="btn btn-small btn-tertiary" id="" type="button" onclick="window.location.href = 'index.php?r=penjualan&page=view';" >Batal</button> 

            </div>-->
        </form>
        <?php
    } elseif ($page == 'edit') {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $query_edit = mysql_query("select * from tb_penjualan a 
                                    inner join tb_pelanggan b on a.id_pelanggan=b.id_pelanggan 
                                    inner join tb_pekerjaan c on a.id_penjualan=c.id_penjualan 
                                    inner join tb_type_motor d on b.id_type_motor=d.id_type_motor
                                    where a.id_penjualan='$id'");
            $row = mysql_fetch_array($query_edit);
            ?>
            <script src="module/penjualan/main_edit.js"></script>
            <form action="module/penjualan/edit.proses.php" method="POST" class="form-horizontal" id="creates">
                <div class="control-group" >
                    <label class="pull-right">Tanggal :
                        <input type="text" class="span2" id="tanggal" name="tanggal" value="<?php echo tgl_indo($row['tanggal']); ?>" readonly></label>
                    <label class=""></label>
                    <label class="control-label">Nomor Service :</label>
                    <div class="controls">
                        <input type="text" class="span2" id="nomor_penjualan" name="nomor_penjualan" value="<?php echo $row['nomor_penjualan']; ?>" readonly >
                        <input type="hidden" class="span2" id="id_penjualan" name="id_penjualan" value="<?php echo $id; ?>" readonly >
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Nomor Polisi :</label>
                    <div class="controls">
                        <input type="text" class="span2" id="nopol" name="nopol" value="<?php echo $row['nopol']; ?>" readonly ></label>
                    </div>

                </div>
                <div class="control-group">
                    <label class="control-label">Data Pemilik :</label>                        
                </div>
                <div class="well" style="max-height: 250px; overflow: auto;">
                    <div class="row">
                        <div class="span4">
                            <div class="control-group">
                                <label class="control-label"><b>Nama Pemilik</b></label>
                                <div class="controls">
                                    <label>: <?php echo $row['nama_pemilik']; ?></label>
                                    <input type="hidden" name="id_pelanggan" id="id_pelanggan" value="<?php echo $row['id_pelanggan']; ?>" >
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label"><b>Alamat</b></label>
                                <div class="controls">
                                    <label>: <?php echo $row['alamat_pemilik']; ?></label>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label"><b>No. Telepon</b></label>
                                <div class="controls">
                                    <label>: <?php echo $row['no_telp']; ?></label>
                                </div>
                            </div>
                        </div>
                        <div class="span4">
                            <div class="control-group">
                                <label class="control-label"><b>Tahun Pembuatan</b></label>
                                <div class="controls">
                                    <label>: <?php echo $row['th_pembuatan']; ?></label>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label"><b>Nomor Rangka</b></label>
                                <div class="controls">
                                    <label>: <?php echo $row['no_rangka']; ?></label>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label"><b>Nomor Mesin</b></label>
                                <div class="controls">
                                    <label>: <?php echo $row['no_mesin']; ?></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br/>
                <div class="control-group">
                    <label class="control-label">Status</label>
                    <div class="controls">
                        <?php
                        if ($row['status'] == 'OPEN') {
                            $open = "checked";
                            $close = "";
                        } else {
                            $open = "";
                            $close = "checked";
                        }
                        ?>
                        <label class="radio">
                            <input type="radio" name="status" id="validateRadio1" value="OPEN" <?php echo $open; ?>>
                            OPEN
                        </label>
                        <label class="radio">
                            <input type="radio" name="status" id="validateRadio2" value="CLOSE" <?php echo $close; ?>>
                            CLOSE
                        </label>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Keluhan</label>
                    <div class="controls">
                        <textarea name="keluhan" id="keluhan" class="span8" row="5"><?php echo $row['keluhan']; ?></textarea>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Catatan</label>
                    <div class="controls">
                        <textarea name="catatan" id="catatan" class="span8" row="5"><?php echo $row['catatan']; ?></textarea>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Mekanik *</label>
                    <div class="controls">
                        <select name="id_mekanik" id="id_mekanik"   class="input-large">
                            <?php
                            $qMekanik = mysql_query("select * from tb_pegawai where id_jabatan='1' order by nama");
                            while ($row2 = mysql_fetch_array($qMekanik)) {
                                if ($row['tb_pegawai'] == $row2['id_pegawai']) {
                                    echo"<option value='$row2[id_pegawai]' selected>$row2[nama]</option>";
                                }
                                else
                                    echo"<option value='$row2[id_pegawai]'>$row2[nama]</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Pekerjaan</label>
                    <?php
                    //if($row['keterangan'] == 'Satuan'){
                    ?>
                    <div class="controls">
                        <select name="pekerjaan" id="pekerjaan"  class="input-large">
                            <?php
                            $qKerja = mysql_query("select * from tb_jenis_pekerjaan order by jenis_pekerjaan");
                            while ($rKerja = mysql_fetch_array($qKerja)) {
                                $base64 = base64_encode(implode('||', array($rKerja['id_jenis_pekerjaan'], $rKerja['jenis_pekerjaan'], $rKerja['tarif_kerja'])));
                                echo"<option value='$base64'>$rKerja[jenis_pekerjaan]</option>";
                            }
                            ?>
                        </select>
                        <button class="btn btn-mini" id="addWork" type="button" ><i class="icon-plus" style="margin-top: 3px;"></i></button> 
                        <button class="btn btn-mini" id="deleteWork" type="button" ><i class="icon-minus" style="margin-top: 3px;"></i></button>
                    </div>

                    <?php
                    //}
                    ?>

                    <br/><br/>
                    <div class="well" style="max-height: 250px; overflow: auto;">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th style="width: 3%;">#</th>
                                    <th>Pekerjaan</th>
                                    <th>Tarif Pekerjaan</th>
                                </tr>
                            </thead>
                            <tbody id="detailPekerjaan">
                                <?php
                                if ($row['keterangan'] == 'Satuan') {
                                    $query_kerja = mysql_query("select a.id_penjualan, c.* from tb_penjualan a 
                                                                    inner join tb_detail_penjualan b on a.id_penjualan=b.id_penjualan 
                                                                    inner join tb_jenis_pekerjaan c on b.id_jenis_pekerjaan=c.id_jenis_pekerjaan 
                                                                    where a.id_penjualan='$id'");
                                    $jum = mysql_num_rows($query_kerja);
                                    if ($jum > 0) {
                                        $no = 1;
                                        while ($row1 = mysql_fetch_array($query_kerja)) {
                                            ?>
                                            <tr>
                                                <td><input type="checkbox" /></td>
                                                <td><input name="work[edit][<?php echo $no; ?>][jenis_pekerjaan]" type="text" class="span4" value="<?php echo $row1['jenis_pekerjaan']; ?>" readonly/>
                                                    <input name="work[edit][<?php echo $no; ?>][id_jenis_pekerjaan]" type="hidden" class="span4" value="<?php echo $row1['id_jenis_pekerjaan']; ?>" id="akses_<?php echo $row1['id_jenis_pekerjaan']; ?>"/></td>
                                                <td>
                                                    <input name="work[edit][<?php echo $no; ?>][tarif_kerja]" type="text" class="span4 txt2" value="<?php echo $row1['tarif_kerja']; ?>" readonly id="tarif_<?php echo $row1['id_jenis_pekerjaan']; ?>"/>
                                                    <input name="ongkos_kerja" type="hidden" class="span2" id="ongkos_kerja" value="<?php echo $row['ongkos_kerja']; ?>" readonly/>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    } else {
                                        ?>
                                        <tr><td colspan="2" class="sys_align_center">Belum ada data yang dimasukkan</td></tr>
                                        <?php
                                    }
                                } else {
                                    $parts = explode(' ', $row['keterangan']);
                                    $query_kerja = mysql_query("select * from tb_kategori_pekerjaan where nama_kategori='$parts[1]'");
                                    $jum = mysql_num_rows($query_kerja);
                                    $row1 = mysql_fetch_array($query_kerja);
                                    if ($jum > 0) {
                                        ?>
                                        <tr>
                                            <td><input type="checkbox" /></td>
                                            <td><input name="work[edit][<?php echo $no; ?>][jenis_pekerjaan]" type="text" class="span4" value="<?php echo $row1['nama_kategori']; ?>" readonly/>
                                                <input name="work[edit][<?php echo $no; ?>][id_jenis_pekerjaan]" type="hidden" class="span4" value="<?php echo $row1['id_kategori_pekerjaan']; ?>" id="akses_<?php echo $row1['id_kategori_pekerjaan']; ?>"/></td>
                                            <td>
                                                <input name="work[edit][<?php echo $no; ?>][tarif_kerja]" type="text" class="span4 txt2" value="<?php echo $row1['tarif_kerja']; ?>" readonly id="tarif_<?php echo $row1['id_kategori_pekerjaan']; ?>"/>
                                                <input name="ongkos_kerja" type="hidden" class="span2" id="ongkos_kerja" value="<?php echo $row['ongkos_kerja']; ?>" readonly/>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                                <?php ?>
                            </tbody>
                            <tr id="editJmlOngkosPekerjaan">
                                <td colspan="2" style="text-align: right;"><b>Total : </b></td>
                                <td><input class="span2" type="text" name="jmlPekerjaan" id="jmlPekerjaan" value="<?php echo $row['ongkos_kerja']; ?>" readonly ></td>
                            </tr>

                        </table>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Sparepart</label>
                    <div class="controls">
                        <select name="penjualan" id="penjualan"  class="input-large">
            <?php
            $qPenjualan = mysql_query("select * from tb_penjualan a inner join tb_stok b on a.id_penjualan=b.id_penjualan 
                                                    where jumlah_stok > 0 order by nama_penjualan");
            while ($rPenjualan = mysql_fetch_array($qPenjualan)) {
                $base642 = base64_encode(implode('||', array($rPenjualan['id_penjualan'], $rPenjualan['nama_penjualan'], $rPenjualan['harga_jual_satuan'])));
                echo"<option value='$base642'>$rPenjualan[nama_penjualan]</option>";
            }
            ?>
                        </select>
                        <button class="btn btn-mini" id="addPro" type="button" ><i class="icon-plus" style="margin-top: 3px;"></i></button> 
                        <button class="btn btn-mini" id="deletePro" type="button" ><i class="icon-minus" style="margin-top: 3px;"></i></button>
                    </div>
                    <br/>
                    <div class="well" style="max-height: 250px; overflow: auto;">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th style="width: 3%;">#</th>
                                    <th>Sparepart</th>
                                    <th>Harga Satuan</th>
                                    <th>Kuantitas</th>
                                    <th>Jumlah</th>
                                </tr>
                            </thead>
                            <tbody id="detailpenjualan">
            <?php
            $query_spare = mysql_query("select a.id_penjualan, a.biaya_penjualan, b.*, c.*, d.* from tb_penjualan a 
                                                                inner join tb_penjualan b on a.id_penjualan=b.id_penjualan 
                                                                inner join tb_penjualan c on b.id_penjualan =c.id_penjualan  
                                                                inner join tb_stok d on b.id_penjualan =d.id_penjualan 
                                                                where a.id_penjualan='$id'");
            $jum2 = mysql_num_rows($query_spare);
            if ($jum2 > 0) {
                $no2 = 1;
                while ($row2 = mysql_fetch_array($query_spare)) {
                    ?>
                                        <tr>
                                            <td><input type="checkbox" /></td>
                                            <td>
                                                <input name="penjualan[edit][<?php echo $no2; ?>][nama_penjualan]" type="text" class="span2" value="<?php echo $row2['nama_penjualan']; ?>" readonly/>
                                                <input name="penjualan[edit][<?php echo $no2; ?>][id_penjualan]" type="hidden" class="span2" value="<?php echo $row2['id_penjualan']; ?>" id="akses2_<?php echo $row2['id_penjualan']; ?>"/>
                                                <input name="penjualan[edit][<?php echo $no2; ?>][id_penjualan]" type="hidden" class="span2" value="<?php echo $row2['id_penjualan']; ?>" />
                                            </td>
                                            <td><input name="penjualan[edit][<?php echo $no2; ?>][harga_satuan]" type="text" class="span2" id="harga_<?php echo $row2['id_penjualan']; ?>" value="<?php echo $row2['harga_jual_satuan']; ?>" readonly/></td>
                                            <td><input name="penjualan[edit][<?php echo $no2; ?>][kuantitas]" type="text" class="span2" id="kuantitas_<?php echo $row2['id_penjualan']; ?>" value="<?php echo $row2['kuantitas']; ?>" onkeyup="autoComplete(<?php echo $row2['id_penjualan']; ?>);"/></td>
                                            <td>
                                                <input name="penjualan[edit][<?php echo $no2; ?>][jumlah]" type="text" class="span2 txt" id="jumlah_<?php echo $row2['id_penjualan']; ?>" value="<?php echo $row2['total_harga']; ?>" readonly/>
                                                <input name="biaya_penjualan" type="hidden" class="span2" id="biaya_penjualan" value="<?php echo $row['biaya_penjualan']; ?>" readonly/>
                                            </td>
                                        </tr>

                    <?php
                }
            } else {
                ?>
                                    <tr><td colspan="3" class="sys_align_center">Belum ada data yang dimasukkan</td></tr>
                                    <?php
                                }
                                ?>

                            </tbody>

                            <tr id="EditJmlJualSparepart">
                                <td colspan="4" style="text-align: right;"><b>Total : </b></td>
                                <td><input class="span2" type="text" name="jmlpenjualan" id="jmlpenjualan" value="<?php echo $row['biaya_penjualan']; ?>" readonly></td>
                            </tr>

                        </table>
                    </div>
                </div>

                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th colspan="4">Perhitungan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td>Ongkos Kerja</td>
                            <td><input class="span2" type="hidden" name="jmlPekerjaan2" id="jmlPekerjaan2"><label id='jmlPekerjaanLabel'></label></td>
                            <td rowspan='4' width='40%'>
                                Jumlah tagihan : <h2><label id='JumlahTotalLabel'></label></h2><br/>
                                Kembalian : <h2><label id='JumlahKembalianLabel'></label></h2>
                            </td>
                        </tr>
                        <tr><td>Biaya Parts</td><td><input class="span2" type="hidden" name="jmlSparepart2" id="jmlSparepart2"><label id='jmlpenjualanLabel'></label></td></tr>
                        <tr><td>Total</td><td><input class="span2" type="hidden" name="totalSemua" id="totalSemua"><label id='totalSemuaLabel'></label></td></tr>
                        <tr><td>Setor Customer</td><td><input class="span2" type="text" name="setor" id="setor"></td></tr>
                    </tbody>
                </table>
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary btn-small" id="save">Simpan</button>
                    <button class="btn btn-small btn-tertiary" id="" type="button" onclick="window.location.href = 'index.php?r=penjualan&page=view';" >Batal</button> 

                </div>
            </form>
            <?php
        }
    } elseif ($page == 'report') {
        ?>
        <script src="module/penjualan/main.js"></script>
        <form name="form" target="_blank" method="POST" action="module/penjualan/print.php?sub=laporan1">
            <div class="well-small">
        <?php
        combonamabln(1, 12, 'bln_filter', $bln_sekarang);
        combothn($thn_sekarang - 3, $thn_sekarang, 'thn_filter', $thn_sekarang);
        ?>
                <input type="submit" name="search" value="Cari" class="btn btn-warning">
            </div>
        </form>
        <div class="span12" style="margin: 0 auto; ">
            <center><img src="img/report.jpg" width="550px"></center>
        </div>
        <?php
    }
}
?>