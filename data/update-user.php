<?php include_once '../auth/startup.php';
$f = filter_input(INPUT_POST, 'f', FILTER_SANITIZE_STRING);
$e = filter_input(INPUT_POST, 'e', FILTER_SANITIZE_STRING);
//update the values
$update_one = $mysqli->prepare("UPDATE ap_members SET fullname = ?, email = ? WHERE id=$owner"); 
$update_one->bind_param('ss', $f, $e);
$update_one->execute();
$update_one->close();
	
$mysqli->close();
header('Location: ../profile');
?>