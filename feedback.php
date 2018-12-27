<!DOCTYPE HTML>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1">
    <meta name="robots" content="index, follow">
	<title>Talerang Express | Feedback</title>
	<?php include 'jqueryload.php' ?>
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css?version=2.1"> 
	<link rel="stylesheet" type="text/css" href="css/passwordstyle.css"> 
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<?php include 'noscript.php' ?>
</head>

<body>
<?php include 'google-analytics.php'; ?>
<div id="wrapper">
	<div id="header" class="container-fluid">
		<img src="img/logoexpress.jpg" alt="Talerang">
	</div>
	<?php 
		if(isset($_GET['id'])) $id=$_GET['id']; else $id="";
		if(isset($_GET['rate'])) $rate=$_GET['rate']; else $rate="";
		$ratearr=array('1'=>"very unsatisfied", '2'=>"unsatisfied", '3'=>"neutral", '4'=>"satisfied", '5'=>"very satisfied");
		
		if($id=="" && $rate=="") $flag=true; else $flag=false;
	?>

	<div id="content" class="container">
		<h1>Feedback for Talerang Express</h1>
		<?php if(!$flag): ?>
		<div id="rate">
			Your response has been recorded
		</div>
		<?php endif; ?>
		<?php
			require 'connectsql.php';

			$sql="SELECT * FROM `feedback` WHERE `hash`='$id';";
			$result=mysqli_query($DBcon,$sql);
			$num=mysqli_num_rows($result);

			if($num==0 && !$flag)
			{	
				date_default_timezone_set('Asia/Kolkata');
		        $date=date("Y-m-d h:i:sa"); 

		        $rating=$rate." - ".$ratearr[$rate];
				$sql="INSERT INTO `feedback`(`hash`,`rating`,`time`)
						VALUES ('$id','$rating','$date');";
				mysqli_query($DBcon,$sql);
			}
			if(isset($_POST['feedback-submit']))
			{
				$text=$_POST['comment'];
				$text=mysqli_real_escape_string($DBcon,nl2br($text));
				$sql="UPDATE `feedback` SET `comment`='$text' WHERE `hash`='$id';";
				mysqli_query($DBcon,$sql);
				echo "<div class=\"notif success\">Your comment has been saved, you may leave this page now</div>";
			}
		?>
		<form name="feedback" method="post" id="feedback">
			<label for="comment">Any comments that would help us understand your feedback?</label><br>
			<textarea name="comment" id="comment"></textarea><br>
			<input type="submit" name="feedback-submit" value="Submit comment"/>
		</form>
	</div>
	<?php include 'footer.php' ?>
</div>
	
</body>
</html>