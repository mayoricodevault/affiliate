<?php include('../auth/db-connect.php');
//LOOP THROUGH ALL ACTIVE RECURRING TRANSACTIONS
$query = "SELECT * FROM ap_earnings WHERE recurring_fee > 0 AND stop_recurring=0";
	$query = $mysqli->real_escape_string($query);
		if($result = $mysqli->query($query)){
			$num_results = mysqli_num_rows($result);
			while($row = $result->fetch_array())
				{
				$today = date('Y-m-d');
				$affiliate_id = $row['affiliate_id'];
				//MONTHLY RECURRING
				if($row['recurring']=='monthly'){
					if($row['last_reoccurance']=='0000-00-00 00:00:00'){
						$recurring_date = date('Y-m-d', strtotime($row['datetime'] . ' +1 month'));
					}else{
						$recurring_date = date('Y-m-d', strtotime($row['last_reoccurance'] . ' +1 month'));	
					}
				}
				//WEEKLY RECURRING
				if($row['recurring']=='weekly'){
					if($row['last_reoccurance']=='0000-00-00 00:00:00'){
						$recurring_date = date('Y-m-d', strtotime($row['datetime'] . ' +1 week'));
					}else{
						$recurring_date = date('Y-m-d', strtotime($row['last_reoccurance'] . ' +1 week'));	
					}
				}
				//BIWEEKLY RECURRING
				if($row['recurring']=='biweekly'){
					if($row['last_reoccurance']=='0000-00-00 00:00:00'){
						$recurring_date = date('Y-m-d', strtotime($row['datetime'] . ' +2 weeks'));
					}else{
						$recurring_date = date('Y-m-d', strtotime($row['last_reoccurance'] . ' +2 weeks'));	
					}
				}
				//DAILY RECURRING
				if($row['recurring']=='daily'){
					if($row['last_reoccurance']=='0000-00-00 00:00:00'){
						$recurring_date = date('Y-m-d', strtotime($row['datetime'] . ' +1 day'));
					}else{
						$recurring_date = date('Y-m-d', strtotime($row['last_reoccurance'] . ' +1 day'));	
					}
				}
				echo $recurring_date.'<br>';
				//IF TODAY IS RECURRING'S LUCKY DAY
				if($recurring_date == $today){
					//SET LAST REOCCURANCE DATE
					$datetime = date("Y-m-d H:i:s");
					$transaction_id = $row['id'];
					$update_one = $mysqli->prepare("UPDATE ap_earnings SET last_reoccurance = ? WHERE id=$transaction_id"); 
					$update_one->bind_param('s', $datetime);
					$update_one->execute();
					$update_one->close();
					
					//CALC RECURRING DOLLAR AMOUNT
					$recurring_fee = $row['recurring_fee'] / 100;
					$sale_amount = $row['sale_amount'];
					echo $recurring_fee;
					$recurring_earnings = $sale_amount * $recurring_fee;
					
					//UPDATE AFFILIATE_BALANCE
					$get_affiliate = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT balance FROM ap_members WHERE id=$affiliate_id"));
					$affiliate_balance = $get_affiliate['balance'];
					$updated_balance = $recurring_earnings + $affiliate_balance;
					$update_one = $mysqli->prepare("UPDATE ap_members SET balance = ? WHERE id=$affiliate_id"); 
					$update_one->bind_param('s', $updated_balance);
					$update_one->execute();
					$update_one->close();
					
					//INSERT INTO RECURRING HISTORY
					$stmt = $mysqli->prepare("INSERT INTO ap_recurring_history (affiliate_id, transaction_id, recurring_earnings, datetime) VALUES (?, ?, ?, ?)");
					$stmt->bind_param('ssss', $affiliate_id, $transaction_id, $recurring_earnings, $datetime);
					$stmt->execute();
					$stmt->close();
				}
			}
		}