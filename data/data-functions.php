<?php
/* ===========================================
	TOP NAV FUNCTION 
   ========================================= */
function admin_control($admin_user, $lang_u, $lang_a){
	if($admin_user=='1'){
	echo '<li>
		<a href="user-management"><i class="icon-default fa fa-fw fa-user"></i> '.$lang_u.'</a>
	</li>
	<li>
		<a href="settings"><i class="icon-default fa fa-fw fa-cog"></i> '.$lang_a.'</a>
	</li>';}
}

function avatar($userid){
	include('auth/db-connect.php');
	$get_email = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT email FROM ap_members WHERE id=$userid"));
	$email = $get_email['email'];
	//GRAVATAR IMAGE URL
	$size = 40;
	$grav_url = "http://www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) ) . "?d=" . urlencode( $default ) . "&s=" . $size;
	echo '<img src="'.$grav_url.'">';
}

function balance($owner){
	include('auth/db-connect.php');
	$get_balance= mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT balance FROM ap_members WHERE id=$owner"));
	$balance = $get_balance['balance'];
	$money_format = new \NumberFormatter($locale, \NumberFormatter::CURRENCY); 
  $currency_symbol = $money_format->getSymbol(\NumberFormatter::INTL_CURRENCY_SYMBOL); 
	echo $money_format->formatCurrency($balance,  $currency_symbol); 
}

/* ===========================================
	PROFILE FUNCTION 
   ========================================= */

function profile_name($owner){
	include('auth/db-connect.php');
	$get_profile = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT fullname FROM ap_members WHERE id=$owner"));
	$name = $get_profile['fullname'];
	echo $name;
}

function profile_img($owner){
	include('auth/db-connect.php');
	$get_profile = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT avatar FROM ap_members WHERE id=$owner"));
	if($get_profile['avatar']==''){
		//GRAVATAR IMAGE URL
		$email = $get_profile['email'];
		$size = 180;
		$grav_url = "http://www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) ) . "?d=" . urlencode( $default ) . "&s=" . $size;
		echo '<img src="'.$grav_url.'">';
	}
}

function profile_details($owner){
	include('auth/db-connect.php');
	include('lang/'.$_SESSION['language'].'.php');
	$get_profile = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT fullname, email, username FROM ap_members WHERE id=$owner"));
	$profile_name = $get_profile['fullname'];
	$profile_email = $get_profile['email'];
	$profile_username = $get_profile['username'];
	echo '
		<form method="post" action="data/update-user">
			<input type="text" name="f" value="'.$profile_name.'">
			<input type="text" name="e" value="'.$profile_email.'">
			<input type="submit" class="btn btn-success" value="Save">
		</form>';

}
/* ===========================================
	AFFILIATES FUNCTION 
   ========================================= */
function affiliate_name($affiliate_filter){
	include('auth/db-connect.php');
	$get_profile = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT fullname FROM ap_members WHERE id=$affiliate_filter"));
	$name = $get_profile['fullname'];
	echo ucwords($name);
}

function affiliates_table(){
	include('auth/db-connect.php');
	$query = "SELECT * FROM ap_members WHERE admin_user!=1 ORDER BY id DESC";
	$query = $mysqli->real_escape_string($query);
		if($result = $mysqli->query($query)){
			$num_results = mysqli_num_rows($result);
			while($row = $result->fetch_array())
				{
				$member = $row['id'];
				//CALC AFFILIATE SALES
				$get_affiliate = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT SUM(sale_amount) as affiliate_sales FROM ap_earnings WHERE affiliate_id=$member"));
				$affiliate_sales = $get_affiliate['affiliate_sales'];
				if($affiliate_sales==''){$affiliate_sales = '0.00';}
				//CALC AFFILIATE REFERRALS
				$get_affiliate = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT COUNT(id) as affiliate_referrals FROM ap_referral_traffic WHERE affiliate_id=$member"));
				$affiliate_referrals = $get_affiliate['affiliate_referrals'];
				if($affiliate_referrals==''){$affiliate_referrals = '0.00';}
				//MULTI CURRENCY
				$money_format = new \NumberFormatter($locale, \NumberFormatter::CURRENCY); 
 				$currency_symbol = $money_format->getSymbol(\NumberFormatter::INTL_CURRENCY_SYMBOL); 
				echo '<tr>
						<td>?ref='.$member.'</td>
						<td><a href="affiliate-stats?a='.$row['id'].'">'.$row['fullname'].'</a></td>
						<td>'.$row['username'].'</td>
						<td>'.$row['email'].'</td>
						<td>'.$affiliate_referrals.'</td>
						<td>'.$money_format->formatCurrency($affiliate_sales, $currency_symbol).'</td>
						<td>'.$money_format->formatCurrency($row['balance'], $currency_symbol).'</td>
						<td>'; if($row['terms']=='1'){echo 'Yes';} echo '</td>
						<td>
							<form method="get" action="affiliate-stats" class="pull-left">
								<input type="hidden" name="a" value="'.$row['id'].'">
								<input type="submit" class="btn btn-sm btn-primary" value="View Stats">
							</form>
							<form method="post" action="data/delete-affiliate" class="pull-left">
								<input type="hidden" name="m" value="'.$row['id'].'">
								<input type="submit" class="btn btn-sm btn-danger" value="Delete">
							</form>
						</td>
					</tr>';
			}
		}
}

function top_affiliates_table(){
	include('auth/db-connect.php');
	$limit = '4';
	$i = '0';
	$query = "SELECT affiliate_id, COUNT(*) as count FROM ap_earnings GROUP BY affiliate_id ORDER BY count DESC;";
	$query = $mysqli->real_escape_string($query);
		if($result = $mysqli->query($query)){
			$num_results = mysqli_num_rows($result);
			while($row = $result->fetch_array())
				{
				if($i < $limit){
					$affiliate_id = $row['affiliate_id'];
					$get_affiliate = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT fullname, email FROM ap_members WHERE id=$affiliate_id"));
					$fullname = $get_affiliate['fullname'];
					$email = $get_affiliate['email'];
					//CALC AFFILIATE SALES
					$get_affiliate = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT SUM(sale_amount) as affiliate_sales, COUNT(id) as ts FROM ap_earnings WHERE affiliate_id=$affiliate_id"));
					$affiliate_sales = $get_affiliate['affiliate_sales'];
					if($affiliate_sales==''){$affiliate_sales = '0.00';}
					$sales_count = $get_affiliate['ts'];
					//CALC AFFILIATE REFERRALS
					$get_affiliate = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT COUNT(id) as affiliate_referrals, COUNT(id) as tr FROM ap_referral_traffic WHERE affiliate_id=$affiliate_id"));
					$affiliate_referrals = $get_affiliate['affiliate_referrals'];
					if($affiliate_referrals==''){$affiliate_referrals = '0.00';}
					$referral_count = $get_affiliate['tr'];
					//MULTI CURRENCY
					$money_format = new \NumberFormatter($locale, \NumberFormatter::CURRENCY); 
					$currency_symbol = $money_format->getSymbol(\NumberFormatter::INTL_CURRENCY_SYMBOL); 
					echo '<tr class="top-list">
							<td>'; avatar($affiliate_id); echo '<a href="affiliate-stats?a='.$affiliate_id.'">'.$fullname.'</a></td>
							<td>'.$affiliate_referrals.'</td>
							<td>'.$money_format->formatCurrency($affiliate_sales, $currency_symbol).'</td>
							<td>'; $conv = $sales_count / $referral_count  * 100; echo number_format((float)$conv, 2, '.', '').'%'; echo '</td>
						  </tr>';
				}
				$i++;
			}	
		}
}

function top_affiliates_list(){
include('auth/db-connect.php');
	$limit = '5';
	$i = '0';
	$query = "SELECT affiliate_id, COUNT(*) as count FROM ap_earnings GROUP BY affiliate_id ORDER BY count DESC";
	$query = $mysqli->real_escape_string($query);
		if($result = $mysqli->query($query)){
			$num_results = mysqli_num_rows($result);
			while($row = $result->fetch_array())
				{
				if($i < $limit){
					$affiliate_id = $row['affiliate_id'];
					$get_affiliate = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT fullname, email FROM ap_members WHERE id=$affiliate_id"));
					$fullname = $get_affiliate['fullname'];
					$email = $get_affiliate['email'];
					$size = 40;
					$grav_url = "http://www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) ) . "?d=" . urlencode( $default ) . "&s=" . $size;
					echo '
						<li id="'.$affiliate_id.'" class="side-danger">
							<a href="affiliate-stats?a='.$affiliate_id.'">
								<img src="'.$grav_url.'">
								'.$fullname.'
							</a>
						</li>';
				}
				$i++;
			}	
		}
}

/* ===========================================
	REFERRAL TRAFFIC FUNCTIONS
   ========================================= */
function referral_table($start_date, $end_date, $affiliate_filter){
	include('auth/db-connect.php');
	$start_date = $start_date.'000000';
	$end_date = $end_date.'235959';
	$start_date = str_replace("-", "", $start_date);
	$end_date = str_replace("-", "", $end_date);
	if(isset($affiliate_filter)){$show = ' AND affiliate_id='.$affiliate_filter.'';}
	$query = "SELECT * FROM ap_referral_traffic WHERE datetime > $start_date AND datetime < $end_date $show ORDER BY datetime DESC";
	$query = $mysqli->real_escape_string($query);
		if($result = $mysqli->query($query)){
			$num_results = mysqli_num_rows($result);
			while($row = $result->fetch_array())
				{
				$affiliate_id = $row['affiliate_id'];
				$get_affiliate = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT * FROM ap_members WHERE id=$affiliate_id"));
				$affiliate_user = $get_affiliate['fullname'];
				//CHECK IF CPC ENABLED
				$get_cpc_on = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT cpc_on FROM ap_other_commissions WHERE id=1"));
				$cpc_on = $get_cpc_on['cpc_on'];
				//MULTI CURRENCY
				$money_format = new \NumberFormatter($locale, \NumberFormatter::CURRENCY); 
				$currency_symbol = $money_format->getSymbol(\NumberFormatter::INTL_CURRENCY_SYMBOL); 
				numfmt_set_attribute($money_format, NumberFormatter::MAX_FRACTION_DIGITS, 6);
				echo '<tr>
						<td><a href="affiliate-stats?a='.$affiliate_id.'">'; if($affiliate_user!=''){echo $affiliate_user;}else{echo 'No Affiliate';} echo '</a></td>
						<td>'.$row['ip'].'</td>
						<td>'.$row['agent'].'</td>
						<td>'.$row['host_name'].'</td>
						<td>'.$row['landing_page'].'</td>';
						if($cpc_on=='1'){
							echo '<td>';
							if($row['void']=='1'){ echo '<span class="red">'.$money_format->formatCurrency('0.00', $currency_symbol).' (VOID)</span>';} else {								 
									if($row['cpc_earnings']=='0'){echo $money_format->formatCurrency('0.00', $currency_symbol);}
						 			else { echo $money_format->formatCurrency($row['cpc_earnings'], $currency_symbol); }
							}
						echo '</td>';}
						echo '<td>'.$row['datetime'].'</td>
						<td>
							<form method="post" action="data/void-referral" class="pull-left">
								<input type="hidden" name="m" value="'.$row['id'].'">
								<input type="hidden" name="a" value="'.$row['affiliate_id'].'">
								<input type="hidden" name="r" value="'.pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME).'">
								<input type="submit" class="btn btn-xs btn-inverse" value="Void">
							</form>
							<form method="post" action="data/delete-referral" class="pull-left">
								<input type="hidden" name="m" value="'.$row['id'].'">
								<input type="hidden" name="a" value="'.$row['affiliate_id'].'">
								<input type="hidden" name="r" value="'.pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME).'">
								<input type="submit" class="btn btn-xs btn-danger" value="Delete">
							</form>
						</td>
					</tr>';
			}
		}
}

function top_url_referral_table($start_date, $end_date, $affiliate_filter){
	include('auth/db-connect.php');
	$start_date = $start_date.'000000';
	$end_date = $end_date.'235959';
	$start_date = str_replace("-", "", $start_date);
	$end_date = str_replace("-", "", $end_date);
	if(isset($affiliate_filter)){$show = ' AND affiliate_id='.$affiliate_filter.'';}
	$query = "SELECT landing_page, datetime, affiliate_id, COUNT(*) as count FROM ap_referral_traffic WHERE datetime > $start_date AND datetime < $end_date $show GROUP BY landing_page ORDER BY count DESC LIMIT 0, 5";
	$query = $mysqli->real_escape_string($query);
		if($result = $mysqli->query($query)){
			$num_results = mysqli_num_rows($result);
			while($row = $result->fetch_array())
				{
				$affiliate_id = $row['affiliate_id'];
				$get_affiliate = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT * FROM ap_members WHERE id=$affiliate_id"));
				$affiliate_user = $get_affiliate['fullname'];
				echo '<tr>
						<td><a href="affiliate-stats?a='.$affiliate_id.'">'; if($affiliate_user!=''){echo $affiliate_user;}else{echo 'No Affiliate';} echo '</a></td>
						<td>'.$row['landing_page'].'</td>
					</tr>';
			}
		}
}

function top_referring_affiliates($start_date, $end_date, $affiliate_filter){
	include('auth/db-connect.php');
	$start_date = $start_date.'000000';
	$end_date = $end_date.'235959';
	$start_date = str_replace("-", "", $start_date);
	$end_date = str_replace("-", "", $end_date);
	if(isset($affiliate_filter)){$show = ' AND affiliate_id='.$affiliate_filter.'';}
	$query = "SELECT SUM(cpc_earnings) as total_cpc, landing_page, datetime, affiliate_id, COUNT(*) as count FROM ap_referral_traffic WHERE datetime > $start_date AND datetime < $end_date $show GROUP BY affiliate_id ORDER BY count DESC LIMIT 0, 5";
	$query = $mysqli->real_escape_string($query);
		if($result = $mysqli->query($query)){
			$num_results = mysqli_num_rows($result);
			while($row = $result->fetch_array())
				{
				$affiliate_id = $row['affiliate_id'];
				$get_affiliate = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT fullname, email FROM ap_members WHERE id=$affiliate_id"));
				$affiliate_user = $get_affiliate['fullname'];
				$email = $get_affiliate['email'];
				//CHECK IF CPC ENABLED
				$get_cpc_on = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT cpc_on FROM ap_other_commissions WHERE id=1"));
				$cpc_on = $get_cpc_on['cpc_on'];
				//MULTI CURRENCY
				$money_format = new \NumberFormatter($locale, \NumberFormatter::CURRENCY); 
				$currency_symbol = $money_format->getSymbol(\NumberFormatter::INTL_CURRENCY_SYMBOL); 
				numfmt_set_attribute($money_format, NumberFormatter::MAX_FRACTION_DIGITS, 6);
				echo '<tr class="top-list">
						<td>'; avatar($affiliate_id); echo '<a href="affiliate-stats?a='.$affiliate_id.'">'.$affiliate_user.'</a></td>
						<td>'.$row['count'].'</td>';
						if($cpc_on=='1'){echo '<td>'; 
						if($row['total_cpc']=='0'){echo $money_format->formatCurrency($row['total_cpc'], $currency_symbol);;}
						 else { echo $money_format->formatCurrency($row['total_cpc'], $currency_symbol); }
						echo '</td>';}
				echo '</tr>';
			}
		}
}

function my_referral_table($start_date, $end_date, $owner){
	include('auth/db-connect.php');
	$start_date = $start_date.'000000';
	$end_date = $end_date.'235959';
	$start_date = str_replace("-", "", $start_date);
	$end_date = str_replace("-", "", $end_date);
	$query = "SELECT * FROM ap_referral_traffic WHERE affiliate_id=$owner AND datetime > $start_date AND datetime < $end_date ORDER BY datetime DESC";
	$query = $mysqli->real_escape_string($query);
		if($result = $mysqli->query($query)){
			$num_results = mysqli_num_rows($result);
			while($row = $result->fetch_array())
				{
				$affiliate_id = $row['affiliate_id'];
				$get_affiliate = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT * FROM ap_members WHERE id=$affiliate_id"));
				$affiliate_user = $get_affiliate['fullname'];
				//CHECK IF CPC ENABLED
				$get_cpc_on = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT cpc_on FROM ap_other_commissions WHERE id=1"));
				$cpc_on = $get_cpc_on['cpc_on'];
				//MULTI CURRENCY
				$money_format = new \NumberFormatter($locale, \NumberFormatter::CURRENCY); 
				$currency_symbol = $money_format->getSymbol(\NumberFormatter::INTL_CURRENCY_SYMBOL); 
				numfmt_set_attribute($money_format, NumberFormatter::MAX_FRACTION_DIGITS, 6); 
				echo '<tr>
						<td>'.$row['ip'].'</td>
						<td>'.$row['agent'].'</td>
						<td>'.$row['host_name'].'</td>
						<td>'.$row['landing_page'].'</td>';
						if($cpc_on=='1'){echo '<td>'; 
						if($row['cpc_earnings']=='0'){echo $money_format->formatCurrency('0.00', $currency_symbol);;}
						 else { echo $money_format->formatCurrency($row['cpc_earnings'], $currency_symbol); }
						echo '</td>';}
						echo '<td>'.$row['datetime'].'</td>
					</tr>';
			}
		}
}

function recent_referrals($owner){
	include('auth/db-connect.php');

	$query = "SELECT * FROM ap_referral_traffic WHERE affiliate_id=$owner ORDER BY datetime DESC LIMIT 0, 4";
	$query = $mysqli->real_escape_string($query);
		if($result = $mysqli->query($query)){
			$num_results = mysqli_num_rows($result);
			while($row = $result->fetch_array())
				{
				$affiliate_id = $row['affiliate_id'];
				$get_affiliate = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT * FROM ap_members WHERE id=$affiliate_id"));
				$affiliate_user = $get_affiliate['fullname'];
				//CHECK IF CPC ENABLED
				$get_cpc_on = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT cpc_on FROM ap_other_commissions WHERE id=1"));
				$cpc_on = $get_cpc_on['cpc_on'];
				//MULTI CURRENCY
				$money_format = new \NumberFormatter($locale, \NumberFormatter::CURRENCY); 
				$currency_symbol = $money_format->getSymbol(\NumberFormatter::INTL_CURRENCY_SYMBOL); 
				numfmt_set_attribute($money_format, NumberFormatter::MAX_FRACTION_DIGITS, 6);
				echo '<tr>
						<td>'.$row['ip'].'</td>
						<td>'.$row['landing_page'].'</td>';
						if($cpc_on=='1'){echo '<td>'; 
						if($row['cpc_earnings']=='0'){echo $money_format->formatCurrency('0.00', $currency_symbol);}
						 else { echo $money_format->formatCurrency($row['cpc_earnings'], $currency_symbol); }
						echo '</td>';}
						echo '<td>'.$row['datetime'].'</td>
					</tr>';
			}
		}
}
/* ===========================================
	SALES FUNCTIONS
   ========================================= */
function sales_table($start_date, $end_date, $affiliate_filter){
	include('auth/db-connect.php');
	$start_date = $start_date.'000000';
	$end_date = $end_date.'235959';
	$start_date = str_replace("-", "", $start_date);
	$end_date = str_replace("-", "", $end_date);
	if(isset($affiliate_filter)){$show = ' AND affiliate_id='.$affiliate_filter.'';}
	$query = "SELECT * FROM ap_earnings WHERE datetime > $start_date AND datetime < $end_date $show ORDER BY datetime DESC";
	$query = $mysqli->real_escape_string($query);
		if($result = $mysqli->query($query)){
			$num_results = mysqli_num_rows($result);
			while($row = $result->fetch_array())
				{
				$affiliate_id = $row['affiliate_id'];
				$get_affiliate = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT * FROM ap_members WHERE id=$affiliate_id"));
				$affiliate_user = $get_affiliate['fullname'];
				//CHECK IF RC ENABLED
				$get_rc_on = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT rc_on FROM ap_other_commissions WHERE id=1"));
				$rc_on = $get_rc_on['rc_on'];
				//MULTI CURRENCY
				$money_format = new \NumberFormatter($locale, \NumberFormatter::CURRENCY); 
				$currency_symbol = $money_format->getSymbol(\NumberFormatter::INTL_CURRENCY_SYMBOL); 
				echo '<tr>
						<td><a href="affiliate-stats?a='.$affiliate_id.'">'; if($affiliate_user!=''){echo $affiliate_user;}else{echo 'No Affiliate';} echo '</a></td>
						<td>'.$row['product'].'</td>
						<td>'; 
							if($row['void']=='1'){ echo '<span class="red">'.$money_format->formatCurrency('0.00', $currency_symbol).' (Refunded)</span>'; } else { echo $money_format->formatCurrency($row['sale_amount'], $currency_symbol); }
						echo '</td>
						<td>'.$row['comission'].'%</td>
						<td>'; 
							if($row['void']=='1'){ echo '<span class="red">'.$money_format->formatCurrency('0.00', $currency_symbol).' (Refunded)</span>'; } else { echo $money_format->formatCurrency($row['net_earnings'], $currency_symbol); }
						echo '</td>';
						if($rc_on=='1'){
							if($row['stop_recurring']=='1'){
									echo '<td><span class="red">Recurring Stopped</span></td>';
								}else {
									if($row['recurring']=='Non-recurring' || $row['recurring']==''){ echo '<td>Non-Recurring</td>';} else { 
										$recurring_fee = $row['recurring_fee'] / 100;
										echo '<td>'.$row['recurring'].' @ '; $mv = $row['sale_amount'] * $recurring_fee; echo $money_format->formatCurrency($mv, $currency_symbol);
										echo ' ('.$row['recurring_fee'].'%)</td>';
									}
								}
						}
						echo '<td>'.$row['datetime'].'</td>
						<td>';
							if($row['void']!='1'){ echo '
							<form method="post" action="data/void-transaction" class="pull-left">
								<input type="hidden" name="m" value="'.$row['id'].'">
								<input type="hidden" name="a" value="'.$row['affiliate_id'].'">
								<input type="hidden" name="r" value="'.pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME).'">
								<input type="submit" class="btn btn-sm btn-inverse" value="Refund">
							</form>';} echo '
							<form method="post" action="data/delete-transaction" class="pull-left">
								<input type="hidden" name="m" value="'.$row['id'].'">
								<input type="hidden" name="a" value="'.$row['affiliate_id'].'">
								<input type="hidden" name="r" value="'.pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME).'">
								<input type="submit" class="btn btn-sm btn-danger" value="Delete">
							</form>
						</td>
					</tr>';
			}
		}
}

function recurring_sales_table($start_date, $end_date, $affiliate_filter){
	include('auth/db-connect.php');
	$start_date = $start_date.'000000';
	$end_date = $end_date.'235959';
	$start_date = str_replace("-", "", $start_date);
	$end_date = str_replace("-", "", $end_date);
	if(isset($affiliate_filter)){$show = ' AND affiliate_id='.$affiliate_filter.'';}
	$query = "SELECT * FROM ap_earnings WHERE datetime > $start_date AND datetime < $end_date $show AND recurring_fee > 0  ORDER BY datetime DESC";
	$query = $mysqli->real_escape_string($query);
		if($result = $mysqli->query($query)){
			$num_results = mysqli_num_rows($result);
			while($row = $result->fetch_array())
				{
				$affiliate_id = $row['affiliate_id'];
				$get_affiliate = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT * FROM ap_members WHERE id=$affiliate_id"));
				$affiliate_user = $get_affiliate['fullname'];
				//CHECK IF RC ENABLED
				$get_rc_on = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT rc_on FROM ap_other_commissions WHERE id=1"));
				$rc_on = $get_rc_on['rc_on'];
				//MULTI CURRENCY
				$money_format = new \NumberFormatter($locale, \NumberFormatter::CURRENCY); 
				$currency_symbol = $money_format->getSymbol(\NumberFormatter::INTL_CURRENCY_SYMBOL); 
				echo '<tr>
						<td><a href="affiliate-stats?a='.$affiliate_id.'">'; if($affiliate_user!=''){echo $affiliate_user;}else{echo 'No Affiliate';} echo '</a></td>
						<td>'.$row['product'].'</td>
						<td>'; 
							if($row['void']=='1'){ echo '<span class="red">-'.$money_format->formatCurrency($row['sale_amount'], $currency_symbol).' (Refunded)</span>'; } else { echo $money_format->formatCurrency($row['net_earnings'], $currency_symbol); }
						echo '</td>';
						if($rc_on=='1'){
							if($row['stop_recurring']=='1'){
								echo '<td><span class="red">Recurring Stopped</span></td>';
							}else {
								if($row['recurring']=='Non-recurring' || $row['recurring']==''){ echo '<td>Non-Recurring</td>';} else { 
									$recurring_fee = $row['recurring_fee'] / 100;
									echo '<td>'.$row['recurring'].' @ '; $mv = $row['sale_amount'] * $recurring_fee; echo $money_format->formatCurrency($mv, $currency_symbol);
									echo ' ('.$row['recurring_fee'].'%)</td>';
								}
							}
						}
						echo '<td>'; if($row['last_reoccurance']=='0000-00-00 00:00:00'){ echo 'Never Reoccured';}else{echo $row['last_reoccurance'];} echo '</td>';
						echo '<td>';
							//MONTHLY RECURRING
							if($row['recurring']=='monthly'){
								if($row['last_reoccurance']=='0000-00-00 00:00:00'){
									echo date('Y-m-d', strtotime($row['datetime'] . ' +1 month'));
								}else{
									echo date('Y-m-d', strtotime($row['last_reoccurance'] . ' +1 month'));	
								}
							}
							//WEEKLY RECURRING
							if($row['recurring']=='weekly'){
								if($row['last_reoccurance']=='0000-00-00 00:00:00'){
									echo date('Y-m-d', strtotime($row['datetime'] . ' +1 week'));
								}else{
									echo date('Y-m-d', strtotime($row['last_reoccurance'] . ' +1 week'));	
								}
							}
							//BIWEEKLY RECURRING
							if($row['recurring']=='biweekly'){
								if($row['last_reoccurance']=='0000-00-00 00:00:00'){
									echo date('Y-m-d', strtotime($row['datetime'] . ' +2 weeks'));
								}else{
									echo date('Y-m-d', strtotime($row['last_reoccurance'] . ' +2 weeks'));	
								}
							}
							//DAILY RECURRING
							if($row['recurring']=='daily'){
								if($row['last_reoccurance']=='0000-00-00 00:00:00'){
									echo date('Y-m-d', strtotime($row['datetime'] . ' +1 day'));
								}else{
									echo date('Y-m-d', strtotime($row['last_reoccurance'] . ' +1 day'));	
								}
							}
						echo '</td>';
						echo '<td>'.$row['datetime'].'</td>
						<td>';
							if($row['stop_recurring']!='1'){ echo '
							<form method="post" action="data/stop-recurring" class="pull-left">
								<input type="hidden" name="m" value="'.$row['id'].'">
								<input type="submit" class="btn btn-sm btn-inverse" value="Stop Recurring">
							</form>';}else{ echo '
							<form method="post" action="data/start-recurring" class="pull-left">
								<input type="hidden" name="m" value="'.$row['id'].'">
								<input type="submit" class="btn btn-sm btn-success" value="Start Recurring">
							</form>';	
							} echo '
							<form method="post" action="data/delete-recurring" class="pull-left">
								<input type="hidden" name="m" value="'.$row['id'].'">
								<input type="hidden" name="a" value="'.$row['affiliate_id'].'">
								<input type="hidden" name="r" value="'.pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME).'">
								<input type="submit" class="btn btn-sm btn-danger" value="Delete">
							</form>
						</td>
					</tr>';
			}
		}
}

function my_recurring_sales_table($start_date, $end_date, $affiliate_filter){
	include('auth/db-connect.php');
	$start_date = $start_date.'000000';
	$end_date = $end_date.'235959';
	$start_date = str_replace("-", "", $start_date);
	$end_date = str_replace("-", "", $end_date);
	if(isset($affiliate_filter)){$show = ' AND affiliate_id='.$affiliate_filter.'';}
	$query = "SELECT * FROM ap_earnings WHERE datetime > $start_date AND datetime < $end_date $show AND recurring_fee > 0  ORDER BY datetime DESC";
	$query = $mysqli->real_escape_string($query);
		if($result = $mysqli->query($query)){
			$num_results = mysqli_num_rows($result);
			while($row = $result->fetch_array())
				{
				//CHECK IF RC ENABLED
				$get_rc_on = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT rc_on FROM ap_other_commissions WHERE id=1"));
				$rc_on = $get_rc_on['rc_on'];
				//MULTI CURRENCY
				$money_format = new \NumberFormatter($locale, \NumberFormatter::CURRENCY); 
				$currency_symbol = $money_format->getSymbol(\NumberFormatter::INTL_CURRENCY_SYMBOL); 
				echo '<tr>
						<td>'.$row['product'].'</td>
						<td>'; 
							if($row['void']=='1'){ echo '<span class="red">-'.$money_format->formatCurrency($row['sale_amount'], $currency_symbol).' (Refunded)</span>'; } else { echo $money_format->formatCurrency($row['sale_amount'], $currency_symbol); }
						echo '</td>';
						if($rc_on=='1'){
							if($row['stop_recurring']=='1'){
								echo '<td><span class="red">Recurring Stopped</span></td>';
							}else {
								if($row['recurring']=='Non-recurring' || $row['recurring']==''){ echo '<td>Non-Recurring</td>';} else { 
									$recurring_fee = $row['recurring_fee'] / 100;
										echo '<td>'.$row['recurring'].' @ '; $mv = $row['sale_amount'] * $recurring_fee; echo $money_format->formatCurrency($mv, $currency_symbol);
									echo ' ('.$row['recurring_fee'].'%)</td>';
								}
							}
						}
						echo '<td>'; if($row['last_reoccurance']=='0000-00-00 00:00:00'){ echo 'Never Reoccured';}else{echo $row['last_reoccurance'];} echo '</td>';
						echo '<td>';
							//MONTHLY RECURRING
							if($row['recurring']=='monthly'){
								if($row['last_reoccurance']=='0000-00-00 00:00:00'){
									echo date('Y-m-d', strtotime($row['datetime'] . ' +1 month'));
								}else{
									echo date('Y-m-d', strtotime($row['last_reoccurance'] . ' +1 month'));	
								}
							}
							//WEEKLY RECURRING
							if($row['recurring']=='weekly'){
								if($row['last_reoccurance']=='0000-00-00 00:00:00'){
									echo date('Y-m-d', strtotime($row['datetime'] . ' +1 week'));
								}else{
									echo date('Y-m-d', strtotime($row['last_reoccurance'] . ' +1 week'));	
								}
							}
							//BIWEEKLY RECURRING
							if($row['recurring']=='biweekly'){
								if($row['last_reoccurance']=='0000-00-00 00:00:00'){
									echo date('Y-m-d', strtotime($row['datetime'] . ' +2 weeks'));
								}else{
									echo date('Y-m-d', strtotime($row['last_reoccurance'] . ' +2 weeks'));	
								}
							}
							//DAILY RECURRING
							if($row['recurring']=='daily'){
								if($row['last_reoccurance']=='0000-00-00 00:00:00'){
									echo date('Y-m-d', strtotime($row['datetime'] . ' +1 day'));
								}else{
									echo date('Y-m-d', strtotime($row['last_reoccurance'] . ' +1 day'));	
								}
							}
						echo '</td>';
						echo '<td>'.$row['datetime'].'</td>
					</tr>';
			}
		}
}

function my_sales_table($start_date, $end_date, $owner){
	include('auth/db-connect.php');
	$start_date = $start_date.'000000';
	$end_date = $end_date.'235959';
	$start_date = str_replace("-", "", $start_date);
	$end_date = str_replace("-", "", $end_date);
	$query = "SELECT * FROM ap_earnings WHERE affiliate_id=$owner AND datetime > $start_date AND datetime < $end_date ORDER BY datetime DESC";
	$query = $mysqli->real_escape_string($query);
		if($result = $mysqli->query($query)){
			$num_results = mysqli_num_rows($result);
			while($row = $result->fetch_array())
				{
				//CHECK IF RC ENABLED
				$get_rc_on = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT rc_on FROM ap_other_commissions WHERE id=1"));
				$rc_on = $get_rc_on['rc_on'];
				//MULTI CURRENCY
				$money_format = new \NumberFormatter($locale, \NumberFormatter::CURRENCY); 
				$currency_symbol = $money_format->getSymbol(\NumberFormatter::INTL_CURRENCY_SYMBOL);
				echo '<tr>
						<td>'.$row['product'].'</td>
						<td>'; 
							if($row['void']=='1'){ echo '<span class="red">-'.$money_format->formatCurrency($row['sale_amount'], $currency_symbol).' (Refunded)</span>'; } else { echo $money_format->formatCurrency($row['sale_amount'], $currency_symbol); }
						echo '</td>
						<td>'.$row['comission'].'%</td>
						<td>'; 
							if($row['void']=='1'){ echo '<span class="red">'.$money_format->formatCurrency('0.00', $currency_symbol).' (Refunded)</span>'; } else { echo $money_format->formatCurrency($row['net_earnings'], $currency_symbol); }
						echo '</td>';
						if($rc_on=='1'){
							if($row['stop_recurring']=='1'){
									echo '<td><span class="red">Recurring Stopped</span></td>';
								}else {
									if($row['recurring']=='Non-recurring' || $row['recurring']==''){ echo '<td>Non-Recurring</td>';} else { 
										$recurring_fee = $row['recurring_fee'] / 100;
										echo '<td>'.$row['recurring'].' @ '; $mv = $row['sale_amount'] * $recurring_fee; echo $money_format->formatCurrency($mv, $currency_symbol);
										echo ' ('.$row['recurring_fee'].'%)</td>';
									}
								}
						}
						echo '<td>'.$row['datetime'].'</td>
					</tr>';
			}
		}
}

function recurring_history_table(){
	include('auth/db-connect.php');
	$query = "SELECT * FROM ap_recurring_history ORDER by id DESC";
	$query = $mysqli->real_escape_string($query);
		if($result = $mysqli->query($query)){
			$num_results = mysqli_num_rows($result);
			while($row = $result->fetch_array())
				{
				$affiliate_id = $row['affiliate_id'];
				$get_affiliate = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT * FROM ap_members WHERE id=$affiliate_id"));
				$affiliate_user = $get_affiliate['fullname'];
				//GET PRODUCT NAME
				$transaction_id = $row['transaction_id'];
				$get_product = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT * FROM ap_earnings WHERE id=$transaction_id"));
				$product = $get_product['product'];
				//MULTI CURRENCY
				$money_format = new \NumberFormatter($locale, \NumberFormatter::CURRENCY); 
				$currency_symbol = $money_format->getSymbol(\NumberFormatter::INTL_CURRENCY_SYMBOL);
				echo '<tr>
						<td>'; if($affiliate_user!=''){echo $affiliate_user;}else{echo 'No Affiliate';} echo '</td>
						<td>'.$product.'</td>
						<td>'.$money_format->formatCurrency($row['recurring_earnings'], $currency_symbol).'</td>
						<td>'.$row['datetime'].'</td>
					</tr>';
			}
		}
}

function recent_sales_table(){
	include('auth/db-connect.php');
	$query = "SELECT * FROM ap_earnings ORDER by datetime DESC LIMIT 0, 15";
	$query = $mysqli->real_escape_string($query);
		if($result = $mysqli->query($query)){
			$num_results = mysqli_num_rows($result);
			while($row = $result->fetch_array())
				{
				$affiliate_id = $row['affiliate_id'];
				$get_affiliate = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT * FROM ap_members WHERE id=$affiliate_id"));
				$affiliate_user = $get_affiliate['fullname'];
				//CHECK IF RC ENABLED
				$get_rc_on = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT rc_on FROM ap_other_commissions WHERE id=1"));
				$rc_on = $get_rc_on['rc_on'];
				//MULTI CURRENCY
				$money_format = new \NumberFormatter($locale, \NumberFormatter::CURRENCY); 
				$currency_symbol = $money_format->getSymbol(\NumberFormatter::INTL_CURRENCY_SYMBOL);
				echo '<tr>
						<td><a href="affiliate-stats?a='.$affiliate_id.'">'; if($affiliate_user!=''){echo $affiliate_user;}else{echo 'No Affiliate';} echo '</a></td>
						<td>'.$row['product'].'</td>
						<td>'; 
							if($row['void']=='1'){ echo '<span class="red">'.$money_format->formatCurrency('0.00', $currency_symbol).' (Refunded)</span>'; } else { echo $money_format->formatCurrency($row['sale_amount'], $currency_symbol); }
						echo '</td>
						<td>'.$row['comission'].'%</td>
						<td>'; 
							if($row['void']=='1'){ echo '<span class="red">'.$money_format->formatCurrency('0.00', $currency_symbol).' (Refunded)</span>'; } else { echo $money_format->formatCurrency($row['net_earnings'], $currency_symbol); }
						echo '</td>';
						if($rc_on=='1'){
							if($row['stop_recurring']=='1'){
									echo '<td><span class="red">Recurring Stopped</span></td>';
								}else {
									if($row['recurring']=='Non-recurring' || $row['recurring']==''){ echo '<td>Non-Recurring</td>';} else { 
										$recurring_fee = $row['recurring_fee'] / 100;
										echo '<td>'.$row['recurring'].' @ '; $mv = $row['sale_amount'] * $recurring_fee; echo $money_format->formatCurrency($mv, $currency_symbol);
										echo ' ('.$row['recurring_fee'].'%)</td>';
									}
								}
						}
						echo '<td>'.$row['datetime'].'</td>
						
					</tr>';
			}
		}
}

function my_recent_sales_table($owner){
	include('auth/db-connect.php');
	$query = "SELECT * FROM ap_earnings WHERE affiliate_id=$owner ORDER by datetime DESC LIMIT 0, 15";
	$query = $mysqli->real_escape_string($query);
		if($result = $mysqli->query($query)){
			$num_results = mysqli_num_rows($result);
			while($row = $result->fetch_array())
				{
				$affiliate_id = $row['affiliate_id'];
				$get_affiliate = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT * FROM ap_members WHERE id=$affiliate_id"));
				$affiliate_user = $get_affiliate['fullname'];
				//CHECK IF RC ENABLED
				$get_rc_on = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT rc_on FROM ap_other_commissions WHERE id=1"));
				$rc_on = $get_rc_on['rc_on'];
				//MULTI CURRENCY
				$money_format = new \NumberFormatter($locale, \NumberFormatter::CURRENCY); 
				$currency_symbol = $money_format->getSymbol(\NumberFormatter::INTL_CURRENCY_SYMBOL);
				echo '<tr>
						<td>'.$row['product'].'</td>
						<td>'; 
							if($row['void']=='1'){ echo '<span class="red">-'.$money_format->formatCurrency($row['sale_amount'], $currency_symbol).' (Refunded)</span>'; } else { echo $money_format->formatCurrency($row['sale_amount'], $currency_symbol); }
						echo '</td>
						<td>'.$row['comission'].'%</td>
						<td>'; 
							if($row['void']=='1'){ echo '<span class="red">-'.$money_format->formatCurrency('0.00', $currency_symbol).' (Refunded)</span>'; } else { echo $money_format->formatCurrency($row['net_earnings'], $currency_symbol); }
						echo '</td>';
						if($rc_on=='1'){
							if($row['stop_recurring']=='1'){
									echo '<td><span class="red">Recurring Stopped</span></td>';
								}else {
									if($row['recurring']=='Non-recurring' || $row['recurring']==''){ echo '<td>Non-Recurring</td>';} else { 
										$recurring_fee = $row['recurring_fee'] / 100;
										echo '<td>'.$row['recurring'].' @ '; $mv = $row['sale_amount'] * $recurring_fee; echo $money_format->formatCurrency($mv, $currency_symbol);
										echo ' ('.$row['recurring_fee'].'%)</td>';
									}
								}
						}
						echo '<td>'.$row['datetime'].'</td>
					</tr>';
			}
		}
}

/* ===========================================
	LEADS FUNCTION 
   ========================================= */
function leads_table(){
	include('auth/db-connect.php');
	$query = "SELECT * FROM ap_leads ORDER BY id DESC";
	$query = $mysqli->real_escape_string($query);
		if($result = $mysqli->query($query)){
			$num_results = mysqli_num_rows($result);
			while($row = $result->fetch_array())
				{
				$affiliate = $row['affiliate_id'];
				$get_affiliate = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT fullname FROM ap_members WHERE id=$affiliate"));
				$affiliate_name = $get_affiliate['fullname'];
				if($affiliate_name==''){$affiliate_name = 'No Referring Affiliate';}
				//MULTI CURRENCY
				$money_format = new \NumberFormatter($locale, \NumberFormatter::CURRENCY); 
				$currency_symbol = $money_format->getSymbol(\NumberFormatter::INTL_CURRENCY_SYMBOL);
				echo '<tr>
						<td><a href="affiliate-stats?a='.$row['affiliate_id'].'">'.$affiliate_name.' - ID: '.$row['affiliate_id'].'</a></td>
						<td>'.$row['fullname'].'</td>
						<td>'.$row['email'].'</td>
						<td>'.$row['phone'].'</td>
						<td>'.$row['message'].'</td>
						<td>'.$money_format->formatCurrency($row['epl'], $currency_symbol).'</td>
						<td>';if($row['converted']=='1'){echo '<span class="green">Converted</span>';}else{echo'<span class="red">Not Converted</span>';} echo '</td>
						<td>'.$row['datetime'].'</td>
						<td>
							<form method="post" action="data/mark-converted" class="pull-left">
								<input type="hidden" name="m" value="'.$row['id'].'">
								<input type="submit" class="btn btn-sm btn-primary" value="Converted">
							</form>
							<form method="post" action="data/delete-lead" class="pull-left">
								<input type="hidden" name="m" value="'.$row['id'].'">
								<input type="submit" class="btn btn-sm btn-danger" value="Delete">
							</form>
						</td>
					</tr>';
			}
		}
}

function my_leads_table($owner){
	include('auth/db-connect.php');
	$query = "SELECT * FROM ap_leads WHERE affiliate_id=$owner ORDER BY id DESC";
	$query = $mysqli->real_escape_string($query);
		if($result = $mysqli->query($query)){
			$num_results = mysqli_num_rows($result);
			while($row = $result->fetch_array())
				{
				//MULTI CURRENCY
				$money_format = new \NumberFormatter($locale, \NumberFormatter::CURRENCY); 
				$currency_symbol = $money_format->getSymbol(\NumberFormatter::INTL_CURRENCY_SYMBOL);
				echo '<tr>
								<td>ID: '.$row['id'].'</td>
								<td>'.$money_format->formatCurrency($row['epl'], $currency_symbol).'</td>
								<td>';if($row['converted']=='1'){echo '<span class="green">Converted</span>';}else{echo'<span class="red">Not Converted</span>';} echo '</td>
								<td>'.$row['datetime'].'</td>
							</tr>';
			}
		}
}
/* ===============================

/* ===========================================
	BANNERS FUNCTIONS
   ========================================= */
function banner_table($owner, $domain_path, $main_url, $admin_user){
	include('auth/db-connect.php');
	$query = "SELECT * FROM ap_banners ORDER BY id DESC";
	$query = $mysqli->real_escape_string($query);
		if($result = $mysqli->query($query)){
			$num_results = mysqli_num_rows($result);
			while($row = $result->fetch_array())
				{
				echo '<tr>
						<td><img src="data/banners/'.$row['filename'].'" class="banners"></td>';
						echo '<td>';
						if($row['adsize']=='1'){ echo 'Mobile - leaderboard (320x50)';}
						if($row['adsize']=='2'){ echo 'Mobile - Large Banner (320x100)';}
						if($row['adsize']=='3'){ echo 'Medium Rectange (300x250)';}
						if($row['adsize']=='4'){ echo 'Rectange (180x150)';}
						if($row['adsize']=='5'){ echo 'Wide Skyscraper (160x600)';}
						if($row['adsize']=='6'){ echo 'Leaderboard (728x90)';}
						echo '</td>';
						echo '<td><textarea class="banner-code"><a href="'.$main_url.'?ref='.$owner.'"><img src="http://'.$domain_path.'/data/banners/'.$row['filename'].'"></a></textarea></td>
						<td>'; if($admin_user=='1'){ echo '
							<form method="post" action="data/delete-file">
								<input type="hidden" name="f" value="'.$row['id'].'">
								<input type="submit" class="btn btn-sm btn-danger" value="Delete">
							</form>';} echo '
						</td>
					</tr>';
			}
		}
}
/* ===========================================
	COMMISSION FUNCTIONS
   ========================================= */
function commission_table($owner, $domain_path, $main_url){
	include('auth/db-connect.php');
	$query = "SELECT * FROM ap_commission_settings ORDER BY sales_from DESC";
	$query = $mysqli->real_escape_string($query);
		if($result = $mysqli->query($query)){
			$num_results = mysqli_num_rows($result);
			while($row = $result->fetch_array())
				{
				//MULTI CURRENCY
				$money_format = new \NumberFormatter($locale, \NumberFormatter::CURRENCY); 
				$currency_symbol = $money_format->getSymbol(\NumberFormatter::INTL_CURRENCY_SYMBOL);
				echo '<tr>
						<td>'.$money_format->formatCurrency($row['sales_from'], $currency_symbol).'</td>
						<td>'.$money_format->formatCurrency($row['sales_to'], $currency_symbol).'</td>
						<td>'.$row['percentage'].'%</td>
						<td>
							<form method="post" action="data/delete-commission-level">
								<input type="hidden" name="m" value="'.$row['id'].'">
								<input type="submit" class="btn btn-sm btn-danger" value="Delete">
							</form>
						</td>
					</tr>';
			}
		}
}

function highest_level(){
	include('auth/db-connect.php');
	$get_max = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT MAX(sales_to) as max FROM ap_commission_settings"));
	$max = $get_max['max'];
	echo $max;
}

function highest_level_plus(){
	include('auth/db-connect.php');
	$get_max = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT MAX(sales_to) as max FROM ap_commission_settings"));
	$max = $get_max['max'] + 1;
	echo $max.'.00';
}

function default_commission(){
	include('auth/db-connect.php');
	$get_dc = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT default_commission FROM ap_settings"));
	$dc = $get_dc['default_commission'];
	echo $dc;
}

function cpc_on(){
	include('auth/db-connect.php');
	$get_cpc = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT cpc_on FROM ap_other_commissions WHERE id=1"));
	$cpc_on = $get_cpc['cpc_on'];
	return $cpc_on;
}

function lc_on(){
	include('auth/db-connect.php');
	$get_lc = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT lc_on FROM ap_other_commissions WHERE id=1"));
	$lc_on = $get_lc['lc_on'];
	return $lc_on;
}

function epc(){
	include('auth/db-connect.php');
	$get_epc = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT epc FROM ap_other_commissions WHERE id=1"));
	$epc = $get_epc['epc'];
	echo $epc;
}

function epl(){
	include('auth/db-connect.php');
	$get_epc = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT epl FROM ap_other_commissions WHERE id=1"));
	$epl = $get_epc['epl'];
	echo $epl;
}

function rc_on(){
	include('auth/db-connect.php');
	$get_rc = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT rc_on FROM ap_other_commissions WHERE id=1"));
	$rc_on = $get_rc['rc_on'];
	return $rc_on;
}

function sv_on(){
	include('auth/db-connect.php');
	$get_sv = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT sv_on FROM ap_other_commissions WHERE id=1"));
	$sv_on = $get_sv['sv_on'];
	return $sv_on;
}

function mt_on(){
	include('auth/db-connect.php');
	$get_mt = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT mt_on FROM ap_other_commissions WHERE id=1"));
	$mt_on = $get_mt['mt_on'];
	return $mt_on;
}
/* ===========================================
	PAYOUT FUNCTIONS
   ========================================= */
function payout_table($start_date, $end_date){
	include('auth/db-connect.php');
	$start_date = $start_date.'000000';
	$end_date = $end_date.'235959';
	$start_date = str_replace("-", "", $start_date);
	$end_date = str_replace("-", "", $end_date);
	$query = "SELECT * FROM ap_payouts WHERE datetime > $start_date AND datetime < $end_date ORDER BY datetime DESC";
	$query = $mysqli->real_escape_string($query);
		if($result = $mysqli->query($query)){
			$num_results = mysqli_num_rows($result);
			while($row = $result->fetch_array())
				{
				$affiliate_id = $row['affiliate_id'];
				$get_affiliate = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT * FROM ap_members WHERE id=$affiliate_id"));
				$affiliate_user = $get_affiliate['fullname'];
				$email = $get_affiliate['email'];
				//MULTI CURRENCY
				$money_format = new \NumberFormatter($locale, \NumberFormatter::CURRENCY); 
				$currency_symbol = $money_format->getSymbol(\NumberFormatter::INTL_CURRENCY_SYMBOL);
				echo '<tr>
						<td>'; if($affiliate_user!=''){echo $affiliate_user;}else{echo 'No Affiliate';} echo '</td>
						<td>';
							if($row['payment_method']=='1'){echo 'PayPal';}
							if($row['payment_method']=='2'){echo 'Stripe';}
							if($row['payment_method']=='3'){echo 'Skrill';}
							if($row['payment_method']=='4'){echo 'Wire Transfer';}
							if($row['payment_method']=='5'){echo 'Check';}
						echo '</td>
						<td>'.$money_format->formatCurrency($row['amount'], $currency_symbol).'</td>
						<td>'.$row['payment_email'].'</td>
						<td>'; 
							if($row['status']=='0'){echo '<span class="red">Payment Pending</span>';}
							if($row['status']=='1'){echo '<span class="green">Paid Request</span>';}
							if($row['status']=='2'){echo '<span class="red">Cancelled</span>';}
						echo '</td>
						<td>'.$row['datetime'].'</td>
						<td>';
							if($row['payment_method']=='2' || $row['payment_method']=='4' || $row['payment_method']=='5'){ echo '
							<form action="payouts-additional" method="get" class="pull-left" target="_blank">
								<input type="hidden" name="p" value="'.$row['id'].'">
								<button type="submit" class="btn btn-sm btn-primary">View Details</button>
							</form>';}
							if($row['status']=='0' && $row['payment_method']=='1'){ echo '
							<form action="https://www.paypal.com/cgi-bin/webscr" method="post" class="pull-left" target="_blank">
								<input type="hidden" name="cmd" value="_xclick">
								<input type="hidden" name="item_number" value="'.$row['id'].'">
								<input type="hidden" name="item_name" value="Affiliate Payment">
								<input type="hidden" name="amount" value="'.$row['amount'].'">
								<input type="hidden" name="business" value="'.$email.'">
								<button type="submit" class="btn btn-sm btn-primary">Redirect to <i class="fa-paypal"></i></button>
							</form>';}
							if($row['status']=='0'){echo '													   
							<form method="post" action="data/mark-paid" class="pull-left">
								<input type="hidden" name="m" value="'.$row['id'].'">
								<input type="submit" class="btn btn-sm btn-success" value="Mark Paid">
							</form>';} echo '				   
							<form method="post" action="data/delete-payout" class="pull-left">
								<input type="hidden" name="m" value="'.$row['id'].'">
								<input type="submit" class="btn btn-sm btn-danger" value="Delete">
							</form>
						</td>
					</tr>';
			}
		}
}

function my_payout_table($start_date, $end_date, $owner){
	include('auth/db-connect.php');
	$start_date = $start_date.'000000';
	$end_date = $end_date.'235959';
	$start_date = str_replace("-", "", $start_date);
	$end_date = str_replace("-", "", $end_date);
	$query = "SELECT * FROM ap_payouts WHERE affiliate_id=$owner AND datetime > $start_date AND datetime < $end_date ORDER BY datetime DESC";
	$query = $mysqli->real_escape_string($query);
		if($result = $mysqli->query($query)){
			$num_results = mysqli_num_rows($result);
			while($row = $result->fetch_array())
				{
				$affiliate_id = $row['affiliate_id'];
				$get_affiliate = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT * FROM ap_members WHERE id=$affiliate_id"));
				$affiliate_user = $get_affiliate['fullname'];
				$email = $get_affiliate['email'];
				//MULTI CURRENCY
				$money_format = new \NumberFormatter($locale, \NumberFormatter::CURRENCY); 
				$currency_symbol = $money_format->getSymbol(\NumberFormatter::INTL_CURRENCY_SYMBOL);
				echo '<tr>
						<td>'.$money_format->formatCurrency($row['sales_to'], $currency_symbol).'</td>
						<td>';
							if($row['payment_method']=='1'){echo 'PayPal';}
							if($row['payment_method']=='2'){echo 'Stripe';}
							if($row['payment_method']=='3'){echo 'Skrill';}
							if($row['payment_method']=='4'){echo 'Wire Transfer';}
							if($row['payment_method']=='5'){echo 'Check';}
						echo '</td>
						<td>'.$row['payment_email'].'</td>
						<td>'; 
							if($row['status']=='0'){echo '<span class="red">Payment Pending</span>';}
							if($row['status']=='1'){echo '<span class="green">Paid Request</span>';}
							if($row['status']=='2'){echo '<span class="red">Cancelled</span>';}
						echo '</td>
						<td>'.$row['datetime'].'</td>
						<td>';if($row['status']=='0'){ echo '
							<form method="post" action="data/cancel-payout" class="pull-left">
								<input type="hidden" name="m" value="'.$row['id'].'">
								<input type="submit" class="btn btn-sm btn-danger" value="Cancel Request">
							</form>';} echo '
						</td>
					</tr>';
			}
		}
}

function available_payment(){
	include('auth/db-connect.php');
	$query = "SELECT * FROM ap_settings WHERE id=1";
	$query = $mysqli->real_escape_string($query);
		if($result = $mysqli->query($query)){
			$num_results = mysqli_num_rows($result);
			while($row = $result->fetch_array())
				{
				if($row['paypal']=='1'){echo '<option value="1">PayPal</option>';}
				if($row['stripe']=='1'){echo '<option value="2">Stripe</option>';}
				if($row['skrill']=='1'){echo '<option value="3">Skrill</option>';}
				if($row['wire']=='1'){echo '<option value="4">Wire Transfer</option>';}
				if($row['checks']=='1'){echo '<option value="5">Check</option>';}
			}
		}
}

function payouts_additional($payout_id){
	include('auth/db-connect.php');
	$query = "SELECT * FROM ap_payouts WHERE id=$payout_id";
	$query = $mysqli->real_escape_string($query);
		if($result = $mysqli->query($query)){
			$num_results = mysqli_num_rows($result);
			while($row = $result->fetch_array())
				{
				$affiliate_id = $row['affiliate_id'];
				$get_affiliate = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT * FROM ap_members WHERE id=$affiliate_id"));
				$affiliate_user = $get_affiliate['fullname'];
				
				if($row['payment_method']=='2' || $row['payment_method']=='4'){
				echo '<li>Full Name: '.$affiliate_user.'</li>
				<li>Bank Name: '.$row['bn'].'</li>
				<li>Routing #'.$row['rn'].'</li>
				<li>Account #'.$row['an'].'</li>';}
				if($row['payment_method']=='5'){
				echo '<li>Full Name: '.$affiliate_user.'</li>
				<li>Street: '.$row['street'].'</li>
				<li>City: '.$row['city'].'</li>
				<li>Zip: '.$row['zip'].'</li>';}
			}
		}
}
/* ===========================================
	MULTI-TIERS FUNCTION 
   ========================================= */
function tier_levels(){
	include('auth/db-connect.php');
	$get_tiers = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT * FROM ap_other_commissions"));
	$tier2 = $get_tiers['tier2']; $tier3 = $get_tiers['tier3']; $tier4 = $get_tiers['tier4']; 
	$tier5 = $get_tiers['tier5']; $tier6 = $get_tiers['tier6']; $tier7 = $get_tiers['tier7'];
	$tier8 = $get_tiers['tier8']; $tier9 = $get_tiers['tier9']; $tier10 = $get_tiers['tier10'];
	echo '
		<li>Level 2 (Affiliate\'s Sponsor) = <input type="text" name="tier2" size="2" value="'.$tier2.'">%</li>
		<li>Level 3 (Level 2\'s Sponsor) = <input type="text" name="tier3" size="2" value="'.$tier3.'">%</li>
		<li>Level 4 (Level 3\'s Sponsor) = <input type="text" name="tier4" size="2" value="'.$tier4.'">%</li>
		<li>Level 5 (Level 4\'s Sponsor) = <input type="text" name="tier5" size="2" value="'.$tier5.'">%</li>
		<li>Level 6 (Level 5\'s Sponsor) = <input type="text" name="tier6" size="2" value="'.$tier6.'">%</li>
		<li>Level 7 (Level 6\'s Sponsor) = <input type="text" name="tier7" size="2" value="'.$tier7.'">%</li>
		<li>Level 8 (Level 7\'s Sponsor) = <input type="text" name="tier8" size="2" value="'.$tier8.'">%</li>
		<li>Level 9 (Level 8\'s Sponsor) = <input type="text" name="tier9" size="2" value="'.$tier9.'">%</li>
		<li>Level 10 (Level 9\'s Sponsor) = <input type="text" name="tier10" size="2" value="'.$tier10.'">%</li>';
}

function mt_table($start_date, $end_date){
	include('auth/db-connect.php');
	$start_date = $start_date.'000000';
	$end_date = $end_date.'235959';
	$start_date = str_replace("-", "", $start_date);
	$end_date = str_replace("-", "", $end_date);
	$query = "SELECT transaction_id, datetime, COUNT(*) as total_levels FROM ap_multi_tier_transactions WHERE datetime > $start_date AND datetime < $end_date GROUP BY transaction_id ORDER BY datetime DESC";
	$query = $mysqli->real_escape_string($query);
		if($result = $mysqli->query($query)){
			$num_results = mysqli_num_rows($result);
			while($row = $result->fetch_array())
				{
				//GET PRODUCT NAME
				$transaction_id = $row['transaction_id'];
				$get_product = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT * FROM ap_earnings WHERE id=$transaction_id"));
				$product = $get_product['product'];
				echo '<tr>
						<td>MT-'.$row['transaction_id'].'</td>
						<td>'.$product.'</td>
						<td>'.$row['total_levels'].' Payments <a href="view-mt-payments?tid='.$row['transaction_id'].'" class="btn btn-xs btn-default">View Transactions</a> </td>
						<td>'.$row['datetime'].'</td>													   	
					</tr>';
			}
		}
}

function mt_payments_table($transaction_id){
	include('auth/db-connect.php');
	
	$query = "SELECT * FROM ap_multi_tier_transactions WHERE transaction_id=$transaction_id ORDER BY id ASC";
	$query = $mysqli->real_escape_string($query);
		if($result = $mysqli->query($query)){
			$num_results = mysqli_num_rows($result);
			while($row = $result->fetch_array())
				{
				$affiliate_id = $row['affiliate_id'];
				$get_affiliate = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT * FROM ap_members WHERE id=$affiliate_id"));
				$affiliate_user = $get_affiliate['fullname'];
				//MULTI CURRENCY
				$money_format = new \NumberFormatter($locale, \NumberFormatter::CURRENCY); 
				$currency_symbol = $money_format->getSymbol(\NumberFormatter::INTL_CURRENCY_SYMBOL);
				echo '<tr>
						<td>'; if($affiliate_user!=''){echo $affiliate_user;}else{echo 'No Affiliate';} echo '</td>
						<td>Level '.$row['tier'].'</td>
						<td>'.$row['commission'].'%</td>
						<td>'; if($row['reversed']=='1'){echo '<span class="red">-'.$money_format->formatCurrency($row['mt_earnings'], $currency_symbol).' (Reversed)';}else{echo $money_format->formatCurrency($row['mt_earnings'], $currency_symbol);} echo '</td>
						<td>'.$row['datetime'].'</td>													   	
						<td>';
							if($row['reversed']!='1'){ echo '
							<form method="post" action="data/reverse-mt-transaction" class="pull-left">
								<input type="hidden" name="i" value="'.$row['id'].'">
								<input type="hidden" name="a" value="'.$row['affiliate_id'].'">
								<input type="hidden" name="t" value="'.$row['transaction_id'].'">
								<input type="submit" class="btn btn-sm btn-inverse" value="Reverse Transaction">
							</form>';} echo '
							<form method="post" action="data/delete-mt" class="pull-left">
								<input type="hidden" name="i" value="'.$row['id'].'">
								<input type="hidden" name="t" value="'.$row['transaction_id'].'">
								<input type="submit" class="btn btn-sm btn-danger" value="Delete">
							</form>
							</td>
					</tr>';
			}
		}
}

function my_mt_payments_table($owner){
	include('auth/db-connect.php');
	
	$query = "SELECT * FROM ap_multi_tier_transactions WHERE affiliate_id=$owner ORDER BY id ASC";
	$query = $mysqli->real_escape_string($query);
		if($result = $mysqli->query($query)){
			$num_results = mysqli_num_rows($result);
			while($row = $result->fetch_array())
				{
				//GET PRODUCT NAME
				$transaction_id = $row['transaction_id'];
				$get_product = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT * FROM ap_earnings WHERE id=$transaction_id"));
				$product = $get_product['product'];
				//MULTI CURRENCY
				$money_format = new \NumberFormatter($locale, \NumberFormatter::CURRENCY); 
				$currency_symbol = $money_format->getSymbol(\NumberFormatter::INTL_CURRENCY_SYMBOL);
				echo '<tr>
						<td>'.$product.'</td>
						<td>Level '.$row['tier'].'</td>
						<td>'.$row['commission'].'%</td>
						<td>'; if($row['reversed']=='1'){echo '<span class="red">-$'.$money_format->formatCurrency($row['mt_earnings'], $currency_symbol).' (Reversed)';}else{echo $money_format->formatCurrency($row['mt_earnings'], $currency_symbol);} echo '</td>
						<td>'.$row['datetime'].'</td>													   	
					</tr>';
			}
		}
}
/* ===========================================
	TOTALS FUNCTION 
   ========================================= */

function total_leads(){
	include('auth/db-connect.php');
	$sql = "SELECT * FROM ap_leads";
	$result = $mysqli->query($sql);
	$num_affiliates = $result->num_rows;
	if($num_affiliates==''){$num_affiliates='0';}
	echo $num_affiliates;
}

function total_lead_conversions(){
	include('auth/db-connect.php');
	$sql = "SELECT * FROM ap_leads WHERE converted=1";
	$result = $mysqli->query($sql);
	$num_affiliates = $result->num_rows;
	if($num_affiliates==''){$num_affiliates='0';}
	echo $num_affiliates;
}

function total_leads_i($owner){
	include('auth/db-connect.php');
	$sql = "SELECT * FROM ap_leads WHERE affiliate_id=$owner";
	$result = $mysqli->query($sql);
	$num_affiliates = $result->num_rows;
	if($num_affiliates==''){$num_affiliates='0';}
	echo $num_affiliates;
}

function total_lead_conversions_i($owner){
	include('auth/db-connect.php');
	$sql = "SELECT * FROM ap_leads WHERE affiliate_id=$owner AND converted=1";
	$result = $mysqli->query($sql);
	$num_affiliates = $result->num_rows;
	if($num_affiliates==''){$num_affiliates='0';}
	echo $num_affiliates;
}

function total_affiliate_lead_earnings(){
	include('auth/db-connect.php');
	$get_tb = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT SUM(epl) as total_balance FROM ap_leads"));
	$tb = $get_tb['total_balance'];
	if($tb==''){$tb='0.00';}
	$money_format = new \NumberFormatter($locale, \NumberFormatter::CURRENCY); 
  $currency_symbol = $money_format->getSymbol(\NumberFormatter::INTL_CURRENCY_SYMBOL); 
	echo $money_format->formatCurrency($tb,  $currency_symbol); 
}

function total_affiliate_lead_earnings_i($owner){
	include('auth/db-connect.php');
	$get_tb = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT SUM(epl) as total_balance FROM ap_leads WHERE affiliate_id=$owner"));
	$tb = $get_tb['total_balance'];
	if($tb==''){$tb='0.00';}
	$money_format = new \NumberFormatter($locale, \NumberFormatter::CURRENCY); 
  $currency_symbol = $money_format->getSymbol(\NumberFormatter::INTL_CURRENCY_SYMBOL); 
	echo $money_format->formatCurrency($tb,  $currency_symbol); 
}

function total_affiliates(){
	include('auth/db-connect.php');
	$sql = "SELECT * FROM ap_members WHERE admin_user!=1";
	$result = $mysqli->query($sql);
	$num_affiliates = $result->num_rows;
	echo $num_affiliates;
}

function total_balance(){
	include('auth/db-connect.php');
	$get_tb = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT SUM(balance) as total_balance FROM ap_members WHERE admin_user!=1"));
	$tb = $get_tb['total_balance'];
	if($tb==''){$tb='0.00';}
	$money_format = new \NumberFormatter($locale, \NumberFormatter::CURRENCY); 
  $currency_symbol = $money_format->getSymbol(\NumberFormatter::INTL_CURRENCY_SYMBOL); 
	echo $money_format->formatCurrency($tb,  $currency_symbol); 
}

function total_sales(){
	include('auth/db-connect.php');
	$get_tb = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT SUM(sale_amount) as total_sales FROM ap_earnings WHERE void!=1"));
	$tb = $get_tb['total_sales'];
	if($tb==''){$tb='0.00';}
	$money_format = new \NumberFormatter($locale, \NumberFormatter::CURRENCY); 
  $currency_symbol = $money_format->getSymbol(\NumberFormatter::INTL_CURRENCY_SYMBOL); 
	echo $money_format->formatCurrency($tb,  $currency_symbol); 
}

function my_total_sales($owner){
	include('auth/db-connect.php');
	$get_tb = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT SUM(sale_amount) as total_sales FROM ap_earnings WHERE affiliate_id=$owner AND void!=1"));
	$tb = $get_tb['total_sales'];
	if($tb==''){$tb='0.00';}
	$money_format = new \NumberFormatter($locale, \NumberFormatter::CURRENCY); 
  $currency_symbol = $money_format->getSymbol(\NumberFormatter::INTL_CURRENCY_SYMBOL); 
	echo $money_format->formatCurrency($tb,  $currency_symbol); 
}

function count_sales(){
	include('auth/db-connect.php');
	$get_tb = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT COUNT(id) as total_sales FROM ap_earnings WHERE void!=1"));
	$tb = $get_tb['total_sales'];
	if($tb==''){$tb='0';}
	echo $tb;
}

function my_count_sales($owner){
	include('auth/db-connect.php');
	$get_tb = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT COUNT(id) as total_sales FROM ap_earnings WHERE affiliate_id=$owner AND void!=1"));
	$tb = $get_tb['total_sales'];
	if($tb==''){$tb='0';}
	echo $tb;
}

function total_sales_period($start_date, $end_date, $affiliate_filter){
	include('auth/db-connect.php');
	$start_date = $start_date.'000000';
	$end_date = $end_date.'235959';
	$start_date = str_replace("-", "", $start_date);
	$end_date = str_replace("-", "", $end_date);
	if(isset($affiliate_filter)){$show = ' AND affiliate_id='.$affiliate_filter.'';}
	$get_tb = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT SUM(sale_amount) as total_sales FROM ap_earnings WHERE void!=1 AND datetime > $start_date AND datetime < $end_date $show"));
	$tb = $get_tb['total_sales'];
	if($tb==''){$tb='0.00';}
	$money_format = new \NumberFormatter($locale, \NumberFormatter::CURRENCY); 
  $currency_symbol = $money_format->getSymbol(\NumberFormatter::INTL_CURRENCY_SYMBOL); 
	echo $money_format->formatCurrency($tb,  $currency_symbol); 
}

function total_sales_period_i($start_date, $end_date, $owner){
	include('auth/db-connect.php');
	$start_date = $start_date.'000000';
	$end_date = $end_date.'235959';
	$start_date = str_replace("-", "", $start_date);
	$end_date = str_replace("-", "", $end_date);
	$get_tb = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT SUM(sale_amount) as total_sales FROM ap_earnings WHERE affiliate_id=$owner AND void!=1 AND datetime > $start_date AND datetime < $end_date $show"));
	$tb = $get_tb['total_sales'];
	if($tb==''){$tb='0.00';}
	$money_format = new \NumberFormatter($locale, \NumberFormatter::CURRENCY); 
  $currency_symbol = $money_format->getSymbol(\NumberFormatter::INTL_CURRENCY_SYMBOL); 
	echo $money_format->formatCurrency($tb,  $currency_symbol); 
}

function affiliate_earnings(){
	include('auth/db-connect.php');
	$get_tb = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT SUM(net_earnings) as affiliate_earnings FROM ap_earnings WHERE void!=1"));
	$ae = $get_tb['affiliate_earnings'];
	$get_tb = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT SUM(recurring_earnings) as recurring_earnings FROM ap_recurring_history"));
	$re = $get_tb['recurring_earnings'];
	$get_tb = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT SUM(epl) as lead_earnings FROM ap_leads"));
	$le = $get_tb['lead_earnings'];
	$tb = $ae + $re + $le;
	if($tb==''){$tb='0.00';}
	$money_format = new \NumberFormatter($locale, \NumberFormatter::CURRENCY); 
  $currency_symbol = $money_format->getSymbol(\NumberFormatter::INTL_CURRENCY_SYMBOL); 
	echo $money_format->formatCurrency($tb,  $currency_symbol); 
}

function affiliate_earnings_period($start_date, $end_date, $affiliate_filter){
	include('auth/db-connect.php');
	$start_date = $start_date.'000000';
	$end_date = $end_date.'235959';
	$start_date = str_replace("-", "", $start_date);
	$end_date = str_replace("-", "", $end_date);
	if(isset($affiliate_filter)){$show = ' AND affiliate_id='.$affiliate_filter.'';}
	$get_tb = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT SUM(net_earnings) as affiliate_earnings FROM ap_earnings WHERE void!=1 AND datetime > $start_date AND datetime < $end_date $show"));
	$ae = $get_tb['affiliate_earnings'];
	$get_tb = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT SUM(recurring_earnings) as recurring_earnings FROM ap_recurring_history WHERE datetime > $start_date AND datetime < $end_date $show"));
	$re = $get_tb['recurring_earnings'];
	$tb = $ae + $re;
	if($tb==''){$tb='0.00';}
	$money_format = new \NumberFormatter($locale, \NumberFormatter::CURRENCY); 
  $currency_symbol = $money_format->getSymbol(\NumberFormatter::INTL_CURRENCY_SYMBOL); 
	echo $money_format->formatCurrency($tb,  $currency_symbol); 
}

function affiliate_earnings_period_i($start_date, $end_date, $owner){
	include('auth/db-connect.php');
	$start_date = $start_date.'000000';
	$end_date = $end_date.'235959';
	$start_date = str_replace("-", "", $start_date);
	$end_date = str_replace("-", "", $end_date);
	$get_tb = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT SUM(net_earnings) as affiliate_earnings FROM ap_earnings WHERE affiliate_id=$owner AND void!=1 AND datetime > $start_date AND datetime < $end_date $show"));
	$tb = $get_tb['affiliate_earnings'];
	if($tb==''){$tb='0.00';}
	$money_format = new \NumberFormatter($locale, \NumberFormatter::CURRENCY); 
  $currency_symbol = $money_format->getSymbol(\NumberFormatter::INTL_CURRENCY_SYMBOL); 
	echo $money_format->formatCurrency($tb,  $currency_symbol); 
}

function total_recurring(){
	include('auth/db-connect.php');
	$get_tr = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT COUNT(id) as total_recurring FROM ap_earnings WHERE stop_recurring=0 AND recurring_fee > 0"));
	$tr = $get_tr['total_recurring'];
	if($tr==''){$tr='0';}
	echo $tr;
}

function total_recurring_i($owner){
	include('auth/db-connect.php');
	$get_tr = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT COUNT(id) as total_recurring FROM ap_earnings WHERE affiliate_id=$owner AND stop_recurring=0 AND recurring_fee > 0"));
	$tr = $get_tr['total_recurring'];
	if($tr==''){$tr='0';}
	echo $tr;
}

function total_recurring_sales_period($start_date, $end_date){
	include('auth/db-connect.php');
	$start_date = $start_date.'000000';
	$end_date = $end_date.'235959';
	$start_date = str_replace("-", "", $start_date);
	$end_date = str_replace("-", "", $end_date);
	$get_tb = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT SUM(sale_amount) as sales FROM ap_earnings WHERE stop_recurring=0 AND recurring_fee > 0 AND void!=1 AND datetime > $start_date AND datetime < $end_date $show"));
	$tb = $get_tb['sales'];
	if($tb==''){$tb='0.00';}
	$money_format = new \NumberFormatter($locale, \NumberFormatter::CURRENCY); 
  $currency_symbol = $money_format->getSymbol(\NumberFormatter::INTL_CURRENCY_SYMBOL); 
	echo $money_format->formatCurrency($tb,  $currency_symbol); 
}

function total_recurring_sales_period_i($start_date, $end_date, $owner){
	include('auth/db-connect.php');
	$start_date = $start_date.'000000';
	$end_date = $end_date.'235959';
	$start_date = str_replace("-", "", $start_date);
	$end_date = str_replace("-", "", $end_date);
	$get_tb = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT SUM(sale_amount) as sales FROM ap_earnings WHERE affiliate_id=$owner AND stop_recurring=0 AND recurring_fee > 0 AND void!=1 AND datetime > $start_date AND datetime < $end_date $show"));
	$tb = $get_tb['sales'];
	if($tb==''){$tb='0.00';}
	$money_format = new \NumberFormatter($locale, \NumberFormatter::CURRENCY); 
  $currency_symbol = $money_format->getSymbol(\NumberFormatter::INTL_CURRENCY_SYMBOL); 
	echo $money_format->formatCurrency($tb,  $currency_symbol); 
}

function total_referrals(){
	include('auth/db-connect.php');
	$get_tr = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT COUNT(id) as total_referrals FROM ap_referral_traffic"));
	$tr = $get_tr['total_referrals'];
	if($tr==''){$tr='0';}
	echo $tr;
}

function my_total_referrals($owner){
	include('auth/db-connect.php');
	$get_tr = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT COUNT(id) as total_referrals FROM ap_referral_traffic WHERE affiliate_id=$owner"));
	$tr = $get_tr['total_referrals'];
	if($tr==''){$tr='0';}
	echo $tr;
}

function total_cpc_earnings($owner){
	include('auth/db-connect.php');
	$get_tr = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT SUM(cpc_earnings) as total_cpc FROM ap_referral_traffic WHERE void=0"));
	$tr = $get_tr['total_cpc'];
	if($tr==''){$tr='0.00';}
  $money_format = new \NumberFormatter($locale, \NumberFormatter::CURRENCY); 
  $currency_symbol = $money_format->getSymbol(\NumberFormatter::INTL_CURRENCY_SYMBOL); 
	echo $money_format->formatCurrency($tb,  $currency_symbol); 
}

function my_total_cpc_earnings($owner){
	include('auth/db-connect.php');
	$get_tr = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT SUM(cpc_earnings) as total_cpc FROM ap_referral_traffic WHERE affiliate_id=$owner AND void=0"));
	$tr = $get_tr['total_cpc'];
	if($tr==''){$tr='0.00';}
	$money_format = new \NumberFormatter($locale, \NumberFormatter::CURRENCY); 
  $currency_symbol = $money_format->getSymbol(\NumberFormatter::INTL_CURRENCY_SYMBOL); 
	echo $money_format->formatCurrency($tb,  $currency_symbol); 
}

function total_referrals_period($start_date, $end_date, $affiliate_filter){
	include('auth/db-connect.php');
	$start_date = $start_date.'000000';
	$end_date = $end_date.'235959';
	$start_date = str_replace("-", "", $start_date);
	$end_date = str_replace("-", "", $end_date);
	if(isset($affiliate_filter)){$show = ' AND affiliate_id='.$affiliate_filter.'';}
	$get_tr = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT COUNT(id) as total_referrals FROM ap_referral_traffic WHERE datetime > $start_date AND datetime < $end_date $show"));
	$tr = $get_tr['total_referrals'];
	if($tr==''){$tr='0';}
	echo $tr;
}

function total_referrals_period_i($start_date, $end_date, $owner){
	include('auth/db-connect.php');
	$start_date = $start_date.'000000';
	$end_date = $end_date.'235959';
	$start_date = str_replace("-", "", $start_date);
	$end_date = str_replace("-", "", $end_date);
	$get_tr = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT COUNT(id) as total_referrals FROM ap_referral_traffic WHERE affiliate_id=$owner AND datetime > $start_date AND datetime < $end_date"));
	$tr = $get_tr['total_referrals'];
	if($tr==''){$tr='0';}
	echo $tr;
}

function active_affiliates_period($start_date, $end_date){
	include('auth/db-connect.php');
	$start_date = $start_date.'000000';
	$end_date = $end_date.'235959';
	$start_date = str_replace("-", "", $start_date);
	$end_date = str_replace("-", "", $end_date);
	$get_tr = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT COUNT(DISTINCT(affiliate_id)) as active_affiliates FROM ap_referral_traffic WHERE datetime > $start_date AND datetime < $end_date"));
	$tr = $get_tr['active_affiliates'];
	if($tr==''){$tr='0';}
	echo $tr;
}

function total_pending_period($start_date, $end_date){
	include('auth/db-connect.php');
	$start_date = $start_date.'000000';
	$end_date = $end_date.'235959';
	$start_date = str_replace("-", "", $start_date);
	$end_date = str_replace("-", "", $end_date);
	$get_tb = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT SUM(amount) as pending_payments FROM ap_payouts WHERE status!=1 AND datetime > $start_date AND datetime < $end_date"));
	$tb = $get_tb['pending_payments'];
	if($tb==''){$tb='0.00';}
	$money_format = new \NumberFormatter($locale, \NumberFormatter::CURRENCY); 
  $currency_symbol = $money_format->getSymbol(\NumberFormatter::INTL_CURRENCY_SYMBOL); 
	echo $money_format->formatCurrency($tb,  $currency_symbol); 
}

function total_paid_period($start_date, $end_date){
	include('auth/db-connect.php');
	$start_date = $start_date.'000000';
	$end_date = $end_date.'235959';
	$start_date = str_replace("-", "", $start_date);
	$end_date = str_replace("-", "", $end_date);
	$get_tb = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT SUM(amount) as pending_payments FROM ap_payouts WHERE status=1 AND datetime > $start_date AND datetime < $end_date"));
	$tb = $get_tb['pending_payments'];
	if($tb==''){$tb='0.00';}
	$money_format = new \NumberFormatter($locale, \NumberFormatter::CURRENCY); 
  $currency_symbol = $money_format->getSymbol(\NumberFormatter::INTL_CURRENCY_SYMBOL); 
	echo $money_format->formatCurrency($tb,  $currency_symbol); 
}

function my_conversion_period_i($start_date, $end_date, $owner){
	include('auth/db-connect.php');
	$start_date = $start_date.'000000';
	$end_date = $end_date.'235959';
	$start_date = str_replace("-", "", $start_date);
	$end_date = str_replace("-", "", $end_date);
	//COUNT SALES
	$get_tb = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT COUNT(id) as sales FROM ap_earnings WHERE void!=1 AND affiliate_id=$owner AND datetime > $start_date AND datetime < $end_date"));
	$sales = $get_tb['sales'];
	//COUNT REFERRALS
	$get_tb = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT COUNT(id) as referrals FROM ap_referral_traffic WHERE affiliate_id=$owner AND datetime > $start_date AND datetime < $end_date"));
	$referrals = $get_tb['referrals'];
	$rate = $sales / $referrals * 100;
	echo number_format((float)$rate, 2, '.', '').'%';
}

function total_mt_transactions(){
	include('auth/db-connect.php');
	$get_tb = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT COUNT(id) as total_mt FROM ap_multi_tier_transactions WHERE reversed!=1"));
	$tb = $get_tb['total_mt'];
	if($tb==''){$tb='0';}
	echo $tb;
}

function total_mt_payments_period($start_date, $end_date){
	include('auth/db-connect.php');
	$start_date = $start_date.'000000';
	$end_date = $end_date.'235959';
	$start_date = str_replace("-", "", $start_date);
	$end_date = str_replace("-", "", $end_date);
	$get_tb = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT SUM(mt_earnings) as total_mt FROM ap_multi_tier_transactions WHERE reversed!=1 AND datetime > $start_date AND datetime < $end_date"));
	$tb = $get_tb['total_mt'];
	if($tb==''){$tb='0.00';}
	$money_format = new \NumberFormatter($locale, \NumberFormatter::CURRENCY); 
  $currency_symbol = $money_format->getSymbol(\NumberFormatter::INTL_CURRENCY_SYMBOL); 
	echo $money_format->formatCurrency($tb,  $currency_symbol); 
}

function total_mt_transactions_i($owner){
	include('auth/db-connect.php');
	$get_tb = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT COUNT(id) as total_mt FROM ap_multi_tier_transactions WHERE affiliate_id=$owner AND reversed!=1"));
	$tb = $get_tb['total_mt'];
	if($tb==''){$tb='0';}
	echo $tb;
}

function total_mt_payments_period_i($start_date, $end_date, $owner){
	include('auth/db-connect.php');
	$start_date = $start_date.'000000';
	$end_date = $end_date.'235959';
	$start_date = str_replace("-", "", $start_date);
	$end_date = str_replace("-", "", $end_date);
	$get_tb = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT SUM(mt_earnings) as total_mt FROM ap_multi_tier_transactions WHERE affiliate_id=$owner AND reversed!=1 AND datetime > $start_date AND datetime < $end_date"));
	$tb = $get_tb['total_mt'];
	if($tb==''){$tb='0.00';}
	$money_format = new \NumberFormatter($locale, \NumberFormatter::CURRENCY); 
  $currency_symbol = $money_format->getSymbol(\NumberFormatter::INTL_CURRENCY_SYMBOL); 
	echo $money_format->formatCurrency($tb,  $currency_symbol); 
}
	
/* ===========================================
	USER MANAGEMENT FUNCTION 
   ========================================= */
function user_table($used_space){
	include('auth/db-connect.php');
	include('lang/'.$_SESSION['language'].'.php');
	$query = "SELECT * FROM ap_members ORDER BY fullname ASC";
	$query = $mysqli->real_escape_string($query);
		if($result = $mysqli->query($query)){
			$num_results = mysqli_num_rows($result);
			while($row = $result->fetch_array())
				{
				$member = $row['id'];
				$terms = $row['terms'];
				$a = $row['admin_user'];
				echo '<tr>
						<td><span id="fullname:'.$row['id'].'" contenteditable="true" class="editable">'.$row['fullname'].'</span></td>
						<td><span id="username:'.$row['id'].'" contenteditable="true" class="editable">'.$row['username'].'</span></td>
						<td><span id="email:'.$row['id'].'" contenteditable="true" class="editable">'.$row['email'].'</span></td>
						<td>'; if($terms=='1'){echo 'Yes';} echo '</td>
						<td>
							<form method="post" action="data/change-user-level">
								<input type="hidden" name="m" value="'.$row['id'].'">
								<select name="l" onchange="this.form.submit()">
									<option value="0" ';if($a=='0'){echo 'selected';} echo '>Affiliate</option>
									<option value="1" ';if($a=='1'){echo 'selected';} echo '>Admin User</option>
								</select>
							</form>
						</td>
						<td>
							<form method="post" action="data/delete-user">
								<input type="hidden" name="m" value="'.$row['id'].'">
								<input type="submit" class="btn btn-sm btn-danger" value="'.$lang['DELETE'].'">
							</form>
						</td>
					</tr>';
			}
		}
}


/* ===========================================
	SETTINGS FUNCTIONS	 
   ========================================= */
function all_settings(){
	include('auth/db-connect.php');
	$get_settings = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT meta_title, meta_description, site_title, site_email FROM ap_settings"));
	$meta_title = $get_settings['meta_title'];
	$meta_description = $get_settings['meta_description'];
	$site_title = $get_settings['site_title'];
	$site_email = $get_settings['site_email'];
	$default_commission = $get_settings['default_commission'];
	return array($meta_title, $meta_description, $site_title, $site_email, $ar);
}

function settings_form(){
	include('auth/db-connect.php');
	$get_settings = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT * FROM ap_settings"));
	$rs_meta_title = $get_settings['meta_title'];
	$rs_meta_description = $get_settings['meta_description'];
	$rs_site_title = $get_settings['site_title'];
	$rs_site_email = $get_settings['site_email'];
	$default_commission = $get_settings['default_commission'];
	$min_payout = $get_settings['min_payout'];
	$currency = $get_settings['currency_fmt'];
	$paypal = $get_settings['paypal'];
	$stripe = $get_settings['stripe'];
	$skrill = $get_settings['skrill'];
	$wire = $get_settings['wire'];
	$checks = $get_settings['checks'];
	echo '<fieldset>
	<hr><h3>Basic Settings</h3><hr>
	<div class="control-group">
		<label class="control-label" for="">Meta Title</label>
		<div class="controls">
		<input id="" name="mt" type="text" placeholder="" class="input-xlarge" value="'.$rs_meta_title.'">
	</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="">Meta Description</label>
		<div class="controls">
		<input id="" name="md" type="text" placeholder="" class="input-xlarge" value="'.$rs_meta_description.'">
	</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="">Site Title</label>
		<div class="controls">
		<input id="" name="st" type="text" placeholder="" class="input-xlarge" value="'.$rs_site_title.'">
	</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="">Site Email</label>
		<div class="controls">
		<input id="" name="se" type="text" placeholder="" class="input-xlarge" value="'.$rs_site_email.'">
	</div>
	</div>
	<hr><h3>Payout Settings</h3><hr>
	<div class="col-lg-3">
	<div class="control-group">
		<label class="control-label" for="">Default Commission</label>
		<div class="controls">
		<input id="" name="dc" type="text" placeholder="" class="input-large" value="'.$default_commission.'">%
	</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="">Min Required for Payout</label>
		<div class="controls">
		<input id="" name="mp" type="text" placeholder="" class="input-large" value="'.$min_payout.'">
	</div>
	</div>
	</div>
	<div class="col-lg-3">
	<div class="control-group">
		<label class="control-label" for="">Payout Options Available</label>
		<div class="controls">
		<input id="" name="paypal" type="checkbox" value="1" ';if($paypal=='1'){echo 'checked';}echo'><i class="fa-paypal"></i> PayPal<br>
		<input id="" name="stripe" type="checkbox" value="1" ';if($stripe=='1'){echo 'checked';}echo'><i class="fa-cc-stripe"></i> Stripe<br>
		<input id="" name="skrill" type="checkbox" value="1" ';if($skrill=='1'){echo 'checked';}echo'> Skrill<br>
		<input id="" name="wire" type="checkbox" value="1" ';if($wire=='1'){echo 'checked';}echo'> Wire Transfer<br>
		<input id="" name="checks" type="checkbox" value="1" ';if($checks=='1'){echo 'checked';}echo'> Check <br>
	</div>
	</div>
	</div>
	</div>
	<div class="control-group">
		<label class="control-label" for=""></label>
		<div class="controls">
		<button type="submit" class="btn btn-success">Save</button>
	</div>
	</div>
	</fieldset>';	
}
