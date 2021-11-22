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
                        </div> 


									<div class="row">
									<div class="col-md-12">
								<div class="panel panel-color panel-info">
									<div class="panel-heading">
										<h3 class="panel-title"><i class="fa fa-shopping-cart-plus"></i> Detail Layanan</h3>
									</div>
									<div class="panel-body">
											<table class="table table-striped table-bordered table-hover m-0">
												<tr>
													<td>ID Layanan</td>
													<td><?php echo $datadb_service['sid']; ?></td>
												</tr>
												<tr>
													<td>Nama Layanan</td>
													<td><?php echo $datadb_service['service']; ?></td>
												</tr>
												<tr>
													<td>Kategori</td>
													<td><?php echo $datadb_service['category']; ?></td>
												</tr>
												<tr>
													<td>Keterangan</td>
													<td><?php echo $datadb_service['note']; ?></td>
												</tr>
												<tr>
													<td>Min. Pesan</td>
													<td><?php echo number_format($datadb_service['min'],0,',','.'); ?></td>
												</tr>
												<tr>
													<td>Max. Pesan</td>
													<td><?php echo number_format($datadb_service['max'],0,',','.'); ?></td>
												</tr>
												<tr>
													<td>Harga/1000</td>
													<td>Rp. <?php echo number_format($datadb_service['price'],0,',','.'); ?></td>
												</tr>
												<tr>
													<td>Provider</td>
													<td><?php echo $datadb_service['provider']; ?></td>
												</tr>
												<tr>
													<td>ID Layanan Provider</td>
													<td><?php echo $datadb_service['pid']; ?></td>
												</tr>
												<tr>
													<td>Status</td>
													<td><?php echo $datadb_service['status']; ?></td>
												</tr>
											</table>
										</div>
									</div>
<?php
				include("../../lib/footer.php");
			}
		} else {
			header("Location: ".$cfg_baseurl."admin/services.php");
		}
	}
} else {
	header("Location: ".$cfg_baseurl);
}
?>