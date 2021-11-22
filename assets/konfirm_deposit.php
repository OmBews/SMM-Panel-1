<?php // Source By root~source or YarzCode <3
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
	} else {
	if (isset($_GET['code'])) {
	$post_code = $_GET['code'];
    $check_history = mysqli_query($db, "SELECT * FROM deposits_history WHERE code = '$post_code'");
    $data_history = mysqli_fetch_assoc($check_history);
    $links = $data_history['link_confirm'];
    if(mysqli_num_rows($check_history) == 0) {
		header("Location: ".$cfg_baseurl."deposit_history.php");
    } else if($data_history['user'] !== $sess_username) {
		header("Location: ".$cfg_baseurl."deposit_history.php");
    } else if($data_history['status'] !== "Pending") {
		header("Location: ".$cfg_baseurl."deposit_history.php");
    } else if(!empty($links)) {
        if($data_history['status'] == "Pending") {
            $update = mysqli_query($db, "UPDATE deposits_history set status = 'Processing'");
		    header("Location: ".$cfg_baseurl."deposit_history.php");
        }
		header("Location: ".$cfg_baseurl."deposit_history.php");
    } else {
        if(isset($_POST['konfirmasi'])) {
            $post_bukti = $_POST['bukti'];
            if(empty($post_bukti)) {
                $msg_type = "error";
                $msg_content = "<b>Gagal:</b> Mohon mengisi input.";
            } else {
                $update_depo = mysqli_query($db, "UPDATE deposits_history set link_confirm = '$post_bukti' WHERE code = '$post_code'");
                $update_depo = mysqli_query($db, "UPDATE deposits_history set status = 'Processing' WHERE code = '$post_code'");      
                if($update_depo == TRUE) {
                   header("Location: ".$cfg_baseurl."deposit_history.php");
                } else {
                    $msg_type = "error";
                    $msg_content = "<b> Gagal : </b> System Error #1";
                }
            }
        }
    }
	include("lib/header.php");
	$msg_type = "nothing";

	
	$check_user = mysqli_query($db, "SELECT * FROM users WHERE username = '$sess_username'");
	$data_user = mysqli_fetch_assoc($check_user);

?>
            <!-- Start right Content here -->
            <!-- ============================================================== -->                      
            <div class="content-page">
                <!-- Start content -->
                <div class="content">
                    <div class="container">
                        
                       <div class="row">
                           <div class="col-md-12">
                             <div class="text-center">
                             <div class="alert bg-danger alert-styled-left">
                             <button type="button" class="close" data-dismiss="alert"><span>&times;</span>
                             <span class="sr-only">Close</span></button>
                            <span class="text-semibold">Demi Kenyamanan Pengguna, Harap memberikan tulisan "DEPOSIT DIMSP" diBukti Transfer/Struk. Jika tidak akan kami tolak. :)</span>
                            </div></div>                               
                           </div>
                       </div>

						<div class="row">
							<div class="col-md-12">
								<div class="panel panel-border panel-primary">
                                    <div class="panel-heading"> 
                                        <h3 class="panel-title"><i class="fa fa-edit"></i> Konfirmasi Bukti Pembayaran</h3>        
                                    </div> 
                                    <div class="panel-body">
										<?php 
										if ($msg_type == "success") {
										?>
										<div class="alert alert-icon alert-success alert-dismissible fade in" role="alert">
											<button type="button" class="close" data-dismiss="alert" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
											<i class="fa fa-check-circle"></i>
											<?php echo $msg_content; ?>
										</div>
										<?php
										} else if ($msg_type == "error") {
										?>
										<div class="alert alert-icon alert-danger alert-dismissible fade in" role="alert">
											<button type="button" class="close" data-dismiss="alert" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
											<i class="fa fa-times-circle"></i>
											<?php echo $msg_content; ?>
										</div>
										<?php
										}
										?>
										<form class="form-horizontal" role="form" method="POST">
											<div class="form-group">
												<label class="col-md-2 control-label">Kode Deposit</label>
												<div class="col-md-10">
													<input type="text" class="form-control" placeholder="Kode Deposit" value="<?php echo $post_code; ?>" readonly>
												</div>
											</div>
                                      	<div class="form-group">
												<label class="col-md-2 control-label">Pengirim</label>
												<div class="col-md-10">
													<input type="text" class="form-control" placeholder="Sending" value="<?php echo $data_history['pengirim']; ?>" readonly>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-2 control-label">Metode</label>
												<div class="col-md-10">
													<input type="text" class="form-control" placeholder="Kode Deposit" value="<?php echo $data_history['method']; ?>" readonly>
												</div>
											</div>	
                                    	<div class="form-group">
												<label class="col-md-2 control-label">Jumlah</label>
												<div class="col-md-10">
													<input type="text" class="form-control" placeholder="Kode Deposit" value="<?php echo $data_history['quantity']; ?>" readonly>
												</div>
											</div>
                             	<div class="form-group">
												<label class="col-md-2 control-label">Saldo yg diterima</label>
												<div class="col-md-10">
													<input type="text" class="form-control" placeholder="Kode Deposit" value="<?php echo $data_history['get_balance']; ?>" readonly>
												</div>
											</div>											
<label><h4>Ikuti Langkah Berikut :</h4></label>
<ol class="list-p"><b>
<li><b>Setelah Transfer Mohon tuliskan dalam berita Transfer dengan Format "Topup DIMSP : username anda"<br /></li>
<li><b>Upload foto / bukti transfer ke <a href="http://prntscr.com" target="_blank">http://prntscr.com</a>. Atau: <a href="https://postimage.org/?lang=indonesia" target="_blank">https://postimage.org</a>. ke Sosmed juga bisa atau bebas :) </b></li>
<li><b>Copy URL foto bukti transfer yang telah diupload ke <a href="https://postimg.org" target="_blank">https://postimg.org/</a>". </b></li>
<li><b>Penting! Jika tidak memberikan URL foto bukti transfer & Mengisi data yang diminta, maka Deposit tidak akan diproses! </b></li>
</ol></b> <p align="justify"><span style="color: red;"><i>* Perhatikan langkah nomer 1.</i></span></p>
											<div class="form-group">
												<label class="col-md-2 control-label">Bukti Pembayaran</label>
												<div class="col-md-10">
													<input type="url" name="bukti" class="form-control" placeholder="Link Bukti Pembayaran / Transfer">
												</div>
											</div>

										
											
											<a href="<?php echo $cfg_baseurl; ?>deposit_history.php" class="btn btn-info btn-bordered waves-effect w-md waves-light">Kembali ke Riwayat deposit</a>
											<div class="pull-right">
												<button type="reset" class="btn btn-danger btn-bordered waves-effect w-md waves-light">Ulangi</button>
												<button type="submit" class="btn btn-success btn-bordered waves-effect w-md waves-light" name="konfirmasi">Konfirmasi</button>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
						<!-- end row -->

<?php
				include("lib/footer.php");
		} else {
			header("Location: ".$cfg_baseurl);
		}
	}
} else {
	header("Location: ".$cfg_baseurl);
}
?>