<!DOCTYPE html>
<html lang="EN">
<head>
    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/sndtformstyle.css?version=2.1">
	<link rel="stylesheet" type="text/css" href="css/landingstyle.css?version=1.1">
	<?php include 'jqueryload.php' ?>
	<title>Talerang Express | SNDT</title>
	<?php include 'noscript.php' ?>
</head>

<?php 
date_default_timezone_set('Asia/Kolkata');
require 'connectsql.php'; ?>

<body>
<?php include 'google-analytics.php'; ?>
<div id="wrapper">
<div class="container-fluid" style="padding-left: 0; padding-right: 0;">
	<div id="header">
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
		    <li class="nav-link welcome"><a><span>Welcome, <?php echo $_SESSION['firstname'] ?></span></a></li>
		    <li class="nav-link"><a href="logout.php"><span>Logout</span></a></li>
	      
	      </ul>
	    </div><!-- /.navbar-collapse -->
	   <?php endif; ?>
	  </div><!-- /.container-fluid -->
	</nav>
	</div>

<div id="content">

<div class="ribbon container-fluid">
    <div class="container" id="middle">
        SNDT Registration Form
    </div>
</div>

<div class="container-fluid" style="padding-right: 0; padding-left: 0;">
<div class="row" style="margin: 0;">
<div class="col-md-offset-3 col-md-6">

<?php 
if(isset($_POST['sndt-submit'])):

	$fname=ucwords(mysqli_real_escape_string($DBcon,trim(strtolower($_POST['fname']))));
	$lname=ucwords(mysqli_real_escape_string($DBcon,trim(strtolower($_POST['lname']))));
	$email=strtolower(mysqli_real_escape_string($DBcon,$_POST['email']));
	$encpassword=crypt($_POST['password']);
	$phone=$_POST['phone'];

	$sql="SELECT `email` FROM `register` WHERE `email`='$email'";
	$emails=mysqli_query($DBcon,$sql);
	$emails=mysqli_num_rows($emails);

	if($emails>0)
	{
		echo '<div class="alert alert-danger" style="font-size: 22px;">This email address has already been used to sign up! Please use another one.</div>';
	}
	else{
		$date=date("Y-m-d h:i:s a");
		$sndtreg=mysqli_real_escape_string($DBcon,$_POST['sndtreg']);

		if($_POST['college']!=="Other") $college=$_POST['college'];
		else $college="Other - ".mysqli_real_escape_string($DBcon,$_POST['college-other']);

		if($_POST['degree']!=="Other") $degree=$_POST['degree'];
		else $degree="Other - ".mysqli_real_escape_string($DBcon,$_POST['degree-other']);

		if($_POST['course']!=="Other") $course=$_POST['course'];
		else $course="Other - ".mysqli_real_escape_string($DBcon,$_POST['course-other']);

		if($_POST['year']!=="Other") $year=$_POST['year'];
		else $year="Other - ".mysqli_real_escape_string($DBcon,$_POST['year-other']);

		$job=$_POST['job'];

		$sk_arr=$_POST['skilltrack'];
		$skilltracks="";
		for ($i=0; $i <count($sk_arr) ; $i++) 
		{ 
			$skilltracks.=$sk_arr[$i];
			if($i<(count($sk_arr)-1))
				$skilltracks.=", ";
		}
		if(in_array("Other",$sk_arr))
			$skilltracks.=" - ".$_POST['skilltrack-other'];
		$skilltracks=mysqli_real_escape_string($DBcon,$skilltracks);
		$skillexp=mysqli_real_escape_string($DBcon,nl2br($_POST['skillexp']));
		$citypref=mysqli_real_escape_string($DBcon,ucfirst(strtolower($_POST['citypref'])));
		$salarypref=mysqli_real_escape_string($DBcon,$_POST['salarypref']);
		$lifegoals=mysqli_real_escape_string($DBcon,nl2br($_POST['lifegoals']));
		$extrainfo=mysqli_real_escape_string($DBcon,nl2br($_POST['extrainfo']));

		$hash=sha1(chr(rand(65,90)).chr(rand(65,90)).chr(rand(65,90)).chr(rand(65,90)).chr(rand(65,90)).chr(rand(65,90)));
		$link="http://www.talerang.com/express/verify.php?email=".$email."&hash=".$hash;
		$fullname=$fname." ".$lname;

		function getrandom()
        {
            $chars = "123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"; $res = "";
            for ($j=0;$j<10; $j++) $res .= $chars[mt_rand(0, strlen($chars)-1)];
            return $res;
        }
        function generate_id()
        {
            require 'connectsql.php';
            $notgenerated=true; $random="";

            while($notgenerated)
            {
                $random=getrandom(); 
                //Checks if ID isn't already in database
                if(! mysqli_num_rows(mysqli_query($DBcon,"SELECT `id` FROM `register` WHERE `accountno`='$random'")))
                {
                    if(! is_numeric($random))
                    $notgenerated=false;
                }
                
            }
            return $random;
        }
        $accountno=generate_id();

		$sql="INSERT INTO `register` (`firstname`,`lastname`,`email`,`password`,`country`,`phoneno`,`college`,`aboutus`,`regtime`,`hash`,`active`,`intro`,`accountno`)
				VALUES ('$fname','$lname','$email','$encpassword','India','$phone','SNDT University','SNDT - UNDP','$date','$hash','0','0','$accountno');";
		if (mysqli_query($DBcon, $sql))
		{
			$DBcon->close();
			$edusynch=true;
			require 'connectsql.php';
			$sql="INSERT INTO `register` (`firstname`,`lastname`,`email`,`password`,`country`,`college`,`aboutus`,`regtime`,`active`,`intro`,`accountno`)
					VALUES ('$fname','$lname','$email','$encpassword','India','SNDT University','SNDT - UNDP','$date','0','0','$accountno');";
			mysqli_query($EDcon,$sql);
			$EDcon->close();
			require 'connectsql.php';

			$sql="INSERT INTO `sndt` (`email`,`firstname`,`lastname`,`date`,`sndtreg`,`college`,`degree`,`course`,`year`,`job`,`skill`,`skillexp`,`city_pref`,`salary`,`lifegoals`,`extrainfo`,`accountno`)
				VALUES ('$email','$fname','$lname','$date','$sndtreg','$college','$degree','$course','$year','$job','$skilltracks','$skillexp','$citypref','$salarypref','$lifegoals','$extrainfo','$accountno');";
			mysqli_query($DBcon,$sql);

           	if(!in_array($_SERVER['REMOTE_ADDR'],array('127.0.0.1','::1')))   
            {  
				require("vendor/phpmailer/phpmailer/PHPMailerAutoload.php");
				try {
				    $mail = new PHPMailer(true);
				    $mail->IsSMTP(); // Using SMTP.
				    $mail->CharSet = 'utf-8';
				    $mail->Host = "smtp.gmail.com"; // SMTP server host.
				    $mail->SMTPSecure   = "ssl";
				    $mail->Port         =465;
				   // $mail->SMTPDebug = 2; // Enables SMTP debug information - SHOULD NOT be active on production servers!
				    $mail->SMTPAuth = true; // Enables SMTP authentication.

				    $mail->Username='support@talerang.com'; // SMTP account username example
				    $mail->Password='TalerangSupport2015';        // SMTP account password example
				    
				    $mail->SetFrom('support@talerang.com', 'Talerang Support Team');
				    $mail->AddReplyTo('support@talerang.com', 'Talerang Support Team');

				    //$fullname=$_SESSION['firstname']." ".$_SESSION['lastname'];
				    $mail->AddAddress($_POST['email'],$fullname); 
				    
				    $mail->Subject = 'Confirm your email address';
				    $mail->AddEmbeddedImage('img/logoemail.gif', 'logo');
				    //$mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
				    $emailbody="<!DOCTYPE html><html><head></head><body>Dear {$fullname},<br><br>Please <a href=\"{$link}\" target=\"new\">click here</a> to complete your registration and verify your account!<br><br>Regards,<br>Team Talerang<br><img src=\"cid:logo\" width=\"150px\"/></body></html>";

				    $mail->MsgHTML($emailbody);
				    $mail->Send();
				    // clear all addresses and attachments for the next mail
				    $mail->ClearAddresses();
				    $mail->ClearAttachments();
				    
				} catch (phpmailerException $e) {
				    echo $e->errorMessage(); 
				} catch (Exception $e) {
				    echo $e->getMessage(); 
				}
            }
       		
       		echo "<div class=\"alert alert-success\" style=\"font-size: 22px;\">You have been successfully registered. Please activate your account from the email sent to <b>{$_POST['email']}</b> and then sign in. Thank you!<br>If you cannot find the email please look in your junk/spam folder.</div>";
        }
    	else
	    	{
	    		echo '<div class="alert alert-danger">Oops! Something went wrong please try again.</div>';
	    		$thisemail=$_POST['email'];
	    		$sql="DELETE FROM `sndt` WHERE `email`='$thisemail';";
	    		mysqli_query($DBcon,$sql);

	    		$sql="DELETE FROM `regsiter` WHERE `email`='$thisemail';";
	    		mysqli_query($DBcon,$sql);
	    	} 
        }
endif;
?>
<!-- <h1 id="title">SNDT Registration Form<img src="img/boomerang.gif" alt="h1"></h1> -->
<div id="reqdfields">Fields marked with (*) are required</div>
<form method="post" id="sndt_registration">
	<div class="formfield">
		Please enter your name<span class="redstar">*</span>
		<div>
			<input type="text" class="form-control" name="fname" placeholder="First name"/>
			<input type="text" class="form-control" name="lname" placeholder="Last name" style="margin-top: 5px;" />
		</div>
	</div>
	<hr>
	<div class="formfield">
		Please enter your email address<span class="redstar">*</span>
		<input type="text" class="form-control" name="email" placeholder="Email address" id="email"/>
		<span id="email_status"></span>
	</div>
	<div class="formfield">
		Please enter a new password<span class="redstar">*</span>
		<input type="password" class="form-control" name="password" placeholder="Password" id="password" />
		<input type="password" class="form-control" name="passwordc" placeholder="Confirm Password" style="margin-top: 5px;"/>
	</div>
	<hr>
	<div class="formfield">
		Please enter your mobile number<span class="redstar">*</span>
		<!-- <input type="text" name="phone" placeholder="Mobile Number"/> -->
		<div class="input-group">
		  <span class="input-group-addon" id="ccode">+91</span>
		  <input type="text" class="form-control" name="phone" placeholder="Mobile Number" aria-describedby="ccode" id="mobno">
		</div>
		<label class="error" for="mobno"></label>
	</div>
	<hr>
	<div class="formfield">
		Please enter your SNDT Permanent Registration Number(PRN)
		<input type="text" class="form-control" name="sndtreg" placeholder="PRN"/>
	</div>
	<hr>
	<div class="formfield">
		Which college are you from?<span class="redstar">*</span>
		<select name="college" class="form-control">
		<option disabled="disabled" selected="selected" value="">--Select--</option>
		<option value="Aishabai College of Education, Byculla, Mumbai">Aishabai College of Education, Byculla, Mumbai</option>
		<option value="Anjuman-I-Islams, B.J.A.H. College of Home Science, Andheri, Mumbai">Anjuman-I-Islams, B.J.A.H. College of Home Science, Andheri, Mumbai</option>
		<option value="C.U. Shah College of Pharmacy, Santacruz, Mumbai">C.U. Shah College of Pharmacy, Santacruz, Mumbai</option>
		<option value="Centre for Distance Education, Juhu, Mumbai">Centre for Distance Education, Juhu, Mumbai</option>
		<option value="Centre of Special Education, Santacruz, Mumbai">Centre of Special Education, Santacruz, Mumbai</option>
		<option value="Department Of Commerce, Churchgate, Mumbai">Department Of Commerce, Churchgate, Mumbai</option>
		<option value="Department Of Commerce, Pune">Department Of Commerce, Pune</option>
		<option value="Department Of Drawing and Painting, Pune">Department Of Drawing and Painting, Pune</option>
		<option value="Department Of Economics, Churchgate, Mumbai">Department Of Economics, Churchgate, Mumbai</option>
		<option value="Department Of English, Churchgate, Mumbai">Department Of English, Churchgate, Mumbai</option>
		<option value="Department Of Extension Education, Juhu">Department Of Extension Education, Juhu</option>
		<option value="Department Of Food Science and Nutrition, Juhu">Department Of Food Science and Nutrition, Juhu</option>
		<option value="Department Of Geography, Pune">Department Of Geography, Pune</option>
		<option value="Department Of Gujrati, Churchgate, Mumbai">Department Of Gujrati, Churchgate, Mumbai</option>
		<option value="Department Of Hindi, Churchgate, Mumbai">Department Of Hindi, Churchgate, Mumbai</option>
		<option value="Department Of Hindi, Pune">Department Of Hindi, Pune</option>
		<option value="Department Of History, Churchgate, Mumbai">Department Of History, Churchgate, Mumbai</option>
		<option value="Department Of Human Development, Juhu">Department Of Human Development, Juhu</option>
		<option value="Department Of Marathi, Churchgate, Mumbai">Department Of Marathi, Churchgate, Mumbai</option>
		<option value="Department Of Marathi, Pune">Department Of Marathi, Pune</option>
		<option value="Department Of Music, Churchgate, Mumbai">Department Of Music, Churchgate, Mumbai</option>
		<option value="Department Of Music, Pune">Department Of Music, Pune</option>
		<option value="Department Of Political Science, Churchgate, Mumbai">Department Of Political Science, Churchgate, Mumbai</option>
		<option value="Department Of Psychology, Churchgate, Mumbai">Department Of Psychology, Churchgate, Mumbai</option>
		<option value="Department Of Psychology, Pune">Department Of Psychology, Pune</option>
		<option value="Department Of Resource Management, Juhu">Department Of Resource Management, Juhu</option>
		<option value="Department Of Sanskrit, Churchgate, Mumbai">Department Of Sanskrit, Churchgate, Mumbai</option>
		<option value="Department Of Social Work, Churchgate, Mumbai">Department Of Social Work, Churchgate, Mumbai</option>
		<option value="Department Of Sociology, Churchgate, Mumbai">Department Of Sociology, Churchgate, Mumbai</option>
		<option value="Department Of Textile Science and Apparel Design, Juhu">Department Of Textile Science and Apparel Design, Juhu</option>
		<option value="Department of Communication Media for Children, Pune">Department of Communication Media for Children, Pune</option>
		<option value="Department of Continuing and Adult Education, Churchgate">Department of Continuing and Adult Education, Churchgate</option>
		<option value="Department of Economics, Pune">Department of Economics, Pune</option>
		<option value="Department of Education Management, Juhu, Mumbai">Department of Education Management, Juhu, Mumbai</option>
		<option value="Department of Education, Mumbai">Department of Education, Mumbai</option>
		<option value="Department of Educational Technology, Juhu, Mumbai">Department of Educational Technology, Juhu, Mumbai</option>
		<option value="Dr. Bhanuben Mahendra Nanavati College of Home Science, Matunga, Mumbai">Dr. Bhanuben Mahendra Nanavati College of Home Science, Matunga, Mumbai</option>
		<option value="Dr. Smt. Nanavati Bhanuben Mahendra Womens College of Home Science, Ghatkopar">Dr. Smt. Nanavati Bhanuben Mahendra Womens College of Home Science, Ghatkopar</option>
		<option value="GAETs Pre School Teacher Training Centre, Goregaon-E, Mumbai">GAETs Pre School Teacher Training Centre, Goregaon-E, Mumbai</option>
		<option value="Jankidevi Bajaj Institute of Management Studies, Santacruz">Jankidevi Bajaj Institute of Management Studies, Santacruz</option>
		<option value="K.B.Joshi Institute of Information Technology Bachelor of Computer Application College">K.B.Joshi Institute of Information Technology Bachelor of Computer Application College</option>
		<option value="K.S.E.T. College of Computer Applications, Bhandup">K.S.E.T. College of Computer Applications, Bhandup</option>
		<option value="Kothari College of Management Studies, Mumbai">Kothari College of Management Studies, Mumbai</option>
		<option value="Kum. U.R. Shah Womens College of Commerce, Ghatkopar">Kum. U.R. Shah Womens College of Commerce, Ghatkopar</option>
		<option value="L.J.N.J. Mahila Mahavidyalaya, Vile-Parle(East), Mumbai">L.J.N.J. Mahila Mahavidyalaya, Vile-Parle(East), Mumbai</option>
		<option value="Leelabai Thackersey College of Nursing, Churchgate, Mumbai">Leelabai Thackersey College of Nursing, Churchgate, Mumbai</option>
		<option value="Maharshi Karve Stree Shikshan Samsthas School of Fashion Technology, Karve Nagar, Pune">Maharshi Karve Stree Shikshan Samsthas School of Fashion Technology, Karve Nagar, Pune</option>
		<option value="Maniben Nanavati Womens College, Vile-Parle (West)">Maniben Nanavati Womens College, Vile-Parle (West)</option>
		<option value="Mumbai B.Ed College for Women, Wadala, Mumbai">Mumbai B.Ed College for Women, Wadala, Mumbai</option>
		<option value="P.V.D.T. College of Education for Women, Churchgate, Mumbai">P.V.D.T. College of Education for Women, Churchgate, Mumbai</option>
		<option value="Post Graduate Department of Computer Science, Santacruz, Mumbai">Post Graduate Department of Computer Science, Santacruz, Mumbai</option>
		<option value="Rani Putalabai Womens Law College, Bhosari">Rani Putalabai Womens Law College, Bhosari</option>
		<option value="Research Centre for Womens Studies, Juhu, Mumbai">Research Centre for Womens Studies, Juhu, Mumbai</option>
		<option value="S.H.P.T. College of Science, Santacruz, Mumbai">S.H.P.T. College of Science, Santacruz, Mumbai</option>
		<option value="S.H.P.T. School of Library Science, Churchgate, Mumbai">S.H.P.T. School of Library Science, Churchgate, Mumbai</option>
		<option value="S.N.D.T. Arts and Commerce College for Women, Pune">S.N.D.T. Arts and Commerce College for Women, Pune</option>
		<option value="S.N.D.T. College of ARTS And SCB College of Commerce And Science For Women">S.N.D.T. College of ARTS And SCB College of Commerce And Science For Women</option>
		<option value="S.N.D.T. College of Education, Pune">S.N.D.T. College of Education, Pune</option>
		<option value="S.N.D.T. College of Home Science, Pune">S.N.D.T. College of Home Science, Pune</option>
		<option value="S.V.T. College of Home Science (Autonomous) Juhu, Mumbai">S.V.T. College of Home Science (Autonomous) Juhu, Mumbai</option>
		<option value="School of Law">School of Law</option>
		<option value="Shri M D Shah Mahila College of Arts and Commerce, Malad, Mumbai">Shri M D Shah Mahila College of Arts and Commerce, Malad, Mumbai</option>
		<option value="Sitaram Deora Institute of Management Studies, Mumbai">Sitaram Deora Institute of Management Studies, Mumbai</option>
		<option value="Smt. B.M. Ruia Mahila Mahavidyalaya, Gamdevi">Smt. B.M. Ruia Mahila Mahavidyalaya, Gamdevi</option>
		<option value="Smt. Jamnabai H. Wadhwa College of Technology, Mumbai">Smt. Jamnabai H. Wadhwa College of Technology, Mumbai</option>
		<option value="Smt. Kamlaben Gambhirchand Shah Law School, Matunga, Mumbai">Smt. Kamlaben Gambhirchand Shah Law School, Matunga, Mumbai</option>
		<option value="Smt. M.M.P. Shah Womens College of Arts and Commerce, Matunga, Mumbai">Smt. M.M.P. Shah Womens College of Arts and Commerce, Matunga, Mumbai</option>
		<option value="Smt. P.N. Doshi Womens College of Arts, Ghatkopar">Smt. P.N. Doshi Womens College of Arts, Ghatkopar</option>
		<option value="Usha Mittal Institute of Technology, Juhu, Mumbai">Usha Mittal Institute of Technology, Juhu, Mumbai</option>
		<option value="Other">Other</option>
		</select>
		<input type="text" class="form-control displaynone formfield" name="college-other" id="college-other" placeholder="Please enter other college" value=""/>
	</div>
	<hr>
	<div class="formfield">
		Are you pursuing an undergraduate or postgraduate degree?<span class="redstar">*</span>
		<br>
		<input type="radio" name="degree" value="Undergraduate" id="degree-ug"/><label for="degree-ug">Undergraduate</label>
		<input type="radio" name="degree" value="Postgraduate" id="degree-pg"/><label for="degree-pg">Postgraduate</label>
		<input type="radio" name="degree" value="Other" id="degree-other-radio"/><label for="degree-other-radio">Other</label><br>
		<input type="text" class="form-control displaynone" name="degree-other" id="degree-other" placeholder="Please enter other degree type"/>
		<label for="degree" class="error"></label>
		<label for="degree-other" class="error"></label>
	</div>
	<hr>
	<div class="formfield">
		Which course are you pursuing?<span class="redstar">*</span>
		<select name="course" class="form-control">
			<option disabled="disabled" selected="selected" value="">--Select--</option>
			<option value="B. Com.">B. Com.</option>
			<option value="B. Ed in Education">B. Ed in Education</option>
			<option value="B. Ed. Special Education (Learning Disability/Mental Retardation/Visual Impairment)">B. Ed. Special Education (Learning Disability/Mental Retardation/Visual Impairment)</option>
			<option value="B.A in Economics">B.A in Economics</option>
			<option value="B.A in English">B.A in English</option>
			<option value="B.A in Geography">B.A in Geography</option>
			<option value="B.A in Gujarati">B.A in Gujarati</option>
			<option value="B.A in Hindi">B.A in Hindi</option>
			<option value="B.A in History">B.A in History</option>
			<option value="B.A in Marathi">B.A in Marathi</option>
			<option value="B.A in Music">B.A in Music</option>
			<option value="B.A in Political Science">B.A in Political Science</option>
			<option value="B.A in Psychology">B.A in Psychology</option>
			<option value="B.A in Sanskrit">B.A in Sanskrit</option>
			<option value="B.A in Sociology">B.A in Sociology</option>
			<option value="B.Sc. in Chemistry">B.Sc. in Chemistry</option>
			<option value="B.Sc. in Extension Education">B.Sc. in Extension Education</option>
			<option value="B.Sc. in Extension Education">B.Sc. in Extension Education</option>
			<option value="B.Sc. in Food Science and Nutrition">B.Sc. in Food Science and Nutrition</option>
			<option value="B.Sc. in Human Development">B.Sc. in Human Development</option>
			<option value="B.Sc. in Information Technology">B.Sc. in Information Technology</option>
			<option value="B.Sc. in Physics">B.Sc. in Physics</option>
			<option value="B.Sc. in Resource Management">B.Sc. in Resource Management</option>
			<option value="B.Sc. in Textile Science">B.Sc. in Textile Science</option>
			<option value="B.Sc. in Zoology">B.Sc. in Zoology</option>
			<option value="Bachelor of Business Administration LLB">Bachelor of Business Administration LLB</option>
			<option value="Bachelor of Computer Applicaitions (B.C.A)">Bachelor of Computer Applicaitions (B.C.A)</option>
			<option value="Bachelor of Computer Science (B.Tech.)">Bachelor of Computer Science (B.Tech.)</option>
			<option value="Bachelor of Electronics &amp; Telecommunication (B.Tech.)">Bachelor of Electronics &amp; Telecommunication (B.Tech.)</option>
			<option value="Bachelor of Electronics (B.Tech.)">Bachelor of Electronics (B.Tech.)</option>
			<option value="Bachelor of Information Technology (B.Tech.)">Bachelor of Information Technology (B.Tech.)</option>
			<option value="Bachelor of Law (LL.B.)">Bachelor of Law (LL.B.)</option>
			<option value="Bachelor of Library &amp; Information Science (B.L.I.Sc.)">Bachelor of Library &amp; Information Science (B.L.I.Sc.)</option>
			<option value="Bachelor of Management Studies (B.M.S.)">Bachelor of Management Studies (B.M.S.)</option>
			<option value="Bachelor of Mass Media">Bachelor of Mass Media</option>
			<option value="Bachelor of Nursing (B.Sc.)">Bachelor of Nursing (B.Sc.)</option>
			<option value="Bachelor of Pharmacy (B.Pharm.)">Bachelor of Pharmacy (B.Pharm.)</option>
			<option value="Bachelor of Social Work (B.S.W)">Bachelor of Social Work (B.S.W)</option>
			<option value="Bachelor of Visual Arts (B.V.A)">Bachelor of Visual Arts (B.V.A)</option>
			<option value="M A Education (Full time)">M A Education (Full time)</option>
			<option value="M. Pharm - Herbal Drug Technology">M. Pharm - Herbal Drug Technology</option>
			<option value="M. Pharm in Pharmaceutics">M. Pharm in Pharmaceutics</option>
			<option value="M. Pharm in Quality Assurance">M. Pharm in Quality Assurance</option>
			<option value="M.A in Ancient Indian Culture">M.A in Ancient Indian Culture</option>
			<option value="M.A in English">M.A in English</option>
			<option value="M.A in Gujarati">M.A in Gujarati</option>
			<option value="M.A in Hindi">M.A in Hindi</option>
			<option value="M.A in Marathi">M.A in Marathi</option>
			<option value="M.A in Sanskrit">M.A in Sanskrit</option>
			<option value="M.A. in Applied Linguistics">M.A. in Applied Linguistics</option>
			<option value="M.A. in Career and Developmental Counselling">M.A. in Career and Developmental Counselling</option>
			<option value="M.A. in Economics">M.A. in Economics</option>
			<option value="M.A. in Educational Technology (MA ET)">M.A. in Educational Technology (MA ET)</option>
			<option value="M.A. in Geography">M.A. in Geography</option>
			<option value="M.A. in History">M.A. in History</option>
			<option value="M.A. in Inclusive Education">M.A. in Inclusive Education</option>
			<option value="M.A. in Music">M.A. in Music</option>
			<option value="M.A. in Non-Formal Education and Development">M.A. in Non-Formal Education and Development</option>
			<option value="M.A. in Political Science">M.A. in Political Science</option>
			<option value="M.A. in Psychology">M.A. in Psychology</option>
			<option value="M.A. in Social Exclusion &amp; Inclusive Policy">M.A. in Social Exclusion &amp; Inclusive Policy</option>
			<option value="M.A. in Social Work (MSW)">M.A. in Social Work (MSW)</option>
			<option value="M.A. in Sociology">M.A. in Sociology</option>
			<option value="M.A. in Women’s Studies">M.A. in Women’s Studies</option>
			<option value="M.Sc in Analytical Chemistry">M.Sc in Analytical Chemistry</option>
			<option value="M.Sc. in Clinical Nutrition and Dietetics">M.Sc. in Clinical Nutrition and Dietetics</option>
			<option value="M.Sc. in Communication Media for Children">M.Sc. in Communication Media for Children</option>
			<option value="M.Sc. in Computer Science">M.Sc. in Computer Science</option>
			<option value="M.Sc. in Early Childhood Education">M.Sc. in Early Childhood Education</option>
			<option value="M.Sc. in Family Resource Management">M.Sc. in Family Resource Management</option>
			<option value="M.Sc. in Human Development">M.Sc. in Human Development</option>
			<option value="M.Sc. in Interior Design">M.Sc. in Interior Design</option>
			<option value="M.Sc. in Nursing">M.Sc. in Nursing</option>
			<option value="M.Sc. in Nutrition &amp; Health Communication">M.Sc. in Nutrition &amp; Health Communication</option>
			<option value="M.Sc. in Nutrition and Food Processing">M.Sc. in Nutrition and Food Processing</option>
			<option value="M.Sc. in Resource Management and Ergonomics">M.Sc. in Resource Management and Ergonomics</option>
			<option value="M.Sc. in Textile Science and Apparel Design">M.Sc. in Textile Science and Apparel Design</option>
			<option value="M.Tech in Electronics and Communication">M.Tech in Electronics and Communication</option>
			<option value="Master in Computer Applications (M.C.A.)">Master in Computer Applications (M.C.A.)</option>
			<option value="Master in Education Management">Master in Education Management</option>
			<option value="Master in MBA – Retail Management">Master in MBA – Retail Management</option>
			<option value="Master in Management Studies (M.M.S.)">Master in Management Studies (M.M.S.)</option>
			<option value="Master of Commerce (M.Com.)">Master of Commerce (M.Com.)</option>
			<option value="Master of Education (Full time)">Master of Education (Full time)</option>
			<option value="Master of Education (Special Education)">Master of Education (Special Education)</option>
			<option value="Master of Law (LL.M)">Master of Law (LL.M)</option>
			<option value="Master of Library and Information Science (M.L.I.Sc.)">Master of Library and Information Science (M.L.I.Sc.)</option>
			<option value="Master of Personnel Management &amp; Industrial Relations (M.P.M.I.R)">Master of Personnel Management &amp; Industrial Relations (M.P.M.I.R)</option>
			<option value="Masters in Extension Education">Masters in Extension Education</option>
			<option value="Masters in Visual Arts (M.V.A.)">Masters in Visual Arts (M.V.A.)</option>
			<option value="Other">Other</option>
		</select>
		<input type="text" name="course-other" class="form-control displaynone formfield" id="course-other" placeholder="Please enter other course" value=""/>
	</div>
	<hr>
	<div class="formfield">
		Which year are you currently studying in?<span class="redstar">*</span>
		<br>
		<input type="radio" name="year" value="1" id="year-1"><label for="year-1">First Year</label>
		<input type="radio" name="year" value="2" id="year-2"><label for="year-2">Second Year</label>
		<input type="radio" name="year" value="3" id="year-3"><label for="year-3">Third Year</label>
		<input type="radio" name="year" value="4" id="year-4"><label for="year-4">Fourth Year</label>
		<input type="radio" name="year" value="5" id="year-5"><label for="year-5">Fifth Year</label>
		<input type="radio" name="year" value="Other" id="year-other-radio"><label for="year-other-radio">Other</label>
		<input type="text" name="year-other" placeholder="Please enter other year" class="displaynone formfield form-control" id="year-other"/>
		<br><label for="year" class="error"/>
	</div>
	<hr>
	<div class="formfield">
		Are you looking to get a job after you complete the course you are currently pursuing?<span class="redstar">*</span>
		<br>
		<input type="radio" name="job" value="Yes" id="job-yes"/><label for="job-yes">Yes</label>
		<input type="radio" name="job" value="No" id="job-no"/><label for="job-no">No</label>
		<input type="radio" name="job" value="Maybe" id="job-maybe"/><label for="job-maybe">Maybe</label>
		<br><label for="job" class="error"></label>
	</div>
	<hr>
	<div class="formfield">
		Which of the following skill tracks do you identify with the most?<span class="redstar">*</span> (select all that apply)
		<br>
		<div><input type="checkbox" name="skilltrack[]" value="Academia" id="skilltrack-1"><label for="skilltrack-1">Academia</label></div>
		<div><input type="checkbox" name="skilltrack[]" value="Business Operations" id="skilltrack-2"><label for="skilltrack-2">Business Operations</label></div>
		<div><input type="checkbox" name="skilltrack[]" value="Coding" id="skilltrack-3"><label for="skilltrack-3">Coding</label></div>
		<div><input type="checkbox" name="skilltrack[]" value="Data Analytics" id="skilltrack-4"><label for="skilltrack-4">Data Analytics</label></div>
		<div><input type="checkbox" name="skilltrack[]" value="Design" id="skilltrack-5"><label for="skilltrack-5">Design</label></div>
		<div><input type="checkbox" name="skilltrack[]" value="Entrepreneurship" id="skilltrack-6"><label for="skilltrack-6">Entrepreneurship</label></div>
		<div><input type="checkbox" name="skilltrack[]" value="Fashion" id="skilltrack-7"><label for="skilltrack-7">Fashion</label></div>
		<div><input type="checkbox" name="skilltrack[]" value="Marketing" id="skilltrack-8"><label for="skilltrack-8">Marketing</label></div>
		<div><input type="checkbox" name="skilltrack[]" value="Research" id="skilltrack-9"><label for="skilltrack-9">Research</label></div>
		<div><input type="checkbox" name="skilltrack[]" value="Sales" id="skilltrack-10"><label for="skilltrack-10">Sales</label></div>
		<div><input type="checkbox" name="skilltrack[]" value="Social Media Marketing" id="skilltrack-11"><label for="skilltrack-11">Social Media Marketing</label></div>
		<div><input type="checkbox" name="skilltrack[]" value="Strategy" id="skilltrack-12"><label for="skilltrack-12">Strategy</label></div>
		<div><input type="checkbox" name="skilltrack[]" value="Written Communications" id="skilltrack-13"><label for="skilltrack-13">Written Communications</label></div>
		<div><input type="checkbox" name="skilltrack[]" value="Other" id="skilltrack-othercheck"><label for="skilltrack-othercheck">Other</label></div>
		<div><input type="text" name="skilltrack-other" class="displaynone formfield form-control" placeholder="Other skill track" id="skilltrack-other"/></div>
		<div>
		<label for="skilltrack[]" class="error"></label>
		<label for="skilltrack-other" class="error"></label>
		</div>
		<div>
		Please explain why you chose this skill track (optional)
		<textarea class="form-control" name="skillexp" id="skillexp" placeholder=""></textarea>
		<label for="skillexp" class="error"></label>
		</div>
	</div>
	<hr>
	<div class="formfield">
		In which city would you like to do an internship?<span class="redstar">*</span>
		<input type="text" class="form-control" name="citypref" placeholder="">
	</div>
	<hr>
	<div class="formfield">
		What are your salary expectations?<span class="redstar">*</span>
		<input type="text" class="form-control" name="salarypref" placeholder="">
	</div>
	<hr>
	<div class="formfield">
		What are your life goals? (optional)
		<textarea class="form-control" name="lifegoals" placeholder=""></textarea>
	</div>
	<hr>
	<div class="formfield">
		Anything else you would like to share with us? (optional)
		<textarea class="form-control" name="extrainfo" placeholder=""></textarea>
	</div>
	<div class="formfield submit">
		<input type="submit" name="sndt-submit" id="submit" value="Submit">
	</div>
	<div style="text-align: center; margin-top: 10px;">
		<div>
			Follow Project Swadisha!
		</div>
		<div>
	  		<div class="logodiv"><a href="https://www.facebook.com/projectswadisha/" target="_new"><img src="img/logo-facebook.png?version=1.1"/></a></div>
	  		<div class="logodiv"><a href="https://www.instagram.com/projectswadisha/" target="_new"><img src="img/logo-instagram.jpg"/></a></div>
	  		<div class="logodiv"><a href="https://twitter.com/projectswadisha/" target="_new"><img src="img/logo-twitter.png"/></a></div>
  		</div>
  	</div>
</form>
</div>
</div> <!-- close row -->
</div> <!-- close container-fluid -->
</div> <!-- close content -->

<?php include 'footer.php' ?>
</div><!-- close container-fluid -->
</div> <!-- close wrapper -->

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.1/jquery.validate.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){

$('#email').keyup(function()
{
    var emailid=$(this).val();
    if(email)
    {
        $.ajax({
            type: 'post',
            url: 'checkemail.php',
            data: { email:emailid, },
            success: function (response) 
            {
                $('#email_status').html(response);
                if(response=="")
                { 
                    $('#email_status').css({'display':'none'});
                    return true; 
                }    
                else  
                { 
                    $('#email_status').css({'display':'inline-block'});
                    return false; 
                } 
            }
        });
    }
    else
    {
        $('#email_status').html();
        return false;
    }
});

$(function() {
    $('input[name="skilltrack[]"]').on('change', function() {
        if ($("#skilltrack-othercheck").is(':checked')) $('#skilltrack-other').stop().slideDown('fast');
        else $('#skilltrack-other').stop().slideUp('fast');
    });
});
$(function() {
    $('input[name="year"]').on('change', function() {
        if ($(this).val()=='Other') $('#year-other').stop().slideDown('fast');
        else $('#year-other').stop().slideUp('fast');
    });
});
$(function() {
    $('select[name="course"]').on('change', function() {
        if ($(this).val()=='Other') $('#course-other').stop().slideDown('fast');
        else $('#course-other').stop().slideUp('fast');
    });
});
$(function() {
    $('select[name="college"]').on('change', function() {
        if ($(this).val()=='Other') $('#college-other').stop().slideDown('fast');
        else $('#college-other').stop().slideUp('fast');
    });
});
$(function() {
    $('input[name="degree"]').on('change', function() {
        if ($(this).val()=='Other') $('#degree-other').stop().slideDown('fast');
        else  $('#degree-other').stop().slideUp('fast');
    });
});

jQuery.validator.addMethod("phoneno", function(value, element) {
  return this.optional(element) || /^(?:(?:\+|0{0,2})91(\s*[\ -]\s*)?|[0]?)?[789]\d{9}|(\d[ -]?){10}\d$/.test(value);
}, "Please enter a valid phone number");

/*$(function() {
    if($('#email').valid())
    	checkemail();
});
*/
$('#sndt_registration').validate({
	errorClass: 'error',
/*	errorPlacement: function(error,element) {
    return true;},*/
	rules: {
		'fname'		    : { required:true, maxlength: 40, },
		'lname'		    : { required:true, maxlength: 40, },
		'email'		    : { required:true, email: true, maxlength: 255, },
		'password'      : { required:true, minlength: 6 },
		'passwordc'     : { required:true, equalTo: "#password" },
		'phone'         : { required:true, phoneno: true },
	/*	'sndtreg'		: { required:true },*/
		'college'		: { required:true },
		'college-other'	: { required:true },
		'degree'		: { required:true },
		'degree-other'	: { required:true },
		'course'		: { required:true },
		'course-other'	: { required:true },
		'year'			: { required:true },
		'year-other'	: { required:true },
		'job'			: { required:true },
		'skilltrack[]'	: { required:true },
		'skilltrack-other'	: { required:true },
		/*'skillexp'	:     { required:true },*/
		'citypref'		: { required:true },
		'salarypref'	: { required:true },
	/*	'lifegoals'		: { required:true },*/
		'submit'		: { required:true },
	},
		messages: {
		'password'      : { minlength:"Password must be at least 6 characters long"},
		'passwordc'     : { equalTo:"Passwords do not match"},
	},

});

});//end document ready
</script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>