<?php 
include_once 'auth/access-functions.php';
sec_session_start();
echo $_SESSION['ap_sale_hit'];
?>