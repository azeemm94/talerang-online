<?php session_start(); 
      date_default_timezone_set('Asia/Kolkata'); 
      if(!isset($_SESSION['adminuser'])) { header('location:adminlogin.php'); exit(); }
      if(isset($_GET['user'])) $studentemail=$_GET['user'];
      else { header('location:adminreset.php'); exit(); }

      require 'connectsql.php';
      $sql="SELECT `id` FROM `results` WHERE `email`='$studentemail'";
      $studentfound=mysqli_num_rows(mysqli_query($DBcon,$sql));
      if(!$studentfound) { header('location:adminreset.php'); exit(); }
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="robots" content="index, follow">
	<title>Talerang Express | Dashboard</title>
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css?version=2.1" />
	<link rel="stylesheet" type="text/css" href="css/landingstyle.css" />
	<link rel="stylesheet" type="text/css" href="css/dashboard.css" />
    <?php include 'noscript.php' ?>
    <?php include 'jqueryload.php' ?>
	<style type="text/css">
		@media print  
		{
		    div.skillbar{
		        page-break-inside: avoid;
		    }
		    #page-title{
		    	padding: 0;
		    	margin: 0;
		    }
		}
	</style>
</head>
<?php 
?>
<body>

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

	    <!-- Collect the nav links, forms, and other content for toggling -->
	    
	    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	      <ul class="nav navbar-nav navbar-right">
	        <li class="nav-link welcome"><a><span>Admin</span></a></li>
	        <li class="nav-link"><a href="adminreset.php"><span>Back</span></a></li>
	        <li class="nav-link"><a href="adminlogout.php"><span>Logout</span></a></li>
	      </ul>
	    </div><!-- /.navbar-collapse -->
	  </div><!-- /.container-fluid -->
	</nav>

	<div id="content">

	<?php
	$email=$studentemail;
	require 'connectsql.php'; 
	$sql="SELECT * FROM `teststart` WHERE `email`='$email';";
	$result=mysqli_query($DBcon,$sql);
	$num_start=mysqli_num_rows($result);

	$sql="SELECT * FROM `results` WHERE `email`='$email';";
	$result=mysqli_query($DBcon,$sql);
	$num_result=mysqli_num_rows($result);
	$row=mysqli_fetch_assoc($result);
	?>

	<div class="ribbon container-fluid">
        <div class="container" id="middle">
            Admin Dashboard
        </div>
    </div>

		<div class="container-fluid section-title">
			<span id="page-title">Work Readiness Aptitude Predictor</span>
			<?php if($num_result): ?>
            	<button class="nav-link hidden-print print-button" id="print-button" onclick="printPage()">Print this report</button>
        	<?php endif ?>
		</div>
		<div class="container">
		<div class="row">

			<?php
				$var1=$row['lv1grade'];
				$var2=$row['lv2grade'];
				if(is_null($row['lv1grade'])) $lv1grade="Under review"; else $lv1grade=$row['lv1grade'];
				if(is_null($row['lv2grade'])) $lv2grade="Under review"; else $lv2grade=$row['lv1grade'];
				$gradelevel=explode(".",$row['gradelevel']);
				$gradecolor=array('0'=>"red",'1'=>"yellow",'2'=>"green");
		if($num_result): //if test given and completed
				 ?>
			<div class="col-md-12">
			<div id='results'>
				<div>
					<?php 
						require 'connectsql.php';
						$sql="SELECT `firstname`,`lastname` FROM `register` WHERE `email`='$email'";
						$result=mysqli_query($DBcon,$sql);
						$details=mysqli_fetch_assoc($result);
						echo "Name: ".$details['firstname']." ".$details['lastname'];

						$sql="SELECT `resulttime` FROM `results` WHERE `email`='$email';";
						$resulttime=mysqli_query($DBcon,$sql);
						$resulttime=mysqli_fetch_assoc($resulttime);
						$resulttime=strtotime($resulttime['resulttime']);

						$time=date('jS M, Y',$resulttime);
						$day=date('h:i A',$resulttime);
						$newtime=$time." at ".$day;
						echo "<br>Test Date: ".$newtime;
					 ?>
				</div>
				<li>
					<div class="skillbar clearfix" data-percent="<?php echo $row['avg'] ?>">
						<div class="skillbar-title"><span>Work Readiness</span></div>
						<div class="skillbar-bar"></div>
						<div class="skill-bar-percent"><?php echo $row['avg'] ?>%</div>
					</div>
			   </li>
				<b>Percentile rank is <?php echo $row['percentile'] ?>. </b>
				<ul id="results">
					<li>
						<div class="percentagealt">
							<hr>
							Self Belief: <?php echo $row['selfbelief']." %" ?>
						</div>
						<div class="skillbar clearfix" data-percent="<?php echo $row['selfbelief'] ?>">
							<div class="skillbar-title"><span>Self Belief</span></div>
							<div class="skillbar-bar <?php echo $gradecolor[$gradelevel[0]]?>"></div>
							<div class="skill-bar-percent"><?php echo $row['selfbelief'] ?>%</div>
						</div>
					</li>
					<li>
						<div class="percentagealt">
							<hr>
							Self Awareness: <?php echo $row['selfaware']." %" ?>
						</div>
						<div class="skillbar clearfix" data-percent="<?php echo $row['selfaware'] ?>">
							<div class="skillbar-title"><span>Self Awareness</span></div>
							<div class="skillbar-bar <?php echo $gradecolor[$gradelevel[1]]?>"></div>
							<div class="skill-bar-percent"><?php echo $row['selfaware'] ?>%</div>
						</div>
					</li>
					<li>
						<div class="percentagealt">
							<hr>
							Professionalism: <?php echo $row['professionalism']." %" ?>
						</div>
						<div class="skillbar clearfix" data-percent="<?php echo $row['professionalism'] ?>">
							<div class="skillbar-title"><span>Professionalism</span></div>
							<div class="skillbar-bar <?php echo $gradecolor[$gradelevel[2]]?>"></div>
							<div class="skill-bar-percent"><?php echo $row['professionalism'] ?>%</div>
						</div>
					</li>
					<li>
						<div class="percentagealt">
							<hr>
							Business Communication: <?php echo $row['businesscomm']." %" ?>
						</div>
						<div class="skillbar clearfix" data-percent="<?php echo $row['businesscomm'] ?>">
							<div class="skillbar-title"><span>Business Communication</span></div>
							<div class="skillbar-bar <?php echo $gradecolor[$gradelevel[3]]?>"></div>
							<div class="skill-bar-percent"><?php echo $row['businesscomm'] ?>%</div>
						</div>
					</li>
					<li>
						<div class="percentagealt">
							<hr>
							Professional Awareness: <?php echo $row['profaware']." %" ?>
						</div>
						<div class="skillbar clearfix" data-percent="<?php echo $row['profaware'] ?>">
							<div class="skillbar-title"><span>Professional Awareness</span></div>
							<div class="skillbar-bar <?php echo $gradecolor[$gradelevel[8]]?>"></div>
							<div class="skill-bar-percent"><?php echo $row['profaware'] ?>%</div>
						</div>
					</li>
					<li>
						<div class="percentagealt">
							<hr>
							Prioritization: <?php echo $row['prioritization']." %" ?>
						</div>
						<div class="skillbar clearfix" data-percent="<?php echo $row['prioritization'] ?>">
							<div class="skillbar-title"><span>Prioritization</span></div>
							<div class="skillbar-bar <?php echo $gradecolor[$gradelevel[4]]?>"></div>
							<div class="skill-bar-percent"><?php echo $row['prioritization'] ?>%</div>
						</div>
					</li>
					<li>
						<div class="percentagealt">
							<hr>
							Problem Solving: <?php echo $row['probsolve']." %" ?>
						</div>
						<div class="skillbar clearfix" data-percent="<?php echo $row['probsolve'] ?>">
							<div class="skillbar-title"><span>Problem Solving</span></div>
							<div class="skillbar-bar <?php echo $gradecolor[$gradelevel[5]]?>"></div>
							<div class="skill-bar-percent"><?php echo $row['probsolve'] ?>%</div>
						</div>
					</li>
					<li>
						<div class="percentagealt">
							<hr>
							Grammar: <?php echo $row['grammar']." %" ?>
						</div>
						<div class="skillbar clearfix" data-percent="<?php echo $row['grammar'] ?>">
							<div class="skillbar-title"><span>Grammar</span></div>
							<div class="skillbar-bar <?php echo $gradecolor[$gradelevel[6]]?>"></div>
							<div class="skill-bar-percent"><?php echo $row['grammar'] ?>%</div>
						</div>
					</li>
					<li>
						<div class="percentagealt">
							<hr>
							Ethics: <?php echo $row['ethics']." %" ?>
						</div>
						<div class="skillbar clearfix" data-percent="<?php echo $row['ethics'] ?>">
							<div class="skillbar-title"><span>Ethics</span></div>
							<div class="skillbar-bar <?php echo $gradecolor[$gradelevel[7]]?>"></div>
							<div class="skill-bar-percent"><?php echo $row['ethics'] ?>%</div>
						</div>
					</li>
				</ul>
				<div>
				<hr>
				Your Life Vision essay (What matters most to you and why?) grade is: <?php echo $lv1grade ?><br/>
				Your Life Vision essay (What is your plan for the next 3-5 years?) grade is: <?php echo $lv2grade ?><br/>
				</div>
			</div>
			</div> <!--close colmd12-->
		<?php elseif($num_start): ?>
			<div class="col-md-12 alt">
				<p>
					Results could not be calculated as you did not complete the test
				</p>
			</div>
		<?php else: ?>
			<div class="col-md-12 alt">
				<p>
					No test scores to show.
				</p>
			</div>
		<?php endif ?>
		</div>     <!--close row    -->
		</div>  <!-- close container -->

	</div> <!--close content -->
	<div class="hidden-print">
	<?php include 'footer.php' ?>
	</div>
</div> <!--close wrapper    -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<script type="text/javascript">
	jQuery('.skillbar').each(function(){
		var barwidth=jQuery(this).attr('data-percent')*0.6; //corresponds to bar width in results.css:59
	jQuery(this).find('.skillbar-bar').animate({ width: barwidth+"%"},1000);
});

function printPage()
{
    $('body').css("overflow", "initial");
	window.print();
}
</script>
</body>
</html>