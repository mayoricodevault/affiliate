<?php 
include_once '../auth/db-connect.php';
include '../auth/password.php';
function rs($length = 60) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

	//DATA REQURED
	$search_email = filter_input(INPUT_POST, 'se', FILTER_SANITIZE_STRING);

  //SEARCH FOR ACCOUNT MATCHING INPUT EMAIL
  $query = "SELECT email, id, fullname, username FROM `ap_members` WHERE email=?";
  if($stmt = $mysqli->prepare($query)){
      $stmt->bind_param("s", $search_email);
      if($stmt->execute()){
          $stmt->store_result();
            $email_check= "";         
            $stmt->bind_result($email_check, $account_id, $fullname, $username);
            $stmt->fetch();
            if ($stmt->num_rows == 1){
              //ACCOUNT EXISTS SENT RESET PIN AND EMAIL INSTRUCTIONS
              $pin = mt_rand(100000, 999999);
              $key = rs();
              $hashed_pin = password_hash($pin, PASSWORD_DEFAULT, array("cost" => 10));
              $set_pin = $mysqli->prepare("UPDATE ap_members SET forgot_pin = ?, forgot_key = ? WHERE id=$account_id"); 
              $set_pin->bind_param('ss', $hashed_pin, $key);
              $set_pin->execute();
              $set_pin->close();
              //SUCCESSFUL RESET
              $get_settings = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT site_title, site_email FROM ap_settings WHERE id=1"));
              $site_title = $get_settings['site_title'];
              $site_email = $get_settings['site_email'];
		
              $to = $email_check;	
              $subject = $site_title.' Password Reset Request';

              $headers = "From: ".$site_email." \r\n";
              $headers .= "Reply-To: ".$site_email." \r\n";
              $headers .= "MIME-Version: 1.0\r\n";
              $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

              $message = '<html><body>';
              $message .= "<h4>Hello ".ucwords($fullname).",</h4>";
              $message .= "<p>Your or someone has requested for your password be reset at ".$site_title.".  If this was not you please contact us, otherwise follow the link
              below to reset you password and enter the temporary pin below.</p><br><br><strong>Username: ".$username."<br><strong>Temporary PIN: ".$pin."<br>";
              $message .= '<a href="http://'.$domain_path.'/reset?k='.$key.'">http:/'.$domain_path.'/reset?k='.$key.'</a>';
              $message .= '<h4>Thank you!</h4>'.$DOMAIN;
              $message .= "</body></html>";
              mail($to, $subject, $message, $headers);
              header('Location: ../forgot?success=1');
            }else{
              //NO EMAIL ADDRESS FOUND
              header('Location: ../forgot?error=1');
            }
        }
    }