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
	<title>Talerang Express | Jobs vs Higher Studies vs Entrepreneurship Quiz</title>
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css?version=2.1" />
	<link rel="stylesheet" type="text/css" href="css/landingstyle.css" />
	<link rel="stylesheet" type="text/css" href="css/jhe.css" />
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
            Jobs vs Higher Studies vs Entrepreneurship
        </div>
    </div>

	<div class="container">
		<div class="row" id="question-row">
			<form name="jhe" id="jhe" method="post"> 

<?php 
	require 'connectsql.php';
	if(isset($_SESSION['useremail']))
	{
		$fullname=$_SESSION['firstname']." ".$_SESSION['lastname'];
		$email=$_SESSION['useremail'];
	}
	else
	{
		$fullname='---';
		$email='---';
	}	

	if(isset($_POST['jhe_start'])) //runs on AJAX call from jhe.js
	{
		$date=date("Y-m-d h:i:sa");
		$sql="INSERT INTO `jhe` (`quizid`,`email`,`fullname`,`starttime`)
				VALUES('$quizid','$email','$fullname','$date');";
		mysqli_query($DBcon,$sql); 
	}
	if(isset($_POST['jhe_end'])) //runs on AJAX call from jhe.js
	{
		$j=$_POST['j'];
		$e=$_POST['e'];
		$h=$_POST['h'];
		$highest=$_POST['highest'];
		    if($highest=='j')   $highest='Jobs';
		elseif($highest=='e')   $highest='Entrepreneurship';
		elseif($highest=='h')   $highest='Higher Studies';
		elseif($highest=='jeh') $highest='All';
		$date=date("h:i:sa");
		$answer=$_POST['answer'];

		$sql="UPDATE `jhe` 
			  SET `endtime`='$date',`answers`='$answer',`j`='$j',`h`='$h',`e`='$e',`outcome`='$highest'
			  WHERE `quizid`='$quizid'
			  ORDER BY `id` DESC 
			  LIMIT 1;";

		mysqli_query($DBcon,$sql);
	}
?>
			<div class="quiz-step container start current step0" id="firstquizstep" style="display:block">
				<div>	
					<p>
						What is the right path for you immediately after college?<br>
						Take our quiz to find out!
					</p>
				</div>
				<input type="radio" id="quizstart" class="quiz-answer" />
				<label class="dummy" for="quizstart">Start</label>
			</div>
			<div class="quiz-step container step1 question">
		     	<h2 class="question-title">Do you intend to further pursue the core subject you are currently enrolled in?</h2>
			    <ul class="no-bullet answers row">
			        <li class="col-md-offset-3 col-md-6 col-sm-12 col-xs-12">
			            <input type="radio" name="q1" value="Y" class="quiz-answer" id="q1a1"/>
			            <label for="q1a1">Yes</label>
			        </li>
			        <li class="col-md-offset-3 col-md-6 col-sm-12 col-xs-12">
			            <input type="radio" name="q1" value="N" class="quiz-answer" id="q1a2"/>
			            <label for="q1a2">No</label>
			        </li>
			    </ul>
			</div>
			<div class="quiz-step container step2 question">
			    <h2 class="question-title">Do you feel excited about managing and building a team?</h2>
			    <ul class="no-bullet answers row">
			        <li class="col-md-offset-3 col-md-6 col-sm-12 col-xs-12">
			            <input type="radio" name="q2" value="Y" class="quiz-answer" id="q2a1"/>
			            <label for="q2a1">Yes</label>
			        </li>
			        <li class="col-md-offset-3 col-md-6 col-sm-12 col-xs-12">
			            <input type="radio" name="q2" value="N" class="quiz-answer" id="q2a2"/>
			            <label for="q2a2">No</label>
			        </li>
			    </ul>
			</div>
			<div class="quiz-step container step3 question">
			    <h2 class="question-title">Do you want a well settled peaceful life with less risk?</h2>
			    <ul class="no-bullet answers row">
			        <li class="col-md-offset-3 col-md-6 col-sm-12 col-xs-12">
			            <input type="radio" name="q3" value="Y" class="quiz-answer" id="q3a1"/>
			            <label for="q3a1">Yes</label>
			        </li>
			        <li class="col-md-offset-3 col-md-6 col-sm-12 col-xs-12">
			            <input type="radio" name="q3" value="N" class="quiz-answer" id="q3a2"/>
			            <label for="q3a2">No</label>
			        </li>
			    </ul>
			</div>			
			<div class="quiz-step container step4 question">
			    <h2 class="question-title">Do you have a passion which can be converted into a business idea?</h2>
			    <ul class="no-bullet answers row">
			        <li class="col-md-offset-3 col-md-6 col-sm-12 col-xs-12">
			            <input type="radio" name="q4" value="Y" class="quiz-answer" id="q4a1"/>
			            <label for="q4a1">Yes</label>
			        </li>
			        <li class="col-md-offset-3 col-md-6 col-sm-12 col-xs-12">
			            <input type="radio" name="q4" value="N" class="quiz-answer" id="q4a2"/>
			            <label for="q4a2">No</label>
			        </li>
			    </ul>
			</div>			
			<div class="quiz-step container step5 question">
			    <h2 class="question-title">Are you sure about the field which you want to pursue?</h2>
			    <ul class="no-bullet answers row">
			        <li class="col-md-offset-3 col-md-6 col-sm-12 col-xs-12">
			            <input type="radio" name="q5" value="Y" class="quiz-answer" id="q5a1"/>
			            <label for="q5a1">Yes</label>
			        </li>
			        <li class="col-md-offset-3 col-md-6 col-sm-12 col-xs-12">
			            <input type="radio" name="q5" value="N" class="quiz-answer" id="q5a2"/>
			            <label for="q5a2">No</label>
			        </li>
			    </ul>
			</div>		
			<div class="quiz-step container step6 question">
			    <h2 class="question-title">Are you comfortable with chaos and a fast-paced environment?</h2>
			    <ul class="no-bullet answers row">
			        <li class="col-md-offset-3 col-md-6 col-sm-12 col-xs-12">
			            <input type="radio" name="q6" value="Y" class="quiz-answer" id="q6a1"/>
			            <label for="q6a1">Yes</label>
			        </li>
			        <li class="col-md-offset-3 col-md-6 col-sm-12 col-xs-12">
			            <input type="radio" name="q6" value="N" class="quiz-answer" id="q6a2"/>
			            <label for="q6a2">No</label>
			        </li>
			    </ul>
			</div>			
			<div class="quiz-step container step7 question">
			    <h2 class="question-title">Do you need financial security in the short term?</h2>
			    <ul class="no-bullet answers row">
			        <li class="col-md-offset-3 col-md-6 col-sm-12 col-xs-12">
			            <input type="radio" name="q7" value="Y" class="quiz-answer" id="q7a1"/>
			            <label for="q7a1">Yes</label>
			        </li>
			        <li class="col-md-offset-3 col-md-6 col-sm-12 col-xs-12">
			            <input type="radio" name="q7" value="N" class="quiz-answer" id="q7a2"/>
			            <label for="q7a2">No</label>
			        </li>
			    </ul>
			</div>			
			<div class="quiz-step container step8 question">
			    <h2 class="question-title">Can you make independent decisions?</h2>
			    <ul class="no-bullet answers row">
			        <li class="col-md-offset-3 col-md-6 col-sm-12 col-xs-12">
			            <input type="radio" name="q8" value="Y" class="quiz-answer" id="q8a1"/>
			            <label for="q8a1">Yes</label>
			        </li>
			        <li class="col-md-offset-3 col-md-6 col-sm-12 col-xs-12">
			            <input type="radio" name="q8" value="N" class="quiz-answer" id="q8a2"/>
			            <label for="q8a2">No</label>
			        </li>
			    </ul>
			</div>			
			<div class="quiz-step container step9 question">
			    <h2 class="question-title">Are you clear about the industry where you want to be?</h2>
			    <ul class="no-bullet answers row">
			        <li class="col-md-offset-3 col-md-6 col-sm-12 col-xs-12">
			            <input type="radio" name="q9" value="Y" class="quiz-answer" id="q9a1"/>
			            <label for="q9a1">Yes</label>
			        </li>
			        <li class="col-md-offset-3 col-md-6 col-sm-12 col-xs-12">
			            <input type="radio" name="q9" value="N" class="quiz-answer" id="q9a2"/>
			            <label for="q9a2">No</label>
			        </li>
			    </ul>
			</div>			
			<div class="quiz-step container step10 question">
			    <h2 class="question-title">Are you an out-of-the-box thinker?</h2>
			    <ul class="no-bullet answers row">
			        <li class="col-md-offset-3 col-md-6 col-sm-12 col-xs-12">
			            <input type="radio" name="q10" value="Y" class="quiz-answer" id="q10a1"/>
			            <label for="q10a1">Yes</label>
			        </li>
			        <li class="col-md-offset-3 col-md-6 col-sm-12 col-xs-12">
			            <input type="radio" name="q10" value="N" class="quiz-answer" id="q10a2"/>
			            <label for="q10a2">No</label>
			        </li>
			    </ul>
			</div>		
			<div class="quiz-step container result end" id="results">
			    <div class="row">
			    	<div class="col-md-12">
			    		<div id="results-text">
				    		<h2 class="score-title"></h2>
				    		<p class="sub-scores"></p>
				    		<button type="button" id="shareBtn" class="btn-facebook">Share on Facebook</button>
			    		    <?php if(!isset($_SESSION['useremail'])){ ?>
				    		<div>
				    			Like this quiz? <a href="index.php" class="alert-link">Register on Talerang Express now!</a>
				    		</div>
				    		<?php } ?>
						</div>
			    	</div>
			    </div>
			</div>
			</form>

			<div id="qno"><div>Question <span id="stepno">1</span> of 10</div></div>
		</div>     <!--close row    -->
	</div>  <!-- close container -->

	</div> <!--close content -->
	<div class="hidden-print">
	<?php include 'footer.php' ?>
	</div>
</div> <!--close wrapper    -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="js/jhe.js" type="text/javascript"></script>
</body>
</html>