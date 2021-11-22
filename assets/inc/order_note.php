<?php
require("../mainconfig.php");

if (isset($_POST['service'])) {
	$post_sid = $_POST['service'];
	$check_service = mysqli_query($db, "SELECT * FROM services WHERE sid = '$post_sid'");
	if (mysqli_num_rows($check_service) == 1) {
		$data_service = mysqli_fetch_assoc($check_service);
	?>
<div id="note">												<table class="table table-bordered">
	                                                <tbody>
	                                                    <tr>
		                                                    <td align="center"><b>Harga/1000</b></td>
		                                                    <td align="center"><b>Minimum</b></td>
		                                                    <td align="center"><b>Maksimum</b></td>
                                                    	</tr>
	                                                    <tr>
	                                                	    <td align="center">Rp.<?php echo number_format($data_service['price'],0,',','.'); ?></td>
		                                                    <td align="center"><?php echo number_format($data_service['min'],0,',','.'); ?></td>
	                                                    	<td align="center"><?php echo number_format($data_service['max'],0,',','.'); ?></td>
	                                                    </tr>
	                                                    <tr>
		                                                    <td align="center" colspan="3"><b>Keterangan</b></td>
	                                                    </tr>
	                                                    <tr>
	                                                       	<td align="center" colspan="3"><?php echo $data_service['note']; ?></td>
	                                                    </tr>
                                                    </tbody>
                                                </table>
	</div>
	<?php
	} else {
	?>
												<div class="alert alert-icon alert-danger alert-dismissible fade in" role="alert">
													<button type="button" class="close" data-dismiss="alert" aria-label="Close">
														<span aria-hidden="true">&times;</span>
													</button>
													<i class="mdi mdi-block-helper"></i>
													<b>Error:</b> Service not found.
												</div>
	<?php
	}
} else {
?>
												<div class="alert alert-icon alert-danger alert-dismissible fade in" role="alert">
													<button type="button" class="close" data-dismiss="alert" aria-label="Close">
														<span aria-hidden="true">&times;</span>
													</button>
													<i class="mdi mdi-block-helper"></i>
													<b>Error:</b> Something went wrong.
												</div>
<?php
}