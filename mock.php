<?php session_start(); 
      date_default_timezone_set('Asia/Kolkata'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no"/>
    <meta name="robots" content="index, follow">
    <title>Talerang Express | Talerang Mock Interviews</title>
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css?version=2.1" />
	<link rel="stylesheet" type="text/css" href="css/landingstyle.css" />
	<link rel="stylesheet" type="text/css" href="css/mockstyle.css" />
	<?php include 'jqueryload.php' ?>
	<script id="context" type="text/javascript" src="https://context.citruspay.com/static/kiwi/app-js/icp.min.js"></script>
	<?php include 'noscript.php' ?>
</head>
<body>  
<?php include 'google-analytics.php'; ?>
<?php //echo "<table>";foreach ($_POST as $key => $value) echo "<tr><td>".$key."</td><td>".$value."</td></tr>"; echo "<tr><td>Flag</td><td>".$flag."</td></table>" ?>
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
	    <?php endif ?>
	  </div><!-- /.container-fluid -->
	</nav>

	<div id="content" class="container-fluid">
		<?php if(isset($_SESSION['useremail'])): ?>
		<div class="ribbon container-fluid">
            <div class="container" id="middle">
                Talerang Mock Interviews
            </div>
        </div>

		<div class="container-fluid" id="quote">
			<blockquote>80% of people fail their interviews due to fear<br>
			Don't fear, Talerang is here!</blockquote> 
		</div>
		<div class="container"><!--  container 1 -->
		<div class="row">
			<div class="col-md-12">
				<div id="intform">
					What kind of interview are we looking at?<br>
					<form method="post" action="" id="interview">
						<input type="radio" name="inttype" class="displaynone" id="inttype-1" value="hrfit"/>
						<label for="inttype-1">HR/Fit Interview</label>
						<input type="radio" name="inttype" class="displaynone" id="inttype-2" value="case"/>
						<label for="inttype-2">Case Interview</label>
					</form>
				</div>

				<div class="container displaynone" id="deschrfit">
				<div class="desc row">
					<div class="col-md-9 desc-col">
						<div class="desctitle">Description</div>
						<div class="descpara">
							Ever wondered why toppers don't always get the top job?<br>
							There is more to you than your academic grades and projects.<br>
							Employers want people who fit well into their culture. Young leaders whose personality matches their expectations.<br><br>
							Talerang will take you through practice questions that most companies expect you to answer with ease and ensure you are prepared!
						</div>
					</div>
					<div class="col-md-3 desc-col">
						<div class="desctitle">Time alotted</div>
						<div class="descpara">20 minutes</div>
					</div>
				</div> <!-- end row -->
				<div class="row mocklink">
				<div>
					<a href="mockform.php?type=hrfit" class="mocklink">Book a mock interview now!</a>
				</div>
				</div> <!-- end row -->
				</div> <!-- end container deschrfit -->
				<div class="container displaynone" id="desccase">
				<div class="desc row">
					<div class="col-md-9 desc-col">
						<div class="desctitle">Description</div>
						<div class="descpara">
							Ever wondered why companies take you through case studies in your interview?<br>
							Practical aspects of the theory you have studied have meaning.<br>
							Employers want people who can apply what they have learned in real world scenarios.<br><br>
							Talerang will take you through a practice case that most companies expect you to answer with ease and ensure you are prepared!
						</div>
					</div>
					<div class="col-md-3 desc-col">
						<div class="desctitle">Time alotted</div>
						<div class="descpara">30 minutes</div>
					</div>
				</div>
				<?php ?>
				<div class="row mocklink">
				<div>
					<a href="mockform.php?type=case" class="mocklink">Book a mock interview now!</a>
				</div>
				</div>
				</div>
			</div> <!-- end col-md-12 -->
		</div> <!-- end row -->
			<?php 
				if(isset($_SESSION['accountno'])) $accountno=$_SESSION['accountno'];
				else $accountno="";
				require 'connectsql.php';
				$sql="SELECT * FROM `feespaid` WHERE `accountno`='$accountno' AND `status`='SUCCESS' AND `type`='Mock interview' LIMIT 1;";

				$result=mysqli_query($DBcon,$sql);
				$paid=mysqli_num_rows($result);
				$result=mysqli_fetch_assoc($result);
				$amount=$result['amount'];

			?>
			<?php if($paid): ?>
			<div id="schedule">
                <div class="alert alert-success">We have successfully received a payment of Rs. <?php echo $amount ?></div>
                <div id="appointment">
					<a id="Setmore_button_iframe" style="float:none" href="https://my.setmore.com/bookingpage/5c7215d9-a912-4a20-8079-65bc54db67d6">Schedule your mock interview</a>
				</div>
			</div>
			<?php endif ?>
		</div> <!-- end container 1 -->
		<?php else: ?>
		<div id="notsignedin" class="container">
			<div class="alert alert-warning">
				You are not signed in! Please <a href="index.php?signin&pg=mock" class="alert-link">Sign in</a> first
			</div>
			
		</div>
	    <?php endif; //end not signed in?>
	</div>
	<?php include 'footer.php' ?>
</div>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="js/landing.js"></script>
<script id="setmore_script" type="text/javascript" src="https://my.setmore.com/js/iframe/setmore_iframe.js"></script>
</body>
</html>