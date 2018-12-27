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
<?php include 'google-analytics.php'; ?>
<div id="wrapper">
	<div id="header" class="container-fluid">
		<a href="index.php"><img src="img/logoexpress.jpg" alt="Talerang"></a>
	</div>
	<div id="content" class="container">
	<?php
	if(isset($_GET['email'])&&isset($_GET['hash']))
	{
		$email=$_GET['email'];
		$hash=$_GET['hash'];
		require 'connectsql.php';
		$sql="SELECT * FROM `forgotpass` WHERE `email`='$email' AND `hash`='$hash';";
		$result=mysqli_query($DBcon,$sql);
		$row_cnt=mysqli_num_rows($result);

		if($row_cnt==1){ 
			$error=array('password'=>"",'passwordc'=>"");
			echo $error['passwordc'].$error['password'];
			if(isset($_POST['password']))
			{
				echo $error['passwordc'].$error['password'];
				$password=$_POST['password'];
				$passwordc=$_POST['passwordc'];
				/*echo $password;
				echo $passwordc;*/
				if($password=="") $error['password']="Please enter new password";
				elseif(strlen($password)<6) $error['password']="Password must be at least 6 characters long";
				if($passwordc=="") $error['passwordc']="Please enter the password again";
				elseif(!($passwordc==$password)) $error['passwordc']="Passwords don't match!";

				if($error['password']==""&&$error['passwordc']=="")
				{	
					$password=crypt($password);
					$sql="UPDATE `register` SET `password`='$password' WHERE `email`='$email';";
					mysqli_query($DBcon,$sql);
					echo '<div class="alert alert-success">Your password has been changed! <a class="alert-link" href="index.php?signin">Sign in</a> with your new password</div>';
				}
			}
			?>
			<h2>Reset your password:</h2>
			<form name="resetpass" method="post" id="resetpass">
				<div>
					<input type="password" class="form-control" style="max-width: 250px; font-size: 22px; display: inline-block;" name="password" placeholder="New Password" id="password"/>
					<label for="password" class="errorphp" style="display: inline"><?php echo $error['password'] ?></label>
					<label for="password" class="error"></label>
				</div>
				<div>
					<input type="password" class="form-control" style="max-width: 250px; font-size: 22px; display: inline-block;" name="passwordc" placeholder="Confirm Password" id="passwordc"/>
					<label for="passwordc" class="errorphp" style="display: inline"><?php echo $error['passwordc'] ?></label>
					<label for="passwordc" class="error"></label>
				</div>
				<input type="submit" name="submit" value="Reset">
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
		<?php
		}//end row_cnt==1?
		elseif($row_cnt==0) echo '<div class="alert alert-warning">Your password could not be reset! Please try again from <a href="forgotpass.php" class="alert-link">here</a></div>';
	}
	else{ ?> 
		<div class="alert alert-warning">Your password could not be reset! Please try again from <a href="forgotpass.php" class="alert-link">here</a></div>
	<?php } ?>
	</div>
	<?php include 'footer.php' ?>
</div>
	
</body>
</html>