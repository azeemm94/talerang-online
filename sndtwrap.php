<?php session_start(); 
	  if(!$_SESSION['sndtprogram']){ header('location:teststart.php'); exit(); }
      date_default_timezone_set('Asia/Kolkata'); 
      ?>
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
	<link rel="stylesheet" type="text/css" href="css/landingstyle.css" />
	<?php include 'jqueryload.php' ?>
	<?php include 'noscript.php' ?>
</head>
<body>
<?php include 'google-analytics.php'; ?>
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
				$email=$_SESSION['useremail'];
				
				$sql="SELECT * FROM `teststart` WHERE `email`='$email'";
				$started=mysqli_num_rows(mysqli_query($DBcon,$sql)); //test not started if 0

				if(!$started):
				?>
				<div>
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
			    <div class="alert alert-warning">You have already attempted the test before! View your results <a href="dashboard.php" class="alert-link">here</a></div>
			    
				<?php endif ?>

		<?php else: //not signed in?> 
			<div id="notsignedin">
				You are not signed in!<br/>
				Please <a href="index.php">Sign in</a> first
			</div>
	    <?php endif ?>
	</div>
	</div>
	<?php include 'footer.php' ?>
</div>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.1/jquery.validate.min.js"></script>
<script type="text/javascript" src="js/teststart.js"></script>
</body>
</html>