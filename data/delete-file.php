<?php include_once '../auth/db-connect.php';
$file_id = filter_input(INPUT_POST, 'f', FILTER_SANITIZE_STRING);
//DELETE FILE FROM SERVER
$get_path = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT filename FROM ap_banners WHERE id=$file_id"));
$file_path = $get_path['filename'];
unlink('banners/'.$file_path); 
if ($stmt = $mysqli->prepare("DELETE FROM ap_banners WHERE id = ? LIMIT 1"))
	{ 
	$stmt->bind_param("i", $file_id);	
	$stmt->execute();
	$stmt->close();
	} else { echo "ERROR: could not prepare SQL statement."; }
	
$mysqli->close();

header('Location: ../banners-logos');