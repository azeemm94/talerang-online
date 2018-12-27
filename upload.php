<?php session_start();
date_default_timezone_set('Asia/Kolkata');
isset($_SESSION['accountno'])? $accountno=$_SESSION['accountno'] : $accountno="";
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1" />
	<meta name="robots" content="index, follow">  
	<title>Talerang Express | Submissions</title>
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css?version=2.1">
	<link rel="stylesheet" type="text/css" href="css/landingstyle.css?version=1.4">
	<?php include 'noscript.php' ?>
	<?php include 'jqueryload.php' ?>
	<style type="text/css">
		.form-field{
			margin-top: 10px;
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
		    <li class="nav-link"><a href="landing.php"><span class="text">Back</span></a></li>
		    <li class="nav-link"><a href="logout.php"><span class="text">Logout</span></a></li>
	      
	      </ul>
	    </div><!-- /.navbar-collapse -->
	   <?php endif; ?>
	  </div><!-- /.container-fluid -->
	</nav>

	<div class="ribbon container-fluid" style="margin-bottom: 10px;">
        <div class="container" id="middle">
            Submissions
        </div>
    </div>

	<div id="content">
	<div class="container">
	<?php
	if(isset($_SESSION['useremail'])){

	require 'connectsql.php';
	$sql="SELECT * FROM `fileupload` WHERE `accountno`='$accountno';";
	$result=mysqli_query($DBcon,$sql);
	if(mysqli_num_rows($result)){
	?>
	<div class="alert alert-info">
	<?php 
	while($row=mysqli_fetch_assoc($result))
	{
		$date=date('jS M, Y',strtotime($row['uploadtime']));
		$time=date('h:ia',strtotime($row['uploadtime']));
		$f_name=$row['filename'];
		echo '<div>We have received your file <b>'.$f_name.'</b> uploaded on <b>'.$date.'</b> at <b>'.$time.'</b></div>';
	}
	?>
	</div>
	<?php 
	}//endif mysqli num rows
	$fullname=$_SESSION['firstname'].' '.$_SESSION['lastname'];
	$allowed=array('xls','xlsx','doc','docx','rtf','ppt','pptx','pptm','pdf');
	$maxfilesize=10; //Max size in MB
	$maxfilesize*=1048576;
	if(isset($_POST['submit-upload']))
	{
		$file_name=$_FILES['file_upload']['name'];
		$file_size=$_FILES['file_upload']['size'];
		$file_tmp=$_FILES['file_upload']['tmp_name'];
		$file_type=$_FILES['file_upload']['type'];
		$file_ext=explode('.',$file_name);
		$file_ext=strtolower(end($file_ext));

		$submit_type=ucwords($_POST['submit-type']);
		$phperror="";

		if(!in_array($file_ext,$allowed)) 
			$phperror.="This file type is not allowed.<br>";

		if($file_size>$maxfilesize) 
			$phperror.="File too large, maximum size allowed is 10 MB.";

		if($phperror!="")
			echo '<div class="alert alert-danger">'.$phperror.'</div>';

		if($phperror=="")
		{
			include("vendor/phpmailer/phpmailer/PHPMailerAutoload.php");
			try 
			{
			    $mail = new PHPMailer(true);
			    $mail->IsSMTP(); // Using SMTP.
			    $mail->CharSet = 'utf-8';
			    $mail->Host = "smtp.gmail.com"; // SMTP server host.
			    $mail->SMTPSecure = "ssl";
			    $mail->Port = 465;
			    $mail->SMTPAuth = true; // Enables SMTP authentication.

			    $mail->Username='support@talerang.com'; // SMTP account username
			    $mail->Password='TalerangSupport2015';        // SMTP account password
			    
			    $mail->SetFrom('support@talerang.com', 'Talerang Support Team');
			    $mail->AddReplyTo('support@talerang.com', 'Talerang Support Team');
			    // $mail->AddAddress('azeem.talerang@gmail.com', 'Azeem Merchant'); 
			    $mail->AddAddress('homework@talerang.com', 'Homework Talerang'); 
			    // $mail->AddCC('srividhya@talerang.com','Srividhya Jayakumar');
			    //$mail->AddAddress('azeem_merchant999@hotmail.com', 'Azeem Merchant'); 
			    $fullname=$_SESSION['firstname'].' '.$_SESSION['lastname'];

			    $mail->AddAttachment($file_tmp,$file_name);
			    $mail->Subject = 'Project Upload - '.$fullname;
			    //$mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
			    $emailbody='<!DOCTYPE html><html><head></head><body>PFA<br><br>Student Name: '.$fullname.'<br><br>Submission type: '.$submit_type.'<br><br><div style="color: #aaaaaa;">Uploaded on Talerang Express</div></body></html>';

			    $mail->MsgHTML($emailbody);
			      
			    if(!$mail->Send())
			        echo '<div class="notif fail">Oops! Something went wrong please try again.</div>';
			    else
			    {
			    	require 'connectsql.php';
			    	$date=mysqli_real_escape_string($DBcon,date("Y-m-d h:i:sa")); 
			    	$fname=mysqli_real_escape_string($DBcon,$file_name);
			    	$uploadtype=mysqli_real_escape_string($DBcon,$_POST['submit-type']);
			    	$sql="INSERT INTO `fileupload` (`accountno`,`filename`,`uploadtype`,`uploadtime`) VALUES ('$accountno','$fname','$uploadtype','$date');";
			    	mysqli_query($DBcon,$sql);
			    	header('location:upload.php');
			    } 
			    
			} 
			catch (phpmailerException $e) { echo $e->errorMessage(); } 
			catch (Exception $e) { echo $e->getMessage(); }	
		}
	}
	 ?>
		<form method="post" action="upload.php" name="uploader" id="uploader" enctype="multipart/form-data">
			<div class="alert alert-warning">
				Please upload only the following file types: .pdf, .xls, .xlsx, .doc, .docx, .rtf, .ppt, .pptx, .pptm<br>
				Upload one file at a time
			</div>
			<div class="form-field">
				<input type="file" name="file_upload" style="width: 100%;">
			</div>
			<div class="form-field">
				<label for="submit-type">Type of submission:</label>
				<input type="radio" name="submit-type" value="project" id="submit-project">
				<label for="submit-project"><b>Project</b></label>
<!-- 				<input type="radio" name="submit-type" value="webinar" id="submit-webinar">
<label for="submit-webinar"><b>Webinar</b></label> -->
				<input type="radio" name="submit-type" value="resume" id="submit-resume">
				<label for="submit-resume"><b>Resume</b></label>
				<div><label for="submit-type" class="error"></label></div>
			</div>
			<div class="form-field">
				<label for="submit-upload" id="upload-button"><span class="glyphicon glyphicon-upload"></span>Upload</label>
				<input type="submit" name="submit-upload" value="Upload" class="displaynone" id="submit-upload">
			</div>
		</form>
	</div> <!-- close container -->
	</div> <!-- close content -->
	<?php } else { ?>
			<div id="notsignedin">
				<div class="alert alert-warning">
					You are not signed in! Please <a href="index.php?signin&pg=upload" class="alert-link">Sign in</a> first
				</div>
			</div>
	<?php } ?>

	<?php include 'footer.php' ?>

</div><!--  close wrapper -->

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.1/jquery.validate.min.js"></script>
<script type="text/javascript" src="js/jquery-validate-additionalmethods.js"></script>
<script>
$.validator.addMethod('filesize', function(value, element, param) {
    return this.optional(element) || (element.files[0].size <= param) 
});

$('#uploader').validate({
	rules:{
		'file_upload': 
		{ 
			required: true,
			extension: "<?php echo implode('|',$allowed) ?>",
			filesize: <?php echo $maxfilesize; ?>
		},
		'submit-type': { required:true }
	},
	messages: {
		'file_upload': 
		{ 
			require: 'This field is required',
			extension: 'This file extension is not allowed',
			filesize: 'Maximum size of 10MB only',
		}
	}
});
</script>
</body>
</html>