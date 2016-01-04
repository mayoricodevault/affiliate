<?php //THIS RECORDS THE SALE FROM THE PREVIOUS FORM (NORMALLY YOU WOULD COMPLETE A CHECKOUT PROCESS BEFORE THIS OR IMPLEMENT THE INCLUDED PAYPAL IPN EXAMPLE)
if(isset($_POST['amount'])){
$sale_amount = filter_input(INPUT_POST, 'amount', FILTER_SANITIZE_STRING);
$product = filter_input(INPUT_POST, 'product', FILTER_SANITIZE_STRING);
$commission = filter_input(INPUT_POST, 'commission', FILTER_SANITIZE_STRING);
$recurring = filter_input(INPUT_POST, 'recurring', FILTER_SANITIZE_STRING);
$recurring_fee = filter_input(INPUT_POST, 'recurring_fee', FILTER_SANITIZE_STRING);
include('controller/record-sale.php');
?>

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
            <h1>Your Sale has Been Recorded! 
				<H3>
				- Refreshing this page will not create another sale
				</H3>
			</h1>
			<p><a href="http://jdwebdesigner.com/affiliate-pro-demo">Login to the affiliate panel</a> to view the transaction.</p>
			
        </header>

       

        <!-- Footer -->
        <footer>
            <div class="row">
                <div class="col-lg-12">
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
<?php 
}else{
header('Location: demo_landing');
}
?>