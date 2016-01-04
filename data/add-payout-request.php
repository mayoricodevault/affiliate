<?php include_once '../auth/startup.php';
$get_min = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT min_payout FROM ap_settings WHERE id=1"));
$min_payout = $get_min['min_payout'];

$get_balance= mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT balance FROM ap_members WHERE id=$owner"));
$balance = $get_balance['balance'];

$get_requests= mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT SUM(amount) as pending FROM ap_payouts WHERE affiliate_id=$owner AND status=0"));
$pending_requests = $get_requests['pending'];

$true_balance = $balance - $pending_requests;

	//DATA REQURED
	$pm= filter_input(INPUT_POST, 'pm', FILTER_SANITIZE_STRING);
	$ppe= filter_input(INPUT_POST, 'ppe', FILTER_SANITIZE_STRING);
	$vppe = filter_input(INPUT_POST, 'vppe', FILTER_SANITIZE_STRING);
	$amount = filter_input(INPUT_POST, 'a', FILTER_SANITIZE_STRING);
	$datetime = date("Y-m-d H:i:s");

	//PAYMENT METHOD SPECIFIC DATA
	$street = filter_input(INPUT_POST, 'street', FILTER_SANITIZE_STRING);
	$city = filter_input(INPUT_POST, 'city', FILTER_SANITIZE_STRING);
	$zip = filter_input(INPUT_POST, 'zip', FILTER_SANITIZE_STRING);
	if($payment_method=='2'){
	$bn = filter_input(INPUT_POST, 'sb', FILTER_SANITIZE_STRING);
	$rn = filter_input(INPUT_POST, 'sr', FILTER_SANITIZE_STRING);
	$an = filter_input(INPUT_POST, 'sa', FILTER_SANITIZE_STRING);
	}else{
	$bn = filter_input(INPUT_POST, 'wb', FILTER_SANITIZE_STRING);
	$rn = filter_input(INPUT_POST, 'wr', FILTER_SANITIZE_STRING);
	$an = filter_input(INPUT_POST, 'wa', FILTER_SANITIZE_STRING);	
	}

	if($ppe == $vppe && $amount >= $min_payout  && $true_balance >= $amount){
	$stmt = $mysqli->prepare("INSERT INTO ap_payouts (affiliate_id, payment_method, payment_email, amount, street, city, zip, bn, an, rn, datetime) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
	$stmt->bind_param('sssssssssss', $owner, $pm, $ppe, $amount, $street, $city, $zip, $bn, $an, $rn, $datetime);
	$stmt->execute();
	$stmt->close();
	}

if($ppe != $vppe){ $error = '?e=1';}
if($amount < $min_payout){ $error = '?e=2';}
if($amount > $true_balance){ $error = '?e=3';}

header('Location: ../my-payouts'.$error);
?>