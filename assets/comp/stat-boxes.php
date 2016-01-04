<div class="row">
	<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
		<div class="stat-box">
			<a href="affiliates">
				<div class="stat-icon stat-primary hvr-bounce-in">
					<i class="fa-users"></i>
				</div>
				<div class="stat-data">
					<h2><?php total_affiliates();?> <span class="stat-info"><?php echo $lang['TOTAL_AFFILIATES'];?></span></h2>
				</div>
			</a>
		</div>
	</div>
	<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
		<div class="stat-box">
			<a href="referral-traffic">
				<div class="stat-icon stat-default hvr-bounce-in">
					<i class="fa-rocket"></i>
				</div>
				<div class="stat-data">
					<h2><?php total_referrals();?> <span class="stat-info"><?php echo $lang['REFERRED_VISITS'];?></span></h2>
				</div>
			</a>
		</div>
	</div>
	<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
		<div class="stat-box">
			<a href="sales-profits">
				<div class="stat-icon stat-success hvr-bounce-in">
					<i class="fa-dollar"></i>
				</div>
				<div class="stat-data">
					<h2><?php total_sales();?> <span class="stat-info"><?php echo $lang['TOTAL_SALES'];?></span></h2>
				</div>
			</a>
		</div>
	</div>
	<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
		<div class="stat-box">
			<a href="sales-profits">
				<div class="stat-icon stat-danger hvr-bounce-in">
					<i class="fa-money"></i>
				</div>
				<div class="stat-data">
					<h2><?php affiliate_earnings();?> <span class="stat-info"><?php echo $lang['NET_EARNINGS'];?></span></h2>
				</div>
			</a>
		</div>
	</div>
</div>