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

	include("lib/header.php");
	$msg_type = "nothing";

	
	$check_user = mysqli_query($db, "SELECT * FROM users WHERE username = '$sess_username'");
	$data_user = mysqli_fetch_assoc($check_user);
	
	$check_depo = mysqli_query($db, "SELECT * FROM deposits_history WHERE user = '$sess_username' AND status = 'Pending'");
	
	if(isset($_POST['deposit'])) {
	 $post_method = $_POST['method'];
	 $post_quantity = $_POST['quantity'];
	 $post_pengirim = $_POST['sending'];
	 $post_code = "48P-DEPOSIT-".random(6)."";
	 
	 $query_depo = mysqli_query($db, "SELECT * FROM deposits_method WHERE id = '$post_method'");
	 $data_depo = mysqli_fetch_assoc($query_depo);
	 
	 $getbalance = $post_quantity*$data_depo['rate'];
	 
	 if(preg_match("/./", $post_quantity)) {
	  $post_quantity = str_replace(".","", $post_quantity);
	 }
	 
	 
	 if(empty($post_method) AND empty($post_quantity)) {
	    $msg_type = "error";
	    $msg_content = "<b>Gagal:</b> Mohon lengkapi semua input.";
	 } else if($post_quantity < 5000) {
	    $msg_type = "error";
	    $msg_content = "<b>Gagal:</b> Minimal topup adalah Rp. 5.000";
	 } else {
	    $insert_depo = mysqli_query($db, "INSERT INTO deposits_history (user, code, quantity, pengirim, get_balance, link_confirm, method, date, time, status) VALUES ('$sess_username', '$post_code', '$post_quantity', '$post_pengirim', '$getbalance', '', '".$data_depo['method']."', '$date', '$time', 'Pending')");
	    if($insert_depo == TRUE) {
	     $msg_type = "success";
	     $msg_content = "<b>Berhasil:</b> Permintaan Deposit Berhasil. <br /> Metode : ".$data_depo['method']." <br /> 
	         Nomor Pengirim : $post_pengirim <br /> 
	         Silahkan Transfer ke : ".$data_depo['note']." dengan jumlah Rp. ".$post_quantity." Dan anda akan mendapatkan saldo Rp. $getbalance <br /> Jika sudah Transfer Klik Konfirmasi Deposit Manual Anda. <br /> <center><a href='konfirm_deposit.php?code=$post_code'><span class='label bg-danger'>Konfirmasi Deposit</span></a></center>";
	     echo '';
	     } else {
	     $msg_type = "error";
	     $msg_content = "<b>Gagal:</b> System error #1";	     
	 }
}
}
?>

<?php if (mysqli_num_rows($check_depo) == 1 or mysqli_num_rows($check_depo) > 1){
 ?>
                        
<div class="row">
							<div class="col-md-7">
								<div class="panel panel-border panel-primary">
                                    <div class="panel-heading"> 
                                        <h3 class="panel-title"><i class="fa fa-money"></i> Anda Tidak Dapat Mengakses</h3>        
                                    </div> 
                                    <div class="panel-body">
									    <b>- Anda masih memiliki deposit yang pending segera selesaikan.</b> <br />
									    <b>- Silahkan klik link <a href="<?php echo $cfg_baseurl; ?>deposit_history.php"; ?>Berikut</a> Untuk menyelesaikan deposit anda.</b> <br /> <br />
									    	<div id="pesan">
									    	</div>
									   </div>
								</div>
							</div>
									    	<div class="col-md-5">
							<div class="panel panel-border panel-primary">
                                    <div class="panel-heading"> 
                                        <h3 class="panel-title"><i class="fa fa-info"></i> Informasi</h3> 
                                    </div> 
                                    <div class="panel-body">
<ul>
											<li>Jangan Input Deposit yang sama</li> 
											<li>Harap Tungguh Status <span class="label bg-success">Success</span></li>
											<li>Minimal Deposit Rp. 5.000 baik via BANK / PULSA.</li>
                                     	    <li>Anda Akan Dialihkan Ke Riwayat Saldo</li>
                                     	    <li>Pembayaran Via Perfectmoney Hubungi Admin</li>                                     	    
                                     	    <li>Jika Butuh Bantuan Silahkan Hubungi Admin</li>
										</ul>
									</div>
								</div>
							</div>
						</div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script>
            var url = "<?php echo $cfg_baseurl; ?>deposit_history.php"; // url tujuan
            var count = 5; // dalam detik
            function countDown() {
                if (count > 0) {
                    count--;
                    var waktu = count + 1;
                    $('#pesan').html('<b>- Anda akan di alihkan ke ' + url + ' dalam ' + waktu + ' detik untuk menyelesaikan deposit anda. </b>');
                    setTimeout("countDown()", 1000);
                } else {
                    window.location.href = url;
                }
            }
            countDown();
        </script>

<?php
} else {
?>
                        
 <div class="row">
							<div class="col-md-7">
								<div class="panel panel-border panel-primary">
                                    <div class="panel-heading"> 
                                        <h3 class="panel-title"><i class="fa fa-money"></i> Deposit Saldo</h3>        
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
												<label class="col-md-2 control-label">Metode</label>
												<div class="col-md-10">
													<select class="form-control" name="method" id="depomethod">
														<option value="0">Pilih salah satu...</option>
<optgroup label="Bank">
														<?php
														$check_met = mysqli_query($db, "SELECT * FROM deposits_method WHERE tipe = 'Bank' ORDER BY id ASC");
														while ($data_met = mysqli_fetch_assoc($check_met)) {
														?>
														<option value="<?php echo $data_met['id']; ?>"><?php echo $data_met['method']; ?></option>
												
														<?php
														}
														?>
</optgroup>											
														<br />
<optgroup label="Pulsa">
<?php
														$check_met = mysqli_query($db, "SELECT * FROM deposits_method WHERE tipe = 'Pulsa' ORDER BY id ASC");
														while ($data_met = mysqli_fetch_assoc($check_met)) {
														?>
														<option value="<?php echo $data_met['id']; ?>"><?php echo $data_met['method']; ?></option>
												
														<?php
														}
														?>
</optgroup>																												
													</select>
												</div>
											</div>
                                      	<div class="form-group">
												<label class="col-md-2 control-label">Pengirim</label>
												<div class="col-md-10">
													<input type="text" name="sending" class="form-control" placeholder="Nama Pengirim">
												</div>
											</div>
											<input type="hidden" id="rate" value="0">
											<div class="form-group">
												<label class="col-md-2 control-label">Jumlah</label>
												<div class="col-md-10">
													<input type="number" name="quantity" class="form-control" placeholder="Minimal Rp.5.000-," onkeyup="get_total(this.value).value;">
												</div>
											</div>
											<input type="hidden" id="rate" value="0">
											<button type="submit" class="pull-right btn btn-success btn-bordered waves-effect w-md waves-light" name="deposit">Buat Permintaan Deposit</button>
										</form>
<div class="clearfix"></div>
									</div>
								</div>
							</div>
<div class="col-md-5">
							<div class="panel panel-border panel-primary">
                                    <div class="panel-heading"> 
                                        <h3 class="panel-title"><i class="fa fa-info"></i> Informasi</h3> 
                                    </div> 
                                    <div class="panel-body">
<ul>
											<li>Jangan Input Deposit yang sama</li> 
											<li>Harap Tungguh Status <span class="label bg-success">Success</span></li>
											<li>Minimal Deposit Rp. 5.000 baik via BANK / PULSA.</li>
                                     	    <li>Table "Pengirim" Isikan Nama Pengirim</li>
                                     	    <li>Pembayaran Via Perfectmoney Hubungi Admin</li>                                     	    
                                     	    <li>Jika Butuh Bantuan Silahkan Hubungi Admin</li>
									        <center>                                     	    
									        <img src="https://4.bp.blogspot.com/-MsTtnq6HtQI/Wf_yXAKGRcI/AAAAAAAABLM/RhN9xoejjLkvwsUCGwHUzU4t3mNFW6w4QCKgBGAs/s1600/unnamed%2B%25284%2529.png" high="100" width="100">
									        <img src="https://3.bp.blogspot.com/-ZK6W9UlA3lw/V15RGexr3yI/AAAAAAAAAJ4/nkyM9ebn_qg3_rQWyBZ1se5L_SSuuxcDACLcB/s640/Bank_Central_Asia.png" high="90" width="90">
									        <img src="https://upload.wikimedia.org/wikipedia/id/5/55/BNI_logo.svg" high="90" width="90">
									        <img src="https://upload.wikimedia.org/wikipedia/commons/9/97/Logo_BRI.png" high="90" width="90"></p>
									        <center>
									        <img src="http://2.bp.blogspot.com/-zoz4My8uhK8/UDBHdFrCH0I/AAAAAAAAAK4/nGwPkAkXreE/s1600/logo+telkomsel.png" high="100" width="100">
									        <img src="https://www.xl.co.id/sites/default/files/media-kit/png_XL_Axiata%20Logo_mediakit-01-01.png" high="100" width="100"></p>
										</ul>
									</div>
								</div>
							</div>
						</div>
						<!-- end row -->
<?php
}
	include("lib/footer.php");
} else {
	header("Location: ".$cfg_baseurl);
}
?>