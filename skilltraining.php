<?php session_start();
date_default_timezone_set('Asia/Kolkata');
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1" />
	<meta name="robots" content="index, follow">  
	<title>Talerang Express | Skill Training</title>
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css?version=2.1">
	<link rel="stylesheet" type="text/css" href="css/landingstyle.css">
	<link rel="stylesheet" type="text/css" href="css/livelearning.css?version=2.2">
	<?php include 'noscript.php' ?>
	<?php include 'jqueryload.php' ?>
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
		    <li class="nav-link welcome"><a><span class="text">Signed in as <?php echo $_SESSION['firstname'] ?></span></a></li>
		    <li class="nav-link"><a href="landing.php"><span class="text">Back</span></a></li>
		    <li class="nav-link"><a href="logout.php"><span class="text">Logout</span></a></li>
	      
	      </ul>
	    </div><!-- /.navbar-collapse -->
	   <?php endif; ?>
	  </div><!-- /.container-fluid -->
	</nav>

	<div class="ribbon container-fluid">
        <div class="container" id="middle">
           	Skill Training
        </div>
    </div>

	<div id="content">
	<?php if(isset($_SESSION['useremail'])): ?>

	<div class="container">
		
		<!-- <h2 class="livelearning-title">Adaptive English Training</h2> -->
		
		
		<div class="row edusynch">
			<div class="col-md-6">
				<div id="pppwrap" class="wrappers">
					<p style="font-size: 34px;">
						Placement Express
					</p>
					<br>
					<div class="talerang-edusynch-link" onclick="window.open('pdf/Placement_Express.pdf','_blank');">Click here for more details</div>
				</div>
			</div>
			<div class="col-md-6">
				<div id="resume" class="wrappers">
					<p style="font-size: 34px;">
						Make your own resume!
					</p>
					<br>
					<div class="talerang-edusynch-link" onclick="window.open('resumecreate.php','_self')">Start Here</div>
				</div>
			</div>
		</div>

		<div class="row edusynch">
			<div class="col-md-6">
				<div id="skills" class="wrappers">
					<p>
						Find the correct skill track for yourself
					</p>
					<br>
					<div class="talerang-edusynch-link" onclick="window.open('skillselect.php','_self')">Start Here</div>
				</div>
			</div>
			<div class="col-md-6">
				<div id="wrap" class="wrappers">
					<p>
						Do you want to learn or practice your English?<br>
						Use our adaptive English training platform<br>
					</p>
					<br>
					<?php if ($_SESSION['sndtprogram']) { ?>
						<div class="talerang-edusynch-link" onclick="window.open('https://talerang.edusynch.com/sign-up','_blank');">Get Started</div>
						<div class="edusynch-link" onclick="window.open('https://edusynch.com','_blank');">Powered by <a href="http://edusynch.com" target="_blank">Edusynch</a></div>
					<?php } else { ?>
						<div class="talerang-edusynch-link" style="cursor: default;">Coming Soon</div>
						<div class="edusynch-link" style="cursor: default;">Powered by Edusynch</div>
					<?php } ?>
					
				</div>
			</div>
		</div>
		
		<div class="row edusynch">
			<div class=" col-md-offset-3 col-md-6">
				<div id="jhe" class="wrappers" onclick="location.href='jhe.php'">
					<p>Jobs vs Entrepreneurship vs Higher studies Quiz</p><br>
					<div class="talerang-edusynch-link" onclick="window.open('genz.php','_self')">Start Here</div>
				</div>
			</div>
		</div>

	</div> <!-- close container -->
	<?php else: ?>
		<div class="container" id="notsignedin">
			<div class="alert alert-warning">
				You are not signed in! Please <a href="index.php?signin&pg=skilltraining" class="alert-link">Sign in</a> first
			</div>
			
		</div>
	<?php endif; ?>
	</div> <!-- close content -->

	<?php include 'footer.php' ?>

</div><!--  close wrapper -->

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>