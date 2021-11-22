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
                                        <h3 class="panel-title">Pertanyaan Umum</h3>
                                    </div>
                                    <div class="panel-body">
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
                                                            1. Bagaimana Cara Mendaftar?
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="collapseOne" class="panel-collapse collapse in"
                                                     role="tabpanel" aria-labelledby="headingOne">
                                                    <div class="panel-body">
                                                    Untuk Pendaftaran, Silahkan Anda Menghubungi <a href="/contact.php"><b>Admin</b></a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="panel panel-default bx-shadow-none">
                                                <div class="panel-heading" role="tab" id="headingTwo">
                                                    <h4 class="panel-title">
                                                        <a class="collapsed" role="button" data-toggle="collapse"
                                                           data-parent="#accordion" href="#collapseTwo"
                                                           aria-expanded="false" aria-controls="collapseTwo">
                                                            2. Bagaimana Cara Membuat Pesanan?
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="collapseTwo" class="panel-collapse collapse"
                                                     role="tabpanel" aria-labelledby="headingTwo">
                                                    <div class="panel-body">
                                                    Anda Bisa Pergi Ke Halaman Media Sosial Untuk Membuat Pesanan, Bacalah Informasi Pada Halaman Tersebut Sebelum Melakukan Pemesanan.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="panel panel-default bx-shadow-none">
                                                <div class="panel-heading" role="tab" id="headingThree">
                                                    <h4 class="panel-title">
                                                        <a class="collapsed" role="button" data-toggle="collapse"
                                                           data-parent="#accordion" href="#collapseThree"
                                                           aria-expanded="false" aria-controls="collapseThree">
                                                            3. Bagaimana Cara Mengisi Saldo?
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="collapseThree" class="panel-collapse collapse"
                                                     role="tabpanel" aria-labelledby="headingThree">
                                                    <div class="panel-body">
                                                    Anda Dapat Mengisi Saldo Melalui Halaman Saldo --> Deposit Yang Sudah Kami Sediakan, Pembayaran Bisa Dilakukan Melalui <b>Bank BCA | BNI | BRI</b> Dan <b>Pulsa Telkomsel | Axis/XL</b>.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="panel panel-default bx-shadow-none">
                                                <div class="panel-heading" role="tab" id="headingFour">
                                                    <h4 class="panel-title">
                                                        <a class="collapsed" role="button" data-toggle="collapse"
                                                           data-parent="#accordion" href="#collapseFive"
                                                           aria-expanded="false" aria-controls="collapseFive">
                                                            4. Bagaimana Jika Pesanan Saya Gagal?
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="collapseFive" class="panel-collapse collapse"
                                                     role="tabpanel" aria-labelledby="headingFive">
                                                    <div class="panel-body">
                                                    Website  Memiliki Fitur Yang Serba Otomatis. Saldo Anda Akan Dikembalikan Secara Otomatis Oleh Server Apabila Pesanan Anda Gagal.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="panel panel-default bx-shadow-none">
                                                <div class="panel-heading" role="tab" id="headingSix">
                                                    <h4 class="panel-title">
                                                        <a class="collapsed" role="button" data-toggle="collapse"
                                                           data-parent="#accordion" href="#collapseSix"
                                                           aria-expanded="false" aria-controls="collapseSix">
                                                            5. Bagaimana Jika Ada Masalah Pada Akun Saya?
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="collapseSix" class="panel-collapse collapse"
                                                     role="tabpanel" aria-labelledby="headingSix">
                                                    <div class="panel-body">
                                                    Kami Memiliki Fitur Support Tiket Yang Berfungsi Untuk Pengguna Jika Ingin Melaporkan Masalah.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="panel panel-default bx-shadow-none">
                                                <div class="panel-heading" role="tab" id="headingSeven">
                                                    <h4 class="panel-title">
                                                        <a class="collapsed" role="button" data-toggle="collapse"
                                                           data-parent="#accordion" href="#collapseSeven"
                                                           aria-expanded="false" aria-controls="collapseSeven">
                                                            6. Bagaimana Jika Saya Ingin cURL?
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="collapseSeven" class="panel-collapse collapse"
                                                     role="tabpanel" aria-labelledby="headingSeven">
                                                    <div class="panel-body">
                                                    Kami Memiliki Fitur <b><a href="javascript:void(0);">API Integration</a></b> Yang Memudahkan Anda Dalam Melakukan Pemesanan Di Website Lain.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="panel panel-default bx-shadow-none">
                                                <div class="panel-heading" role="tab" id="headingEight">
                                                    <h4 class="panel-title">
                                                        <a class="collapsed" role="button" data-toggle="collapse"
                                                           data-parent="#accordion" href="#collapseEight"
                                                           aria-expanded="false" aria-controls="collapseSeven">
                                                            7. Bagaimana Kalau Saya Ingin Membuat Web Panel?
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="collapseEight" class="panel-collapse collapse"
                                                     role="tabpanel" aria-labelledby="headingEight">
                                                    <div class="panel-body">
                                                    Anda Bisa Menghubungi <a href="/contact.php"><b>Admin</b></a>
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