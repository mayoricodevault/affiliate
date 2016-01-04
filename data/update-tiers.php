<?php include_once '../auth/startup.php';
session_start();
$tier2 = filter_input(INPUT_POST, 'tier2', FILTER_SANITIZE_STRING);
$tier3 = filter_input(INPUT_POST, 'tier3', FILTER_SANITIZE_STRING);
$tier4 = filter_input(INPUT_POST, 'tier4', FILTER_SANITIZE_STRING);
$tier5 = filter_input(INPUT_POST, 'tier5', FILTER_SANITIZE_STRING);
$tier6 = filter_input(INPUT_POST, 'tier6', FILTER_SANITIZE_STRING);
$tier7 = filter_input(INPUT_POST, 'tier7', FILTER_SANITIZE_STRING);
$tier8 = filter_input(INPUT_POST, 'tier8', FILTER_SANITIZE_STRING);
$tier9 = filter_input(INPUT_POST, 'tier9', FILTER_SANITIZE_STRING);
$tier10 = filter_input(INPUT_POST, 'tier10', FILTER_SANITIZE_STRING);

$update_one = $mysqli->prepare("UPDATE ap_other_commissions SET tier2 = ?, tier3 = ?, tier4 = ?, tier5 = ?, tier6 = ?, tier7 = ?, tier8 = ?, tier9 = ?, tier10 = ? WHERE id=1"); 
$update_one->bind_param('sssssssss', $tier2, $tier3, $tier4, $tier5, $tier6, $tier7, $tier8, $tier9, $tier10);
$update_one->execute();
$update_one->close();
$_SESSION['action_saved'] = '1';
header('Location: ../multi-tier-commissions');
?>