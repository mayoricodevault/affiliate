<?php $page = basename($_SERVER['PHP_SELF']);?>
<div class="side-heading">Main Menu</div>
<li class="side-danger menu-item <?php if($page=='dashboard.php'){echo 'active';}?>">
	<a href="http://<?php echo $domain_path;?>/dashboard">
		<i class="fa-desktop"></i> <?php echo $lang['DASHBOARD'];?>
	</a>
</li>
<?php if($admin_user=='1'){?>
<li class="side-danger menu-item <?php if($page=='affiliates.php'){echo 'active';}?>">
	<a href="http://<?php echo $domain_path;?>/affiliates">
		<i class="fa-users"></i> <?php echo $lang['AFFILIATES'];?>
	</a>
</li>
<?php $lc_on = lc_on(); if($lc_on=='1'){ ?>
<li class="side-danger menu-item <?php if($page=='leads.php'){echo 'active';}?>">
	<a href="http://<?php echo $domain_path;?>/leads">
		<i class="fa-user"></i> <?php echo $lang['LEADS'];?>
	</a>
</li>
<?php } ?>
<li class="side-danger menu-item <?php if($page=='sales-profits.php'){echo 'active';}?>">
	<a href="http://<?php echo $domain_path;?>/sales-profits">
		<i class="fa-basket"></i> <?php echo $lang['SALES'];?>
	</a>
</li>
<?php $rc_on = rc_on(); if($rc_on=='1'){ ?>
<li class="side-danger menu-item <?php if($page=='recurring-sales.php'){echo 'active';}?>">
	<a href="http://<?php echo $domain_path;?>/recurring-sales">
		<i class="fa-arrows-cw"></i> <?php echo $lang['RECURRING_COMMISSIONS'];?>
	</a>
</li>
<?php } ?>
<?php $mt_on = mt_on(); if($mt_on=='1'){ ?>
<li class="side-danger menu-item <?php if($page=='multi-tier.php'){echo 'active';}?>">
	<a href="http://<?php echo $domain_path;?>/multi-tier">
		<i class="fa-sitemap"></i> <?php echo $lang['MULTI_TIER_COMMISSIONS'];?>
	</a>
</li>
<?php } ?>
<li class="side-danger menu-item <?php if($page=='referral-traffic.php'){echo 'active';}?>">
	<a href="http://<?php echo $domain_path;?>/referral-traffic">
		<i class="fa-rocket"></i> <?php echo $lang['REFERRAL_TRAFFIC'];?>
	</a>
</li>
<li class="side-danger menu-item <?php if($page=='banners-logos.php'){echo 'active';}?>">
	<a href="http://<?php echo $domain_path;?>/banners-logos">
		<i class="fa-picture"></i> <?php echo $lang['BANNERS_AND_LOGOS'];?>
	</a>
</li>
<li class="side-danger menu-item <?php if($page=='payouts.php'){echo 'active';}?>">
	<a href="http://<?php echo $domain_path;?>/payouts">
		<i class="fa-money"></i> <?php echo $lang['PAYOUTS'];?>
	</a>
</li>
<li class="side-danger menu-item <?php if($page=='fixed-commissions.php'){echo 'active';}?>" >
	<a href="#" data-toggle="collapse" data-target="#cs">
		<i class="fa-award"></i> <?php echo $lang['COMMISSION_SETTINGS'];?>
	</a>
	<ul id="cs" class="collapse">
		<li>
			<a href="fixed-commissions"><?php echo $lang['FIXED_COMMISSIONS'];?></a>
		</li>
		<li>
			<a href="sales-volume-commissions"><?php echo $lang['SALES_VOLUME_COMMISSIONS'];?></a>
		</li>
		<li>
			<a href="cpc-commissions"><?php echo $lang['CPC_COMMISSIONS'];?></a>
		</li>
		<li>
			<a href="recurring-commissions"><?php echo $lang['RECURRING_COMMISSIONS'];?></a>
		</li>
		<li>
			<a href="multi-tier-commissions"><?php echo $lang['MULTI_TIER_COMMISSIONS'];?></a>
		</li>
		<li>
			<a href="lead-commissions"><?php echo $lang['LEAD_COMMISSIONS'];?></a>
		</li>
	</ul>
</li>
<li class="side-danger menu-item <?php if($page=='settings.php'){echo 'active';}?>">
	<a href="http://<?php echo $domain_path;?>/settings">
		<i class="fa-cog"></i> <?php echo $lang['WEBSITE_INTEGRATION'];?>
	</a>
</li>
<div class="side-heading"><?php echo $lang['TOP_AFFILIATES'];?></div>
<?php top_affiliates_list(); ?>
<?php } else { ?>
<li class="side-danger menu-item <?php if($page=='leads.php'){echo 'active';}?>">
	<a href="http://<?php echo $domain_path;?>/leads">
		<i class="fa-user"></i> <?php echo $lang['MY_LEADS'];?>
	</a>
</li>
<li class="side-danger menu-item <?php if($page=='banners-logos.php'){echo 'active';}?>">
	<a href="http://<?php echo $domain_path;?>/banners-logos">
		<i class="fa-picture"></i> <?php echo $lang['BANNERS_AND_LOGOS'];?>
	</a>
</li>
<li class="side-danger menu-item <?php if($page=='my-sales.php'){echo 'active';}?>">
	<a href="http://<?php echo $domain_path;?>/my-sales">
		<i class="fa-chart-line"></i> <?php echo $lang['SALES'];?>
	</a>
</li>
<?php $rc_on = rc_on(); if($rc_on=='1'){ ?>
<li class="side-danger menu-item <?php if($page=='my-recurring-sales.php'){echo 'active';}?>">
	<a href="http://<?php echo $domain_path;?>/my-recurring-sales">
		<i class="fa-arrows-cw"></i> <?php echo $lang['RECURRING_COMMISSIONS'];?>
	</a>
</li>
<?php } ?>
<?php $mt_on = mt_on(); if($mt_on=='1'){ ?>
<li class="side-danger menu-item <?php if($page=='my-multi-tier.php'){echo 'active';}?>">
	<a href="http://<?php echo $domain_path;?>/my-multi-tier">
		<i class="fa-sitemap"></i> <?php echo $lang['MULTI_TIER_COMMISSIONS'];?>
	</a>
</li>
<?php } ?>
<li class="side-danger menu-item <?php if($page=='my-traffic.php'){echo 'active';}?>">
	<a href="http://<?php echo $domain_path;?>/my-traffic">
		<i class="fa-rocket"></i> <?php echo $lang['REFERED_TRAFFIC'];?>
	</a>
</li>
<li class="side-danger menu-item <?php if($page=='my-payouts.php'){echo 'active';}?>">
	<a href="http://<?php echo $domain_path;?>/my-payouts">
		<i class="fa-money"></i> <?php echo $lang['PAYOUTS'];?>
	</a>
</li>
<?php } ?>

