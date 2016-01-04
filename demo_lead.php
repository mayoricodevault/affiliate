<?php
include('data/data-functions.php');
include('controller/affiliate-tracking.php');
//SITE SETTINGS
list($meta_title, $meta_description, $site_title, $site_email) = all_settings();
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Affiliate Pro</title>

    <!-- Bootstrap Core CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="assets/css/base.css" rel="stylesheet">
	<link href="assets/css/login.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body class="full">

    <!-- Navigation -->
    <nav class="navbar navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">
                   	<img src="assets/img/aplogo.png" style="padding-bottom:20px;">
                </a>
            </div>
           
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                     <!-- You can add some menu links here if you want -->
					
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <!-- Page Content -->
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
				<?php if($_GET['success']!='1'){?>
                <form action="data/capture-lead" method="post" class="form-horizontal login-form">
								<input type="hidden" name="redirect" value="demo_lead">
					<fieldset>
						<legend>Demo Lead</legend>

						<?php if($_GET['error']=='1'){ echo '<div style="color:red;">Please fill in all fields marked with an asterisk *</div>'; } ?>
								<div class="control-group">
								  <label class="control-label" for="fullname">Name *</label>
								  <div class="controls">
									<input id="textinput" name="fullname" type="text" placeholder="" class="input-xlarge"  required="required">
								  </div>
								</div>

								<div class="control-group">
								  <label class="control-label" for="email">E-Mail Address *</label>
								  <div class="controls">
									<input id="textinput" name="email" type="email" placeholder="" class="input-xlarge" required>
								  </div>
								</div>
						
								<div class="control-group">
								  <label class="control-label" for="phone">Phone #</label>
								  <div class="controls">
									<input id="textinput" name="phone" type="text" placeholder="" class="input-xlarge" required>
								  </div>
								</div>

								<div class="control-group">
								  <label class="control-label" for="message">Message *</label>
								  <div class="controls">
									<textarea class="form-control" id="textarea" name="msg"></textarea>
								  </div>
								</div>
				
								<!-- Submit-->
								<div class="control-group">
								  <div class="controls">
									<input type="submit" class="btn btn-primary login-btn" value="Submit">
								  </div>
								</div>
						</fieldset>
				</form> 
				<?php }else{ ?>
					<div class="alert alert-success" role="alert" style="margin-top:40px;">
						<h3>
						Thank you for your time!
						</h3>
						<p>
						Your lead has been successfully submitted to us for review.  We will be in contact with you shortly!
						</p>
					</div>
				<?php } ?>

            </div>
			
        </div>
    </div>
    <!-- /.container -->

    <!-- jQuery -->
    <script src="assets/js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="assets/js/bootstrap.min.js"></script>

</body>

</html>
