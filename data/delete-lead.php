<?php include_once '../auth/startup.php';
session_start();
$lead_id = filter_input(INPUT_POST, 'm', FILTER_SANITIZE_STRING);

$get_affiliate = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT epl, affiliate_id FROM ap_leads WHERE id=$lead_id"));
$affiliate_id = $get_affiliate['affiliate_id'];
$ta = $get_affiliate['epl'];

if(isset($affiliate_id)){
	//UPDATE BALANCE
	$get_tb = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT balance FROM ap_members WHERE id=$affiliate_id"));
	$tb = $get_tb['balance'];

	$updated_balance = $tb - $ta;
	if($updated_balance < 0){$updated_balance ='0.00';}
		$update_one = $mysqli->prepare("UPDATE ap_members SET balance = ? WHERE id=$affiliate_id"); 
		$update_one->bind_param('s', $updated_balance);
		$update_one->execute();
	$update_one->close();
}

if($admin_user=='1'){
if ($stmt = $mysqli->prepare("DELETE FROM ap_leads WHERE id = ? LIMIT 1"))
	{ 
	$stmt->bind_param("i", $lead_id);	
	$stmt->execute();
	$stmt->close();
	} else { echo "ERROR: could not prepare SQL statement."; }
}

$mysqli->close();
$_SESSION['action_deleted'] = '1';
header('Location: ../leads');