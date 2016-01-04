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
						
                <form method="post" action="access/process_login" class="form-horizontal login-form">
								<fieldset>
									<img src="assets/img/aplogo.png" style="width:50%;"><br>
											<?php if($_GET['logoff']=='1'){
													echo '<span class="success-text">You have logged off successfully</span>';
											} 
											if($_GET['success']=='1'){
													echo '<span class="success-text">Your password has been reset successfully.</span>';
											} 
											if($_GET['error']=='1'){
													echo '<span class="red">Invalid Username or Password</span>';
											}?>
											<!-- Username -->
											<div class="control-group">
												<label class="control-label" for="textinput">Username or E-mail Address</label>
												<div class="controls">
												<input id="textinput" name="email" type="text" placeholder="username" class="input-xlarge">
												</div>
											</div>

											<!-- Password input-->
											<div class="control-group">
												<label class="control-label" for="passwordinput">Password</label>
												<div class="controls">
												<input id="passwordinput" name="p" type="password" placeholder="Password" class="input-xlarge">
												</div>
											</div>

											<div class="control-group forgot-link">
												<a href="forgot">Forgot your username or password?</a>
											</div>

											<!-- Submit-->
											<div class="control-group">
												<div class="controls">
												<input type="submit" class="btn btn-primary btn-block login-btn" value="Login">
												</div>
											</div>
											
											<div class="signup">
												<span> <a href="index">Don't have an account?</a> </span>
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
