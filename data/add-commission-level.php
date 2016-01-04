<?php include_once '../auth/db-connect.php';
	
	//DATA REQURED
	$sales_from = filter_input(INPUT_POST, 'sf', FILTER_SANITIZE_STRING);
	$sales_to = filter_input(INPUT_POST, 'st', FILTER_SANITIZE_STRING);
	$c = filter_input(INPUT_POST, 'c', FILTER_SANITIZE_STRING);

	$stmt = $mysqli->prepare("INSERT INTO ap_commission_settings (sales_from, sales_to, percentage) VALUES (?, ?, ?)");
	$stmt->bind_param('sss', $sales_from, $sales_to, $c);
	$stmt->execute();
	$stmt->close();

header('Location: ../sales-volume-commissions');
?>