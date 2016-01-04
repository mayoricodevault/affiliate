<?php
include_once 'auth/db-connect.php';

$datetime = date("Y-m-d H:i:s");

//GET COMMISSION LEVEL
$get_dc = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT default_commission FROM ap_settings WHERE id=1"));
$default_commission = $get_dc['default_commission'];
	
$get_cl = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT percentage FROM ap_commission_settings WHERE $sale_amount BETWEEN sales_from AND sales_to"));
$comission = $get_cl['percentage'];
if($comission==''){$comission = $default_commission;}
	
//RECORD SALE
$affiliate_id = $affiliate; // PASSED FROM PAYPAL CUSTOM FORM FIELD
$percentage = $comission / 100;
$net_earnings = $sale_amount * $percentage;
$datetime = date("Y-m-d H:i:s");

//CHECK FOR VALID AFFILIATE
$get_affiliate = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT balance FROM ap_members WHERE id=$affiliate_id"));
$affiliate_balance = $get_affiliate['balance'];

if(isset($affiliate_balance)){
	$stmt = $mysqli->prepare("INSERT INTO ap_earnings (affiliate_id, product, comission, sale_amount, net_earnings, datetime) VALUES (?, ?, ?, ?, ?, ?)");
	$stmt->bind_param('ssssss', $affiliate_id, $product, $comission, $sale_amount, $net_earnings, $datetime);
	$stmt->execute();
	$stmt->close();
	//UPDATE AFFILIATE BALANCE
	$updated_balance = $affiliate_balance + $net_earnings;
	$update_one = $mysqli->prepare("UPDATE ap_members SET balance = ? WHERE id=$affiliate_id"); 
	$update_one->bind_param('s', $updated_balance);
	$update_one->execute();
	$update_one->close();	
	}
}
?>