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
	} else if ($data_user['level'] == "Member") {
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
			} else if ($post_balance < 10) {
				$msg_type = "error";
				$msg_content = "<b>Gagal:</b> Minimal transfer adalah Rp. 10.";
			} else if ($data_user['balance'] < $post_balance) {
				$msg_type = "error";
				$msg_content = "<b>Gagal:</b> Saldo Anda tidak mencukupi untuk melakukan transfer dengan jumlah tersebut.";
			} else {
				$update_user = mysqli_query($db, "UPDATE users SET balance = balance-$post_balance WHERE username = '$sess_username'"); // cut sender
				$update_user = mysqli_query($db, "UPDATE users SET balance = balance+$post_balance WHERE username = '$post_username'"); // send receiver
				$insert_tf = mysqli_query($db, "INSERT INTO transfer_balance (sender, receiver, quantity, date) VALUES ('$sess_username', '$post_username', '$post_balance', '$date')");
				$insert_tf = mysqli_query($db, "INSERT INTO balance_history (username, action, quantity, price, msg, date, time) VALUES ('$sess_username', 'Cut Balance', '$post_balance', '$post_balance', 'Telah mentransfer Saldo senilai $post_balance kpd pengguna $post_username', '$date', '$time')");
				$insert_tf = mysqli_query($db, "INSERT INTO balance_history (username, action, quantity, price, msg, date, time) VALUES ('$post_username', 'Add Balance', '$post_balance', '$post_balance', 'Telah menerima Saldo senilai $post_balance dari pengguna $sess_username', '$date', '$time')");
				if ($insert_tf == TRUE) {
					$msg_type = "success";
					$msg_content = "<b>Berhasil:</b> Transfer saldo berhasil.<br /><b>Pengirim:</b> $sess_username<br /><b>Penerima:</b> $post_username<br /><b>Jumlah Transfer:</b> Rp.".number_format($post_balance,0,',','.')."-, Saldo";
				} else {
					$msg_type = "error";
					$msg_content = "<b>Gagal:</b> Error system.";
				}
			}
		}

	include("../lib/header.php");
?>
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
										<form class="form-horizontal" role="form" method="POST">
											<div class="alert alert-info">
												- Saldo Anda akan dipotong sesuai jumlah transfer saldo.<br />
											</div>
											<div class="form-group row">
												<label class="col-md-2 control-label">Username Penerima</label>
												<div class="col-md-10">
													<input type="text" name="username" class="form-control" placeholder="Username">
												</div>
											</div>
											<div class="form-group row">
												<label class="col-md-2 control-label">Jumlah Transfer</label>
												<div class="col-md-10">
													<input type="number" name="balance" class="form-control" placeholder="Jumlah Transfer">
												</div>
											</div>
											<div class="pull-right">
												<button type="reset" class="btn btn-danger btn-bordered waves-effect w-md waves-light">Ulangi</button>
												<button type="submit" class="btn btn-info btn-bordered waves-effect w-md waves-light" name="add">Transfer</button>
											</div>
										</form>
										<div class="clearfix"></div>
									</div>
								</div>
							</div>
						</div>
						<!-- end row -->
<?php
	include("../lib/footer.php");
	}
} else {
	header("Location: ".$cfg_baseurl);
}
?>