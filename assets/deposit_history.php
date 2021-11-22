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
	$msg_type = "nothing";

	
	$check_user = mysqli_query($db, "SELECT * FROM users WHERE username = '$sess_username'");
	$data_user = mysqli_fetch_assoc($check_user);
	
	if(isset($_POST['code'])) {
	    $post_code = $_POST['code'];
	    
	    $select = mysqli_query($db, "SELECT * FROM deposits_history WHERE code = '$post_code'");
	    $datana = mysqli_fetch_assoc($select);
	    
	    if(mysqli_num_rows($select) == 0) {
	        $msg_type = "error";
	        $msg_content = "<b>Gagal:</b> Data tidak di temukan.";
	    } else if($datana['status'] !== "Pending" AND $datana['status'] !== "Processing") {
             $msg_type = "error";
	        $msg_content = "<b>Gagal:</b> Data tidak bisa di batalkan.";	 
	    } else {
	        $update = mysqli_query($db, "UPDATE deposits_history set status = 'Error' WHERE code = '$post_code'");
	        if($update == TRUE) {
	            $msg_type = "success";
	            $msg_content = "Berhasil membatalkan!";
	        } else {
	            $msg_type = "error";
	            $msg_content = "GAGAL MEMBATALKAN #1";
	        }
	    }
	}

?>
                        
		<div class="row">
							<div class="col-md-12">
							<div class="panel panel-border panel-primary">
                                    <div class="panel-heading"> 
                                        <h3 class="panel-title"><i class="fa fa-history"></i> Riwayat Saldo</h3> 
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
									    <div class="alert alert-info">
									        Status <span class="label bg-warning">Pending</span> Berarti : Membutuhkan Bukti Pembayaran <br />
									        Status <span class="label bg-info">Processing</span> Berarti : Sedang di check <br />
									        Status<span class="label bg-danger">Error</span> Berarti : Gagal Deposit <br />
									        Status  <span class="label bg-success">Success</span> Berarti : Saldo sudah di terima dan deposit berhasil
									    </div>
											<div class="table-responsive">
											<table class="table table-striped table-bordered table-hover m-0">
												<thead>
													<tr>	
													    <th>Deposit ID</th>
														<th>Jumlah Pembayaran     </th>
														<th>Saldo Didapat</th>
														<th>Bukti Transfer</th>
														<th>Tanggal</th>
														<th>Waktu</th>
														<th>Status</th>
														<th>Aksi</th>
													</tr>
												</thead>
												<tbody>
												<?php
												
// start paging config
$query_order = "SELECT * FROM deposits_history WHERE user = '$sess_username' ORDER BY id DESC"; // edit
$records_per_page = 30; // edit

$starting_position = 0;
if(isset($_GET["page_no"])) {
	$starting_position = ($_GET["page_no"]-1) * $records_per_page;
}
$new_query = $query_order." LIMIT $starting_position, $records_per_page";
$new_query = mysqli_query($db, $new_query);
// end paging config
												while ($data_depo = mysqli_fetch_assoc($new_query)) {
													if($data_depo['status'] == "Pending") {
														$label = "warning";
													} else if($data_depo['status'] == "Processing") {
														$label = "info";
													} else if($data_depo['status'] == "Error") {
														$label = "danger";
													} else if($data_depo['status'] == "Success") {
														$label = "success";
													}
												?>
													<tr>
														<td style="vertical-align: middle;">
													        <div class="input-group" style="min-width: 150px">
														        <input type="text" class="form-control input-sm" value="<?php echo $data_depo['code']; ?>" readonly="readonly">														
														<td>Rp. <?php echo number_format($data_depo['quantity'],0,',','.'); ?></td>
														<td>Rp. <?php echo number_format($data_depo['get_balance'],0,',','.'); ?></td>
														<?php if(empty($data_depo['link_confirm']) AND $data_depo['status'] == "Pending") {
														   ?>
														<td><a href="<?php echo $cfg_baseurl; ?>konfirm_deposit.php?code=<?php echo $data_depo['code']; ?>"><button class="btn btn-warning btn-bordered waves-effect w-md waves-light">Konfirmasi Bukti</button></a></td>
														<?php } else { ?>
														<td><?php echo $data_depo['link_confirm']; ?></td>
														<?php
														}
														?>
														<td><?php echo $data_depo['date']; ?></td>
														<td><?php echo $data_depo['time']; ?></td>
														<td><label class="label label-<?php echo $label; ?>"><?php echo $data_depo['status']; ?></label></td>
														<?php if($data_depo['status'] !== "Success" AND $data_depo['status'] !== "Error") { ?>
														<td> <form action="" method="post">
                                       <input type="hidden" name="code" value="<?php echo $data_depo['code']; ?>">
                                      <button type="submit" class="btn btn-danger btn-xs"><strong><span class="fa fa-remove"></span> Batalkan Deposit</strong></button>
</td> <? } else { ?>
                                                    	<td><span class="label label-success"><strong>Not Action</strong></span> </td>			<? } ?>			
													</tr>
												<?php
												}
												?>
												</tbody>
											</table>
										</div>
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
}	?>
										
										</ul>
									</div>
								</div>
							</div>
						</div>
						<!-- end row -->

<?php
	include("lib/footer.php");
}} else {
	header("Location: ".$cfg_baseurl);
}
?>