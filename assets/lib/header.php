<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <meta name="description" content="<?php echo $cfg_desc; ?>">
  <meta name="author" content="<?php echo $cfg_author; ?>">
  <link rel="shortcut icon" href="<?php echo $cfg_baseurl; ?>assets/images/small/icon.png">
  <title><?php echo $cfg_webname; ?></title>
    
        <!-- DataTables -->
        
        <link href="../assets/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/plugins/datatables/buttons.bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/plugins/datatables/fixedHeader.bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/plugins/datatables/responsive.bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/plugins/datatables/scroller.bootstrap.min.css" rel="stylesheet" type="text/css" />
    
        <!--Morris Chart CSS -->
		
        <link href="../assets/plugins/morris/morris.css" rel="stylesheet" type="text/css" />
        <link href="../assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/css/core.css" rel="stylesheet" type="text/css" />
        <link href="../assets/css/components.css" rel="stylesheet" type="text/css" />
        <link href="../assets/css/icons.css" rel="stylesheet" type="text/css" />
        <link href="../assets/css/pages.css" rel="stylesheet" type="text/css" />
        <link href="../assets/css/menu.css" rel="stylesheet" type="text/css" />
        <link href="../assets/css/responsive.css" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

        <script src="../assets/js/modernizr.min.js"></script>
    </head>


    <body>
        <!-- Navigation Bar-->
        <header id="topnav">
            <div class="topbar-main">
                <div class="container">

                    <!-- LOGO -->
                    <div class="topbar">
                        <a href="/" class="logo"><span>Dimas SMM<span> Panel</span></span></a>
                    </div>
                    <!-- End Logo container-->
                    <div class="menu-extras">
                        <div class="menu-item">
                            <!-- Mobile menu toggle-->
                            <a class="navbar-toggle">
                                <div class="lines">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </div>
                            </a>
                            <!-- End mobile menu toggle-->
                        </div>
                        <?php if(isset($_SESSION['user'])) { ?>
                        <ul class="nav navbar-nav navbar-right pull-right">
                            <li class="dropdown">
							    <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="javascript:void(0)">
								<i class="fa fa-user"></i> <b class="hidden-xs"><?php echo $data_user['username']; ?></b> <span class="caret"></span>
							    </a>
							    <ul class="dropdown-menu">
							        <li>
									<div class="user-box">
										<div class="u-text">
											<h4><?php echo $data_user['username']; ?></h4>
											<span class="label label-success">Sisa Saldo: Rp.<?php echo number_format($data_user['balance'],0,',','.'); ?></span>
										</div>
									</div>
							    	</li>
                                    <li><a href="<?php echo $cfg_baseurl; ?>settings.php"><i class="ti-user m-r-5"></i> Profil Akun</a></li>
                                    <li><a href="<?php echo $cfg_baseurl; ?>history_balance.php"><i class="ti-bar-chart-alt m-r-5"></i> Cek Mutasi</a></li>
                                    <li><a href="<?php echo $cfg_baseurl; ?>logout.php"><i class="ti-power-off m-r-5"></i> Keluar</a></li>
                                </ul>
						    </li>
						</ul>
						<?php
                        }
                        ?>
                    </div>
                
                </div>
            </div>

            <div class="navbar-custom">
                <div class="container">
                    <div id="navigation">
                        <!-- Navigation Menu-->
                        <ul class="navigation-menu">
                            <?php
			                if (isset($_SESSION[ 'user'])) {
			                ?>
                            <?php
			                if ($data_user[ 'level'] == "Reseller") {
			                ?>
                            <li class="has-submenu">
                                <a href="#"><i class="fa fa-star"></i> <span> Fitur Staff </span> </a>
                                <ul class="submenu megamenu">
                                    <li>
                                        <ul>
                                    <li><a href="<?php echo $cfg_baseurl; ?>staff/add_user">Tambah Pengguna</a></li>
									<li><a href="<?php echo $cfg_baseurl; ?>staff/transfer_balance">Transfer Saldo</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <?php
							}
							?>
							<?php
							if ($data_user['level'] == "Admin") {
							?>

                            <li class="has-submenu">
                                <a href="#"><i class="fa fa-star"></i> <span> Fitur Developer </span> </a>
                                <ul class="submenu">
                                    <li><a href="<?php echo $cfg_baseurl; ?>admin/users.php">Kelola Pengguna</a></li>
                                    <li><a href="<?php echo $cfg_baseurl; ?>staff/add_user.php">Tambah Member</a></li>
                                    <li><a href="<?php echo $cfg_baseurl; ?>admin/reseller.php">Tambah Reseller</a></li>
                                    <li><a href="<?php echo $cfg_baseurl; ?>staff/transfer_balance.php">Transfer Saldo</a></li>
                                    <li><a href="<?php echo $cfg_baseurl; ?>admin/services.php">Kelola Layanan</a></li>
                                    <li><a href="<?php echo $cfg_baseurl; ?>admin/orders.php">Kelola Pesanan</a></li>
                                    <li><a href="<?php echo $cfg_baseurl; ?>admin/news/add.php">Tambah Berita</a></li>
                                    <li><a href="<?php echo $cfg_baseurl; ?>admin/news.php">Kelola Berita</a></li>
                                    <li><a href="<?php echo $cfg_baseurl; ?>admin/deposit.php">Kelola Deposit</a></li>
                                    <li><a href="<?php echo $cfg_baseurl; ?>admin/transfer_history.php">Riwayat Transfer</a></li>
                                </ul>
                            </li>
                            <?php
							}
							?>
							
							<li>
                                <a href="/"><i class="fa fa-home"></i> <span> Dashboard </span> </a>
                            </li>

                            <li class="has-submenu">
                                <a href="#"><i class="fa fa-shopping-cart"></i> <span> Media Sosial </span> </a>
                                <ul class="submenu">
                                    <li><a href="<?php echo $cfg_baseurl; ?>order.php">Pesanan Baru</a></li>
									<li><a href="<?php echo $cfg_baseurl; ?>order_history.php">Riwayat Pesanan</a></li>
									<li><a href="<?php echo $cfg_baseurl; ?>price_list.php">Daftar & Harga Layanan</a></li>
                                </ul>
                            </li>
                            
                            <li class="has-submenu">
                                <a href="#"><i class="ti-money m-r-5"></i> <span> Saldo </span> </a>
                                <ul class="submenu">
                                    <li><a href="<?php echo $cfg_baseurl; ?>deposit.php">Deposit Saldo</a></li>
									<li><a href="<?php echo $cfg_baseurl; ?>deposit_history.php">Riwayat Saldo</a></li>
                                </ul>
                            </li>
                            
                            <?php
							} else {
							?>
							
							<li>
                                <a href="<?php echo $cfg_baseurl; ?>"><i class="fa fa-sign-in"></i> <span> Masuk </span> </a>
                            </li>
                            
							<li>
                                <a href="<?php echo $cfg_baseurl; ?>register.php"><i class="fa fa-user-plus"></i> <span> Daftar </span> </a>
                            </li>
                            
                            
                            <li class="has-submenu">
                                <a href="#"><i class="fa fa-tag"></i> <span> Daftar Layanan </span> </a>
                                <ul class="submenu">
                                    <li><a href="<?php echo $cfg_baseurl; ?>price_list.php">Media Sosial</a></li>
                                </ul>
                            </li>
                            
                            <?php
							}
							?>
                            
                            <li class="has-submenu">
                                <a href="#"><i class="fa fa-exchange"></i> <span> Dokumentasi API </span> </a>
                                <ul class="submenu">
                                    <li><a href="<?php echo $cfg_baseurl; ?>api_doc.php">Media Sosial</a></li>
                                </ul>
                            </li>
                            
                            <li class="has-submenu">
                                <a href="#"><i class="fa fa-question-circle"></i> <span> Bantuan </span> </a>
                                <ul class="submenu">
                                    <li><a href="<?php echo $cfg_baseurl; ?>contact.php">Kontak</a></li>
                                    <li><a href="<?php echo $cfg_baseurl; ?>ketentuan_layanan.php">Ketentuan Layanan</a></li>
                                    <li><a href="<?php echo $cfg_baseurl; ?>faq.php">Pertanyaan Umum</a></li>                                    
                                </ul>
                            </li>
                            

                        </ul>
                        <!-- End navigation menu  -->
                    </div>
                </div>
            </div>
        </header>
        <!-- End Navigation Bar-->
        
         <div class="wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6">
                        </br>
                    </div>
                </div>