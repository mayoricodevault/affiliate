<?php include_once '../auth/db-connect.php';
include('../auth/password.php');

	//DATA REQURED
	$key = filter_input(INPUT_POST, 'key', FILTER_SANITIZE_STRING);
	$pin = filter_input(INPUT_POST, 'pin', FILTER_SANITIZE_STRING);
	$pwd = filter_input(INPUT_POST, 'new_pass', FILTER_SANITIZE_STRING);
	$cpwd = filter_input(INPUT_POST, 'c_pass', FILTER_SANITIZE_STRING);

	if($key!='' || $pin != ''){
	$query = "SELECT forgot_pin, id FROM `ap_members` WHERE forgot_key = ?";
  if($stmt = $mysqli->prepare($query)){
      $stmt->bind_param("s", $key);
      if($stmt->execute()){
          $stmt->store_result();
            $email_check= "";         
            $stmt->bind_result($db_pin, $owner);
            $stmt->fetch();	

						if($stmt->num_rows == 1){
							//KEY FOUND, VALID TEMPORARY PIN
							if(password_verify($pin, $db_pin)){
							
								//PIN VALIDATED
								if($pwd == $cpwd){ 
									//HASH NEW PASSWORD
									$hash = password_hash($pwd, PASSWORD_DEFAULT, array("cost" => 10));
									//UPDATE DB
									$reset = '';
									$update_one = $mysqli->prepare("UPDATE ap_members SET password = ?, forgot_pin = ?, forgot_key = ? WHERE id=$owner"); 
									$update_one->bind_param('sss', $hash, $reset, $reset);
									$update_one->execute();
									$update_one->close();
									
									header('Location: ../login?success=1');
								}else{
									//PASSWORDS DO NOT MATCH
									header('Location: ../reset?k='.$key.'&error=1');
								}
							}else{
								//INVALID PIN ENTERED
								header('Location: ../reset?k='.$key.'&error=2');
							}
					}
			}
	}
	
}else{
	header('Location: ../reset?k='.$key.'&error=3');	
}
?>