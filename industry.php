<?php 
	session_start(); 
  	date_default_timezone_set('Asia/Kolkata'); 
  	require 'connectsql.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="robots" content="index, follow">
	<title>Talerang Express | Industry Connect</title>
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css?version=2.1" />
	<link rel="stylesheet" type="text/css" href="css/landingstyle.css" />
	<link rel="stylesheet" type="text/css" href="css/industry.css?version=1.1" />
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

	<div id="content">

	<div class="ribbon container-fluid">
        <div class="container" id="middle">
            Industry Connect
        </div>
    </div>

	<?php if(isset($_SESSION['useremail'])): 
		$email=$_SESSION['useremail'];
		require 'connectsql.php';
		$sql="SELECT `email` FROM `results` WHERE `email`='$email';";
		$wrapgiven=mysqli_num_rows(mysqli_query($DBcon,$sql));

		$accountno=$_SESSION['accountno'];
		$sql="SELECT `id` FROM `feespaid` WHERE `accountno`='$accountno' AND `status`='SUCCESS' AND `type`='Placement Express';";
		$placement=mysqli_num_rows(mysqli_query($DBcon,$sql));
		if($wrapgiven||$placement):
	?>

    <div class="container">
	    <div class="row">
	    	<div class="form-panel">
<?php 
	if(isset($_POST['submitref']))
	{	
		$email=$_SESSION['useremail'];
		require 'connectsql.php';
		$refname1=mysqli_real_escape_string($DBcon,$_POST['refname1']);
		$refemail1=mysqli_real_escape_string($DBcon,$_POST['refemail1']);
		$refmob1=mysqli_real_escape_string($DBcon,$_POST['refmob1']);
		$designation1=$_POST['refdesn1']." at ".$_POST['reforg1'];
		$designation1=mysqli_real_escape_string($DBcon,$designation1);

		$refname2=mysqli_real_escape_string($DBcon,$_POST['refname2']);
		$refemail2=mysqli_real_escape_string($DBcon,$_POST['refemail2']);
		$refmob2=mysqli_real_escape_string($DBcon,$_POST['refmob2']);
		$designation2=$_POST['refdesn2']." at ".$_POST['reforg2'];
		$designation2=mysqli_real_escape_string($DBcon,$designation2);
		
		$sql="INSERT INTO `refcontacts` (`fullname`,`contactemail`,`contactmobile`,`designation`,`email`)
					VALUES ('$refname1','$refemail1','$refmob1','$designation1','$accountno');
			INSERT INTO `refcontacts` (`fullname`,`contactemail`,`contactmobile`,`designation`,`email`)
					VALUES ('$refname2','$refemail2','$refmob2','$designation2','$accountno');";

		if(mysqli_multi_query($DBcon,$sql))
			echo '<div class="alert alert-success">Your references have been successfully submitted!</div>';
		else echo mysqli_error($DBcon);
	}
?>

	<h4>Step 1: Submit references</h4>
	<?php
	$accountno=$_SESSION['accountno'];
	$sql="SELECT `id` FROM `refcontacts` WHERE `email`='$accountno';";
	$refsubmitted=mysqli_num_rows(mysqli_query($DBcon,$sql));
	if(!$refsubmitted):
	?>
	<p>All fields are required. Two references are required for you to be eligible for Industry Connect</p>
		<div class="container">
		<div class="row">
		<form action="industry.php" method="post" name="reference" id="reference">	
			<div class="col-md-12">
				<p class="form-heading">Reference 1</p>	
				<div>
					<input type="text" name="refname1" class="form-control" placeholder="Full Name" id="refname1">
				</div>
				<div>
					<input type="text" name="refemail1" class="form-control" placeholder="Email address" id="refemail1">
				</div>
				<div>
					<input type="text" name="refmob1" class="form-control" placeholder="Mobile Number" id="refmob1">
				</div>
				<div>
					<input type="text" name="reforg1" class="form-control" placeholder="Organisation" id="reforg1">
				</div>
				<div>
					<input type="text" name="refdesn1" class="form-control" placeholder="Designation" id="refdesn1">
				</div>
			</div>
			<div class="col-md-12">
			<p class="form-heading">Reference 2</p>	
				<div>
					<input type="text" name="refname2" class="form-control" placeholder="Full Name" id="refname2">
				</div>
				<div>
					<input type="text" name="refemail2" class="form-control" placeholder="Email address" id="refemail2">
				</div>
				<div>
					<input type="text" name="refmob2" class="form-control" placeholder="Mobile Number" id="refmob2">
				</div>
				<div>
					<input type="text" name="reforg2" class="form-control" placeholder="Organisation" id="reforg2">
				</div>
				<div>
					<input type="text" name="refdesn2" class="form-control" placeholder="Designation" id="refdesn2">
				</div>
			</div>
			<div class="col-md-12">
				<input type="submit" name="submitref" id="submitref">
			</div>
		</form>
		</div>
		</div>
	<?php else: ?>
		<div class="alert alert-success">Your references have been successfully submitted!</div>
	<?php endif; ?>
	</div> <!-- end form-panel -->
	
	<div class="form-panel">
	<h4>Step 2: Upload resume (optional)</h4>
	
	<?php 
	$resumeuploaded=false;
	$filename="../talerangexpress_resumes/".$_SESSION['useremail']."_".$_SESSION['firstname']." ".$_SESSION['lastname']."_Resume.";
	if(file_exists($filename."pdf")||file_exists($filename."doc")||file_exists($filename."docx"))
		$resumeuploaded=true;

	require 'connectsql.php';
	$email=$_SESSION['useremail'];
	$sql="SELECT `email` FROM `industryfiles` WHERE `email`='$email' AND `type`='Resume / CV';";
	$resumedb=mysqli_num_rows(mysqli_query($DBcon,$sql));
	if($resumedb) $resumeuploaded=true;

    $file_error="";
    if(isset($_POST['file-submit']))
    {
	    $target_dir="../talerangexpress_resumes/";
	    $filename_user=basename($_FILES["fileToUpload"]["name"]);
		$docFileType=pathinfo($filename_user,PATHINFO_EXTENSION);

		$target_file = $target_dir . $_SESSION['useremail'] ."_". $_SESSION['firstname'] ." ". $_SESSION['lastname']."_Resume.".$docFileType;
		// Check file size
		$maxSize=1; //in MB
		$maxSize*=1024*1024;

		if ($_FILES['fileToUpload']['size'] > $maxSize) 
			$file_error.="Sorry, your file is too large. Please upload a file under 1MB in size.<br>";
		// Allow certain file formats
		if(!in_array($docFileType,array("doc","docx","pdf","DOC","DOCX","PDF")))
			$file_error.="Sorry, only PDF, doc and docx files are allowed<br>";
		
		if($file_error=="")
		{
		    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) 
		    	{
		    		echo "<div class=\"notif success\">The file <b>". basename( $_FILES["fileToUpload"]["name"]). "</b> has been uploaded.</div>";
		    		$email=$_SESSION['useremail'];
		    		$name=$_SESSION['firstname']." ".$_SESSION['lastname'];
		    		$date=date("Y-m-d h:i:sa");
		    		$sql="INSERT INTO `industryfiles` (`email`,`name`,`type`,`link`,`date`)
		    				VALUES ('$email','$name','Resume / CV','$filename_user','$date');";
		    		require 'connectsql.php';
		    		mysqli_query($DBcon,$sql);
		    	}
		    else echo "Sorry, there was an error uploading your file";
		}
    }
	?>
	<?php if(!$resumeuploaded): ?>
	    <form action="industry.php" method="post" enctype="multipart/form-data" name="resumeUpload" id="resumeUpload">
		    <p class="form-heading">Please upload your resume / CV</p>
		    <div class="instructions">(Max file size 1mb. Pdf, doc or docx type only):</div>
		    <input type="file" name="fileToUpload" id="fileToUpload" accept="application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/pdf">
		    <input type="submit" value="Upload resume" name="file-submit" id="file-submit">
		    <div>
			    <div class="phperror"><?php if(isset($_POST['file-submit'])) echo $file_error; ?></div>
			    <label for="fileToUpload" class="error"></label>
		    </div>
		</form>
	<?php else: ?>
			<div class="alert alert-success">Your resume has been received</div>
	<?php endif; ?>
	</div>
		<div class="form-panel">
		<?php 
		if(isset($_POST['submit-video']))
		{
			$video_link=$_POST['video-link'];
			$email=$_SESSION['useremail'];
    		$name=$_SESSION['firstname']." ".$_SESSION['lastname'];
    		$date=date("Y-m-d h:i:sa");
			$sql="INSERT INTO `industryfiles` (`email`,`name`,`type`,`link`,`date`)
					VALUES ('$email','$name','Video','$video_link','$date')";
			mysqli_query($DBcon,$sql);
		}
		?>
			<h4>Step 3: Video essay (optional)</h4>
			<?php 
			require 'connectsql.php';
			$sql="SELECT `email` FROM `industryfiles` WHERE `email`='$email' AND type='Video';";
			$videouploaded=mysqli_num_rows(mysqli_query($DBcon,$sql));
			if(!$videouploaded){
			?>
			<form method="post" id="video" name="video">
				<p class="form-heading">Link to video</p>
				<div class="instructions">Upload a video telling us more about yourself to YouTube or Google Drive and insert the link here:
					<div>
						<a href="pdf/Introductory_Video_Upload_Instructions.pdf">Click here for more instructions</a>
					</div>
				</div>
				<input type="text" class="form-control" name="video-link" id="video-link" placeholder="Eg: https://www.youtube.com/watch?v=dQw4w9WgXcQ">
				<input type="submit" name="submit-video" id="submit-video" value="Submit">
				<br><label for="video-link" class="error"></label>
			</form>
			<?php } else { ?>
			<div class="alert alert-success">Your video link has been received</div>
			<?php } ?>
		</div>
		</div>
	</div>

	<?php  
	else: //wrapnotgiven
	?>
	<div class="container">
		<div class="row">
			<div class="alert alert-warning" role="alert">
				You must complete the <a href="teststart.php" class="alert-link">Work Readiness Aptitude Predictor (WRAP)</a> in order to unlock Industry Connect
			</div>
		</div>
		<div class="row">
			<div class="col-md-4 industrylock">
				<div class="industryimg"><img src="img/reference.jpg"></div>
				Step 1: <br>Submit two references
			</div>
			<div class="col-md-4 industrylock">
				<div class="industryimg"><img src="img/resume.jpg"></div>
				Step 2: <br>Submit Resume and video essay (optional)
			</div>
			<div class="col-md-4 industrylock">
				<div class="industryimg"><img src="img/job_internship.jpg"></div>
				Step 3: <br>Get connected for internships and full time offers
			</div>
		</div>
	</div>
	<?php
	endif; //wrapgiven? ?>
	<div class="container" id="corporate-partners">
		<h1>Our partner companies</h1>
		<div class="row">
			<div class="col-md-2 col-sm-4 col-xs-4">
				<div class="industry-partner">
					<a href="http://www.adityabirla.com/home" target="new">
						<img src="img/logos/aditya-birla-group.jpg" alt="Aditya Birla Group" class="connectlogo">
					</a>
				</div>
			</div>
			<div class="col-md-2 col-sm-4 col-xs-4">
				<div class="industry-partner">
					<a href="http://www.mahindrapartners.com/about-us.html" target="new">
						<img src="img/logos/mahindra.jpg" alt="Mahindra Partners" class="connectlogo">
					</a>
				</div>
			</div>
			<div class="col-md-2 col-sm-4 col-xs-4">
				<div class="industry-partner">
					<a href="http://www.godrej.com/GodrejIndustries/index.aspx?id=12" target="new">
						<img src="img/logos/godrej.png" alt="Godrej" class="connectlogo">
					</a>
				</div>
			</div>
			<div class="col-md-2 col-sm-4 col-xs-4">
				<div class="industry-partner">
					<a href="http://www.hbs.edu/global/faculty-research/research-centers/Pages/india.aspx" target="new">
						<img src="img/logos/HBSRC.jpg" alt="Harvard Business School - India Research Center" class="connectlogo">
					</a>
				</div>
			</div>
			<div class="col-md-2 col-sm-4 col-xs-4">
				<div class="industry-partner">
					<a href="https://hbr.org/contact-us-india-office" target="new">
						<img src="img/logos/hb-publishing.jpg" alt="Harvard Business Publishing" class="connectlogo">
					</a>
				</div>
			</div>
			<div class="col-md-2 col-sm-4 col-xs-4">
				<div class="industry-partner">
					<a href="http://www.aon.com/default.jsp" target="new">
						<img src="img/logos/AON.png" alt="AON Hewitt" class="connectlogo">
					</a>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-2 col-sm-4 col-xs-4">
				<div class="industry-partner">
					<a href="http://www.foxymoron.in/" target="new">
						<img src="img/logos/foxymoron.jpg" alt="Foxymoron" class="connectlogo">
					</a>
				</div>
			</div>
			<div class="col-md-2 col-sm-4 col-xs-4">
				<div class="industry-partner">
					<a href="http://www.delhivery.com/" target="new">
						<img src="img/logos/delhivery.jpg" alt="Delhivery" class="connectlogo">
					</a>
				</div>
			</div>
			<div class="col-md-2 col-sm-4 col-xs-4">
				<div class="industry-partner">
					<a href="http://www.harley-davidson.com/content/h-d/en_IN/home.html" target="new">
						<img src="img/logos/harley-davidson.png" alt="Harley Davidson" class="connectlogo">
					</a>
				</div>
			</div>
			<div class="col-md-2 col-sm-4 col-xs-4">
				<div class="industry-partner">
					<a href="http://www.ashoka.edu.in/" target="new">
						<img src="img/logos/ashoka-university.png" alt="Ashoka University" class="connectlogo">
					</a>
				</div>
			</div>
			<div class="col-md-2 col-sm-4 col-xs-4">
				<div class="industry-partner">
					<a href="http://www.direxions.com/" target="new">
						<img src="img/logos/direxions.png" alt="Direxions" class="connectlogo">
					</a>
				</div>
			</div>
			<div class="col-md-2 col-sm-4 col-xs-4">
				<div class="industry-partner">
					<a href="http://humancircle.in/" target="new">
						<img src="img/logos/human-circle.png" alt="Human Circle" class="connectlogo">
					</a>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-2 col-sm-4 col-xs-4">
				<div class="industry-partner">
					<a href="http://www.icfn.in/" target="new">
						<img src="img/logos/india-cares-foundation.png" alt="India Cares Foundation" class="connectlogo">
					</a>
				</div>
			</div>
			<div class="col-md-2 col-sm-4 col-xs-4">
				<div class="industry-partner">
					<a href="https://www.jobsforher.com/" target="new">
						<img src="img/logos/jobsforher.png" alt="Jobs For Her" class="connectlogo">
					</a>
				</div>
			</div>
			<div class="col-md-2 col-sm-4 col-xs-4">
				<div class="industry-partner">
					<a href="http://kingslearning.in/" target="new">
						<img src="img/logos/kings-learning.jpg" alt="Kings Learning" class="connectlogo">
					</a>
				</div>
			</div>
			<div class="col-md-2 col-sm-4 col-xs-4">
				<div class="industry-partner">
					<a href="http://www.lenskart.com/" target="new">
						<img src="img/logos/Lenskart.jpg" alt="Lenskart" class="connectlogo">
					</a>
				</div>
			</div>
			<div class="col-md-2 col-sm-4 col-xs-4">
				<div class="industry-partner">
					<a href="http://www.asappinfoglobal.com/" target="new">
						<img src="img/logos/ASAPP.png" alt="ASAPP Media" class="connectlogo">
					</a>
				</div>
			</div>
			<div class="col-md-2 col-sm-4 col-xs-4">
				<div class="industry-partner">
					<a href="http://www.myglamm.com/" target="new">
						<img src="img/logos/my-glamm.jpg" alt="MyGlamm" class="connectlogo">
					</a>
				</div>
			</div>
		</div>
	</div>
		
	<?php else: ?>
		<div class="container" id="notsignedin">
			<div class="alert alert-warning">
				You are not signed in! Please <a href="index.php?signin&pg=industry" class="alert-link">Sign in</a> first
			</div>
			
		</div>
	<?php endif;  ?>
	</div> <!--close content -->

	<?php include 'footer.php' ?>
</div> <!--close wrapper    -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.1/jquery.validate.min.js"></script>
<script src="js/jquery-validate-additionalmethods.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/industry.js"></script>
</body>
</html>