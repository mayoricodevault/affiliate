<div class="row">
<div class="col-lg-4 col-md-3 col-sm-6 col-xs-12">
	<div class="stat-box">
		<a href="my-sales">
			<div class="stat-icon stat-success hvr-bounce-in">
				<i class="fa-dollar"></i>
			</div>
			<div class="stat-data">
				<h2><?php total_sales_period($start_date, $end_date, $affiliate_filter);?> 
					<span class="stat-info"><?php echo $lang['SALES'];?> 
						<span class="small-text">(selected period)</span>
					</span>
				</h2>
			</div>
		</a>
	</div>
</div>
<div class="col-lg-4 col-md-3 col-sm-6 col-xs-12">
	<div class="stat-box">
		<a href="my-sales">
			<div class="stat-icon stat-danger hvr-bounce-in">
				<i class="fa-money"></i>
			</div>
			<div class="stat-data">
				<h2><?php affiliate_earnings_period($start_date, $end_date, $affiliate_filter);?> 
					<span class="stat-info"><?php echo $lang['EARNINGS'];?> 
						<span class="small-text">(selected period)</span>
					</span>
				</h2>
			</div>
		</a>
	</div>
</div>
<div class="col-lg-4 col-md-3 col-sm-6 col-xs-12">
	<div class="stat-box">
		<a href="my-traffic">
			<div class="stat-icon stat-default hvr-bounce-in">
				<i class="fa-rocket"></i>
			</div>
			<div class="stat-data">
				<h2><?php total_referrals_period($start_date, $end_date, $affiliate_filter);?> 
					<span class="stat-info"><?php echo $lang['REFERRED'];?> 
						<span class="small-text">(selected period)</span>
					</span>
				</h2>
			</div>
		</a>
	</div>
</div>
</div>