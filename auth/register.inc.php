<?php
include_once 'db-connect.php';
include_once 'config.inc.php';
include 'password.php';
include_once 'access-functions.php';
sec_session_start(); 
$error_msg = "";

if (isset($_POST['fullname'], $_POST['username'])) {
	
    // Sanitize and validate the data passed in
	$fullname = filter_input(INPUT_POST, 'fullname', FILTER_SANITIZE_STRING);
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
	$terms = filter_input(INPUT_POST, 'terms', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Not a valid email
        $error_msg .= '<p class="error" style="color:red;">The email address you entered is not valid</p>';
    }
 
    $pw = $_POST['p'];
	
    $prep_stmt = "SELECT id FROM ap_members WHERE email = ? LIMIT 1";
    $stmt = $mysqli->prepare($prep_stmt);
 
    if ($stmt) {
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();
 
        if ($stmt->num_rows == 1) {
            // A user with this email address already exists
            $error_msg .= '<p class="error" style="color:red;">A user with this email address already exists.</p>';
        }
	}
	
	$prep_stmt = "SELECT id FROM ap_members WHERE username = ? LIMIT 1";
    $stmt = $mysqli->prepare($prep_stmt);
 
    if ($stmt) {
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->store_result();
 
        if ($stmt->num_rows == 1) {
            // A user with this email address already exists
            $error_msg .= '<p class="error" style="color:red;">This username already exists.</p>';
        }
		
    } else {
        $error_msg .= '<p class="error">Database setup error.</p>';
    }
 
	if ($terms!='1'){$error_msg .= '<p class="error" style="color:red;">You must accept our terms of use and privacy policy.</p>';}
	
	
    if (empty($error_msg)) {
    
 		$hash = password_hash($pw, PASSWORD_DEFAULT, array("cost" => 10));

		if(isset($_COOKIE['ap_sponsor_tracking'])){$sponsor = $_COOKIE['ap_sponsor_tracking'];}else{$sponsor='0';}
        if ($insert_stmt = $mysqli->prepare("INSERT INTO ap_members (fullname, username, email, password, terms, sponsor) VALUES (?, ?, ?, ?, ?, ?)")) {
            $insert_stmt->bind_param('ssssss', $fullname, $username, $email, $hash, $terms, $sponsor);
			
            if (! $insert_stmt->execute()) {
                header('Location: ../error.php?err=Registration failure: INSERT');
            }
        }
		
		
	$prep_stmt = "SELECT id FROM ap_members WHERE username = ? LIMIT 1";
    $stmt = $mysqli->prepare($prep_stmt);
 
    if ($stmt) {
   mysqli_stmt_bind_param($stmt, "s", $username);
   mysqli_stmt_execute($stmt);
   mysqli_stmt_bind_result($stmt, $users_id);
   mysqli_stmt_fetch($stmt);
   mysqli_stmt_close($stmt);


}

	// XSS protection as we might print this value
	$users_id = preg_replace("/[^0-9]+/", "", $users_id);
	$_SESSION['user_id'] = $users_id;
	//$_SESSION['accttype'] = $accttype;
	// XSS protection as we might print this value
	$username = preg_replace("/[^a-zA-Z0-9_\-]+/", 
	"", 
	$username);
	$_SESSION['username'] = $username;
	$_SESSION['fullname'] = $fullname;
	$owner = $users_id;
		
	$get_settings = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT site_title, site_email FROM ap_settings WHERE id=1"));
	$site_title = $get_settings['site_title'];
	$site_email = $get_settings['site_email'];
		
	$get_email = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT email FROM ap_members WHERE id=$owner"));
	$recp_email = $get_email['email'];	
	$to = $recp_email;
	$subject = 'Thanks for Joining our Affiliate Program '.ucwords($fullname);

	$headers = "From: ".$site_email." \r\n";
	$headers .= "Reply-To: ".$site_email." \r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

	$message = '<html><body>';
	$message .= "<h4>Hello ".ucwords($fullname).",</h4>";
	$message .= "<p>Thank you for joining ".$site_title." Affiliate Program.  Login to your account and click on Marketing Materials for ways
	you can start referring traffic and/or sales to us.  If you want to get started right away you can also start referring traffic and/or sales to us using the following link:</p>";
	$message .= '<a href="http://'.$DOMAIN.'?ref'.$owner.'">http:/'.$DOMAIN.'?ref'.$owner.'</a>';
	$message .= '<h4>Thank you!</h4>'.$DOMAIN;
	$message .= "</body></html>";
	mail($to, $subject, $message, $headers);
		
	header('Location: dashboard');
    }
}