<?php            
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

    //$fullname=$_SESSION['firstname']." ".$_SESSION['lastname'];
    $mail->AddAddress($_POST['email'],$firstname.' '.$lastname); 
    //$mail->AddAddress('azeem.talerang@gmail.com', 'Azeem Merchant'); 
    //$mail->AddAddress('azeem_merchant999@hotmail.com', 'Azeem Merchant'); 
    
    $mail->Subject = 'Confirm your email address';
    $mail->AddEmbeddedImage('img/logoemail.gif', 'logo');
    //$mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
    $emailbody="<!DOCTYPE html><html><head></head><body>Dear {$fullname},<br><br>Please <a href=\"{$link}\" target=\"new\">click here</a> to complete your registration and verify your account!<br><br>Regards,<br>Team Talerang<br><img src=\"cid:logo\" width=\"150px\"/></body></html>";

    $mail->MsgHTML($emailbody);
      
    if(!$mail->Send())
    {
        echo '<div class="alert alert-danger">Oops! Something went wrong please try again.</div>';
        $sql="DELETE FROM `register` WHERE `email`='$emailregister';";
        mysqli_query($DBcon,$sql);
        $DBcon->close();
        $edusynch=true;
        require 'connectsql.php';
        mysqli_query($EDcon,$sql);
        $EDcon->close();
        require 'connectsql.php';
    }
    else
    {
        echo '<div class="alert alert-success">Success! Please click on the verification link sent to <b>'.$_POST['email'].'</b> to complete your registration.<br>If you cannot find the email, please check your spam and junk folders. If this email address is incorrect, you will need to register again.</div>';
    }  
    // clear all addresses and attachments for the next mail
    $mail->ClearAddresses();
    $mail->ClearAttachments();
    
} catch (phpmailerException $e) {
    echo $e->errorMessage(); 
} catch (Exception $e) {
    echo $e->getMessage(); 
}
?>