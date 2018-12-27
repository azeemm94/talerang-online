<?php session_start();
if(!isset($_SESSION['adminuser'])) { header('location:adminlogin.php'); exit;}
unset($_SESSION['useremail']);
unset($_SESSION['firstname']);
unset($_SESSION['lastname']);
unset($_SESSION['sndtprogram']);
unset($_SESSION['accountno']);
  /*echo session_id();*/
date_default_timezone_set('Asia/Kolkata');
if(isset($_POST["export_excel_register"])) header('location:exportexcel_register.php'); 
if(isset($_POST["export_excel_results"]))  header('location:exportexcel_results.php');
if(isset($_POST["export_excel_sndt"]))     header('location:exportexcel_sndt.php');

require 'connectsql.php';
$sql="SELECT `id` FROM `register` WHERE `college`!='SNDT University';";
$registered=mysqli_num_rows(mysqli_query($DBcon,$sql));
$sql="SELECT `id` FROM `results`;";
$wrap=mysqli_num_rows(mysqli_query($DBcon,$sql));
$sql="SELECT `id` FROM `register` WHERE `college`='SNDT University';";
$sndt=mysqli_num_rows(mysqli_query($DBcon,$sql));
$sql="SELECT `results`.`accountno` FROM `results` INNER JOIN `register` ON `results`.`accountno`=`register`.`accountno` WHERE `college`='SNDT University';";
$sndtwrap=mysqli_num_rows(mysqli_query($DBcon,$sql));
$wrap-=$sndtwrap;
?>  
<html>  
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1" />
    <meta name="robots" content="noindex, nofollow">
    <title>Talerang Express | Admin Panel</title>  
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> 
    <link rel="stylesheet" href="css/excelstyle.css?version=1.3" />
    <?php include 'noscript.php' ?>
    <?php include 'jqueryload.php' ?>
    <style type="text/css">
        .notif.success{
        color: green;
        font-size: 22px;
        font-weight: lighter;
        }
    </style>
</head>
<body>  
    <div id="wrapper">
        <div id="header">
            <img src="img/logoexpress.jpg" alt="Talerang">   
            <div id="admin">Admin<?php if($_SESSION['privilege']==1) echo ' - Shveta'; ?></div>
            <?php if(isset($_SESSION['adminuser'])){?>
            <a href='adminlogout.php' id="logout">Logout</a> 
            <?php } ?>
        </div>
    <div class="clearfix"></div>
        <?php if(isset($_SESSION['adminuser'])){ ?>
        <div class="container" id="content"> 
            <div class="rTable">
                <div class="rTableRow">
                    <div class="rTableCell blank center">No of Users</div>
                    <div class="rTableHead center">Talerang Express</div>
                    <div class="rTableHead center">SNDT Program</div>
                    <div class="rTableHead center">Total Users</div>
                </div>
                <div class="rTableRow evenRow">
                    <div class="rTableHead center">Registered Users</div>
                    <div class="rTableCell center"><?php echo $registered ?></div>
                    <div class="rTableCell center"><?php echo $sndt ?></div>
                    <div class="rTableCell center"><?php echo $registered+$sndt ?></div>
                </div>
                <div class="rTableRow evenRow">
                    <div class="rTableHead center">WRAP Users</div>
                    <div class="rTableCell center"><?php echo $wrap ?></div>
                    <div class="rTableCell center"><?php echo $sndtwrap ?></div>
                    <div class="rTableCell center"><?php echo $wrap+$sndtwrap ?></div>
                </div>
            </div>
            <hr>
            <div class="list-group lifevis">
                <div class="list-group-item">
                    <h3 class="list-group-item-heading">WRAP</h3>
                    <p class="list-group-item-text">
                        Grade life vision essays Low/Medium/High after students have completed the WRAP
                    </p>
                    <a href="admin.php" class="btn btn-success btn-lg adminlink">Update WRAP Life Vision Essay Grades</a>
                    <hr>
                    <p class="list-group-item-text">
                        Delete a record for a student who has completed the WRAP. This will delete their results and let them start the test again.<br>View dashboard for any student who has completed WRAP successfully.
                    </p>
                    <a href="adminreset.php" class="btn btn-success btn-lg adminlink">Reset / View WRAP</a>
                </div>
            </div>
            <div class="list-group lifevis">
                <div class="list-group-item">
                    <h3 class="list-group-item-heading">Mock Interviews</h3>
                    <p class="list-group-item-text">
                        View details submitted in the mock interview form
                    </p>
                    <a href="adminmock.php" class="btn btn-success btn-lg adminlink">View Mock Interview Form Submissions</a>
                    <hr>           
                    <p class="list-group-item-text">
                        Create a mock interview room for a student
                    </p>
                    <a href="roomcreate.php" class="btn btn-success btn-lg adminlink">Create interview room</a>
                    <hr>                       
                    <p class="list-group-item-text">
                        Give feedback for an interview that has been completed
                    </p>
                    <a href="adminmockc.php" class="btn btn-success btn-lg adminlink">Interview feedback</a>
                </div>
            </div>

            <div class="list-group lifevis">
                <div class="list-group-item">
                    <h3 class="list-group-item-heading">Resume</h3>
                    <p class="list-group-item-text">
                        Download or edit resumes of anyone who has used the Resume Creator
                    </p>
                    <a href="adminresume.php" class="btn btn-success btn-lg adminlink">Download / Edit Resumes</a>
                </div>
            </div>

            <div class="list-group lifevis">
                <div class="list-group-item">
                    <h3 class="list-group-item-heading">Webinar</h3>
                    <p class="list-group-item-text">
                        Schedule new webinars or view existing webinars. Send invites to confirmed students with link to webinar
                    </p>
                    <a href="adminwebinar.php" class="btn btn-success btn-lg adminlink">Schedule a Webinar</a>
                </div>
            </div>

            <div>  
                <div class="list-group">
                    <div class="list-group-item lifevis">
                        <h3 class="list-group-item-heading">Downloads</h3>
                        <p class="list-group-item-text">
                            Download excel files of up to date Talerang registrations and WRAP results from the database
                        </p>
                        <?php if($_SESSION['privilege']==1): ?>
                        <form method="post" action="adminlanding.php">  
                            <!-- <span class="glyphicon glyphicon-save"></span> -->
                            <label for="export_excel_register" class="btn btn-primary btn-lg">
                            <span class="glyphicon glyphicon-download-alt"></span>Download Talerang Express Registrations
                            </label>
                            <input type="submit" name="export_excel_register" class="xldl" id="export_excel_register" style="display:none"/>
                        </form> 

                        <form method="post" action="adminlanding.php">
                            <label for="export_excel_results" class="btn btn-primary btn-lg">
                            <span class="glyphicon glyphicon-download-alt"></span>Download WRAP Results
                            </label>
                            <input type="submit" name="export_excel_results" class="xldl" id="export_excel_results" style="display:none"/>  
                        </form> 
                        <?php endif;//end privilege ?>

                        <form method="post" action="adminlanding.php">
                            <label for="export_excel_sndt" class="btn btn-primary btn-lg">
                            <span class="glyphicon glyphicon-download-alt"></span>Download SNDT Registrations and WRAP
                            </label>
                            <input type="submit" name="export_excel_sndt" class="xldl" id="export_excel_sndt" style="display:none"/>  
                        </form> 
                    </div>
                </div>
            <?php if($_SESSION['privilege']==1): ?>
            <?php
            if(isset($_POST['submit-reset-password'])) 
            {           
                require 'connectsql.php';
                $hash=sha1(chr(rand(65,90)).chr(rand(65,90)).chr(rand(65,90)).chr(rand(65,90)).chr(rand(65,90)).chr(rand(65,90)));
                $date=date('Y-m-d H:i');
                $user=$_POST['account'];
                $link="http://www.talerang.com/express/resetpassadmin.php?user=".$user."&hash=".$hash;

                $sql="UPDATE `adminpass` SET `hash`='$hash',`settime`='$date' WHERE `email`='$user'";
                if(mysqli_query($DBcon,$sql))
                {
                    include("vendor/phpmailer/phpmailer/PHPMailerAutoload.php");
                    try 
                    {
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
                        $mail->AddAddress('shveta@talerang.com', 'Shveta Raina'); 

                        $mail->Subject = 'Reset your password for Talerang Express';
                        $mail->AddEmbeddedImage('img/logoemail.gif', 'logo');
                        //$mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
                        $emailbody="<!DOCTYPE html><html><head></head><body><img src='cid:logo' width=\"150px\"/><br>Dear Shveta,<br><br>Please <a href=\"".$link."\" target=\"new\">click here</a> to reset the password.<br>This link expires within 15 minutes.<br><br>Regards,<br>Team Talerang</body></html>";

                        $mail->MsgHTML($emailbody);

                        if(!$mail->Send())
                        echo 'Message could not be sent';
                        echo "<div class=\"notif success\">An email with a link to reset your password has been sent to you!</div>";
                        // clear all addresses and attachments for the next mail
                        $mail->ClearAddresses();
                        $mail->ClearAttachments();

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

            } ?>
            <div class="list-group">
                <div class="list-group-item lifevis">
                    <h3 class="list-group-item-heading">Reset passwords</h3>
                    <p class="list-group-item-text">
                        Reset passwords of either of the accounts. Email will be sent to shveta@talerang.com <b>(Link valid for only 15 minutes)</b>
                    </p>
                    <button class="btn btn-danger btn-lg" name="submit-password-confirm" id="submit-password-confirm" >Reset Admin account passwords</button>
                    <br>
                    <form method="post" action="adminlanding.php" id="password-reset" style="display:none;font-size: 22px">
                        <p class="list-group-item-text" style="font-size: 18px;">
                            Which account do you want to reset?
                        </p>
                        <label for="account" class="error" style="color:red; font-weight: lighter;"></label><br>
                        <input type="radio" name="account" value="admin" id="account-admin">
                        <label for="account-admin">Admin</label>
                        <input type="radio" name="account" value="shveta" id="account-shveta">
                        <label for="account-shveta">Shveta</label>
                        <input type="submit" name="submit-reset-password" id="submit-reset-password" class="btn btn-danger btn-md" value="Reset">
                    </form>
                </div>
            </div><!--  end list group -->
            </div> 
            <?php endif;//end privilege ?>
        </div> <!-- end container -->
        <?php } //end if isset admin user 
        else { ?> 
        <div class="container" id="notsignedin">
            <div class="alert alert-warning">
                You are not signed in! Please <a href="adminlogin.php" class="alert-link">log in</a> first.
            </div>
        </div>
        <?php } ?>
        <?php include 'footer.php' ?>
    </div><!--  end wrapper -->

<?php if($_SESSION['privilege']==1): ?>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.1/jquery.validate.min.js"></script>
<script type="text/javascript">
    $('#password-reset').validate({
        errorElement: 'label',
        errorClass: 'error',
        rules: {
            'account':     { required: true},
        },
        messages: {
            'account':     { required: "Please select an account to reset"},
        },
    });

    $(function() {
        $('#submit-password-confirm').on('click', function() {
        $('#password-reset').show('fast');
    });
    });
</script>
<?php endif ?>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
</body>  
</html>  