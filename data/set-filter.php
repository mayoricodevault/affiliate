<?php include('../auth/startup.php');
$start_date = filter_input(INPUT_POST, 'start_date', FILTER_SANITIZE_STRING);
$end_date = filter_input(INPUT_POST, 'end_date', FILTER_SANITIZE_STRING);
$redirect = filter_input(INPUT_POST, 'redirect', FILTER_SANITIZE_STRING);
$affiliate_filter = filter_input(INPUT_POST, 'af', FILTER_SANITIZE_STRING);
unset($_SESSION['start_date']);
unset($_SESSION['end_date']);
$_SESSION['start_date'] = $start_date;
$_SESSION['end_date'] = $end_date;
if(isset($affiliate_filter)){$q = '?a='.$affiliate_filter.'';}
header('Location: '.$redirect.$q.'');