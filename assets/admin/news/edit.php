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
		if (isset($_GET['id'])) {
			$post_id = $_GET['id'];
			$checkdb_news = mysqli_query($db, "SELECT * FROM news WHERE id = '$post_id'");
			$datadb_news = mysqli_fetch_assoc($checkdb_news);
			if (mysqli_num_rows($checkdb_news) == 0) {
				header("Location: ".$cfg_baseurl."admin/news.php");
			} else {
				if (isset($_POST['edit'])) {
					$post_content = $_POST['content'];
					if (empty($post_content)) {
						$msg_type = "error";
						$msg_content = "<b>Gagal:</b> Mohon mengisi semua input.";
					} else {
						$update_news = mysqli_query($db, "UPDATE news SET content = '$post_content' WHERE id = '$post_id'");
						if ($update_news == TRUE) {
							$msg_type = "success";
							$msg_content = "<b>Berhasil:</b> Berita berhasil diubah.";
						} else {
							$msg_type = "error";
							$msg_content = "<b>Gagal:</b> Error system.";
						}
					}
				}
				$checkdb_news = mysqli_query($db, "SELECT * FROM news WHERE id = '$post_id'");
				$datadb_news = mysqli_fetch_assoc($checkdb_news);
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
                                        <h3 class="panel-title"><i class="fa fa-info"></i> Ubah berita</h3> 
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
											<div class="form-group row">
												<label class="col-md-2 control-label">Konten</label>
												<div class="col-md-10">
													<textarea name="content" class="form-control" placeholder="Konten"><?php echo $datadb_news['content']; ?></textarea>
												</div>
											</div>
											<a href="<?php echo $cfg_baseurl; ?>admin/news.php" class="btn btn-info btn-bordered waves-effect w-md waves-light">Kembali</a>
											<div class="pull-right">
												<button type="reset" class="btn btn-danger btn-bordered waves-effect w-md waves-light">Ulangi</button>
												<button type="submit" class="btn btn-success btn-bordered waves-effect w-md waves-light" name="edit">Ubah</button>
											</div>
										</form>
										<div class="clearfix"></div>
									</div>
								</div>
							</div>
						</div>
						<!-- end row -->
<?php
				include("../../lib/footer.php");
			}
		} else {
			header("Location: ".$cfg_baseurl."admin/news.php");
		}
	}
} else {
	header("Location: ".$cfg_baseurl);
}
?>