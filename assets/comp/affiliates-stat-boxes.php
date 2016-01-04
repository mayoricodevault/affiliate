<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
		<div class="stat-box">
			<a href="#">
				<div class="stat-icon stat-success hvr-bounce-in">
					<i class="fa-users"></i>
				</div>
				<div class="stat-data">
					<h2><?php total_affiliates();?> <span class="stat-info"><?php echo $lang['TOTAL_AFFILIATES'];?></span></h2>
				</div>
			</a>
		</div>
	</div>
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
	<div class="stat-box">
		<a href="#">
			<div class="stat-icon stat-danger hvr-bounce-in">
				<i class="fa-dollar"></i>
			</div>
			<div class="stat-data">
				<h2><?php total_balance();?> <span class="stat-info"><?php echo $lang['TOTAL_BALANCE'];?></span></h2>
			</div>
		</a>
	</div>
</div>
</div>