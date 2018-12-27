<?php session_start();
require 'connectsql.php';

if(isset($_POST['page'])) 
	$curpg=$_POST['page'];
elseif(isset($_GET['pgno']))
	$curpg=$_GET['pgno'];
else $curpg=1;

if(isset($_POST['update']))
{
	$fullname=mysqli_real_escape_string($DBcon, $_POST['fullname']);
	$mockfeedback=mysqli_real_escape_string($DBcon, nl2br($_POST['mockfeedback']));
	$email=mysqli_real_escape_string($DBcon, $_POST['email']);
	$inttype=mysqli_real_escape_string($DBcon, $_POST['inttype']);
	$intdate=$_POST['intdate'];
	$inttime=$_POST['inttime'];
	$datetime=mysqli_real_escape_string($DBcon, $inttime." ".$intdate);

    $sql="INSERT INTO `mockfeedback` (`fullname`,`email`,`intdate`,`inttype`,`mockfeedback`,`emailed`)
    		VALUES ('$fullname','$email','$datetime','$inttype','$mockfeedback','0')";
    mysqli_query($DBcon,$sql);
    //header("location:adminmockc.php?pgno=".$curpg);
}
if(isset($_POST['reset']))
{	
	$email=$_POST['email'];
	$sql="DELETE FROM `mockfeedback` WHERE `email`='$email';";
	mysqli_query($DBcon,$sql);
    header("location:adminmockc.php?pgno=".$curpg);
}
if(isset($_POST['confirm']))
{
	$email=$_POST['email'];
	$sql="SELECT `fullname`,`mockfeedback`,`intdate`,`inttype` FROM `mockfeedback` WHERE `email`='$email'";
	$result=mysqli_query($DBcon,$sql);
	$row=mysqli_fetch_assoc($result);
	$fullname=$row['fullname'];
	$mockfeedback=$row['mockfeedback'];
	$intdate=$row['intdate'];
	$inttype=$row['inttype'];
	$inttime=substr($intdate,0,7);
	$intdate=substr($intdate,8);
	//send the email here
		if(!in_array($_SERVER['REMOTE_ADDR'],array('127.0.0.1','::1')))
		{
		include("vendor/phpmailer/phpmailer/PHPMailerAutoload.php");
		try {
		    $mail = new PHPMailer(true);
		    $mail->IsSMTP(); // Using SMTP.
		    $mail->CharSet = 'utf-8';
		    $mail->Host = "smtp.gmail.com"; // SMTP server host.
		    $mail->SMTPSecure   = "ssl";
		    $mail->Port         =465;
		   // $mail->SMTPDebug = 2; // Enables SMTP debug information - SHOULD NOT be active on production servers!
		    $mail->SMTPAuth = true; // Enables SMTP authentication.

		    $mail->Username='support@talerang.com'; // SMTP account username example
		    $mail->Password='TalerangSupport2015';        // SMTP account password example
		    
		    $mail->SetFrom('support@talerang.com', 'Talerang Support Team');
		    $mail->AddReplyTo('support@talerang.com', 'Talerang Support Team');
		    $mail->AddAddress($email,$fullname); 
		    //$mail->AddAddress('azeem.talerang@gmail.com', 'Azeem');
		    
		    $mail->Subject = 'Talerang Express Mock Interview Feedback';
		    $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
		    $body="<html><body>Dear {$fullname},<br><br>Thank you for completing your {$inttype} interview with Talerang on {$intdate} at {$inttime}. <br><br>Based on your interview, here is the feedback that the interviewer has provided:<br><br><b>{$mockfeedback}</b><br><br>Thank you and feel free to contact us if you have any questions.<br><br>Regards,<br>Team Talerang.</body></html>";
		    $mail->MsgHTML($body);
		    
		    
		    if(!$mail->Send())
		    echo 'Message could not be sent';
		    else {
		    	$sql="UPDATE `mockfeedback` SET `emailed`='1' WHERE `email`='$email';";
		    	mysqli_query($DBcon,$sql);
		    }//echo 'Message sent!';
		    
		} catch (phpmailerException $e) {
		    echo $e->errorMessage(); 
		} catch (Exception $e) {
		    echo $e->getMessage(); 
		} 
		}//end mailer


	$sql="UPDATE `results` SET `graded`='2' WHERE `email`='$email'";
	mysqli_query($DBcon,$sql);
    $DBcon->close();
    $search=$_POST['search'];
	header("location:adminmockc.php?pgno=".$curpg."&search=".$search);
}// end if isset confirm
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1" />
    <meta name="robots" content="noindex, nofollow">
	<title>Talerang Express | Admin Panel</title>
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css?version=2.1">
	<link rel="stylesheet" type="text/css" href="css/adminstyle.css">
	<?php include 'jqueryload.php' ?>
	<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
	<?php include 'noscript.php' ?>
</head>

<body>
<div id="wrapper">
<div id="header">
	<img src="img/logoexpress.jpg" alt="Talerang">
	<?php if(isset($_SESSION['adminuser'])) { ?>
		<a href='adminlogout.php' id="logout">Logout</a>
		<a href='adminlanding.php' id="back">Back</a>
	<?php } ?>
</div> <!-- end header -->

<div id="content">

<?php if(isset($_SESSION['adminuser'])){ 
		
		$query="SELECT `firstname`,`lastname`,`email`,`paymenttime` FROM `feespaid` WHERE `status`='SUCCESS' AND `type`='Mock Interview'";
		$result=mysqli_query($DBcon,$query);
		$row_cnt=mysqli_num_rows($result);
		$nopgs=10; // no of entries you want per page
		$pgs=ceil($row_cnt/$nopgs); ?>

		<?php echo "<div id=\"num\">Total number of entries: ".$row_cnt."</div>"; ?>
		<?php if(!$row_cnt==0 && $pgs>1){ ?>
		<form method="post" action="adminmockc.php" id="pages">
			<label for="page">Page No:</label>
			<select name="page" id="page">
				<?php 
					for($i=1; $i <=$pgs ; $i++) 
					{
						if($i!=$curpg)
							echo '<option value="'.$i.'">'.$i.'</option>';
						else
							echo '<option value="'.$i.'" selected>'.$i.'</option>';
					}
				?>
			</select>
			<input type="submit" name="submit" id="submit" style="display: none">
			<?php if($curpg!=1){ ?><a href="adminmockc.php?pgno=<?php echo ($curpg-1) ?>" class="prevnext" target="_self">&lt;&lt;Previous</a><?php } ?>
			<?php if($curpg!=$pgs){ ?><a href="adminmockc.php?pgno=<?php echo ($curpg+1) ?>" class="prevnext" target="_self">Next&gt;&gt;</a><?php } ?>
		</form>
		<?php } //end if row_cnt!=0 ?>
<?php	require 'connectsql.php';
		$pgstart=($curpg-1)*$nopgs; 
if($row_cnt==0) ;
if(!$row_cnt==0){ ?>
<div class="rTable">
	<div class="rTableRow">
		<div class="center rTableHead" style="border-left:0">No</div>
		<div class="center rTableHead">Full Name</div>
		<div class="center rTableHead">Email</div>
		<div class="center rTableHead">Phone Number</div>
		<div class="center rTableHead">Type</div>
		<div class="center rTableHead">Interview Date</div>
		<div class="center rTableHead">Interview Time</div>
		<div class="center rTableHead">Facilitator Feedback</div>
		<div class="center rTableHead">Confirm interview</div>
	</div>
<?php 
$vals=array();
for ($i=0; $i<$nopgs ; $i++) array_push($vals,$pgstart++);
$i=0;
while($row=mysqli_fetch_row($result)) 
{	
	if(!in_array($i,$vals))
	{
		$i++; 
		continue;
	}
	//if($row[5]==true) continue;
	$field1=$row[0]." ".$row[1];//fullname
	$field2=$row[2]; //email
	$field3=$row[3]; //pay time
	$sql="SELECT `phoneno` FROM `register` WHERE `email`='$field2'";
	$row=mysqli_fetch_assoc(mysqli_query($DBcon,$sql));
	$field4=$row['phoneno'];
	$sql="SELECT `type` FROM `mockinterviews` WHERE `email`='$field2'";
	$row=mysqli_fetch_assoc(mysqli_query($DBcon,$sql));
	$field5=$row['type'];
	$sql="SELECT * FROM `mockfeedback` WHERE `email`='$field2' LIMIT 1";
	$existingresult=mysqli_query($DBcon,$sql);
	if(mysqli_num_rows($existingresult)==0) $existing=0;
	else {
		$existing=1;
		$existingrow=mysqli_fetch_assoc($existingresult);
		$emailed=$existingrow['emailed'];
	}
?>

<form method="post" class="feedbackform rTableRow <?php if($i%2==0) echo 'evenRow' ?>" action="">
	<input style="display:none" name="page" type="text" value="<?php echo $curpg ?>" />
	<input style="display:none" name="email" type="text" value="<?php echo $field2; ?>"/>
	<input style="display:none" name="fullname" type="text" value="<?php echo $field1; ?>"/>
	<input style="display:none" name="inttype" type="text" value="<?php echo $field5; ?>"/>
	<div class="center rTableCell" style="border-left:0"><?php echo ($i+1); ?></div>
	<div class="center rTableCell"><?php echo $field1; ?></div>
	<div class="center rTableCell"><?php echo $field2; ?></div>
	<div class="center rTableCell"><?php echo $field4; ?></div>
	<div class="center rTableCell"><?php echo $field5; ?></div>
	<div class="center rTableCell">
	<?php if(!$existing){ ?>
		<input type="text" name="intdate" id="" class="center datepicker" readonly="readonly"/>
	<?php } else {
				echo substr($existingrow['intdate'],8);
		  }
     ?>
	</div>
	<div class="center rTableCell"> 
	<?php if(!$existing){ ?>
		<select name="inttime">
			<option selected disabled>Timing</option>
			<?php $timings=array("07:30am","08:00am","08:30am","09:00am","09:30am","10:00am","10:30am","11:00am","11:30am","12:00pm","12:30pm","01:00pm","01:30pm","02:00pm","02:30pm","03:00pm","03:30pm","04:00pm","04:30pm","05:00pm","05:30pm","06:00pm","06:30pm","07:00pm","07:30pm","08:00pm","08:30pm","09:00pm");
			for ($j=0; $j <count($timings) ; $j++) 
				echo "<option value=\"".$timings[$j]."\">".$timings[$j]."</option>";
			?>
		</select>
	<?php } else { 
		echo substr($existingrow['intdate'], 0, 7);
	 } ?>
	</div>	
	<div class="center rTableCell">
	<?php if(!$existing){ ?>
		<textarea name="mockfeedback" style="height:50px; resize: vertical;"></textarea>
	<?php } else {
				echo $existingrow['mockfeedback'];
			}
		
		?>
	</div>				
	<div class="center rTableCell">
		<?php if(!$existing) { ?>
		<input type="submit" name="update" value="Update" method="post" id="update"/>
		<?php } else { 
				if(!$emailed){
			?>
		<input type="submit" name="reset" value="Reset" method="post" id="reset"/>
		<input type="submit" name="confirm" value="Confirm" method="post" id="confirm"/>

		<?php }
			  else echo "Feedback sent to student";
		} ?>
	</div>
</form> 

<?php $i++;} //end while loop ?>
</div> <!-- close table -->
<?php } // end if row_cnt==0 ?>
<?php } else { //end if session isset??>
	<div class="container" id="notsignedin">
		<div class="alert alert-warning">
			You are not signed in! Please <a href="adminlogin.php" class="alert-link">log in</a> first.
		</div>
	</div>

<?php } ?> <!-- end else session isset? -->
</div> <!-- close content -->

<?php include 'footer.php' ?>
</div><!--  close wrapper -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.1/jquery.validate.min.js"></script>
<script type="text/javascript" src="js/adminmockc.js"></script>
</body>
</html>