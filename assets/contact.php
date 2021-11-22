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

                <h1 class="text-center">Silahkan kontak admin melalui kontak berikut ini</h1><br>                    	
            <div class="row">
                <div class="col-md-4">
                    <div class="text-center">
                        <img src="/image/wa.png" style="width: 100px;"><br /><hr>
                        <div class="padding-20 text-center">
                            <a href="https://api.whatsapp.com/send?phone=081296341177text=Moshi Moshi" class="btn btn-primary"><i class="fa fa-whatsapp"></i> Whatsapp </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="text-center">
                        <img src="/image/instagram-new.png" style="width: 100px;"><br /><hr>
                        <div class="padding-20 text-center">
                            <a href="http://instagram.com/dimas.aryap" class="btn btn-primary"><i class="fa fa-instagram"></i> Instagram </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="text-center">
                        <img src="/image/line.png" style="width: 100px;"><br /><hr>
                        <div class="padding-20 text-center">
                            <a href="http://line.me/ti/p/yayayayayaya" class="btn btn-primary"><i class="fa fa-phone"></i> Line </a>
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
						
						
						
						
						
						
						