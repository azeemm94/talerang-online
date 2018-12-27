<?php session_start(); 
      date_default_timezone_set('Asia/Kolkata'); 
      $accountno="";
if(isset($_SESSION['accountno']))
{
	$accountno=$_SESSION['accountno'];
	$sql="SELECT `id` FROM `mockinterviews` WHERE `accountno`='$accountno';";
	require 'connectsql.php';
	$registered=mysqli_num_rows(mysqli_query($DBcon,$sql));

/*	$sql="SELECT `id` FROM `feespaid` WHERE `accountno`='$accountno' AND `type`='Mock interview' AND `status`='SUCCESS';";
	$paid=mysqli_num_rows(mysqli_query($DBcon,$sql));*/

	$sql="SELECT `id` FROM `feespaid` WHERE `accountno`='$accountno' AND `status`='SUCCESS' AND `type`='Placement Express';";
	$placementpaid=mysqli_num_rows(mysqli_query($DBcon,$sql));
}
?>
<?php 
if(isset($_POST['submit-mock']))
{
	require 'connectsql.php';

    $fullname=$_SESSION['firstname']." ".$_SESSION['lastname'];
    $email=$_SESSION['useremail'];
    $track=mysqli_real_escape_string($DBcon, nl2br($_POST['skill']));
    $grade10=mysqli_real_escape_string($DBcon,$_POST['grade10m']."/".$_POST['grade10t']);
    $grade12=mysqli_real_escape_string($DBcon,$_POST['grade12m']."/".$_POST['grade12t']);
    $leader=mysqli_real_escape_string($DBcon,nl2br($_POST['ldrex']));
    $work=mysqli_real_escape_string($DBcon,nl2br($_POST['workex']));
    if($_POST['mocktype']=='hrfit') $type="HR / Fit";
    if($_POST['mocktype']=='case') $type="Case";
    $type=mysqli_real_escape_string($DBcon,$type);
    if($_POST['intmode']=='phone') $mobileskype="Mobile:".$_POST['mobileno'];
    if($_POST['intmode']=='skype') $mobileskype="Skype:".$_POST['skypeid'];
    $mobileskype=mysqli_real_escape_string($DBcon,$mobileskype);
    $reason=mysqli_real_escape_string($DBcon, nl2br($_POST['skilldesc']));
    $accountno=mysqli_real_escape_string($DBcon,$_SESSION['accountno']);

    $sql="INSERT INTO `mockinterviews`(`accountno`,`fullname`,`email`,`track`,`type`,`grade10`,`grade12`,`lship`,`workex`,`mobileskype`,`extrainfo`)
    VALUES ('$accountno','$fullname','$email','$track','$type','$grade10','$grade12','$leader','$work','$mobileskype','$reason');";
    if(mysqli_query($DBcon,$sql)) 
    	header('location:mockform.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no"/>
    <meta name="robots" content="index, follow">
    <title>Talerang Express | Talerang Mock Interviews | Form</title>
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css?version=2.1" />
	<link rel="stylesheet" type="text/css" href="css/landingstyle.css" />
	<link rel="stylesheet" type="text/css" href="css/mockstyle.css?version=2.1" />
	<?php include 'jqueryload.php' ?>
	<script id="context" type="text/javascript" src="https://context.citruspay.com/static/kiwi/app-js/icp.min.js"></script>
	<?php include 'noscript.php' ?>
</head>
<body>
<?php include 'google-analytics.php'; 
if(isset($_POST['submit-citrus'])) //adding Citrus gateway
{
	if($_POST['interview-type']=='hrfit')
		$orderAmount = "500.00"; //order amount for HR/Fit Interview
	elseif($_POST['interview-type']=='case')
		$orderAmount = "700.00"; //order amount for Case Interview
}
$returnUrl='http://www.talerang.com/express/mockform.php';
$paymenttype='Mock Interview';
include 'citrus-pay.php';
?>
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
	      <a href="landing.php"><img alt="Talerang" src="img/logoexpress.jpg"></a>
	    </div>

	    <!-- Collect the nav links, forms, and other content for toggling -->
	    <?php if(isset($_SESSION['useremail'])): 
	    ?>
	    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	      <ul class="nav navbar-nav navbar-right">
	        <li class="nav-link welcome"><a><span>Signed in as <?php echo $_SESSION['firstname'] ?></span></a></li>
	        <li class="nav-link"><a href="mock.php"><span>Back</span></a></li>
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
		<?php if(!$registered):// not registered, fees not paid ?>
		<h3>Please fill in this form before signing up for a mock interview</h3>
			<form name="mockform" action="" method="post" id="mockform">
			<div>
				<?php isset($_GET['type'])? $type=$_GET['type'] : $type=""; ?>
				<label for="mocktype">Type of mock interview?</label><br>
				<select name="mocktype" class="form-control">
					<option value="hrfit" <?php if($type=='hrfit') echo 'selected'?>>HR/Fit interview<?php if(!$placementpaid): ?> (Rs. 500/-)<?php endif; ?></option>
					<option value="case" <?php if($type=='case') echo 'selected'?>>Case interview<?php if(!$placementpaid): ?> (Rs. 700/-)<?php endif; ?></option>
				</select>
			</div>
			<div class="fieldset">
				<label for="skill">What is the purpose of this interview?</label>
				<label for="skill" class="error"></label><br>
				<textarea name="skill" class="form-control"></textarea>
			</div>
			<div class="row" style="margin-bottom: 0;">
			<div class="col-md-12 col-sm-12 fieldset">
				<label for="grade10m">10th std. marks:</label>
				<div>
					<span>
						<input class="marks form-control" type="text" name="grade10m" id="grade10m" placeholder="Marks obtained">
						<label for="grade10m" class="error marks"></label>
					</span>
					<span>
						<input class="marks form-control" type="text" name="grade10t" id="grade10t" placeholder="Total Marks">
						<label for="grade10t" class="error marks"></label>
					</span>
				</div>
			</div>
			<div class="col-md-12 col-sm-12 fieldset">
				<label for="grade12m">12th std. marks:</label>
				<div>
					<span>
						<input class="marks form-control" type="text" name="grade12m" id="grade12m" placeholder="Marks obtained">
						<label for="grade12m" class="error marks"></label>
					</span>
					<span>
						<input class="marks form-control" type="text" name="grade12t" id="grade12t" placeholder="Total Marks">
						<label for="grade12t" class="error marks"></label>
					</span>
				</div>
			</div>
			</div>
			<div class="fieldset">
				<label for="ldrex">Leadership experience:</label>
				<label for="ldrex" class="error"></label><br>
				<textarea name="ldrex" placeholder="Leadership experiences / positions held in school or college (Club Event or Organization, Position, Duration, Responsibilities and Projects Undertaken)" class="form-control"></textarea>
			</div>
			<div class="fieldset">
				<label for="workex">Work experience:</label>
				<label for="workex" class="error"></label><br>
				<textarea name="workex" placeholder="Work / internship experience (Company, Position, Duration, Compensation, Responsibilities and Projects Undertaken)" class="form-control"></textarea>
			</div>
			<div class="fieldset">
				<label for="intmode">How would you like to do this interview?</label>
				<label for="intmode" class="error"></label><br>
				<span>
				<input type="radio" name="intmode" value="phone" id="intmode-phone"/>
				<label for="intmode-phone">Telephone</label>
				</span>
				<span>
				<input type="radio" name="intmode" value="skype" id="intmode-skype"/>
				<label for="intmode-skype">Skype</label>
				</span>
			</div>
			<div class="fieldset">
				<div id="mobileno" class="displaynone">
					<label for>Mobile No:</label>
					<input type="text" name="mobileno" class="form-control contact">
				</div>
				<div id="skypeid" class="displaynone">
					<label for>Skype ID:</label>
					<input type="text" name="skypeid" class="form-control contact">
				</div>
			</div>
			<div class="fieldset">
				<label for="skilldesc">Any other information that you would like to share with us? <span style="color:#aaa">(optional)</span></label><br>
				<textarea name="skilldesc" id="skilldesc" class="form-control"></textarea>
			</div>
			<div class="fieldset submit">
				<input type="submit" name="submit-mock" id="msubmit" value="Submit">
			</div>
			</form>
		<?php elseif(!($paid||$placementpaid))://registered, fees not paid 
			require 'connectsql.php';
			$sql="SELECT * FROM `mockinterviews` WHERE `accountno`='$accountno' LIMIT 1;";
			$details=mysqli_fetch_assoc(mysqli_query($DBcon,$sql));
			$interviewtype=$details['type'];
			if($interviewtype=='HR / Fit') $interviewtype='hrfit';
			if($interviewtype=='Case') $interviewtype='case';
		?>
			<div class="alert alert-success" style="margin-top: 20px;">
				You have been successfully registered for a mock interview
			</div>
			<form method="post" id="payment-mock" action="">
				<input class="displaynone" type="text" name="interview-type" value="<?php echo $interviewtype; ?>">
				<input type="submit" name="submit-citrus" value="Click here to checkout online" id="mock-citrus">
			</form>
		<?php elseif($paid): //fees paid and registered 
			require 'connectsql.php';
			$sql="SELECT `amount` FROM `feespaid` WHERE `accountno`='$accountno' AND `type`='Mock interview' AND `status`='SUCCESS' LIMIT 1;";
			$amount=mysqli_fetch_assoc(mysqli_query($DBcon,$sql));
			$amount=$amount['amount'];
		?>
			<div id="schedule">
                <div class="alert alert-success">We have successfully received a payment of Rs. <?php echo $amount ?><br><a href="mock.php" class="alert-link">Schedule your interview here</a></div>
			</div>
		<?php else: ?>
			<div id="schedule">
                <div class="alert alert-success"><a href="mock.php" class="alert-link">Schedule your interview here</a></div>
			</div>
		<?php endif; ?>
		</div> <!-- end container 1 -->
		<?php else: ?>
		<div id="notsignedin" class="container">
			<div class="alert alert-warning">
				You are not signed in! Please <a href="index.php?signin&pg=mockform" class="alert-link">Sign in</a> first
			</div>
			
		</div>
	    <?php endif; //end not signed in?>
	</div>
	<?php include 'footer.php' ?>
</div>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.1/jquery.validate.min.js"></script>
<script src="js/mockform.js"></script>
</body>
</html>