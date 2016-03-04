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
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
        <title>Dashboard Admin</title>

        <meta name="description" content="overview &amp; stats" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

		<!-- bootstrap & fontawesome -->
		<link rel="stylesheet" href="assets/css/bootstrap.min.css" />
		<link rel="stylesheet" href="assets/font-awesome/4.2.0/css/font-awesome.min.css" />

		<!-- page specific plugin styles -->

		<!-- text fonts -->
		<link rel="stylesheet" href="assets/fonts/fonts.googleapis.com.css" />

		<!-- ace styles -->
		<link rel="stylesheet" href="assets/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />
		<script src="assets/js/ace-extra.min.js"></script>

        <link rel="stylesheet" href="css/font-awesome.css">
        
        <link rel="stylesheet" href="css/jquery.dataTables.css">

        <link rel="stylesheet" href="css/ui-lightness/jquery-ui-1.8.21.custom.css">	

        <link rel="stylesheet" href="css/application.css">
        <!--<link rel="stylesheet" href="css/pages/dashboard.css">-->
        <script src="js/jquery-1.9.1.min.js"></script>  
        <link href="select2/select2.css" rel="stylesheet">
        <link href="css/main.css" rel="stylesheet">       

    </head>

   <body class="no-skin">
		<div id="navbar" class="navbar navbar-default">
			<script type="text/javascript">
				try{ace.settings.check('navbar' , 'fixed')}catch(e){}
			</script>

        <div class="navbar-container" id="navbar-container">
				<button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
					<span class="sr-only">Toggle sidebar</span>

					<span class="icon-bar"></span>

					<span class="icon-bar"></span>

					<span class="icon-bar"></span>
				</button>

				<div class="navbar-header pull-left">
					<a href="index.html" class="navbar-brand">
						<small>
							<i class="fa fa-bicycle"></i>
							MEJI SAKTI MOTOR
						</small>
					</a>
				</div>
				<div class="navbar-buttons navbar-header pull-right" role="navigation">
					<ul class="nav ace-nav">
						<li class="light-blue">
							<a data-toggle="dropdown" href="#" class="dropdown-toggle">
								<img class="nav-user-photo" src="assets/avatars/user.jpg" alt="Jason's Photo" />
								<span class="user-info">
									<small>Welcome,</small>
									<?php echo $nama_log; ?>
								</span>

								<i class="ace-icon fa fa-caret-down"></i>
							</a>

							<ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
								<li>
									<a href="#">
										<i class="ace-icon fa fa-cog"></i>
										Settings
									</a>
								</li>

								<li>
									<a href="profile.html">
										<i class="ace-icon fa fa-user"></i>
										Profile
									</a>
								</li>

								<li class="divider"></li>

								<li>
									<a href="logout.php">
										<i class="ace-icon fa fa-power-off"></i>
										Logout
									</a>
								</li>
							</ul>
						</li>
					</ul>
				</div>
			</div><!-- /.navbar-container -->
		</div>

		<div class="main-container" id="main-container">
			<script type="text/javascript">
				try{ace.settings.check('main-container' , 'fixed')}catch(e){}
			</script>

			<div id="sidebar" class="sidebar responsive">
				<script type="text/javascript">
					try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
				</script>
								
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
                            $hak_akses = '<li>
											<a href="index.php?page=hak_akses">
												<i class="menu-icon fa fa-key"></i>
												<span class="menu-text"> Hak Akses </span>
											</a>
											<b class="arrow"></b>
										</li>';
                        }
                        if ($set['hak_akses'] == 'kelola_master_privilege') {
                            $priv = '<li>
										<a href="index.php?r=privilege&page=view">
											<i class="menu-icon fa fa-user"></i>
											<span class="menu-text"> User Hak Akses</span>
										</a>
										<b class="arrow"></b>
									</li>';
                        }
                        if ($set['hak_akses'] == 'kelola_master_jabatan') {
                            $jabatan = '<li>
											<a href="index.php?r=jabatan&page=view">
												<i class="menu-icon fa fa-briefcase"></i>
												<span class="menu-text">Jabatan</span>
											</a>
											<b class="arrow"></b>
										</li>';
                        }
                        if ($set['hak_akses'] == 'kelola_master_pegawai') {
                            $pegawai = '<li>
											<a href="index.php?r=pegawai&page=view">
												<i class="menu-icon fa fa-group"></i>
												<span class="menu-text">Pegawai</span>
											</a>
											<b class="arrow"></b>
										</li>';
                        }
                        if ($set['hak_akses'] == 'kelola_master_color') {
                            $color = '<li>
											<a href="index.php?r=color&page=view">
												<i class="menu-icon fa fa-bicycle"></i>
												<span class="menu-text">Warna</span>
											</a>
											<b class="arrow"></b>
										</li>';
                        }
                        if ($set['hak_akses'] == 'kelola_master_unit') {
                            $tipe_motor = '<li>
											<a href="index.php?r=unit&page=view">
												<i class="menu-icon fa fa-folder-open"></i>
												<span class="menu-text">Tipe Motor</span>
											</a>
											<b class="arrow"></b>
										</li>';
                        }
                        if ($set['hak_akses'] == 'kelola_master_leasing') {
                            $leasing = '<li>
											<a href="index.php?r=leasing&page=view">
												<i class="menu-icon fa fa-bookmark"></i>
												<span class="menu-text">Leasing</span>
											</a>
											<b class="arrow"></b>
										</li>';
                        }
                        if ($set['hak_akses'] == 'kelola_master_unit') {
                            $unit = '<li>
										<a href="index.php?r=unit&page=view">
											<i class="menu-icon fa fa-reorder"></i>
											<span class="menu-text">Unit</span>
										</a>
										<b class="arrow"></b>
									</li>';
                        }
                        if ($set['hak_akses'] == 'kelola_detail_unit') {
                            $detailunit = '<li>
											<a href="index.php?r=detailunit&page=view">
												<i class="menu-icon fa fa-list-alt"></i>
												<span class="menu-text">Detail Unit</span>
											</a>
											<b class="arrow"></b>
										</li>';
                        }
                        if ($set['hak_akses'] == 'kelola_master_suplier') {
                            $suplier = '<li>
											<a href="index.php?r=suplier&page=view">
												<i class="menu-icon fa fa-child"></i>
												<span class="menu-text">Supplier</span>
											</a>
											<b class="arrow"></b>
										</li>';
                        }
                        if ($set['hak_akses'] == 'kelola_operasional_customer') {
                            $customer = '<li>
											<a href="index.php?r=customer&page=view">
												<i class="menu-icon fa fa-user"></i>
												<span class="menu-text">Registrasi Customer</span>
											</a>
											<b class="arrow"></b>
										</li>';
                        }
                        if ($set['hak_akses'] == 'kelola_history_customer') {
                            $history_customer = '<li>
													<a href="index.php?r=historycustomer&page=view">
														<i class="menu-icon fa fa-tachometer"></i>
														<span class="menu-text">History Customer</span>
													</a>
													<b class="arrow"></b>
												</li>';
                        }
                        if ($set['hak_akses'] == 'kelola_operasional_pemesanan_unit') {
                            $pembelianunit = '<li>
												<a href="index.php?r=pembelianunit&page=view">
													<i class="menu-icon fa fa-list-ul"></i>
													<span class="menu-text">Pembelian Unit</span>
												</a>
												<b class="arrow"></b>
											</li>';
                        }
                        if ($set['hak_akses'] == 'kelola_operasional_pembelian') {
                            $pengirimanunit = '<li>
												<a href="index.php?r=pengirimanunit&page=view">
													<i class="menu-icon fa fa-shopping-cart"></i>
													<span class="menu-text">Pengiriman Unit</span>
												</a>
												<b class="arrow"></b>
											</li>';
                        }
                        if ($set['hak_akses'] == 'kelola_operasional_penjualan') {
                            $penjualan = '<li>
											<a href="index.php?r=penjualan&page=view">
												<i class="menu-icon fa fa-money"></i>
												<span class="menu-text">Penjualan Unit</span>
											</a>
											<b class="arrow"></b>
										</li>';
                        }
                        if ($set['hak_akses'] == 'kelola_biayasr') {
                            $biayasr = '<li>
											<a href="index.php?r=biayasr&page=view">
												<i class="menu-icon fa fa-tachometer"></i>
												<span class="menu-text">Biaya Showroom</span>
											</a>
											<b class="arrow"></b>
										</li>';
                        }
                        if ($set['hak_akses'] == 'kelola_laporan_penjualan') {
                            $lap_penjualan = '<li>
												<a href="index.php?r=lap_penjualan&page=view">
													<i class="menu-icon fa fa-tachometer"></i>
													<span class="menu-text">Laporan Penjualan</span>
												</a>
												<b class="arrow"></b>
											</li>';
                        }
						if ($set['hak_akses'] == 'kelola_stok_masuk') {
							$ro = '<li>
										<a href="index.php?r=ro&page=view">
											<i class="menu-icon fa fa-tachometer"></i>
											<span class="menu-text">Stok Masuk</span>
										</a>
									</li>';
						}
                        if ($set['hak_akses'] == 'kelola_stok_master') {
                              $stok = '<li>
										<a href="index.php?r=stok&page=view">
											<i class="menu-icon fa fa-tachometer"></i>
											<span class="menu-text">Master Stok</span>
										</a>
									</li>';
                        }
                        if ($set['hak_akses'] == 'kelola_stok_retur') {
							$retur = '<li>
										<a href="index.php?r=retur&page=view">
											<i class="menu-icon fa fa-tachometer"></i>
											<span class="menu-text">Retur Stok</span>
										</a>
									</li>';
                        }
                        if ($set['hak_akses'] == 'kelola_laporan_pembelian') {
                            $lap_pengirimanunit = '<li>
													<a href="index.php?r=lap_pengirimanunit&page=view">
														<i class="menu-icon fa fa-tachometer"></i>
														<span class="menu-text">Laporan Pembelian</span>
													</a>
													<b class="arrow"></b>
												</li>';
                        }
                    }
                    ?>
					
			<ul class="nav nav-list">
				<li class="active">
					<a href="index.php?r=home">
						<i class="menu-icon fa fa-tachometer"></i>
						<span class="menu-text"> Dashboard </span>
					</a>

					<b class="arrow"></b>
				</li>
				
				<li class="">
					<a href="#" class="dropdown-toggle">
						<i class="menu-icon fa fa-folder"></i>
						<span class="menu-text">
							Data Master
						</span>

						<b class="arrow fa fa-angle-down"></b>
					</a>
					<b class="arrow"></b>
					<ul class="submenu">
						<?php if (isset($hak_akses)) echo $hak_akses; ?>
						<?php if (isset($priv)) echo $priv; ?>
						<?php if (isset($jabatan)) echo $jabatan; ?>
						<?php if (isset($pegawai)) echo $pegawai; ?>
						<?php if (isset($tipe_motor)) echo $tipe_motor; ?>
						<?php if (isset($color)) echo $color; ?>
						<?php if (isset($unit)) echo $unit; ?>
						<?php if (isset($detailunit)) echo $detailunit; ?>                                  
						<?php if (isset($leasing)) echo $leasing; ?>
						<?php if (isset($suplier)) echo $suplier; ?>
					</ul>
				</li>
				
				<li class="">
					<a href="#" class="dropdown-toggle">
						<i class="menu-icon fa fa-desktop"></i>
						<span class="menu-text">
							Operasional
						</span>

						<b class="arrow fa fa-angle-down"></b>
					</a>

					<b class="arrow"></b>

					<ul class="submenu">
						<li class="">
							<a href="#" class="dropdown-toggle">
								<i class="menu-icon fa fa-caret-right"></i>
								Customer
								<b class="arrow fa fa-angle-down"></b>
							</a>

							<b class="arrow"></b>

							<ul class="submenu">
								<?php if (isset($customer)) echo $customer; ?>               
								<?php if (isset($history_customer)) echo $history_customer; ?>
							</ul>
						</li>
						<?php if (isset($pembelianunit)) echo $pembelianunit; ?>
						<?php if (isset($pengirimanunit)) echo $pengirimanunit; ?>
						<?php if (isset($penjualan)) echo $penjualan; ?>
					</ul>
				</li>
			
				<li class="">
					<a href="#" class="dropdown-toggle">
						<i class="menu-icon fa fa-money"></i>
						<span class="menu-text">
							Keuangan
						</span>

						<b class="arrow fa fa-angle-down"></b>
					</a>
					<b class="arrow"></b>
					<ul class="submenu">
						<?php if (isset($biayasr)) echo $biayasr; ?>
						<?php if (isset($ro)) echo $ro; ?>
						<?php if (isset($retur)) echo $retur; ?>
						<?php if (isset($stok)) echo $stok; ?>
					</ul>
				</li>
				
				<li class="">
					<a href="#" class="dropdown-toggle">
						<i class="menu-icon fa fa-desktop"></i>
						<span class="menu-text">
							Laporan
						</span>

						<b class="arrow fa fa-angle-down"></b>
					</a>
					<b class="arrow"></b>
					<ul class="submenu">
						<?php if (isset($lap_penjualan)) echo $lap_penjualan; ?>
						<?php if (isset($lap_pengirimanunit)) echo $lap_pengirimanunit; ?>
					</ul>
				</li>
			</ul><!-- /.nav-list -->
	
			<div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
					<i class="ace-icon fa fa-angle-double-left" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
				</div>

				<script type="text/javascript">
					try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
				</script>
			</div>
			
			<div class="main-content">
				<div class="main-content-inner">
					<div class="breadcrumbs" id="breadcrumbs">
						<script type="text/javascript">
							try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
						</script>

						<ul class="breadcrumb">
							<li>
								<i class="ace-icon fa fa-home home-icon"></i>
								<a href="#">Home</a>
							</li>
							<li class="active">Dashboard</li>
						</ul><!-- /.breadcrumb -->

					</div>

					
					<?php
						if (isset($_GET['r'])) {
							if ($_GET['r'] == 'home') {
								$title = "Halaman Utama";
							} elseif ($_GET['r'] == 'privilege') {
								$title = "Kelola Hak Akses";
							} elseif ($_GET['r'] == 'hak_akses') {
								$title = "Kelola Master Data Hak Akses";
							} elseif ($_GET['r'] == 'color') {
								$title = "Kelola Warna";
							} elseif ($_GET['r'] == 'unit') {
								$title = "Kelola Jenis Motor";
							} elseif ($_GET['r'] == 'detailunit') {
								$title = "Kelola Detail Jenis Motor";
							} elseif ($_GET['r'] == 'leasing') {
								$title = "Kelola Leasing";
							} elseif ($_GET['r'] == 'kota') {
								$title = "Kelola Kota";
							} elseif ($_GET['r'] == 'provinsi') {
								$title = "Kelola Provinsi";
							} elseif ($_GET['r'] == 'suplier') {
								$title = "Kelola Suplier";
							} elseif ($_GET['r'] == 'biayasr') {
								$title = "Biaya Showroom";
//                            } elseif ($_GET['r'] == 'ro') {
//                                $title = "Stok Masuk";
							} elseif ($_GET['r'] == 'stok') {
								$title = "Master Stok";
							} elseif ($_GET['r'] == 'retur') {
								$title = "Retur Stok";
							} elseif ($_GET['r'] == 'jabatan') {
								$title = "Kelola Jabatan";
							} elseif ($_GET['r'] == 'pegawai') {
								$title = "Kelola Data Pegawai";
							} elseif ($_GET['r'] == 'pengirimanunit') {
								$title = "Pengiriman Unit";
							} elseif ($_GET['r'] == 'customer') {
								$title = "Data customer";
							} elseif ($_GET['r'] == 'historycustomer') {
								$title = "History customer";
							} elseif ($_GET['r'] == 'pembelianunit') {
								$title = "Data Pembelian Unit";
							} elseif ($_GET['r'] == 'penjualan') {
								if ($_GET['page'] == 'laba') {
									$title = "Perhitungan Laba Penjualan";
								} else {
									$title = "Data Penjualan";
								}
							} elseif ($_GET['r'] == 'lap_penjualan') {
								$title = "Laporan Penjualan";
							} elseif ($_GET['r'] == 'lap_pengirimanunit') {
								$title = "Laporan Pengiriman Unit";
							} else {
								$title = "Page Not Found";
							}
						}
						?>
					
					
					<div class="page-content">
						<div class="page-header">
							<h1>
								<?php if (isset($title)) echo $title; ?>								
							</h1>
						</div><!-- /.page-header -->

						<div class="row">
							<div class="col-xs-12">
								<div class="row">
									<?php
									if (isset($_GET['r'])) {

										if ($_GET['r'] == 'home') {
											include"home.php";
										} elseif ($_GET['r'] == 'privilege') {
											include"module/privilege/main.php";
										} elseif ($_GET['r'] == 'hak_akses') {
											include"module/hak_akses/main.php";
										} elseif ($_GET['r'] == 'color') {
											include"module/color/main.php";
										} elseif ($_GET['r'] == 'unit') {
											include"module/unit/main.php";
										} elseif ($_GET['r'] == 'leasing') {
											include"module/leasing/main.php";
										} elseif ($_GET['r'] == 'suplier') {
											include"module/suplier/main.php";
										} elseif ($_GET['r'] == 'unit') {
											include"module/unit/main.php";
										} elseif ($_GET['r'] == 'detailunit') {
											include"module/detailunit/main.php";
										} elseif ($_GET['r'] == 'provinsi') {
											include"module/provinsi/main.php";
										} elseif ($_GET['r'] == 'kota') {
											include"module/kota/main.php";
										} elseif ($_GET['r'] == 'biayasr') {
											include"module/biayasr/main.php";
										} elseif ($_GET['r'] == 'pegawai') {
											include"module/pegawai/main.php";
										} elseif ($_GET['r'] == 'jabatan') {
											include"module/jabatan/main.php";
										} elseif ($_GET['r'] == 'ro') {
											include"module/stok_masuk/main.php";
										} elseif ($_GET['r'] == 'stok') {
											include"module/stok/main.php";
										} elseif ($_GET['r'] == 'retur') {
											include"module/retur/main.php";
										} elseif ($_GET['r'] == 'pembelianunit') {
											include"module/pembelianunit/main.php";
										} elseif ($_GET['r'] == 'pengirimanunit') {
											include"module/pengirimanunit/main.php";
										} elseif ($_GET['r'] == 'customer') {
											include"module/customer/main.php";
										} elseif ($_GET['r'] == 'historycustomer') {
											include"module/historycustomer/main.php";
										} elseif ($_GET['r'] == 'penjualan') {
											include"module/penjualan/main.php";
										} elseif ($_GET['r'] == 'lap_penjualan') {
											include"module/lap_penjualan/main.php";
										} elseif ($_GET['r'] == 'paket_service') {
											include"module/paket_service/main.php";
										} elseif ($_GET['r'] == 'lap_pengirimanunit') {
											include"module/lap_pengirimanunit/main.php";
										}
									} else {
										include"error_page/error.php";
									}
									?>		
								</div><!-- /.col -->
							</div><!-- /.row -->

								<!-- PAGE CONTENT ENDS -->
						</div><!-- /.col -->
					</div><!-- /.row -->
				</div><!-- /.page-content -->
			</div>
		</div><!-- /.main-content -->

			<div class="footer">
				<div class="footer-inner">
					<div class="footer-content">
						<span class="bigger-120">
							<span class="blue bolder">Ace</span>
							Application &copy; 2013-2014
						</span>

						&nbsp; &nbsp;
						<span class="action-buttons">
							<a href="#">
								<i class="ace-icon fa fa-twitter-square light-blue bigger-150"></i>
							</a>

							<a href="#">
								<i class="ace-icon fa fa-facebook-square text-primary bigger-150"></i>
							</a>

							<a href="#">
								<i class="ace-icon fa fa-rss-square orange bigger-150"></i>
							</a>
						</span>
					</div>
				</div>
			</div>

			<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
				<i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
			</a>
		</div><!-- /.main-container -->

		
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
		
		<!-- basic scripts -->
		<script src="assets/js/jquery.2.1.1.min.js"></script>
		<script type="text/javascript">
			window.jQuery || document.write("<script src='assets/js/jquery.min.js'>"+"<"+"/script>");
		</script>
		<script type="text/javascript">
			if('ontouchstart' in document.documentElement) document.write("<script src='assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
		
		<script src="assets/js/bootstrap.min.js"></script>		
		<script src="assets/js/jquery-ui.custom.min.js"></script>
		<script src="assets/js/jquery.ui.touch-punch.min.js"></script>
		<script src="assets/js/jquery.easypiechart.min.js"></script>
		<script src="assets/js/jquery.sparkline.min.js"></script>
		<script src="assets/js/jquery.flot.min.js"></script>
		<script src="assets/js/jquery.flot.pie.min.js"></script>
		<script src="assets/js/jquery.flot.resize.min.js"></script>

		<!-- ace scripts -->
		<script src="assets/js/ace-elements.min.js"></script>
		<script src="assets/js/ace.min.js"></script>
</html>
    <?php
} 