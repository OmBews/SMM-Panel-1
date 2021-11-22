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
				include("../../lib/header.php");
?>

                        <!-- Page-Title -->
                        <div class="row">
                            <div class="col-sm-12">
                                <h4 class="pull-left page-title">Hapus Layanan</h4>
                            </div>
                        </div>

 <div class="row">
							<div class="col-md-7">
								<div class="panel panel-border panel-primary">
                                    <div class="panel-heading"> 
                                        <h3 class="panel-title"><i class="fa fa-shopping-cart"></i> Hapus Layanan</h3> 
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
											<form class="form-horizontal" method="POST" action="<?php echo $cfg_baseurl; ?>admin/services.php">
												<fieldset>
								<div class="form-group row">
												<label class="col-md-2 control-label">SID</label>
												<div class="col-md-10">
															<input type="number" class="form-control" name="sid" value="<?php echo $datadb_service['sid']; ?>" readonly />
														</div>
													</div>
							<div class="form-group row">
												<label class="col-md-2 control-label">Nama Layanan</label>
												<div class="col-md-10">
															<input type="text" class="form-control" name="service" value="<?php echo $datadb_service['service']; ?>" readonly />
														</div>
													</div>
													<div class="form-actions">
														<button type="submit" class="btn btn-primary" name="delete">Hapus</button>
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
			header("Location: ".$cfg_baseurl."admin/users.php");
		}
	}
} else {
	header("Location: ".$cfg_baseurl);
}
?>