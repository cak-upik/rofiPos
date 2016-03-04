<?php
session_start();
//$id_perusahaan_log = $_SESSION['id_perusahaan_log'];
$nama_log = $_SESSION['nama_log'];
$username_log = $_SESSION['username_log'];
$password_log = $_SESSION['password_log'];
$id_pegawai = $_SESSION['id_pegawai'];
if ($username_log == null and $password_log == null) {
    header('Location: error_page/must_login.php');
} else {
    //if($nama_log == 'programmer' AND $password_log== 'programmer'){
    //}
    ?>
    <!doctype html>
    <head>
        <title>Dashboard Admin</title>

        <meta charset="utf-8">

        <meta name="description" content="">
        <meta name="author" content="">

        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <meta name="apple-mobile-web-app-capable" content="yes">


        <link rel="stylesheet" href="css/font-awesome.css">

        <link rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" href="css/bootstrap-responsive.css">
        <link rel="stylesheet" href="css/jquery.dataTables.css">

        <link rel="stylesheet" href="css/ui-lightness/jquery-ui-1.8.21.custom.css">	

        <link rel="stylesheet" href="css/application.css">
        <!--<link rel="stylesheet" href="css/pages/dashboard.css">-->
        <script src="js/jquery-1.9.1.min.js"></script>  
        <link href="select2/select2.css" rel="stylesheet">
        <link href="css/main.css" rel="stylesheet">       



    </head>

    <body>

        <div id="wrapper">

            <div id="topbar">

                <div class="container">

                    <a href="javascript:;" id="menu-trigger" class="dropdown-toggle" data-toggle="dropdown" data-target="#">
                        <i class="icon-cog"></i>
                    </a>

                    <div id="top-nav">
                        <a class="brands" href="#">MEJI SAKTI MOTOR</a>
                        <ul class="pull-right">
                            <li><a href="javascript:;"><i class="icon-user"></i> Logged in as <?php echo $nama_log; ?></a></li>
                            <li><a href="logout.php">Logout</a></li>
                        </ul>

                    </div> <!-- /#top-nav -->

                </div> <!-- /.container -->

            </div> <!-- /#topbar -->




            <div id="header">

                <div class="container">

                    <a href="#" class="brand"><img src="img/logo.png" width="121px"></a>
                    <a href="javascript:;" class="btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                        <i class="icon-reorder"></i>                </a>

                    <?php
                    include "conf/connect.php";
                    include "conf/class_paging.php";
                    include "conf/fungsi_indotgl.php";
                    include "conf/fungsi_combobox.php";
                    include "conf/library.php";
                    include "conf/pengkodean.php";

                    $privilege = mysql_query("select hak_akses from tb_jabatan a 
                                inner join tb_detail_hak_akses b on a.id_jabatan=b.id_jabatan 
                                inner join tb_hak_akses c on b.id_hak_akses=c.id_hak_akses 
                                inner join tb_pegawai d on a.id_jabatan=d.id_jabatan 
                                where d.id_pegawai='$id_pegawai'");

                    while ($set = mysql_fetch_array($privilege)) {

                        if ($set['hak_akses'] == 'kelola_master_hak_akses') {
                            $hak_akses = '<li><a href="index.php?page=hak_akses">Hak Akses</a></li>';
                        }
                        if ($set['hak_akses'] == 'kelola_master_privilege') {
                            $priv = '<li><a href="index.php?r=privilege&page=view">User Hak Akses</a></li>';
                        }
                        if ($set['hak_akses'] == 'kelola_master_jabatan') {
                            $jabatan = '<li><a href="index.php?r=jabatan&page=view">Jabatan</a></li>';
                        }
                        if ($set['hak_akses'] == 'kelola_master_pegawai') {
                            $pegawai = '<li><a href="index.php?r=pegawai&page=view">Pegawai</a></li>';
                        }
                        if ($set['hak_akses'] == 'kelola_master_color') {
                            $color = '<li><a href="index.php?r=color&page=view">Warna</a></li>';
                        }
                        if ($set['hak_akses'] == 'kelola_master_unit') {
                            $tipe_motor = '<li><a href="index.php?r=unit&page=view">Tipe Motor</a></li>';
                        }
                        if ($set['hak_akses'] == 'kelola_master_leasing') {
                            $leasing = '<li><a href="index.php?r=leasing&page=view">Leasing</a></li>';
                        }
                        if ($set['hak_akses'] == 'kelola_master_unit') {
                            $unit = '<li><a href="index.php?r=unit&page=view">Unit</a></li>';
                        }
                        if ($set['hak_akses'] == 'kelola_detail_unit') {
                            $detailunit = '<li><a href="index.php?r=detailunit&page=view">Detail Unit</a></li>';
                        }
                        if ($set['hak_akses'] == 'kelola_master_suplier') {
                            $suplier = '<li><a href="index.php?r=suplier&page=view">Supplier</a></li>';
                        }
                        if ($set['hak_akses'] == 'kelola_operasional_customer') {
                            $customer = '<li><a href="index.php?r=customer&page=view">Registrasi Customer</a></li>';
                        }
                        if ($set['hak_akses'] == 'kelola_history_customer') {
                            $history_customer = '<li><a href="index.php?r=historycustomer&page=view">History Customer</a></li>';
                        }
                        if ($set['hak_akses'] == 'kelola_operasional_pemesanan_unit') {
                            $pembelianunit = '<li><a href="index.php?r=pembelianunit&page=view">Pembelian Unit</a></li>';
                        }
                        if ($set['hak_akses'] == 'kelola_operasional_pembelian') {
                            $pengirimanunit = '<li><a href="index.php?r=pengirimanunit&page=view">Pengiriman Unit</a></li>';
                        }
                        if ($set['hak_akses'] == 'kelola_operasional_penjualan') {
                            $penjualan = '<li><a href="index.php?r=penjualan&page=view">Penjualan Unit</a></li>';
                        }
                        if ($set['hak_akses'] == 'kelola_biayasr') {
                            $biayasr = '<li><a href="index.php?r=biayasr&page=view">Biaya Showroom</a></li>';
                        }
//                        if ($set['hak_akses'] == 'kelola_stok_masuk') {
//                            $ro = '<li><a href="index.php?r=ro&page=view">Stok Masuk</a></li>';
//                        }
                        //      if ($set['hak_akses'] == 'kelola_stok_master') {
                        //        $stok = '<li><a href="index.php?r=stok&page=view">Master Stok</a></li>';
                        //  }
                        //if ($set['hak_akses'] == 'kelola_stok_retur') {
                        //  $retur = '<li><a href="index.php?r=retur&page=view">Retur Stok</a></li>';
                        //}
                        if ($set['hak_akses'] == 'kelola_laporan_penjualan') {
                            $lap_penjualan = '<li><a href="index.php?r=lap_penjualan&page=view">Laporan Penjualan</a></li>';
                        }
                        if ($set['hak_akses'] == 'kelola_laporan_pembelian') {
                            $lap_pengirimanunit = '<li><a href="index.php?r=lap_pengirimanunit&page=view">Laporan Pembelian</a></li>';
                        }
                    }
                    ?>

                    <div class="nav-collapse">
                        <ul id="main-nav" class="nav pull-right">
                            <li class="nav-icon active">
                                <a href="index.php?page=home"> 
                                    <i class="icon-home"></i>
                                    <span>Home</span>                                            
                                </a>                                    
                            </li>

                            <li class="dropdown">					
                                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="icon-th"></i>
                                    <span>Data Master</span> 
                                    <b class="caret"></b>                                            
                                </a>	
                                <ul class="dropdown-menu">
                                    <?php if (isset($hak_akses)) echo $hak_akses; ?>
                                    <?php if (isset($priv)) echo $priv; ?>
                                    <?php if (isset($jabatan)) echo $jabatan; ?>
                                    <?php if (isset($pegawai)) echo $pegawai; ?>

                                    <div class="divider"></div>
                                    <?php //if (isset($tipe_motor)) echo $tipe_motor; ?>
                                    <?php if (isset($color)) echo $color; ?>
                                    <?php if (isset($unit)) echo $unit; ?>
                                    <?php if (isset($detailunit)) echo $detailunit; ?>

                                    <div class="divider"></div>                                            
                                    <?php if (isset($leasing)) echo $leasing; ?>
                                    <?php if (isset($suplier)) echo $suplier; ?>

                                </ul>
                            </li>

                            <li class="dropdown">					
                                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="icon-copy"></i>
                                    <span>Operasional</span> 
                                    <b class="caret"></b>                                            
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="dropdown-submenu">
                                        <a href="#">Customer</a>
                                        <ul class="dropdown-menu">                                           
                                            <?php if (isset($customer)) echo $customer; ?>               
                                            <?php if (isset($history_customer)) echo $history_customer; ?>
                                        </ul>
                                    </li>

                                    <div class="divider"></div>
                                    <?php if (isset($pembelianunit)) echo $pembelianunit; ?>
                                    <?php if (isset($pengirimanunit)) echo $pengirimanunit; ?>
                                    <?php if (isset($penjualan)) echo $penjualan; ?>

                                </ul>
                            </li>

                            <li class="dropdown">					
                                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="icon-external-link"></i>
                                    <span>Keuangan</span> 
                                    <b class="caret"></b>                                            
                                </a>	
                                <ul class="dropdown-menu">		
                                    <?php if (isset($biayasr)) echo $biayasr; ?>
                                    <?php if (isset($ro)) echo $ro; ?>
                                    <?php if (isset($retur)) echo $retur; ?>
                                    <?php if (isset($stok)) echo $stok; ?>
                                </ul>
                            </li>

                            <li class="dropdown">					
                                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="icon-certificate"></i>
                                    <span>Laporan</span> 
                                    <b class="caret"></b>                                            
                                </a>	

                                <ul class="dropdown-menu">	
                                    <?php if (isset($lap_penjualan)) echo $lap_penjualan; ?>
                                    <?php if (isset($lap_pengirimanunit)) echo $lap_pengirimanunit; ?>
                                </ul>
                            </li>
                        </ul>  
                    </div>

                </div> <!-- /.container -->

            </div> <!-- /#header -->


            <!-- TITLE HEADER -->

            <div id="masthead">

                <div class="container">

                    <div class="masthead-pad">
                        <?php
                        if (isset($_GET['page'])) {
                            if ($_GET['page'] == 'home') {
                                $title = "Halaman Utama";
                            } elseif ($_GET['page'] == 'privilege') {
                                $title = "Kelola Hak Akses";
                            } elseif ($_GET['page'] == 'hak_akses') {
                                $title = "Kelola Master Data Hak Akses";
                            } elseif ($_GET['page'] == 'color') {
                                $title = "Kelola Warna";
                            } elseif ($_GET['page'] == 'unit') {
                                $title = "Kelola Jenis Motor";
                            } elseif ($_GET['page'] == 'detailunit') {
                                $title = "Kelola Detail Jenis Motor";
                            } elseif ($_GET['page'] == 'leasing') {
                                $title = "Kelola Leasing";
                            } elseif ($_GET['page'] == 'kota') {
                                $title = "Kelola Kota";
                            } elseif ($_GET['page'] == 'provinsi') {
                                $title = "Kelola Provinsi";
                            } elseif ($_GET['page'] == 'suplier') {
                                $title = "Kelola Suplier";
                            } elseif ($_GET['page'] == 'biayasr') {
                                $title = "Biaya Showroom";
//                            } elseif ($_GET['r'] == 'ro') {
//                                $title = "Stok Masuk";
                            } elseif ($_GET['page'] == 'stok') {
                                $title = "Master Stok";
                            } elseif ($_GET['page'] == 'retur') {
                                $title = "Retur Stok";
                            } elseif ($_GET['page'] == 'jabatan') {
                                $title = "Kelola Jabatan";
                            } elseif ($_GET['page'] == 'pegawai') {
                                $title = "Kelola Data Pegawai";
                            } elseif ($_GET['page'] == 'pengirimanunit') {
                                $title = "Pengiriman Unit";
                            } elseif ($_GET['page'] == 'customer') {
                                $title = "Data customer";
                            } elseif ($_GET['page'] == 'historycustomer') {
                                $title = "History customer";
                            } elseif ($_GET['page'] == 'pembelianunit') {
                                $title = "Data Pembelian Unit";
                            } elseif ($_GET['page'] == 'penjualan') {
                                if ($_GET['pages'] == 'laba') {
                                    $title = "Perhitungan Laba Penjualan";
                                } else {
                                    $title = "Data Penjualan";
                                }
                            } elseif ($_GET['page'] == 'lap_penjualan') {
                                $title = "Laporan Penjualan";
                            } elseif ($_GET['page'] == 'lap_pengirimanunit') {
                                $title = "Laporan Pengiriman Unit";
                            } else {
                                $title = "Page Not Found";
                            }
                        }
                        ?>
                        <div class="masthead-text">
                            <h2><?php if (isset($title)) echo $title; ?></h2>
                        </div> <!-- /.masthead-text -->

                    </div>

                </div> <!-- /.container -->	

            </div> <!-- /#masthead -->


            <!-- Module Location Definition -->

            <div id="content">

                <div class="container">

                    <?php
                    
                    if (isset($_GET['page'])) {
                            
                        if ($_GET['page'] == 'home') {
                            include"home.php";
                        } elseif ($_GET['page'] == 'privilege') {
                            include"module/privilege/main.php";
                        } elseif ($_GET['page'] == 'hak_akses') {
                            include"module/hak_akses/main.php";
                        } elseif ($_GET['page'] == 'color') {
                            include"module/color/main.php";
                        } elseif ($_GET['page'] == 'unit') {
                            include"module/unit/main.php";
                        } elseif ($_GET['page'] == 'leasing') {
                            include"module/leasing/main.php";
                        } elseif ($_GET['page'] == 'suplier') {
                            include"module/suplier/main.php";
                        } elseif ($_GET['page'] == 'unit') {
                            include"module/unit/main.php";
                        } elseif ($_GET['page'] == 'detailunit') {
                            include"module/detailunit/main.php";
                        } elseif ($_GET['page'] == 'provinsi') {
                            include"module/provinsi/main.php";
                        } elseif ($_GET['page'] == 'kota') {
                            include"module/kota/main.php";
                        } elseif ($_GET['page'] == 'biayasr') {
                            include"module/biayasr/main.php";
                        } elseif ($_GET['page'] == 'pegawai') {
                            include"module/pegawai/main.php";
                        } elseif ($_GET['page'] == 'jabatan') {
                            include"module/jabatan/main.php";
                        } elseif ($_GET['page'] == 'ro') {
                            include"module/stok_masuk/main.php";
                        } elseif ($_GET['page'] == 'stok') {
                            include"module/stok/main.php";
                        } elseif ($_GET['page'] == 'retur') {
                            include"module/retur/main.php";
                        } elseif ($_GET['page'] == 'pembelianunit') {
                            include"module/pembelianunit/main.php";
                        } elseif ($_GET['page'] == 'pengirimanunit') {
                            include"module/pengirimanunit/main.php";
                        } elseif ($_GET['page'] == 'customer') {
                            include"module/customer/main.php";
                        } elseif ($_GET['page'] == 'historycustomer') {
                            include"module/historycustomer/main.php";
                        } elseif ($_GET['page'] == 'penjualan') {
                            include"module/penjualan/main.php";
                        } elseif ($_GET['page'] == 'lap_penjualan') {
                            include"module/lap_penjualan/main.php";
                        } elseif ($_GET['page'] == 'paket_service') {
                            include"module/paket_service/main.php";
                        } elseif ($_GET['page'] == 'lap_pengirimanunit') {
                            include"module/lap_pengirimanunit/main.php";
                        }
                    } else {
                        include"error_page/error.php";
                    }
                    ?>

                </div> <!-- /.container -->

            </div> <!-- /#content -->

        </div> <!-- /#wrapper -->




        <div id="footer">

            <div class="container">

                <div class="row">

                    <div class="span6">
                        Copyright © Ika Rahim S - 7411030804
                    </div> <!-- /span6 -->


                </div> <!-- /row -->

            </div> <!-- /container -->

        </div> <!-- /#footer -->


        <script src="js/jquery-1.7.2.min.js"></script>   
        <script type="text/javascript" src="select2/select2.min.js"></script>    
        <script src="js/libs/jquery-ui-1.8.21.custom.min.js"></script>
        <script src="js/libs/jquery.ui.touch-punch.min.js"></script>
        <script type="text/javascript" src="js/main.js"></script>
        <script src="js/jquery.dataTables.js"></script>

        <script src="js/libs/bootstrap/bootstrap.min.js"></script>
        <script src="js/bootstrap-typeahead.js"></script>
        <script src="js/Theme.js"></script>
        <script src="js/Charts.js"></script>
        <!--<script src="js/modal_bootstrap.js"></script>-->

        <script src="./js/plugins/excanvas/excanvas.min.js"></script>
        <script src="./js/plugins/flot/jquery.flot.js"></script>
        <script src="./js/plugins/flot/jquery.flot.pie.js"></script>
        <script src="./js/plugins/flot/jquery.flot.orderBars.js"></script>
        <script src="./js/plugins/flot/jquery.flot.tooltip.min.js"></script>
        <script src="./js/plugins/flot/jquery.flot.resize.js"></script>

        <script src="js/demos/charts/line.js"></script>
        <script src="js/demos/charts/donut.js"></script>
        <script src="js/jquery.validate.js"></script>
        <script src="js/jquery.numberformatter-1.2.3.js"></script>

    </body>
    </html>
    <?php
} 