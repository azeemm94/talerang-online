<!DOCTYPE HTML>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1">
    <meta name="robots" content="index, follow">
	<title>Talerang Express | Forgot Password</title>
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
		<a href="index.php"><img src="img/logoexpress.jpg" alt="Talerang"></a>
	</div>
	<div id="content" class="container">
		<h2>Forgot your Password?</h2>
		<form name="forgotpass" method="post" id="forgotpass">
			<label for="email">Enter your email address:</label>
			<input type="text" class="form-control" name="email" placeholder="Email address" style="max-width: 300px; font-size: 22px;" />
			<input type="submit" name="submit" value="Go"/>
		</form>
		<?php 
		if(isset($_POST['email']))
		{	
			require 'connectsql.php';
			$email=mysqli_real_escape_string($DBcon,$_POST['email']);

			if ($email==""){
				echo '<div class="alert alert-danger">Enter your email address</div>';
				$row_cnt=-1;
			}
			elseif(filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
				echo '<div class="alert alert-danger">This is not a valid email address</div>';
				$row_cnt=-1;
			}
			else{
				$sql="SELECT * FROM `register` WHERE `email`='$email' AND `active`='1';";
				$result=mysqli_query($DBcon,$sql);
				$row_cnt=mysqli_num_rows($result);
			}
			if($row_cnt==1){
				$row=mysqli_fetch_assoc($result);
				$fullname=$row['firstname']." ".$row['lastname'];
				$hash=sha1(chr(rand(65,90)).chr(rand(65,90)).chr(rand(65,90)).chr(rand(65,90)).chr(rand(65,90)).chr(rand(65,90)));
				$link="http://www.talerang.com/express/resetpass.php?email=".$email."&hash=".$hash;
                date_default_timezone_set('Asia/Kolkata');
                $date=date("Y-m-d h:i:sa"); 
                $sql="INSERT INTO `forgotpass` (email,hash,requesttime)
                		VALUES ('$email','$hash','$date');";
                mysqli_query($DBcon,$sql);
                if(!in_array($_SERVER['REMOTE_ADDR'],array('127.0.0.1','::1')))

                //Sending a reset email
                include("vendor/phpmailer/phpmailer/PHPMailerAutoload.php");
				try {
				    $mail = new PHPMailer(true);
				    $mail->IsSMTP(); // Using SMTP.
				    $mail->CharSet = 'utf-8';
				    $mail->Host = "smtp.gmail.com"; // SMTP server host.
				    $mail->SMTPSecure   = "ssl";
				    $mail->Port         =465;
				    $mail->SMTPAuth = true; // Enables SMTP authentication.

				    $mail->Username='support@talerang.com'; // SMTP account username
				    $mail->Password='TalerangSupport2015';        // SMTP account password
				    
				    $mail->SetFrom('support@talerang.com', 'Talerang Support Team');
				    $mail->AddReplyTo('support@talerang.com', 'Talerang Support Team');

				    $mail->AddAddress($email,$fullname); //sending to this email
				    
				    $mail->Subject = 'Reset your password for Talerang Express';
				    $mail->AddEmbeddedImage('img/logoemail.gif', 'logo');
				    //$mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
				    $emailbody='<!DOCTYPE html><html><head></head><body><img src="cid:logo" width="150px"/><br>Dear '.$fullname.',<br><br>Please <a href="'.$link.'" target="new">click here</a> to reset your password.<br><br>Regards,<br>Team Talerang</body></html>';

				    $mail->MsgHTML($emailbody);
				      
				    if(!$mail->Send())
				    echo 'Message could not be sent';
				    echo '<div class="alert alert-success">An email with a link to reset your password has been sent to you!</div>';
				    // clear all addresses and attachments for the next mail
				    $mail->ClearAddresses();
				    $mail->ClearAttachments();
				    
				} catch (phpmailerException $e) {
				    echo $e->errorMessage(); 
				} catch (Exception $e) {
				    echo $e->getMessage(); 
				}
			}
			elseif($row_cnt==0){
				echo '<div class="alert alert-danger">This email is not registered on Talerang Express or it has not been verified yet!</div>';
			}
		}
		?>
	</div>
	<?php include 'footer.php' ?>
</div>
	
</body>
</html>