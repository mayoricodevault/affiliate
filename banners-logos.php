<?php 
include('auth/startup.php');
include('data/data-functions.php');
//SITE SETTINGS
list($meta_title, $meta_description, $site_title, $site_email) = all_settings();
$url = filter_input(INPUT_POST, 'url', FILTER_SANITIZE_STRING);
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

        <!-- YOUR CONTENT GOES HERE -->
        <div id="page-content-wrapper">
            <div class="container-fluid">
				<?php if($admin_user=='1'){?>
				<div class="row">
				<!-- Start Panel -->
					<div class="col-lg-12">
						<div class="panel">
							<div class="panel-heading panel-primary">
								<span class="title"><?php echo $lang['UPLOAD_BANNER'];?></span>
							</div>
							<div class="panel-content">
								<?php echo $message;?>
								<form action="data/upload-data" method="post" enctype="multipart/form-data" class="upload-form">
									<select name="adsize">
										<option value="0">Select Size</option>
										<option value="1">Mobile leaderboard (320x50)</option>
										<option value="2">Large mobile banner (320x100)</option>
										<option value="3">Medium Rectange (300x250)</option>
										<option value="4">Rectange (180x150)</option>
										<option value="5">Wide Skyscraper (160x600)</option>
										<option value="6">Leaderboard (728x90)</option>
									</select>
									<br><br>
									<input type="file" name="file" size="25" /><br>
									<input type="submit" name="submit" value="Upload" class="btn btn-primary" />
								</form>
							</div>
						</div>
					</div>
					<!-- End Panel -->
				</div>
				<?php } ?>
				<div class="row">
				<!-- Start Panel -->
					<div class="col-lg-12">
						<div class="panel">
							<div class="panel-heading panel-warning">
								<span class="title"><?php echo $lang['GENERATE_TEXT_LINKS'];?></span>
							</div>
							<div class="panel-content">
								<form class="form-horizontal" method="post" action="banners-logos">
									<fieldset>
										
										<div class="form-group">
											<label class="col-md-2 control-label" for="textinput">URL to Promote</label>
											<div class="col-md-10">
												<input id="textinput" name="url" type="text" placeholder="http://<?php echo $DOMAIN;?>" class="form-control input-md">
												<span class="help-block">example: http://<?php echo $DOMAIN;?>/product-page-1</span> 
											</div>
										</div>
										<div class="form-group">
										<?php if(isset($url)){
											echo '<label class="col-md-2 control-label" for="textinput">Referral Link</label>
													<div class="col-md-10">';
											if (parse_url($url, PHP_URL_QUERY)){
												echo '<input id="textinput" type="text" value="'.$url.'&ref='.$owner.'" class="form-control input-md">';
											}else{
												echo '<input id="textinput" type="text" value="'.$url.'?ref='.$owner.'" class="form-control input-md">';
												
											}
											echo '</div>';
										}?>
										</div>
										<div class="form-group">
											<div class="col-md-10">
												<input type="submit" class="btn btn-default" value="Generate Referral Link">
											</div>
										</div>
									</fieldset>
								</form>
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
								<span class="title"><?php echo $lang['BANNERS_LOGOS'];?></span>
							</div>
							<div class="panel-content">
								<div>
									<div id="status"></div>
									<table id="users" class="row-border" cellspacing="0" width="100%">
									<thead>
										<tr>
											<th><?php echo $lang['BANNER'];?></th>
											<th>Display</th>
											<th><?php echo $lang['CODE'];?></th>
											<th><?php echo $lang['ACTION'];?></th>
										</tr>
									</thead>

									<tbody>
										<?php banner_table($owner, $domain_path, $main_url, $admin_user); ?>
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
    <!-- Base JS -->
   	<script src="assets/js/base.js"></script>
	<!-- SweetAlert -->
	<script src="assets/js/plugins/sweetalert.min.js"></script>
	<!-- Datatables -->
	<script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
	
	<script>
	$(document).ready(function() {
    $('#users').DataTable();
	} );
		
	</script>
	

	
</body>
</html>
