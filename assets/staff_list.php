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
 <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->                      
            <div class="content-page">
                <!-- Start content -->
                <div class="content">
                    <div class="container">

                        <!-- Page-Title -->
                        <div class="row">
                            <div class="col-sm-12">
                            </div>
                        </div>
                        
							
							<div class="row">
							<div class="col-md-12">
								<div class="alert alert-icon bg-primary alert-dismissible fade in" role="alert">
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
									<i class="fa fa-info-circle"></i> Anda dapat menghubungi kami untuk Daftar/mengisi saldo.
							</div>
								<div class="col-md-6">
									<div class="white-box text-center bg-info" style="padding: 20px 0;">
										<img src="https://previews.123rf.com/images/provector/provector1501/provector150100144/35282212-Flat-Busness-Man-User-Profile-Avatar-in-Suit-icon-design-and-long-shadow-vector-illustration-for-web-Stock-Vector.jpg" class="img-thumbnail" style="width: 100px; border-radius: 50px;"><br />
										<h4 class="text-black text-uppercase"><i class="ti-user"></i>Mohamad Ardan</h4>
										<p class="text-black text-uppercase">Developer</p>
										<p style="padding-right:10px;"><img src="../image/Line.png"> Line : @ardansan ( Tidak Pakai @ )</p>
										<p style="padding-right:10px;"><img src="../image/WA.png"> WA/TLPN/SMS : 0895-3735-4901-4 ( Fast Respon )</p>
										<p style="padding-right:10px;"><img src="../image/Facebook.png"> www.facebook.com/mohamadardanjp/</p>
											<center>
											<a href="https://api.whatsapp.com/send?phone=62895373549014&text=Hello%20admin%20!" class="btn btn-success btn-bordered waves-effect w-md waves-light"><i class="fa fa-whatsapp"></i> via WhatsApp</button></a>
									</div>
								</div> <!-- end col -->
								
																<div class="col-md-6">
									<div class="white-box text-center bg-info" style="padding: 20px 0;">
										<img src="https://previews.123rf.com/images/provector/provector1501/provector150100144/35282212-Flat-Busness-Man-User-Profile-Avatar-in-Suit-icon-design-and-long-shadow-vector-illustration-for-web-Stock-Vector.jpg" class="img-thumbnail" style="width: 100px; border-radius: 50px;"><br />
										<h4 class="text-black text-uppercase"><i class="ti-user"></i>Mohamad Ardan</h4>
										<p class="text-black text-uppercase">Reseller</p>
										<p style="padding-right:10px;"><img src="../image/Line.png"> Line : @ardansan ( Tidak Pakai @ )</p>
										<p style="padding-right:10px;"><img src="../image/WA.png"> WA/TLPN/SMS : 0895-3735-4901-4 ( Fast Respon )</p>
										<p style="padding-right:10px;"><img src="../image/Facebook.png"> www.facebook.com/mohamadardanjp/</p>
											<center>
											<a href="https://api.whatsapp.com/send?phone=62895373549014&text=Hello%20admin%20!" class="btn btn-success btn-bordered waves-effect w-md waves-light"><i class="fa fa-whatsapp"></i> via WhatsApp</button></a>
									</div>
								</div> <!-- end col -->
							
						<!-- end row -->
													
								</div>
							</div>
						</div>
<?php
include("lib/footer.php");
?>