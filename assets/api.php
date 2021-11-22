<?php
require("mainconfig.php");
header("Content-Type: application/json");

if (isset($_POST['key']) AND isset($_POST['action'])) {
	$post_key = addslashes(trim($_POST['key']));
	$post_action = $_POST['action'];
	if (empty($post_key) || empty($post_action)) {
		$array = array("error" => "Incorrect request");
	} else {
		$check_user = mysqli_query($db, "SELECT * FROM users WHERE api_key = '$post_key'");
		$data_user = mysqli_fetch_assoc($check_user);
		if (mysqli_num_rows($check_user) == 1) {
			$username = $data_user['username'];
			if ($post_action == "add") {
				if (isset($_POST['service']) AND isset($_POST['link']) AND isset($_POST['quantity'])) {
					$post_service = $_POST['service'];
					$post_link = $_POST['link'];
					$post_quantity = $_POST['quantity'];
					if (empty($post_service) || empty($post_link) || empty($post_quantity)) {
						$array = array("error" => "Incorrect request");
					} else {
						$check_service = mysqli_query($db, "SELECT * FROM services WHERE sid = '$post_service' AND status = 'Active'");
						$data_service = mysqli_fetch_assoc($check_service);
						if (mysqli_num_rows($check_service) == 0) {
							$array = array("error" => "Service not found");
						} else {
							$rate = $data_service['price'] / 1000;
							$price = $rate*$post_quantity;
							$service = $data_service['service'];
							$provider = $data_service['provider'];
							$pid = $data_service['pid'];
							$oid = random_number(7);
							if ($post_quantity < $data_service['min']) {
								$array = array("error" => "Quantity inccorect");
							} else if ($post_quantity > $data_service['max']) {
								$array = array("error" => "Quantity inccorect");
							} else if ($data_user['balance'] < $price) {
								$array = array("error" => "Low balance");
							} else {
								$check_provider = mysqli_query($db, "SELECT * FROM provider WHERE code = '$provider'");
								$data_provider = mysqli_fetch_assoc($check_provider);
								$provider_key = $data_provider['api_key'];
								$provider_link = $data_provider['link'];
								if ($provider !== "MANUAL") {
									$api_postdata = "key=$provider_key&action=add&service=$pid&link=$post_link&quantity=$post_quantity";
								} else if ($provider == "MANUAL") {
									$api_postdata = 0;
								}
								
			if ($provider == "GLOBE") {
   class Api
   {
      public $api_url = 'https://smmglobe.com/api/v2'; // API URL

      public $api_key = '515fa5ee2385894305712589517f9bd6'; // Your API key

      public function order($link, $type, $quantity) { // Add order
        return json_decode($this->connect(array(
          'api' => $this->api_key,
          'action' => 'add',
          'link' => $link,
          'service' => $type,
          'quantity' => $quantity
        )));
      }

      public function status($order_id) { // Get status, remains
        return json_decode($this->connect(array(
          'api' => $this->api_key,
          'action' => 'status',
          'order_id' => $order_id
        )));
      }


      private function connect($post) {
        $_post = Array();
        if (is_array($post)) {
          foreach ($post as $name => $value) {
            $_post[] = $name.'='.urlencode($value);
          }
        }
        $ch = curl_init($this->api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        if (is_array($post)) {
          curl_setopt($ch, CURLOPT_POSTFIELDS, join('&', $_post));
        }
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        $result = curl_exec($ch);
        
        if (curl_errno($ch) != 0 && empty($result)) {
          $result = false;
        }
        curl_close($ch);
        return $result;
      }
   }

   // Examples

   $api = new Api();
      $order = $api->order("".$post_link."", "".$pid."", "".$post_quantity.""); // $link, $type - service type, $quantity: return order id or Error
   $json = json_decode($order);
			}
								
								if ($provider !== "MANUAL" AND $json_result['error'] == TRUE) {
									$array = array("error" => "Server maintenance");
								} else {
									if ($provider !== "SMPL") {
										$poid = $order->data->order_id;
									}
									$update_user = mysqli_query($db, "UPDATE users SET balance = balance-$price WHERE username = '$username'");
									if ($update_user == TRUE) {
										$insert_order = mysqli_query($db, "INSERT INTO orders (oid, poid, user, service, link, quantity, price, status, date, provider, place_from) VALUES ('$oid', '$poid', '$username', '$service', '$post_link', '$post_quantity', '$price', 'Pending', '$date', '$provider', 'API')");
										if ($insert_order == TRUE) {
											$array = array("order_id" => "$oid");
										} else {
											$array = array("error" => "System error");
										}
									} else {
										$array = array("error" => "System error");
									}
								}
							}
						}
					}
				} else {
					$array = array("error" => "Incorrect request");
				}
			} else if ($post_action == "status") {
				if (isset($_POST['order_id'])) {
					$post_oid = $_POST['order_id'];
					$post_oid = $_POST['order_id'];
					$check_order = mysqli_query($db, "SELECT * FROM orders WHERE oid = '$post_oid' AND user = '$username'");
					$data_order = mysqli_fetch_array($check_order);
					if (mysqli_num_rows($check_order) == 0) {
						$array = array("error" => "Order not found");
					} else {
						$array = array("charge" => $data_order['price'], "start_count" => $data_order['start_count'], "status" => $data_order['status'], "remains" => $data_order['remains']);
					}
				} else {
					$array = array("error" => "Incorrect request");
				}
			} else {
				$array = array("error" => "Wrong action");
			}
		} else {
			$array = array("error" => "Invalid API key");
		}
	}
} else {
	$array = array("error" => "Incorrect request");
}

$print = json_encode($array);
print_r($print);