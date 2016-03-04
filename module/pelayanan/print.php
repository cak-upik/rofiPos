<style>
                .header{
                    margin: 0 auto; width: 800px; text-align: center;
                }
                .content{
                    width:1000px; margin: 0 auto;
                    font-family: monospace; 
                }
                .content2{
                    width:800px; margin: 0 auto;
                    font-family: arial; 
                }
                table{
                    border-collapse:collapse;
                }
                .table, .tableb{


                            font-family: Arial; 
                            font-size: 13px;
                            }

                    .table th{
                        border:1px solid black;
                            text-align:center;
                            text-transform:capitalize;
                            }
                    .table tr{
                            text-transform:capitalize;

                            }
                    .table td{
                            border-right:1px solid black;
                            border-left:1px solid black;
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
                    .note2{
                        font-size: 13px;
                    }
                    .note2{
                        font-size: 12px;
                        float: right;
                    }
                    .detail{
                        border: #039;
                    }
</style>
            
<?php
include"../../conf/connect.php";
include"../../conf/class_paging.php";
include"../../conf/fungsi_indotgl.php";
include"../../conf/library.php";
include"service.php";

if(isset($_GET['sub'])){
    $sub=$_GET['sub'];
    if($sub == 'nota'){
        $query= mysql_query("select * from tb_pelayanan a 
                            inner join tb_pelanggan b on a.id_pelanggan=b.id_pelanggan
                            inner join tb_type_motor c on b.id_type_motor=c.id_type_motor
                            inner join tb_pekerjaan d on a.id_pelayanan=d.id_pelayanan
                            inner join tb_pegawai e on d.tb_pegawai=e.id_pegawai 
                            inner join tb_pembayaran f on a.id_pelayanan=f.id_pelayanan 
                            where a.id_pelayanan='$_GET[id]'");
        $res=  mysql_fetch_array($query);
        ?>
            <div class="content2">
                <center><h2> NOTA SERVICE</h2></center>
                <div class="rightleft">
                    <span class="left">
                        <table class="tableb" width="500px" border="0" cellpadding="3" cellspacing="0" >
                            
                            <tbody>
                                <tr>
                                    <td style="border-right: none;" rowspan="4" width="125px"><img src="../../img/1b.gif" width="120px" /></td>
                                    <td style="border-right: none;">
                                        <b>PT. ASTRA HONDA MOTOR</b>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border-right: none;">
                                        Ahass Honda 2626 DilaJaya Motor</td>
                                </tr>
                                <tr>
                                    <td style="border-right: none;">
                                        Jln. Raya Cangkir 4, Driyorejo</td>
                                </tr>
                                <tr>
                                    <td style="border-right: none;">61177 - Gresik</td>
                                </tr>
                            </tbody>
                       </table>
                    </span>
                    <span class="right">
                        <table class="tableb" width="300px" border="0" cellpadding="3" cellspacing="0" >
                            
                            <tbody>
                                <tr>
                                    <td width="92" style="border-right: none;">
                                        Bapak/ Ibu 
                                    </td>
                                    <td width="17" style="border-right: none;">:</td>
                                    <td width="173" style="border-right: none;">
                                        <?php echo $res['nama_pemilik']; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border-right: none;">
                                        No. Polisi 
                                    </td>
                                    <td style="border-right: none;">:</td>
                                    <td style="border-right: none;">
                                        <?php echo $res['nopol']; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border-right: none;">
                                        No. Nota 
                                    </td>
                                    <td style="border-right: none;">:</td>
                                    <td style="border-right: none;">
                                        <?php echo $res['nomor_pembayaran']; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border-right: none;">
                                        Tgl Service 
                                    </td>
                                    <td style="border-right: none;">:</td>
                                    <td style="border-right: none;">
                                        <?php echo tgl_indo($res['tanggal']); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border-right: none;">
                                        Tipe Motor 
                                    </td>
                                    <td style="border-right: none;">:</td>
                                    <td style="border-right: none;">
                                        <?php echo $res['nama_type']; ?>
                                    </td>
                                </tr>
                            </tbody>
                       </table>
                    </span>

                    
                </div>
                <br/>
                <table width="100%" class="table" border="1" cellpadding="8" cellspacing="0">
                  <thead>
                        <tr>
                            <th style="text-align:left;">Keluhan :</th>
                            <th style="text-align:left;" width="30%">Mekanik :</th>
                        </tr>
                  </thead>
                  <tbody>
                      <tr style="height: 90px; vertical-align: top;">
                          <td><?php echo $res['keluhan']; ?></td>
                          <td>
                              Kode Mekanik : <?php echo $res['id_pegawai']; ?> <br/>
                              Nama Mekanik : <?php echo $res['nama']; ?> 
                          </td>
                      </tr>
                  </tbody>
                </table>
                <br/>
                <table width="100%" class="table" border="1" cellpadding="8" cellspacing="0">
                  <thead>
                        <tr>
                            <th width="30px">No.</th>
                            <th>Jasa Service</th>
                            <th width="150px">Biaya Service</th>
                        </tr>
                  </thead>
                  <tbody>
                      <?php
                        $cekPekerjaan=checkJob($_GET['id']);
                        
                        if($cekPekerjaan == 'Satuan'){
                            $det_jenis=  mysql_query("select * from tb_pelayanan a inner join tb_detail_pelayanan b on a.id_pelayanan=b.id_pelayanan 
                                                    inner join tb_jenis_pekerjaan c on b.id_jenis_pekerjaan=c.id_jenis_pekerjaan
                                                    where a.id_pelayanan='$_GET[id]'");
                        }  else {
                            $parts2 = explode(' ', $cekPekerjaan);
                            $det_jenis=  mysql_query("select nama_kategori as jenis_pekerjaan, tarif_kerja from tb_kategori_pekerjaan 
                                where nama_kategori='$parts2[1]'");
                            
                            
                            //var_dump($parts2);
                            //exit();
                        }
                        
                        $jumRecord1=  mysql_num_rows($det_jenis);
                        
                        $no=1;
                        if($jumRecord1 > 0){
                            while ($row = mysql_fetch_array($det_jenis)) {
                                echo"<tr>
                                        <td>$no</td>
                                        <td>$row[jenis_pekerjaan]</td>
                                        <td style='white-space:nowrap; text-align:right;'>".number_format( $row['tarif_kerja'] , 2 , '.' , ',' )."</td>
                                     </tr>";
                                $no++;
                            }
                            if($cekPekerjaan !== 'Satuan'){
                                $tambahan = mysql_query("select a.id_jenis_pekerjaan,jenis_pekerjaan, tarif_kerja from tb_detail_pelayanan a 
                                                    inner join tb_jenis_pekerjaan b on a.id_jenis_pekerjaan=b.id_jenis_pekerjaan 
                                                    where a.id_pelayanan='$_GET[id]' and a.id_jenis_pekerjaan not in 
                                                    (
                                                        select a.id_jenis_pekerjaan from tb_jenis_pekerjaan a 
                                                        inner join tb_detail_jenis_pekerjaan b on a.id_jenis_pekerjaan=b.id_jenis_pekerjaan 
                                                        inner join tb_kategori_pekerjaan c on b.id_kategori_pekerjaan=c.id_kategori_pekerjaan 
                                                        where c.nama_kategori='$parts2[1]'
                                                    )");
                                while ($row3 = mysql_fetch_array($tambahan)) {
                                    echo"<tr>
                                            <td>$no</td>
                                            <td>$row3[jenis_pekerjaan]</td>
                                            <td style='white-space:nowrap; text-align:right;'>".number_format( $row3['tarif_kerja'] , 2 , '.' , ',' )."</td>
                                         </tr>";
                                    $no++;
                                }
                            }
                        }else{
                            echo"<tr><td colspan='3'> Data Kosong </td></tr>";
                        }
                      ?>
                  </tbody>
                </table>
                <br/>
                <table width="100%" class="table" border="1" cellpadding="8" cellspacing="0">
                  <thead>
                        <tr>
                            <th width="30px">No.</th>
                            <th>Kode Sparepart</th>
                            <th>Nama Sparepart</th>
                            <th>Harga Satuan</th>
                            <th>Kuantitas</th>
                            <th width="150px">Sub Total</th>
                        </tr>
                  </thead>
                  <tbody>
                      <?php
                        $det_spare=  mysql_query("SELECT c.kode_sparepart, c.nama_sparepart, d.harga_jual_satuan, 
                                                b.kuantitas, b.total_harga FROM tb_pelayanan a 
                                                inner join tb_penjualan b on a.id_pelayanan=b.id_pelayanan 
                                                inner join tb_sparepart c on b.id_sparepart=c.id_sparepart 
                                                inner join tb_stok d on c.id_sparepart=d.id_sparepart 
                                                where a.id_pelayanan='$_GET[id]' and d.jumlah_stok > 0");
                        $jumRecord2=  mysql_num_rows($det_jenis);
                        $no2=1;
                        if($jumRecord2 > 0){
                            while ($row2 = mysql_fetch_array($det_spare)) {
                                echo"<tr>
                                        <td>$no2</td>
                                        <td>$row2[kode_sparepart]</td>
                                        <td>$row2[nama_sparepart]</td>
                                        <td style='white-space:nowrap; text-align:right;'>Rp. ".number_format( $row2['harga_jual_satuan'] , 2 , '.' , ',' )."</td>
                                        <td style='white-space:nowrap; text-align:right;'>$row2[kuantitas]</td>
                                        <td style='white-space:nowrap; text-align:right;'>".number_format( $row2['total_harga'] , 2 , '.' , ',' )."</td>
                                     </tr>";
                                $no2++;
                            }
                        }else{
                            echo"<tr><td colspan='6'> Data Kosong </td></tr>";
                        }
                      ?>
                      <tr>
                          <td colspan="3" rowspan="5" style=" vertical-align: top; border-bottom: 1px solid black; font-size: 11px; padding-top: 20px;">
                              <p>Service bergaransi dengan ketentuan sebagai berikut :</p>
                              <ul>
                                  <li>Apabila setelah 7hari motor masih mengalami trouble</li>
                                  <li>nota service tidak boleh hilang</li>
                                  <li>tidak termasuk ganti spareparts</li>
                              </ul>
                          </td>
                          <td colspan="2" align="right" style="border-left:hidden;border-bottom:hidden; font-weight: bold;">Ongkos Kerja : </td>
                          <td style="white-space:nowrap; text-align:right;">Rp. <?php echo number_format( $res['ongkos_kerja'] , 2 , '.' , ',' ) ?></td>
                      </tr>
                      <tr>
                          <td colspan="2" align="right" style="border-left:hidden;border-bottom:hidden; font-weight: bold;">Biaya Parts : </td>
                          <td style="white-space:nowrap; text-align:right;">Rp. <?php echo number_format( $res['biaya_sparepart'] , 2 , '.' , ',' ) ?></td>
                      </tr>
                      <tr>
                          <td colspan="2" align="right" style="border-left:hidden;border-bottom: hidden; font-weight: bold;">Total : </td>
                          <td style="white-space:nowrap; text-align:right;">Rp. <?php echo number_format( $res['total'] , 2 , '.' , ',' ) ?></td>
                      </tr>
                      <tr>
                          <td colspan="2" align="right" style="border-left:hidden;border-bottom:hidden; font-weight: bold;">Pembayaran : </td>
                          <td style="white-space:nowrap; text-align:right;">Rp. <?php echo number_format( $res['jumlah_bayar'] , 2 , '.' , ',' ) ?></td>
                      </tr>
                      <tr>
                          <td colspan="2" align="right" style="border-left:hidden;border-bottom:1px solid black; font-weight: bold;">Kembalian : </td>
                          <td style="white-space:nowrap; text-align:right;">Rp. 
                              <?php $kembali=$res['jumlah_bayar']-$res['total']; echo number_format( $kembali , 2 , '.' , ',' ) ?>
                          </td>
                      </tr>
                      
                  </tbody>
                </table>
                <br/><br/>
                <table width="40%" class="note2" border="0">
                    <tr>
                        <td align="center" width="20%">Pemilik / Pembawa Kendaraan,</td>
                        <td align="center" width="20%">Hormat Kami,</td>
                    </tr>
                    <tr>
                        <td height="73">&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td align="center"><u><?php echo $res['nama_pemilik']; ?></u></td>
                        <td align="center"><u>Front Desk</u></td>
                    </tr>
                </table>
                
            </div>
        <?php
    }
    elseif ($sub == 'kerja') {
        $query= mysql_query("select * from tb_pelayanan a 
                            inner join tb_pelanggan b on a.id_pelanggan=b.id_pelanggan
                            inner join tb_type_motor c on b.id_type_motor=c.id_type_motor
                            inner join tb_pekerjaan d on a.id_pelayanan=d.id_pelayanan
                            inner join tb_pegawai e on d.tb_pegawai=e.id_pegawai where a.id_pelayanan='$_GET[id]'");
        $res=  mysql_fetch_array($query);
        ?>
            <div class="content" style="margin-top:30px;">
                <center>
    <h2> PERINTAH KERJA MEKANIK</h2></center>
                
                <table width="100%" border="0" style="border-bottom: solid 1px #000;">
                    <tr valign="top">
                        <td width="30%">
                            <table width="100%" cellpadding="3">
                                <tr>
                                    <td width="38%">No. Nota</td>
                                    <td width="9%">:</td>
                                    <td width="53%"><?php echo $res['nomor_pelayanan']; ?></td>
                                </tr>
                                <tr>
                                    <td>Tanggal</td>
                                    <td>:</td>
                                    <td><?php echo tgl_indo($res['tanggal']); ?></td>
                                </tr>
                                <tr>
                                    <td>Jam</td>
                                    <td>:</td>
                                    <td><?php echo pukul_indo($res['jam']); ?></td>
                                </tr>
                            </table>
                        </td>
                        <td width="40%">
                            <table width="90%" cellpadding="5" border="2">
                                <tr>
                                    <td align="center">PEMILIK</td>
                                </tr>
                                <tr>
                                    <td>
                                        <?php echo $res['nama_pemilik']; ?> <br/>
                                        <?php echo $res['alamat_pemilik']; ?> <br/>
                                        <?php echo $res['no_telp']; ?>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td width="30%">
                            <table width="100%" cellpadding="3">
                                <tr>
                                    <td width="57%">No. Polisi</td>
                                    <td width="9%">:</td>
                                    <td width="34%"><?php echo $res['nopol']; ?></td>
                                </tr>
                                <tr>
                                    <td>Tipe Motor</td>
                                    <td>:</td>
                                    <td><?php echo $res['nama_type']; ?></td>
                                </tr>
                                <tr>
                                    <td>No. Mesin</td>
                                    <td>:</td>
                                    <td><?php echo $res['no_rangka']; ?></td>
                                </tr>
                                <tr>
                                    <td>No. Rangka</td>
                                    <td>:</td>
                                    <td><?php echo $res['no_mesin']; ?></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <br/><br/>
                <table width="100%" cellpadding="10">
                    <tr>
                        <td width="50%">JASA BENGKEL :</td>
                        <td width="50%">KELUHAN :</td>
                    </tr>
                    <tr>
                        <td>
                            <?php
                                $q=  mysql_query("select jenis_pekerjaan from tb_detail_pelayanan a 
                                                    inner join tb_jenis_pekerjaan b on a.id_jenis_pekerjaan=b.id_jenis_pekerjaan 
                                                    where a.id_pelayanan='$_GET[id]'");
                                $no=1;
                                while ($r = mysql_fetch_array($q)) {
                                    echo"$no.  $r[jenis_pekerjaan] </br>";
                                    $no++;
                                }
                            ?>
                        </td>
                        <td><?php echo $res['keluhan']; ?></td>
                    </tr>
                </table>
                
                <br/><br/><br/><br/><br/><br/>
                <table width="40%" border="0" align="center" class="note">
                    <tr>
                        <td align="center" width="51%">Pemilik Kendaraan,</td>
                        <td align="center" width="49%">Mekanik,</td>
                    </tr>
                    <tr>
                        <td height="73">&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td align="center"><u><?php echo $res['nama_pemilik']; ?></u></td>
                        <td align="center"><u><?php echo $res['nama']; ?></u></td>
                    </tr>
                </table>
                <div style="margin-top: 40px; border: solid 1px #000; -webkit-border-radius: 9px; -moz-border-radius: 9px; border-radius: 9px; padding:10px; font-size:14px; width: 800px; font-family: 'Times New Roman', Times, serif;">
                    <p>Semua pekerjaan dan pergantian suku cadang yang tertulis pada Perintah Kerja ini telah disetujui oleh Pemilik/Pemakai kendaraan, 
                    termasuk tes kendaraan ditempat maupun berjalan.</p>
                    <p>Kami tidak bertanggung jawab atas kehilangan/kerusakan kendaraanatau benda-benda lain yang ada di kendaraan yang diakibatkan oleh sebab-sebab diluar kekuasaan kami.</p>
                </div>
            </div>
        <?php
    }
    elseif ($sub == 'laporan1') {
        ?>
        <div class="content2" style="margin-top:30px;">
                <center><h2> Laporan Bulanan Bengkel</h2></center>
                <center><h3>Bulan <?php echo $_POST['bln_filter']; ?> / Tahun <?php echo $_POST['thn_filter']; ?> </h3></center>
                
                <table width="100%" class="table" border="1" cellpadding="8" cellspacing="0">
                  <thead>
                        <tr>
                            <th rowspan="2" align="center" valign="middle">No.</th>
                            <th rowspan="2" align="center">Tipe</th>
                            <th rowspan="2" align="center">Nama Tipe</th>
                            <th colspan="2" align="center">Jenis Service</th>
                            <th rowspan="2" align="center">Jumlah Pekerjaan</th>
                          </tr>
                          <tr>
                            <th align="center">Satuan</th>
                            <th align="center">Paket</th>
                          </tr>
                  </thead>
                  <tbody>
                      <?php
                        $det_jenis=  mysql_query("SELECT distinct b.id_type_motor, c.kode_type_motor, c.nama_type FROM tb_pelayanan a 
                            inner join tb_pelanggan b on a.id_pelanggan=b.id_pelanggan 
                            inner join tb_type_motor c on b.id_type_motor=c.id_type_motor 
                            where substr(tanggal,1,4)='".$_POST['thn_filter']."' and substr(tanggal,6,2)='".$_POST['bln_filter']."' ");
                        $jumRecord1=  mysql_num_rows($det_jenis);
                        $no=1;
                        if($jumRecord1 > 0){
                            while ($row = mysql_fetch_array($det_jenis)) {
                                $satuan=getJumlahSatuan($_POST['bln_filter'], $_POST['thn_filter'], $row['id_type_motor']);
                                $paket=getJumlahPaket($_POST['bln_filter'], $_POST['thn_filter'], $row['id_type_motor']);
                                //$katRingan=getJumlahPelayanan('2', $_POST['bln_filter'], $_POST['thn_filter'], $row['id_type_motor']);
                                //$katGaransi=getJumlahPelayanan('3', $_POST['bln_filter'], $_POST['thn_filter'], $row['id_type_motor']);
                                $tot=$satuan + $paket;
                                echo"<tr>
                                        <td>$no</td>
                                        <td>$row[kode_type_motor]</td>
                                        <td>$row[nama_type]</td>
                                        <td>$satuan</td>
                                        <td>$paket</td>
                                        <td style='white-space:nowrap; text-align:right;'>$tot</td>
                                     </tr>";
                                $no++;
                            }
                        }else{
                            echo"<tr><td colspan='8'> Data Kosong </td></tr>";
                        }
                      ?>
                  </tbody>
                </table>
        </div>
        <?php
    }
}
?>
