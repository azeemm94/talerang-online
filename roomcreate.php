<?php session_start();
date_default_timezone_set('Asia/Kolkata'); 

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

if(isset($_GET['hash']))
$hashemailed=$_GET['hash'];
else $hashemailed="";

if(isset($_GET['roomname']))
$currentroom=$_GET['roomname'];
else $currentroom="";

if(isset($_POST['enter']))
{
    if(!in_array($_SERVER['REMOTE_ADDR'],array('127.0.0.1','::1')))
    {
    $semail=$_POST['semail'];
    $cemail=$_POST['cemail'];
    $student=$_POST['student'];
    $counsellor=$_POST['counsellor'];
    $roomname=$_POST['roomname'];
    $hash=$_POST['hash'];
    require("vendor/phpmailer/phpmailer/PHPMailerAutoload.php");
    try 
    {
        $mail = new PHPMailer(true);
        $mail->IsSMTP(); // Using SMTP.
        $mail->CharSet = 'utf-8';
        $mail->Host = "smtp.gmail.com"; // SMTP server host.
        $mail->SMTPSecure   = "ssl";
        $mail->Port         = 465;
       // $mail->SMTPDebug = 2; // Enables SMTP debug information - SHOULD NOT be active on production servers!
        $mail->SMTPAuth = true; // Enables SMTP authentication.

        $mail->Username='support@talerang.com'; // SMTP account username 
        $mail->Password='TalerangSupport2015';        // SMTP account password 
        
        $mail->SetFrom('support@talerang.com', 'Talerang Support Team');
        $mail->AddReplyTo('support@talerang.com', 'Talerang Support Team');
        $mail->AddAddress($semail,$student);  
        $mail->AddCC($cemail,$counsellor);  
        $mail->AddEmbeddedImage('img/logoemail.gif', 'logo');
        //$mail->AddAddress('azeem.talerang@gmail.com', 'Azeem');
        
        $mail->Subject = 'Talerang video session link';
        $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
        $body='<html><body><img src="cid:logo" width="150px"/><br>Dear '.$student.',<br><br> Your video chat session with the counsellor is ready! Please join the room by <a href="http://www.talerang.com/express/mockroom.php?room='.$hash.'" target="_blank">clicking this link</a><br><br>If you have trouble with the above link, copy and paste this link into your browser: <a>http://appear.in/'.$roomname.'</a><br><br>Regards,<br>Team Talerang.</body></html>';
        $mail->MsgHTML($body);
        
        if(!$mail->Send())
        echo 'Message could not be sent';
        else //Message sent!
        {
            header('location: http://www.talerang.com/express/roomcreate.php?hash='.$hash.'&roomname='.$roomname);
        }
        
    } 
    catch (phpmailerException $e) 
    {
        echo $e->errorMessage(); 
    } 
    catch (Exception $e) 
    {
        echo $e->getMessage(); 
    } 
    }//end mailer  //endif server ! localhost
}//end isset post enter;

?>
<html>
  <head>
    <title>Talerang Express | Interview Room</title>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <link rel="stylesheet" type="text/css" href="css/style.css?version=2.1">
    <link rel="stylesheet" type="text/css" href="css/adminstyle.css">
    <link rel="stylesheet" type="text/css" href="css/roomcreate.css?version=1.1">
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
  <?php 
    require "connectsql.php";

    if(isset($_POST['roomcreate']))
    {
        $studentemail=$_POST['studentemail'];

        $studentname=strpos($studentemail,'<');
        $studentname=substr($studentemail, 0, $studentname-1);

        $studentemail=substr($studentemail,strpos($studentemail,'<')+1);
        $studentemail=substr($studentemail,0,strlen($studentemail)-1);
        $roomid=mysqli_real_escape_string($DBcon,uniqid());

        $cemail=$_POST['counsellor'];
        for ($i=0; $i < count($teamnames); $i++) 
        { 
            if($teamnames[$i][1]==$cemail)
                $counsellor=$teamnames[$i][0];
        }

        $roomname=strtolower("talerang-".substr($counsellor, 0,strpos($counsellor,' ')));
        $studentname=mysqli_real_escape_string($DBcon,$studentname);
        $studentemail=mysqli_real_escape_string($DBcon,$studentemail);
        $cemail=mysqli_real_escape_string($DBcon,$cemail);
        $counsellor=mysqli_real_escape_string($DBcon,$counsellor);
        $date=mysqli_real_escape_string($DBcon,date("Y-m-d h:i:sa"));

        $hash=sha1(chr(rand(65,90)).chr(rand(65,90)).chr(rand(65,90)).chr(rand(65,90)).chr(rand(65,90)).chr(rand(65,90)));

        $sql="INSERT INTO `activemockroom` (`counsellor`,`cemail`,`student`,`semail`,`timeactivated`,`roomid`,`roomname`,`active`,`hash`)
                  VALUES('$counsellor','$cemail','$studentname','$studentemail','$date','$roomid','$roomname',true,'$hash');";
        mysqli_query($DBcon,$sql);
    }

    if(isset($_POST['deactivate']))
    {
        $roomid=$_POST['roomid'];
        $sql="UPDATE `activemockroom`
                SET `active`='false'
                WHERE `roomid`='$roomid';";
        mysqli_query($DBcon,$sql);
        header('location:roomcreate.php');
    }

    $sql="SELECT `email`,`firstname`,`lastname` FROM `register` WHERE `active`='1' ORDER BY `email` ASC;";
    $result=mysqli_query($DBcon,$sql);
    $registercontacts=array();
    while ($row=mysqli_fetch_assoc($result)) {
        $temp=$row['firstname']." ".$row['lastname']." <".$row['email'].">";
        array_push($registercontacts,$temp);
    }
    $erroremail="";
    if(isset($_POST['submit']))
    {
        if(!in_array($_POST['studentemail'],$registercontacts))
        $erroremail="This email address does not exist";

        $roomname="talerang-".strtolower($_POST['counsellor']);
        echo "Room name: ".$roomname."<br>";
        echo '<iframe src="https://appear.in/'.$roomname.'" style="width:100%; height:100%" frameborder="0"></iframe>';
    }
  ?>

<?php if(!isset($_POST['submit'])){ ?>
<div class="container">
  <div class="row">
    <div class="col-md-12">
        <form name="videoemail" action="" method="post" id="videoemail">
            <div class="row">
                <div class="col-md-4">
                    <select name="counsellor" class="form-control">
                        <option selected="selected" disabled="disabled">Select</option>
                        <?php
                            for ($i=0; $i<count($teamnames); $i++) 
                            echo '<option value="'.$teamnames[$i][1].'">'.$teamnames[$i][0].'</option>';
                        ?>
                    </select>
                    <label for="counsellor">Counsellor</label><br>
                    <label for="counsellor" class="error"></label>
                </div>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="studentemail" id="studentemail" placeholder="Type at least 2 characters">
                    <label for="studentemail">Student Email: </label>
                    Please search for the student email/name and enter from the dropdown list only<br>
                    <label for="studentemail" class="error"></label>
                </div>
                <div class="col-md-4">
                    <input type="submit" name="roomcreate" id="roomcreate" value="Add Room"/>
                </div>                
            </div>
            <div class="phperror"><?php //echo $erroremail; ?></div>
        </form>
    </div>
  </div>
</div>
<div class="container-fluid">
  <div class="row">
      <?php 
      $sql="SELECT * FROM `activemockroom` WHERE `active`='1';";
      $result=mysqli_query($DBcon,$sql); 
      $rooms=mysqli_num_rows($result); 
if($rooms){
      ?>
<div class="rTable">
        <div class="rTableRow">
            <div class="rTableHead" style="border-left: 0;">No</div>
            <div class="rTableHead">Counsellor Name</div>
            <div class="rTableHead">Student Name</div>
            <div class="rTableHead">Student Mobile</div>
            <div class="rTableHead">Student Email</div> 
            <div class="rTableHead">Room Name</div> 
            <div class="rTableHead">Date Created</div> 
            <div class="rTableHead">Email Student</div> 
            <div class="rTableHead">Deactivate Room</div> 
        </div>

 <?php 
 $i=1;
 while ($row=mysqli_fetch_assoc($result)) {
    $semail=$row['semail'];
    /*require 'connectsql.php';*/
    $sql2="SELECT `phoneno` FROM `register` WHERE `email`='$semail' LIMIT 1;"; 
    $mobileno=mysqli_fetch_row(mysqli_query($DBcon,$sql2));
    $mobileno=$mobileno[0];
    $timeactivated=strtotime($row['timeactivated']);
    $timeactivated=date("jS M, h:ia",$timeactivated)
    ?>

        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" name="mockroom" id="mockroom<?php echo $i ?>" class="rTableRow <?php if($i%2==0) echo "evenRow" ?>">
            <div class="rTableCell center" style="border-left: 0;">
                <?php echo $i ?>
                <input type="text" name="roomid" class="displaynone" value="<?php echo $row['roomid'] ?>">
                <input type="text" name="hash" class="displaynone" value="<?php echo $row['hash'] ?>">
                <input type="text" name="semail" class="displaynone" value="<?php echo $row['semail'] ?>">
                <input type="text" name="cemail" class="displaynone" value="<?php echo $row['cemail'] ?>">
                <input type="text" name="student" class="displaynone" value="<?php echo $row['student'] ?>">
                <input type="text" name="roomname" class="displaynone" value="<?php echo $row['roomname'] ?>">
                <input type="text" name="counsellor" class="displaynone" value="<?php echo $row['counsellor'] ?>">
            </div>
            <div class="rTableCell center"><?php echo $row['counsellor'] ?></div>
            <div class="rTableCell center"><?php echo $row['student'] ?></div>
            <div class="rTableCell center"><?php echo $mobileno ?></div>
            <div class="rTableCell center"><?php echo $row['semail'] ?></div>
            <div class="rTableCell center"><?php echo $row['roomname'] ?></div>
            <div class="rTableCell center"><?php echo $timeactivated ?></div>
            <div class="rTableCell center">
            <?php 
                if($hashemailed==$row['hash']) 
                { 
                    echo "Email sent<br>"; 
                    echo '<input type="submit" class="deactivate" name="enter" value="Send Again" />';
                }
                else echo '<input type="submit" class="deactivate" name="enter" value="Send Email" />';
            ?>
            </div>
            <div class="rTableCell center"><input type="submit" class="deactivate" name="deactivate" value="Deactivate" /></div>
        </form>
      <?php $i++;
      }//end while loop ?>
</div> <!-- close table -->
<?php if($hashemailed==""): ?>
<div class="container alert alert-success" style="text-align: center;">
    Clicking <b>'Send Email'</b> will send the student an email with a link to the room.
</div>
<?php else: ?>
<div class="container alert alert-success" style="text-align: center;">
    Please go to <a href="https://appear.in/<?php echo $currentroom ?>" class="alert-link" target="_blank">Appear.in</a> and sign in to your account
</div>
<?php endif; ?>

<?php } //end if rooms
     else{ // no active rooms ?>  
        <div class="container alert alert-warning" style="text-align: center">
            No mock interview rooms are currently active, please create a new one from above.
        </div>
<?php } ?>
  </div>
</div>

<?php } ?>
  

<script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.1/jquery.validate.min.js"></script>
<script type="text/javascript" src="js/roomcreate.js"></script>
<script type="text/javascript">
    $(function() {
        var accounts = <?php echo json_encode($registercontacts); ?>;
        $( "#studentemail" ).autocomplete({ source: accounts });
        $( "#studentemail" ).autocomplete("option", "minLength", 2);
        } );
</script>
</div> <!-- end content -->

<?php include 'footer.php'; ?>
</div> <!-- end wrapper -->
  </body>
</html>