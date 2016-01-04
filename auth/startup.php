<?php
include_once 'db-connect.php';
include_once 'access-functions.php';
sec_session_start();

if (login_check($mysqli) == true) {
    $logged = 'in';
	$_SESSION['loggedin']='1';
	$userid = $_SESSION['user_id'];
	$fullname = $_SESSION['fullname'];
	if($_SESSION['owner']==''){$owner = $userid;}else{$owner = $_SESSION['owner'];}
	$get_access_level = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT admin_user FROM ap_members WHERE id=$owner"));
	$admin_user = $get_access_level['admin_user'];

} else {
	$logged = 'out';
	$_SESSION['loggedin']='0';
	header('Location: index');
}
/* ===========================================
		Date Period Filter 
   	========================================= */
if(isset($_SESSION['start_date'])){$start_date = $_SESSION['start_date'];}
if(isset($_SESSION['end_date'])){$end_date = $_SESSION['end_date'];}
if(empty($start_date)){$start_date = date('Y-m-d', strtotime('today - 364 days'));}
if(empty($end_date)){$end_date= date('Y-m-d', strtotime('today + 1 day'));}

/* ===========================================
		Langauge Support  
   	========================================= */
	if(isset($_SESSION['language'])){$language = $_SESSION['language'];}	
	
	//DEFAULT LANGUAGE
	if(empty($language)){$language='en'; $_SESSION['language'] = 'en';}
	include('lang/'.$language.'.php'); 
