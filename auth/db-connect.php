<?php
// NO NEED TO EDIT THIS FILE, USE DB-CONNECT.PHP
include_once 'config.inc.php';   // As functions.php is not included
$mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);
/* determine our thread id */
$thread_id = $mysqli->thread_id;
$get_dc = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT default_commission FROM ap_settings"));
print_r($get_dc);

define('DEBUG', false);

if(DEBUG == true)
{
    ini_set('display_errors', 'On');
    error_reporting(E_ALL);
}
else
{
    ini_set('display_errors', 'Off');
    error_reporting(0);
}

if(isset($_SESSION['locale'])){
    $locale = $_SESSION['locale'];  
}else{
  $locale = 'en-US';
}
