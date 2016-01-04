<?php 
include('auth/startup.php');
include('data/data-functions.php');
//SITE SETTINGS
list($meta_title, $meta_description, $site_title, $site_email) = all_settings();
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?php echo $meta_description;?>">
    <meta name="author" content="">

    <title><?php echo $meta_title;?></title>

    <!-- Bootstrap Core CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
   	<link href="assets/css/base.css" rel="stylesheet">
	
	<!-- Elusive and Font Awesome Icons -->
    <link href="assets/fonts/css/elusive.css" rel="stylesheet">
	<link href="assets/fonts/css/fa.css" rel="stylesheet">
	<!-- Webfont -->
	<link href='http://fonts.googleapis.com/css?family=Archivo+Narrow:400,400italic,700,700italic' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Noto+Sans:400,700' rel='stylesheet' type='text/css'>
	<!-- Animation Effects -->
	<link href="assets/css/plugins/hover.css" rel="stylesheet" media="all">
	<!-- SweetAlert Plugin -->
	<link href="assets/css/plugins/sweetalert.css" rel="stylesheet" media="all">
	<!-- Datatables Plugin -->
	<link href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.css" rel="stylesheet" media="all">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
 
</head>

<body>
	<!-- Start Top Navigation -->
	<?php include('assets/comp/top-nav.php');?>
    <!-- Start Main Wrapper --> 
   	<div id="wrapper">
		<!-- Side Wrapper -->
        <div id="side-wrapper">
            <ul class="side-nav">
                <?php include('assets/comp/side-nav.php');?>
			</ul>
        </div><!-- End Main Navigation --> 

        <div id="page-content-wrapper">
            <div class="container-fluid">
				<?php if($admin_user=='1'){ include('assets/comp/stat-boxes.php');}else{ include('assets/comp/my-stat-boxes.php');}?>
				<div class="row">
					<!-- Start Panel -->
					<div class="col-lg-6">
						<div class="panel">
							<div class="panel-heading panel-primary">
								<span class="title"><?php if($admin_user=='1') { echo $lang['TOP_AFFILIATES']; }else { echo $lang['RECENT_TRAFFIC'].' <span class="small">('.$DOMAIN.'?ref='.$owner.')</span>'; }?></span>
							</div>
							<div class="panel-content">
								
									<div id="status"></div>
									<table id="top-affiliates" class="row-border" cellspacing="0" width="100%">
									<thead>
										<tr>
											<?php if($admin_user=='1'){ ?>
											<th><?php echo $lang['NAME'];?></th>
											<th><?php echo $lang['TOTAL_REFERRED'];?></th>
											<th><?php echo $lang['TOTAL_SALES'];?></th>
											<th><?php echo $lang['CONVERSION_RATE'];?></th>
											<?php }else { ?>
											<th><?php echo $lang['IP_ADDRESS'];?></th>
											<th><?php echo $lang['LANDING_PAGE'];?></th>
											<?php $cpc_on = cpc_on(); if($cpc_on=='1'){ echo '<th>'.$lang['CPC_EARNINGS'].'</th>';}?>
											<th><?php echo $lang['DATETIME'];?></th>
											<?php } ?>
										</tr>
									</thead>

									<tbody>
										<?php if($admin_user=='1') { top_affiliates_table(); } else { recent_referrals($owner); }?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<!-- End Panel -->
					<!-- Start Panel -->
					<div class="col-lg-6">
						<div class="panel">
							<div class="panel-heading panel-primary">
								<span class="title"><?php echo $lang['REF_VS_SALE'];?></span>
							</div>
							<div class="panel-content">
								<script type="text/javascript" src="https://www.google.com/jsapi?autoload={'modules':[{'name':'visualization','version':'1.1','packages':['corechart']}]}"></script>
       							<div id="piechart" style="width: 100%; height: 300px;"></div>
								
							</div>
						</div>
					</div>
					<!-- End Panel -->
				</div>
				<div class="row">
				<!-- Start Panel -->
					<div class="col-lg-12">
						<div class="panel">
							<div class="panel-heading panel-warning">
								<span class="title"><?php echo $lang['RECENT_SALES'];?></span>
								<div class="pull-right mr">
									<a href="<?php if($admin_user=='1'){echo 'sales-profits';}else{echo 'my-sales';}?>" class="btn btn-sm btn-primary">View all Sales</a>
								</div>
							</div>
							<div class="panel-content">
								<div>
									<div id="status"></div>
									<table id="sales" class="row-border" cellspacing="0" width="100%">
									<thead>
										<tr>
											<?php if($admin_user=='1'){ ?><th><?php echo $lang['AFFILIATE'];?></th><?php } ?>
											<th><?php echo $lang['PRODUCT'];?></th>
											<th><?php echo $lang['SALE_AMOUNT'];?></th>
											<th><?php echo $lang['COMISSION'];?></th>
											<th><?php echo $lang['NET_EARNINGS'];?></th>
											<?php $rc_on = rc_on(); if($rc_on=='1'){ echo '<th>'.$lang['RECURRING'].'</th>';}?>
											<th><?php echo $lang['DATETIME'];?></th>
										</tr>
									</thead>

									<tbody>
										<?php if($admin_user=='1') { recent_sales_table(); } else { my_recent_sales_table($owner); } ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<!-- End Panel -->
				</div>
            </div>
        </div>
        <!-- End Page Content -->

	</div><!-- End Main Wrapper  -->
   
    <!-- jQuery -->
    <script src="assets/js/jquery.js"></script>

    <!-- Bootstrap -->
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- Base Theme JS -->
   	<script src="assets/js/base.js"></script>
	<!-- SweetAlert -->
	<script src="assets/js/plugins/sweetalert.min.js"></script>
	<!-- Datatables -->
	<script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
	
	<script>
	$(document).ready(function() {
    $('#sales').dataTable({
        /* Disable initial sort */
        "aaSorting": []
    });
	})
	$(document).ready( function() {
    $('#top-affiliates').dataTable({
        /* Disable initial sort */
        "aaSorting": []
    });
	})	
	google.setOnLoadCallback(drawChart);
      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Stat', 'Quanity'],
			['Referrals', <?php if($admin_user=='1'){total_referrals();}else{my_total_referrals($owner);}?>],
			['Sales',      <?php if($admin_user=='1'){count_sales();}else{my_count_sales($owner);}?>],
          
        ]);

        var options = {
          title: 'Total Referrals and Sales'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }	
	</script>
	

	
</body>
</html>
