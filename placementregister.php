<?php session_start();
date_default_timezone_set('Asia/Kolkata');
require 'connectsql.php';
$acctno="";
if(isset($_SESSION['accountno']))
$acctno=$_SESSION['accountno'];
$sql="SELECT `id` FROM `placement` WHERE `accountno`='$acctno';";
$registered=mysqli_num_rows(mysqli_query($DBcon,$sql));

$sql="SELECT * FROM `feespaid` WHERE `accountno`='$acctno' AND `status`='SUCCESS' AND `type`='Placement Express' LIMIT 1;";
$paid=mysqli_query($DBcon,$sql);
$amountpaid=mysqli_fetch_assoc($paid);
$amountpaid=$amountpaid['amount'];
$paid=mysqli_num_rows($paid);

if(isset($_POST['pe-submit']))
{
	$fname=mysqli_real_escape_string($DBcon,$_POST['fname']);
	$lname=mysqli_real_escape_string($DBcon,$_POST['lname']);
	$accountno=mysqli_real_escape_string($DBcon,$_POST['accountno']);
	$email=mysqli_real_escape_string($DBcon,$_POST['email']);
	$mobileno=mysqli_real_escape_string($DBcon,$_POST['phone']);
	$college=mysqli_real_escape_string($DBcon,$_POST['college']);
	$extrainfo=mysqli_real_escape_string($DBcon,nl2br($_POST['extrainfo']));
	$city=mysqli_real_escape_string($DBcon,$_POST['city']);
	$citypref=mysqli_real_escape_string($DBcon,$_POST['city-pref']);
	$date=date("Y-m-d h:i:s A");

	$sql="INSERT INTO `placement` (`accountno`,`email`,`firstname`,`lastname`,`mobileno`,`college`,`city`,`citypref`,`extrainfo`,`date`)
		VALUES ('$accountno','$email','$fname','$lname','$mobileno','$college','$city','$citypref','$extrainfo','$date');";
	if(mysqli_query($DBcon,$sql))
	{
		header('location:placementregister.php');
		exit;
	}
	else
	 	echo '<div class="alert alert-danger">Sorry something went wrong, please try registering again</div>';
}
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1" />
	<meta name="robots" content="index, follow">  
	<title>Talerang Express | Placement Express | Register</title>
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css?version=2.1">
	<link rel="stylesheet" type="text/css" href="css/sndtformstyle.css">
	<link rel="stylesheet" type="text/css" href="css/landingstyle.css?version=1.1">
	<!-- <link rel="stylesheet" type="text/css" href="css/adminstyle.css"> -->
	<?php include 'noscript.php' ?>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
	<script id="context" type="text/javascript" src="https://context.citruspay.com/static/kiwi/app-js/icp.min.js"></script>
</head>

<body>
<?php include 'google-analytics.php' ?>
<?php 
	$orderAmount = "3500.00"; //order amount for Placement Express in INR
	$returnUrl='http://www.talerang.com/express/placementregister.php';
	$paymenttype='Placement Express';
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
	      <img alt="Talerang" src="img/logoexpress.jpg">
	    </div>

	    <!-- Collect the nav links, forms, and other content for toggling -->
	   <?php if(isset($_SESSION['useremail'])): ?>
	    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	      <ul class="nav navbar-nav navbar-right">
		    <li class="nav-link welcome"><a><span class="text">Welcome, <?php echo $_SESSION['firstname'] ?></span></a></li>
		    <li class="nav-link"><a href="skilltraining.php"><span class="text">Back</span></a></li>
		    <li class="nav-link"><a href="logout.php"><span class="text">Logout</span></a></li>
	      </ul>
	    </div><!-- /.navbar-collapse -->
	   <?php endif; ?>
	  </div><!-- /.container-fluid -->
	</nav>

	<div id="content">

	<div class="ribbon container-fluid">
        <div class="container" id="middle">
            Placement Express
        </div>
    </div>
	
	<?php 
	if(isset($_SESSION['useremail'])): 
	 if(!$registered): 
		require 'connectsql.php';
		$email=$_SESSION['useremail'];

		$sql="SELECT * FROM `register` WHERE `email`='$email';";
		$result=mysqli_query($DBcon,$sql);
		$result=mysqli_fetch_assoc($result);
		if($result['college']!="")
		{
			$college=$result['college'];
			if(substr($college,0,8)=='Other - ') $college=substr($college,8);
		}
		else $college="";
	?>
	<div class="container" id="main">
		<div class="row">
		<div class="col-md-offset-3 col-md-6">
		<form method="post" id="PE_registration" style="margin-bottom: 0;">
			<div class="formfield">
				Please enter your name
				<div>	
					<input type="text" name="accountno" class="form-control displaynone" value="<?php if(isset($result['accountno']) && !isset($_POST['pe-submit'])) echo $result['accountno']; ?>">
					<div>
						<input type="text" class="form-control" name="fname" placeholder="First name" value="<?php if(isset($result['firstname']) && !isset($_POST['pe-submit'])) echo $result['firstname']; ?>" id="fname" />
						<label class="error" for="fname"></label>
					</div>
					<div>
						<input type="text" class="form-control" name="lname" placeholder="Last name" value="<?php if(isset($result['lastname']) && !isset($_POST['pe-submit'])) echo $result['lastname']; ?>" style="margin-top: 5px;" id="lname" />
						<label class="error" for="lname"></label>
					</div>
				</div>
			</div>
			<hr>
			<div class="formfield">
				Please enter your email address
				<input type="text" class="form-control" name="email" placeholder="Email address" id="email" value="<?php if(!isset($_POST['pe-submit'])) echo $_SESSION['useremail']; ?>" />
				<label class="error" for="email"></label>
			</div>
			<hr>
			<div class="formfield">
				Please enter your mobile number
				<!-- <input type="text" name="phone" placeholder="Mobile Number"/> -->
				<div class="input-group">
				  <span class="input-group-addon" id="ccode">+91</span>
				  <input type="text" class="form-control" name="phone" placeholder="Mobile Number" aria-describedby="ccode" id="mobno" value="<?php if(isset($result['phoneno']) && !isset($_POST['pe-submit'])) echo $result['phoneno']; ?>">
				</div>
				<label class="error" for="mobno"></label>
			</div>
			<hr>
			<div class="formfield">
				Which college are you from?
				<input type="text" class="form-control" name="college" id="college" placeholder="Please enter college name" value="<?php if(!isset($_POST['pe-submit'])) echo $college; ?>"/>
				<label for="college" class="error"></label>
			</div>
			<hr>
			<div class="formfield">
				Which city do you currently live in?
				<div>
					<input type="text" class="form-control" name="city" placeholder="Please enter city name" id="city">
					<label for="city" class="error"></label>
				</div>
			</div>
			<div class="formfield">
				Which city do you prefer to work in?
				<div>
					<input type="text" class="form-control" name="city-pref" placeholder="Please enter city name" id="city-pref">
					<label for="city-pref" class="error"></label>
				</div>
			</div>
			<hr>
			<div class="formfield">
				Anything else you would like to share with us? (optional)
				<textarea class="form-control" name="extrainfo" placeholder=""></textarea>
			</div>
			<div class="formfield submit">
				<input type="submit" name="pe-submit" id="submit" value="Submit">
			</div>
		</form>
		</div>
		</div>
	</div> <!-- close container -->
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.1/jquery.validate.min.js"></script>
	<script type="text/javascript">
		//Validating the form
		$('#PE_registration').validate({
			errorClass: 'error',
			rules: {
				'fname':     { required: true , maxlength: 40 },		
				'lname':     { required: true , maxlength: 40 },
				'email':     { required: true , email: true, maxlength: 254 },		
				'phone':     { required: true , maxlength: 15 },		
				'college':   { required: true , maxlength: 250 },		
				'city':      { required: true , maxlength: 50 },		
				'city-pref': { required: true , maxlength: 50 },		
			},
		});
	</script>
	<?php elseif(!$paid): ?>
		<div class="container" id="main">
		<div class="row">
			<?php 
			if (isset($_POST['TxStatus'])) {
			if($_POST['TxStatus']=='SUCCESS'){ ?>
			<div class="alert alert-success">
				Thank you! Your payment was successful. We will contact you shortly with further details of the program
			</div>
			<?php }} ?>
			<div class="alert alert-success">
				Thank you for registering on Placement Express
			</div>
			<div class="alert alert-warning">
				Your registration will be completed once you pay online. Please use the below link to issue the online payment
			</div>
			<form method="post" action="placementregister.php" id="citrus-pay">
				<input type="submit" name="submit-citrus" id="citrus-placement" value="Click here to checkout">
			</form>
		</div>
		</div>
	<?php else: //if paid and registered ?>
		<div class="container" id="main">
		<div class="row">
			<div class="alert alert-success">
				We have received your payment of Rs. <?php echo $amountpaid; ?>.<br>We will contact you shortly with further details of the program
			</div>
		</div>
		</div>
	<?php endif; //if !$registered ?>
	<?php else: ?>
	<div class="container">
		<div class="container" id="notsignedin">
			<div class="alert alert-warning">
				You are not signed in!<br>If you have an account on Talerang Express, please <a class="alert-link" href="index.php?signin&pg=placementregister">sign in</a> first. <br> If you do not have an account, you must <a href="index.php?register" class="alert-link">register here</a>
			</div>
		</div>
	</div>
	<?php endif; // isset session useremail ?>
	</div> <!-- close content -->
	<?php include 'footer.php' ?>
	
</div><!--  close wrapper -->

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>