<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
		<div class="stat-box">
			<a href="#">
				<div class="stat-icon stat-success hvr-bounce-in">
					<i class="fa-dollar"></i>
				</div>
				<div class="stat-data">
					<h2><?php total_sales_period($start_date, $end_date);?> <span class="stat-info"><?php echo $lang['TOTAL_SALES'];?> <span class="small-text">(selected period)</span></span></h2>
				</div>
			</a>
		</div>
	</div>
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
	<div class="stat-box">
		<a href="#">
			<div class="stat-icon stat-danger hvr-bounce-in">
				<i class="fa-money"></i>
			</div>
			<div class="stat-data">
				<h2><?php affiliate_earnings_period($start_date, $end_date);?> <span class="stat-info"><?php echo $lang['AFFILIIATE_EARNINGS'];?> <span class="small-text">(selected period)</span></span></h2>
			</div>
		</a>
	</div>
</div>
</div>