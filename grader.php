<?php   session_start(); 
    	date_default_timezone_set('Asia/Kolkata'); 
		error_reporting(0);
		//error_reporting(E_ALL & ~E_NOTICE); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
	<title>Talerang Express | WRAP Results</title>
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css?version=2.1" />
    <?php include 'noscript.php' ?>
</head>

<body>
	<div id="page-container">
	<div id="header" class="container">
            <img src="img/logo.gif" alt="Talerang">  
    </div>
<?php //echo "<table>";foreach ($_POST as $key => $value) echo "<tr><td>".$key."</td><td>".$value."</td></tr>"; echo "</table>" ?>
	<div id="page-wrap" class="container">
        <?php
        if(isset($_POST['wrap-submit'])):
  			// 0-Low, 1-Moderate, 2-High
  			$gradelevel= array("","","","","","","","","");
  			$gradecolor=array('0'=>"red",'1'=>"yellow",'2'=>"green");
/********************Self Belief 400********************/		      
            $answer1   = isset($_POST['question1answers'])    ? $_POST['question1answers']    : "";
			$answer2   = isset($_POST['question2answers'])    ? $_POST['question2answers']    : "";
            $answer1b  = isset($_POST['question1banswers'])   ? $_POST['question1banswers']    : "";
			$answer2b  = isset($_POST['question2banswers'])   ? $_POST['question2banswers']    : "";
			$answer1btext  = isset($_POST['question1banswerstext'])   ? $_POST['question1banswerstext']    : "";

			$totalCorrect1 = 0;
			     if($answer1=="D") $totalCorrect1+=100;
			 elseif($answer1=="E") $totalCorrect1+=100;
			 elseif($answer1=="F") $totalCorrect1+=100;
			 elseif($answer1=="H") $totalCorrect1+=100;
			 elseif($answer1=="G") $totalCorrect1+=50;
			 elseif($answer1=="I") $totalCorrect1+=50;

			     if($answer2=="D") $totalCorrect1+=100;
			 elseif($answer2=="E") $totalCorrect1+=100;
			 elseif($answer2=="F") $totalCorrect1+=100;
			 elseif($answer2=="H") $totalCorrect1+=100;
			 elseif($answer2=="G") $totalCorrect1+=50;
			 elseif($answer2=="I") $totalCorrect1+=50;

			     if($answer1b=="A"||$answer1b=="B"||$answer1b=="C")
			     	$totalCorrect1+=100;
			 elseif($answer1b=="D" && !$answer1btext=="")
			 		$totalCorrect1+=100;
			 elseif($answer1b=="E") $totalCorrect1+=0;

			     if($answer2b=="A"||$answer2b=="B") $totalCorrect1+=100;
			 elseif($answer2b=="C")                 $totalCorrect1+= 50;
			 elseif($answer2b=="D"||$answer2b=="E") $totalCorrect1+= 25;
			 elseif($answer2b=="F")                 $totalCorrect1+=  0;
		 
                 if($totalCorrect1<=100) $gradelevel[0]="0"; //low
             elseif($totalCorrect1<=200) $gradelevel[0]="1"; //mod
             elseif($totalCorrect1<=400) $gradelevel[0]="2"; //high
/********************Self Awareness 200********************/
			$answer3= isset($_POST['question3answers']) ? $_POST['question3answers'] : "";
			$answer4= isset($_POST['question4answers']) ? $_POST['question4answers'] : "";
			$answer5= isset($_POST['question5answers']) ? $_POST['question5answers'] : "";
			$answer6= isset($_POST['question6answers']) ? $_POST['question6answers'] : "";

			$totalCorrect2 = 0;
			 //Any 2 out of 4 randomly chosen
			 	if ($answer3=="") ;
			elseif ($answer3=="A") $totalCorrect2+=100;
			elseif ($answer3=="B") $totalCorrect2+=100;
			elseif ($answer3=="C") $totalCorrect2+= 50;
			 
			    if ($answer4=="") ;
			elseif ($answer4=="A") $totalCorrect2+=100;
			elseif ($answer4=="B") $totalCorrect2+=100;
			elseif ($answer4=="C") $totalCorrect2+= 50;
			 
			    if ($answer5=="") ;
			elseif ($answer5=="A") $totalCorrect2+=100;
			elseif ($answer5=="B") $totalCorrect2+=100;
			elseif ($answer5=="C") $totalCorrect2+= 50;

			    if ($answer6=="") ;
			elseif ($answer6=="A") $totalCorrect2+=100;
			elseif ($answer6=="B") $totalCorrect2+= 50;
			elseif ($answer6=="C") $totalCorrect2+= 50;

                if($totalCorrect2<=50) $gradelevel[1]="0";//low
            elseif($totalCorrect2<=100) $gradelevel[1]="1";//mod
            elseif($totalCorrect2<=200) $gradelevel[1]="2";//high
/********************Life Vision (Optional) ********************/		
            $answer37  = isset($_POST['question37answers'])   ? $_POST['question37answers']   : "";
            $answer38  = isset($_POST['question38answers'])   ? $_POST['question38answers']   : "";	 
/********************Professionalism 200  ********************/			 
			$answer7   = isset($_POST['question7answers'])    ? $_POST['question7answers']    : "";
			$answer32  = isset($_POST['question32answers'])   ? $_POST['question32answers']   : "";

			$totalCorrect3 = 0;
			    if ($answer7=="A") $totalCorrect3+=100;
			elseif ($answer7=="B") $totalCorrect3+= 50;
			elseif ($answer7=="C") $totalCorrect3+= 30;
			elseif ($answer7=="D") $totalCorrect3+=  0;
			
			if     ($answer32=="C") $totalCorrect3+=100;
			elseif ($answer32=="A") $totalCorrect3+= 80;
			elseif ($answer32=="B") $totalCorrect3+= 50;
			elseif ($answer32=="D") $totalCorrect3+= 30;

                if($totalCorrect3<= 60) $gradelevel[2]="0";//low
            elseif($totalCorrect3<=100) $gradelevel[2]="1";//mod
            elseif($totalCorrect3<=200) $gradelevel[2]="2";//high
/********************Business Communication 600********************/
			$answer8   = isset($_POST['question8answers'])    ? $_POST['question8answers']    : "";
			$answer9   = isset($_POST['question9answers'])    ? $_POST['question9answers']    : "";
			$answer10  = isset($_POST['question10answers'])   ? $_POST['question10answers']   : "";
			$answer11  = isset($_POST['question11answers'])   ? $_POST['question11answers']   : "";
			$answer12  = isset($_POST['question12answers'])   ? $_POST['question12answers']   : "";
			$answer13  = isset($_POST['question13answers'])   ? $_POST['question13answers']   : "";

			 $totalCorrect4 = 0;
			
	        if(in_array("A", $answer8, TRUE) && in_array("B", $answer8, TRUE) && in_array("C", $answer8, TRUE)  )
		    $totalCorrect4 = $totalCorrect4 + 100;
			 
			if($answer9=="A") $totalCorrect4+=100;
			if(in_array("A",$answer10,TRUE)&& !in_array("B",$answer10,TRUE)&& !in_array("C",$answer10,TRUE)&& !in_array("D",$answer10,TRUE))$totalCorrect4+=100;
			if($answer11=="A") $totalCorrect4+=100;
			if($answer12=="A") $totalCorrect4+=100;
			if($answer13=="B") $totalCorrect4+=100;

                if($totalCorrect4<=100) $gradelevel[3]="0";//low
            elseif($totalCorrect4<=400) $gradelevel[3]="1";//mod
            elseif($totalCorrect4<=600) $gradelevel[3]="2";//high
/**********************Prioritization 220/240 **********************/
			$answer14=isset($_POST['question14answers'])  ? $_POST['question14answers']  : "";
			$answer14arr=explode(".",$answer14);

			 $totalCorrect5 = 0;
			if($answer14arr[0]=="D") $totalCorrect5+=20;
			if($answer14arr[1]=="C") $totalCorrect5+=20;
			if($answer14arr[2]=="A") $totalCorrect5+=20;
			if($answer14arr[3]=="E") $totalCorrect5+=20;
			if($answer14arr[4]=="F") $totalCorrect5+=20;
			if($answer14arr[5]=="B") $totalCorrect5+=20;

			if($_POST['prioritization']=="option1")
			{
				$answer15  = isset($_POST['question15answers'])   ? $_POST['question15answers']   : "";
				$totalpri=2.2;
				    if($answer15=='D')
					$totalCorrect5+=100;
				elseif($answer15=='A')
					$totalCorrect5+=80;
				elseif($answer15=='B')
					$totalCorrect5+=50;	
			}

			elseif($_POST['prioritization']=="option2")
			{			
				$answer161 = isset($_POST['question15answers1'])  ? $_POST['question15answers1']  : "";
				$answer162 = isset($_POST['question15answers2'])  ? $_POST['question15answers2']  : "";
		 		$answertop3   =explode(".",$answer161);
		 		$answerbottom3=explode(".",$answer162);
				$totalpri=2.4;

		 		if(in_array("E",$answertop3)) $totalCorrect5+=20;
		 		if(in_array("G",$answertop3)) $totalCorrect5+=20;
		 		if(in_array("K",$answertop3)) $totalCorrect5+=20;

		 		if(in_array("B",$answerbottom3)) $totalCorrect5+=20;
		 		if(in_array("F",$answerbottom3)) $totalCorrect5+=20;
		 		if(in_array("J",$answerbottom3)) $totalCorrect5+=20;
		 	}
			    if($totalCorrect5<= 80) $gradelevel[4]="0";//low
			elseif($totalCorrect5<=160) $gradelevel[4]="1";//mod
			elseif($totalCorrect5<=240) $gradelevel[4]="2";//high
/**********************Professional Awareness 100**********************/
			$answer35  = isset($_POST['question35answers'])   ? $_POST['question35answers']   : "";
            $answer36  = isset($_POST['question36answers'])   ? $_POST['question36answers']   : "";

			$pa=array("A"=>"ABCD","B"=>"EPQFG","C"=>"HI","D"=>"ABJKL","E"=>"JK","F"=>"FL","G"=>"IMNO","H"=>"IPQ","I"=>"RST","J"=>"IMT");
			$pa_ans=$pa[$answer35];
			$count=0;
			for($i=0;$i<count($answer36);$i++)
				if(strpos($pa_ans,$answer36[$i])!==false)
					$count++;

			if($count>=3)     $totalCorrect9=100;
			elseif($count==2) $totalCorrect9= 80;
			elseif($count==1) $totalCorrect9= 50;
			else              $totalCorrect9=  0;

                if($totalCorrect9<  50) $gradelevel[8]="0";//low
            elseif($totalCorrect9<= 80) $gradelevel[8]="1";//mod
            elseif($totalCorrect9<=100) $gradelevel[8]="2";//high	
/**********************Problem Solving 200**********************/
			$answer17  = isset($_POST['question17answers'])   ? $_POST['question17answers']   : "";
			$answer18  = isset($_POST['question18answers'])   ? $_POST['question18answers']   : "";
			$totalCorrect6 = 0;
			
			if(in_array("A", $answer17, TRUE))
			$totalCorrect6 = $totalCorrect6 + 25;
			if(in_array("D", $answer17, TRUE))
			$totalCorrect6 = $totalCorrect6 + 25;
			if(in_array("E", $answer17, TRUE))
			$totalCorrect6 = $totalCorrect6 + 25;
			if(in_array("F", $answer17, TRUE))
			$totalCorrect6 = $totalCorrect6 + 25; 
			 
			if($answer18=="E") $totalCorrect6+=100;
			elseif($answer18=="A") $totalCorrect6+=40;
			elseif($answer18=="B") $totalCorrect6+=40;	
			
                if($totalCorrect6<= 60) $gradelevel[5]="0";//low
            elseif($totalCorrect6<=140) $gradelevel[5]="1";//mod
            elseif($totalCorrect6<=200) $gradelevel[5]="2";//high		 
/**********************Grammar Section 1800**********************/
			$answer19  = isset($_POST['question19answers'])   ? $_POST['question19answers']   : "";
			$answer20  = isset($_POST['question20answers'])   ? $_POST['question20answers']   : "";
			$answer21  = isset($_POST['question21answers'])   ? $_POST['question21answers']   : "";
			$answer22  = isset($_POST['question22answers'])   ? $_POST['question22answers']   : "";
			$answer23  = isset($_POST['question23answers'])   ? $_POST['question23answers']   : "";
			$answer24  = isset($_POST['question24answers'])   ? $_POST['question24answers']   : "";
			$answer25  = isset($_POST['question25answers'])   ? $_POST['question25answers']   : "";
			$answer26  = isset($_POST['question26answers'])   ? $_POST['question26answers']   : "";
			$answer27  = isset($_POST['question27answers'])   ? $_POST['question27answers']   : "";
			$answer28  = isset($_POST['question28answers'])   ? $_POST['question28answers']   : "";
			$answer29  = isset($_POST['question29answers'])   ? $_POST['question29answers']   : "";
			$answer30  = isset($_POST['question30answers'])   ? $_POST['question30answers']   : "";

            $answer301=strtolower(trim(isset($_POST['question30answersA'])  ? $_POST['question30answersA']  : ""));
  			$answer302=strtolower(trim(isset($_POST['question30answersB'])  ? $_POST['question30answersB']  : ""));
  			$answer303=strtolower(trim(isset($_POST['question30answersC'])  ? $_POST['question30answersC']  : ""));
  			$answer304=strtolower(trim(isset($_POST['question30answersD'])  ? $_POST['question30answersD']  : ""));
  			$answer305=strtolower(trim(isset($_POST['question30answersE'])  ? $_POST['question30answersE']  : ""));
  			$answer306= isset($_POST['question30answersF'])  ? $_POST['question30answersF']  : "";

			$totalCorrect7 = 0;
			if($answer19=="A") $totalCorrect7+=100;
			if($answer20=="A") $totalCorrect7+=100;
			if($answer21=="A") $totalCorrect7+=100;
			if($answer22=="B") $totalCorrect7+=100;
			if($answer23=="B") $totalCorrect7+=100;
			if($answer24=="A") $totalCorrect7+=100;
			if($answer25=="A") $totalCorrect7+=100;
			if($answer26=="C") $totalCorrect7+=100;
			if($answer27=="C") $totalCorrect7+=100;
			if($answer28=="B") $totalCorrect7+=100;
			if($answer29=="D") $totalCorrect7+=100;
			if($answer30=="B") $totalCorrect7+=100;
			 
		 	if($answer301=="for"||$answer301=="as"||$answer301=="at"||$answer301=="with")
		 		$totalCorrect7+=100;
			if($answer302=="in")
				$totalCorrect7+=100;
			if($answer303=="to")
				$totalCorrect7+=100;
			if($answer304=="for")
				$totalCorrect7+=100;
			if($answer305=="at"||$answer305=="by"||$answer305=="after"||$answer305=="before"||$answer305=="around")
				$totalCorrect7+=100;
 
			if ($answer306=="B") $totalCorrect7+=100;

                if($totalCorrect7<= 600) $gradelevel[6]="0";//low
            elseif($totalCorrect7<=1200) $gradelevel[6]="1";//mod
            elseif($totalCorrect7<=1800) $gradelevel[6]="2";//high
/**********************Ethics Section 300 changed**********************/	
			$answer31  = isset($_POST['question31answers'])   ? $_POST['question31answers']   : "";
			$answer33  = isset($_POST['question33answers'])   ? $_POST['question33answers']   : "";
			$answer34  = isset($_POST['question34answers'])   ? $_POST['question34answers']   : "";	 
			$totalCorrect8 = 0;
			 
			if     ($answer31=="B") $totalCorrect8+=100;
			elseif ($answer31=="D") $totalCorrect8+=50;
			
			if($answer33=="A") $totalCorrect8+=100;
			
			if($answer34=="A") $totalCorrect8+=100;
			elseif($answer34=="B") $totalCorrect8+=50;

                if($totalCorrect8<=130) $gradelevel[7]="0";//low
            elseif($totalCorrect8<=250) $gradelevel[7]="1";//mod
            elseif($totalCorrect8<=400) $gradelevel[7]="2";//high
/**********************Percentage Calculation**********************/
			$totalCorrect1/=4;         $totalCorrect1=round($totalCorrect1, 2); //Self Belief
			$totalCorrect2/=2;         $totalCorrect2=round($totalCorrect2, 2); //Self Awareness
			$totalCorrect3/=2;         $totalCorrect3=round($totalCorrect3, 2); //Professionalism
			$totalCorrect4/=6;         $totalCorrect4=round($totalCorrect4, 2); //Business Communication
	        $totalCorrect5/=$totalpri; $totalCorrect5=round($totalCorrect5, 2); //Prioritization 
			$totalCorrect6/=2;         $totalCorrect6=round($totalCorrect6, 2); //Problem Solving
			$totalCorrect7/=18;        $totalCorrect7=round($totalCorrect7, 2); //Grammar
			$totalCorrect8/=4;         $totalCorrect8=round($totalCorrect8, 2); //Ethics
			$totalCorrect9/=1;         $totalCorrect9=round($totalCorrect9, 2); //Professional Awareness 
		
			$totalCorrect = ($totalCorrect1+$totalCorrect2+$totalCorrect3+$totalCorrect4+$totalCorrect5+$totalCorrect6+$totalCorrect7+$totalCorrect8+$totalCorrect9)/9;

			$totalCorrect=round($totalCorrect, 2);
/***********************Grading Statement Responses********************/
            $gradelv="";
            for($i=0;$i<9;$i++)
            {
            	if($i<8)$gradelv.=$gradelevel[$i].".";
    			else    $gradelv.=$gradelevel[$i];
    		}
            // 0-Low, 1-Moderate, 2-High

	endif; //endif isset wrap-submit (line 25)

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
/**************************Insert into results table*****************************/
            
            $email=$_SESSION["useremail"];
        	$firstname=$_SESSION["firstname"];
    		$lastname=$_SESSION["lastname"];
    		$accountno=$_SESSION["accountno"];

            $fullname=$firstname." ".$lastname;

			require 'connectsql.php';    
            $sql="SELECT `topscore` FROM `topscoretable` LIMIT 1;";

            $result=mysqli_query($DBcon,$sql);
            $row = mysqli_fetch_array($result);
            $topscore=$row['topscore'];
        
            if($totalCorrect>=$topscore)
            {
                $percentile=99;
                $sql="UPDATE `topscoretable` SET `topscore`='$totalCorrect',`name`='$fullname' WHERE `topscore`='$topscore';";
                mysqli_query($DBcon,$sql);
            }
            else
			$percentile=round(($totalCorrect/$topscore*100),0);

			$answer37=mysqli_real_escape_string($DBcon, nl2br($answer37));
			$answer38=mysqli_real_escape_string($DBcon, nl2br($answer38));

			// if(isset($_POST['industryconn'])) $industryconn=true; 
			// else $industryconn=false;

			//Generating Random Certificate ID
			function getrandom()
			{
				$chars = "123456789"; $chars2= "ABCDEFGHIJKLMNPQRSTUVWXYZ";
				$res = "";
				for ($j=0;$j<8; $j++)
				{
					if($j>2) $res .= $chars[mt_rand(0, strlen($chars)-1)];
					else     $res .= $chars2[mt_rand(0, strlen($chars2)-1)];
				}
				return $res;
			}
			function generate_id(){
				require 'connectsql.php';
				$notgenerated=true;
				$random="";

				while($notgenerated)
				{
					$random=getrandom(); 
					//Checks if ID isn't already in database
					if(! mysqli_num_rows(mysqli_query($DBcon,"SELECT `id` FROM `results` WHERE `certificate`='$random'")))
					$notgenerated=false;
				}
				return $random;
			}

			$certificateid=generate_id();
			
    		$date=date("Y-m-d h:i:sa");
			if(isset($_POST['wrap-submit'])):
	    		$sql = "INSERT INTO `results`(`accountno`,`firstname`, `lastname`, `email`, `certificate`, `lv1`, `lv2`, `graded`, `gradelevel`, `avg`, `percentile`, `selfbelief`, `selfaware`, `professionalism`, `businesscomm`, `profaware`, `prioritization`, `probsolve`, `grammar`, `ethics`, `resulttime`,`industryconn`) VALUES ('$accountno','$firstname','$lastname','$email','$certificateid','$answer37','$answer38','false','$gradelv','$totalCorrect','$percentile','$totalCorrect1','$totalCorrect2','$totalCorrect3','$totalCorrect4','$totalCorrect9','$totalCorrect5','$totalCorrect6','$totalCorrect7','$totalCorrect8','$date','0')";

	    		if (mysqli_query($DBcon, $sql)) ;
	                        /*echo "New sign in record created successfully"; */
	            else 
	            echo "Error: " . $sql . "<br>" . mysqli_error($DBcon);
        	endif;

        	if(isset($_SESSION['useremail'])&&isset($_POST['wrap-submit']))
        		if(!in_array($_SERVER['REMOTE_ADDR'],array('127.0.0.1','::1')))
        			{
						include("vendor/phpmailer/phpmailer/PHPMailerAutoload.php");
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

						    $fullname=$_SESSION['firstname']." ".$_SESSION['lastname'];
						    $mail->AddAddress($_SESSION['useremail'], $fullname); 
						    
						    $mail->Subject = 'WRAP Score Report';
						    $mail->AddEmbeddedImage('img/logoemail.gif', 'logo');
						    //$mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
						    $emailbody='<!DOCTYPE html>
										<html>
										<head>
										</head>
										<body>
											<img src="cid:logo" width=\"150px\"/><br>

											Dear '.$fullname.',<br><br>
											Your <b>work ready score</b> is '.$totalCorrect.'% ,<br><br>
											Your WRAP percentile score is '.$percentile.'<br>
											WRAP Percentile Rank is a score which has values from 1 to 99. It compares performance to other students taking the same test.<br><br>
											Your scores in each of the sections are:
											<ul>
												<li>Your <b>Self Belief</b> score is: '.$totalCorrect1.'% <br> '.$statement[0][$gradelevel[0]].'</li><br>
												<li>Your <b>Self Awareness</b> score is: '.$totalCorrect2.'% <br> '.$statement[1][$gradelevel[1]].'</li><br>
												<li>Your <b>Professionalism</b> score is: '.$totalCorrect3.'% <br> '.$statement[2][$gradelevel[2]].'</li><br>
												<li>Your <b>Business Communication</b> score is: '.$totalCorrect4.'% <br> '.$statement[3][$gradelevel[3]].'</li><br>
												<li>Your <b>Professional Awareness</b> score is: '.$totalCorrect9.'% <br> '.$statement[8][$gradelevel[8]].'</li><br>
												<li>Your <b>Prioritization</b> score is: '.$totalCorrect5.'% <br> '.$statement[4][$gradelevel[4]].'</li><br>
												<li>Your <b>Problem Solving</b> score is: '.$totalCorrect6.'% <br> '.$statement[5][$gradelevel[5]].'</li><br>
												<li>Your <b>Grammar</b> score is: '.$totalCorrect7.'% <br> '.$statement[6][$gradelevel[6]].'</li><br>
												<li>Your <b>Ethics</b> score is: '.$totalCorrect8.'% <br> '.$statement[7][$gradelevel[7]].'</li>
											</ul>
											Feel free to book a slot for a personalized mentorship session with us by <a href="https://talerang.setmore.com" target="_new">clicking here</a><br><br>
											Regards,<br>
											Team Talerang
										</body>
										</html>';

						    $mail->MsgHTML($emailbody);
						      
						    if(!$mail->Send())
						    echo '<div class="alert alert-warning">Email with score report could not be sent. Please view the scores on your <a href="dashboard.php" class="alert-link">dashboard</a></div>';
						    
						} catch (phpmailerException $e) {
						    echo $e->errorMessage(); 
						} catch (Exception $e) {
						    echo $e->getMessage(); 
						}

						include("vendor/phpmailer/phpmailer/PHPMailerAutoload.php");
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

						    $fullname=$_SESSION['firstname']." ".$_SESSION['lastname'];
						    $mail->AddAddress($_SESSION['useremail'],$fullname); 
						    //$mail->AddAddress('azeem.talerang@gmail.com', 'Azeem Merchant'); 
						    //$mail->AddAddress('azeem_merchant999@hotmail.com', 'Azeem Merchant'); 
						    
						    $mail->Subject = 'Feedback for Talerang Express';
						    $mail->AddEmbeddedImage('img/logoemail.gif', 'logo');
						    
						    $id=sha1(uniqid(rand(), true));

						    //$mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
						   $emailbody='<!DOCTYPE html>
						    <html>
						    <head></head>
						    <body>
						    <img src="cid:logo" width="150px"/>
						    <br>
						    Dear '.$fullname.',
						    <br><br>
						    Thank you for using Talerang Express. Was the service friendly and helpful? Please take a moment to tell us how we did.
						    <br><br>
						    How satisfied were you with our online platform? (Click on one of the boxes below)
						    <br><br>
						    <div style="font-family: Arial; font-size: 14px;">
						    	<span style="display: inline-block; text-align:center; min-width: 10%; max-width: 120px; margin-right: 5px; background-color: #2abf29; padding: 5px;"><a href="http://www.talerang.com/express/feedback.php?id='.$id.'&rate=5" target="_blank" style="color: black; text-decoration: none">Very satisfied</a></span>
						    	<span style="display: inline-block; text-align:center; min-width: 10%; max-width: 120px; margin-right: 5px; background-color: #d1e231; padding: 5px;"><a href="http://www.talerang.com/express/feedback.php?id='.$id.'&rate=4" target="_blank" style="color: black; text-decoration: none">Satisfied</a></span>
						    	<span style="display: inline-block; text-align:center; min-width: 10%; max-width: 120px; margin-right: 5px; background-color: #fcf800; padding: 5px;"><a href="http://www.talerang.com/express/feedback.php?id='.$id.'&rate=3" target="_blank" style="color: black; text-decoration: none">Neutral</a></span>
						    	<span style="display: inline-block; text-align:center; min-width: 10%; max-width: 120px; margin-right: 5px; background-color: #eb792a; padding: 5px;"><a href="http://www.talerang.com/express/feedback.php?id='.$id.'&rate=2" target="_blank" style="color: black; text-decoration: none">Unsatisfied</a></span>
						    	<span style="display: inline-block; text-align:center; min-width: 10%; max-width: 120px; margin-right: 5px; background-color: #f71e0a; padding: 5px;"><a href="http://www.talerang.com/express/feedback.php?id='.$id.'&rate=1" target="_blank" style="color: black; text-decoration: none">Very unsatisfied</a></span>
						    	</div>
						    	<br>This feedback will be kept anonymous.<br><br>Regards,<br>Team Talerang
						    	</body>
						    	</html>';

						    $mail->MsgHTML($emailbody);
						      
						    if(!$mail->Send())
						    echo '<div class="alert alert-warning">Feedback message could not be sent</div>';
						    else header('location:dashboard.php');
						    
						} catch (phpmailerException $e) {
						    echo $e->errorMessage(); 
						} catch (Exception $e) {
						    echo $e->getMessage(); 
						}
        			}//endif email results + email feedback
			?>
			<?php if(isset($_SESSION['useremail'])): ?>
				 	<div>
				 		Please view your results on the <a href="dashboard.php">dashboard!</a>
				 	</div>
			 <?php else: ?>
			 		<div>
				 		You are not signed in!<br>
						Please <a href="index.php">Sign in</a> first
				 	</div>
			 <?php endif ?>
	</div>
	<?php include 'footer.php' ?>
</div>
<?php include 'jqueryload.php' ?>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>

</html>