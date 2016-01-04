<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
		<div class="stat-box">
			<a href="#">
				<div class="stat-icon stat-primary hvr-bounce-in">
					<i class="fa-user"></i>
				</div>
				<div class="stat-data">
					<h2><?php total_leads_i($owner);?> <span class="stat-info"><?php echo $lang['TOTAL_LEADS'];?> </span></h2>
				</div>
			</a>
		</div>
	</div>
	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
		<div class="stat-box">
			<a href="#">
				<div class="stat-icon stat-default hvr-bounce-in">
					<i class="fa-ok-circled2"></i>
				</div>
				<div class="stat-data">
					<h2><?php total_lead_conversions_i($owner);?> <span class="stat-info"><?php echo $lang['TOTAL_CONVERSIONS'];?> </span></h2>
				</div>
			</a>
		</div>
	</div>
	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
	<div class="stat-box">
		<a href="#">
			<div class="stat-icon stat-success hvr-bounce-in">
				<i class="fa-money"></i>
			</div>
			<div class="stat-data">
				<h2><?php total_affiliate_lead_earnings_i($owner);?> <span class="stat-info"><?php echo $lang['AFFILIATE_LEAD_EARNINGS'];?></span></h2>
			</div>
		</a>
	</div>
</div>
</div>