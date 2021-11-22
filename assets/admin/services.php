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
		if (isset($_POST['delete'])) {
			$post_sid = $_POST['sid'];
			$checkdb_service = mysqli_query($db, "SELECT * FROM services WHERE sid = '$post_sid'");
			if (mysqli_num_rows($checkdb_service) == 0) {
				$msg_type = "error";
				$msg_content = "<b>Gagal:</b> Layanan tidak ditemukan.";
			} else {
				$delete_user = mysqli_query($db, "DELETE FROM services WHERE sid = '$post_sid'");
				if ($delete_user == TRUE) {
					$msg_type = "success";
					$msg_content = "<b>Berhasil:</b> Layanan <b>$post_sid</b> dihapus.";
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
                                        <h3 class="panel-title"><i class="fa fa-plus"></i> Kelola service</h3> 
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
											<a href="<?php echo $cfg_baseurl; ?>admin/service/add.php" class="btn btn-info" style="margin-bottom: 20px;">+ Tambah</a>
											<p>
												<b>SID:</b> ID Layanan<br />
												<b>PID:</b> ID Layanan Provider<br />
												<b>KAT:</b> Kategori
											</p></br>
									<div class="table-responsive">
											<table class="table table-striped table-bordered table-hover m-0">
												<thead>
													<tr>
														<th>Status</th>
														<th>SID</th>
														<th>KAT</th>
														<th>Layanan</th>
														<th>Min</th>
														<th>Max</th>
														<th>Harga/1000</th>
														<th>PID</th>
														<th>Provider</th>
														<th>Aksi</th>
													</tr>
												</thead>
												<tbody>
												<?php
// start paging config
if (isset($_GET['search'])) {
	$search = $_GET['search'];
	$query_list = "SELECT * FROM services WHERE service LIKE '%$search%' ORDER BY sid ASC"; // edit
} else {
	$query_list = "SELECT * FROM services ORDER BY sid ASC"; // edit
}
$records_per_page = 30; // edit

$starting_position = 0;
if(isset($_GET["page_no"])) {
	$starting_position = ($_GET["page_no"]-1) * $records_per_page;
}
$new_query = $query_list." LIMIT $starting_position, $records_per_page";
$new_query = mysqli_query($db, $new_query);
// end paging config
												while ($data_show = mysqli_fetch_assoc($new_query)) {
												?>
													<tr>
														<td><?php echo $data_show['status']; ?></td>
														<td><?php echo $data_show['sid']; ?></td>
														<td><?php echo $data_show['category']; ?></td>
														<td><?php echo $data_show['service']; ?></td>
														<td><?php echo number_format($data_show['min'],0,',','.'); ?></td>
														<td><?php echo number_format($data_show['max'],0,',','.'); ?></td>
														<td><?php echo number_format($data_show['price'],0,',','.'); ?></td>
														<td><?php echo $data_show['pid']; ?></td>
														<td><?php echo $data_show['provider']; ?></td>
														<td>
														<a href="<?php echo $cfg_baseurl; ?>admin/service/detail.php?sid=<?php echo $data_show['sid']; ?>" class="btn btn-xs btn-info"><i class="fa fa-info"></i></a>
														<a href="<?php echo $cfg_baseurl; ?>admin/service/edit.php?sid=<?php echo $data_show['sid']; ?>" class="btn btn-xs btn-warning"><i class="fa fa-edit"></i></a>
														<a href="<?php echo $cfg_baseurl; ?>admin/service/delete.php?sid=<?php echo $data_show['sid']; ?>" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a
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