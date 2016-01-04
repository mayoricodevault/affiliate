<?php include_once '../auth/startup.php';
$request_id = filter_input(INPUT_POST, 'm', FILTER_SANITIZE_STRING);

if($admin_user=='1'){
	//MAKE PAID
	$one = '1';
	$update_one = $mysqli->prepare("UPDATE ap_leads SET converted = ? WHERE id=$request_id"); 
	$update_one->bind_param('s', $one);
	$update_one->execute();
	$update_one->close();
}
$mysqli->close();

header('Location: ../leads');