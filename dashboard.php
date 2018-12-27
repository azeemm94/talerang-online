<?php session_start(); 
      date_default_timezone_set('Asia/Kolkata'); 
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
	<link rel="stylesheet" type="text/css" href="css/style.css?version=2.0" />
	<link rel="stylesheet" type="text/css" href="css/landingstyle.css" />
	<link rel="stylesheet" type="text/css" href="css/dashboard.css?version=2.1" />
    <?php include 'noscript.php' ?>
	<?php include 'jqueryload.php' ?>
</head>
<?php 
/***********************Grading Statement Responses********************/            
            // 0-Low, 1-Moderate, 2-High
$wrap_percentage="";
$statement = 
array(
	array("Don't give up! Develop your self belief. If you truly believe in yourself, so will others. Deeply ingrained confidence and self-worth will make life more enjoyable, exciting and satisfying.",
		  "You have have moderate and reasonable self-belief that may go up and down based on the circumstances. Firmly believe in your values and principles, and  be ready to defend them even when finding opposition, feeling secure enough to modify them in light of experience.",
		  "Congratulations! You have a good opinion of your abilities but recognize your flaws. You have a strong belief in your ability to take action in achieving various goals in life."), 
		  //0 Self Belief
	array("You avoid looking at yourself in terms of feelings, thoughts and motivations.  As you develop self awareness you will able to make changes in the thoughts and interpretations you make in your mind. Having a clear understanding of your thought and, behavior patterns helps you understand other people. This ability to empathize facilitates better personal and professional relationships.",
		  "You have a reasonable understanding of your strengths, weaknesses and the values that drive you.A better understanding of which core traits drive your decisions and your attitude is what is most important for increasing the probability for success.",
		  "Congratulations - you are amazing! You are on a search to understand who you are and why you are here! You can leverage your self-awareness to effectively manage situations and relationships."), 
	      //1 Self Awareness
	array("Learn about how you can be someone who exhibits professionalism under any circumstances so that you can open doors for you either in the workplace or in your personal ambition.",
	      "You know that it's essential to be professional if you want to be a success. Work on what \"being professional\" actually means and your gaps.",
	      "You exude professionalism by presenting all qualities to create a positive reputation for yourself. Your workplace will think of you as an asset to the team for consistently doing things in a professional way."), 
	      //2 Professionalism
	array("You need to keep working on your communication skills. You are not expressing yourself clearly. The good news is that, by paying attention to communication, you can be much more effective at work, and enjoy much better working relationships!",
		  "You're a capable communicator, but you sometimes experience communication problems. Take the time to think about your approach to communication, and focus on receiving and giving messages effectively. This will help you improve.",
		  "Excellent! You well understand your role as a communicator, You choose the right ways of communicating. People respect you for your ability to communicate clearly."), 
		  //3 Business Communication
	array("Ouch. The good news is that you've got a great opportunity to improve your effectiveness at work, and your long term success! However, to realize this, you've got to fundamentally improve your time management skills.",
		  "You're good at some things, but there's room for improvement elsewhere. Focus on the critical issues like setting goals, prioritizing, scheduling,managing interruptions and procrastination, and you'll most likely find that work becomes much less stressful.",
		  "You're managing your time very effectively! Still, check if there are specific areas like goal setting, managing interruptions, scheduling, to see if there's anything you can tweak to make this even better."), 
	      //4 Prioritization 
	array("You probably tend to view problems as negatives, instead of seeing them as opportunities to make exciting and necessary change. Your approach to problem solving is more intuitive than systematic, and this may have led to some poor experiences in the past. With more practice, and by following a more structured approach, you'll be able to develop this important skill and start solving problems more effectively right away.",
		  "Your approach to problem solving is a little \"hit-and-miss.\" Sometimes your solutions work really well, and other times they don't. You understand what you should do, and you recognize that having a structured problem-solving process is important. However, you don't always follow that process. By working on your consistency and committing to the process, you'll see significant improvements.",
	      "You are a confident problem solver. You take time to understand the problem, understand the criteria for a good decision, and generate some good options. Because you approach problems systematically, you cover the essentials each time – and your decisions are well though out, well planned, and well executed. You can continue to perfect your problem-solving skills and use them for continuous improvement initiatives."), 
	      //5 Problem Solving
	array("You have a low score on the grammar test. You are familiar with only basic and simple grammar. You need to work hard on your grammar aptitude to be ready for the demands of workplace.",
		  "You are occasionally skilled at using contextual, grammatical and lexical cues. You need to focus on improving you grammar aptitude.",
	      "You are proficient and skilled at using contextual, grammatical and lexical cues."), 
	      //6 Grammar
	array("Low ethical score. You are  ill-equipped to navigate the ethical minefields awaiting you in the swirl of fast-changing competitive market. Imagine making the decision and then look at yourself in the mirror. How do you feel? What do you see in your eyes? Does it trigger alarm bells, violate your principles, or summon a guilty conscience?",
		  "Moderately ethical. You might engage in unethical behaviours under certain circumstances.",
	      "Highly ethical! You have high integrity and strong ethical principles."), 
	      //7 Ethics
	array("You could do with getting a better understanding and aligning your natural motivations and talents with your career choices and how you should best work to get there.",
		  "You are on the right track, but yet to understand the wider profession and the world outside. Focus on begining to  begin to figure out who you are while you decide what you want to become and the the kind of life you hope to lead.",
	      "Congratulations! You are able to effectively navigate the pathways that connect your education to employment are prepared to achieve a fulfilling and successful career."), 
	      //8 Professional Awareness
	 );
?>
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
	      <a href="landing.php"><img alt="Talerang" src="img/logoexpress.jpg"></a>
	    </div>

	    <!-- Collect the nav links, forms, and other content for toggling -->
	    <?php if(isset($_SESSION['useremail'])): ?>
	    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	      <ul class="nav navbar-nav navbar-right">
	        <li class="nav-link welcome"><a><span>Signed in as <?php echo $_SESSION['firstname'] ?></span></a></li>
	        <?php if(!$_SESSION['sndtprogram']): ?>
	        <li class="nav-link"><a href="landing.php"><span>Back</span></a></li>
	    	<?php endif; ?>
	        <li class="nav-link"><a href="logout.php"><span>Logout</span></a></li>
	      </ul>
	    </div><!-- /.navbar-collapse -->
	    <?php endif ?>
	  </div><!-- /.container-fluid -->
	</nav>

	<div id="content">
	<?php if(isset($_SESSION['useremail'])): ?>

	<?php
	$email=$_SESSION['useremail'];
	require 'connectsql.php'; 
	$sql="SELECT * FROM `teststart` WHERE `email`='$email';";
	$result=mysqli_query($DBcon,$sql);
	$num_start=mysqli_num_rows($result);

	$sql="SELECT * FROM `results` WHERE `email`='$email';";
	$result=mysqli_query($DBcon,$sql);
	$num_result=mysqli_num_rows($result);
	$row=mysqli_fetch_assoc($result);
	$wrap_percentage=round($row['avg'],0);
	?>

	<div class="ribbon container-fluid">
        <div class="container" id="middle">
            Dashboard
        </div>
    </div>

    <ul id="mytabs" class="nav nav-tabs hidden-print" role="tablist">
        <li class="tabtop<?php if(!isset($_GET['skillselect'])) echo ' active'; ?>">
            <a class="tablink" href="#wrap" role="tab" data-toggle="tab"><div class="tabdiv"><span>WRAP</span></div></a>
        </li>
        <?php if(!$_SESSION['sndtprogram']): ?>
        <li class="tabtop">
            <a class="tablink" href="#mock" role="tab" data-toggle="tab"><div class="tabdiv"><span>Mock Interviews</span></div></a>
        </li>
        <li class="tabtop<?php if(isset($_GET['skillselect'])) echo ' active'; ?>">
            <a class="tablink" href="#skill" role="tab" data-toggle="tab"><div class="tabdiv"><span>Skill Selector</span></div></a>
        </li>
    	<?php endif; ?>
    </ul>

    <div class="tab-content">
	<div class="tab-pane container-fluid dash-section<?php if(!isset($_GET['skillselect'])) echo ' in active'; ?>" id="wrap">
		<div class="container-fluid section-title">
			<span id="page-title">Work Readiness Aptitude Predictor</span>
			
		</div>
		<?php if($num_result): ?>
		<div class="container-fluid section-buttons">
        	<button class="nav-link hidden-print print-button" id="shareBtn" type="button"/>Share to Facebook</button>
        	<!-- <button class="nav-link hidden-print print-button" type="button" onclick="location.href='certificate.php';"/>Get your certificate</button> -->
        	<button class="nav-link hidden-print print-button" id="print-button" onclick="printPage()">Print this report</button>
		</div>
		<?php endif ?>
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

						//get average
						$resultavg=mysqli_query($DBcon,"SELECT * FROM `results`;");
						$selfbelief=0;
						$selfaware=0;
						$professionalism=0;
						$businesscomm=0;
						$profaware=0;
						$prioritization=0;
						$probsolve=0;
						$grammar=0;
						$ethics=0;

						$num_rows_avg=mysqli_num_rows($resultavg);
						while($rowavg=mysqli_fetch_assoc($resultavg))
						{
						    $selfbelief+=$rowavg['selfbelief'];
						    $selfaware+=$rowavg['selfaware'];
						    $professionalism+=$rowavg['professionalism'];
						    $businesscomm+=$rowavg['businesscomm'];
						    $profaware+=$rowavg['profaware'];
						    $prioritization+=$rowavg['prioritization'];
						    $probsolve+=$rowavg['probsolve'];
						    $grammar+=$rowavg['grammar'];
						    $ethics+=$rowavg['ethics'];
						}

						$selfbelief=round($selfbelief/$num_rows_avg,2);
						$selfaware=round($selfaware/$num_rows_avg,2);
						$professionalism=round($professionalism/$num_rows_avg,2);
						$businesscomm=round($businesscomm/$num_rows_avg,2);
						$profaware=round($profaware/$num_rows_avg,2);
						$prioritization=round($prioritization/$num_rows_avg,2);
						$probsolve=round($probsolve/$num_rows_avg,2);
						$grammar=round($grammar/$num_rows_avg,2);
						$ethics=round($ethics/$num_rows_avg,2);
					 ?>
				</div>
			    <b>Your Work Ready score is <?php echo $row['avg'] ?> % </b>
				<li>
					<div class="skillbar clearfix" data-percent="<?php echo $row['avg'] ?>">
						<div class="skillbar-title"><span>Work Readiness</span></div>
						<div class="skillbar-bar"></div>
						<div class="skill-bar-percent"><?php echo $row['avg'] ?>%</div>
					</div>
			   </li>
				<b>Your percentile rank is <?php echo $row['percentile'] ?>. </b>
				<div>
					WRAP Percentile Rank is a score which has values from 1 to 99. It compares performance to other students taking the same test.<br/>
					Your scores in each of the sections are:
				</div>
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
						<div><?php echo $statement[0][$gradelevel[0]] ?></div>
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
						<div><?php echo $statement[1][$gradelevel[1]] ?></div>
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
						<div><?php echo $statement[2][$gradelevel[2]] ?></div>
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
						<div><?php echo $statement[3][$gradelevel[3]] ?></div>
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
						<div><?php echo $statement[8][$gradelevel[8]] ?></div>
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
						<div><?php echo $statement[4][$gradelevel[4]] ?></div>
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
						<div><?php echo $statement[5][$gradelevel[5]] ?></div>
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
						<div><?php echo $statement[6][$gradelevel[6]] ?></div>
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
						<div><?php echo $statement[7][$gradelevel[7]] ?></div>
					</li>
				</ul>
				<div>
				<hr>
				Your Life Vision essay (What matters most to you and why?) grade is: <?php echo $lv1grade ?><br/>
				Your Life Vision essay (What is your plan for the next 3-5 years?) grade is: <?php echo $lv2grade ?><br/>
				</div>
			</div>
			</div> <!--close colmd12-->
			<div class="col-md-12">
				<hr>
				<canvas id="compareChart" style="max-width: 100%;"></canvas> 
			</div>
		<?php elseif($num_start): ?>
			<div class="col-md-12 alt">
				<div class="alert alert-warning">
					Results could not be calculated as you did not complete the test
				</div>
			</div>
		<?php else: ?>
			<div class="col-md-12 alt">
				<div class="alert alert-warning">
					No test scores to show
				</div>
			</div>
		<?php endif ?>
		</div>     <!--close row    -->
		</div>  <!-- close container -->
	</div> <!-- close dash section wrap -->
	
	<?php if(!$_SESSION['sndtprogram']): ?>
	<div class="tab-pane container-fluid dash-section" id="mock">
		<div class="container-fluid section-title">
			Mock Interviews
		</div>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
			<?php 
				$sql="SELECT * FROM `feespaid` WHERE `email`='$email' AND `type`='Mock interview';";
				$feespaid=mysqli_num_rows(mysqli_query($DBcon,$sql));

				if(!$feespaid): ?>
					<div class="feedback alert alert-warning">
						No mock interview feedback to show
					</div>
				<?php else:
					$sql="SELECT * FROM `mockfeedback` WHERE `email`='$email';"; 
					$result=mysqli_query($DBcon,$sql);
					$feedbackrows=mysqli_num_rows($result);
					while($rowmock=mysqli_fetch_assoc($result)):
						$inttype=$rowmock['inttype'];
						$intdate=$rowmock['intdate'];
						$feedback=$rowmock['mockfeedback'];

						$inttime=substr($intdate,0,7);
						$intdate=substr($intdate,8);
						?>
						<div class="feedback alert alert-info">For your <b><?php echo $inttype ?></b> interview on <b><?php echo $intdate ?></b> at <b><?php echo $inttime ?></b>, counsellor has given the following feedback:
							<p>"<?php echo $feedback ?>"</p>
						</div>
						
			    <?php endwhile;//end while loop 
		    		if(!$feedbackrows): ?>
		    			<div class="feedback alert alert-info">Feedback will be updated here soon. Thank you!</div>
		    	<?php endif;//end if feedbackrows
		   		 endif;//end if feespaid ?>
		   		 </div> <!-- end col-md-12 -->
			</div> <!-- end row	 -->
		</div><!--  end container -->
	</div> <!-- close dash section mockinterviews -->

	<div class="tab-pane container-fluid dash-section<?php if(isset($_GET['skillselect'])) echo ' in active'; ?>" id="skill">
		<div class="container-fluid section-title">
			Skill Selector
		</div>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<?php 
					require 'connectsql.php';
					$accountno=mysqli_real_escape_string($DBcon,$_SESSION['accountno']);
					$sql="SELECT `id` FROM `skillselector` WHERE `accountno`='$accountno';";
					$selectorused=mysqli_num_rows(mysqli_query($DBcon,$sql));

					if(!$selectorused):
					?>
						<div class="alert alert-warning" style="margin-top: 20px">
							No results to show
						</div>
					<?php else: 
						$sql="SELECT * FROM `skillselector` WHERE `accountno`='$accountno';";
						$rowskill=mysqli_fetch_assoc(mysqli_query($DBcon,$sql));
						$skilltrk=array(
						//'names' Skill track names
						'names'=>array(0=>"Academia",1=>"Business Operations",2=>"Coding",3=>"Data Analytics",4=>"Design",5=>"Entrepreneurship",6=>"Finance",7=>"Fashion",8=>"Marketing",9=>"Non Profit - Social Impact",10=>"Research",11=>"Sales",12=>"Social Media Marketing",13=>"Strategy",14=>"Written Communications"),
						//'percent' Percentage in skill tracks
						'percent' =>explode('%',$rowskill['percent']),
						'filename' => array(0=>"academia",1=>"business-operations",2=>"coding",3=>"data-analytics",4=>"design",5=>"entrepreneurship",6=>"finance",7=>"fashion",8=>"marketing",9=>"non-profit-social-impact",10=>"research",11=>"sales",12=>"social-media-marketing",13=>"strategy",14=>"written-communications"),
						//'desc' Description of each of the skill tracks
						'desc'=>array("<b>Academia: </b>This track delves deeper into the understanding and creating better content for teaching. Strong written communication skills are essential. Also, strong research capabilities by taking public surveys and analyzing data is important. Working knowledge of excel and powerpoint are required for this track.",//Academia
							"<b>Business Operations: </b>This track requires strong organizational and planning skills. Process management enables the smooth functioning of all the different aspects of any organization you must have the ability to clearly lay out a step by step approach to business functions and processes. Working knowledge of excel and powerpoint are essential for presenting designed plans.",//Business Operations
							"<b>Coding: </b>A highly technical skill track, this demands exceptional knowledge of different IT functional languages. From coding a simple subroutine in a major client back end support software, to designing the concept of a new process management ERP package. A coder needs to have sound understanding of program logic and process flow. Report writing and powerpoint skills are important for presenting ideas and plans.",//Coding
							"<b>Data Analytics: </b>Data analytics requires finding patterns in numbers and trends in vast amount of data generated through research. Understanding the research data and building meaningful next steps in terms of strategy and execution makes this track indispensable for organizations. Strong knowledge of excel and data handling skills are required. Being aware of associations and inter-relatedness of functions is also an important skill.",//Data Analytics
							"<b>Design: </b>This skill requires imagination, out of the box thinking approach and creativity partnered with a technical ability to create (Adobe Photoshop/Corel Draw). It requires translating an idea into a visual message.",//Design
							"<b>Entrepreneurship: </b>This skill track is a mix of many different functional roles. From operations to research. Strategy to Sales. This track demands the ability to clearly create a vision and set achievable goals for both short and the long term. Excellent written and verbal communication skills are essential. Ability to get out of your comfort zone and interact with different people to understand mindsets, study research data and create meaningful strategies.",//Entrepreneurship
							"<b>Finance: </b>The game of numbers. This track demands exceptional mathematical and analytical skills. From redesigning the revenue structure to employee remuneration, this skill track allows you to understand how the money component of organizations works. Strong knowledge of excel and powerpoint are essential. Understanding financial models will be critical for this track.",//Finance
							"<b>Fashion: </b>This track not only requires fineness in visual arts and imagination, but also a strong knowledge of market trends. Research and good written communication is essential. Powerpoint skills are equally necessary. Good marketing skills especially visual merchandising ideas are very important for this skill track.",//Fashion
							"<b>Marketing: </b>Unlike sales, marketing is the story behind the scene. For a product to sell, the product has to be strategically placed in the right market place. This track requires a strong research and analytical mind combined with a creative out of box thinking. Understanding data from market research is essential and demands rigorous field work and speaking to people. Strong verbal and written communication skills with a working knowledge of excel and powerpoint is very important.",//Marketing
							"<b>Non Profit - Social Impact: </b>To succeed at non-profit or social impact work, you must tap a certain mental mojo, work-style and tenacity for the move to be a win-win for both parties. Top of the list are \"data-savvy skills\". Collecting data and measuring social impact is key to the non-profit career story. The ability to apply design thinking to solving social issues is next on the list. You will also need the people skills to create cross-sector partnerships with potential supporters in an increasingly sophisticated, constantly evolving market.",//Non Profit - Social Impact
							"<b>Research: </b>This skill requires data collection abilities and converting that data into meaningful conclusion. It involves coming up with new ideas based on a theory and finally an executable plan for that idea. A strong sense of the big picture and associated functions is necessary to successfully complete any research project. Working knowledge powerpoint and report writing skills are essential. Field work and speaking with customers are essential steps for gaining insights before presenting.",//Research
							"<b>Sales: </b>No organization can function unless the product it creates is sold. From selling over the counter to selling to a country, sales handles it all. This track enables you to take a much deeper look at the most intricate details of how the sales and distribution works for organization. Any product can be sold, if it is pitched so. This track also requires a lot of research and analysis of current trends. A strong sense of vision and goal setting are important aspects for this track. A working knowledge of excel particularly data analysis is essential. Strong written and verbal communication skills are required.",//Sales
							"<b>Social Media Marketing: </b>Every organization new and old today understands the importance of online social communities and the impact these have on business. Social Media Marketing will require not only a strong sense of the online marketing environment, but ideas that can change the masses. A sound knowledge of working around various social media platforms and creative thinking for running various marketing campaigns are important skills for this track.",//Social Media Marketing
							"<b>Strategy: </b>Strategists carve a path for future functioning and development of the company’s offering. A very strong understanding of numbers is required for coming up with new strategies. Organizations will expect you to analyse information as well as effectively present your ideas. Working knowledge of powerpoint and excel is critical. Research goes hand in hand with strategy so you may also need to speak to customers and gain insights before presenting your findings. Comfort with data and numbers, as well as the ability to step back and think about vision and goals from a big picture perspective is key.",//Strategy
							"<b>Written Communications: </b>This skill allows expression of thoughts and ideas to one or many people depending on the audience. From public messaging to internal memos, communication is an integral part of any organization. Knowledge of written and verbal forms of communication is critical. Presentation skills and creative ideation are skills that are important for functioning in this role."//Written Communications
							)
						);
						function swapper(&$a,&$b) { $t=$a; $a=$b; $b=$t; }

						for ($i=0; $i < count($skilltrk['percent']) ; $i++) 
							for ($j=1; $j < count($skilltrk['percent'])-$i ; $j++) 
								if($skilltrk['percent'][$j]>$skilltrk['percent'][$j-1])
								{
								swapper($skilltrk['percent'][$j],$skilltrk['percent'][$j-1]);
								swapper($skilltrk['names'][$j],$skilltrk['names'][$j-1]);
								swapper($skilltrk['desc'][$j],$skilltrk['desc'][$j-1]);
								swapper($skilltrk['filename'][$j],$skilltrk['filename'][$j-1]);
								}
						$breakpt=4;
						for ($i=5; $i< count($skilltrk['percent']); $i++) 
						{
							if($skilltrk['percent'][$i]<$skilltrk['percent'][4])
								break;
							else $breakpt=$i;
						}
					?>
						<div style="margin-top: 20px">
							The skill tracks that suit you the most are: 
							<ul id="results">
							<?php 
								for ($i=0; $i <=$breakpt ; $i++) 
								{ 
									if($skilltrk['percent'][$i]>60)
									$thiscolor='green';
									elseif($skilltrk['percent'][$i]>40)
									$thiscolor='yellow';
									else
									$thiscolor='red';
								?>
								<li>
									<div class="percentagealt">
										<hr>
										<?php echo $skilltrk['names'][$i] ?>: <?php echo $skilltrk['percent'][$i]." %"; ?>
									</div>
									<div class="skillbar clearfix" data-percent="<?php echo $skilltrk['percent'][$i] ?>">
										<div class="skillbar-title"><span><?php echo ($i+1).'. '.$skilltrk['names'][$i] ?></span></div>
										<div class="skillbar-bar <?php echo $thiscolor ?>"></div>
										<div class="skill-bar-percent"><?php echo $skilltrk['percent'][$i] ?>%</div>
									</div>
									<div class="container">
										<div class="row">
											<div class="col-md-3 skilltrk-img">
												<img class="skilltrk-image" src="img/skilltracks/<?php echo $skilltrk['filename'][$i] ?>.jpg"/>
											</div>
											<div class="col-md-9 skilltrk-desc">
												<?php echo $skilltrk['desc'][$i] ?>
											</div>
										</div>
									</div>
								</li>
							<?php }//end for loop for skill select bars ?>
							</ul>
						</div>
					<?php endif; ?>
		   		 </div> <!-- end col-md-12 -->
			</div> <!-- end row	 -->
		</div><!--  end container -->
	</div> <!-- close dash section skillselector -->
	<?php endif; ?>

	</div> <!-- close tabcontent -->
	<?php else: ?>
		<div class="container" id="notsignedin">
			<div class="alert alert-warning">
				You are not signed in! Please <a href="index.php?signin&pg=dashboard" class="alert-link">Sign in</a> first
			</div>
		</div>
	<?php endif ?>
	</div> <!--close content -->
	<div class="hidden-print">
	<?php include 'footer.php' ?>
	</div>
</div> <!--close wrapper    -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript">

$(window).on("load", function() {

	jQuery('.skillbar').each(function(){
		var barwidth=jQuery(this).attr('data-percent')*0.6; //corresponds to bar width in dashboard.css:60
	jQuery(this).find('.skillbar-bar').animate({ width: barwidth+"%"},1000, 'linear');
	});

});

function printPage()
{
    $('body').css("overflow", "initial");
	window.print();
}

$(document).ready(function(){

/*Facebook SDK*/
window.fbAsyncInit = function() {
FB.init({
  appId      : '1863694867204377',
  xfbml      : true,
  version    : 'v2.8'
});
};

(function(d, s, id){
 var js, fjs = d.getElementsByTagName(s)[0];
 if (d.getElementById(id)) {return;}
 js = d.createElement(s); js.id = id;
 js.src = "//connect.facebook.net/en_US/sdk.js";
 fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

/*Facebook Sharing*/
document.getElementById('shareBtn').onclick = function() {

    FB.ui({
        display: 'popup',
        method: 'share',
        title: 'I am <?php echo $wrap_percentage ?>% work-ready! How about you?',
        description: 'How work-ready are you? Find out now!',
    /*link: 'www.talerang.com/express/',*/
    /*picture: 'www.talerang.com/express/img/genz/generation-z.jpg',*/
    href: 'www.talerang.com/express',

  }, function(response){}); 
}
});
</script>
<?php if(isset($_SESSION['useremail'])):
		if($num_result): ?>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	//Chart code
    var ctx = document.getElementById("compareChart");
    var mixedChart = new Chart(ctx, {
      type: 'bar',
      data: {
		datasets: 
		[
			{
				label: 'Your Score (%)',
				borderColor: '#27215b',
				backgroundColor: '#27215b',
				lineTension: 0,
				fill: false,
				data: [<?php echo implode(',',array($row['selfbelief'],$row['selfaware'],$row['professionalism'],$row['businesscomm'],$row['profaware'],$row['prioritization'],$row['probsolve'],$row['grammar'],$row['ethics'])); ?>]
			}, 
			{
			label: 'Average Score (%)',
			borderColor: '#bd2325',
			backgroundColor: '#bd2325',
			lineTension: 0,
			fill: false,
			data: [<?php echo implode(',',array($selfbelief,$selfaware,$professionalism,$businesscomm,$profaware,$prioritization,$probsolve,$grammar,$ethics)); ?>],
			}
		],
		labels: ['Self Belief','Self Awareness','Professionalism','Business Communication','Professional Awareness','Prioritization','Problem Solving','Grammar','Ethics']
		//labels: ['Self Belief','Self Awareness','Professionalism','Business Communication','Professional Awareness','Prioritization','Problem Solving','Grammar','Ethics']
		},
		options: 
		{
			scales: 
			{
				yAxes: 
				[{
					ticks: 
					{
						fontSize: 18,
						fontFamily: "sinhala_mnregular",
						fontColor: "#000000",
						beginAtZero:true
					}
				}],
				xAxes: 
				[{
					ticks: 
					{
						fontSize: 18,
						fontColor: "#000000",
						fontFamily: "sinhala_mnregular",
					}
				}]
			},
			tooltips: 
			{
				titleFontSize: 18,
				titleFontFamily: "sinhala_mnregular",
				bodyFontSize: 18,
				bodyFontFamily: "sinhala_mnregular",
			},
			legend:
			{
				labels:
				{
					fontSize: 18,
					fontFamily: "sinhala_mnregular",
					fontColor: "#000000",
				}
			},
			title: 
			{
				display: true,
				text: 'Comparison of your scores with the average scores of all WRAP takers',
				fontSize: 24,
				fontFamily: "sinhala_mnregular",
				fontColor: "#000000",
			}
		}
    });

}); //end document ready
</script>
<?php endif;
endif; ?>
<script id="setmore_script" type="text/javascript" src="https://my.setmore.com/js/iframe/setmore_iframe.js"></script>
</body>
</html>