<!DOCTYPE HTML>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1">
    <meta name="robots" content="index, follow">
	<title>Talerang Express | Reset Password</title>
	<?php include 'jqueryload.php' ?>
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css?version=2.1">
	<link rel="stylesheet" type="text/css" href="css/passwordstyle.css">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.1/jquery.validate.min.js"></script>
    <?php include 'noscript.php' ?>
</head>

<body>
<div id="wrapper">
	<div id="header" class="container-fluid">
		<img src="img/logoexpress.jpg" alt="Talerang">
	</div>
	<div id="content" class="container">
	<?php
	date_default_timezone_set("Asia/Kolkata");

	if(isset($_GET['hash']))
	$hash=$_GET['hash'];
	else $hash='';
	if(isset($_GET['user']))
	$user=$_GET['user'];
	else $user='';

	require 'connectsql.php';
	$sql="SELECT `settime` FROM `adminpass` WHERE `hash`='$hash' AND `email`='$user'";
	$result=mysqli_query($DBcon,$sql);
	$found=mysqli_num_rows($result);
	$result=mysqli_fetch_row($result);
	$settime=$result[0];
	$current=date('Y-m-d H:i');

	$date_a = new DateTime($settime);
	$date_b = new DateTime($current);

	$interval = date_diff($date_a,$date_b);

	$years=$interval->format('%Y');
	$months=$interval->format('%m'); 
	$days=$interval->format('%d');   
	$hours=$interval->format('%H');   
	$minutes=$interval->format('%i'); 

	if($years==0&&$months==0&&$days==0&&$hours==0&&$minutes<=15&&$found)
		 $timediff=true;
	else $timediff=false;
		if($timediff)
		{
			if(isset($_POST['submit-resetpass']))
			{	
				$password=$_POST['password'];
				$password=crypt($password);
				$sql="UPDATE `adminpass` SET `password`='$password' WHERE `email`='$user';";
				if(mysqli_query($DBcon,$sql))
				echo "<div class=\"notif success\">Your password has been changed!</div><div><a href=\"adminlogout.php\">Sign in</a> with your new password</div>";
			}
			?>
			<h3>Reset the password for username <b><?php echo $user ?></b>:</h3>
			<form name="resetpass" method="post" id="resetpass">
				<div>
					<input type="password" name="password" placeholder="New Password" id="password"/>
					<label for="password" class="errorphp"><?php echo $error['password'] ?></label>
					<label for="password" class="error"></label>
				</div>
				<div>
					<input type="password" name="passwordc" placeholder="Confirm Password" id="passwordc"/>
					<label for="passwordc" class="errorphp"><?php echo $error['passwordc'] ?></label>
					<label for="passwordc" class="error"></label>
				</div>
				<input type="submit" name="submit-resetpass" value="Reset">
			</form>
			<script type="text/javascript">
				$('#resetpass').validate({
					errorClass: 'error',
					rules:    {
						'password':  { required: true, minlength: 6},
						'passwordc': { required: true, equalTo: "#password",},
					},
					messages: {
						'password':  { required:"Please enter new password", minlength: "Password must be at least {0} characters long"},
						'passwordc': { required:"Please enter the password again", equalTo: "Passwords don't match!"},
					},
				});
			</script>
			<?php } //endif timediff=true?
			else { ?>
			<div class="alert alert-danger">This link has expired, please generate a new link from the admin account</div>
			<?php } ?>
	</div>
	<?php include 'footer.php' ?>
</div>
	
</body>
</html>