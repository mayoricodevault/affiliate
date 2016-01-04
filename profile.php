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
	<!-- SweetAlert Plugin -->
	<link href="assets/css/plugins/sweetalert.css" rel="stylesheet" media="all">
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
				<div class="row">
					<!-- Start Panel -->
					<div class="col-lg-4">
						<div class="panel">
							<div class="panel-heading panel-primary">
								<span class="title"><?php profile_name($owner);?></span>
							</div>
							<div class="panel-content text-center">
								<div class="file-preview">
									<?php profile_img($owner);?>
								</div>
							</div>
						</div>
					</div>
					<!-- End Panel -->
					<!-- Start Panel -->
					<div class="col-lg-8">
						<div class="panel">
							<div class="panel-heading panel-primary">
								<span class="title"><?php echo $lang['ACCOUNT_DETAILS'];?></span>
							</div>
							<div class="panel-content">
								<?php if($_GET['error']=='1'){
									echo '<div class="alert alert-danger alert-message">
											<i class="icon-exclamation"></i>
												<strong>Ooops!</strong> Your passwords do not match, please try again.
												<button type="button" class="close" data-dismiss="alert" aria-label="Close">
													<span aria-hidden="true">×</span>
												</button>
											</div>';
								}?>
								<div id="status"></div>
								<ul class="file-details"><br><br>
									<?php profile_details($owner);?>
								</ul>
								<div class="download-delete">
									<br><br><hr>
								
									<a href="#" class="btn btn-primary" data-toggle="modal" data-target="#myModal"><?php echo $lang['CHANGE_PASSWORD'];?></a>
								</div>
								
							</div>
						</div>
					</div>
					<!-- End Panel -->
				</div>
            </div>
        </div>
        <!-- End Page Content -->

	</div><!-- End Main Wrapper  -->
   <!-- Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
		   <form method="post" action="data/change-password">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><?php echo $lang['CHANGE_PASSWORD'];?></h4>
		  </div>
		  <div class="modal-body">
			<?php echo $lang['CREATE_NEW_PASSWORD'];?> <br>
			 <div class="form-group">
				 <input type="password" class="form-control margin-10" id="password" name="pwd" placeholder="Password">
				 <input type="password" class="form-control margin-10" id="password" name="cpwd" placeholder="Confirm Password">
			  </div>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $lang['CLOSE'];?></button>
			<button type="submit" class="btn btn-primary"><?php echo $lang['SAVE'];?></button>
			</form>
		  </div>
		</div>
	  </div>
	</div>
    <!-- jQuery -->
    <script src="assets/js/jquery.js"></script>
    <!-- Bootstrap -->
    <script src="assets/js/bootstrap.min.js"></script>
	<!-- Base JS -->
   	<script src="assets/js/base.js"></script>
	<!-- SweetAlert -->
	<script src="assets/js/plugins/sweetalert.min.js"></script>
	<script src="assets/js/profile.js"></script>
</body>
</html>
