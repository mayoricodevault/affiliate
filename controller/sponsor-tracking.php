<?php
include_once 'auth/db-connect.php';
$ap_sponsor_tracking = 'ap_sponsor_tracking';
$sponsor_id = filter_input(INPUT_GET, 'sponsor'); 
$days_to_expiration = '30';
//SET A NEW COOKIE
if(isset($sponsor_id) && empty($_COOKIE[$ap_sponsor_tracking])) {
setcookie($ap_sponsor_tracking, $sponsor_id, time() + (86400 * $days_to_expiration), '/');
header("Refresh:0");
}


