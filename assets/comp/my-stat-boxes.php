<?php $cpc_on = cpc_on();
if($cpc_on=='1'){$col='3';}else{$col='4';}?>
<div class="row">
	<div class="col-lg-<?php echo $col;?> col-md-<?php echo $col;?>  col-sm-6 col-xs-12">
		<div class="stat-box">
			<a href="my-traffic">
				<div class="stat-icon stat-default hvr-bounce-in">
					<i class="fa-rocket"></i>
				</div>
				<div class="stat-data">
					<h2><?php my_total_referrals($owner);?> <span class="stat-info"><?php echo $lang['REFERRED_VISITS'];?></span></h2>
				</div>
			</a>
		</div>
	</div>
	<?php if($cpc_on=='1'){ ?>
	<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
		<div class="stat-box">
			<a href="my-traffic">
				<div class="stat-icon stat-primary hvr-bounce-in">
					<i class="fa-money"></i>
				</div>
				<div class="stat-data">
					<h2><?php my_total_cpc_earnings($owner);?> <span class="stat-info"><?php echo $lang['CPC_EARNINGS'];?></span></h2>
				</div>
			</a>
		</div>
	</div>
	<?php } ?>
	<div class="col-lg-<?php echo $col;?> col-md-<?php echo $col;?> col-sm-6 col-xs-12">
		<div class="stat-box">
			<a href="my-sales">
				<div class="stat-icon stat-danger hvr-bounce-in">
					<i class="fa-money"></i>
				</div>
				<div class="stat-data">
					<h2><?php my_total_sales($owner);?> <span class="stat-info"><?php echo $lang['SALES'];?></span></h2>
				</div>
			</a>
		</div>
	</div>
	<div class="col-lg-<?php echo $col;?> col-md-<?php echo $col;?> col-sm-6 col-xs-12">
		<div class="stat-box">
			<a href="my-sales">
				<div class="stat-icon stat-success hvr-bounce-in">
					<i class="fa-dollar"></i>
				</div>
				<div class="stat-data">
					<h2><?php balance($owner);?> <span class="stat-info"><?php echo $lang['BALANCE'];?></span></h2>
				</div>
			</a>
		</div>
	</div>
</div>