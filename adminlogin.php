<?php session_start();
if(isset($_SESSION['adminuser'])) header('location:adminlanding.php');
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1" />
	<meta name="robots" content="index, follow">  
	<title>Talerang Express | Admin Login</title>
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css?version=2.1">
	<link rel="stylesheet" type="text/css" href="css/adminstyle.css">
	<?php include 'noscript.php' ?>
	<?php include 'jqueryload.php' ?>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<style type="text/css">
		label.error { display: none; }
		input       { width: 300px; margin: 10px 0; }
		.phperror   { color: red; }
	</style>
</head>

<body>
<div id="wrapper">
	<div id="header" class="container">
		<img src="img/logoexpress.jpg" alt="Talerang">
	</div> <!-- end header -->

	<div id="content">
	<div class="container">
	<?php 
	$adminuser="";
	if(isset($_POST['adminsubmit']))
	{	
		$adminuser=$_POST['adminuser'];
		$adminpass=$_POST['adminpass'];
		require 'connectsql.php';
		$row=mysqli_fetch_row(mysqli_query($DBcon,"SELECT `password`,`privilege` FROM `adminpass` WHERE `email`='$adminuser'"));
		$dbpass=$row[0];
		$privilege=$row[1];

		if(($dbpass==crypt($adminpass,$dbpass)))
		{
			session_regenerate_id();
			$_SESSION['adminuser']=$adminuser;
			$_SESSION['privilege']=$privilege;
			header('location:adminlanding.php');
		}
		else echo '<p class="phperror">Invalid username or password</p>';
	}
	?>
	
	<h3 style="text-decoration: underline">Admin Login</h3>
	<p>Please login to continue.</p>
		<form id="adminlogin" method="post" name="adminlogin" action="adminlogin.php">
			<div>
				<input type="text" class="form-control admin-input" name="adminuser" placeholder="Username" value="<?php echo $adminuser ?>">
				<label for="admin" class="error"></label>
			</div>
			<div>
				<input type="password" class="form-control admin-input" name="adminpass" placeholder="Password">
				<label for="admin" class="error"></label>
			</div>
			<div>
				<input type="submit" name="adminsubmit" id="adminsubmit" value="Log in">
			</div>
		</form>
	</div> <!-- close container -->
	</div> <!-- close content -->



	<?php include 'footer.php' ?>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.1/jquery.validate.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){

			$('#adminlogin').validate({
				errorClass: 'error',
				rules: {
					'adminuser': { required: true,},
					'adminpass': { required: true,},
				},
					messages: {
					'adminuser': { required:"Please enter your username",},
					'adminpass': { required:"Please enter your password",},
				},
			});
			$('#adminsubmit').click(function() {
			    if($('#adminlogin').valid() ) return true;
			    	else return false;
			});

			}); /*end document ready*/
	</script>
</div><!--  close wrapper -->
</body>
</html>