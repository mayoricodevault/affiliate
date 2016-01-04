<?php include_once '../auth/startup.php';
$id = filter_input(INPUT_POST, 'i', FILTER_SANITIZE_STRING);
$affiliate_id = filter_input(INPUT_POST, 'a', FILTER_SANITIZE_STRING);
$transaction_id = filter_input(INPUT_POST, 't', FILTER_SANITIZE_STRING);
$get_ta = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT mt_earnings FROM ap_multi_tier_transactions WHERE id=$id"));
$ta = $get_ta['mt_earnings'];

if($admin_user=='1'){
	//VOID TRANSACTION
	$one = '1';
	$update_one = $mysqli->prepare("UPDATE ap_multi_tier_transactions SET reversed = ? WHERE id=$id"); 
	$update_one->bind_param('s', $one);
	$update_one->execute();
	$update_one->close();
	
//UPDATE BALANCE
$get_tb = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT balance FROM ap_members WHERE id=$affiliate_id"));
$tb = $get_tb['balance'];

$updated_balance = $tb - $ta;
if($updated_balance < 0){$updated_balance ='0.00';}
	$update_one = $mysqli->prepare("UPDATE ap_members SET balance = ? WHERE id=$affiliate_id"); 
	$update_one->bind_param('s', $updated_balance);
	$update_one->execute();
	$update_one->close();
}
$mysqli->close();

header('Location: ../view-mt-payments?tid='.$transaction_id.'');