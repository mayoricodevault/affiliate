<?php include_once '../auth/startup.php';
$request_id = filter_input(INPUT_POST, 'm', FILTER_SANITIZE_STRING);

	$two = '2';
	$update_one = $mysqli->prepare("UPDATE ap_payouts SET status = ? WHERE id=$request_id"); 
	$update_one->bind_param('s', $two);
	$update_one->execute();
	$update_one->close();

$mysqli->close();

header('Location: ../my-payouts');