<?php include_once '../auth/startup.php';
$transaction_id = filter_input(INPUT_POST, 'm', FILTER_SANITIZE_STRING);

if($admin_user=='1'){
if ($stmt = $mysqli->prepare("DELETE FROM ap_payouts WHERE id = ? LIMIT 1"))
	{ 
	$stmt->bind_param("i", $transaction_id);	
	$stmt->execute();
	$stmt->close();
	} else { echo "ERROR: could not prepare SQL statement."; }
}

$mysqli->close();

header('Location: ../payouts');