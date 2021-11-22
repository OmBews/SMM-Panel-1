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
}

include("lib/header.php");
?>
                        
                        <div class="row">
							<div class="panel panel-border panel-primary">
                                    <div class="panel-heading"> 
                                        <h3 class="panel-title"><i class="fa fa-random"></i> API Docs</h3> 
                                    </div> 
                                    <div class="panel-body"> 
										<table class="table table-bordered">
											<tbody>
												<tr>
													<td>HTTP Method</td>
													<td>POST</td>
												</tr>
												<tr>
													<td>API URL</td>
													<td><?php echo $cfg_baseurl; ?>api.php</td>
												</tr>
												<tr>
													<td>Response format</td>
													<td>JSON</td>
												</tr>
											</tbody>
										</table>
										<h3>Method <font color="red">add</font> (Place order)</h3>
										<table class="table table-bordered">
											<thead>
												<tr>
													<th>Parameters</th>
													<th>Description</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>key</td>
													<td>Your API key</td>
												</tr>
												<tr>
													<td>action</td>
													<td>add</td>
												</tr>
												<tr>
													<td>service</td>
													<td>Service ID <a href="<?php echo $cfg_baseurl; ?>price_list.php">Check at price list</a></td>
												</tr>
												<tr>
													<td>link</td>
													<td>Link to page</td>
												</tr>
												<tr>
													<td>quantity</td>
													<td>Needed quantity</td>
												</tr>
											</tbody>
										</table>
<b>Example Response</b><br />
<pre>
IF ORDER SUCCESS

{
  "order_id":"12345"
}

IF ORDER FAIL

{
  "error":"Incorrect request"
}
</pre>
<b>Example PHP Code Order: <a href="<?php echo $cfg_baseurl; ?>api_order.txt">CLICK ME</a></b>
										<h3>Method <font color="red">status</font> (Check order status)</h3>
										<table class="table table-bordered">
											<thead>
												<tr>
													<th>Parameters</th>
													<th>Description</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>key</td>
													<td>Your API key</td>
												</tr>
												<tr>
													<td>action</td>
													<td>status</td>
												</tr>
												<tr>
													<td>order_id</td>
													<td>Your order id</td>
												</tr>
											</tbody>
										</table>
<b>Example Response</b><br />
<pre>
IF CHECK STATUS SUCCESS

{
  "charge":"10000",
  "start_count":"123",
  "status":"Success",
  "remains":"0"
}

IF CHECK STATUS FAIL

{
  "error":"Incorrect request"
}
</pre>
<b>Example PHP Code Status: <a href="<?php echo $cfg_baseurl; ?>api_status.txt">CLICK ME</a></b>
									</div>
								</div>
							</div>
						</div>
						<!-- end row -->
<?php
include("lib/footer.php");
?>