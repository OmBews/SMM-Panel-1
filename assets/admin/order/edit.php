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
		if (isset($_GET['oid'])) {
			$post_oid = $_GET['oid'];
			$checkdb_order = mysqli_query($db, "SELECT * FROM orders WHERE oid = '$post_oid'");
			$datadb_order = mysqli_fetch_assoc($checkdb_order);
			if (mysqli_num_rows($checkdb_order) == 0) {
				header("Location: ".$cfg_baseurl."admin/orders.php");
			} else if ($datadb_order['status'] == "Success" || $datadb_order['status'] == "Error" || $datadb_order['status'] == "Partial") {
				header("Location: ".$cfg_baseurl."admin/orders.php");
			} else {
				if (isset($_POST['edit'])) {
					$post_status = $_POST['status'];
					$post_start = $_POST['start_count'];
					$post_remains = $_POST['remains'];
					if ($post_status != "Pending" AND $post_status != "Processing" AND $post_status != "Error" AND $post_status != "Partial" AND $post_status != "Success") {
						$msg_type = "error";
						$msg_content = "<b>Gagal:</b> Input tidak sesuai.";
					} else {
						$update_order = mysqli_query($db, "UPDATE orders SET start_count = '$post_start', remains = '$post_remains', status = '$post_status' WHERE oid = '$post_oid'");
						if ($update_order == TRUE) {
							$msg_type = "success";
							$msg_content = "<b>Berhasil:</b> Pesanan berhasil diubah.<br /><b>Order ID:</b> $post_oid<br /><b>Status:</b> $post_status<br /><b>Jumlah Awal:</b> ".number_format($post_start,0,',','.')."<br /><b>Sisa:</b> ".number_format($post_remains,0,',','.');
						} else {
							$msg_type = "error";
							$msg_content = "<b>Gagal:</b> Error system.";
						}
					}
				}
				$checkdb_order = mysqli_query($db, "SELECT * FROM orders WHERE oid = '$post_oid'");
				$datadb_order = mysqli_fetch_assoc($checkdb_order);
				include("../../lib/header.php");
?>

                        <!-- Page-Title -->
                        <div class="row">
                            <div class="col-sm-12">
                                <h4 class="pull-left page-title"></h4>
                            </div>
                        </div>
								<div class="row">
									<div class="col-md-12">
								<div class="panel panel-border panel-primary">
                                    <div class="panel-heading"> 
                                        <h3 class="panel-title"><i class="fa fa-plus"></i> Ubah pesanan</h3> 
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
												<label class="col-md-2 control-label">Order ID</label>
												<div class="col-md-10">
															<input type="number" class="form-control" value="<?php echo $datadb_order['oid']; ?>" readonly />
														</div>
													</div>
							<div class="form-group row">
												<label class="col-md-2 control-label">Jumlah Awal</label>
												<div class="col-md-10">
															<input type="number" class="form-control" name="start_count" value="<?php echo $datadb_order['start_count']; ?>" />
														</div>
													</div>
							<div class="form-group row">
												<label class="col-md-2 control-label">Sisa</label>
												<div class="col-md-10">
															<input type="number" class="form-control" name="remains" value="<?php echo $datadb_order['remains']; ?>" />
														</div>
													</div>
							<div class="form-group row">
												<label class="col-md-2 control-label">Status</label>
												<div class="col-md-10">
															<select class="form-control" name="status">
																<option value="Pending" <?php if ($datadb_order['status'] == "Pending") { echo "selected"; } ?>>Pending <?php if ($datadb_order['status'] == "Pending") { echo "(Terpilih)"; } ?></option>
																<option value="Processing" <?php if ($datadb_order['status'] == "Processing") { echo "selected"; } ?>>Processing <?php if ($datadb_order['status'] == "Processing") { echo "(Terpilih)"; } ?></option>
																<option value="Error" <?php if ($datadb_order['status'] == "Error") { echo "selected"; } ?>>Error <?php if ($datadb_order['status'] == "Error") { echo "(Terpilih)"; } ?></option>
																<option value="Partial" <?php if ($datadb_order['status'] == "Partial") { echo "selected"; } ?>>Partial <?php if ($datadb_order['status'] == "Partial") { echo "(Terpilih)"; } ?></option>
																<option value="Success" <?php if ($datadb_order['status'] == "Success") { echo "selected"; } ?>>Success <?php if ($datadb_order['status'] == "Success") { echo "(Terpilih)"; } ?></option>
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
			header("Location: ".$cfg_baseurl."admin/orders.php");
		}
	}
} else {
	header("Location: ".$cfg_baseurl);
}
?>