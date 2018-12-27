<?php session_start();
date_default_timezone_set('Asia/Kolkata');
if(isset($_SESSION['useremail'])):
require 'connectsql.php';
$sql="SELECT * FROM `webinar`;";
$result=mysqli_query($DBcon,$sql);
$webinar=array();
function swapper(&$a,&$b) { $t=$a; $a=$b; $b=$t; }
$i=0;
$todayunix=strtotime(date('d M Y'));

while ($row=mysqli_fetch_assoc($result)) 
{
	$webinarunix=strtotime($row['datescheduled']);
	if($webinarunix<$todayunix) { continue; }
	array_push(
		$webinar,
		array(
			'id'=>$row['webinarid'],
			'title'=>$row['title'],
			'description'=>$row['description'],
			'time'=>$row['time'],
			'datescheduled'=>$row['datescheduled'],
			'link'=>$row['link'],
			'timeunix'=>strtotime($row['datescheduled'].' '.$row['time']),
			'confirmedacc'=>$row['confirmedacc']
		)
	);
	$i++;
}
//sorts webinars by time and date
for ($i=0; $i < count($webinar); $i++) 
	for ($j=1; $j < count($webinar)-$i; $j++) 
		if($webinar[$j]['timeunix']<$webinar[$j-1]['timeunix'])
			swapper($webinar[$j],$webinar[$j-1]);

if(isset($_POST['submit-webinar-confirm']))
{
	$webinarid=$_POST['webinar-id'];
	$accountno=$_SESSION['accountno'];
	$sql="SELECT `confirmedacc` FROM `webinar` WHERE `webinarid`='$webinarid' LIMIT 1;";
	$confirmed=mysqli_fetch_assoc(mysqli_query($DBcon,$sql));
	$confirmed=$confirmed['confirmedacc'];
	if($confirmed=="")
		$confirmed=array();
	else
	$confirmed=explode(',',$confirmed);
	if(!in_array($accountno,$confirmed));
	array_push($confirmed,$accountno);
	$confirmed=implode(',',$confirmed);
	$sql="UPDATE `webinar` SET `confirmedacc`='$confirmed' WHERE `webinarid`='$webinarid';";
	mysqli_query($DBcon,$sql);
	header('location:webinar.php');
}
if(isset($_POST['submit-webinar-cancel']))
{
	$webinarid=$_POST['webinar-id'];
	$accountno=$_SESSION['accountno'];
	$sql="SELECT `confirmedacc` FROM `webinar` WHERE `webinarid`='$webinarid' LIMIT 1;";
	$confirmed=mysqli_fetch_assoc(mysqli_query($DBcon,$sql));
	$confirmed=explode(',',$confirmed['confirmedacc']);
	for ($i=0; $i < count($confirmed); $i++) 
		if($confirmed[$i]==$accountno)
			unset($confirmed[$i]);
	$confirmed=implode(',',$confirmed);
	$sql="UPDATE `webinar` SET `confirmedacc`='$confirmed' WHERE `webinarid`='$webinarid';";
	mysqli_query($DBcon,$sql);
	header('location:webinar.php');
}
endif; // isset session useremail
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1" />
	<meta name="robots" content="index, follow">  
	<title>Talerang Express | Webinar</title>
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css?version=2.1">
	<link rel="stylesheet" type="text/css" href="css/landingstyle.css">
	<link rel="stylesheet" type="text/css" href="css/webinarstyle.css">
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
		    <li class="nav-link welcome"><a><span class="text">Signed in as <?php echo $_SESSION['firstname'] ?></span></a></li>
		    <li class="nav-link"><a href="landing.php"><span class="text">Back</span></a></li>
		    <li class="nav-link"><a href="logout.php"><span class="text">Logout</span></a></li>
	      
	      </ul>
	    </div><!-- /.navbar-collapse -->
	   <?php endif; ?>
	  </div><!-- /.container-fluid -->
	</nav>

	<div id="content">

	<div class="ribbon container-fluid">
        <div class="container" id="middle">
            Training
        </div>
    </div>
	
	<?php if(isset($_SESSION['useremail'])): ?>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
			<?php if(count($webinar)==0): ?>
				<div class="alert alert-warning" style="margin-top: 20px;">
					There are currently no webinars scheduled, please check again later
				</div>
			<?php else: ?>
				<div class="alert alert-warning" style="margin-top: 20px;">
					Click on the confirm button for the scheduled webinars that you want to attend
				</div>
				<div class="rTable">
					<div class="rTableRow">
						<div class="rTableHead center">S. No.</div>
						<div class="rTableHead center">Title</div>
						<div class="rTableHead center">Description</div>
						<div class="rTableHead center">Date</div>
						<div class="rTableHead center">Time</div>
						<div class="rTableHead center">Link</div>
						<div class="rTableHead center">Confirm</div>
					</div>
				<?php $i=0; while($i<count($webinar)) {
					$confirmed=$webinar[$i]['confirmedacc'];
					if(in_array($_SESSION['accountno'],explode(',',$confirmed)))
						$webinarconfirmed=true;
					else
						$webinarconfirmed=false;
				?>
					<form class="rTableRow<?php if($i%2==0) echo ' evenRow'; ?>" method="post" name="webinar-confirm" action="webinar.php" id="#webinar-confirm">
						<input type="hidden" name="webinar-id" value="<?php echo $webinar[$i]['id']; ?>">
						<div class="rTableCell center"><?php echo $i+1; ?></div>
						<div class="rTableCell center"><?php echo $webinar[$i]['title'] ?></div>
						<div class="rTableCell center"><?php echo $webinar[$i]['description'] ?></div>
						<div class="rTableCell center"><?php echo $webinar[$i]['datescheduled'] ?></div>
						<div class="rTableCell center"><?php echo $webinar[$i]['time'] ?></div>
						<div class="rTableCell center"><a href="<?php echo $webinar[$i]['link'] ?>" target="_blank"><?php echo $webinar[$i]['link'] ?></a></div>
						<div class="rTableCell center">
						<?php if(!$webinarconfirmed): ?>
							<input type="submit" name="submit-webinar-confirm" value="Confirm">
						<?php else: ?>
							Confirmed<br>
							<input type="submit" name="submit-webinar-cancel" value="Cancel">
						<?php endif; ?>
						</div>
					</form>
				<?php $i++; } // end while loop ?>
				</div>
			<?php endif; ?>
			</div>
		</div>
	</div> <!-- close container -->
	<?php else: ?>
		<div class="container" id="notsignedin">
			<div class="alert alert-warning">
				You are not signed in! Please <a href="index.php?signin&pg=webinar" class="alert-link">Sign in</a> first
			</div>
		</div>
	<?php endif; ?>
	</div> <!-- close content -->

	<?php include 'footer.php' ?>

</div><!--  close wrapper -->

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>