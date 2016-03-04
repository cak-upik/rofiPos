
<script src="module/retur/main.js"></script>
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
                            <li><a tabindex="-1" href="index.php?r=retur&page=create">Tambah</a></li>
                        </ul>
                    </div>
                </div>
                <br/>
                       <table class="table table-bordered table-striped table-highlight">
                            <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th>Nomor Retur</th>
                                    <th>Nomor PO</th>
                                    <th>Jumlah Tagihan</th>
                                    <th colspan="4" width="5%">&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody> 
                                <?php
                                    $p      = new Paging;
                                    $batas  = 15;
                                    $posisi = $p->cariPosisi($batas);
                                    
                                    $query=  mysql_query("select distinct a.nomor_retur, a.id_retur, c.id_pemesanan_stok, no_faktur ,
                                        a.jumlah_tagihan as a from tb_retur a 
                                        inner join tb_detail_retur b on a.id_retur=b.id_retur
                                        inner join tb_pemesanan_stok c on b.id_pemesanan_stok=c.id_pemesanan_stok 
                                        order by a.nomor_retur LIMIT $posisi,$batas");
                                    $total=  mysql_num_rows($query);

                                    if($total > 0){
                                        $no=$posisi+1;
                                        while($result=  mysql_fetch_array($query)){
                                            //$tgl=  tgl_indo($result['tanggal']);
                                            echo"<tr>
                                                    <td>$no</td>
                                                    <td>$result[nomor_retur]</td>
                                                    <td>$result[no_faktur]</td>
                                                    <td>Rp. ".number_format( $result['a'] , 2 , '.' , ',' )."</td>
                                                    <td>
                                                        <a href='#' title='Show Detail' class='trigger'><i class='icon-eye-open'></i></a>
                                                    </td>
                                                    <td>
                                                        <a href='index.php?r=retur&page=edit&id=$result[id_retur]' title='Edit'><i class='icon-edit'></i></a>
                                                    </td>
                                                    <td>
                                                        <a href='module/retur/delete.php?id=$result[id_retur]' title='Delete'><i class='icon-remove'></i></a>
                                                    </td>  
                                                    <td>
                                                        <a href='module/retur/main.php?r=retur&page=print&id=$result[id_retur]&author=$id_pegawai' title='Print' target='_blank'><i class='icon-print'></i></a>
                                                    </td>
                                                 </tr>";
												 echo"<tr class=\"details\" style='display:none;'>
                                                    <td colspan=\"8\">";
                                                    $getDetail=  mysql_query("select *, a.keterangan as ket_retur from tb_detail_retur a 
                                                                    inner join tb_sparepart b on a.id_sparepart=b.id_sparepart 
                                                                    where a.id_retur='$result[id_retur]'");
                                                    ?>
                                                    <table >
                                                    <thead>
                                                        <tr style="background-color:#ddd; color: black;">
                                                            <th width="5%">#</th>
                                                            <th>Kode Sparepart</th>
                                                            <th>Sparepart</th>
                                                            <th>Kuantitas</th>
                                                            <th>Keterangan</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            $no=1;
                                                             while ($row1 = mysql_fetch_array($getDetail)) {
                                                                 echo"<tr>
                                                                    <td>$no</td>
                                                                    <td>$row1[kode_sparepart]</td>
                                                                    <td>$row1[nama_sparepart]</td>
                                                                    <td>$row1[kuantitas]</td>
                                                                    <td>$row1[ket_retur]</td>
                                                                 </tr>";
                                                                 $no++;
                                                             }
                                                        ?>
                                                    </tbody> 
                                                    </table>
                                                    <?php
                                            echo"</td>
                                                 </tr>";
												 $no++;
                                            }
                                }else echo"<tr><td colspan='7'><label>Data Tidak Ditemukan</label></td></tr>";
                                            
                                           ?>
                                
                            </tbody>
                        </table>
    <?php 
                    $jmldata=mysql_num_rows(mysql_query("select * from tb_retur a 
                                        inner join tb_detail_retur b on a.id_retur=b.id_retur
                                        inner join tb_pemesanan_stok c on b.id_pemesanan_stok=c.id_pemesanan_stok "));
                        $jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);
                        $linkHalaman = $p->navHalaman($_GET['halaman'], $jmlhalaman);
                        echo "<div class='pagination pagination-centered' id=paging>$linkHalaman</div><br>";
    }
    elseif ($page == 'create') {
        ?>
        <h2>Tambah Data</h2>
        <form action="module/retur/input.proses.php" method="POST" class="form-horizontal" id="create">
                <?php
                    $kode= returNumber();
                ?>
                <div class="control-group">
                    <label class="control-label">Nomor Retur *</label>
                    <div class="controls">
                         <input type="text" class="span4" id="no_retur" name="no_retur" value="<?php echo $kode; ?>">
                         <input type="hidden" class="span4" id="id_pegawai" name="id_pegawai" value="<?php echo $id_pegawai; ?>">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Nomor Faktur *</label>
                    <div class="controls">
                            <select name="id_pemesanan_stok" id="id_pemesanan_stok"  class="input-large">
                                <option value="" selected>-- Pilih --</option>
                                <?php
                                    $suplier= mysql_query("select * from tb_pemesanan_stok where id_pemesanan_stok in 
                                        (select id_pemesanan_stok from tb_stok masuk )  and id_pemesanan_stok not in 
                                        (select distinct id_pemesanan_stok from tb_detail_retur) order by no_faktur  ");
                                    while ($a = mysql_fetch_array($suplier)) {
                                        echo"<option value='$a[id_pemesanan_stok]'>$a[no_faktur]</option>";
                                    }
                                ?>
                            </select>
                    </div>
                </div>
                <div class="control-group" >
                        <label class="control-label"> 
                            Sparepart
                        </label>
                        <div class="controls">
                            <select name="id_sparepart" id="id_sparepart"  class="input-large">
                            </select>


                            <button class="btn btn-small" id="addRetur" type="button" ><b>+</b></button> 
                            <button class="btn btn-small" id="deleteRetur" type="button" ><b>-</b></button>
                        </div>
                </div>
            <div class="well" style="max-height: 250px; overflow: auto;">
                <table class="table table-striped">
                            <thead>
                               <tr>
                                   <th>&nbsp;</th>
                                   <th>Kode Sparepart</th>
                                  <th>Nama Sparepart</th>
                                  <th>Harga Satuan</th>
                                  <th>Kuantitas</th>
                                  <th>Keterangan</th>
                               </tr>
                            </thead>
                            <tbody id="returProduct">
                                <tr><td colspan="6" align='center'>Tidak  ada data yang dimasukkan.</td></tr>
                            </tbody>
                </table>
            </div>
            <div class="form-actions">
                                <button type="submit" class="btn btn-primary btn-small" >Simpan</button>
                                <button class="btn btn-small btn-tertiary" id="" type="button" onclick="window.location.href='index.php?r=retur&page=view';" >Batal</button> 
                                
            </div>
        </form>
        <?php        
    }
    elseif ($page == 'edit') {
        if(isset($_GET['id'])){
            $id=$_GET['id'];
            $query_edit=  mysql_query("select distinct a.id_retur, a.nomor_retur, b.id_pemesanan_stok, c.no_faktur from tb_retur a 
                        inner join tb_detail_retur b on a.id_retur=b.id_retur 
                        inner join tb_pemesanan_stok c on b.id_pemesanan_stok=c.id_pemesanan_stok 
                        where a.id_retur='$id'");
            $a=  mysql_fetch_array($query_edit);
            ?>
                <h2>Edit Data</h2>
                
                <form action="module/retur/edit.proses.php" method="POST" class="form-horizontal" id="create">
                        <div class="control-group">
                            <label class="control-label">Nomor Retur</label>
                            <div class="controls">
                                 <input type="text" class="span4" id="nomor_retur" name="nomor_retur" value="<?php echo $a['nomor_retur']; ?>" readonly>
                                 <input type="hidden" class="span4" id="id_retur" name="id_retur" value="<?php echo $a['id_retur']; ?>">
                                 <input type="hidden" class="span4" id="id_pegawai" name="id_pegawai" value="<?php echo $id_pegawai; ?>">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Nomor Faktur *</label>
                            <div class="controls">
                                 <input type="text" class="span4" id="no_faktur" name="no_faktur" value="<?php echo $a['no_faktur']; ?>" readonly>
                                 <input type="hidden" class="span4" id="id_pemesanan_stok" name="id_pemesanan_stok" value="<?php echo $a['id_pemesanan_stok']; ?>">
                                 <input type="hidden" class="span4" id="jumlah_tagihan" name="jumlah_tagihan" value="<?php echo $a['jumlah_tagihan']; ?>">
                            </div>
                        </div>
                        <div class="control-group" >
                                <label class="control-label"> 
                                    Sparepart
                                </label>
                                <div class="controls">
                                    <select name="id_sparepart" id="id_sparepart" class="input-large">
                                        <?php
                                            $query=  mysql_query("select * from tb_detail_pemesanan_stok  a 
                                                        inner join tb_sparepart b on a.id_sparepart=b.id_sparepart 
                                                        where a.id_pemesanan_stok='$a[id_pemesanan_stok];'
                                                        order by nama_sparepart");
                                            while ($row = mysql_fetch_array($query)) {
                                               $base64=base64_encode(implode('||', array($row['id_sparepart'],$row['nama_sparepart'], $row['kode_sparepart'], $row['harga'])));
                                               echo"<option value='$base64'>$row[nama_sparepart] </option>";
                                            }
                                        ?>
                                    </select>

                                    <button class="btn btn-small" id="addEdit" type="button" ><b>+</b></button> 
                                    <button class="btn btn-small" id="deleteEdit" type="button" ><b>-</b></button>
                                </div>
                        </div>
                        <div class="well" style="max-height: 250px; overflow: auto;">
                        <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>&nbsp;</th>
                                            <th>Kode Sparepart</th>
                                           <th>Nama Sparepart</th>
                                           <th>Harga Satuan</th>
                                           <th>Kuantitas</th>
                                           <th>Keterangan</th>
                                        </tr>
                                     </thead>
                                    <tbody id="addProductEdit">
                                        <?php
                                            $edit2=  mysql_query("select t1.*, t2.*, t3.id_sparepart, t3.kode_sparepart, t3.nama_sparepart
                                                            from tb_retur t1 
                                                            inner join tb_detail_retur t2
                                                                on t1.id_retur=t2.id_retur 
                                                            inner join tb_sparepart t3 on t2.id_sparepart=t3.id_sparepart 
                                                            where t1.id_retur='$id'");
                                            $jumlah_detil=  mysql_num_rows($edit2);

                                            if($jumlah_detil > 0){
                                                $no=1;
                                                while($result_detil=  mysql_fetch_array($edit2)){
                                                    echo"<tr>
                                                            <td><input type='checkbox' id='editCheck_$result_detil[id_sparepart]' value='$result_detil[id_sparepart]'/></td>
                                                            <td><label>$result_detil[kode_sparepart]</label></div>
                                                            <td><label>$result_detil[nama_sparepart]</label>
                        <input name='retur[edit][$no][nama_sparepart]' type='hidden' value='$result_detil[nama_sparepart]' />
                        <input name='retur[edit][$no][id_sparepart]' type='hidden' value='$result_detil[id_sparepart]' id='akses2_$result_detil[id_sparepart]' /></td>
                                                            <td><input name=\"retur[edit][$no][harga]\" id='price_$result_detil[id_sparepart]' type='text' class='span2' value='$result_detil[harga]' readonly/></td>
                                                            <td><input name=\"retur[edit][$no][kuantitas]\" id='quantity_$result_detil[id_sparepart]' type=\"text\" class=\"span2\" value='$result_detil[kuantitas]'/></td>
                                                            <td><textarea name=\"retur[edit][$no][keterangan]\" id='remark_$result_detil[id_sparepart]' class=\"span2\" row=\"4\">$result_detil[keterangan]</textarea></td> 
                                                         </tr>";
                                                    $no++;
                                                }
                                            }
                                            else echo"<tr><td colspan='5'>Data kosong</td></tr>";
                                         ?>
                                    </tbody>
                        </table>
                    </div>

                    <div class="form-actions">
                                        <button type="submit" class="btn btn-primary btn-small" >Simpan</button>
                                        <button class="btn btn-small btn-tertiary" id="" type="button" onclick="window.location.href='index.php?r=retur&page=view';" >Batal</button> 

                    </div>
                </form>
                    
        <?php        
        }
    }
    elseif ($page == 'detail') {
        echo json_encode(array('row'=> '<tr class="toggle"><td colspan="8">tes
                        </td></tr>'));
    }
    elseif ($page == 'print') {
        ?>
             <style>
                .header{
                    margin: 0 auto; width: 800px; text-align: center;
                }
                .content{
                    width:800px; margin: 0 auto;
                    font-family: Arial; 
                }
                table{
                    border-collapse:collapse;
                }
                .table{


                            font-family: Arial; 
                            font-size: 13px;
                            }

                    .table th{
                        border:2px solid black;
                            text-align:center;
                            text-transform:capitalize;
                            }
                    .table tr{
                            text-transform:capitalize;

                            }
                    .table td{
                            border-right:2px solid black;

                            }
                    .info2{
                            float:left;
                            margin-bottom: 30px;
                    }
                    .info2 ol table {

                            font-size: 12px;
                            }
                    .info1{
                            font-weight:bold;
                            float:left;
                            }
                    .info1 tr{
                        font-size: 12px;
                            }
                    .rightleft{
                            height:150px;

                            }
                    .rightleft .left{
                            float:left

                            }
                    .rightleft .right{
                            float:right;}
                    .note{
                        font-size: 13px;
                    }
                    .detail{
                        border: #039;
                    }
            </style>
             
            <?php
                include"../../conf/connect.php";
                include"../../conf/fungsi_indotgl.php";
                include"../../conf/library.php";
                
                
                $query=  mysql_query("select a.*, b.*, sum(kuantitas * harga) as total , f.no_faktur
                    from tb_retur a
                    inner join tb_detail_retur e on a.id_retur=e.id_retur 
                    inner join tb_pemesanan_stok f on e.id_pemesanan_stok=f.id_pemesanan_stok
                    inner join tb_suplier b on f.id_suplier=b.id_suplier 
                    where a.id_retur='$_GET[id]'");
                $b=  mysql_fetch_array($query);
                $tgl=  tgl_indo($b['tanggal_retur']);
            ?>
            <div class="content">
            <center><h2> NOTA RETUR</h2></center>

            <div class="info1">
                    <table cellpadding="5">
                        <tr>
                            <td><b>Nomor Retur</b></td>
                            <td>: <?php echo $b['nomor_retur']; ?></td>
                        </tr>
                        <tr>
                            <td><b>Nomor Faktur</b></td>
                            <td>: <?php echo $b['no_faktur']; ?></td>
                        </tr>
                        <tr>
                            <td><b>Tanggal</b></td>
                            <td>: <?php echo $tgl; ?></td>
                        </tr>
                    </table>
            </div>
            <br />
            <br />
            <br />
            <br />
            <br />
            <br />

            <div class="rightleft">
                    <span class="left">
                    <table class="table" width="300px" border="1" cellpadding="5" cellspacing="0">
                        <thead><tr><th>Suplier :</th></tr></thead>
                        <tbody><tr>
                                <td style="border:2px solid black;"><?php echo $b['nama']; ?><br />
                                  <?php echo $b['alamat']; ?> <br />INDONESIA      <br /></td>
                            </tr></tbody>
                        </table>
                    </span>

                    <span class="right">
                    <table class="table" width="300px" border="1" cellpadding="5" cellspacing="0">
                        <thead><tr><th>Faktur :</th></tr></thead>
                        <tbody><tr>
                                <td style="border:2px solid black;">PT ASTRA HONDA MOTOR <br />
Ahass Honda 2626 DilaJaya Motor<br />
Jln. Raya Cangkir 4 - Driyorejo<br />
61177 - Gresik<br /></td>
                            </tr></tbody>
                        </table>
                    </span>
            </div>
            <br />
            <table width="100%" class="table" border="2" cellpadding="5" cellspacing="0">
                  <thead>
                        <tr>
                            <th>No.</th>
                            <th>Kode Sparepart</th>
                            <th>Nama Sparepart</th>
                            <th>Kuantitas</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                        </tr>
                  </thead>
                  <tbody>
                      <?php
                            $query2='SELECT *, (kuantitas * harga) as total FROM tb_retur a 
                                inner join tb_detail_retur b on a.id_retur=b.id_retur 
                                inner join tb_sparepart c on b.id_sparepart=c.id_sparepart
                                where  a.id_retur='.$_GET['id'].'';
                            $rows=  mysql_query($query2);
                            $no=1;
                                while($row=mysql_fetch_array($rows)) {
                                    echo"<tr>
                                            <td style='text-align:center;'>$no</td>
                                            <td>".$row['kode_sparepart']."</td>
                                            <td>".$row['nama_sparepart']."</td>
                                            <td>".$row['kuantitas']."</td>
                                            <td style='white-space:nowrap; text-align:right;'>".number_format( $row['harga'] , 2 , '.' , ',' )."</td>
                                            <td style='white-space:nowrap; text-align:right;'>".number_format( $row['total'] , 2 , '.' , ',' )."</td>
                                         </tr>";
                                    $no++;

                                }
                        ?>
                        <tr>
                            <td colspan="4" style="border:2px solid black; border-left:hidden;border-bottom:hidden;"></td>
                            <td class="right_align" style="border-top:2px solid black;"><b>Total</b></td>
                            <td class="right_align" style="white-space:nowrap; text-align:right; border-top:2px solid black;"><?php echo number_format( $b['total'] , 2 , '.' , ',' ); ?></td>
                        </tr>
                  </tbody>
            </table>
            <br/><br/><br/>
            <?php 
            if(isset($_GET['author'])){
                $getname=  mysql_fetch_array(mysql_query("select nama from tb_pegawai where id_pegawai='$_GET[author]'"));
                $name=$getname['nama'];
            } 
            
            ?>
            <table width="100%" class="note">
                <tr>
                    <td>Prepared by,</td>
                    <td align="right">Approved by,</td>
                </tr>
                <tr>
                    <td height="73">&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td><u><?php if(isset($name)) echo $name; ?></u></td>
            <td align="right"><u>Supplier PT.AHM</u></td>
                </tr>
        </table>
            </div>
        <?php
    }
    else {
        
    }
}
    ?>