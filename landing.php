<?php
session_start();
date_default_timezone_set('Asia/Kolkata');
if(isset($_SESSION['useremail']))
{
	require 'connectsql.php';
	$accountno=$_SESSION['accountno'];
	//Check if fees paid
	$sql="SELECT * FROM `feespaid` WHERE `accountno`='$accountno' AND `type`='Placement Express' AND `status`='SUCCESS';";
	$fees=mysqli_num_rows(mysqli_query($DBcon,$sql));

	//Check if WRAP given
	$sql="SELECT * FROM `results` WHERE `accountno`='$accountno';";
	$wrap=mysqli_num_rows(mysqli_query($DBcon,$sql));

	//Check if Skill selector given
	$sql="SELECT * FROM `skillselector` WHERE `accountno`='$accountno';";
	$skillselector=mysqli_num_rows(mysqli_query($DBcon,$sql));

	//Check if resume complete
	$sql="SELECT * FROM `resume` WHERE `resumeid`='$accountno';";
	$resumearr=mysqli_fetch_assoc(mysqli_query($DBcon,$sql));
	$resumests=array('personal'=>false,'education'=>false,'workex'=>false,'leader'=>false,'skills'=>false); //status of completion for each of the sections...updated below
	if($resumearr['firstname']!=""&&$resumearr['lastname']!=""&&$resumearr['mobileno']!=""&&$resumearr['email']!=""&&$resumearr['city']!=""&&$resumearr['country']!=""&&$resumearr['pincode']!="") 
	$resumests['personal']=true; //Personal complete
	if($resumearr['schoolname']!=""&&$resumearr['schoolcity']!=""&&$resumearr['schoolcourse']!=""&&$resumearr['schoolyear']!=""&&$resumearr['schoolmarks']!=""&&$resumearr['schoolname']!="")
	$resumests['education']=true; //Education complete
	if($resumearr['workcompany']!=""&&$resumearr['workdes']!=""&&$resumearr['workstart']!=""&&$resumearr['workend']!=""&&$resumearr['workresp']!="")
	$resumests['workex']=true; //Work ex complete
	if($resumearr['leadername']!=""&&$resumearr['leaderdesc']!="")
	$resumests['leader']=true; //leader complete
	if($resumearr['skills']!="")
	$resumests['skills']=true; // skills complete
	if($resumests['personal']==true && $resumests['education']==true && $resumests['workex']==true && $resumests['leader']==true && $resumests['skills']==true)
	$resumecmp=true;
	else $resumecmp=false;	

	//Check if project uploaded
	$sql="SELECT * FROM `fileupload` WHERE `accountno`='$accountno';";
	$project=mysqli_num_rows(mysqli_query($DBcon,$sql));
}

?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1" />
	<meta name="robots" content="index, follow">  
	<title>Talerang Express | Home</title>
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css?version=2.1">
	<link rel="stylesheet" type="text/css" href="css/landingstyle.css">
	<link rel="stylesheet" type="text/css" href="css/placement.css?<?php echo uniqid(); ?>">
	<!-- <link rel="stylesheet" type="text/css" href="css/adminstyle.css"> -->
	<?php include 'noscript.php' ?>
	<?php include 'jqueryload.php' ?>
	<script id="context" type="text/javascript" src="https://context.citruspay.com/static/kiwi/app-js/icp.min.js"></script>
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
      <img alt="Talerang" src="img/logoexpress.jpg">
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
   <?php if(isset($_SESSION['useremail'])): ?>
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav navbar-right">
	    <li class="nav-link welcome"><a><span class="text">Welcome, <?php echo $_SESSION['firstname'] ?></span></a></li>
	    <li class="nav-link"><a href="dashboard.php"><span class="text">Dashboard</span></a></li>
	    <!-- <li class="nav-link"><a href="landing.php"><span class="text">Back</span></a></li> -->
	    <li class="nav-link"><a href="logout.php"><span class="text">Logout</span></a></li>
      
      </ul>
    </div><!-- /.navbar-collapse -->
   <?php endif; ?>
  </div><!-- /.container-fluid -->
</nav>

<div id="content">
<?php 
// $fees=true;
if(!$fees): ?>
	<div class="ribbon container-fluid" style="margin-bottom: 15px;">
	    <div class="container" id="middle">
	        Course Outline
	    </div>
	</div>
<?php endif; ?>

<div class="container">
	<?php 	
	if(isset($_SESSION['useremail'])){
		/*echo 'WRAP - '.$wrap.'<br>';
		echo 'skillselector - '.$skillselector.'<br>';
		echo 'Resume - '.$resumecmp.'<br>';
		echo 'Project - '.$project.'<br>';*/
	?>
	<div class="row">
		<?php 
		$orderAmount = "6000.00"; //order amount for Placement Express in INR
		$returnUrl='http://www.talerang.com/express/landing.php';
		$paymenttype='Placement Express';
		include 'citrus-pay.php';
		if(!$fees):

			//Check if coupon code is entered
			if (isset($_POST['submit-coupon'])) 
			{
				require 'connectsql.php';
				$ccode=trim(strtoupper($_POST['ccode']));
				$sql="SELECT `id` FROM `couponcodes` WHERE `code`='$ccode' AND `used`='0';";
				$notused=mysqli_num_rows(mysqli_query($DBcon,$sql));
				// echo $notused;	
				if($notused)
				{
					$sql="SELECT * FROM `register` WHERE `accountno`='$accountno';";
					$details=mysqli_fetch_assoc(mysqli_query($DBcon,$sql));
					$firstname=$details['firstname'];
					$lastname=$details['lastname'];
					$emailid=$details['email'];
		    		$paymenttime=date("Y-m-d h:i:sa");
					$couponcode='Coupon - '.$ccode;
					// echo var_dump($details);
					$sql="INSERT INTO `feespaid` (`accountno`,`firstname`,`lastname`,`email`,`status`,`transactionid`,`amount`,`paymenttime`,`type`) 
							VALUES ('$accountno','$firstname','$lastname','$emailid','SUCCESS','$couponcode','0.00','$paymenttime','Placement Express');";
					mysqli_query($DBcon,$sql);

					$sql="UPDATE `couponcodes` SET `email`='$emailid',`used`='1',`date`='$paymenttime' WHERE `code`='$ccode';";
					mysqli_query($DBcon,$sql);
					header('location:landing.php');
				}
				else
				{
					?>
					<div class="alert alert-danger">
						This coupon code is invalid or has already been used. Please try again
					</div>
					<?php 
				}
			}
		?>
		<div class="col-md-12">
			<div class="desc">
				<ul style="margin-bottom: 0;">
					<li>
						<b>Step 1A: Take Work Readiness Aptitude Predictor (WRAP)</b>
						<div>
							Our WRAP is a widely recognized assessment developed from our research with over 100 companies and 20,000 students. WRAP determines where you stand and helps evaluate your areas of development. It is the first assessment of its kind that focuses on both your hard and soft skills. It will accurately predict how work-ready you are.
						</div>
					</li>
					<li>
						<b>Step 1B: Skill Track Selector</b>
						<div>
							Our powerful skill selection tool - Skill Track Selector helps you determine and understand the skills and competencies that are right for you. Our skill-tracks range from marketing to finance to design. You can also pick from a variety of simulated projects and ideas to decide which skill tracks to pursue!
						</div>
					</li>
					<li>
						<b>Step 2A: Undergo Specialized Trainings</b>
						<div>
							Our trainings set-us apart from the rest. Our training is structured to introduce you to 6 core competencies and 1 skill-track required for work readiness. Competencies include self-awareness, life vision, communication, working smart, first impressions and bridge to career. Our interactive training with live participation will connect you to students across the globe with different perspectives thus gaining - a shared learning experience.
						</div>
					</li>
					<li>
						<b>Step 2B: Experience Immersive/Live Project</b>
						<div>
							Once you have identified and developed your competencies and skill track, strengthen your application by working on a relevant simulation project. This gives you practical exposure to your skill area and helps you advance quickly in your career.
						</div>
					</li>
					<li>
						<b>Step 3: Develop your Resume</b>
						<div>
							We have redefined the art of resume making with our one-of its kind tool. This will make resume building a hassle free process. You can now get your resume ready in minutes with continuous support from our team. This document will then be showcased to potential employers for placement.
						</div>
					</li>
					<li>
						<b>Step 4: Get Personalized Coaching</b>
						<div>
							Our program is designed to be adaptive focussing on individual needs and personalised feedback at each step. You get feedback on your project and your resume from our mentor panel. You can also schedule a demo interview with us. Your performance will be critiqued which will help you understand and mitigate weaknesses. Most importantly we will enable you to optimize your strengths.
						</div>
					</li>
					<li>
						<b>Step 5: Earn Certificates and Recommendation</b>
						<div>
							Earn your certificate from Talerang and a recommendation letter with your strengths and development areas.
						</div>
					</li>
					<li>
						<b>Step 6: Qualify for Industry Connect </b>
						<div>
							Certified Students are connected to our corporate partners for internships and jobs!
						</div>
					</li>
				</ul>
				<div class="clearfix"></div>
			</div>
		</div>

		<div class="col-md-6">
			<hr>
			<div class="title">
				<b>Pay Online</b>
				<?php if(isset($_POST['TxStatus']) && $_POST['TxStatus']=='SUCCESS'): ?>
					<div class="alert alert-success">
						We have successfully received payment of <?php echo 'Rs. '.$orderAmount; ?>
					</div>
					<div class="clearfix"></div>
				<?php endif; ?>
			</div>
			<div class="desc">
				<div>The price of this program is Rs. 6,000/-<br>Email <a href="mailto:support@talerang.com">support@talerang.com</a> for more information</div>
				<form method="post" action="landing.php" name="payment-form" id="citrus" style="margin-bottom: 0;">
					<input type="submit" name="submit-citrus" value="Pay here">
				</form>
			</div>
		</div>

		<div class="col-md-6">
			<hr>
			<div class="title">
				<b>Use Coupon Code</b>
			</div>
			<div class="desc">
				<form method="post" action="landing.php" name="coupon-form" id="coupon" style="margin-bottom: 0; margin-top: 0;">
					<div>
						Enter Code: <br>
						<input type="text" class="form-control" name="ccode" placeholder="Coupon Code" style="font-size: 24px; margin-top: 0; text-align: left;">
					</div>
					<input type="submit" name="submit-coupon" value="Use Coupon Code" style="width: auto;">
				</form>
			</div>
		</div>

		<?php else: //fees are paid or coupon code ?>
		<div class="col-md-12">
			<div class="week<?php echo ' unlocked'; if(!$wrap) echo ' incomplete'; else echo ' complete'; ?>">
				<div class="title">
					Step 1A - Work Readiness Aptitude Predictor			
<!-- 					<div class="locked">
	<span class="glyphicon glyphicon-lock"></span>
	<span>Locked</span>
</div> -->
					<div class="clearfix"></div>
				</div>
				<div class="desc">
					<?php if(!$wrap): ?>
			          	<div><a href="teststart.php">Predict your work-readiness aptitude</a></div>
			          	If you know where you stand, you are one step ahead of the rest!<br>
			          	Confused about what path to take?<br> 
						Percentile based work-readiness with a mentorship and feedback session
						<div class="clearfix"></div>
					<?php else: ?>
						<a href="dashboard.php">View your results</a>
					<?php endif; ?>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="week alternate<?php if($skillselector) echo ' complete'; else echo ' incomplete';if($wrap) echo ' unlocked'; else echo ' grey-locked'; ?>">
				<div class="title">
					Step 1B - Skill track selector
					<?php if(!$wrap): //unlocked if WRAP is complete ?>
						<div class="locked">
							<span class="glyphicon glyphicon-lock"></span>
							<span>Locked</span>
						</div>
						<div class="clearfix"></div>
					<?php endif; ?>
				</div>
				<div class="desc">
					<?php if(!$skillselector): ?>
						<?php if($wrap): ?><a href="skillselect.php"><?php endif; ?>Take the Skill-track selector assessment to find out which skill-track is apt for you!<?php if($wrap): ?></a><?php endif; ?>
					<?php else: ?>
						<a href="dashboard.php?skillselect">View your skills here</a>
					<?php endif; ?>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="week alternate<?php if($wrap&&$skillselector) echo ' complete unlocked'; else echo ' grey-locked'; ?>">
				<div class="title">
					Step 2A - Upskill through Interactive Training
					<?php if(!$wrap||!$skillselector): ?>
						<div class="locked">
							<span class="glyphicon glyphicon-lock"></span>
							<span>Locked</span>
						</div>
					<?php endif; ?>
					<div class="clearfix"></div>
				</div>
				<div class="desc">
					Receive interactive training through webinars to bridge your skill gap. You need to complete six trainings across the modules of self awareness and self-belief, life vision, perfect communication, working smart, first impressions and bridge to career to be oriented
					<?php if($wrap&&$skillselector): ?>
						<div>
							<a href="webinar.php">Click here to confirm webinars</a>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="week<?php if($skillselector) echo ' unlocked'; else echo ' grey-locked'; if($project) echo ' complete'; else echo ' incomplete'; ?>">
				<div class="title">
					Step 2B - Project Work
					<?php if(!$skillselector): //Unlocked if skill selector is complete ?>
						<div class="locked">
							<span class="glyphicon glyphicon-lock"></span>
							<span>Locked</span>
						</div>
						<div class="clearfix"></div>
					<?php endif; ?>
				</div>
				<div class="desc">
				<?php if(!$project): ?>
					Submit in-depth project work on the skill track that was selected by you in the previous week. (Submission) <?php if($skillselector): ?><a href="upload.php">Submit here</a><?php endif; ?>
				<?php else: ?>
					Thank you for submitting your project!<br>
					<a href="upload.php">Need to submit another file?</a>
				<?php endif; ?>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="week alternate<?php if($project) echo ' unlocked'; else echo ' grey-locked'; if($resumecmp) echo ' complete'; else echo ' incomplete';?>">
				<div class="title">
					Step 3 - Resume
					<?php if(!$project): //Unlocked if porject is submitted ?>
						<div class="locked">
							<span class="glyphicon glyphicon-lock"></span>
							<span>Locked</span>
						</div>
						<div class="clearfix"></div>
					<?php endif; ?>
				</div>
				<div class="desc">
					Make use of the Resume creator tool to build the perfect resume for yourself!
					<?php if($project): ?>
							<br><a href="resumecreate.php">Click here to continue</a>
					<?php endif; ?>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="week<?php if($resumecmp) echo ' unlocked'; else echo ' grey-locked'; if($resumecmp) echo ' complete'; ?>">
				<div class="title">
					Step 4 - Live session with Talerang
					<?php if(!$resumecmp): //Unlocked if resume is completed ?>
						<div class="locked">
							<span class="glyphicon glyphicon-lock"></span>
							<span>Locked</span>
						</div>
						<div class="clearfix"></div>
					<?php endif; ?>
				</div>
				<div class="desc">
					Get access to an exclusive mentoring session with Team Talerang! We provide feedback on the project you have worked on. You can then sign-up for a mock interview (20-30 minutes) using the portal.
				</div>
			</div>				
		</div>
		<div class="col-md-12">
			<div class="week alternate<?php if($resumecmp) echo ' unlocked'; else echo ' grey-locked'; if($resumecmp) echo ' complete'; ?>">
				<div class="title">
					Step 5 - Certification and Recommendation
					<?php if(!$resumecmp): //Unlocked if resume is completed ?>
						<div class="locked">
							<span class="glyphicon glyphicon-lock"></span>
							<span>Locked</span>
						</div>
						<div class="clearfix"></div>
					<?php endif; ?>
				</div>
				<div class="desc">
					Collect your certificate for completing this program
				</div>
			</div>				
		</div>
		<div class="col-md-12">
			<div class="week<?php if($resumecmp) echo ' unlocked'; else echo ' grey-locked'; if($resumecmp) echo ' incomplete'; ?>">
				<div class="title">
					Step 6 - Industry Connect
					<?php if(!$resumecmp): //Unlocked if resume is completed ?>
						<div class="locked">
							<span class="glyphicon glyphicon-lock"></span>
							<span>Locked</span>
						</div>
						<div class="clearfix"></div>
					<?php endif; ?>
				</div>
				<div class="desc">
					<?php if($resumecmp): ?>
						<a href="industry.php">Click here for Industry Connect</a><br>
					<?php endif; ?>
					You will be required to give us details for a reference check using Industry Connect (Submission).
				</div>
			</div>				
		</div>
		<?php endif; //endif feespaid? ?>
	</div>
	<?php }else{ //else isset session useremail  ?>
		<div id="notsignedin">
			<div class="alert alert-warning">
				You are not signed in! Please <a href="index.php?signin&pg=placement" class="alert-link">Sign in</a> first
			</div>
		</div>
	<?php }//endif isset session useremail ?>
</div> <!-- close container -->
</div> <!-- close content   -->

<?php include 'footer.php' ?>

</div><!--  close wrapper -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>