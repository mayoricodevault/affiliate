<?php include_once 'controller/affiliate-tracking.php';?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Affiliate Pro - Demo Site</title>

    <!-- Bootstrap Core CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="assets/css/demo.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#"><img src="assets/img/aplogo.png" style="width:200px; margin-top:-10px;"></a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="#">About</a>
                    </li>
                    <li>
                        <a href="#">Services</a>
                    </li>
                    <li>
                        <a href="#">Contact</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <!-- Page Content -->
    <div class="container">

        <!-- Jumbotron Header -->
        <header class="jumbotron hero-spacer">
            <h1>Affiliate Pro Demo Store</h1>
            <p>This is very simply how affiliate pro could interact with your website to create a robust affiliate program with simplisticity!
			Clicking "buy now" on a product below will record a sale that you can see in the backend.  Note buying the same product or refreshing
			the thank you page will not result in an affiliate sale and is flagged for your protection.</p>
            <p><a class="btn btn-primary btn-large">Affiliate ID: <?php echo $_COOKIE[$ap_tracking];?></a> - If
				this value is set, the affiliate will get credit for any sales!  ?ref=ID in any query string / URL sets it
            </p>
			<hr>
			<form method="post" action="demo_landing">
				<input type="hidden" name="delete" value="1">
				<input type="submit" class="btn btn-default" value="Clear Affiliate ID"> - You can then set your own 
				<a href="http://jdwebdesigner.com/affiliate-pro-demo/demo_landing?ref=12">(for example: http://jdwebdesigner.com/affiliate-pro-demo/demo_landing?ref=12)</a>
			</form>
			
        </header>

        <hr>

        <!-- Title -->
        <div class="row">
            <div class="col-lg-12">
                <h3>Our Products (click buy to record a sale)</h3>
            </div>
        </div>
        <!-- /.row -->

        <!-- Page Features -->
        <div class="row text-center">

            <div class="col-md-3 col-sm-6 hero-feature">
                <div class="thumbnail">
                    <img src="http://placehold.it/800x500" alt="">
                    <div class="caption">
                        <h3>Gaming System</h3>
                        <p>$249.99</p>
                        <p>
                            <form method="post" action="demo_sale">
								<input type="hidden" name="product" value="Gaming System">
								<input type="hidden" name="amount" value="249.99">
								<input type="submit" class="btn btn-primary" value="Buy Now">
							</form>
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 hero-feature">
                <div class="thumbnail">
                    <img src="http://placehold.it/800x500" alt="">
                    <div class="caption">
                        <h3>Desk Lamp</h3>
                        <p>$29.99</p>
                        <p>
                            <form method="post" action="demo_sale">
								<input type="hidden" name="product" value="Desk Lamp">
								<input type="hidden" name="amount" value="29.99">
								<input type="hidden" name="commission" value="21">
								<input type="submit" class="btn btn-primary" value="Buy Now">
							</form>
                        </p>
					<span style="font-size:11px;">* Commission override set at 21% for this product only to show how you can manually change commissions if you want.</span>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 hero-feature">
                <div class="thumbnail">
                    <img src="http://placehold.it/800x500" alt="">
                    <div class="caption">
                        <h3>Wireless Headphones</h3>
                        <p>$95.50</p>
                        <p>
                            <form method="post" action="demo_sale">
								<input type="hidden" name="product" value="Wireless Headphones">
								<input type="hidden" name="amount" value="95.50">
								<input type="submit" class="btn btn-primary" value="Buy Now">
							</form>
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 hero-feature">
                <div class="thumbnail">
                    <img src="http://placehold.it/800x500" alt="">
                    <div class="caption">
                        <h3>Monthly Download Subscription</h3>
                        <p>$19.95</p>
                        <p>
                           <form method="post" action="demo_sale">
								<input type="hidden" name="product" value="Monthly Download Subscription">
								<input type="hidden" name="amount" value="19.95">
							   	<input type="hidden" name="recurring" value="monthly">
							   	<input type="hidden" name="recurring_fee" value="8">
								<input type="submit" class="btn btn-primary" value="Buy Now">
							</form>
                        </p>
					<span style="font-size:11px;">* You can let affiliates earn a recurring commission, this product is set to do so.</span>
                    
                    </div>
                </div>
            </div>

        </div>
        <!-- /.row -->

        <hr>

        <!-- Footer -->
        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p>PRODUCTS AND PRICING SHOW ARE FOR AFFILIATE PRO DEMONSTRATION PURPOSES ONLY!  PRODUCTS ARE NOT ACTUALLY FOR SALE THROUGH THIS WEBSITE.  </p>
                </div>
            </div>
        </footer>

    </div>
    <!-- /.container -->

    <!-- jQuery -->
    <script src="assets/js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="assets/js/bootstrap.min.js"></script>

</body>

</html>
<?php unset($_SESSION['ap_sale_hit']);?>