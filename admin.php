<?php session_start();
require 'connectsql.php';

if(isset($_POST['page'])) 
	$curpg=$_POST['page'];
elseif(isset($_GET['pgno']))
	$curpg=$_GET['pgno'];
else $curpg=1;

if(isset($_POST['update']))
{
	$lvgrade1=$_POST['lvgrade1'];
	$lvgrade2=$_POST['lvgrade2'];
	$lvgrade=mysqli_real_escape_string($DBcon, nl2br($_POST['lifevisfeedback']));
	$email=$_POST['email'];
    $sql="UPDATE `results` SET `lv1grade`='$lvgrade1',`lv2grade`='$lvgrade2',`lvgrade`='$lvgrade',`graded`='1' WHERE `email`='$email'";
    mysqli_query($DBcon,$sql);
    $DBcon->close();
    $search=$_POST['search'];
    header("location:admin.php?pgno=".$curpg."&search=".$search);
}
if(isset($_POST['reset']))
{
	$email=$_POST['email'];
	$sql="UPDATE `results` SET `lv1grade`='',`lv2grade`='',`lvgrade`='',`graded`='0' WHERE `email`='$email'";
	mysqli_query($DBcon,$sql);
    $DBcon->close();
    $search=$_POST['search'];
    header("location:admin.php?pgno=".$curpg."&search=".$search);
}
if(isset($_POST['confirm']))
{
	$email=$_POST['email'];
	$sql="SELECT `lv1grade`,`lv2grade`,`lvgrade`,`firstname`,`lastname` FROM `results` WHERE `email`='$email'";
	$result=mysqli_query($DBcon,$sql);
	$row=mysqli_fetch_assoc($result);
	$lvgrade1=$row["lv1grade"];
	$lvgrade2=$row["lv2grade"];
	$lvgrade=$row["lvgrade"];
	$fullname=$row["firstname"]." ".$row["lastname"];
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
		    $mail->Port         = 465;
		   // $mail->SMTPDebug = 2; // Enables SMTP debug information - SHOULD NOT be active on production servers!
		    $mail->SMTPAuth = true; // Enables SMTP authentication.

		    $mail->Username='support@talerang.com'; // SMTP account username example
		    $mail->Password='TalerangSupport2015';        // SMTP account password example
		    
		    $mail->SetFrom('support@talerang.com', 'Talerang Support Team');
		    $mail->AddReplyTo('support@talerang.com', 'Talerang Support Team');
		    $mail->AddAddress($email,$fullname); 
		    //$mail->AddAddress('azeem.talerang@gmail.com', 'Azeem');
		    
		    $mail->Subject = 'WRAP Life Vision Essay Grades';
		    $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
		    $body="<html><body>Dear ".$fullname.",<br> Your life vision essay grades are as follows: <br><ul><li>Life Vision essay 1 (What matters most to you and why?) : <b>".$lvgrade1."</b></li><li> Life Vision essay 2 (What is your plan for the next 3-5 years?) : <b>".$lvgrade2."</b></li></ul><p>The counsellor has given the following feedback:<br><br><b>\"".$lvgrade."\"</b></p>Regards,<br>Team Talerang.</body></html>";
		    $mail->MsgHTML($body);
		    
		    
		    if(!$mail->Send())
		    echo 'Message could not be sent';
		    else ;//echo 'Message sent!';
		    
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
	header("location:admin.php?pgno=".$curpg."&search=".$search);
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
	<link rel="stylesheet" type="text/css" href="css/adminstyle.css?version=1.1">
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
		$search=mysqli_real_escape_string($DBcon,$search);
		$query="SELECT `lv1`,`lv2`,`firstname`,`lastname`,`email`,`graded`,`lv1grade`,`lv2grade`,`id`,`lvgrade` FROM `results` WHERE `firstname` LIKE '%$search%' OR `lastname` LIKE '%$search%' OR `email` LIKE '%$search%'";
		$result=mysqli_query($DBcon,$query);
		$row_cnt=mysqli_num_rows($result);
		$nopgs=10; // no of entries you want per page
		$pgs=ceil($row_cnt/$nopgs); ?>

		<div id="search">
			<p>You may search either by first/last name or email</p> 
		    <form  method="post" action="admin.php"  id="searchform"> 
				<input type="text" name="search" value="<?php echo $search ?>"> 
				<input type="submit" name="search-submit" value="Search">
				<a href="admin.php" target="_self" id="showall">Show all entries</a>
		    </form> 
	    </div>

		<?php if(!$row_cnt==0) echo "<div id=\"num\">Total number of entries: ".$row_cnt."</div>"; ?>
		<?php if(!$row_cnt==0 && $pgs>1){ ?>
		<form method="post" action="admin.php" id="pages">
			<label for="page">Page No:</label>
			<select name="page" id="page">
				<?php 
					for($i=1; $i <=$pgs ; $i++) 
					{
						if($i!=$curpg)
							echo "<option value=\"".$i."\">".$i."</option>";
						else
							echo "<option value=\"".$i."\" selected>".$i."</option>";
					}
				?>
			</select>
			<input type="submit" name="submit" id="submit" style="display: none">
			<?php if($curpg!=1){ ?><a href="admin.php?pgno=<?php echo ($curpg-1) ?>&search=<?php echo $search ?>" class="prevnext" target="_self">&lt;&lt; Previous</a><?php } ?>
			<?php if($curpg!=$pgs){ ?><a href="admin.php?pgno=<?php echo ($curpg+1) ?>&search=<?php echo $search ?>" class="prevnext" target="_self">Next &gt;&gt;</a><?php } ?>
		</form>
		<?php } //end if row_cnt!=0 ?>
<?php	require 'connectsql.php';
		$pgstart=($curpg-1)*$nopgs; 
if($row_cnt==0) echo "<div style=\"margin-left:20px\"><b>$search</b> not found! Please search again</div>";
if(!$row_cnt==0){ ?>
<div class="rTable">
<div class="rTableRow">
	<div class="rTableHead center">No</div>
	<div class="rTableHead center">Full Name</div>
	<div class="rTableHead center">Email</div>
	<div class="rTableHead">Life Vision 1<br>What matters most to you and why?</div>
	<div class="rTableHead center">Life Vision 1 Grade</div>
	<div class="rTableHead">Life Vision 2<br>What is your plan for the next 3-5 years?</div>
	<div class="rTableHead center">Life Vision 2 Grade</div>
	<div class="rTableHead">Feedback</div>
	<div class="rTableHead center">Update grades</div>
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
	$f1=$row[0];
	$f2=$row[1];
	$f3=$row[2]." ".$row[3];
	$f4=$row[4]; 
	$f1=str_ireplace(array("<br />","<br>","<br/>"), "\r\n", $f1); 
	$f2=str_ireplace(array("<br />","<br>","<br/>"), "\r\n", $f2); 
?>

<form method="post" class="lifevisform rTableRow <?php if($i%2==0)echo 'evenRow' ?>" action="<?php echo $_SERVER['PHP_SELF']; ?>">
	<input type="text" name="page" value="<?php echo $curpg ?>" style="display:none">
	<input type="text" name="search" value="<?php echo $search ?>" style="display:none">
	<div class="rTableCell center"><?php echo ($i+1);//$row[8]; ?></div>
	<div class="rTableCell center"><?php echo $f3; ?></div>
	<div class="rTableCell center"><?php echo $f4; ?><input style="display:none" name="email" type="text" value="<?php echo $f4; ?>"/></div>
	<div class="rTableCell"><p><?php if(!$f1=="") echo '<textarea class="disabled" disabled="disabled">'.$f1.'</textarea>'; else echo "---" ?></p></div>
	<div class="rTableCell center">
	<?php if($row[5]==1||$row[5]==2) echo $row[6]; 
			elseif ($row[5]==0){ ?>
		<select name="lvgrade1">
			<option <?php if(!$f1=="") echo "selected" ?> disabled value="">Grade</option>
			<?php if(!$f1==""){ ?> 
			<option value="Low">Low</option>
			<option value="Medium">Medium</option>
			<option value="High">High</option>
			<?php } ?>
			<?php if($f1==""){ ?><option value="Not attempted" selected>Not attempted</option><?php } ?>
		</select>
		<?php } ?>
	</div>
	<div class="rTableCell"><p><?php if(!$f2=="") echo '<textarea class="disabled" disabled="disabled">'.$f2.'</textarea>'; else echo "---" ?></p></div>
	<div class="rTableCell center">
	<?php if($row[5]==1||$row[5]==2) echo $row[7]; 
			elseif ($row[5]==0){ ?>
		<select name="lvgrade2">
			<option <?php if(!$f2=="") echo "selected" ?> disabled value="">Grade</option>
			<?php if(!$f2==""){ ?> 
			<option value="Low">Low</option>
			<option value="Medium">Medium</option>
			<option value="High">High</option>
			<?php } ?>
			<?php if($f2==""){ ?><option value="Not attempted" selected>Not attempted</option><?php } ?>
		</select> 
		<?php } ?>
	</div>
	<div class="rTableCell">
	<?php if($row[5]==1||$row[5]==2) echo $row[9]; 
			elseif ($row[5]==0){ ?>
		<textarea name="lifevisfeedback" style="width:auto; height:100%; resize: vertical"><?php if($f1=="" && $f2=="") echo "We cannot provide any feedback since you have not attempted these questions."; ?></textarea>
		<?php } ?>
	</div>
	<div class="rTableCell center">
		<?php if($row[5]==0){ ?>
		<input type="submit" name="update" value="Update" method="post" id="update"/>
		<?php } elseif($row[5]==1){ ?>
		<input type="submit" name="reset" value="Reset" method="post" id="reset"/>
		<input type="submit" name="confirm" value="Confirm" method="post" id="confirm"/>
		<?php } elseif($row[5]==2){?>
		Grades confirmed, email sent to student.
		<?php } ?>
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
<script type="text/javascript" src="js/admin.js"></script>
</body>
</html>