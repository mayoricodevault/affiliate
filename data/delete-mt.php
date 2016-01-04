<?php include_once '../auth/startup.php';
session_start();
$id = filter_input(INPUT_POST, 'i', FILTER_SANITIZE_STRING);
$transaction_id = filter_input(INPUT_POST, 't', FILTER_SANITIZE_STRING);

if($admin_user=='1'){
if ($stmt = $mysqli->prepare("DELETE FROM ap_multi_tier_transactions WHERE id = ? LIMIT 1"))
	{ 
	$stmt->bind_param("i", $id);	
	$stmt->execute();
	$stmt->close();
	} else { echo "ERROR: could not prepare SQL statement."; }
}

$mysqli->close();

$_SESSION['action_deleted'] = '1';
header('Location: ../view-mt-payments?tid='.$transaction_id.'');