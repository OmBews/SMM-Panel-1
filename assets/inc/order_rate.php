<?php
require("../mainconfig.php");

if (isset($_POST['service'])) {
	$post_sid = $_POST['service'];
	$check_service = mysqli_query($db, "SELECT * FROM services WHERE sid = '$post_sid'");
	if (mysqli_num_rows($check_service) == 1) {
		$data_service = mysqli_fetch_assoc($check_service);
		$result = $data_service['price'] / 1000;
		echo $result;
	} else {
		die("0");
	}
} else {
	die("0");
}