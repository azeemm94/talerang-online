<?php session_start();
	if(isset($_SESSION['adminuser'])) unset($_SESSION['adminuser']);
	if(isset($_SESSION['privilege'])) unset($_SESSION['privilege']);
	date_default_timezone_set('Asia/Kolkata'); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="robots" content="index, follow">
	<title>Talerang Express | Home</title>
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css?version=2.1" />
	<link rel="stylesheet" type="text/css" href="css/landingstyle.css?version=1.1" />
	<?php include 'noscript.php' ?>
	<?php include 'jqueryload.php' ?>
</head>
<body>
<?php include 'google-analytics.php'; ?>
<div id="wrapper">
	<nav class="navbar navbar-default" id="nav-header">
	  <div class="container-fluid">
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

	   <?php if(isset($_SESSION['useremail'])): ?>
	    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	    <?php if($_SESSION['sndtprogram']): ?>
	      <ul class="nav navbar-nav" id="nav-logos">
	      	<li class="nav-link">
	      		<div class="logodiv"><a href="https://www.facebook.com/projectswadisha/" target="_new"><img src="img/logo-facebook.png?version=1.1"/></a></div>
	      		<div class="logodiv"><a href="https://www.instagram.com/projectswadisha/" target="_new"><img src="img/logo-instagram.jpg"/></a></div>
	      		<div class="logodiv"><a href="https://twitter.com/projectswadisha/" target="_new"><img src="img/logo-twitter.png"/></a></div>
	      	</li>
	      </ul>
	      <?php endif; ?>
	      <ul class="nav navbar-nav navbar-right">
		    <li class="nav-link welcome"><a><span class="text" title="<?php echo $_SESSION['useremail'] ?>">Welcome, <?php echo $_SESSION['firstname'] ?></span></a></li>
		    <li class="nav-link"><a href="dashboard.php"><span class="text">Dashboard</span></a></li>
		    <li class="nav-link"><a href="logout.php"><span class="text">Logout</span></a></li>
	      </ul>
	    </div><!-- /.navbar-collapse -->
	   <?php endif; ?>
	  </div><!-- /.container-fluid -->
	</nav>

	<div id="content">
	<div class="container">
		<?php if(isset($_SESSION['useremail'])) : ?>

		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-6 landing test">
				<span class="boxtitle">Work Readiness Aptitude Predictor</span>
		        <div class="box" onclick="location.href='<?php if($_SESSION['sndtprogram']) echo 'sndtwrap.php'; else echo 'teststart.php'; ?>'">
		          	<p><a>Predict your work-readiness aptitude</a></p>
		          	If you know where you stand, you are one step ahead of the rest!<br>
		          	Confused about what path to take?<br> 
					Percentile based work-readiness with a mentorship and feedback session.<br>
					<ol type="1">	
						<li>Take the test</li>
						<li>Schedule a mentoring session</li>
					</ol>
		        </div>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-6 landing mock">
				<span class="boxtitle">Talerang Mock Interviews</span>
		        <div class="box" onclick="location.href='mock.php'">
		          	<p><a>Mock Interview with us</a></p>
		          	When it comes to interviews, practice makes perfect!<br>
					Personalized interview sessions with experts.
		        </div>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-6 landing mock">
				<span class="boxtitle">Skill Training</span>
		        <div class="box" onclick="location.href='skilltraining.php'">
		          	<p><a>Come learn with us</a></p>
		          	Confused between which career path to take? <br>Are you torn between the possibility of higher studies vs job vs entrepreneurship? <br>Take our quizzes here and get to know yourself better! Make informed decisions!<?php if($_SESSION['sndtprogram']) echo '<br>Measure your English Language skills' ?>
		        </div>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-6 landing test">
				<span class="boxtitle">Industry Connect</span>
		        <div class="box" onclick="location.href='industry.php'">
		          	<p><a>Sign-up!</a></p>
					On review, we will connect you with Talerang corporate partners for internships and jobs!<br>
					Submit references<br>
					Upload resume
		        </div>
			</div>
		</div>
		<script type="text/javascript">
			/*******************Start of LiveChat (www.livechatinc.com) code *******************/
		window.__lc = window.__lc || {};
		window.__lc.license = 8844576;
		(function() {
		  var lc = document.createElement('script'); lc.type = 'text/javascript'; lc.async = true;
		  lc.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'cdn.livechatinc.com/tracking.js';
		  var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(lc, s);
		})();
		/*******************************End of LiveChat code*******************************/
		</script>
		<?php else: ?>
			<div id="notsignedin">
				<div class="alert alert-warning">
					You are not signed in! Please <a href="index.php?signin" class="alert-link">Sign in</a> first
				</div>
			</div>
	    <?php endif ?>
	</div>
	<?php include 'footer.php' ?>
	</div>
	</div>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="js/landing.js" type="text/javascript"></script>
</body>
</html>