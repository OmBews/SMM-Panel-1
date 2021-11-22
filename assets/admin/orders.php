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

	include("../lib/header.php");

	// widget
	$check_worder = mysqli_query($db, "SELECT SUM(price) AS total FROM orders");
	$data_worder = mysqli_fetch_assoc($check_worder);
	$check_worder = mysqli_query($db, "SELECT * FROM orders");
	$count_worder = mysqli_num_rows($check_worder);
?>
						
					<!-- WIDGET -->
                        <div class="row">
                                    
                            <div class="col-lg-6">
                                
                               <!-- WIDGET 1 -->
                                <div class="panel bg-success">
                                    <div class="panel-body">
                                    
                                        <div class="row">
                                            <div class="col-sm-7">
                                                <div class="row">
                                                    <div class="col-xs-6 text-center">
                                                        <div class="fa fa-money fa-5x"></div>
                                                    </div>
                                                    <div class="col-xs-6 pv-lg">
                                                        <h7 class="m-t-0 text-white"><b>Rp.<?php echo number_format($data_worder['total'],0,',','.'); ?></b></h7>
                                                        <div class="text-uppercase">Total Pembelian</div>
                                                    </div>
                                                </div><!-- End row -->
                                            </div>
                                           
                                        </div><!-- End row -->
                                    </div><!-- panel-body -->
                                </div><!-- panel -->
                                <!-- END WIDGET 1 -->
                                
                            </div><!-- End col-md-6 -->

                            <div class="col-lg-6">
                                
                                <!-- WIDGET 2 -->
                                <div class="panel bg-warning">
                                    <div class="panel-body">
                                    
                                        <div class="row">
                                            <div class="col-sm-7">
                                                <div class="row">
                                                    <div class="col-xs-6 text-center">
                                                        <div class="fa fa-users fa-5x"></div>
                                                    </div>
                                                    <div class="col-xs-6 pv-lg">
                                                        <h7 class="m-t-0 text-white"><b><?php echo number_format($count_worder,0,',','.'); ?></b></h7>
                                                         <div class="text-uppercase">Total Pesanan</div>
                                                    </div>
                                                </div><!-- End row -->
                                            </div>
                                           
                                        </div><!-- End row -->
                                    </div><!-- panel-body -->
                                </div><!-- panel -->
                                <!-- END WIDGET 2 -->

                        </div></div> <!-- End row -->  
                
</br>

						<div class="row">
							<div class="col-md-12">
							<div class="panel panel-border panel-primary">
                                    <div class="panel-heading"> 
                                        <h3 class="panel-title"><i class="fa fa-plus"></i> Kelola Pesanan</h3> 
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
									<div class="table-responsive">
											<table class="table table-striped table-bordered table-hover m-0">
												<thead>
													<tr>
														<th>Order ID</th>
														<th>Pengguna</th>
														<th>Layanan</th>
														<th>Jumlah</th>
														<th>Harga</th>
														<th>PID</th>
														<th>Status</th>
														<th>Aksi</th>
													</tr>
												</thead>
												<tbody>
												<?php
// start paging config
if (isset($_GET['search'])) {
	$search = $_GET['search'];
	$query_list = "SELECT * FROM orders WHERE order_id LIKE '%$search%' ORDER BY id DESC"; // edit
} else {
	$query_list = "SELECT * FROM orders ORDER BY id DESC"; // edit
}
$records_per_page = 150; // edit

$starting_position = 0;
if(isset($_GET["page_no"])) {
	$starting_position = ($_GET["page_no"]-1) * $records_per_page;
}
$new_query = $query_list." LIMIT $starting_position, $records_per_page";
$new_query = mysqli_query($db, $new_query);
// end paging config
												while ($data_show = mysqli_fetch_assoc($new_query)) {
													if($data_show['status'] == "Pending") {
														$label = "warning";
													} else if($data_show['status'] == "Processing") {
														$label = "info";
													} else if($data_show['status'] == "Error") {
														$label = "danger";
													} else if($data_show['status'] == "Partial") {
														$label = "danger";
													} else if($data_show['status'] == "Success") {
														$label = "success";
													}
												?>
													<tr>
														<td style="vertical-align: middle;">
													        <div class="input-group" style="min-width: 150px">
														        <input type="text" class="form-control input-sm" value="<?php echo $data_show['oid']; ?>" readonly="readonly">
														<td><?php echo $data_show['user']; ?></td>
														<td style="vertical-align: middle;"><?php echo $data_show['service']; ?></td>														
														<td><?php echo number_format($data_show['quantity'],0,',','.'); ?></td>
														<td><?php echo number_format($data_show['price'],0,',','.'); ?></td>
														<td><?php echo $data_show['poid']; ?></td>
														<td><label class="label label-<?php echo $label; ?>"><?php echo $data_show['status']; ?></label></td>
														<td align="center">
														<a href="<?php echo $cfg_baseurl; ?>admin/order/detail.php?oid=<?php echo $data_show['oid']; ?>" class="btn btn-xs btn-info"><i class="fa fa-info"></i></a>
														<a href="<?php echo $cfg_baseurl; ?>admin/order/edit.php?oid=<?php echo $data_show['oid']; ?>" class="btn btn-xs btn-warning"><i class="fa fa-edit"></i></a>
														</td>
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
$query_list = mysqli_query($db, $query_list);
$total_no_of_records = mysqli_num_rows($query_list);
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
	include("../lib/footer.php");
	}
} else {
	header("Location: ".$cfg_baseurl);
}
?>