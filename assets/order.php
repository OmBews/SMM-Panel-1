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
	if (isset($_SESSION['user'])) {
	$msg_type = "nothing";

	if (isset($_POST['order'])) {
		$post_service = $_POST['service'];
		$post_quantity = $_POST['quantity'];
		$post_link = trim($_POST['link']);

		$check_service = mysqli_query($db, "SELECT * FROM services WHERE sid = '$post_service'");
		$data_service = mysqli_fetch_assoc($check_service);

		$rate = $data_service['price'] / 1000;
		$price = $rate*$post_quantity;
		$oid = "DIMS-ORDER-".random(6)."";
		$service = $data_service['service'];
		$provider = $data_service['provider'];
		$pid = $data_service['pid'];

		$check_provider = mysqli_query($db, "SELECT * FROM provider WHERE code = '$provider'");
		$data_provider = mysqli_fetch_assoc($check_provider);

		if (empty($post_service) || empty($post_link) || empty($post_quantity)) {
			$msg_type = "error";
			$msg_content = "<b>Gagal:</b> Mohon mengisi input.";
		} else if (mysqli_num_rows($check_service) == 0) {
			$msg_type = "error";
			$msg_content = "<b>Gagal:</b> Layanan tidak ditemukan.";
		} else if (mysqli_num_rows($check_provider) == 0) {
			$msg_type = "error";
			$msg_content = "<b>Gagal:</b> Server Maintenance.";
		} else if ($post_quantity < $data_service['min']) {
			$msg_type = "error";
			$msg_content = "<b>Gagal:</b> Jumlah minimal adalah ".$data_service['min'].".";
		} else if ($post_quantity > $data_service['max']) {
			$msg_type = "error";
			$msg_content = "<b>Gagal:</b> Jumlah maksimal adalah ".$data_service['max'].".";
		} else if ($data_user['balance'] < $price) {
			$msg_type = "error";
			$msg_content = "<b>Gagal:</b> Saldo Anda tidak mencukupi untuk melakukan pembelian ini.";
		} else {

			// api data
			$api_link = $data_provider['link'];
			$api_id = $data_provider['api_id'];
			$api_key = $data_provider['api_key'];
			// end api data

			if ($provider == "JAP") {
				$api_postdata = "key=$api_key&action=add&service=$pid&link=$post_link&quantity=$post_quantity";
			} else if ($provider == "SMMLITE") {
				$api_postdata = "key=$api_key&action=add&service=$pid&link=$post_link&quantity=$post_quantity";
			} else if ($provider == "PEAKERR") {
				$api_postdata = "key=$api_key&action=add&service=$pid&link=$post_link&quantity=$post_quantity";				
			} else if ($provider == "IRVAN") {
			    $api_postdata = "api_id=$api_id&api_key=$api_key&action=order&service=$pid&target=$post_link&quantity=$post_quantity";
			} else {
				die("System Error!");
			}
			
			if($provider == "JAP") {
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "$api_link");
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $api_postdata);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			$chresult = curl_exec($ch);
	//		echo $chresult;
			curl_close($ch);
			$json_result = json_decode($chresult, true);
			} else if($provider == "SMMLITE") {
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "$api_link");
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $api_postdata);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			$chresult = curl_exec($ch);
	//		echo $chresult;
			curl_close($ch);
			$json_result = json_decode($chresult, true);
			} else if($provider == "PEAKERR") {
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "$api_link");
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $api_postdata);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			$chresult = curl_exec($ch);
	//		echo $chresult;
			curl_close($ch);
			$json_result = json_decode($chresult, true);	
			} else if ($provider == "IRVAN") {
			$api_link = $api_link."order";
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "$api_link");
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $api_postdata);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			$chresult = curl_exec($ch);
	//		echo $chresult;
			curl_close($ch);
			$json_result = json_decode($chresult, true); 
			} else if($provider == "MANUAL") {
			    $poid = $oid;
			}

			if ($provider == "JAP" AND $json_result['error'] == TRUE) {
				$msg_type = "error";
				$msg_content = "<b>Gagal:</b> Server Maintenance.";
			} else if ($provider == "SMMLITE" AND $json_result['error'] == TRUE) {
				$msg_type = "error";
				$msg_content = "<b>Gagal:</b> Server Maintenance.";	
			} else if ($provider == "PEAKERR" AND $json_result['error'] == TRUE) {
				$msg_type = "error";
				$msg_content = "<b>Gagal:</b> Server Maintenance.";					
			} else if($provider == "IRVAN" AND $json_result['status'] == FALSE) {
            	$msg_type = "error";
				$msg_content = "<b>Gagal:</b> ".$json_result['data']."";
			} else {
				if ($provider == "JAP") {
					$poid = $json_result['order'];
				} else if ($provider == "SMMLITE") {
					$poid = $json_result['order'];	
				} else if ($provider == "PEAKERR") {
					$poid = $json_result['order'];					
				} else if($provider == "IRVAN") {
				    $poid = $json_result['data']['id'];
				} else if($provider == "MANUAL") {
				    $poid = $oid;
				}
				$update_user = mysqli_query($db, "UPDATE users SET balance = balance-$price WHERE username = '$sess_username'");
				if ($update_user == TRUE) {
					$insert_order = mysqli_query($db, "INSERT INTO orders (oid, poid, user, service, link, quantity, price, status, date, provider, place_from) VALUES ('$oid', '$poid', '$sess_username', '$service', '$post_link', '$post_quantity', '$price', 'pending', '$date', '$provider', 'WEB')");
					$insert_order = mysqli_query($db, "INSERT INTO balance_history (username, action, quantity, price, msg, date, time) VALUES ('$sess_username', 'Cut Balance', '$price', '$price', 'Telah Melakukan Pembelian $service Senilai Rp.$price-,', '$date', '$time')");
					if ($insert_order == TRUE) {
						$msg_type = "success";
						$msg_content = "<b>Pesanan telah diterima.</b><br /><b>Layanan:</b> $service<br /><b>Target:</b> $post_link<br /><b>Jumlah:</b> ".number_format($post_quantity,0,',','.')."<br /><b>Biaya:</b> Rp. ".number_format($price,0,',','.')." <br /><b>Order Key:</b> $oid";
					} else {
						$msg_type = "error";
						$msg_content = "<b>Gagal:</b> Error system (2).";
					}
				} else {
					$msg_type = "error";
					$msg_content = "<b>Gagal:</b> Error system (1).";
				}
			}
		}
	}
	
	$check_user = mysqli_query($db, "SELECT * FROM users WHERE username = '$sess_username'");
	$data_user = mysqli_fetch_assoc($check_user);
?>

                        <div class="row">
							<div class="col-md-7">
								<div class="panel panel-border panel-primary">
                                    <div class="panel-heading"> 
                                        <h3 class="panel-title"><i class="fa fa-shopping-cart"></i> Pesanan Baru</h3>  
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
					<form class="form-horizontal" method="POST">
						<fieldset>
							<div class="form-group row">
												<label class="col-md-2 control-label">Kategori</label>
												<div class="col-md-10">
									<select class="form-control" name="category" id="category">
														<option value="0">Pilih salah satu...</option>
														<?php
														$check_cat = mysqli_query($db, "SELECT * FROM service_cat ORDER BY name ASC");
														while ($data_cat = mysqli_fetch_assoc($check_cat)) {
														?>
														<option value="<?php echo $data_cat['code']; ?>"><?php echo $data_cat['name']; ?></option>
														<?php
														}
														?>
									</select>
								</div>
											</div>
							<div class="form-group row">
												<label class="col-md-2 control-label">Layanan</label>
												<div class="col-md-10">
									<select class="form-control" name="service" id="service">
										<option value="0">Pilih kategori...</option>
									</select>
								</div>
											</div>
							<div id="note"></div>
							<div class="form-group row">
												<label class="col-md-2 control-label">Target</label>
												<div class="col-md-10">
									<input type="text" class="form-control" placeholder="Link/Target" name="link" />
								</div>
											</div>
							<div class="form-group row">
								<input type="hidden" id="rate" value="0">
												<label class="col-md-2 control-label">Jumlah</label>
												<div class="col-md-10">
									<input type="number" class="form-control" placeholder="Jumlah" name="quantity" onkeyup="get_total(this.value).value;">
								</div>
											</div>
							<div class="form-group row">
												<label class="col-md-2 control-label">Harga</label>
												<div class="col-md-10">
													<div class="input-group"><span class="input-group-addon">Rp.</span>
													<input type="number" class="form-control" id="total" readonly="readonly" placeholder="0">
													</div>
													<span class="help-block"></span>
												</div>
											</div>
							<div class="form-actions">
								<div class="form-group">
                                                <div class="col-md-offset-2 col-md-8">
                                                    <button type="reset" class="btn btn-danger"><i class="fa fa-refresh"></i> Ulangi</button>
						                            <button type="submit" class="btn btn-custom btn-bordered waves-effect w-md waves-light" name="order"><i class="fa fa-send"></i> Buat Pesanan</button>
							</div>
						</fieldset>
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

											<li>Masukkan link/target yang benar.</li>
											<li>Akun target harus bersifat publik (tidak private).</li>
											<li>Dilarang Input 2X Dalam 1 Target Tunggulah Sukses.</li>											
											<li><b>Recom</b>: Kategori Guranteed</li>
											<li>Keterangan Server:<br /></li>
											<li>Contoh Memasukkan "Target/Link" :<br /></li>													
											<li><b>Followers IG</b>: dimas.aryap (Tanpa 2)</li>
											<li><b>Likes/Views IG</b>: Cukup masukan Link foto/video</li>
											<li>Jika butuh bantuan silahkan hubungi Admin<br /></li>
</ul>
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
						
<?php
	include("lib/footer.php");
} else {
	header("Location: ".$cfg_baseurl);
}
?>