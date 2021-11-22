<?php
session_start();
require("../../mainconfig.php");
$msg_type = "nothing";

if (isset($_SESSION['user'])) {
	$sess_username = $_SESSION['user']['username'];
	$check_user = mysqli_query($db, "SELECT * FROM users WHERE username = '$sess_username'");
	$data_user = mysqli_fetch_assoc($check_user);
	if (mysqli_num_rows($check_user) == 0) {
		header("Location: ".$cfg_baseurl."logout.php");
	} else if ($data_user['status'] == "Suspended") {
		header("Location: ".$cfg_baseurl."logout.php");
	} else if ($data_user['level'] != "Admin") {
		header("Location: ".$cfg_baseurl);
	} else {
		if (isset($_POST['add'])) {
			$post_sid = $_POST['sid'];
			$post_cat = $_POST['category'];
			$post_service = $_POST['service'];
			$post_note = $_POST['note'];
			$post_min = $_POST['min'];
			$post_max = $_POST['max'];
			$post_price = $_POST['price'];
			$post_pid = $_POST['pid'];
			$post_provider = $_POST['provider'];

			$checkdb_service = mysqli_query($db, "SELECT * FROM services WHERE sid = '$post_sid'");
			$datadb_service = mysqli_fetch_assoc($checkdb_service);
			if (empty($post_sid) || empty($post_service) || empty($post_note) || empty($post_min) || empty($post_max) || empty($post_price) || empty($post_pid) || empty($post_provider)) {
				$msg_type = "error";
				$msg_content = "<b>Gagal:</b> Mohon mengisi semua input.";
			} else if (mysqli_num_rows($checkdb_service) > 0) {
				$msg_type = "error";
				$msg_content = "<b>Gagal:</b> Service ID $post_sid sudah terdaftar di database.";
			} else {
				$insert_service = mysqli_query($db, "INSERT INTO services (sid, category, service, note, min, max, price, status, pid, provider) VALUES ('$post_sid', '$post_cat', '$post_service', '$post_note', '$post_min', '$post_max', '$post_price', 'Active', '$post_pid', '$post_provider')");
				if ($insert_service == TRUE) {
					$msg_type = "success";
					$msg_content = "<b>Berhasil:</b> Layanan berhasil ditambahkan.<br /><b>Kategori:</b> $post_cat<br /><b>ID Layanan:</b> $post_sid<br /><b>Nama Layanan:</b> $post_service<br /><b>Note:</b> $post_note<br /><b>Min:</b> ".number_format($post_min,0,',','.')."<br /><b>Max:</b> ".number_format($post_max,0,',','.')."<br /><b>Harga/1000:</b> Rp ".number_format($post_price,0,',','.')."<br /><b>ID Layanan Provider:</b> $post_pid<br /><b>Provider:</b> $post_provider";
				} else {
					$msg_type = "error";
					$msg_content = "<b>Gagal:</b> Error system.";
				}
			}
		}

	include("../../lib/header.php");
?>

                        <!-- Page-Title -->
                        <div class="row">
                        </div> 
                        
						<div class="row">
							<div class="col-md-10">
								<div class="panel panel-default panel-border">
                                    <div class="panel-heading"> 
                                        <h3 class="panel-title"><i class="fa fa-plus"></i> Tambah Layanan</h3> 
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
													<div class="form-group">
														<label class="form-label">Provider</label>
															<select class="form-control" name="provider">
																<?php
																$check_prov = mysqli_query($db, "SELECT * FROM provider");
																while ($data_prov = mysqli_fetch_assoc($check_prov)) {
																?>
																<option value="<?php echo $data_prov['code']; ?>"><?php echo $data_prov['code']; ?></option>
																<?php
																}
																?>
															</select>
														</div>
													<div class="form-group">
														<label class="form-label">ID Layanan Provider</label>
															<input type="number" class="form-control" name="pid" />
														</div>
													<div class="form-group">
														<label class="form-label">Kategori</label>
															<select class="form-control" name="category">
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
													<div class="form-group">
													    <label class="form-label">ID Layanan</label>
															<input type="number" class="form-control" name="sid" />
														</div>
													<div class="form-group">
														<label class="control-label">Nama Layanan</label>
															<input type="text" class="form-control" name="service" />
														</div>
													<div class="form-group">
														<label class="control-label">Keterangan</label>
															<input type="text" class="form-control" name="note"  placeholder="Etc: Input username, Input link" />
														</div>
													<div class="form-group">
														<label class="control-label">Min. Pesan</label>
															<input type="number" class="form-control" name="min" />
														</div>
													<div class="form-group">
														<label class="control-label">Max. Pesan</label>
															<input type="number" class="form-control" name="max" />
														</div>
													<div class="form-group">
														<label class="control-label">Harga/1000</label>
															<input type="number" class="form-control" name="price" placeholder="20000" />
														</div>
														<button type="submit" class="btn btn-info" name="add">Tambah</button>
														<button type="reset" class="btn btn-warning">Ulangi</button>
													</div>
												</fieldset>
											</form>
										</div>
									</div>
<?php
	include("../../lib/footer.php");
	}
} else {
	header("Location: ".$cfg_baseurl);
}
?>