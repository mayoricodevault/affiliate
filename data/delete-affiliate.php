<?php include_once '../auth/startup.php';
session_start();
$affiliate_id = filter_input(INPUT_POST, 'm', FILTER_SANITIZE_STRING);
if($admin_user=='1'){
if ($stmt = $mysqli->prepare("DELETE FROM ap_members WHERE id = ? LIMIT 1"))
	{ 
	$stmt->bind_param("i", $affiliate_id);	
	$stmt->execute();
	$stmt->close();
	} else { echo "ERROR: could not prepare SQL statement."; }
	

//DELETE SALES AND TRAFFIC HISTORY
if ($stmt = $mysqli->prepare("DELETE FROM ap_earnings WHERE affiliate_id = ?"))
	{ 
	$stmt->bind_param("i", $affiliate_id);	
	$stmt->execute();
	$stmt->close();
	} else { echo "ERROR: could not prepare SQL statement."; }

if ($stmt = $mysqli->prepare("DELETE FROM ap_referral_traffic WHERE affiliate_id = ?"))
	{ 
	$stmt->bind_param("i", $affiliate_id);	
	$stmt->execute();
	$stmt->close();
	} else { echo "ERROR: could not prepare SQL statement."; }	
}

$mysqli->close();
$_SESSION['action_deleted'] = '1';
header('Location: ../affiliates');