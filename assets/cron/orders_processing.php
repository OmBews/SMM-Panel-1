<?php
require("../mainconfig.php");

$check_order = mysqli_query($db, "SELECT * FROM orders WHERE status = 'Processing'");

if (mysqli_num_rows($check_order) == 0) {
	die("Order Processing not found.");
} else {
	while($data_order = mysqli_fetch_assoc($check_order)) {
		$o_oid = $data_order['oid'];
		$o_poid = $data_order['poid'];
		$o_provider = $data_order['provider'];
	if ($o_provider == "MANUAL") {
		echo "Order manual<br />";
	} else {
		
		$check_provider = mysqli_query($db, "SELECT * FROM provider WHERE code = '$o_provider'");
		$data_provider = mysqli_fetch_assoc($check_provider);
		
		$p_apikey = $data_provider['api_key'];
		$p_link = $data_provider['link'];
		
		if ($o_provider == "GLOBE") {
			$api_postdata = "key=$p_apikey&action=status&id=$o_poid";
		} else {
			die("System error!");
		}
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $p_link);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $api_postdata);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$chresult = curl_exec($ch);
		curl_close($ch);
		$json_result = json_decode($chresult, true);
		
		if ($o_provider == "GLOBE") {
			if ($json_result['status'] == "Pending") {
				$u_status = "Pending";
			} else if ($json_result['status'] == "In progress" || $json_result['status'] == "Processing") {
				$u_status = "Processing";
			} else if ($json_result['status'] == "Canceled") {
				$u_status = "Error";
			} else if ($json_result['status'] == "Partial") {
				$u_status = "Partial";
			} else if ($json_result['status'] == "Completed") {
				$u_status = "Success";
			} else {
				$u_status = "Pending";
			}
			$u_start = $json_result['start_count'];
			$u_remains = $json_result['remains'];
		} else {
			die("System error!");
		}
		
		$update_order = mysqli_query($db, "UPDATE orders SET status = '$u_status', start_count = '$u_start', remains = '$u_remains' WHERE oid = '$o_oid'");
		if ($update_order == TRUE) {
			echo "$o_oid status $u_status | start $u_start | remains $u_remains<br />";
		} else {
			echo "Error database.";
		}
	}
	}
}