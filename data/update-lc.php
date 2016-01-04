<?php include_once '../auth/startup.php';
session_start();
$lc_on = filter_input(INPUT_POST, 'lc_on', FILTER_SANITIZE_STRING);
$epl = filter_input(INPUT_POST, 'epl', FILTER_SANITIZE_STRING);

$update_one = $mysqli->prepare("UPDATE ap_other_commissions SET lc_on = ?, epl = ? WHERE id=1"); 
$update_one->bind_param('ss', $lc_on, $epl);
$update_one->execute();
$update_one->close();
$_SESSION['action_saved'] = '1';
header('Location: ../lead-commissions');
?>