<?php
$path = dirname(__FILE__);
$path = substr($path, 0, -10);
include_once($path.'/auth/db-connect.php');
$ap_tracking = 'ap_ref_tracking';
$ref_id = filter_input(INPUT_GET, 'ref'); 
$days_to_expiration = '30';
//SET A NEW COOKIE
if(isset($ref_id) && empty($_COOKIE[$ap_tracking])) {
setcookie($ap_tracking, $ref_id, time() + (86400 * $days_to_expiration), '/');
	//CHECK IF CPC ENABLED
	$get_cpc_on = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT cpc_on, epc FROM ap_other_commissions WHERE id=1"));
	$cpc_on = $get_cpc_on['cpc_on'];
	$epc = $get_cpc_on['epc'];
	if($cpc_on!='1'){$epc = '0';}
	//RECORD REFERRAL TRAFFIC DATA
	$affiliate_id = $ref_id;
	$agent = $_SERVER['HTTP_USER_AGENT'];
	$ip = $_SERVER['REMOTE_ADDR'];
	$host_name = gethostbyaddr($_SERVER['REMOTE_ADDR']);
	$landing_page = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	$datetime = date("Y-m-d H:i:s");
	
	$stmt = $mysqli->prepare("INSERT INTO ap_referral_traffic (affiliate_id, agent, ip, host_name, landing_page, cpc_earnings, datetime) VALUES (?, ?, ?, ?, ?, ?, ?)");
	$stmt->bind_param('sssssss', $affiliate_id, $agent, $ip, $host_name, $landing_page, $epc, $datetime);
	$stmt->execute();
	$stmt->close();
	
	//IF CPC ENABLED UPDATE MEMBER BALANCE
	if($cpc_on=='1'){
		//GET MEMBER BALANCE
		$get_balance= mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT balance FROM ap_members WHERE id=$affiliate_id"));
		$balance = $get_balance['balance'];
		$new_balance = $balance + $epc;
		//UPDATE BALANCE RECORD
		$update_one = $mysqli->prepare("UPDATE ap_members SET balance = ? WHERE id=$affiliate_id"); 
		$update_one->bind_param('s', $new_balance);
		$update_one->execute();
		$update_one->close();
	}
	header("Refresh:0");
}
if(isset($_POST['delete'])){
setcookie("ap_ref_tracking", '', 1, '/');
header("Refresh:0");
}
