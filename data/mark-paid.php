<?php include_once '../auth/startup.php';
$request_id = filter_input(INPUT_POST, 'm', FILTER_SANITIZE_STRING);

if($admin_user=='1'){
	//MAKE PAID
	$one = '1';
	$update_one = $mysqli->prepare("UPDATE ap_payouts SET status = ? WHERE id=$request_id"); 
	$update_one->bind_param('s', $one);
	$update_one->execute();
	$update_one->close();
}
//UPDATE USER BALANCE
$get_data= mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT affiliate_id, amount FROM ap_payouts WHERE id=$request_id"));
$payment_amount = $get_data['amount'];
$affiliate_id = $get_data['affiliate_id'];
$get_balance= mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT balance FROM ap_members WHERE id=$affiliate_id"));
$balance = $get_balance['balance'];
//NEW BALANCE
$new_balance = $balance - $payment_amount;
$update_two = $mysqli->prepare("UPDATE ap_members SET balance = ? WHERE id=$affiliate_id"); 
$update_two->bind_param('s', $new_balance);
$update_two->execute();
$update_two->close();

$mysqli->close();

header('Location: ../payouts');