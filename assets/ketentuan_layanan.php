<?php
session_start();
require("mainconfig.php");

if (isset($_SESSION['user'])) {
	$sess_username = $_SESSION['user']['username'];
	$check_user = mysqli_query($db, "SELECT * FROM users WHERE username = '$sess_username'");
	$data_user = mysqli_fetch_assoc($check_user);
	if (mysqli_num_rows($check_user) == 0) {
		header("Location: ".$cfg_baseurl."logout.php");
	} else if ($data_user['status'] == "Suspended") {
		header("Location: ".$cfg_baseurl."logout.php");
	}
}

include("lib/header.php");
?>
                        
				<div class="row">
                            <div class="col-md-offset-2 col-md-8">
                                <div class="panel panel-custom panel-border">
                                    <div class="panel-heading">
                                        <h3 class="panel-title"><i class="fa fa-info-circle"></i> Ketentuan Layanan</h3> 
                                    </div> 
                                    <div class="panel-body"> 
										<p>Keputusan Dibawah Tidak Dapat Diganggu Gugat, Kami Pihak <?php echo $cfg_webname; ?> Berhak Mengubah Ketentuan Ini Tanpa Pemberitahuan Terlebih Dahulu.</p>
										<div class="col-lg-12">
                                    <div class=""><br />
                                        <div class="panel-group m-b-0" id="accordion" role="tablist"
                                             aria-multiselectable="true">
                                            <div class="panel panel-default bx-shadow-none">
                                                <div class="panel-heading" role="tab" id="headingOne">
                                                    <h4 class="panel-title">
                                                        <a role="button" data-toggle="collapse"
                                                           data-parent="#accordion" href="#collapseOne"
                                                           aria-expanded="true" aria-controls="collapseOne">
                                                            1. Umum
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="collapseOne" class="panel-collapse collapse in"
                                                     role="tabpanel" aria-labelledby="headingOne">
                                                    <div class="panel-body">
                                                    <ul>
							                            <li>Dengan Mendaftar Dan Menggunakan Layanan <?php echo $cfg_logo_txt; ?>, Anda Secara Otomatis Menyetujui Semua <b>Ketentuan Layanan</b> Kami.</li>
							                            <li>Kami Berhak Mengubah <b>Ketentuan Layanan</b> Ini Tanpa Pemberitahuan Terlebih Dahulu.</li>
							                            <li><?php echo $cfg_logo_txt; ?> <b>Tidak Bertanggung Jawab</b> Apabila Anda Mengalami Kerugian Dalam Bisnis Anda.</li>
							                            <li><?php echo $cfg_logo_txt; ?> <b>Tidak Bertanggung Jawab</b> Apabila Anda Mengalami Suspensi Akun Atau Penghapusan Kiriman Yang Dilakukan Oleh Pihak Instagram, Twitter, Facebook, Youtube, Dan Lain-Lain.</li>
							                            <li>Anda Tidak Dapat Mambatalkan Atau Meminta Pengembalian Dana Pemesanan Dan Deposit, Kecuali Apabila Pesanan Tersebut Gagal.</li>
							                        </ul>
                                                    </div>
                                                </div>
                                            </div>
										<div class="panel panel-default bx-shadow-none">
                                                <div class="panel-heading" role="tab" id="headingTwo">
                                                    <h4 class="panel-title">
                                                        <a class="collapsed" role="button" data-toggle="collapse"
                                                           data-parent="#accordion" href="#collapseTwo"
                                                           aria-expanded="false" aria-controls="collapseTwo">
                                                            2. Layanan
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="collapseTwo" class="panel-collapse collapse"
                                                     role="tabpanel" aria-labelledby="headingTwo">
                                                    <div class="panel-body">
                                                    <ul>
							                            <li><?php echo $cfg_logo_txt; ?> Berhak <b>Menghapus</b>, <b>Mengubah</b>, Serta <b>Memperbaharui</b> Layanan Tanpa Pemberitahuan Terlebih Dahulu.</li>
							                            <li>Anda Tidak Dapat Melakukan Pemesanan Untuk Hal Yang Bersifat <b>Melanggar</b> Hukum.</li>
							                            <li><?php echo $cfg_logo_txt; ?> <b>Tidak Menjamin</b> Semua Layanan Dapat Bertahan Selamanya.</li>
							                            <li><?php echo $cfg_logo_txt; ?> <b>Tidak Menjamin</b> Bahwa Pengikut Baru Yang Anda Pesan Berinteraksi Dengan Anda.</li>
							                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="panel panel-default bx-shadow-none">
                                                <div class="panel-heading" role="tab" id="headingThree">
                                                    <h4 class="panel-title">
                                                        <a class="collapsed" role="button" data-toggle="collapse"
                                                           data-parent="#accordion" href="#collapseThree"
                                                           aria-expanded="false" aria-controls="collapseThree">
                                                            3. Pembayaran
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="collapseThree" class="panel-collapse collapse"
                                                     role="tabpanel" aria-labelledby="headingThree">
                                                    <div class="panel-body">
                                                    <ul>
							                            <li><?php echo $cfg_logo_txt; ?> <b>Tidak Akan</b> Memberikan Pengembalian Dana Untuk Pesanan Dan Deposit Yang Telah Anda Lakukan.</li>
							                            <li>Jika <b>Pengguna</b> Terbukti Melakukan <b>Kecurangan</b> Saat Melakukan Pembayaran Baik Dalam <b>Pesanan</b> Ataupun <b>Deposit</b>, Maka Pihak <?php echo $cfg_logo_txt; ?> Akan Menghapus Secara <b>Permanen</b> Akun Terkait.</li>
							                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
						<!-- end row -->
					<?php
include("lib/footer.php");
?>	
						
						
						
						
						
						
						