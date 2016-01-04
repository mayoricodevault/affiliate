<?php include_once '../auth/startup.php';
session_start();
$level = filter_input(INPUT_POST, 'l', FILTER_SANITIZE_STRING);
$user = filter_input(INPUT_POST, 'm', FILTER_SANITIZE_STRING);
if($admin_user=='1'){
	//MAKE PAID
	$one = '1';
	$update_one = $mysqli->prepare("UPDATE ap_members SET admin_user = ? WHERE id=$user"); 
	$update_one->bind_param('s', $level);
	$update_one->execute();
	$update_one->close();
}
$mysqli->close();
$_SESSION['action_saved'] = '1';
header('Location: ../user-management');