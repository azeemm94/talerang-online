<?php session_start();
date_default_timezone_set('Asia/Kolkata');
require 'connectsql.php';

if(isset($_POST['page'])) 
	$curpg=$_POST['page'];
elseif(isset($_GET['pgno']))
	$curpg=$_GET['pgno'];
else $curpg=1;

if(isset($_POST['grade']))
{
	$fullname=$_POST['fullname'];
	$email=$_POST['email'];
	$accountno=mysqli_real_escape_string($DBcon,$_POST['accountno']);
	$gradeu=mysqli_real_escape_string($DBcon,$_POST['gradeu']);
	$gradeq=mysqli_real_escape_string($DBcon,$_POST['gradeq']);
	$feedback=$_POST['feedback'];
	$date=mysqli_real_escape_string($DBcon,date("Y-m-d h:i:sa")); 
	
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
	    $mail->Password='TalerangSupport2015';  // SMTP account password 
	    
	    $mail->SetFrom('support@talerang.com', 'Talerang Support Team');
	    $mail->AddReplyTo('support@talerang.com', 'Talerang Support Team');
	    $mail->AddAddress($email,$fullname); 
	    
	    $mail->Subject = 'Talerang Express - Project Grade';
	    $mail->AddEmbeddedImage('img/logoemail.gif', 'logo');
	    //$mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
	    $emailbody="<!DOCTYPE html><html><head></head><body>Dear ".$fullname.",<br><br>The grades for the project you uploaded on Talerang Express are as follows: <br><ul><li>Quality of the project: <b>".$gradeq."</b></li><li>Understanding of the project: <b>".$gradeu."</b></li><li>Feedback given by the counsellor: <br><b>".nl2br($feedback)."</b></li></ul>Regards,<br>Team Talerang<br><img src='cid:logo' width=\"150px\"/></body></html>";

	    $mail->MsgHTML($emailbody);
	      
	    if(!$mail->Send())
	        echo '<div class="notif fail">Oops! Something went wrong please try again.</div>';
	    else echo '<div class="notif success">Email sent!</div>'; 
	} 
	catch (phpmailerException $e) { echo $e->errorMessage(); } 
	catch (Exception $e) { echo $e->getMessage(); }

	$feedback=mysqli_real_escape_string($DBcon,nl2br($feedback));

	$sql="INSERT INTO `projectgrade` (`accountno`,`gradeu`,`gradeq`,`feedback`,`date`)
			VALUES ('$accountno','$gradeu','$gradeq','$feedback','$date');";
	mysqli_query($DBcon,$sql);

	header('location:adminproject.php');
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
		if(isset($_GET['search'])) $search=$_GET['search'];
		else
		isset($_POST['search'])? $search=$_POST['search']: $search="";
		
		$sql="SELECT `accountno` FROM `fileupload` GROUP BY `accountno`;";

		$result=mysqli_query($DBcon,$sql);
		$row_cnt=mysqli_num_rows($result);
		$nopgs=20; // no of entries you want per page
		$pgs=ceil($row_cnt/$nopgs); ?>

		<div id="search">
			<p>Grade projects submitted by students<br>You may search by email address</p> 
		    <form method="post" action="adminproject.php"  id="searchform"> 
				<input type="text" name="search" value="<?php echo $search ?>"> 
				<input type="submit" name="search-submit" value="Search">
				<a href="adminproject.php" target="_self" id="showall">Show all entries</a>
		    </form> 
	    </div>

		<?php echo '<div id="num">Total number of entries: '.$row_cnt.'</div>'; ?>
		<?php if(!$row_cnt==0 && $pgs>1){ ?>
		<form method="post" action="adminproject.php" id="pages">
			<?php if($curpg!=1){ ?><a href="adminproject.php?pgno=<?php echo ($curpg-1) ?>&search=<?php echo $search ?>" class="prevnext" target="_self">&lt;&lt; Previous</a><?php } ?>
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
			<?php if($curpg!=$pgs){ ?><a href="adminproject.php?pgno=<?php echo ($curpg+1) ?>&search=<?php echo $search ?>" class="prevnext" target="_self">Next &gt;&gt;</a><?php } ?>
		</form>
		<?php } //end if row_cnt!=0 ?>
<?php	require 'connectsql.php';
		$pgstart=($curpg-1)*$nopgs; 
if(!$row_cnt==0){ ?>
<div class="rTable">
<div class="rTableRow">
	<div class="rTableHead center" style="border-left: none">No</div>
	<div class="rTableHead center">Full Name</div>
	<div class="rTableHead center">Email</div>
	<div class="rTableHead center">Mobile No</div>
	<div class="rTableHead center">Files Uploaded</div>
	<div class="rTableHead center">Grade (Quality)</div>
	<div class="rTableHead center">Grade (Understanding)</div>
	<div class="rTableHead center">Feedback</div>
	<div class="rTableHead center">Grade</div>
</div>
<?php 
$vals=array();
for ($i=0; $i<$nopgs ; $i++) array_push($vals,$pgstart++);
$i=0;
while($row=mysqli_fetch_assoc($result)) 
{	
	if(!in_array($i,$vals))
	{ $i++; continue; }
	
	$accountno=$row['accountno']; 
	$sql="SELECT `firstname`,`lastname`,`email`,`phoneno` FROM `register` WHERE `accountno`='$accountno' LIMIT 1;";
	$personal=mysqli_fetch_assoc(mysqli_query($DBcon,$sql));
	$fullname=$personal['firstname'].' '.$personal['lastname'];
	$email=$personal['email'];
	$mobile=$personal['phoneno'];

	$sql="SELECT `filename`,`uploadtime` FROM `fileupload` WHERE `accountno`='$accountno';";
	$filelist=mysqli_query($DBcon,$sql);

	$sql="SELECT * FROM `projectgrade` WHERE `accountno`='$accountno' LIMIT 1;";
	$grades=mysqli_query($DBcon,$sql);
	$graded=mysqli_num_rows($grades);
	$grades=mysqli_fetch_assoc($grades);
?>

<form method="post" class="rTableRow <?php if($i%2==0)echo 'evenRow' ?>" action="<?php echo $_SERVER['PHP_SELF']; ?>">
	<input type="text" name="page" value="<?php echo $curpg ?>" style="display:none">
	<input type="text" name="search" value="<?php echo $search ?>" style="display:none">
	<input type="text" name="accountno" value="<?php echo $accountno ?>" style="display:none">
	<input type="text" name="fullname" value="<?php echo $fullname ?>" style="display:none">
	<input type="text" name="email" value="<?php echo $email ?>" style="display:none">
	<div class="rTableCell center" style="border-left: none"><?php echo ($i+1); ?></div>
	<div class="rTableCell center"><?php echo $fullname; ?></div>
	<div class="rTableCell center"><?php echo $email; ?></div>
	<div class="rTableCell center"><?php echo $mobile; ?></div>
	<div class="rTableCell center">
	<?php
		while($file=mysqli_fetch_assoc($filelist))
		{
			$time=date('h:ia, D - jS M, Y',strtotime($file['uploadtime']));
			$filename=$file['filename'];
			echo $time.' - <span style="color: blue;">'.$filename.'</span><br>';
		}
	?>
	</div>
	<div class="rTableCell center">
		<?php if(!$graded): ?>
			<select name="gradeu" class="form-control" style="font-size: 18px;">
				<option value="" selected="selected" disabled="disabled">Select</option>
				<option value="Low">Low</option>
				<option value="Medium">Medium</option>
				<option value="High">High</option>
			</select>
		<?php else: 
				echo $grades['gradeu'];
			endif; ?>
	</div>
	<div class="rTableCell center">
		<?php if(!$graded): ?>
			<select name="gradeq" class="form-control" style="font-size: 18px;">
				<option value="" selected="selected" disabled="disabled">Select</option>
				<option value="Low">Low</option>
				<option value="Medium">Medium</option>
				<option value="High">High</option>
			</select>
		<?php else: 
				echo $grades['gradeq'];
			endif; ?>
	</div>
	<div class="rTableCell center">
		<?php if(!$graded): ?>
			<textarea name="feedback" class="form-control" style="font-size: 18px; line-height: 18px; resize: vertical;"></textarea>
		<?php else: ?>
			<textarea name="feedback" class="form-control" disabled="disabled" style="font-size: 18px; line-height: 18px; resize: vertical;"><?php echo $grades['feedback'] ?></textarea>
		<?php endif; ?>
	</div>
	<div class="rTableCell center">
		<?php if(!$graded): ?>
			<input type="submit" name="grade" value="Grade & Email" method="post"/>
		<?php else: ?>
			Graded and Emailed
		<?php endif; ?>
	</div>
</form>

<?php $i++;} //end while loop ?>
</div> <!-- close table -->
<?php } // end if !row_cnt==0 ?>

<?php } else { //end if session isset??>
	<div class="container" id="notsignedin">
		<div class="alert alert-warning">
			You are not signed in! Please <a href="adminlogin.php" class="alert-link">log in</a> first.
		</div>
	</div>

<?php }//end else session isset? ?> 
</div> <!-- close content -->

<?php include 'footer.php' ?>
</div><!--  close wrapper -->
<script type="text/javascript">
	$( "#page" ).change(function() {
 		$("#submit").trigger('click');
	});
</script>
</body>
</html>