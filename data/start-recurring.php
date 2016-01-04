<?php include_once '../auth/startup.php';
$transaction_id = filter_input(INPUT_POST, 'm', FILTER_SANITIZE_STRING);
if($admin_user=='1'){
	//START RECURRING
	$one = '0';
	$update_one = $mysqli->prepare("UPDATE ap_earnings SET stop_recurring = ? WHERE id=$transaction_id"); 
	$update_one->bind_param('s', $one);
	$update_one->execute();
	$update_one->close();
}
$mysqli->close();

header('Location: ../recurring-sales');