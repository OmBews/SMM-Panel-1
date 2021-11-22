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
	?>
                        
		                <div class="row">
							<div class="col-md-12">
							<div class="panel panel-border panel-primary">
                                    <div class="panel-heading"> 
                                        <h3 class="panel-title"><i class="fa fa-history"></i> Riwayat Pesanan</h3> 
                                    </div> 
                                    <div class="panel-body">
                                        	<div class="alert alert-info">
									        Status <span class="label bg-warning">Pending</span> Berarti : Menungguh Orderan Masuk Kesistem <br />
									        Status <span class="label bg-info">Processing</span> Berarti : Sedang di check <br />
									        Status <span class="label bg-danger">Partial</span> Berarti : Gagal Order <br />									        
									        Status<span class="label bg-danger">Error</span> Berarti : Orderan Canceled <br />
									        Status  <span class="label bg-success">Success</span> Berarti : Orderan Sudah Selesai
									    </div>
										<div class="table-responsive">
											<table class="table table-striped table-bordered table-hover m-0">
												<thead>
													<tr>
														<th>Order ID</th>
														<th>Layanan</th>
														<th>Data</th>
														<th>Jumlah</th>
														<th>Awal</th>
														<th>Sisa</th>
														<th>Harga</th>
														<th>Status</th>
													</tr>
												</thead>
												<tbody>
												<?php
// start paging config
$query_order = "SELECT * FROM orders WHERE user = '$sess_username' ORDER BY id DESC"; // edit
$records_per_page = 30; // edit

$starting_position = 0;
if(isset($_GET["page_no"])) {
	$starting_position = ($_GET["page_no"]-1) * $records_per_page;
}
$new_query = $query_order." LIMIT $starting_position, $records_per_page";
$new_query = mysqli_query($db, $new_query);
// end paging config
												while ($data_order = mysqli_fetch_assoc($new_query)) {
													if($data_order['status'] == "Pending") {
														$label = "warning";
													} else if($data_order['status'] == "Processing") {
														$label = "info";
													} else if($data_order['status'] == "Error") {
														$label = "danger";
													} else if($data_order['status'] == "Partial") {
														$label = "danger";
													} else if($data_order['status'] == "Success") {
														$label = "success";
													}
												?>
													<tr>
														<td style="vertical-align: middle;">
													        <div class="input-group" style="min-width: 150px">
														        <input type="text" class="form-control input-sm" value="<?php echo $data_order['oid']; ?>" readonly="readonly">
														<td style="vertical-align: middle;"><?php echo $data_order['service']; ?></td>
														<td style="vertical-align: middle;">
													        <div class="input-group" style="min-width: 150px">
														        <input type="text" class="form-control input-sm" value="<?php echo $data_order['link']; ?>" readonly="readonly">
														<td><?php echo number_format($data_order['quantity'],0,',','.'); ?></td>
														<td><?php echo number_format($data_order['start_count'],0,',','.'); ?></td>
														<td><?php echo number_format($data_order['remains'],0,',','.'); ?></td>
														<td>Rp.<?php echo number_format($data_order['price'],0,',','.'); ?></td>
														<td><label class="label label-<?php echo $label; ?>"><?php echo $data_order['status']; ?></label></td>
													</tr>
												<?php
												}
												?>
												</tbody>
											</table>
										</div>
										<div class="col-md-12">
										<ul class="pagination">
											<?php
// start paging link
$self = $_SERVER['PHP_SELF'];
$query_order = mysqli_query($db, $query_order);
$total_no_of_records = mysqli_num_rows($query_order);
echo "<li class='disabled'><a href='#'>Total: ".$total_no_of_records."</a></li>";
if($total_no_of_records > 0) {
	$total_no_of_pages = ceil($total_no_of_records/$records_per_page);
	$current_page = 1;
	if(isset($_GET["page_no"])) {
		$current_page = $_GET["page_no"];
	}
	if($current_page != 1) {
		$previous = $current_page-1;
		echo "<li><a href='".$self."?page_no=1'>← First</a></li>";
		echo "<li><a href='".$self."?page_no=".$previous."'><i class='fa fa-angle-left'></i> Previous</a></li>";
	}
	for($i=1; $i<=$total_no_of_pages; $i++) {
		if($i==$current_page) {
			echo "<li class='active'><a href='".$self."?page_no=".$i."'>".$i."</a></li>";
		} else {
			echo "<li><a href='".$self."?page_no=".$i."'>".$i."</a></li>";
		}
	}
	if($current_page!=$total_no_of_pages) {
		$next = $current_page+1;
		echo "<li><a href='".$self."?page_no=".$next."'>Next <i class='fa fa-angle-right'></i></a></li>";
		echo "<li><a href='".$self."?page_no=".$total_no_of_pages."'>Last →</a></li>";
	}
}
// end paging link
											?>
										</ul>
										</div>
				</div>
			</div>
<?php
	include("lib/footer.php");
} else {
	header("Location: ".$cfg_baseurl);
}
?>