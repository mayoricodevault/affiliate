<?php include_once '../auth/startup.php';
session_start();
$rc_on = filter_input(INPUT_POST, 'rc_on', FILTER_SANITIZE_STRING);

$update_one = $mysqli->prepare("UPDATE ap_other_commissions SET rc_on = ? WHERE id=1"); 
$update_one->bind_param('s', $rc_on);
$update_one->execute();
$update_one->close();
$_SESSION['action_saved'] = '1';
header('Location: ../recurring-commissions');
?>