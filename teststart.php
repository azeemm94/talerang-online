<?php session_start(); 
      date_default_timezone_set('Asia/Kolkata'); 
	  $accountno=$_SESSION['accountno'];     
      if($_SESSION['sndtprogram']) { header('location: sndtwrap.php'); exit(); }
//echo "<table>";foreach ($_POST as $key => $value) echo "<tr><td>".$key."</td><td>".$value."</td></tr>"; echo "</table>"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="description" content="WRAP is a work-readiness aptitude predictor which can predict how work-ready you are.">
    <meta name="robots" content="index, follow">
	<title>Talerang Express | WRAP</title>
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css?version=2.1" />
	<link rel="stylesheet" type="text/css" href="css/landingstyle.css?version=3.1" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
	<script id="context" type="text/javascript" src="https://context.citruspay.com/static/kiwi/app-js/icp.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.0.47/jquery.fancybox.min.css" />
	<?php include 'noscript.php' ?>
</head>
<body>
<?php include 'google-analytics.php'; ?>
<?php 
$orderAmount = "500.00"; //order amount for WRAP
$returnUrl='http://www.talerang.com/express/teststart.php';
$paymenttype='WRAP';
include 'citrus-pay.php';
?>
<div id="wrapper">
	<nav class="navbar navbar-default" id="nav-header">
	  <div class="container-fluid">
	    <!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<?php if(isset($_SESSION['useremail'])): ?>
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			<?php endif; ?>
			<a href="index.php"><img alt="Talerang" src="img/logoexpress.jpg"></a>
		</div>

	    <!-- Collect the nav links, forms, and other content for toggling -->
	   <?php if(isset($_SESSION['useremail'])): ?>
	    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	      <ul class="nav navbar-nav navbar-right">
		    <li class="nav-link welcome"><a><span>Signed in as <?php echo $_SESSION['firstname'] ?></span></a></li>
		    <li class="nav-link"><a href="landing.php"><span>Back</span></a></li>
		    <li class="nav-link"><a href="logout.php"><span>Logout</span></a></li>
	      </ul>
	    </div><!-- /.navbar-collapse -->
	   <?php endif; ?>
	  </div><!-- /.container-fluid -->
	</nav>

	<div id="content" class="container-fluid">

	<div class="ribbon container-fluid">
	    <div id="middle">
	        Work Readiness Aptitude Predictor
	    </div>
    </div>
    
    <div class="container" id="main">
		<?php if(isset($_SESSION['useremail'])): 
				require 'connectsql.php';
				$sql="SELECT `id` FROM `feespaid` WHERE `accountno`='$accountno' AND `status`='SUCCESS' AND `type`='Placement Express';";
				$placementpaid=mysqli_num_rows(mysqli_query($DBcon,$sql));

				$email=$_SESSION['useremail'];
				
				$sql="SELECT * FROM `teststart` WHERE `email`='$email'";
				$result=mysqli_query($DBcon,$sql);
				$started=mysqli_num_rows($result); //test not started if 0
				
				$sql="SELECT * FROM `couponcodes` WHERE `email`='$email';";
				$coupon=mysqli_num_rows(mysqli_query($DBcon,$sql)); //coupon not applied if 0


				$sql="SELECT * FROM `feespaid` WHERE `type`='WRAP' AND `email`='$email' AND `status`='SUCCESS';";
				$result=mysqli_query($DBcon,$sql);
				$testpaid=mysqli_num_rows($result); //testnot paid if 0
				$row=mysqli_fetch_assoc($result);
				$amt=$row['amount'];
				//$testpaid=1;//free for all
									
				if(isset($_POST['ccode-submit']))://insert coupon code if form submitted
					$couponcode=$_POST['ccode'];
					$sql="SELECT * FROM `couponcodes` WHERE `code`='$couponcode' AND `used`=0";
					$codefound=mysqli_num_rows(mysqli_query($DBcon,$sql));
					if($codefound==0):
						echo '<div class="alert alert-danger">Coupon code entered is invalid or has already been used</div>';
					elseif($codefound==1):
						$date=date("Y-m-d h:i:sa");
						$sql="UPDATE `couponcodes` SET `email`='$email',`used`='1',`date`='$date' WHERE `code`='$couponcode'";
						mysqli_query($DBcon,$sql);
						header('location:teststart.php');
					endif;
				endif;

				if($started==0&&$testpaid==0&&$coupon==0&&$placementpaid==0): ?>
					<div class="row" style="text-align: center">
					<h3>How would you like to checkout?</h3>
					<form name="pay-option" id="pay-option" method="post">
						<input type="radio" class="pay-option displaynone" name="pay-option" value="citrus-pay" id="citrus-pay"/>
						<label for="citrus-pay">Pay Online</label>
						<input type="radio" class="pay-option displaynone" name="pay-option" value="coupon-pay" id="coupon-pay"/>
						<label for="coupon-pay">Use Coupon Code</label>
					</form>
					
					<form action="teststart.php" method="post" name="coupon" id="coupon" class="displaynone">
						<label for="ccode">Enter your coupon code:</label><br>
						<input type="text" name="ccode" placeholder="Coupon Code"/>
						<input type="submit" name="ccode-submit" value="Apply"/>
						<div><label for="ccode" class="error" style="margin: 15px 0 0 0; font-style: normal;"></label></div>
					</form>

					<form action="teststart.php" method="post" name="citrus-test" id="citrus-test" class="displaynone">
						<div>Pay Rs. 500/- with credit card / debit card / net banking</div>
						<input type="submit" name="submit-citrus" value="Pay Online"/>
					</form>
					</div>
					<div class="row" style="text-align: center">
					<h3>With WRAP you get access to:</h3>
						<div class="col-md-4 lbox-image">
							<a href="img/WRAP-screenshot.png" data-fancybox="group" data-caption="WRAP in action">
								<img src="img/WRAP-screenshot.png" class="lightbox-thumbnail" alt="Work-Readiness Aptitude Predictor">
							</a>
						</div>
						<div class="col-md-4 lbox-image">
							<a href="img/dashboard-screenshot.png" data-fancybox="group" data-caption="Your dashboard once you complete WRAP. This includes section-wise grading and feedback">
								<img src="img/dashboard-screenshot.png" class="lightbox-thumbnail" alt="Dashboard">
							</a>
						</div>
						<div class="col-md-4 lbox-image">
							<a href="img/certificate-screenshot.png" data-fancybox="group" data-caption="Certificate given to you for successfully completing WRAP">
								<img src="img/certificate-screenshot.png" class="lightbox-thumbnail" alt="Certificate">
							</a>
						</div>
					</div>
				<?php endif;

				if(($started==0&&($testpaid>0||$placementpaid>0))||($started==0&&$coupon>0)):?>
				<div>

				<?php if($testpaid>0): ?>
					<div class="alert alert-success">
						We have successfully received a payment of Rs. <?php echo $amt ?>
					</div>
				<?php endif ?>

				<?php if($coupon>0): ?>
					<div class="alert alert-success">
						Your coupon code has been applied!
					</div>
				<?php endif ?>

				Important instructions before you start the assessment:
				<ul>
					<li><b>All questions</b> are compulsory</li>
					<li>You will be given <b>30 minutes</b> to complete the test</li>
					<li>Do not press the back button on your browser once the assessment starts</li>
					<li>You have only <b>one attempt</b> to complete the test</li>
					<li>This assessment works best on a laptop / desktop computer. Please <b>avoid</b> using a <b>mobile phone</b></li>
					<li>Make sure you have a <b>steady internet connection</b></li>
				</ul>
				<a id="teststart" href="wrap.php" onclick="return confirm('Are you sure you want to start the test now?')">Start the Assessment!</a>
				</div>
			    <?php elseif($started>0) :?>
			    <div class="alert alert-warning">You have already attempted the test before! <a href="dashboard.php" class="alert-link">View your results here</a>
				<div>
					Contact <a href="mailto:support@talerang.com" class="alert-link">support@talerang.com</a> in case you did not complete the test successfully
				</div>
			    </div>
			    
				<?php endif ?>

		<?php else: //not signed in?> 
			<div id="notsignedin">
				<div class="alert alert-warning">
					You are not signed in! Please <a href="index.php?signin&pg=teststart" class="alert-link">Sign in</a> first
				</div>
			</div>
	    <?php endif ?>
	</div>
	</div>
	<?php include 'footer.php' ?>
</div>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.1/jquery.validate.min.js"></script>
<script type="text/javascript" src="js/teststart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.0.47/jquery.fancybox.min.js"></script>
</body>
</html>