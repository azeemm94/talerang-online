<?php 
session_start();
date_default_timezone_set('Asia/Kolkata'); 

require 'connectsql.php';

$accountno=mysqli_real_escape_string($DBcon,$_SESSION['accountno']);
$sql="SELECT `id` FROM `skillselector` WHERE `accountno`='$accountno';";
$selectorused=mysqli_num_rows(mysqli_query($DBcon,$sql));

$sql="SELECT `id` FROM `feespaid` WHERE `accountno`='$accountno' AND `type`='Skill Selector' AND `status`='SUCCESS';";
$paid=mysqli_num_rows(mysqli_query($DBcon,$sql));

$sql="SELECT `id` FROM `feespaid` WHERE `accountno`='$accountno' AND `status`='SUCCESS' AND `type`='Placement Express';";
$placementpaid=mysqli_num_rows(mysqli_query($DBcon,$sql));

function swapper(&$a,&$b) { $t=$a; $a=$b; $b=$t; }

$qna=array(
'questions'=>array(
"Do you like managing projects, making lists, working on processes?",
"Are you creative? Do you have an eye for design?",
"Do you like numbers? Are you happy to work on excel?",
"Do you have a passion which can be converted into a business idea?",
"Do you like doing research? ",
"Are you comfortable with chaos and a fast-paced environment?",
"Are you motivated by money?",
"Do you like working in a caring and inspiring environment, one where culture is a priority?",
"Do you like convincing people of your point of view?",
"Do you like working independently?",
"Do you like working in teams?",
"Do you like interacting with people?",
"Are you flexible with the type of work that might be given to you in an organization?",
"Are you quick at grasping new concepts?",
"Would you be willing to do field work?",
"Are you motivated by getting things done?",
"Are you able to think on your feet?",
"Are you motivated by targets?",
"Do you have a thick skin?",
"Would you consider yourself as a patient person?",
"Do you like to follow new trends in clothing and accessories?",
"Do you want to change the world?"
),
'answer'=>array()
);

//Grading of each of the questions 
$skillans=array(
	
	array(  0, 20,  0,  0,  0, 10,  0,  0, 15,  0,  0, 20,  0, 10,  0),//Do you like managing projects, making lists, working on processes?
	
	array(  0,  0,  0, 15, 20, 10,  0, 40,  0,  0,  0, 20, 25, 15,  0),//Are you creative? Do you have an eye for design?
	
	array(  0, 15,  0, 20,  0,  0, 30,  0, 15,  0,  0,  0,  0, 35,  0),//Do you like numbers? Are you happy to work on excel?
	
	array(  0,  0,  0,  0,  0, 20,  0,  0,  0,  0, 15,  0,  0, 30,  0),//Do you have a passion which can be converted into a business idea?
	
	array( 30,  0,  0, 20,  0,  0,  0,  0, 15,  0, 30,  0,  0, 25, 30),//Do you like doing research? 
	
	array(  0, 20, 15, 20,  0, 15,  0,  0, 25,  0,  0, 30,  0,  0,  0),//Are you comfortable with chaos and a fast-paced environment?
	
	array(  0,  0, 15,  0,  0,  0, 40,  0, 25,  0,  0, 30,  0,  0,  0),//Are you motivated by money?
	
	array( 10,  0, 10, 10, 10, 10,  0,  0, 10, 20, 10,  0, 10, 10, 10),//Do you like working in a caring and inspiring environment,one where culture is a priority?
	
	array(  0,  0,  0,  0, 30, 20,  0, 10,  0, 40, 20, 35,  0, 25,  0),//Do you like convincing people of your point of view?
	
	array( 15,  0, 20,  0,  0,  0,  0,  0,  0,  0, 15, 25,  0, 30, 20),//Do you like working independently?
	
	array(  0, 15,  0,  0,  0, 15,  0,  0, 30, 30, 15, 15, 10, 20,  0),//Do you like working in teams?
	
	array(  0, 10,  0,  0,  0,  0,  0, 10,  0,  0,  0, 25,  0,  0, 20),//Do you like interacting with people?
	
	array(  0, 10,  0,  0,  0, 20,  0,  0,  0, 45,  0,  0, 25, 30, 25),//Are you flexible with the type of work that might be given to you in an organization?
	
	array( 20,  0, 25, 20,  0, 15,  0,  0, 30,  0,  0,  0, 20, 35,  0),//Are you quick at grasping new concepts?
	
	array(  0, 10,  0,  0,  0, 10,  0,  0, 30, 50, 25, 25,  0,  0,  0),//Would you be willing to do field work?
	
	array(  0, 20, 15,  0,  0,  0,  0,  0, 30,  0,  0, 30,  0, 40,  0),//Are you motivated by getting things done?
	
	array(  0, 15,  0,  0,  0,  0,  0,  0, 35,  0,  0, 20,  0, 30,  0),//Are you able to think on your feet?
	
	array(  0, 20,  0,  0,  0,  0, 30,  0,  0,  0,  0, 50,  0,  0,  0),//Are you motivated by targets?
	
	array(  0,  0,  0,  0,  0,  0, 25,  0,  0,  0,  0, 30,  0,  0,  0),//Do you have a thick skin?
	
	array(  0,  0, 20,  0, 25,  0,  0,  0,  0, 50,  0,  0,  0,  0,  0),//Would you consider yourself as a patient person?
	
	array(  0,  0,  0,  0,  0,  0,  0, 40,  0,  0,  0,  0,  0,  0,  0),//Do you like to follow new trends in clothing and accessories?
	
	array(  0,  0,  0,  0,  0,  0,  0,  0,  0, 70,  0,  0,  0,  0,  0) //Do you want to change the world?
);

$skilltrk=array(
	//'names' Skill track names
	'names'=>array(0=>"Academia",1=>"Business Operations",2=>"Coding",3=>"Data Analytics",4=>"Design",5=>"Entrepreneurship",6=>"Finance",7=>"Fashion",8=>"Marketing",9=>"Non Profit - Social Impact",10=>"Research",11=>"Sales",12=>"Social Media Marketing",13=>"Strategy",14=>"Written Communications"),
	//'scores' Score in skill tracks
	'scores' =>array(  0,  0,  0,  0,  0,  0,  0,  0,  0,  0,  0,  0,  0,  0,  0),
	//'totals' total score in each of the skill tracks
	'totals' =>array(  0,  0,  0,  0,  0,  0,  0,  0,  0,  0,  0,  0,  0,  0,  0),
	//'percent' Percentage of score
	'percent'=>array(  0,  0,  0,  0,  0,  0,  0,  0,  0,  0,  0,  0,  0,  0,  0)
	);
	
	for ($i=0; $i<count($skilltrk['totals']); $i++) 
		for($j=0; $j<count($skillans); $j++)
			$skilltrk['totals'][$i]+=$skillans[$j][$i];

	if(isset($_POST['skill-submit']))
	{
		for ($i=0; $i < 22; $i++)
		{
			if(isset($_POST['skill-'.($i+1)]))
			{
				array_push($qna['answer'], $_POST['skill-'.($i+1)]);
				if($_POST['skill-'.($i+1)]=='Y')
				for($j=0; $j <= 14; $j++) 
					$skilltrk['scores'][$j]+=$skillans[$i][$j];
			}
			else array_push($qna['answer'], 'N');
			
		} 

		//Calculating and storing percentages
		for($i=0;$i<count($skilltrk['percent']);$i++)
			$skilltrk['percent'][$i]=$skilltrk['scores'][$i]/$skilltrk['totals'][$i]*100;

		if(isset($_POST['project'])) $projects=$_POST['project'];
		else $projects="";

		if($projects=="") $projects=array();

		//Increase percentage by 10% if project selected
		for ($i=1; $i<=15 ; $i++) 
		{ 
			if(in_array($i, $projects))
			{
				switch ($i) 
				{
					case  '1': $skilltrk['percent'][0]=1.1*$skilltrk['percent'][0]; break;
					case  '2': $skilltrk['percent'][1]=1.1*$skilltrk['percent'][1]; break;
					case  '3': $skilltrk['percent'][2]=1.1*$skilltrk['percent'][2]; break;
					case  '4': $skilltrk['percent'][3]=1.1*$skilltrk['percent'][3]; break;
					case  '5': $skilltrk['percent'][4]=1.1*$skilltrk['percent'][4]; break;
					case  '6': $skilltrk['percent'][5]=1.1*$skilltrk['percent'][5]; break;
					case  '7': $skilltrk['percent'][6]=1.1*$skilltrk['percent'][6]; break;
					case  '8': $skilltrk['percent'][7]=1.1*$skilltrk['percent'][7]; break;
					case  '9': $skilltrk['percent'][8]=1.1*$skilltrk['percent'][8]; break;
					case '10': $skilltrk['percent'][10]=1.1*$skilltrk['percent'][10]; break;
					case '11': $skilltrk['percent'][11]=1.1*$skilltrk['percent'][11]; break;
					case '12': $skilltrk['percent'][12]=1.1*$skilltrk['percent'][12]; break;
					case '13': $skilltrk['percent'][13]=1.1*$skilltrk['percent'][13]; break;
					case '14': $skilltrk['percent'][14]=1.1*$skilltrk['percent'][14]; break;
					case '15': $skilltrk['percent'][9]=1.1*$skilltrk['percent'][9]; break;
					default:    break;
				}
			}
		}

		//Checking that percentage doesnt go above 100
		for($i=0;$i<count($skilltrk['percent']);$i++)
		{
			if($skilltrk['percent'][$i]>100) $skilltrk['percent'][$i]=100;
			$skilltrk['percent'][$i]=round($skilltrk['percent'][$i],2);
		}
		$percentages=implode('%',$skilltrk['percent']);

		//Bubble sort according to highest skill track percentage
		for ($i=0; $i<count($skilltrk['percent']) ; $i++) 
		{ 
			for($j=1; $j<count($skilltrk['percent'])-$i; $j++)
			{
				if($skilltrk['percent'][$j-1]<$skilltrk['percent'][$j])
				{
					swapper($skilltrk['names'][$j],   $skilltrk['names'][$j-1]);
					swapper($skilltrk['scores'][$j],  $skilltrk['scores'][$j-1]);
					swapper($skilltrk['totals'][$j],  $skilltrk['totals'][$j-1]);
					swapper($skilltrk['percent'][$j], $skilltrk['percent'][$j-1]);
				}
			}	
		}

		require 'connectsql.php';
		$fullname=mysqli_real_escape_string($DBcon,$_SESSION['firstname'].' '.$_SESSION['lastname']);
		$email=mysqli_real_escape_string($DBcon,$_SESSION['useremail']);
		$date=mysqli_real_escape_string($DBcon,date("Y-m-d h:i:sa")); 
		$percentages=mysqli_real_escape_string($DBcon,$percentages);

		$answers=mysqli_real_escape_string($DBcon,implode('.',$qna['answer']));

		$sql="INSERT INTO `skillselector` (`accountno`,`fullname`,`email`,`percent`,`answers`,`date`)
		 		VALUES ('$accountno','$fullname','$email','$percentages','$answers','$date');";

		mysqli_query($DBcon,$sql);
		header('location:dashboard.php?skillselect');
		exit;
		/*	echo var_dump($qna);*/
	/*	for($i=0;$i<count($skilltrk['percent']);$i++)
			echo number_format ($skilltrk['percent'][$i] , 2, '.', '').'% - '.$skilltrk['names'][$i].'<br>';*/
	}
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1" />
	<meta name="robots" content="index, follow">  
	<title>Talerang Express | Skill Track Selector</title>
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css?version=2.1">
	<link rel="stylesheet" type="text/css" href="css/landingstyle.css">
	<link rel="stylesheet" type="text/css" href="css/skillselect.css">
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
		    <li class="nav-link"><a href="skilltraining.php"><span class="text">Back</span></a></li>
		    <li class="nav-link"><a href="logout.php"><span class="text">Logout</span></a></li>
	      </ul>
	    </div><!-- /.navbar-collapse -->
	   <?php endif; ?>
	  </div><!-- /.container-fluid -->
	</nav>

	<div id="content">

	<div class="ribbon container-fluid">
        <div class="container" id="middle">
            Skill Selector
        </div>
    </div>

	<div class="container">
	<?php
		//Adding the payment gateway fot Skill Selector
		$orderAmount = "250.00"; //order amount for Placement Express in INR
		$returnUrl='http://www.talerang.com/express/skillselect.php';
		$paymenttype='Skill Selector';
		include 'citrus-pay.php';
		if(!($paid||$placementpaid)): 
			if (isset($_POST['TxStatus'])) {
			if($_POST['TxStatus']=='SUCCESS'){ ?>
				<div class="alert alert-success" style="margin-top: 20px;">
					Thank you. Your payment was successful. <a href="skillselect.php" class="alert-link">Click here to start</a>
				</div>
			<?php }} ?>
		<div style="margin-top: 20px;">
			Are you unsure about where your talents lie? <br>Take this quiz and find out which skill track suits you best!
			<!-- Having trouble picking out a skill track? <br>Take this quick assessment and find out the skill tracks that suit you the best. -->
		</div>
		<div class="alert alert-warning" style="margin-top: 20px;">
			You need to pay for this service to unlock it. Please click on the below link to issue an online payment
		</div>
		<form id="skill-citrus" action="skillselect.php" method="post">
			<input type="submit" name="submit-citrus" value="Click here to checkout" id="skill-citrus">
		</form>
	
	<?php elseif(!$selectorused): ?>
	<form method="post" action="" name="skill-quiz" id="skill-quiz">

	<div id="question"><div id="qno">Question <span id="currqno">1</span> of 23</div></div>

	<?php
		for ($i=0; $i < count($qna['questions']); $i++) 
		{ ?>
		<div class="skill-question<?php if($i==0) echo ' current'; ?>" data-no="<?php echo $i+1; ?>">
				<h3><?php echo $qna['questions'][$i]; ?></h3>
				<div>
					<input type="radio" name="skill-<?php echo ($i+1); ?>" id="skill-<?php echo ($i+1); ?>-Y" value="Y" class="skill-radio">
					<label for="skill-<?php echo ($i+1); ?>-Y" class="skill-label">Yes</label>
					<input type="radio" name="skill-<?php echo ($i+1); ?>" id="skill-<?php echo ($i+1); ?>-N" value="N" class="skill-radio">
					<label for="skill-<?php echo ($i+1); ?>-N" class="skill-label">No</label>
				</div>
			</div>
	<?php } //end for loop ?>
	

	<div class="skill-question" data-no="23">
	<div class="row">
		<h3>
			Does this task appeal to you AND do you feel that you would excel in it? (Select all that apply)
		</h3>
		<div style="text-align: left" class="col-md-offset-2 col-md-8">
			<div class="project-option">
				<input type="checkbox" name="project[]" id="project-1" value="1">
				<label for="project-1" class="project-label">
					Research the effects of demonetization on the economy in the short term (for the next 2 quarters)
				</label>
			</div>
			<div class="project-option">
				<input type="checkbox" name="project[]" id="project-2" value="2">
				<label for="project-2" class="project-label">
					Plan and oversee shifting of the office of Chatpata Tiffin, a food ordering portal to a new office location. Organise an orientation program for the new entry level and mid level hires.
				</label>
			</div>
			<div class="project-option">
				<input type="checkbox" name="project[]" id="project-3" value="3">
				<label for="project-3" class="project-label">
					Create the logic flow for ChatpataTiffin.com, a food ordering platform
				</label>
			</div>
			<div class="project-option">
				<input type="checkbox" name="project[]" id="project-4" value="4">
				<label for="project-4" class="project-label">
					Analyze the World Bank data for India to answer the following questions:
					<ol>
						<li>Which are the regions in India that have a high employability gap? </li>
						<li>Identify the sectors that suffer most from employability crisis? </li>
						<li>Which sector needs the most number of new hires? </li>
					</ol>
					
				</label>
			</div>
			<div class="project-option">
				<input type="checkbox" name="project[]" id="project-5" value="5">
				<label for="project-5" class="project-label">
					Create the website and app landing page for ChatpataTiffin, a food ordering portal
				</label>
			</div>
			<div class="project-option">
				<input type="checkbox" name="project[]" id="project-6" value="6">
				<label for="project-6" class="project-label">
					Create the business plan and organization flow chart for ChatpataTiffin, a food ordering portal
				</label>
			</div>
			<div class="project-option">
				<input type="checkbox" name="project[]" id="project-7" value="7">
				<label for="project-7" class="project-label">
					Analyze ADF Foods Industries attached financial statements (balance sheet, P&amp;L statement)
				</label>
			</div>
			<div class="project-option">
				<input type="checkbox" name="project[]" id="project-8" value="8">
				<label for="project-8" class="project-label">
					Create a plan to launch an e-commerce portal for women's Indian ethnic wear. 
				</label>
			</div>
			<div class="project-option">
				<input type="checkbox" name="project[]" id="project-9" value="9">
				<label for="project-9" class="project-label">
					Create the marketing strategy for ChatpataTiffin, a food ordering portal 
				</label>
			</div>
			<div class="project-option">
				<input type="checkbox" name="project[]" id="project-10" value="10">
				<label for="project-10" class="project-label">
					Research the topic 'Declining Oil Price : Implications for Indian Economy and the World'
				</label>
			</div>
			<div class="project-option">
				<input type="checkbox" name="project[]" id="project-11" value="11">
				<label for="project-11" class="project-label">
					Create the sales strategy for ChatpataTiffin, a food ordering portal
				</label>
			</div>
			<div class="project-option">
				<input type="checkbox" name="project[]" id="project-12" value="12">
				<label for="project-12" class="project-label">
					Rajasthan Royals are reeling from a Spot Fixing Crisis. Help create an online campaign for them to regain credibility?
				</label>
			</div>
			<div class="project-option">
				<input type="checkbox" name="project[]" id="project-13" value="13">
				<label for="project-13" class="project-label">
					1. Identify the primary customer base of ChatpataTiffin, a food ordering portal<br>
					2. Devise a strategic approach to improve the interaction with the primary customer base and the way they are connected to the firm 
				</label>
			</div>
			<div class="project-option">
				<input type="checkbox" name="project[]" id="project-14" value="14">
				<label for="project-14" class="project-label">
					Create a monthly newsletter and testimonial page for ChatpataTiffin, a food ordering portal
				</label>
			</div>
			<div class="project-option">
				<input type="checkbox" name="project[]" id="project-15" value="15">
				<label for="project-15" class="project-label">
					Create a micro-franchise model for low-cost reading glasses in India.
				</label>
			</div>
		</div>
	</div>
	<div class="submit">
		<input type="submit" name="skill-submit" id="skill-submit" value="Submit">
	</div>
	</div>
	</form>
	<?php else: ?>
		<div class="alert alert-warning" style="margin-top: 20px;">
			You have already used the Skill Selector. <a href="dashboard.php?skillselect" class="alert-link">View your results here</a>
		</div>
	<?php endif; ?>	
	</div> <!-- close container -->
	</div> <!-- close content -->

	<?php include 'footer.php' ?>

</div><!--  close wrapper -->

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript">
	$('.skill-radio').each(function()
	{
		$(this).click(function()
		{
			var qno=parseInt($(this).parent().parent().attr('data-no'))+1;
			$('#currqno').text(qno);
			$(this).parent().parent().slideUp('fast');
			$(this).parent().parent().removeClass('current');
			$(this).parent().parent().next('.skill-question').slideDown('fast');
			$(this).parent().parent().next('.skill-question').addClass('current');
		});
	});
</script>
</body>
</html>