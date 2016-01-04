<?php include_once '../auth/startup.php';
session_start();
$rs_meta_title = filter_input(INPUT_POST, 'mt', FILTER_SANITIZE_STRING);
$rs_meta_description = filter_input(INPUT_POST, 'md', FILTER_SANITIZE_STRING);
$rs_site_title = filter_input(INPUT_POST, 'st', FILTER_SANITIZE_STRING);
$rs_site_email = filter_input(INPUT_POST, 'se', FILTER_SANITIZE_STRING);
$default_commission = filter_input(INPUT_POST, 'dc', FILTER_SANITIZE_STRING);
$min_payout = filter_input(INPUT_POST, 'mp', FILTER_SANITIZE_STRING);
$paypal = filter_input(INPUT_POST, 'paypal', FILTER_SANITIZE_STRING);
if($paypal==''){$paypal='0';}
$stripe = filter_input(INPUT_POST, 'stripe', FILTER_SANITIZE_STRING);
if($stripe==''){$stripe='0';}
$skrill = filter_input(INPUT_POST, 'skrill', FILTER_SANITIZE_STRING);
if($skrill==''){$skrill='0';}
$wire = filter_input(INPUT_POST, 'wire', FILTER_SANITIZE_STRING);
if($wire==''){$wire='0';}
$checks = filter_input(INPUT_POST, 'checks', FILTER_SANITIZE_STRING);
if($checks==''){$checks='0';}

$update_one = $mysqli->prepare("UPDATE ap_settings SET meta_title = ?, meta_description = ?, site_title = ?, site_email = ?, default_commission = ?, min_payout = ?, paypal = ?, stripe = ?, skrill = ?, wire = ?, checks = ?  WHERE id=1"); 
$update_one->bind_param('sssssssssss', $rs_meta_title, $rs_meta_description, $rs_site_title, $rs_site_email, $default_commission, $min_payout, $paypal, $stripe, $skrill, $wire, $checks);
$update_one->execute();
$update_one->close();
$_SESSION['action_saved'] = '1';
header('Location: ../settings');
?>