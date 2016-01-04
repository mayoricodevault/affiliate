<?php include_once '../auth/startup.php';
session_start();
$dc = filter_input(INPUT_POST, 'dc', FILTER_SANITIZE_STRING);
if($dc > 100) { $dc = '100';}
if($admin_user=='1'){
	$one = '1';
	$update_one = $mysqli->prepare("UPDATE ap_settings SET default_commission = ? WHERE id=$one"); 
	$update_one->bind_param('s', $dc);
	$update_one->execute();
	$update_one->close();
}
$mysqli->close();
$_SESSION['action_saved'] = '1';
header('Location: ../fixed-commissions');