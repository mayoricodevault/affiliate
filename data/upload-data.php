<?php include_once '../auth/db-connect.php';
include('data-functions.php');
$adsize = filter_input(INPUT_POST, 'adsize', FILTER_SANITIZE_STRING);
$target_dir = "banners/";
$filename = $_FILES["file"]["name"];
$size = $_FILES["file"]["size"];
$upload_date = date('j M Y H:i:s');
$name = pathinfo($_FILES['file']['name'], PATHINFO_FILENAME);
$extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
$db_filename = $name.'.'.$extension;
$target_file = $target_dir . basename($_FILES["file"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

// Check if file already exists
$counter = 0;
while (file_exists($target_file)) {
	$db_filename = basename($name.'_'.$counter.'.'.$extension);
    $target_file = $target_dir . basename($name.'_'.$counter.'.'.$extension);
	$counter++;
}
// Check file size
if ($_FILES["file"]["size"] > 500000) {
    
}
if ($uploadOk == 0) {
} else {
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
		$stmt = $mysqli->prepare("INSERT INTO ap_banners (filename, filetype, adsize) VALUES (?, ?, ?)");
		$stmt->bind_param('sss', $db_filename, $extension, $adsize);
		$stmt->execute();
		$stmt->close();
    } else {
       
    }
}
header('Location: ../banners-logos');
?>