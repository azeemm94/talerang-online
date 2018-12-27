<?php session_start();
date_default_timezone_set('Asia/Kolkata');

$phperror="";
if(isset($_POST['certificate-submit']))
{
	$cert=$_POST['cert-id'];
	if($cert=="")
	$phperror="Please enter your Certificate ID first";
	else
	{
		require 'connectsql.php';
		$sql="SELECT * FROM `results` WHERE `certificate`='$cert';";
		$result=mysqli_query($DBcon,$sql);
		$verified=mysqli_num_rows($result);
		$result=mysqli_fetch_assoc($result);
	}
}
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1" />
	<meta name="robots" content="index, follow">  
	<title>Talerang Express | </title>
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css?version=2.1">
	<link rel="stylesheet" type="text/css" href="css/landingstyle.css">
	<!-- <link rel="stylesheet" type="text/css" href="css/adminstyle.css"> -->
	<?php include 'noscript.php' ?>
	<?php include 'jqueryload.php' ?>
	<style type="text/css">
	.phperror{
	    color: red;
    	font-style: italic;
    	margin-top: 10px;
	}
	form#certificate-verify{
		display: block;
	    max-width: 300px;
	    margin-top: 30px;
	}
	form#certificate-verify input#cert-id{
		font-size: 24px;
		text-transform: uppercase;
	}
	form#certificate-verify input#submit{
		height: auto;
		width: 100%;
		margin: 0;
		margin-top: 10px;
		font-size: 24px;
		background-color: #bd2325;
		color: white;
		border: none;
		border-radius: 5px;
	}
	</style>
</head>

<body>
<?php include 'google-analytics.php'; ?>
<div id="wrapper">
	<nav class="navbar navbar-default" id="nav-header">
	  <div class="container-fluid">
	    <!-- Brand and toggle get grouped for better mobile display -->
	    <div class="navbar-header">
	      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
	        <span class="sr-only">Toggle navigation</span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	      </button>
	      <img alt="Talerang" src="img/logoexpress.jpg">
	    </div>

	  </div><!-- /.container-fluid -->
	</nav>

	<div class="ribbon container-fluid">
	    <div id="middle">
	        WRAP Certificate
	    </div>
    </div>

	<div id="content">
	<div class="container">

	<?php
	if(isset($_POST['certificate-submit'])): 
		 if($cert!="" && !$verified): ?>
			<div class="alert alert-danger" style="margin-top: 10px;">
				This Certificate ID is invalid
			</div>
		<?php elseif($cert!="" && $verified) : //certificate is valid ?>
			<div class="alert alert-success" style="margin-top: 10px;">
				<?php echo $cert ?><br>
				This certificate belongs to: <?php echo $result['firstname']." ".$result['lastname'] ?><br>
				WRAP Percentile: <?php echo $result['percentile'] ?><br>
				Work-ready score: <?php echo $result['avg'] ?>
			</div>
		<?php endif; ?>

	<?php endif; //only if form posted ?>
	<form method="post" action="certificate-verify.php" id="certificate-verify">
		<label for="cert-id">Enter your 8 digit Certificate ID:</label>
		<input type="text" name="cert-id" id="cert-id" class="form-control">
		<input type="submit" name="certificate-submit" id="submit" value="Submit">
		<label class="phperror" for="cert-id"><?php echo $phperror ?></label>
	</form>
	
	
	</div> <!-- close container -->
	</div> <!-- close content -->

	<?php include 'footer.php' ?>

</div><!--  close wrapper -->

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>