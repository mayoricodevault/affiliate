<?php $cpc_on = cpc_on();
if($cpc_on=='1'){$col='4';}else{$col='6';}?>
<div class="row">
    <div class="col-lg-<?php echo $col;?> col-md-<?php echo $col;?> col-sm-6 col-xs-12">
		<div class="stat-box">
			<a href="#">
				<div class="stat-icon stat-default hvr-bounce-in">
					<i class="fa-rocket"></i>
				</div>
				<div class="stat-data">
					<h2><?php total_referrals_period($start_date, $end_date);?> <span class="stat-info"><?php echo $lang['VISITORS'];?> <span class="small-text">(selected period)</span></span></h2>
				</div>
			</a>
		</div>
	</div>
	<?php if($cpc_on=='1'){ ?>
	<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
		<div class="stat-box">
			<a href="my-traffic">
				<div class="stat-icon stat-default hvr-bounce-in">
					<i class="fa-money"></i>
				</div>
				<div class="stat-data">
					<h2><?php total_cpc_earnings($owner);?> <span class="stat-info"><?php echo $lang['CPC_EARNINGS'];?></span></h2>
				</div>
			</a>
		</div>
	</div>
	<?php } ?>
	<div class="col-lg-<?php echo $col;?> col-md-<?php echo $col;?> col-sm-6 col-xs-12">
	<div class="stat-box">
		<a href="#">
			<div class="stat-icon stat-success hvr-bounce-in">
				<i class="fa-user"></i>
			</div>
			<div class="stat-data">
				<h2><?php active_affiliates_period($start_date, $end_date);?> <span class="stat-info"><?php echo $lang['ACTIVE_AFFILIATES'];?> <span class="small-text">(selected period)</span></span></h2>
			</div>
		</a>
	</div>
</div>
</div>