<?php include_once '../auth/startup.php';
session_start();
$level_id = filter_input(INPUT_POST, 'm', FILTER_SANITIZE_STRING);
if($admin_user=='1'){
if ($stmt = $mysqli->prepare("DELETE FROM ap_commission_settings WHERE id = ? LIMIT 1"))
	{ 
	$stmt->bind_param("i", $level_id);	
	$stmt->execute();
	$stmt->close();
	} else { echo "ERROR: could not prepare SQL statement."; }
	
}
$mysqli->close();
$_SESSION['action_deleted'] = '1';
header('Location: ../sales-volume-commissions');