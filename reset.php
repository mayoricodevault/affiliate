<?php
include('auth/register.inc.php'); 
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
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Affiliate Pro</title>

    <!-- Bootstrap Core CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="assets/css/base.css" rel="stylesheet">
		<link href="assets/css/login.css" rel="stylesheet">
		<link href="assets/fonts/css/fa.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <!-- Page Content -->
    <div class="container">
			
        <div class="row">
						<div class="col-sm-12 col-md-6 col-md-offset-3">
						
                <form method="post" action="data/reset-password" class="form-horizontal login-form">
								<fieldset>
									<input type="hidden" name="key" value="<?php $key = filter_input(INPUT_GET, 'k', FILTER_SANITIZE_STRING); echo $key; ?>">
									<img src="assets/img/aplogo.png" style="width:50%;"><br>
											<?php 
											if($_GET['error']=='1'){
													echo '<span class="red">New password and Confirm password do not match</span>';
											}
											if($_GET['error']=='2'){
															echo '<span class="red">Invalid PIN entered.  Please refer to the reset email for the correct PIN.</span>';
													}
											if($_GET['error']=='3'){
															echo '<span class="red">You did not enter in the correct PIN or your secret key is missing.  Please use the link provided in the reset email.</span>';
													}?>
											<h4>
												Reset your Password
											</h4>
											
											<div class="control-group">
												<label class="control-label" for="textinput">Temporary PIN</label>
												<div class="controls">
												<input id="textinput" name="pin" type="password" placeholder="**************" class="input-xlarge" required>
												</div>
											</div>
											<div class="control-group">
												<label class="control-label" for="textinput">New Password</label>
												<div class="controls">
												<input id="textinput" name="new_pass" type="password" placeholder="" class="input-xlarge" required>
												</div>
											</div>
											<div class="control-group">
												<label class="control-label" for="textinput">Confirm New Password</label>
												<div class="controls">
												<input id="textinput" name="c_pass" type="password" placeholder="" class="input-xlarge" required>
												</div>
											</div>

											<div class="control-group forgot-link">
												<a href="login">Don't need to reset your password?  Go login now</a>
											</div>

											<!-- Submit-->
											<div class="control-group">
												<div class="controls">
												<input type="submit" class="btn btn-primary btn-block login-btn" value="Reset Password">
												</div>
											</div>
								</fieldset>
							</form> 
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
