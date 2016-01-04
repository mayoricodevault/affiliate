<?php include_once '../auth/startup.php';
$referral_id = filter_input(INPUT_POST, 'm', FILTER_SANITIZE_STRING);
$affiliate_id = filter_input(INPUT_POST, 'a', FILTER_SANITIZE_STRING);
$redirect = filter_input(INPUT_POST, 'r', FILTER_SANITIZE_STRING);

if($admin_user=='1'){
if ($stmt = $mysqli->prepare("DELETE FROM ap_referral_traffic WHERE id = ? LIMIT 1"))
	{ 
	$stmt->bind_param("i", $referral_id);	
	$stmt->execute();
	$stmt->close();
	} else { echo "ERROR: could not prepare SQL statement."; }
}

$mysqli->close();


if($redirect == 'affiliate-stats'){$redirect = 'affiliate-stats?a='.$affiliate_id.'';}else { $redirect = 'referral-traffic';}

header('Location: ../'.$redirect.'');