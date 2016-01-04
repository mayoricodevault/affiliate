<?php
phpinfo();
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

    <title>Affiliate</title>

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
				<div class="col-lg-12">
					<a class="navbar-brand" href="#">
             <img src="assets/img/aplogo.png">
          </a>
				</div>
			</div>
        <div class="row">
            <div class="col-lg-6">
                <form action="index" method="post" class="form-horizontal login-form">
								<fieldset>
									<legend>Join our Affiliate Program</legend>

											<?php echo '<div style="color:red;">'.$error_msg.'</div>'; ?>
											<div class="control-group">
												<label class="control-label" for="fullname">Full Name</label>
												<div class="controls">
												<input id="textinput" name="fullname" type="text" placeholder="Full Name" class="input-xlarge"  value="<?php echo $_POST['fullname'];?>" required="required">
												</div>
											</div>

											<div class="control-group">
												<label class="control-label" for="username">Username</label>
												<div class="controls">
												<input id="textinput" name="username" type="text" placeholder="username" class="input-xlarge" value="<?php echo $_POST['username'];?>" required>
												</div>
											</div>

											<div class="control-group">
												<label class="control-label" for="email">E-Mail Address</label>
												<div class="controls">
												<input id="textinput" name="email" type="email" placeholder="email@provider.com" class="input-xlarge" value="<?php echo $_POST['email'];?>" required>
												</div>
											</div>

											<!-- Password input-->
											<div class="control-group">
												<label class="control-label" for="passwordinput">Password</label>
												<div class="controls">
												<input id="passwordinput" name="p" type="password" placeholder="password" class="input-xlarge" value="<?php echo $_POST['qp'];?>" required>
												</div>
											</div>

											<div class="control-group">
												<label class="control-label" for="passwordinput">Confirm Password</label>
												<div class="controls">
												<input id="passwordinput" name="confirmpwd" type="password" placeholder="Confirm" class="input-xlarge" value="<?php echo $_POST['qcp'];?>" required>
												</div>
											</div>

											<div class="control-group terms">
												 <div class="controls">
												<input type="checkbox" value="1" name="terms" <?php if($_POST['terms']=='1') echo 'checked';?>> I accept the terms of the affiliate policy
												</div>
											</div>

											<!-- Submit-->
											<div class="control-group">
												<div class="controls">
												<input type="submit" class="btn btn-warning btn-block register-btn" value="Create Account">
												</div>
											</div>
									</fieldset>
							</form> 
            </div>
						<div class="col-lg-6">
                <form method="post" action="access/process_login" class="form-horizontal login-form">
								<fieldset>
									<legend>Login</legend>
											<?php if($_GET['logoff']=='1'){
													echo '<span class="success-text">You have logged off successfully</span>';
											} 
											if($_GET['error']=='1'){
													echo '<span class="red">Invalid Username or Password</span>';
											}?>
											<!-- Username -->
											<div class="control-group">
												<label class="control-label" for="textinput">Username or E-mail Address</label>
												<div class="controls">
												<input id="textinput" name="email" type="text" placeholder="demo" class="input-xlarge">
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
								</fieldset>
							</form> 
							<div class="affiliate-description">
								<h1><i class="fa fa-help-circled"></i> Why Join our Affiliate Program?</h1>
								<ul>
									<li><i class="fa fa-ok-circled2"></i> Earn 10% on every sale you send us!<li>
									<li><i class="fa fa-ok-circled2"></i> Sponsor other Affiliates and earn when they do!<li>
									<li><i class="fa fa-ok-circled2"></i> Earn by bringing us new and awesome leads<li>
									<li><i class="fa fa-ok-circled2"></i> Earn $0.05 for Each Unqiue Visitor<li>
								</ul>
								<br>
							</div>
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
