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
			} else {
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
                                        <h3 class="panel-title"><i class="fa fa-info"></i> Detail</h3> 
                                    </div> 
                                    <div class="panel-body">
											<table class="table table-striped table-bordered table-hover m-0">
												<tr>
													<td>Order ID</td>
													<td><?php echo $datadb_order['oid']; ?></td>
												</tr>
												<tr>
													<td>Pembeli</td>
													<td><?php echo $datadb_order['user']; ?></td>
												</tr>
												<tr>
													<td>Layanan</td>
													<td><?php echo $datadb_order['service']; ?></td>
												</tr>
												<tr>
													<td>Target</td>
													<td><?php echo $datadb_order['link']; ?></td>
												</tr>
												<tr>
													<td>Jumlah Beli</td>
													<td><?php echo number_format($datadb_order['quantity'],0,',','.'); ?></td>
												</tr>
												<tr>
													<td>Jumlah Awal</td>
													<td><?php echo number_format($datadb_order['start_count'],0,',','.'); ?></td>
												</tr>
												<tr>
													<td>Sisa</td>
													<td><?php echo number_format($datadb_order['remains'],0,',','.'); ?></td>
												</tr>
												<tr>
													<td>Harga</td>
													<td>Rp <?php echo number_format($datadb_order['price'],0,',','.'); ?></td>
												</tr>
												<tr>
													<td>Provider</td>
													<td><?php echo $datadb_order['provider']; ?></td>
												</tr>
												<tr>
													<td>Order ID Provider</td>
													<td><?php echo $datadb_order['poid']; ?></td>
												</tr>
												<tr>
													<td>Status</td>
													<td><?php echo $datadb_order['status']; ?></td>
												</tr>
												<tr>
													<td>Tanggal</td>
													<td><?php echo $datadb_order['date']; ?></td>
												</tr>
											</table>
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