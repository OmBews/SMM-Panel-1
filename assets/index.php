<?php
session_start();
require("mainconfig.php");
$msg_type = "nothing";

if (isset($_SESSION['user'])) {
	$sess_username = $_SESSION['user']['username'];
	$check_user = mysqli_query($db, "SELECT * FROM users WHERE username = '$sess_username'");
	$data_user = mysqli_fetch_assoc($check_user);
	if (mysqli_num_rows($check_user) == 0) {
		header("Location: ".$cfg_baseurl."logout.php");
	} else if ($data_user['status'] == "Suspended") {
		header("Location: ".$cfg_baseurl."logout.php");
	}

	$check_order = mysqli_query($db, "SELECT SUM(price) AS total FROM orders WHERE user = '$sess_username'");
	$data_order = mysqli_fetch_assoc($check_order);
	
	$count_sosmed = mysqli_num_rows(mysqli_query($db, "SELECT * FROM orders WHERE user = '$sess_username'"));
	
	$count_orders = $count_sosmed;
} else {
    

$number1 = rand(1,5);
$number2 = rand(1,5);

// mengacak oprator 
$oprator = "x - +";
$oprator = explode(" ", $oprator);
$oprator = $oprator[mt_rand(0, count($oprator)-1)];

// mendaftarkan session hasil sesuai oprator
if ($oprator == 'x') {
    $_SESSION['captcha'] = $number1 * $number2;
} else if ($oprator == '-') {
    $_SESSION['captcha'] = $number1 - $number2;
} else if ($oprator == '+') {
    $_SESSION['captcha'] = $number1 + $number2;
} else if ($oprator == '+') {
    $_SESSION['captcha'] = $number1 + $number2;
}

// mencetak pertanyaan
$question = "Hasil dari $number1 $oprator $number2 Berapa sih?";
if (isset($_POST['login'])) {
    $post_username = mysqli_real_escape_string($db, trim(stripslashes(strip_tags(htmlspecialchars($_POST['username'])))));
    $post_password = mysqli_real_escape_string($db, trim(stripslashes(strip_tags(htmlspecialchars($_POST['password'])))));
	if (empty($post_username) || empty($post_password)) {
		$msg_type = "error";
		$msg_content = "<b>Gagal:</b> Mohon mengisi semua input dengan benar.";
	} else {
		$check_user = mysqli_query($db, "SELECT * FROM users WHERE username = '$post_username' AND password = '$post_password'");
		if (mysqli_num_rows($check_user) == 0) {
			$msg_type = "error";
			$msg_content = "<b>Gagal:</b> Username atau password salah.";
		} else {
			$data_user = mysqli_fetch_assoc($check_user);
			if ($data_user['status'] == "Suspended") {
				$msg_type = "error";
				$msg_content = "<b>Gagal:</b> Akun nonaktif.";
			} else {
				$_SESSION['user'] = $data_user;
				header("Location: ".$cfg_baseurl);
			}
		}
	}
}
}

include("lib/header.php");
if (isset($_SESSION['user'])) {
?>
                        
                        <div class="row">
							<div class="col-lg-4 col-md-4">
                                <div class="card-box">
                                    <div class="widget-chart-1">
                                        <div class="widget-chart-box-1">
                                            <i class="ti-shopping-cart fa-4x"></i>
                                        </div>
                                        <div class="widget-detail-1">
                                    <h5 class="text-primary text-uppercase"><strong>Total Pembelian</strong></h5>
                                    <h2 class="p-t-10 m-b-0">Rp.<?php echo number_format($data_order['total'],0,',','.'); ?>-,</h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <div class="card-box">
                                    <div class="widget-chart-1">
                                        <div class="widget-chart-box-1">
                                            <i class="fa fa-money fa-4x"></i>
                                        </div>
                                        <div class="widget-detail-1">
                                    <h5 class="text-primary text-uppercase"><strong>Sisa Saldo</strong></h5>
                                    <h2 class="p-t-10 m-b-0">Rp.<?php echo number_format($data_user['balance'],0,',','.'); ?>-,</h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
							<div class="col-lg-4 col-md-4">
                                <div class="card-box">
                                    <div class="widget-chart-1">
                                        <div class="widget-chart-box-1">
                                            <i class="fa fa-calendar fa-4x"></i>
                                        </div>
                                        <div class="widget-detail-1">
                                    <h5 class="text-primary text-uppercase"><strong>Total Pesanan</strong></h5>
                                    <h2 class="p-t-10 m-b-0"><?php echo number_format($count_orders,0,',','.'); ?> Pesanan</h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
	                    </div>

                          <div class="row">
							<div class="col-md-8">
									<div class="panel panel-border panel-primary">
                                    <div class="panel-heading"> 
                                        <h3 class="panel-title"><i class="fa fa-info-circle"></i> Berita:</h3> 
                                    </div> 
                                    <div class="panel-body">
										<div class="table-responsive">
											<table class="table table-striped table-bordered table-hover m-0">
												<thead>
													<tr>
														<th>#</th>
														<th>Tanggal</th>
														<th>Konten</th>
													</tr>
												</thead>
												<tbody>
													<?php
													$check_news = mysqli_query($db, "SELECT * FROM news ORDER BY id DESC LIMIT 5");
													$no = 1;
													while ($data_news = mysqli_fetch_assoc($check_news)) {
													?>
													<tr>
														<th scope="row"><?php echo $no; ?></th>
														<td><?php echo $data_news['date']; ?></td>
														<td><?php echo $data_news['content']; ?></td>
													</tr>
													<?php
													$no++;
													}
													?>
												</tbody>
											</table>
										</div>
                                   </div>
								</div>
							</div>
							<div class="col-md-4">
									<div class="panel panel-border panel-primary">
                                    <div class="panel-heading"> 
                                        <h3 class="panel-title"><i class="fa fa-user"></i> Detail Akun</h3> 
                                    </div> 
                                    <div class="panel-body">
										<div class="table-responsive">
                                              <table class="table table-bordered table-hover">
												<tbody>
													<tr>
														<td><b>Username</b></td>
														<td><?php echo $data_user['username']; ?></td>
													</tr>
													<tr>
														<td><b>Tanggal Daftar</b></td>
														<td><?php echo $data_user['registered']; ?></td>
													</tr>
													<tr>
														<td><b>Status</b></td>
														<td><?php echo $data_user['status']; ?></td>
													</tr>
													<?php
echo "<tr>
														<td><b>Waktu</b></td> <td>" . date("Y-m-d h:i:sa") . "<br></tr>";
?>
														<?php echo $tgl; ?>
													</tr>												    
														<td><b>Api Key</b></td>
														<td><?php echo $data_user['api_key']; ?></td>
													</tr>
													<tr>													    
														<td><b>Pengunjung</b></td>
														<td><!-- Histats.com  (div with counter) --><div id="histats_counter"></div>
<!-- Histats.com  START  (aync)-->
<script type="text/javascript">var _Hasync= _Hasync|| [];
_Hasync.push(['Histats.start', '1,4070354,4,601,110,30,00010101']);
_Hasync.push(['Histats.fasi', '1']);
_Hasync.push(['Histats.track_hits', '']);
(function() {
var hs = document.createElement('script'); hs.type = 'text/javascript'; hs.async = true;
hs.src = ('//s10.histats.com/js15_as.js');
(document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(hs);
})();</script>
<noscript><a href="/" target="_blank"><img  src="//sstatic1.histats.com/0.gif?4070354&101" alt="hit counter code" border="0"></a></noscript>
<!-- Histats.com  END  --></td>														
													</tr>
												</tbody>
											</table>
	<!-- <div class="col-xs-6">
		<ul class="pull-right list-inline m-b-0">
							<li><a href="/tos">Ketentuan Layanan</a></li>
						</ul>
	</div>
	<div class="col-xs-3 text-right">
		<small class="text-muted">v1.5.1 [0.0347s] <b>Kome-Ine Creative.</b></small>
	</div> -->
</div>		</div>
	</footer>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- end row -->
								</div>
							</div>
						</div>
<?php
} else {
?>
						<div class="row">
							<div class="col-md-6">
								<div class="panel panel-border panel-primary">
                                    <div class="panel-heading"> 
                                        <h3 class="panel-title"><i class="fa fa-sign-in"></i> Login Akun Anda Sekarang Juga!</h3> 
                                    </div> 
                                    <div class="panel-body">
									    <?php 
										if ($msg_type == "error") {
										?>
										<div class="alert alert-danger">
											<i class="fa fa-times-circle"></i>
											<?php echo $msg_content; ?>
										</div>
										<?php
										}
										?>

											<form class="form-horizontal" role="form" method="POST">
											<div class="form-group row">
												<label class="col-md-2 control-label">Username</label>
												<div class="col-md-10">
													<input type="text" name="username" class="form-control" placeholder="Username" title="Isi Username"/>
												</div>
											</div>
											<div class="form-group row">
												<label class="col-md-2 control-label">Password</label>
												<div class="col-md-10">
													<input type="password" name="password" class="form-control" placeholder="Password" title="Isi Kata Sandi"/>
												</div>
											</div>
											<button type="submit" class="pull-right btn btn-primary btn-rounded waves-effect waves-light m-b-5" name="login">Masuk</button>
										</form>
<div class="clearfix"></div>
									</div>
									<div class="panel-footer">
										Tidak punya akun? <a href="register.php" class="btn btn-warning btn-rounded waves-effect waves-light m-b-5">Daftar!</a>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="panel panel-border panel-primary">
                                    <div class="panel-heading"> 
                                        <h3 class="panel-title"><i class="fa fa-info-circle"></i> Tentang Dimas SMM Panel</h3> 
                                    </div> 
                                    <div class="panel-body">
									<?php echo $cfg_about; ?>
	<!-- <div class="col-xs-6">
		<ul class="pull-right list-inline m-b-0">
							<li><a href="/tos">Ketentuan Layanan</a></li>
						</ul>
	</div>
	<div class="col-xs-3 text-right">
		<small class="text-muted">v1.5.1 [0.0347s] <b>Kome-Ine Creative.</b></small>
	</div> -->
</div>		</div>
								</div>
	
								<div class="col-md-6">
								<div class="panel panel-border panel-primary">
                                    <div class="panel-heading"> 
                                        <h3 class="panel-title"><i class="fa fa-phone"></i> Contact</h3> 
                                    </div> 
                                    <div class="panel-body">
                                        <center>
                                        <a href="https://api.whatsapp.com/send?phone=000&text=Hello admin !" class="btn btn-primary"><i class="fa fa-whatsapp"></i> Whatsapp </a>
										<a href="https://instagram.com/jago.sosmed" class="btn btn-primary"><i class="fa fa-instagram"></i> instagram </a>  						
  										<a href="http://line.me/ti/p/belumada" class="btn btn-primary"><i class="fa fa-phone"></i> Line </a>
								</div>
							</div>
						</div>

						<!-- end row -->
</section>
            </div>
            <!-- Main content ends -->

            <!-- Container-fluid ends -->
        </div>
    </div>


<?php
}
include("lib/footer.php");
?>