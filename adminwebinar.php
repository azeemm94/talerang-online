<?php session_start();
require 'connectsql.php'; 
/*
Edit $teamnames when adding new team members
Keep fullname two words only!!
*/
$teamnames=array(
    array("Shveta Raina","shveta@talerang.com"),
    array("Kshitij Jain","kshitij@talerang.com"),
    array("Zahn Patuck","zahn@talerang.com"),
    array("Diptee Nair","diptee@talerang.com"),
    array("Nishita Bajaj","nishita@talerang.com"),
    array("Srividhya Jayakumar","srividhya@talerang.com"),
    array("Pranjali Barick","pranjali@talerang.com"),
    array("Bijon Keswani","bijon@talerang.com"),
    array("Bineet Hora","bineet@talerang.com"),
    array("Vikhyat Nanda","vikhyat@talerang.com")
);

if(isset($_POST['webinar-submit']))
{
	function getrandom()
    {
        $chars = "123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"; 
        $res="";
        for ($j=0;$j<8; $j++) $res .= $chars[mt_rand(0, strlen($chars)-1)];
        return $res;
    }
    function generate_id()
    {
        $notgenerated=true; $random="";
        while($notgenerated)
        {
        	require 'connectsql.php';
            $random=getrandom(); 
            //Checks if ID isn't already in database
            if(! mysqli_num_rows(mysqli_query($DBcon,"SELECT `webinarid` FROM `webinar` WHERE `webinarid`='$random'")))
            {
                if(! is_numeric($random))
                $notgenerated=false;
            }
        }
        return $random;
    }
    $webinar_id=generate_id();
	$webinar_title=mysqli_real_escape_string($DBcon,$_POST['webinar-title']);
	$webinar_desc=mysqli_real_escape_string($DBcon,nl2br($_POST['description']));
	$teamoption=$_POST['webinar-conductor'];
	$webinar_cemail=mysqli_real_escape_string($DBcon,substr($teamoption,strpos($teamoption,'<')+1,strpos($teamoption,'>')-strpos($teamoption,'<')-1));
	$webinar_cond=mysqli_real_escape_string($DBcon,substr($teamoption,0,strpos($teamoption,'<')-1));
	$webinar_time=mysqli_real_escape_string($DBcon,$_POST['hour'].':'.$_POST['minute'].' '.$_POST['ampm']);
	$webinar_date=mysqli_real_escape_string($DBcon,$_POST['webinar-date']);
	$webinar_link=mysqli_real_escape_string($DBcon,$_POST['webinar-link']);

	$sql="INSERT INTO `webinar` (`webinarid`,`conductor`,`cemail`,`datescheduled`,`time`,`title`,`description`,`link`)
	VALUES ('$webinar_id','$webinar_cond','$webinar_cemail','$webinar_date','$webinar_time','$webinar_title','$webinar_desc','$webinar_link');";

	require 'connectsql.php';
	mysqli_query($DBcon,$sql);
	//header('location:adminwebinar.php');
}
if(isset($_POST['submit-delete']))
{
	$webinarid=$_POST['webinarid'];
	$sql="DELETE FROM `webinar` WHERE `webinarid`='$webinarid';";
	mysqli_query($DBcon,$sql);
	header('location:adminwebinar.php');
}
if(isset($_POST['submit-edit']))
{
	$webinarid=$_POST['webinarid'];
	$link=mysqli_real_escape_string($DBcon,$_POST['webinar-link']);
	$sql="UPDATE `webinar` SET `link`='$link' WHERE `webinarid`='$webinarid';";
	mysqli_query($DBcon,$sql);
	header('location:adminwebinar.php');
}
if(isset($_POST['submit-email']))
{
	$alldetails=json_decode($_POST['emails'],true);
	var_dump($alldetails);
	$cemail=$_POST['cemail'];
	$time=$_POST['time'];
	$date=$_POST['date'];
	$title=$_POST['title'];
	$description=$_POST['description'];
	$link=$_POST['link'];
	include("vendor/phpmailer/phpmailer/PHPMailerAutoload.php");
	try 
	{
	    $mail = new PHPMailer(true);
	    $mail->IsSMTP(); // Using SMTP.
	    $mail->CharSet = 'utf-8';
	    $mail->Host = "smtp.gmail.com"; // SMTP server host.
	    $mail->SMTPSecure   = "ssl";
	    $mail->Port         =465;
	   // $mail->SMTPDebug = 2; // Enables SMTP debug information - SHOULD NOT be active on production servers!
	    $mail->SMTPAuth = true; // Enables SMTP authentication.

	    $mail->Username='support@talerang.com'; // SMTP account username 
	    $mail->Password='TalerangSupport2015';  // SMTP account password 
	    
	    $mail->SetFrom('support@talerang.com', 'Talerang Support Team');
	    $mail->AddReplyTo('support@talerang.com', 'Talerang Support Team');

	    //$mail->AddAddress($signinemail,$fullname); 
	    $mail->AddCC($cemail,'');
	    for ($i=0; $i <count($alldetails['emails']) ; $i++) 
	    $mail->AddBCC($alldetails['emails'][$i],$alldetails['names'][$i]);
	    //$fullname=$_SESSION['firstname']." ".$_SESSION['lastname'];
	    //$mail->AddAddress('azeem.talerang@gmail.com', 'Azeem Merchant'); 
	    //$mail->AddAddress('azeem_merchant999@hotmail.com', 'Azeem Merchant'); 
	    
	    $mail->Subject = 'Talerang Webinar';
	    $mail->AddEmbeddedImage('img/logoemail.gif', 'logo');
	    //$mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
	    $emailbody='<!DOCTYPE html><html><head></head><body>Dear student,<br><br>A webinar that you are interested in is going to start soon.<br><br>Webinar: <u><b>'.$title.'</b></u><br><br>'.$description.'<br><br>This webinar is scheduled to start on: <b>'.$date.'</b> at <b>'.$time.'</b><br><br>Please click on this link to join: '.$link.'<br><br>Regards,<br>Team Talerang<br><img src="cid:logo" width="150px"/></body></html>';

	    $mail->MsgHTML($emailbody);
	      
	    if(!$mail->Send())
	        echo '<div class="notif fail">Oops! Something went wrong please try again.</div>';
	    else echo '<div class="notif success">Email sent!</div>'; 
	} 
	catch (phpmailerException $e) 
	{
	    echo $e->errorMessage(); 
	} 
	catch (Exception $e) 
	{
	    echo $e->getMessage(); 
	}
}
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
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
	<?php include 'noscript.php' ?>
	<style>
		.form-control.time{
			width: auto;
			display: inline-block;
		}
		.form-control{
			font-size: 20px;
			margin-top: 10px;
		}
		#submit-webinar{
			margin-top: 10px;
		}
	</style>
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
<?php if(isset($_SESSION['adminuser'])){ ?>
<div class="container-fluid">
	<form action="adminwebinar.php" method="post" id="webinarsch" name="webinarsch">
		<div><b><u>Schedule a new webinar:</u></b></div>
		<input type="text" class="form-control" name="webinar-title" placeholder="Title for this webinar">
		<textarea class="form-control" name="description" placeholder="Write a short description of the webinar" style="resize: vertical;"></textarea>
		<input type="text" class="form-control" name="webinar-link" placeholder="Link to join this webinar">
		<select name="webinar-conductor" class="form-control">
			<option value="" selected="selected" disabled="disabled">Who is going to run this webinar?</option>
			<?php  
				for ($i=0; $i <count($teamnames) ; $i++) 
				{ 
					$name=$teamnames[$i][0];
					$email=$teamnames[$i][1];
					$option=$name.' &lt;'.$email.'&gt;';
					echo '<option value="'.$option.'">'.$option.'</option>';
				}
			?>
		</select>
		
		<input type="datepicker" class="form-control" name="webinar-date" id="datepickers" placeholder="Date to schedule this webinar on">
		<div>
			Time:
			<select name="hour" class="form-control time">
				<option value="" selected="selected" disabled="disabled">HH</option>
				<?php 
				for ($i=1; $i<=12 ; $i++)
				{	
					if($i<10)
						echo '<option value="0'.$i.'">0'.$i.'</option>';
					else
						echo '<option value="'.$i.'">'.$i.'</option>';
				} 
				?>
			</select>
			:
			<select name="minute" class="form-control time">
				<option value="" selected="selected" disabled="disabled">MM</option>
				<option value="00">00</option>
				<option value="05">05</option>
				<?php 
				for ($i=10; $i<=55; $i+=5)
					echo '<option value="'.$i.'">'.$i.'</option>';
				?>
			</select>
			<select name="ampm" class="form-control time">
				<option value="" selected="selected" disabled="disabled">AM/PM</option>
				<option value="AM">AM</option>
				<option value="PM">PM</option>
			</select>
		</div>
		<input type="submit" name="webinar-submit" value="Schedule" id="submit-webinar">
	</form>
</div>
<?php 
$sql="SELECT * FROM `webinar`;";
$result=mysqli_query($DBcon,$sql);
$scheduled=mysqli_num_rows($result);
if($scheduled):
?>
<div style="margin-left: 10px;"><b><u>Scheduled webinars:</u></b></div>
<div class="rTable">
<div class="rTableRow">
	<div class="rTableHead center" style="border-left: 0">No</div>
	<div class="rTableHead center">Conductor</div>
	<div class="rTableHead center">Webinar Title</div>
	<div class="rTableHead center">Description</div>
	<div class="rTableHead center">Scheduled Time</div>
	<div class="rTableHead center">Link</div>
	<div class="rTableHead center">Confirmed students</div>
	<div class="rTableHead center">Edit</div>
	<!-- <div class="rTableHead center"></div> -->
</div>
<?php 
$i=0;
while($row=mysqli_fetch_assoc($result)) 
{	
$confirmed=explode(',',$row['confirmedacc']);
$alldetails=array('names'=>array(),'emails'=>array());
for ($j=0; $j< count($confirmed); $j++) 
{ 
	$account=$confirmed[$j];
	$details=mysqli_fetch_assoc(mysqli_query($DBcon,"SELECT `firstname`,`lastname`,`email` FROM `register` WHERE `accountno`='$account';"));
	array_push($alldetails['names'], $details['firstname'].' '.$details['lastname']);
	array_push($alldetails['emails'], $details['email']);
}
?>
<form class="rTableRow <?php if($i%2==0) echo "evenRow" ?>" method="post" action="adminwebinar.php"  onSubmit="return confirm('Are you sure?')">
	<input type="hidden" name="webinarid" value="<?php echo $row['webinarid'] ?>">
	<input type="hidden" name="cemail" value="<?php echo $row['cemail'] ?>">
	<input type="hidden" name="emails" value="<?php echo htmlspecialchars(json_encode($alldetails));?>">
	<input type="hidden" name="title" value="<?php echo $row['title']; ?>">
	<input type="hidden" name="description" value="<?php echo $row['description']; ?>">
	<input type="hidden" name="time" value="<?php echo $row['time']; ?>">
	<input type="hidden" name="date" value="<?php echo $row['datescheduled']; ?>">
	<input type="hidden" name="link" value="<?php echo $row['link']; ?>">
	<div class="rTableCell center"><?php echo ($i+1); ?></div>
	<div class="rTableCell center"><?php echo $row['conductor']; ?></div>
	<div class="rTableCell center"><?php echo $row['title']; ?></div>
	<div class="rTableCell center"><?php echo $row['description']; ?></div>
	<div class="rTableCell center"><?php echo $row['datescheduled'].' at '.$row['time']; ?></div>
	<div class="rTableCell center"><input type="text" name="webinar-link" value="<?php echo $row['link'] ?>" class="form-control" placeholder="Enter link and save"></div>
	<div class="rTableCell center">
		<?php 
		if($row['confirmedacc']!="")
		{
			echo implode(', ', $alldetails['names']);
		}
		else
			echo "No students confirmed";
		?>
	</div>
	<div class="rTableCell center">
		<div><input type="submit" name="submit-delete" value="Delete"></div>
		<div><input type="submit" name="submit-edit" value="Save" style="margin-top: 2px"></div>
		<div><input type="submit" name="submit-email" value="Email confirmed" style="margin-top: 2px"></div>
	</div>
</form>


<?php $i++;} //end while loop ?>
</table>
<?php else: //no webinars scheduled ?>
	<div class="container">
		<div class="alert alert-warning">
			No webinars are scheduled yet. Use the form above to schedule a webinar
		</div>		
	</div>

<?php endif; ?>
<?php } else { ?> <!-- end if session isset? -->
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
<script type="text/javascript">
	$( "#page" ).change(function() {
 		$("#submit").trigger('click');
	});

$(function() {
	$('#datepickers').each(function(){
		$(this).datepicker({ 
			showAnim:"slideDown",
			changeMonth:true,
			changeYear:false,
			showOtherMonths: true,
			selectOtherMonths: false,
			dateFormat: 'D, d M yy', 
			minDate: new Date(),
		});
	});
});

$('#webinarsch').validate({
	errorClass: 'error',
	rules: {
		'webinar-title' :     {required: true},
		'webinar-conductor' : {required: true},
		'webinar-date' :      {required: true},
		'hour':               {required: true},
		'minute':             {required: true},
		'ampm':               {required: true},
	}
});
</script>
</body>
</html>