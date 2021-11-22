<?php
session_start();
require("../mainconfig.php");
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
			$post_username = $_POST['username'];
			$post_balance = $_POST['balance'];

			$checkdb_user = mysqli_query($db, "SELECT * FROM users WHERE username = '$post_username'");
			$datadb_user = mysqli_fetch_assoc($checkdb_user);
			if (empty($post_username) || empty($post_balance)) {
				$msg_type = "error";
				$msg_content = "<b>Gagal:</b> Mohon mengisi semua input.";
			} else if (mysqli_num_rows($checkdb_user) == 0) {
				$msg_type = "error";
				$msg_content = "<b>Gagal:</b> User $post_username tidak ditemukan.";
			} else if ($post_balance < 1) {
				$msg_type = "error";
				$msg_content = "<b>Gagal:</b> Minimal transfer adalah Rp. 1.";
			} else {
				$update_user = mysqli_query($db, "UPDATE users SET balance = balance+$post_balance WHERE username = '$post_username'"); // send receiver
				$insert_tf = mysqli_query($db, "INSERT INTO transfer_balance (sender, receiver, quantity, date) VALUES ('$sess_username', '$post_username', '$post_balance', '$date')");
				if ($insert_tf == TRUE) {
					$msg_type = "success";
					$msg_content = "<b>Berhasil:</b> Transfer saldo berhasil.<br /><b>Pengirim:</b> $sess_username<br /><b>Penerima:</b> $post_username<br /><b>Jumlah Transfer:</b> Rp. ".number_format($post_balance,0,',','.')." Saldo";
				} else {
					$msg_type = "error";
					$msg_content = "<b>Gagal:</b> Error system.";
				}
			}
		}

	include("../lib/header.php");
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
                                        <h3 class="panel-title"><i class="fa fa-plus"></i> Transfer saldo</h3> 
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
							<label class="col-md-2 control-label">Username penerima</label>
								<div class="col-md-10">
									<input type="text" class="form-control" name="username">
								</div>
							</div>
													<div class="form-group">
							<label class="col-md-2 control-label">Saldo di transfer</label>
								<div class="col-md-10">
									<input type="number" class="form-control" name="balance">
								</div>
								</div>
								<button type="submit" class="pull-right btn btn-info" name="add">Kirim</button>
							</div>
						</fieldset>
					</form>
										</div>
									</div>
									</div>
									</div>
<?php
	include("../lib/footer.php");
	}
} else {
	header("Location: ".$cfg_baseurl);
}
?>