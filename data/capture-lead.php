<?php include_once '../auth/db-connect.php';
$ap_tracking = 'ap_ref_tracking';
if(isset($_COOKIE[$ap_tracking])){ 
	$affiliate_id = $_COOKIE[$ap_tracking];
}else{
	$affiliate_id = '';
}
	//DATA REQURED
	$fullname = filter_input(INPUT_POST, 'fullname', FILTER_SANITIZE_STRING);
	$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
	$phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
	$message = filter_input(INPUT_POST, 'msg', FILTER_SANITIZE_STRING);
  $redirect = filter_input(INPUT_POST, 'redirect', FILTER_SANITIZE_STRING);
	$datetime = date("Y-m-d H:i:s");

	//FORM VALIDATION
	if($fullname=='' || $email == '' || $message == ''){
		header('Location: ../'.$redirect.'?error=1');
	}

$get_epc = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT epl FROM ap_other_commissions WHERE id=1"));
$epl = $get_epc['epl'];

$stmt = $mysqli->prepare("INSERT INTO ap_leads (affiliate_id, fullname, email, phone, message, epl, datetime) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param('sssssss', $affiliate_id, $fullname, $email, $phone, $message, $epl, $datetime);
$stmt->execute();
$stmt->close();

	//CHECK FOR VALID AFFILIATE
	$get_affiliate = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT balance FROM ap_members WHERE id=$affiliate_id"));
	$affiliate_balance = $get_affiliate['balance'];

	if(isset($affiliate_balance)){
		//UPDATE AFFILIATE BALANCE
		$updated_balance = $affiliate_balance + $epl;
		$update_one = $mysqli->prepare("UPDATE ap_members SET balance = ? WHERE id=$affiliate_id"); 
		$update_one->bind_param('s', $updated_balance);
		$update_one->execute();
		$update_one->close();	
	}

header('Location: ../'.$redirect.'?success=1');
?>