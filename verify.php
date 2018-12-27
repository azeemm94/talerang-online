<?php header('Refresh:5;url=index.php'); ?>
<!DOCTYPE HTML>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1">
    <meta name="robots" content="index, follow">
	<title>Talerang Express | Email Verification</title>
	<?php include 'jqueryload.php' ?>
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css?version=2.1">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<?php include 'noscript.php' ?>
	<style type="text/css">
		#verified{
			margin: 20px;
			margin-left: 0;
			font-size: 36px;
		}
	</style>
</head>

<body>
<?php include 'google-analytics.php'; ?>
<div id="wrapper">
	<div id="header" class="container">
		<img src="img/logoexpress.jpg" alt="Talerang">
	</div>
	<div id="content" class="container">
	<?php
	if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash']))
	{
		$email=$_GET['email'];
		$hash=$_GET['hash'];
		require 'connectsql.php';
		$sql="SELECT * FROM `register` WHERE `email`='$email';";
		$row=mysqli_fetch_assoc(mysqli_query($DBcon,$sql));
		if($row['hash']==$hash)
		{
			$sql="UPDATE `register` SET `active`='1' WHERE `email`='$email';";
			mysqli_query($DBcon,$sql);
			$DBcon->close();
			$edusynch=true;
			require 'connectsql.php';
			$sql="UPDATE `register` SET `active`='1' WHERE `email`='$email';";
			mysqli_query($EDcon,$sql);
			$EDcon->close();
			require 'connectsql.php';
			echo '<div id="verified">Your account has been verified! You can <a href="index.php?signin" target="_self">sign in</a> now</div>';
		}
		else
			echo '<div id="verified">We are unable to verify your account, please try to <a href="index.php" target="_self">register again</a></div>';
	}
	else
		echo '<div id="verified">We are unable to verify your account, please try to <a href="index.php" target="_self">register again</a></div>';
	?>
	</div>
	<?php include 'footer.php' ?>
</div>
	
</body>
</html>