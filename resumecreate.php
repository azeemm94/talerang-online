<?php session_start();
//echo "<table>";foreach ($_POST as $key => $value) echo "<tr><td>".$key."</td><td>".$value."</td></tr>"; echo "</table>";
if(isset($_SESSION['adminuser'])&&(!isset($_GET['accountno'])))
{ header('location:adminresume.php'); exit; }

if(isset($_SESSION['useremail'])||isset($_SESSION['adminuser']))
{
date_default_timezone_set('Asia/Kolkata');
$months=array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
$year=date('Y');

if(isset($_SESSION['useremail']))
$resumeid=$_SESSION['accountno'];
if(isset($_SESSION['adminuser']))
$resumeid=$_GET['accountno'];

require 'connectsql.php';

if(isset($_SESSION['useremail']))
{
	$email=$_SESSION['useremail'];
	$sql="SELECT `phoneno` FROM `register` WHERE `email`='$email'";
	$row=mysqli_fetch_array(mysqli_query($DBcon,$sql));

	$mobile=$row[0];
	$firstname=$_SESSION['firstname'];
	$lastname=$_SESSION['lastname'];
}

$resumeexists=mysqli_num_rows(mysqli_query($DBcon,"SELECT * FROM `resume` WHERE `resumeid`='$resumeid';"));

$date=date("Y-m-d h:i:sa"); 

$resumests=array('personal'=>false,'education'=>false,'workex'=>false,'leader'=>false,'skills'=>false); //status of completion for each of the sections...updated below

if(!$resumeexists) //Create new
mysqli_query($DBcon,"INSERT INTO `resume` (`resumeid`,`datecreate`) VALUES ('$resumeid','$date'); ");

else //Load existing and update
{
	$resumearr=mysqli_query($DBcon,"SELECT * FROM `resume` WHERE `resumeid`='$resumeid' LIMIT 1;");
	$resumearr=mysqli_fetch_assoc($resumearr);
	//Personal Details
	if($resumearr['firstname']!="") $firstname=$resumearr['firstname'];
	if($resumearr['lastname']!="") $lastname=$resumearr['lastname'];
	if($resumearr['mobileno']!="") $mobile=$resumearr['mobileno'];
	if($resumearr['email']!="") $email=$resumearr['email'];
	if($resumearr['address']!="") $address=explode("<br>",$resumearr['address']);
	if($resumearr['city']!="") $city=$resumearr['city'];
	if($resumearr['country']!="") $country=$resumearr['country'];
	if($resumearr['pincode']!="") $pincode=$resumearr['pincode'];

	if($resumearr['firstname']!=""&&$resumearr['lastname']!=""&&$resumearr['mobileno']!=""&&$resumearr['email']!=""&&$resumearr['city']!=""&&$resumearr['country']!=""&&$resumearr['pincode']!="") 
	$resumests['personal']=true; //Personal complete

	//College details
	if($resumearr['schoolname']!="") $schoolname=explode("<br>",$resumearr['schoolname']);
	if($resumearr['schoolcity']!="") $schoolcity=explode("<br>",$resumearr['schoolcity']);
	if($resumearr['schoolcourse']!="") $schoolcourse=explode("<br>",$resumearr['schoolcourse']);
	if($resumearr['schoolyear']!="") $schoolyear=explode("<br>",$resumearr['schoolyear']);
	if($resumearr['schoolmarks']!="") $schoolmarks=explode("<br>",$resumearr['schoolmarks']);
	if($resumearr['schoolname']!="") $schoolno=count($schoolname);

	if($resumearr['schoolname']!=""&&$resumearr['schoolcity']!=""&&$resumearr['schoolcourse']!=""&&$resumearr['schoolyear']!=""&&$resumearr['schoolmarks']!=""&&$resumearr['schoolname']!="")
	$resumests['education']=true; //Education complete

	//Work-ex details
	if($resumearr['workcompany']=='noworkex')
	{
		$workcompany="";
		$workno=1;
		$workdes="";
		$workstart="";
		$workend="";
		$workresp="";
	}
	else
	{
		if($resumearr['workcompany']!="") $workcompany=explode("<br>", $resumearr['workcompany']);
		if($resumearr['workcompany']!="") $workno=count($workcompany);
		if($resumearr['workdes']!="") $workdes=explode("<br>", $resumearr['workdes']);
		if($resumearr['workstart']!="") $workstart=explode("<br>",$resumearr['workstart']);
		if($resumearr['workend']!="") $workend=explode("<br>",$resumearr['workend']);
		if($resumearr['workresp']!="") $workresp=explode("//", $resumearr['workresp']);
		if($resumearr['workresp']!="") for($i=0; $i <count($workresp) ; $i++) ${'workresponsibility'.$i}=explode("<br>",$workresp[$i]);
	}

	if($resumearr['workcompany']!=""&&$resumearr['workdes']!=""&&$resumearr['workstart']!=""&&$resumearr['workend']!=""&&$resumearr['workresp']!="")
	$resumests['workex']=true; //Work ex complete

	//Leadership details
	if($resumearr['leadername']!="") $leadername=explode("<br>",$resumearr['leadername']);
	if($resumearr['leadername']!="") $leaderno=count($leadername);
	if($resumearr['leaderdesc']!="") $leaderdesc=explode("//",$resumearr['leaderdesc']);
	if($resumearr['leaderdesc']!="") for($i=0; $i <count($leaderdesc) ; $i++) ${'leaderdescription'.$i}=explode("<br>",$leaderdesc[$i]);

	if($resumearr['leadername']!=""&&$resumearr['leaderdesc']!="")
	$resumests['leader']=true; //leader complete

	//Skills and interests
	if($resumearr['skills']!="")
	{
		$skills=explode("<br>",$resumearr['skills']); 
		$skillno=count($skills);

		$resumests['skills']=true; // skills complete
	}
}
}//end if useremail isset;
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1" />
	<meta name="robots" content="index, follow">  
	<title>Talerang Express | Resume</title>
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css?version=2.1">
	<link rel="stylesheet" type="text/css" href="css/landingstyle.css">
	<link rel="stylesheet" type="text/css" href="css/resumecreate.css?version=1.8">
	<?php include 'noscript.php' ?>
	<?php include 'jqueryload.php' ?>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.1/jquery.validate.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.0.47/jquery.fancybox.min.css" />
</head>

<body>
<?php include 'google-analytics.php'; ?>
<div id="wrapper">
	<nav class="navbar navbar-default" id="nav-header">
	  <div class="container-fluid">
	    <div class="navbar-header">
	    <?php if(isset($_SESSION['useremail'])||isset($_SESSION['adminuser'])): ?>
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
	      <ul class="nav navbar-nav navbar-right">
		    <li class="nav-link welcome"><a><span class="text">Signed in as <?php echo $_SESSION['firstname'] ?></span></a></li>
		    <li class="nav-link"><a href="landing.php"><span class="text">Back</span></a></li>
		    <li class="nav-link"><a href="logout.php"><span class="text">Logout</span></a></li>
	      </ul>
	    </div><!-- /.navbar-collapse -->
	   <?php elseif(isset($_SESSION['adminuser'])): ?>
	    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	      <ul class="nav navbar-nav navbar-right">
		    <li class="nav-link welcome"><a><span class="text">Admin</span></a></li>
		    <li class="nav-link"><a href="adminresume.php"><span class="text">Back</span></a></li>
		    <li class="nav-link"><a href="adminlogout.php"><span class="text">Logout</span></a></li>
	      </ul>
	    </div><!-- /.navbar-collapse -->
	   <?php endif; ?>
	  </div><!-- /.container-fluid -->
	</nav>

	<div class="ribbon container-fluid">
        <div class="container" id="middle">
            Resume Creator
        </div>
    </div>

	<div id="content">
	<?php if(isset($_SESSION['useremail'])||isset($_SESSION['adminuser'])): ?>
	<div class="container">
<?php
	//Form submit parts
	function switch_quotes($str)
	{
		$str=str_replace(array("‘","’","'"),"&#x27;",$str);	
		$str=str_replace(array("“","”",'"'),"&quot;",$str);	
		$str=str_replace('–', '-', $str);
		return $str;
	}
	//Personal information form handling
	if(isset($_POST['submit-personal']))
	{
		$fname=mysqli_real_escape_string($DBcon,switch_quotes($_POST['fname']));
		$lname=mysqli_real_escape_string($DBcon,switch_quotes($_POST['lname']));
		$mobile=mysqli_real_escape_string($DBcon,switch_quotes($_POST['mobile']));
		$emailid=mysqli_real_escape_string($DBcon,switch_quotes($_POST['email']));
		$city=mysqli_real_escape_string($DBcon,switch_quotes($_POST['city']));
		$country=mysqli_real_escape_string($DBcon,switch_quotes($_POST['country']));
		$pincode=mysqli_real_escape_string($DBcon,switch_quotes($_POST['pincode']));

		$address1=$_POST['address1'];
		$address2=$_POST['address2'];
		$address3=$_POST['address3'];
		$address=$address1;
		if($address2!="")$address.="<br>".$address2;
		if($address3!="")$address.="<br>".$address3;
		$address=mysqli_real_escape_string($DBcon,switch_quotes($address));
		$date=date("Y-m-d h:i:sa"); 

		$sql="UPDATE `resume` SET `firstname`='$fname',`lastname`='$lname',`mobileno`='$mobile',`email`='$emailid',`address`='$address',`city`='$city',`country`='$country',`pincode`='$pincode',`dateedited`='$date' WHERE `resumeid`='$resumeid'";
		mysqli_query($DBcon,$sql);
		if(!isset($_SESSION['adminuser']))
		header('location:resumecreate.php?section=education');
		else 
		header('location:resumecreate.php?section=education&accountno='.$resumeid);	
	}

	//Education Form Handling
	if(isset($_POST['submit-education']))
	{
		$educationno=$_POST['education-no'];
		$collegename=str_replace("<br>", "", $_POST['college']);
		$collegecity=str_replace("<br>", "", $_POST['city']);
		$coursename= str_replace("<br>", "", $_POST['course']);
		$collegeyear=str_replace("<br>", "", $_POST['year']);
		$collegegpa= str_replace("<br>", "", $_POST['gpa']);

		for($i=1;$i<$educationno;$i++)
		{
			$collegename.="<br>".str_replace("<br>", "", $_POST['college'.$i]);
			$collegecity.="<br>".str_replace("<br>", "", $_POST['city'.$i]);
			$coursename.= "<br>".str_replace("<br>", "", $_POST['course'.$i]);
			$collegeyear.="<br>".str_replace("<br>", "", $_POST['year'.$i]);
			$collegegpa.= "<br>".str_replace("<br>", "", $_POST['gpa'.$i]);
		}

		$collegename=switch_quotes($collegename);
		$collegecity=switch_quotes($collegecity);
		$coursename= switch_quotes($coursename);
		$collegeyear=switch_quotes($collegeyear);
		$collegegpa= switch_quotes($collegegpa);

		$collegename=mysqli_real_escape_string($DBcon,$collegename);
		$collegecity=mysqli_real_escape_string($DBcon,$collegecity);
		$coursename =mysqli_real_escape_string($DBcon,$coursename);
		$collegeyear=mysqli_real_escape_string($DBcon,$collegeyear);
		$collegegpa =mysqli_real_escape_string($DBcon,$collegegpa);

		$date=date("Y-m-d h:i:sa"); 
		$sql="UPDATE `resume` SET `schoolname`='$collegename',`schoolcity`='$collegecity',`schoolcourse`='$coursename',`schoolyear`='$collegeyear',`schoolmarks`='$collegegpa',`dateedited`='$date' WHERE `resumeid`='$resumeid';";

		mysqli_query($DBcon,$sql);

		if(!isset($_SESSION['adminuser']))
		header('location:resumecreate.php?section=workex');
		else 
		header('location:resumecreate.php?section=workex&accountno='.$resumeid);	
	}

	//Work Experience form handling
	if(isset($_POST['submit-workex']))
	{
		if(isset($_POST['noworkex'])) $noworkex=true; 
		else $noworkex=false;

		if(!$noworkex)//student has work experience
		{
			$workno=$_POST['workno'];
			$company=$_POST['company'];
			$designation=$_POST['designation'];

			$smonth=$_POST['startmonth'];
			$syear=$_POST['startyear'];	
			$startwork=$smonth." ".$syear;

			$workpresent=isset($_POST['workpresent'])?1:0;

			if(!$workpresent)
			{
				$emonth=$_POST['endmonth'];
				$eyear=$_POST['endyear'];
				$endwork=$emonth." ".$eyear;
			}
			else
			{
				$endwork="Present";
			}

			$wbullet1=str_replace(array('<br>','//'),'', $_POST['work-bullet-one']);
			$wbullet2=str_replace(array('<br>','//'),'', $_POST['work-bullet-two']);
			$wbullet3=str_replace(array('<br>','//'),'', $_POST['work-bullet-three']);

			$workresp=$wbullet1."<br>".$wbullet2."<br>".$wbullet3;

			for ($i=1; $i< $workno; $i++) 
			{ 
				$company.="<br>".$_POST['company'.$i];
				$designation.="<br>".$_POST['designation'.$i];

				$smonth=$_POST['startmonth'.$i];
				$syear=$_POST['startyear'.$i];	
				$startwork.="<br>".$smonth." ".$syear;

				$workpresent=isset($_POST['workpresent'.$i])?1:0;
				if(!$workpresent)
				{
					$emonth=$_POST['endmonth'.$i];
					$eyear=$_POST['endyear'.$i];
					$endwork.="<br>".$emonth." ".$eyear;
				}
				else
				{
					$endwork.="<br>Present";
				}
				$wbullet1=str_replace(array('<br>','//'),'', $_POST['work-bullet-one'.$i]);
				$wbullet2=str_replace(array('<br>','//'),'', $_POST['work-bullet-two'.$i]);
				$wbullet3=str_replace(array('<br>','//'),'', $_POST['work-bullet-three'.$i]);
				$workresp.="//".$wbullet1."<br>".$wbullet2."<br>".$wbullet3;
			}

			$company=switch_quotes($company);
			$designation=switch_quotes($designation);
			$workresp=switch_quotes($workresp);

			$company=mysqli_real_escape_string($DBcon,$company);
			$designation=mysqli_real_escape_string($DBcon,$designation);
			$startwork=mysqli_real_escape_string($DBcon,$startwork);
			$endwork=mysqli_real_escape_string($DBcon,$endwork);
			$workresp=mysqli_real_escape_string($DBcon,$workresp);

			$date=date("Y-m-d h:i:sa"); 
			$sql="UPDATE `resume` SET `workcompany`='$company',`workdes`='$designation',`workstart`='$startwork',`workend`='$endwork',`workresp`='$workresp',`dateedited`='$date' WHERE `resumeid`='$resumeid';";	
		}
		else//no work experience
		{
			$date=date("Y-m-d h:i:sa"); 
			$sql="UPDATE `resume` SET `workcompany`='noworkex',`workdes`='noworkex',`workstart`='noworkex',`workend`='noworkex',`workresp`='noworkex',`dateedited`='$date' WHERE `resumeid`='$resumeid';";	
		}

		mysqli_query($DBcon,$sql);

		if(!isset($_SESSION['adminuser']))
		header('location:resumecreate.php?section=leadership');
		else 
		header('location:resumecreate.php?section=leadership&accountno='.$resumeid);	
	}

	//Leadership Experience form handling
	if(isset($_POST['submit-leader'])) 
	{
		$leadershipno=mysqli_real_escape_string($DBcon,$_POST['leadership-no']);
		$leadertitle=str_replace(array('<br>','//'),'', $_POST['leadership-title']);
		$bullet1=str_replace(array('<br>','//'),'', $_POST['leader-bullet-one']);
		$bullet2=str_replace(array('<br>','//'),'', $_POST['leader-bullet-two']);
		$bullet3=str_replace(array('<br>','//'),'', $_POST['leader-bullet-three']);

		$leaderdesc=$bullet1."<br>".$bullet2."<br>".$bullet3;

		for($i=1; $i<$leadershipno; $i++)
		{
			$leadertitle.="<br>".str_replace(array("<br>","//"), "", $_POST['leadership-title'.$i]);
			$bullet1=str_replace(array('<br>','//'),'', $_POST['leader-bullet-one'.$i]);
			$bullet2=str_replace(array('<br>','//'),'', $_POST['leader-bullet-two'.$i]);
			$bullet3=str_replace(array('<br>','//'),'', $_POST['leader-bullet-three'.$i]);
			$leaderdesc.="//".$bullet1."<br>".$bullet2."<br>".$bullet3;
		}

		$leadertitle=switch_quotes($leadertitle);
		$leaderdesc=switch_quotes($leaderdesc);

		$leadertitle=mysqli_real_escape_string($DBcon, $leadertitle);
		$leaderdesc=mysqli_real_escape_string($DBcon, $leaderdesc);

		$date=date("Y-m-d h:i:sa"); 
		$sql="UPDATE `resume` SET `leadername`='$leadertitle',`leaderdesc`='$leaderdesc',`dateedited`='$date' WHERE `resumeid`='$resumeid';";
		mysqli_query($DBcon,$sql);

		if(!isset($_SESSION['adminuser']))
		header('location:resumecreate.php?section=skills');
		else 
		header('location:resumecreate.php?section=skills&accountno='.$resumeid);	
	}

	//Skills and interests form handling
	if(isset($_POST['submit-skills']))
	{
		$skillno=mysqli_real_escape_string($DBcon,$_POST['skill-no']);
		$skill=str_replace("<br>","",$_POST['skill']);
		for ($i=1; $i < $skillno ; $i++)  $skill.="<br>".$_POST['skill'.$i];
		$skill=switch_quotes($skill);
		$skill=mysqli_real_escape_string($DBcon,$skill);

		$date=date("Y-m-d h:i:sa"); 
		$sql="UPDATE `resume` SET `skills`='$skill',`dateedited`='$date' WHERE `resumeid`='$resumeid';";
		mysqli_query($DBcon,$sql);

		if(!isset($_SESSION['adminuser']))
		header('location:resumecreate.php?section=download');
		else 
		header('location:resumecreate.php?section=download&accountno='.$resumeid);	
	}
 ?>
	<div class="alert alert-warning">
		<div>
			<a href="pdf/Talerang_Resume_Template.pdf" class="alert-link" target="_blank">Click here</a> to view a guide with important instructions on making your resume
		</div>
		<div>
			<a class="alert-link" data-fancybox data-type="iframe" data-src="pdf/Mridul_Aggarwal_Resume_DoNotCopy.pdf" href="javascript:;">
				View a sample resume here
			</a>
		</div>
		<div>
			Always remember to click 'Save Section' after completing every section or while making edits
		</div>
	</div>
	<?php if(isset($_SESSION['adminuser'])): 
			$sql="SELECT `firstname`,`lastname` FROM `register` WHERE `accountno`='$resumeid';";
			$result=mysqli_query($DBcon,$sql);
			$row=mysqli_fetch_assoc($result);
			$studentname=$row['firstname'].' '.$row['lastname'];
	?>
		<div class="alert alert-info">
			You are editing the resume of <b><?php echo $studentname; ?></b>
		</div>
	<?php endif; ?>
	<div id="tester"></div>
	<ul class="nav nav-tabs" role="tablist" id="resumeTabs">
	  <li role="presentation" class="<?php if(!isset($_GET['section'])||$_GET['section']=='personal') echo 'active' ?>"><a href="#personal">Personal</a></li>
	  <li role="presentation" class="<?php if(isset($_GET['section'])&&$_GET['section']=='education') echo 'active' ?>"><a href="#education">Education</a></li>
	  <li role="presentation" class="<?php if(isset($_GET['section'])&&$_GET['section']=='workex') echo 'active' ?>"><a href="#experience">Work Experience</a></li>
	  <li role="presentation" class="<?php if(isset($_GET['section'])&&$_GET['section']=='leadership') echo 'active' ?>"><a href="#leader">Leadership</a></li>
	  <li role="presentation" class="<?php if(isset($_GET['section'])&&$_GET['section']=='skills') echo 'active' ?>"><a href="#skills">Skills and Interests</a></li>
	  <li role="presentation" class="<?php if(isset($_GET['section'])&&$_GET['section']=='download') echo 'active' ?>"><a href="#download"><span class="glyphicon glyphicon-download-alt" style="padding-right: 10px; vertical-align: middle; color: #0e0e0e"></span>Download</a></li>
	</ul>

	<div class="tab-content">
	<form method="post" action="" id="personal" class="well tab-pane in container-fluid tab-pane in container-fluid <?php if(!isset($_GET['section'])||$_GET['section']=='personal') echo 'active' ?>">
		<div><h3 class="section-title">Personal Information</h3><?php if($resumests['personal']): ?><div class="completemark">Complete!</div><?php endif; ?></div>
		<div class="alert alert-info">
			<ul class="instructions">
				<b>Instructions:</b>
				<li>Your full name should be at the top of the resume. Employers should see this piece of information first</li>
				<li>It is preferred if you include your complete mailing address with zip code, phone number, and e‐mail address</li>
			</ul>
		</div>
		<div>
			<label for="fname" class="fieldlabel">First name: </label>
			<input type="text" class="form-control" name="fname" id="fname" placeholder="Eg. John" value="<?php if(isset($firstname)) echo $firstname ?>"/>
			<label for="fname" class="error"></label>
		</div>
		<div>
			<label for="lname" class="fieldlabel">Last name: </label>
			<input type="text" class="form-control" name="lname" id="lname" placeholder="Eg. Doe" value="<?php if(isset($lastname)) echo $lastname ?>" />
			<label for="lname" class="error"></label>
		</div>
		<div>
			<label for="mobile" class="fieldlabel">Mobile No: </label>
			<input type="text" class="form-control" name="mobile" id="mobile" placeholder="Eg. 9821234567" value="<?php if(isset($mobile)) echo $mobile ?>" />
		</div>
		<div>
			<label for="email" class="fieldlabel">Email: </label>
			<input type="text" class="form-control" name="email" id="email" placeholder="Eg. someone@example.com" value="<?php if(isset($email)) echo $email ?>" />
		</div>
		<div>
			<label for="address1" class="fieldlabel">Home Address: </label>
			<input type="text" class="form-control" name="address1" id="address1" placeholder="Optional" value="<?php if(isset($address[0])) echo $address[0]; ?>" />
		</div>
		<div>
			<label for="address2" class="fieldlabel">Home Address line 2: </label>
			<input type="text" class="form-control" name="address2" id="address2" placeholder="Optional" value="<?php if(isset($address[1])) echo $address[1]; ?>" />
		</div>
		<div>
			<label for="address3" class="fieldlabel">Home Address line 3: </label>
			<input type="text" class="form-control" name="address3" id="address3" placeholder="Optional" value="<?php if(isset($address[2])) echo $address[2]; ?>" />
		</div>
		<div>
			<label for="city" class="fieldlabel">City: </label>
			<input type="text" class="form-control" name="city" id="city" placeholder="Eg. Mumbai" value="<?php if(isset($city)) echo $city; ?>" />
		</div>
		<div>
			<label for="pincode" class="fieldlabel">Pin Code: </label>
			<input type="text" class="form-control" name="pincode" id="pincode" placeholder="Eg. 400001" value="<?php if(isset($pincode)) echo $pincode; ?>" />
		</div>
		<div>
			<label for="country" class="fieldlabel">Country: </label>
			<input type="text" class="form-control" name="country" id="country" placeholder="Eg. India" value="<?php if(isset($country)) echo $country; ?>" />
		</div>
		<div>
			<input type="submit" name="submit-personal" id="submit-personal" class="submit-section">
			<label for="submit-personal" class="submit-section"><span class="glyphicon glyphicon-floppy-disk"></span>Save section</label>
		</div>
	</form>

	<form method="post" action="" id="education" class="well tab-pane in container-fluid <?php if(isset($_GET['section'])&&$_GET['section']=='education') echo 'active' ?>">
		<div><h3 class="section-title">Education</h3><?php if($resumests['education']): ?><div class="completemark">Complete!</div><?php endif; ?></div>
		Add your educational institutions in reverse chronological order (Latest school/college comes first)
		<div class="alert alert-info">
			<ul class="instructions">
				<b>Instructions:</b>
				<li>
					List schools attended (including study abroad) in reverse chronological order
				</li>
				<li>
					Include high school only if you are a first-year or sophomore or if it is highly relevant to your job search
				</li>
				<li>
					State academic grade; either average percentage or Major percentage is acceptable
				</li>
			</ul>
		</div>
		<?php if(!isset($schoolno)) $schoolno=1; ?>
		<input class="displaynone" id="education-no" type="text" name="education-no" value="<?php echo $schoolno ?>">
			<?php for($i=0;$i<$schoolno;$i++){ ?>
		<h3 class="section-sub-title">Educational Institution <?php echo $i+1 ?></h3>
		<div class="education-inst" id="first-education-inst">
			<div>
				<label for="college<?php if($i!=0) echo $i ?>" class="fieldlabel">School or college name</label>
				<input type="text" value="<?php if(isset($schoolname[$i])) echo $schoolname[$i] ?>" name="college<?php if($i!=0) echo $i ?>" class="form-control col-name" id="college<?php if($i!=0) echo $i ?>" placeholder="Eg. Jai Hind College" spellcheck="true"/>
			</div>
			<div>
				<label for="city<?php if($i!=0) echo $i ?>" class="fieldlabel">College City</label>
				<input type="text" value="<?php if(isset($schoolcity[$i])) echo $schoolcity[$i] ?>" name="city<?php if($i!=0) echo $i ?>" class="form-control col-city" id="city<?php if($i!=0) echo $i ?>" placeholder="Eg. Mumbai" />
			</div>
			<div>
				<label for="course<?php if($i!=0) echo $i ?>" class="fieldlabel">Course Name</label>
				<input type="text" value="<?php if(isset($schoolcourse[$i])) echo $schoolcourse[$i] ?>" name="course<?php if($i!=0) echo $i ?>" class="form-control col-course" id="course<?php if($i!=0) echo $i ?>" placeholder="Eg. Bachelor of Science" spellcheck="true"/>
			</div>
			<div>
				<label for="year<?php if($i!=0) echo $i ?>" class="fieldlabel">Year of passing</label>
				<input type="text" value="<?php if(isset($schoolyear[$i])) echo $schoolyear[$i] ?>" name="year<?php if($i!=0) echo $i ?>" class="form-control col-year" id="year<?php if($i!=0) echo $i ?>" placeholder="Eg. 2018" />
			</div>
			<div>
				<label for="gpa<?php if($i!=0) echo $i ?>" class="fieldlabel">Marks Obtained</label>
				<input type="text" value="<?php if(isset($schoolmarks[$i])) echo $schoolmarks[$i] ?>" name="gpa<?php if($i!=0) echo $i ?>" class="form-control col-marks" id="gpa<?php if($i!=0) echo $i ?>" placeholder="Eg. 8/10 or 80%" />
			</div>
		</div>
		<?php } //end for loop for schools ?>
		<div class="next-prev-links" id="next-prev-links-education">
			<h3 id="add-new"><a href="add-new-school">+ Add another school or college</a></h3>
			<h3 id="remove" class="remover" style="display: none;"><a href="remove-school">- Remove school or college</a></h3>
		</div>
		<div>
			<input type="submit" name="submit-education" id="submit-education" class="submit-section" value="Save section">
			<label for="submit-education" class="submit-section"><span class="glyphicon glyphicon-floppy-disk"></span>Save section</label>
		</div>
	</form>

	<form method="post" action="" id="experience" class="well tab-pane in container-fluid <?php if(isset($_GET['section'])&&$_GET['section']=='workex') echo 'active' ?>">
		<div><h3 class="section-title">Work Experience</h3><?php if($resumests['workex']): ?><div class="completemark">Complete!</div><?php endif; ?></div>
		Add your work experience in reverse chronological order (Latest job comes first)
		<div class="alert alert-info">
			<ul class="instructions">
				<b>Instructions:</b>
				<li>
					List experience in reverse chronological order (most recent first)
				</li>
				<li>
					Include employer name (or organization in which you volunteered, interned, etc.), position, title, city, state, dates involved, and accomplishments (in other words: not just duties, but results)
				</li>
				<li>
					Use action verbs, key nouns, and adjectives to quantify and qualify your accomplishments, not just responsibilities (i.e., "Created database which could produce lists of target donors"; "Supervised 15 campers, 8 to 12 years old.")
				</li>
				<li>
					Where possible, indicate how you progressed in a position or organization (i.e., "Started lawn care business. Grew from 2 employees to 13 in three years. Grossed $12,000 last year")
				</li>
				<li>
					If you have no prior work experience, select the checkbox below and click 'Save Section'
				</li>
			</ul>
		</div>
		<div>
			<input type="checkbox" name="noworkex" id="noworkex" value="noworkex"<?php if($resumearr['workcompany']=='noworkex') echo ' checked="checked"' ?>>
			<label for="noworkex">I have no work experience</label>
		</div>
		<?php if(!isset($workno)) $workno=1; ?>
		<input type="text" name="workno" id="workno" value="<?php echo $workno ?>" class="displaynone"/>
		<?php for($i=0;$i<$workno;$i++){ 
				if(isset($workstart[$i]))
				{
					$wstartmonth=substr($workstart[$i],0,3);
					$wstartyear=substr($workstart[$i],4);
				}
				else { $wstartmonth=""; $wstartyear=""; }
				if(isset($workend[$i]))
				{
					if($workend[$i]=="Present") { $wendmonth=""; $wendyear=""; }
					else
					{
						$wendmonth=substr($workend[$i],0,3);
						$wendyear=substr($workend[$i],4);
					}
				}
				else { $wendmonth=""; $wendyear=""; }
			?>
		<h3 class="section-sub-title work">Work Experience <?php echo $i+1 ?></h3>
		<div class="work-inst" <?php if($i==0) echo 'id="workfirst"' ?>>
			<div>
				<label for="company<?php if($i!=0) echo $i ?>" class="fieldlabel">Company name</label>
				<input type="text" value="<?php if(isset($workcompany[$i])) echo $workcompany[$i] ?>" name="company<?php if($i!=0) echo $i ?>" class="form-control work-name" id="company<?php if($i!=0) echo $i ?>" placeholder="Eg. " />
			</div>
			<div>
				<label for="designation<?php if($i!=0) echo $i ?>" class="fieldlabel">Designation</label>
				<input type="text" value="<?php if(isset($workdes[$i])) echo $workdes[$i] ?>" name="designation<?php if($i!=0) echo $i ?>" class="form-control work-des" id="designation<?php if($i!=0) echo $i ?>" placeholder="Designation" spellcheck="true"/>
			</div>
			<div>
				<label for="startmonth<?php if($i!=0) echo $i ?>" class="fieldlabel">Start Date</label>
				<select name="startmonth<?php if($i!=0) echo $i ?>" class="form-control work-start-month" id="startmonth<?php if($i!=0) echo $i ?>"/>
					<option value="" <?php if($wstartmonth=="") echo 'selected="selected"' ?> disabled="disabled">--Month--</option>
					<?php 
						for ($j=0; $j < count($months); $j++) { 
							if($wstartmonth==$months[$j])
							echo '<option selected="selected" value="'.$months[$j].'">'.$months[$j].'</option>';
							else
							echo '<option value="'.$months[$j].'">'.$months[$j].'</option>';
						}
					 ?>
				</select>
				<select name="startyear<?php if($i!=0) echo $i ?>" class="form-control work-start-year" id="startyear<?php if($i!=0) echo $i ?>"/>
					<option value="" <?php  if($wstartyear=="") echo 'selected="selected"' ?> disabled="disabled">--Year--</option>
					<?php 
						for ($j=$year; $j>=1980; $j--) { 
							if($wstartyear==$j)
							echo '<option selected="selected" value="'.$j.'">'.$j.'</option>';
							echo '<option value="'.$j.'">'.$j.'</option>';
						}
					 ?>
				</select>
			</div>
			<div>
				<label for="workpresent<?php if($i!=0) echo $i ?>" class="fieldlabel">Still working here?</label>
				<input type="checkbox" name="workpresent<?php if($i!=0) echo $i ?>" id="workpresent<?php if($i!=0) echo $i ?>" class="workpresent" value="1" <?php if(isset($workend[$i])) if($workend[$i]=="Present") echo "checked" ?>>
			</div>
			<div class="endwork" <?php if(isset($workend[$i])) if($workend[$i]=="Present") echo 'style="display:none"' ?>>
				<label for="endmonth<?php if($i!=0) echo $i ?>" class="fieldlabel">End Date</label>
				<select name="endmonth<?php if($i!=0) echo $i ?>" class="form-control work-end-month" id="endmonth<?php if($i!=0) echo $i ?>"/>
					<option value="" <?php if($wendmonth=="") echo 'selected="selected"' ?> disabled="disabled">--Month--</option>
					<?php 
						for ($j=0; $j < count($months); $j++) { 
							if($wendmonth==$months[$j])
							echo '<option selected="selected" value="'.$months[$j].'">'.$months[$j].'</option>';
							else
							echo '<option value="'.$months[$j].'">'.$months[$j].'</option>';
						}
					 ?>
				</select>
				<select name="endyear<?php if($i!=0) echo $i ?>" class="form-control work-end-year" id="endyear<?php if($i!=0) echo $i ?>"/>
					<option value="" selected="selected" disabled="disabled">--Year--</option>
					<?php 
						$year=date("Y");
						for ($j=$year; $j>=1980; $j--) { 
							if($wendyear==$j)
							echo '<option selected="selected" value="'.$j.'">'.$j.'</option>';
							else
							echo '<option value="'.$j.'">'.$j.'</option>';
						}
					 ?>
				</select>
			</div>
			<div>
				<label for="responsibilities<?php if($i!=0) echo $i ?>" class="fieldlabel"><b>Responsibilities</b></label>
				<div>
					<label for="work-bullet-one<?php if($i!=0) echo $i ?>" class="fieldlabel">Bullet point 1: </label>
					<div class="input-group">
						<input type="text" name="work-bullet-one<?php if($i!=0) echo $i ?>" id="work-bullet-one<?php if($i!=0) echo $i ?>" value="<?php if(isset(${'workresponsibility'.$i})) echo ${'workresponsibility'.$i}[0] ?>" class="form-control bullet work-one work-b length-limit" spellcheck="true" />
						<span class="input-group-addon">0%</span>
					</div>
					<label for="work-bullet-one<?php if($i!=0) echo $i ?>" class="error"></label>
				</div>
				<div>
				<label for="work-bullet-two<?php if($i!=0) echo $i ?>" class="fieldlabel">Bullet point 2: </label>
					<div class="input-group">
						<input type="text" name="work-bullet-two<?php if($i!=0) echo $i ?>" id="work-bullet-two<?php if($i!=0) echo $i ?>" value="<?php if(isset(${'workresponsibility'.$i})) echo ${'workresponsibility'.$i}[1] ?>" class="form-control bullet work-b length-limit" spellcheck="true" />
						<span class="input-group-addon">0%</span>
					</div>
				<label for="work-bullet-two<?php if($i!=0) echo $i ?>" class="error"></label>
				</div>
				<div>
					<label for="work-bullet-three<?php if($i!=0) echo $i ?>" class="fieldlabel">Bullet point 3: </label>
					<div class="input-group">
						<input type="text" name="work-bullet-three<?php if($i!=0) echo $i ?>" id="work-bullet-three<?php if($i!=0) echo $i ?>" value="<?php if(isset(${'workresponsibility'.$i})) echo ${'workresponsibility'.$i}[2] ?>" class="form-control bullet work-b length-limit" spellcheck="true">
						<span class="input-group-addon">0%</span>
					</div>
					<label for="work-bullet-three<?php if($i!=0) echo $i ?>" class="error"></label>
				</div>
			</div>
		</div>
		<?php }//end for loop for work ex ?>
		<div class="next-prev-links" id="next-prev-links-work">
			<h3 id="add-new-job"><a href="add-new-job">+ Add more work experience</a></h3>
			<h3 id="remove-job" class="remover" style="display: none;"><a href="remove-job">- Remove work experience</a></h3>
		</div>

		<div>
			<input type="submit" name="submit-workex" id="submit-experience" class="submit-section" value="Save section">
			<label for="submit-experience" class="submit-section"><span class="glyphicon glyphicon-floppy-disk"></span>Save section</label>
		</div>
	</form>

	<form action="" name="leader" method="post" id="leader" class="well tab-pane in container-fluid <?php if(isset($_GET['section'])&&$_GET['section']=='leadership') echo 'active' ?>">
		<?php if(!isset($leaderno)) $leaderno=1; ?>
		<input type="text" name="leadership-no" id="leadership-no" class="displaynone" value="<?php echo $leaderno ?>">
		<div><h3 class="section-title">Leadership Experiences</h3><?php if($resumests['leader']): ?><div class="completemark">Complete!</div><?php endif; ?></div>
		<div class="alert alert-info">
			<ul class="instructions">
				<b>Instructions:</b>
				<li>
					Leadership does not have to mean starting a new organization. Demonstrate that you have an ability to get the job done and make things happen, especially if it is behind the scenes
				</li>
				<li>
					Demonstrate that you have taken initiative to go above and beyond what was expected of you and make sure you highlight the outcome of your accomplishments
				</li>
			</ul>
		</div>
		<?php for($i=0;$i<$leaderno;$i++) { ?>
		<h3 class="section-sub-title">Leadership Experience <?php echo $i+1; ?></h3>
		<div class="leadership" <?php if($i==0) echo 'id="leadershipfirst"'; ?>>
			<div>
				<label for="leadership-title<?php if($i!=0) echo $i ?>">Title</label><br>
				<input type="text" value="<?php if(isset($leadername[$i])) echo $leadername[$i] ?>" name="leadership-title<?php if($i!=0) echo $i ?>" id="leadership-title<?php if($i!=0) echo $i ?>" class="form-control leader-title" placeholder="Leadership Title" spellcheck="true" />
			</div>
			<div>
				<label for="leadership-desc">Describe this leadership experience in three bullet points</label>
				<div>
					<label for="leader-bullet-one<?php if($i!=0) echo $i ?>" class="fieldlabel">Bullet point 1:</label>
					<div class="input-group">
						<input type="text" name="leader-bullet-one<?php if($i!=0) echo $i ?>" value="<?php if(isset(${'leaderdescription'.$i}[0])) echo ${'leaderdescription'.$i}[0]; ?>" id="leader-bullet-one<?php if($i!=0) echo $i ?>" class="form-control bullet leader-one leader-b length-limit" spellcheck="true"/>
						<span class="input-group-addon">0%</span>
					</div>
					<label for="leader-bullet-one<?php if($i!=0) echo $i ?>" class="error"></label>
				</div>
				<div>
					<label for="leader-bullet-two<?php if($i!=0) echo $i ?>" class="fieldlabel">Bullet point 2:</label>
					<div class="input-group">
						<input type="text" name="leader-bullet-two<?php if($i!=0) echo $i ?>" value="<?php if(isset(${'leaderdescription'.$i}[1])) echo ${'leaderdescription'.$i}[1]; ?>" id="leader-bullet-two<?php if($i!=0) echo $i ?>" class="form-control bullet leader-b length-limit" spellcheck="true"/>
						<span class="input-group-addon">0%</span>
					</div>
					<label for="leader-bullet-two<?php if($i!=0) echo $i ?>" class="error"></label>
				</div>
				<div>
					<label for="leader-bullet-three<?php if($i!=0) echo $i ?>" class="fieldlabel">Bullet point 3:</label>
					<div class="input-group">
						<input type="text" name="leader-bullet-three<?php if($i!=0) echo $i ?>" value="<?php if(isset(${'leaderdescription'.$i}[2])) echo ${'leaderdescription'.$i}[2]; ?>" id="leader-bullet-three<?php if($i!=0) echo $i ?>" class="form-control bullet leader-b length-limit" spellcheck="true"/>
						<span class="input-group-addon">0%</span>
					</div>
					<label for="leader-bullet-three<?php if($i!=0) echo $i ?>" class="error"></label>
				</div>
			</div>
		</div>
		<?php }//end for loop for leadership ?>
		<div class="next-prev-links" id="next-prev-links-leader">
			<h3 id="add-new-leadership"><a href="add-new-leadership">+ Add another leadership experience</a></h3>
			<h3 id="remove-leadership" class="remover" style="display: none;"><a href="remove-leadership">- Remove leadership experience</a></h3>
		</div>
		
		<div>
			<input type="submit" name="submit-leader" id="submit-leader" class="submit-section" value="Save section">
			<label for="submit-leader" class="submit-section"><span class="glyphicon glyphicon-floppy-disk"></span>Save section</label>
		</div>
	</form>

	<form action="" method="post" id="skills" name="skills" class="well tab-pane in container-fluid <?php if(isset($_GET['section'])&&$_GET['section']=='skills') echo 'active' ?>">
		<div><h3 class="section-title">Skills and Interests</h3><?php if($resumests['skills']): ?><div class="completemark">Complete!</div><?php endif; ?></div>
		<div class="alert alert-info">
			<ul class="instructions">
				<b>Instructions:</b>
				<li>
					A multi-purpose section for information of interest that does not merit special emphasis elsewhere in the resume
				</li>
				<li>
					List extracurricular activities here if not already mentioned in education or experience sections
				</li>
			</ul>
		</div>
		<p>Enter your skills and interests activities:</p>
		<?php if(!isset($skillno)) $skillno=1; ?>
		<input type="text" name="skill-no" value="<?php echo $skillno ?>" id="skill-no" class="displaynone">
		<?php for ($i=0; $i < $skillno ; $i++) { ?>
		<div class="skill-interest" id="skillfirst">
			<div class="input-group">
				<input type="text" name="skill<?php if($i!=0) echo $i ?>" id="skill<?php if($i!=0) echo $i ?>" class="form-control skill length-limit" value="<?php if(isset($skills[$i])) echo $skills[$i]; ?>" spellcheck="true"/>
				<span class="input-group-addon">0%</span>
			</div>
			<label class="error" for="skill<?php if($i!=0) echo $i ?>"></label>
		</div>
		<?php } //end skills for loop ?>
		<div class="next-prev-links" id="next-prev-links-skill">
			<h3 id="add-new-skill"><a href="add-new-skill">+ Add more skills or interests</a></h3>
			<h3 id="remove-skill" class="remover" style="display: none;"><a href="remove-skill">- Remove skill or interest</a></h3>
		</div>
		
		<div>
			<input type="submit" name="submit-skills" id="submit-skills" class="submit-section" value="Save section">
			<label for="submit-skills" class="submit-section"><span class="glyphicon glyphicon-floppy-disk"></span>Save section</label>
		</div>
	</form>
	

	<div id="download" class="well tab-pane in container-fluid <?php if(isset($_GET['section'])&&$_GET['section']=='download') echo 'active' ?>">
		<b>Completion Status:</b>
		<div>
			<?php if($resumests['personal']): ?>
				<img src="img/greentick.png">
			<?php else: ?>
				<img src="img/redcross.png">
			<?php endif ?>
			Personal Information
		</div>
		<div>
			<?php if($resumests['education']): ?>
				<img src="img/greentick.png">
			<?php else: ?>
				<img src="img/redcross.png">
			<?php endif ?>
			Education
		</div>
		<div>
			<?php if($resumests['workex']): ?>
				<img src="img/greentick.png">
			<?php else: ?>
				<img src="img/redcross.png">
			<?php endif ?>
			Work Experience
		</div>
		<div>
			<?php if($resumests['leader']): ?>
				<img src="img/greentick.png">
			<?php else: ?>
				<img src="img/redcross.png">
			<?php endif ?>
			Leadership Experience
		</div>
		<div>
			<?php if($resumests['skills']): ?>
				<img src="img/greentick.png">
			<?php else: ?>
				<img src="img/redcross.png">
			<?php endif ?>
			Skills and Interests
		</div>
		<?php if($resumests['personal']&&$resumests['education']&&$resumests['workex']&&$resumests['leader']&&$resumests['skills']): ?> 
			<div class="alert alert-success">
				Your resume is complete
			</div> 
		<?php else: ?>
			<div class="alert alert-warning">
				Your resume is incomplete. Fill in the missing sections first!
			</div>
		<?php endif ?>
		<?php if(isset($_SESSION['useremail'])): ?>
			<a href="resumedownload.php?user" id="download-button"><span class="glyphicon glyphicon-download-alt"></span>Download your resume here</a>
		<?php endif; ?>
		<?php 
		if(isset($_SESSION['adminuser'])):
			$sql="SELECT `firstname`,`lastname` FROM `register` WHERE `accountno`='$resumeid';";
			$result=mysqli_query($DBcon,$sql);
			$row=mysqli_fetch_assoc($result);
			$studentname=$row['firstname'].' '.$row['lastname'];
		?>
			<a href="resumedownload.php?admindl&account=<?php echo $resumeid; ?>" id="download-button"><span class="glyphicon glyphicon-download-alt"></span>Download your resume here</a>
		<?php endif;//endif isset admin user ?>
	</div>
	</div> <!-- close tabcontent -->

	</div> <!-- close container -->
	<?php else: //not signes in ?>
		<div class="container">
			<div id="notsignedin">
				<div class="alert alert-warning">
					You are not signed in! Please <a href="index.php?signin&pg=resumecreate" class="alert-link">Sign in</a> first
				</div>
				
			</div>
		</div>
	<?php endif; //isset session useremail ?>	
	</div> <!-- close content -->

	<?php include 'footer.php' ?>

</div><!--  close wrapper -->

<script type="text/javascript">
$(document).ready(function(){

	//Disabling enter key
    $("form").bind("keypress", function(e) { if (e.keyCode == 13) {return false;} });

    //Hide entire Work-ex
	<?php if($resumearr['workcompany']=='noworkex'): ?>
		$('.work-inst').hide();
		$('h3.work').hide();
		$('#next-prev-links-work').hide();
    <?php endif; ?>
    $('#noworkex').click(function(){
    	if($(this).is(":checked"))
    	{
    		$('.work-inst').hide();
    		$('h3.work').hide();
    		$('#next-prev-links-work').hide();
    	}
    	else
    	{
    		$('.work-inst').show();
    		$('h3.work').show();
    		$('#next-prev-links-work').show();
    	}
    }); 
    //Hide Work End Field
	$('.workpresent').click(function(){
		 $(this).parent().next("div.endwork").toggle('fast'); 
	});
/*************************Form Duplication*************************/

	//Duplication for education
	$(function () {
	    var duplicates = <?php if(isset($schoolno)) echo $schoolno-1; else echo '0'; ?>,
	        $original = $('#first-education-inst').clone(true);
	    
	    if(duplicates>0) $('h3#remove').show();

	    function DuplicateForm () 
	    {
	        var newForm;
	        duplicates++; 
	        $('h3#remove').show();

	        newForm = $original.clone(true).insertBefore($('div#next-prev-links-education'));

	        $("#education-no").val(duplicates+1);

	        $.each($('input', newForm), function(i, item) {
	            $(item).attr('name', $(item).attr('name') + duplicates);
	            $(item).attr('id', $(item).attr('id') + duplicates);
	            $(item).attr('value', '');
	        });

	        $.each($('label', newForm), function(i, item) {
	            $(item).attr('for', $(item).attr('for') + duplicates);
	        });
	        
	        $('<h3 class="section-sub-title">Educational Institution ' + (duplicates + 1) + '</h3>').insertBefore(newForm);
	    }

	    function RemoveForm()
	    {
	    	$("h3#add-new").parent().prev('.education-inst').remove();
	    	$("h3#add-new").parent().prev('h3.section-sub-title').remove();
	    	duplicates--;
	    	if(duplicates==0) $('h3#remove').hide();
	    	$("#education-no").val(duplicates+1);

	    }

	    $('a[href="remove-school"]').on('click', function (e) {
	        e.preventDefault();  if(duplicates!=0) RemoveForm();
	    });

	    $('a[href="add-new-school"]').on('click', function (e) {
	        e.preventDefault(); DuplicateForm();
	    });
	});

	//Duplication for Work experience
	$(function () {
	    var duplicates = <?php echo $workno-1; ?>,
	        $original = $('#workfirst').clone(true);

	    if(duplicates>0) $("#remove-job").show();
	    
	    function DuplicateForm () 
	    {
	        var newForm;
	        duplicates++; 
	        newForm = $original.clone(true).insertBefore($('#next-prev-links-work'));

	        $('input#workno').val(duplicates+1);
	        $("#remove-job").show();

	        $('.endwork',newForm).show();

	        $.each($('input', newForm), function(i, item) {
	            $(item).attr('name', $(item).attr('name') + duplicates);
	            $(item).attr('id', $(item).attr('id') + duplicates);
	            $(item).attr('value','');
	            $(item).removeAttr('checked');
	        });

	        $.each($('select', newForm), function(i, item) {
	            $(item).attr('name', $(item).attr('name') + duplicates);
	            $(item).attr('id', $(item).attr('id') + duplicates);
	            $(item).val('');
	        });

	        $.each($('label', newForm), function(i, item) {
	            $(item).attr('for', $(item).attr('for') + duplicates);
	        });

	        $.each($('span.input-group-addon', newForm), function(i, item) {
	            $(item).text('0%');
	        });
	        
	        $('<h3 class="section-sub-title work">Work Experience '+(duplicates+1)+'</h3>').insertBefore(newForm);

	        $('.work-inst').show();
	    }

	    function RemoveForm() 
	    {
	    	$("h3#add-new-job").parent().prev('.work-inst').remove();
	    	$("h3#add-new-job").parent().prev('h3.section-sub-title').remove();
	    	duplicates--;
	    	$("input#workno").val(duplicates+1);	
	    	if(duplicates==0) $('#remove-job').hide();
	    }

	    $('a[href="add-new-job"]').on('click', function (e) {
	        e.preventDefault(); DuplicateForm();
	    });

	    $('a[href="remove-job"]').on('click', function (e) {
	        e.preventDefault(); if(duplicates>0) RemoveForm();
	    });
	});

	//Duplication for leadership
	$(function () {
	    var duplicates = <?php echo $leaderno-1; ?>,
	        $original = $('#leadershipfirst').clone(true);

	    if(duplicates>0) $('#remove-leadership').show();
	    
	    function DuplicateForm () {
	        var newForm;
	        duplicates++; 
	        newForm = $original.clone(true).insertBefore($('div#next-prev-links-leader'));

	        $('#remove-leadership').show();
	        $("#leadership-no").val(duplicates+1);

	        $.each($('input', newForm), function(i, item) {
	            $(item).attr('name', $(item).attr('name') + duplicates);
	            $(item).attr('id', $(item).attr('id') + duplicates);
	            $(item).attr('value', '');
	        });

	        $.each($('label', newForm), function(i, item) {
	            $(item).attr('for', $(item).attr('for') + duplicates);
	        });

	        $.each($('textarea', newForm), function(i, item) {
	            $(item).attr('name', $(item).attr('name') + duplicates);
	            $(item).attr('id', $(item).attr('id') + duplicates);
	        });

	        $.each($('span.input-group-addon', newForm), function(i, item) {
	            $(item).text('0%');
	        });
	        
	        $('<h3 class="section-sub-title">Leadership Experience ' + (duplicates + 1) + '</h3>').insertBefore(newForm);
	    }

	    function RemoveForm()
	    {
	    	$("h3#add-new-leadership").parent().prev('.leadership').remove();
	    	$("h3#add-new-leadership").parent().prev('h3.section-sub-title').remove();
	    	duplicates--;
	    	$("#leadership-no").val(duplicates+1);	

	    	if(duplicates==0) $('#remove-leadership').hide();
	    }
	    
	    $('a[href="add-new-leadership"]').on('click', function (e) {
	        e.preventDefault(); DuplicateForm();
	    });

	     $('a[href="remove-leadership"]').on('click', function (e) {
	        e.preventDefault(); if(duplicates!=0) RemoveForm();
	    });
	});

	//Duplication for skills and interests
	$(function () {
	    var duplicates = <?php echo $skillno-1; ?>,
	        $original = $('#skillfirst').clone(true);
	    	if(duplicates>0) $('#remove-skill').show();
	    function DuplicateForm () {
	        var newForm;
	        duplicates++; 
	        $('#remove-skill').show();
	        $("#skill-no").val(duplicates+1);	
	        newForm = $original.clone(true).insertBefore($('#next-prev-links-skill'));
         
	        $.each($('input', newForm), function(i, item) {
	            $(item).attr('name', $(item).attr('name') + duplicates);
	            $(item).attr('id', $(item).attr('id') + duplicates);
	            $(item).attr('value','');
	        });

	        $.each($('span.input-group-addon', newForm), function(i, item) {
	            $(item).text('0%');
	        });

	        $.each($('label.error', newForm), function(i, item) {
	            $(item).attr('for', $(item).attr('for') + duplicates);
	        });
	    }

	    function RemoveForm()
	    {
	    	$('#next-prev-links-skill').prev('.skill-interest').remove();
	    	duplicates--;
	    	$("#skill-no").val(duplicates+1);	
	    	if(duplicates==0) $('#remove-skill').hide();
	    }
	    
	    $('a[href="add-new-skill"]').on('click', function (e) {
	        e.preventDefault(); DuplicateForm();
	    });

	    $('a[href="remove-skill"]').on('click', function (e) {
	        e.preventDefault(); if(duplicates>0) RemoveForm();
	    });
	});

/**************************Form Duplication**************************/
/****************************Char counter****************************/
var lengthlimit=482;
function checkLength(element)
{
		var text=element.val();
		/*text=text.replace(/ /g,'&nbsp;');*/
		$('#tester').text(text);
		var inputwidth=Math.round($('#tester').width() *100)/100;
		element.attr('data-length',inputwidth);
		var percent=Math.round(inputwidth/(lengthlimit/100)*100)/100;
		element.next('span.input-group-addon').text( percent+"%");
}

$('input.length-limit').each(function(){
		var element=$(this);
		checkLength(element);

	$(this).keyup(function(){
		var element=$(this);
		checkLength(element);
	});
	$(this).blur(function(){
		var element=$(this);
		checkLength(element);
	});
	$(this).focus(function(){
		var element=$(this);
		checkLength(element);
	});
});
/****************************Char counter****************************/
/**************************Form Validation**************************/
	jQuery.validator.addMethod("lengthlimit", function(value, element, params) 
	{
  		return this.optional(element) || $(element).attr('data-length')<=lengthlimit;

	}, jQuery.validator.format("Please shorten this sentence to below 100%"));

	//Personal Info Form Validation
	$('#personal').validate({
		rules: {
			'fname' : {required: true},
			'lname' : {required: true},
			'mobile': {required: true},
			'email' : {required: true, email: true},
			'city' :  {required: true},
			'pincode' : {required: true},
			'country' : {required: true},
		},
		messages:{

		}
	});

	//Education Form Validation
	$('#education').validate({});
    $.validator.addClassRules('col-name'  ,{required: true,});
    $.validator.addClassRules('col-city'  ,{required: true,});
    $.validator.addClassRules('col-course',{required: true,});
    $.validator.addClassRules('col-year'  ,{required: true,});
    $.validator.addClassRules('col-marks' ,{required: true,});

    //Work Ex Form Validation
    $('#experience').validate({});
    $.validator.addClassRules('work-name', {required: true,});
    $.validator.addClassRules('work-des', {required: true,});
    $.validator.addClassRules('work-start-month', {required: true,});
    $.validator.addClassRules('work-start-year', {required: true,});
    $.validator.addClassRules('work-end-month', {required: true,});
    $.validator.addClassRules('work-end-year', {required: true,});
    $.validator.addClassRules('work-one', {required: true,});
    $.validator.addClassRules('work-b', {lengthlimit: true,});

    //Leadership Experiences Form Validation
    $('#leader').validate({});
    $.validator.addClassRules('leader-title' ,{required: true,});
    $.validator.addClassRules('leader-one' ,{required: true,});
    $.validator.addClassRules('leader-b' ,{lengthlimit: true,});

    $('#skills').validate({});
    $.validator.addClassRules('skill' ,{required: true,lengthlimit: true,});

    $('#resumeTabs a').click(function (e) { e.preventDefault(); $(this).tab('show'); });

});//end document ready
</script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.0.47/jquery.fancybox.min.js"></script>
</body>
</html>