<?php
// Script By root~source
require("../mainconfig.php");

$query = mysqli_query($db, "SELECT * FROM orders WHERE status IN('Error','Partial') AND refund = '0'");
if(mysqli_num_rows($query) == 0) {
    echo "Order Partial/Error tidak ada.";
} else {
    while($data = mysqli_fetch_assoc($query)) {
        $oid = $data['oid'];
        $layanan = $data['service'];
        $price = $data['price'];
        $status = $data['status'];
        $user = $data['user'];
        $remain = $data['remains'];
        
        if($status == "Error") {
         $update_query =  mysqli_query($db, "UPDATE orders set refund = '1' WHERE oid = '$oid'");
            $update_query = mysqli_query($db, "UPDATE users set balance = balance+$price WHERE username = '$user'");
            if($update_query == TRUE) {
				$insert_user = mysqli_query($db, "INSERT INTO refunds (date, user, quantity, oid, msg) VALUES ('$date', '$user', '$price', '$oid', 'Status Order ID #$oid Error, Sudah di refund. ( AUTO )')");
				if($insert_user == TRUE) {
				    echo "[ $time ] Refunded #$oid - Rp $price - Error <br />";
				} else {
				    echo "Not Refunded ! #$oid";
				}
            }
        } else if($status == "Partial") {
        $get_layanan = mysqli_query($db, "SELECT * FROM services WHERE service = '$layanan'");
        $data_layanan = mysqli_fetch_assoc($get_layanan);
        $harga = $data_layanan['price'] / 1000;
        $hargarate = $harga*$remain;

         $update_data =  mysqli_query($db, "UPDATE orders set refund = '1' WHERE oid = '$oid'");
            $update_data = mysqli_query($db, "UPDATE users set balance = balance+$hargarate WHERE username = '$user'");
            if($update_data == TRUE) {
                $insert_data = mysqli_query($db, "INSERT INTO refunds (date, user, quantity, oid, msg) VALUES ('$date', '$user', '$price', '$oid', 'Status Order ID #$oid Partial, Sudah di refund. ( AUTO )')");
                if($insert_data == TRUE) {
                    echo "[ $time ] Refunded #$oid - Rp $hargarate - Partial <br />";
                } else {
                    echo "Not Refunded ! #$oid";
                }
            }
        }
    }
}
