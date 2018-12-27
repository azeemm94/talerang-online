<?php session_start();
date_default_timezone_set('Asia/Kolkata'); ?>

<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1" />
    <meta name="robots" content="noindex, nofollow">
	<title>Talerang Express | Video Chat room</title>
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css?version=2.1">
	<link rel="stylesheet" type="text/css" href="css/adminstyle.css">
	<?php include 'jqueryload.php' ?>
	<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<?php include 'noscript.php' ?>
</head>

<body>
<?php include 'google-analytics.php'; ?>
<div id="wrapper">
<div id="header">
	<img src="img/logoexpress.jpg" alt="Talerang">
</div> <!-- end header -->

<div id="content" class="container-fluid">
	<?php
	require 'connectsql.php';

	if(isset($_GET['room']))
	$hash=$_GET['room'];
	else $hash="";
	$sql="SELECT * FROM `activemockroom` WHERE `hash`='$hash' AND `active`='1' LIMIT 1;";
	$result=mysqli_query($DBcon,$sql);
	$room_found=mysqli_num_rows($result);
	$row=mysqli_fetch_assoc($result);

	if($room_found)
	{
		$roomname=$row['roomname'];
		echo '<iframe src="https://appear.in/'.$roomname.'" style="width:100%; height:100%" frameborder="0"></iframe>';
	}
	else
	{
		echo '<div class="container alert alert-warning">Your room is not active right now. Please wait for further instructions from your counsellor. Thank you!</div>';
	}
	
	?>

	

</div> <!-- close content -->

<?php include 'footer.php' ?>
</div><!--  close wrapper -->

</body>
</html>