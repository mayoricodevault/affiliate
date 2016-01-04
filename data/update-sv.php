<?php include_once '../auth/startup.php';
session_start();
$sv_on = filter_input(INPUT_POST, 'sv_on', FILTER_SANITIZE_STRING);

$update_one = $mysqli->prepare("UPDATE ap_other_commissions SET sv_on = ? WHERE id=1"); 
$update_one->bind_param('s', $sv_on);
$update_one->execute();
$update_one->close();
$_SESSION['action_saved'] = '1';
header('Location: ../sales-volume-commissions');
?>