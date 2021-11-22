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
		if (isset($_GET['sid'])) {
			$post_sid = $_GET['sid'];
			$checkdb_service = mysqli_query($db, "SELECT * FROM services WHERE sid = '$post_sid'");
			$datadb_service = mysqli_fetch_assoc($checkdb_service);
			if (mysqli_num_rows($checkdb_service) == 0) {
				header("Location: ".$cfg_baseurl."admin/services.php");
			} else {
				if (isset($_POST['edit'])) {
					$post_cat = $_POST['category'];
					$post_service = $_POST['service'];
					$post_note = $_POST['note'];
					$post_min = $_POST['min'];
					$post_max = $_POST['max'];
					$post_price = $_POST['price'];
					$post_pid = $_POST['pid'];
					$post_provider = $_POST['provider'];
					$post_status = $_POST['status'];
					if (empty($post_service) || empty($post_note) || empty($post_min) || empty($post_max) || empty($post_price) || empty($post_pid) || empty($post_provider)) {
						$msg_type = "error";
						$msg_content = "<b>Gagal:</b> Mohon mengisi input.";
					} else if ($post_status != "Active" AND $post_status != "Not active") {
						$msg_type = "error";
						$msg_content = "<b>Gagal:</b> Input tidak sesuai.";
					} else {
						$update_service = mysqli_query($db, "UPDATE services SET category = '$post_cat', service = '$post_service', note = '$post_note', min = '$post_min', max = '$post_max', price = '$post_price', status = '$post_status', pid = '$post_pid', provider = '$post_provider' WHERE sid = '$post_sid'");
						if ($update_service == TRUE) {
							$msg_type = "success";
							$msg_content = "<b>Berhasil:</b> Layanan berhasil diubah.<br /><b>ID Layanan:</b> $post_sid<br /><b>Nama Layanan:</b> $post_service<br /><b>Kategori:</b> $post_cat<br /><b>Note:</b> $post_note<br /><b>Min:</b> ".number_format($post_min,0,',','.')."<br /><b>Max:</b> ".number_format($post_max,0,',','.')."<br /><b>Harga/1000:</b> Rp ".number_format($post_price,0,',','.')."<br /><b>ID Layanan Provider:</b> $post_pid<br /><b>Provider:</b> $post_provider<br /><b>Status:</b> $post_status";
						} else {
							$msg_type = "error";
							$msg_content = "<b>Gagal:</b> Error system.";
						}
					}
				}
				$checkdb_service = mysqli_query($db, "SELECT * FROM services WHERE sid = '$post_sid'");
				$datadb_service = mysqli_fetch_assoc($checkdb_service);
				include("../../lib/header.php");
?>

                        <!-- Page-Title -->
                        <div class="row">
                            <div class="col-sm-12">
                                <h4 class="pull-left page-title">Ubah Layanan</h4>
                            </div>
                        </div>

 <div class="row">
							<div class="col-md-7">
								<div class="panel panel-border panel-primary">
                                    <div class="panel-heading"> 
                                        <h3 class="panel-title"><i class="fa fa-shopping-cart"></i> Ubah Layanan</h3> 
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
												<label class="col-md-2 control-label">provider</label>
												<div class="col-md-10">
									<select class="form-control" name="provider" id="provider">
																<?php
																$check_prov = mysqli_query($db, "SELECT * FROM provider");
																while ($data_prov = mysqli_fetch_assoc($check_prov)) {
																?>
																<option value="<?php echo $data_prov['code']; ?>" <?php if ($datadb_service['provider'] == $data_prov['code']) { echo "selected"; } ?>><?php echo $data_prov['code']; ?> <?php if ($datadb_service['provider'] == $data_prov['code']) { echo "(Terpilih)"; } ?></option>
																<?php
																}
																?>
									</select>
								</div>
											</div>
							<div id="note"></div>
							<div class="form-group row">
												<label class="col-md-2 control-label">PID</label>
												<div class="col-md-10">
									<input type="number" class="form-control" name="pid" value="<?php echo $datadb_service['pid']; ?>"/>
								</div>
											</div>
							<div class="form-group row">
												<label class="col-md-2 control-label">Kat</label>
												<div class="col-md-10">
															<select class="form-control" name="category">
																<?php
																$check_cat = mysqli_query($db, "SELECT * FROM service_cat ORDER BY name ASC");
																while ($data_cat = mysqli_fetch_assoc($check_cat)) {
																?>
																<option value="<?php echo $data_cat['code']; ?>" <?php if ($datadb_service['category'] == $data_cat['code']) { echo "selected"; } ?>><?php echo $data_cat['name']; ?> <?php if ($datadb_service['category'] == $data_cat['code']) { echo "(Terpilih)"; } ?></option>
																<?php
																}
																?>
															</select>
														</div>
													</div>
							<div class="form-group row">
												<label class="col-md-2 control-label">SID</label>
												<div class="col-md-10">
															<input type="number" class="form-control" name="sid" value="<?php echo $datadb_service['sid']; ?>" readonly />
														</div>
													</div>
							<div class="form-group row">
												<label class="col-md-2 control-label">Nama Layanan</label>
												<div class="col-md-10">
															<input type="text" class="form-control" name="service" value="<?php echo $datadb_service['service']; ?>" />
														</div>
													</div>
							<div class="form-group row">
												<label class="col-md-2 control-label">Keterangan</label>
												<div class="col-md-10">
															<input type="text" class="form-control" name="note"  placeholder="Etc: Input username, Input link" value="<?php echo $datadb_service['note']; ?>"/>
														</div>
													</div>
							<div class="form-group row">
												<label class="col-md-2 control-label">Min. Pesan</label>
												<div class="col-md-10">
															<input type="number" class="form-control" name="min" value="<?php echo $datadb_service['min']; ?>" />
														</div>
													</div>
							<div class="form-group row">
												<label class="col-md-2 control-label">Max. Pesan</label>
												<div class="col-md-10">
															<input type="number" class="form-control" name="max" value="<?php echo $datadb_service['max']; ?>" />
														</div>
													</div>
							<div class="form-group row">
												<label class="col-md-2 control-label">Harga/1000</label>
												<div class="col-md-10">
															<input type="number" class="form-control" name="price" placeholder="20000" value="<?php echo $datadb_service['price']; ?>" />
														</div>
													</div>
							<div class="form-group row">
												<label class="col-md-2 control-label">Status</label>
												<div class="col-md-10">
															<select class="form-control" name="status">
																<option value="Active" <?php if ($datadb_service['status'] == "Active") { echo "selected"; } ?>>Active <?php if ($datadb_service['status'] == "Active") { echo "(Terpilih)"; } ?></option>
																<option value="Not active" <?php if ($datadb_service['status'] == "Not active") { echo "selected"; } ?>>Not active <?php if ($datadb_service['status'] == "Not active") { echo "(Terpilih)"; } ?></option>
															</select>
														</div>
													</div>
													<div class="form-actions">
														<button type="submit" class="btn btn-primary" name="edit">Ubah</button>
														<button type="reset" class="btn">Ulangi</button>
													</div>
												</fieldset>
											</form>
										</div>
									</div>
<?php
				include("../../lib/footer.php");
			}
		} else {
			header("Location: ".$cfg_baseurl."admin/news.php");
		}
	}
} else {
	header("Location: ".$cfg_baseurl);
}
?>