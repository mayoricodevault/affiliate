<?php include_once '../auth/startup.php';
session_start();
$cpc_on = filter_input(INPUT_POST, 'cpc_on', FILTER_SANITIZE_STRING);
$epc = filter_input(INPUT_POST, 'epc', FILTER_SANITIZE_STRING);

$update_one = $mysqli->prepare("UPDATE ap_other_commissions SET cpc_on = ?, epc = ? WHERE id=1"); 
$update_one->bind_param('ss', $cpc_on, $epc);
$update_one->execute();
$update_one->close();
$_SESSION['action_saved'] = '1';
header('Location: ../cpc-commissions');
?>