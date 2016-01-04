<?php
define("HOST", "localhost");     // The host you want to connect to.
define("USER", "forge");    // The database username.
define("PASSWORD", "9AcXDriMMuqgz8CIQIc4");    // The database password.
define("DATABASE", "affiliate");    // The database name.
 
define("CAN_REGISTER", "any");
define("DEFAULT_ROLE", "member");
 
define("SECURE", FALSE);    // FOR DEVELOPMENT ONLY!!!!

$DOMAIN = $_SERVER['SERVER_NAME'];
//SET TO THE NAME OF THE FOLDER YOUR INSTALLATION IS INSIDE
$INSTALL_FOLDER = '';
//URL WHERE YOU WILL GENERALLY WANT AFFILIATES TO SEND TRAFFIC TO
$main_url = 'http://jdwebdesigner.com';
$domain_path = $DOMAIN.'/'.$INSTALL_FOLDER;

error_reporting(0);