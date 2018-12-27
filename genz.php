<?php session_start(); 
      date_default_timezone_set('Asia/Kolkata'); 
      if(isset($_SESSION['quizid'])) 
      	   $quizid=$_SESSION['quizid'];
      else $quizid=uniqid();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="robots" content="index, follow">
	<title>Talerang Express | Gen Z Quiz</title>
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css?version=2.1" />
	<link rel="stylesheet" type="text/css" href="css/landingstyle.css" />
	<link rel="stylesheet" type="text/css" href="css/genz.css" />
    <?php include 'noscript.php' ?>
    <?php include 'jqueryload.php' ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
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
	        <li class="nav-link"><a href="skilltraining.php"><span>Back</span></a></li>
	        <li class="nav-link"><a href="logout.php"><span>Logout</span></a></li>
	      </ul>
	    </div><!-- /.navbar-collapse -->
	    <?php endif ?>
	  </div><!-- /.container-fluid -->
	</nav>

	<div id="content">


	<div class="ribbon container-fluid">
        <div class="container" id="middle">
            Gen Z Quiz
        </div>
    </div>

	<div class="container">
		<div class="row">
		<?php 
		   	require 'connectsql.php';   

		   	if(isset($_SESSION['useremail']))
		   	{
				$email=$_SESSION['useremail'];
				$fullname=$_SESSION['firstname']." ".$_SESSION['lastname'];
		   	}
			else
			{
				$email='---';
				$fullname='---';
			}

			if(isset($_POST['quizstart'])) //runs on ajax call
			{
				$date=date('Y-m-d h:i:sa');
				$sql="INSERT INTO `genz` (`quizid`,`email`,`fullname`,`starttime`)
						VALUES ('$quizid','$email','$fullname','$date');";

				mysqli_query($DBcon,$sql);
			}

			if(isset($_POST['score'])&&isset($_POST['answers'])) //runs on ajax call
			{
				$score=$_POST['score'];
				$answers=$_POST['answers'];
				$enddate=date('h:i:sa');

				$sql="UPDATE `genz` 
					  SET `endtime`='$enddate',`score`='$score', `answers`='$answers'
					  WHERE `quizid`='$quizid'
					  ORDER BY `id` DESC 
					  LIMIT 1;";

				mysqli_query($DBcon,$sql);
			}
			?>

			<form name="genz" id="genz" method="post"> 
			<div id="timerouter"><div id="timer" style="display: none;">Time left: <span id="timerclock">15</span></div></div>
			<div class="quiz-step container start current step0" id="firstquizstep" style="display:block">
				<div>
					<p>How well do you know Generation Z?</p>
				</div>
				<input type="radio" id="quizstart" class="quiz-answer" />
				<label class="dummy" for="quizstart">Start</label>
			</div>
			<div class="quiz-step container step1 question">
		     	<h2 class="question-title">Gen Z is best described as?</h2>
			    <ul class="no-bullet answers row">
			        <li class="col-md-6">
			            <input type="radio" name="q1" value="A" class="quiz-answer" id="q1a1"/>
			            <label for="q1a1">The most diverse generation</label>
			        </li>
			        <li class="col-md-6">
			            <input type="radio" name="q1" value="B" class="quiz-answer" id="q1a2"/>
			            <label for="q1a2">The largest generation by population</label>
			        </li>
			        <li class="col-md-6">
			            <input type="radio" name="q1" value="C" class="quiz-answer" id="q1a3"/>
			            <label for="q1a3">The most anti-social generation</label>
			        </li>
			        <li class="col-md-6">
			            <input type="radio" name="q1" value="D" class="quiz-answer" id="q1a4"/>
			            <input type="radio" name="q1" value="T" class="quiz-answer displaynone timeover" id="q1at"/>
			            <label for="q1a4">Less dependent on technology than Millennials</label>
			        </li>
			    </ul>
			</div>
			<div class="quiz-step container step1 answer-step">
				<div class="row">
					<div class="col-md-12 answer-image"></div>
					<div class="col-md-12 answer-desc">
						Generation Z is the most radically diverse group, and they hold a positive review of diversity than the generations before them
					</div>
					<div class="col-md-12">
						<input type="radio" name="dummy" class="quiz-answer" id="dummy1">
						<label class="dummy" for="dummy1">Next Question</label>
					</div>
				</div>
			</div>
			<div class="quiz-step container step2 question">
			    <h2 class="question-title">Their social network of choice is?</h2>
			    <ul class="no-bullet answers row image-options">
			        <li class="col-md-3 col-sm-6 col-xs-6">
			            <input type="radio" name="q2" value="A" class="quiz-answer" id="q2a1"/>
			            <label for="q2a1">
			            	<img src="img/genz/facebook.png" alt="Facebook" />
			            </label>
			        </li>
			        <li class="col-md-3 col-sm-6 col-xs-6">
			            <input type="radio" name="q2" value="B" class="quiz-answer" id="q2a2"/>
			            <label for="q2a2">
			            	<img src="img/genz/twitter.png" alt="Twitter" />
			            </label>
			        </li>
			        <li class="col-md-3 col-sm-6 col-xs-6">
			            <input type="radio" name="q2" value="C" class="quiz-answer" id="q2a3"/>
			            <label for="q2a3">
			            	<img src="img/genz/snapchat.png" alt="Snapchat" />
			            </label>
			        </li>
			        <li class="col-md-3 col-sm-6 col-xs-6">
			            <input type="radio" name="q2" value="D" class="quiz-answer" id="q2a4"/>
			            <input type="radio" name="q2" value="T" class="quiz-answer displaynone timeover" id="q2at"/>
			            <label for="q2a4">
			            	<img src="img/genz/pinterest.png" alt="Pinterest" />
			            </label>
			        </li>
			    </ul>
			</div>
			<div class="quiz-step container step2 answer-step">
				<div class="row">
					<div class="col-md-12 answer-image"></div>
					<div class="col-md-12 answer-desc">
						Generation Z values its privacy, and Snapchat, a platform where content is eventually erased, appeals to the source of the audience
					</div>
					<div class="col-md-12">
						<input type="radio" name="dummy" class="quiz-answer" id="dummy2">
						<label class="dummy" for="dummy2">Next Question</label>
					</div>
				</div>
			</div>
			<div class="quiz-step container step3 question">
			    <h2 class="question-title">Which is not a nickname of Generation Z?</h2>
			    <ul class="no-bullet answers row">
			        <li class="col-md-6">
			            <input type="radio" name="q3" value="A" class="quiz-answer" id="q3a1"/>
			            <label for="q3a1">Centennials</label>
			        </li>
			        <li class="col-md-6">
			            <input type="radio" name="q3" value="B" class="quiz-answer" id="q3a2"/>
			            <label for="q3a2">Post Millennials</label>
			        </li>
			        <li class="col-md-6">
			            <input type="radio" name="q3" value="C" class="quiz-answer" id="q3a3"/>
			            <label for="q3a3">iGeneration</label>
			        </li>
			        <li class="col-md-6">
			            <input type="radio" name="q3" value="D" class="quiz-answer" id="q3a4"/>
			            <input type="radio" name="q3" value="T" class="quiz-answer displaynone timeover" id="q3at"/>
			            <label for="q3a4">The Z Squad</label>
			        </li>
			    </ul>
			</div>			
			<div class="quiz-step container step3 answer-step">
				<div class="row">
					<div class="col-md-12 answer-image"></div>
					<div class="col-md-12 answer-desc">
						Generation Z is known by many names but The Z Squad is not one on them
					</div>
					<div class="col-md-12">
						<input type="radio" name="dummy" class="quiz-answer" id="dummy3">
						<label class="dummy" for="dummy3">Next Question</label>
					</div>
				</div>
			</div>
			<div class="quiz-step container step4 question">
			    <h2 class="question-title">Gen Z spends approximately ___ hours a week on their smartphones</h2>
			    <ul class="no-bullet answers row">
			        <li class="col-md-6">
			            <input type="radio" name="q4" value="A" class="quiz-answer" id="q4a1"/>
			            <label for="q4a1">5</label>
			        </li>
			        <li class="col-md-6">
			            <input type="radio" name="q4" value="B" class="quiz-answer" id="q4a2"/>
			            <label for="q4a2">10</label>
			        </li>
			        <li class="col-md-6">
			            <input type="radio" name="q4" value="C" class="quiz-answer" id="q4a3"/>
			            <label for="q4a3">15</label>
			        </li>
			        <li class="col-md-6">
			            <input type="radio" name="q4" value="D" class="quiz-answer" id="q4a4"/>
			            <input type="radio" name="q4" value="T" class="quiz-answer displaynone timeover" id="q4at"/>
			            <label for="q4a4">20</label>
			        </li>
			    </ul>
			</div>			
			<div class="quiz-step container step4 answer-step">
				<div class="row">
					<div class="col-md-12 answer-image"></div>
					<div class="col-md-12 answer-desc">
						Gen Z spends approximately 15.4 hours a week on smartphones. That’s more than Millennials who spend 14.8 hours on their smartphones
					</div>
					<div class="col-md-12">
						<input type="radio" name="dummy" class="quiz-answer" id="dummy4">
						<label class="dummy" for="dummy4">Next Question</label>
					</div>
				</div>
			</div>
			<div class="quiz-step container step5 question">
			    <h2 class="question-title">Quick - pick the Post Millenial!</h2>
			    <ul class="no-bullet answers row image-options">
			        <li class="col-md-3 col-sm-6 col-xs-6">
			            <input type="radio" name="q5" value="A" class="quiz-answer" id="q5a1"/>
			            <label for="q5a1">
			            	<img src="img/genz/chandler-riggs.jpg" alt="Chandler Riggs" />
			            </label>
			        </li>
			        <li class="col-md-3 col-sm-6 col-xs-6">
			            <input type="radio" name="q5" value="B" class="quiz-answer" id="q5a2"/>
			            <label for="q5a2">
			            	<img src="img/genz/rihanna.jpg" alt="Rihanna" />
			            </label>
			        </li>
			        <li class="col-md-3 col-sm-6 col-xs-6">
			            <input type="radio" name="q5" value="C" class="quiz-answer" id="q5a3"/>
			            <label for="q5a3">
			            	<img src="img/genz/miley-cyrus.jpg" alt="Miley Cyrus" />
			            </label>
			        </li>
			        <li class="col-md-3 col-sm-6 col-xs-6">
			            <input type="radio" name="q5" value="D" class="quiz-answer" id="q5a4"/>
			            <input type="radio" name="q5" value="T" class="quiz-answer displaynone timeover" id="q5at"/>
			            <label for="q5a4">
			            	<img src="img/genz/justin-timberlake.jpg" alt="Justin Timberlake" />
			            </label>
			        </li>
			    </ul>
			</div>			
			<div class="quiz-step container step5 answer-step">
				<div class="row">
					<div class="col-md-12 answer-image"></div>
					<div class="col-md-12 answer-desc">
						Chandler Riggs best known as Carl in “The Walking Dead” is the only Post Millenial of this list. He was born in 1999
					</div>
					<div class="col-md-12">
						<input type="radio" name="dummy" class="quiz-answer" id="dummy5">
						<label class="dummy" for="dummy5">Next Question</label>
					</div>
				</div>
			</div>
			<div class="quiz-step container step6 question">
			    <h2 class="question-title">Gen Z is less visual than the generations before it</h2>
			    <ul class="no-bullet answers row">
			        <li class="col-md-6">
			            <input type="radio" name="q6" value="A" class="quiz-answer" id="q6a1"/>
			            <label for="q6a1">True</label>
			        </li>
			        <li class="col-md-6">
			            <input type="radio" name="q6" value="B" class="quiz-answer" id="q6a2"/>
			            <input type="radio" name="q6" value="T" class="quiz-answer displaynone timeover" id="q6at"/>
			            <label for="q6a2">False</label>
			        </li>
			    </ul>
			</div>			
			<div class="quiz-step container step6 answer-step">
				<div class="row">
					<div class="col-md-12 answer-image"></div>
					<div class="col-md-12 answer-desc">
						From emojis to videos, Gen Z prefer to communicate through visuals
					</div>
					<div class="col-md-12">
						<input type="radio" name="dummy" class="quiz-answer" id="dummy6">
						<label class="dummy" for="dummy6">Next Question</label>
					</div>
				</div>
			</div>
			<div class="quiz-step container step7 question">
			    <h2 class="question-title">Want to talk to a Post Millenial? Make it:</h2>
			    <ul class="no-bullet answers row">
			        <li class="col-md-12">
			            <input type="radio" name="q7" value="A" class="quiz-answer" id="q7a1"/>
			            <label for="q7a1">Short and sweet. They have short attention spans</label>
			        </li>
			        <li class="col-md-12">
			            <input type="radio" name="q7" value="B" class="quiz-answer" id="q7a2"/>
			            <input type="radio" name="q7" value="T" class="quiz-answer displaynone timeover" id="q7at"/>
			            <label for="q7a2">Long and detailed. They want all the information</label>
			        </li>
			    </ul>
			</div>			
			<div class="quiz-step container step7 answer-step">
				<div class="row">
					<div class="col-md-12 answer-image"></div>
					<div class="col-md-12 answer-desc">
						On average Gen Z has an attention span of 8 seconds. If you want to get their attention keep it brief
					</div>
					<div class="col-md-12">
						<input type="radio" name="dummy" class="quiz-answer" id="dummy7">
						<label class="dummy" for="dummy7">Next Question</label>
					</div>
				</div>
			</div>
			<div class="quiz-step container step8 question">
			    <h2 class="question-title">When it comes to technology Gen Z uses ____ screens on average</h2>
			    <ul class="no-bullet answers row">
			        <li class="col-md-6">
			            <input type="radio" name="q8" value="A" class="quiz-answer" id="q8a1"/>
			            <label for="q8a1">3</label>
			        </li>
			        <li class="col-md-6">
			            <input type="radio" name="q8" value="B" class="quiz-answer" id="q8a2"/>
			            <label for="q8a2">4</label>
			        </li>
			        <li class="col-md-6">
			            <input type="radio" name="q8" value="C" class="quiz-answer" id="q8a3"/>
			            <label for="q8a3">5</label>
			        </li>
			        <li class="col-md-6">
			            <input type="radio" name="q8" value="D" class="quiz-answer" id="q8a4"/>
			            <input type="radio" name="q8" value="T" class="quiz-answer displaynone timeover" id="q8at"/>
			            <label for="q8a4">6</label>
			        </li>
			    </ul>
			</div>			
			<div class="quiz-step container step8 answer-step">
				<div class="row">
					<div class="col-md-12 answer-image"></div>
					<div class="col-md-12 answer-desc">
						Consider Gen Z a group of multitaskers. This generation uses smart phones, tablets, desktops and television
					</div>
					<div class="col-md-12">
						<input type="radio" name="dummy" class="quiz-answer" id="dummy8">
						<label class="dummy" for="dummy8">Next Question</label>
					</div>
				</div>
			</div>
			<div class="quiz-step container step9 question">
			    <h2 class="question-title">Generation Z's preferred method of communication is :</h2>
			    <ul class="no-bullet answers row image-options">
			        <li class="col-md-3 col-sm-6 col-xs-6">
			            <input type="radio" name="q9" value="A" class="quiz-answer" id="q9a1"/>
			            <label for="q9a1"><img src="img/genz/post.jpg"><div class="image-caption">Snail Mail</div></label>
			        </li>
			        <li class="col-md-3 col-sm-6 col-xs-6">
			            <input type="radio" name="q9" value="B" class="quiz-answer" id="q9a2"/>
			            <label for="q9a2"><img src="img/genz/telephone.jpg"><div class="image-caption">Telephone</div></label>
			        </li>
			        <li class="col-md-3 col-sm-6 col-xs-6">
			            <input type="radio" name="q9" value="C" class="quiz-answer" id="q9a3"/>
			            <label for="q9a3"><img src="img/genz/socialmedia.jpg"><div class="image-caption">Social Media</div></label>
			        </li>
			        <li class="col-md-3 col-sm-6 col-xs-6">
			            <input type="radio" name="q9" value="D" class="quiz-answer" id="q9a4"/><input type="radio" name="q9" value="T" class="quiz-answer displaynone timeover" id="q9at"/>
			            <label for="q9a4"><img src="img/genz/messagingapps.jpg"><div class="image-caption">Messaging Apps</div></label>
			        </li>
			    </ul>
			</div>			
			<div class="quiz-step container step9 answer-step">
				<div class="row">
					<div class="col-md-12 answer-image"></div>
					<div class="col-md-12 answer-desc">
						From identity theft to online bullying; this generation understands the risks the internet presents and as a result is very concerned about privacy. Messaging Gen Z via apps will keep them at ease
					</div>
					<div class="col-md-12">
						<input type="radio" name="dummy" class="quiz-answer" id="dummy9">
						<label class="dummy" for="dummy9">Next Question</label>
					</div>
				</div>
			</div>
			<div class="quiz-step container step10 question">
			    <h2 class="question-title">The first set of Gen Z enters college in?</h2>
			    <ul class="no-bullet answers row">
			        <li class="col-md-6">
			            <input type="radio" name="q10" value="A" class="quiz-answer" id="q10a1"/>
			            <label for="q10a1">2017</label>
			        </li>
			        <li class="col-md-6">
			            <input type="radio" name="q10" value="B" class="quiz-answer" id="q10a2"/>
			            <label for="q10a2">2018</label>
			        </li>
			        <li class="col-md-6">
			            <input type="radio" name="q10" value="C" class="quiz-answer" id="q10a3"/>
			            <label for="q10a3">2019</label>
			        </li>
			        <li class="col-md-6">
			            <input type="radio" name="q10" value="D" class="quiz-answer" id="q10a4"/>
			            <label for="q10a4">2020</label>
			        </li>
			        <li class="col-md-12">
			            <input type="radio" name="q10" value="E" class="quiz-answer" id="q10a5"/>
			            <input type="radio" name="q10" value="T" class="quiz-answer displaynone timeover" id="q10at"/>
			            <label for="q10a5">None of the above. The first set has already enrolled</label>
			        </li>
			    </ul>
			</div>			
			<div class="quiz-step container step10 answer-step last">
				<div class="row">
					<div class="col-md-12 answer-image"></div>
					<div class="col-md-12 answer-desc">
						The early end of Gen Z was born in 1995, meaning they are already enrolled in colleges and universities
					</div>
					<div class="col-md-12">
						<input type="radio" name="dummy" class="quiz-answer" id="dummy10">
						<label class="dummy" for="dummy10">Show results</label>
					</div>
				</div>
			</div>

			<div class="quiz-step container result end" id="results">
			    <div class="row">
			    	<div class="col-md-12">
			    		<h2 class="question-title score-title"></h2>
			    		<button type="button" id="shareBtn" class="btn-facebook">Share on Facebook</button>
			    		<p>
				    		<div id="workforce">
				    			By 2020 Gen Z will make up about 10% of the workforce.
				    		</div>
				    		<div>
					    		Are you amongst them?<br>
					    		What do you want from your career?<br>
					    		What are your concerns for your future?
					    	</div>
					    	<?php if (!isset($_SESSION['useremail'])): ?>
					    	<div style="color: black;">Like this quiz? <a href="index.php">Register now!</a></div>
					    	<?php endif; ?>
			    		</p>
			    	</div>
			    </div>
			</div>
			</form>

			<div id="qno">Question <span id="stepno">1</span> of 10</div>
			
		</div>     <!--close row    -->
	</div>  <!-- close container -->

	</div> <!--close content -->
	<div class="hidden-print">
	<?php include 'footer.php' ?>
	</div>
</div> <!--close wrapper    -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="js/genz.js" type="text/javascript"></script>
</body>
</html>