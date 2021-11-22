<?php
require("../mainconfig.php");

$check_order = mysqli_query($db, "SELECT * FROM orders WHERE status IN('Pending','Processing') AND provider = 'IRVAN'");

if (mysqli_num_rows($check_order) == 0) {
	die("Order Pending not found.");
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
		
		$api_apikey = $data_provider['api_key'];
		$api_apiid = $data_provider['api_id'];
		$p_link = $data_provider['link'];
		$api_link = $p_link."status";
    	$api_postdata = "api_id=$api_apiid&api_key=$api_apikey&id=$o_poid";
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "$api_link");
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $api_postdata);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$chresult = curl_exec($ch);
		curl_close($ch);
		$json_result = json_decode($chresult, true);
		
		if($json_result['status'] == false) {
		    echo "Pesanan tidak diubah karena gagal saat cek status #$o_oid";
		} else {
			if ($json_result['data']['status'] == "1") {
				$u_status = "Pending";
			} else if ($json_result['data']['status'] == "2") {
				$u_status = "Processing";
			} else if ($json_result['data']['status'] == "3") {
				$u_status = "Partial";
			} else if ($json_result['data']['status'] == "4") {
				$u_status = "Error";
			} else if ($json_result['data']['status'] == "5") {
				$u_status = "Success";
			} else {
				$u_status = "Pending";
			}
			$u_start = $json_result['data']['start_count'];
			$u_remains = $json_result['data']['remains'];
		
		$update_order = mysqli_query($db, "UPDATE orders SET status = '$u_status', start_count = '$u_start', remains = '$u_remains' WHERE oid = '$o_oid'");
		if ($update_order == TRUE) {
			echo "$o_oid status $u_status | start $u_start | remains $u_remains<br />";
		} else {
			echo "Error database.";
		}
	}
	}
	}
}