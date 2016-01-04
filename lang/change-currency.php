<?php
include('../auth/startup.php');
$selected_currency = filter_input(INPUT_POST, 'selected_currency', FILTER_SANITIZE_STRING);
$_SESSION['locale'] = $selected_currency;
$redirect = filter_input(INPUT_POST, 'redirect', FILTER_SANITIZE_STRING);
header('Location: ../'.$redirect.'');