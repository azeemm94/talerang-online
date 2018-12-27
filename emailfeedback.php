<?php            
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

    //$fullname=$_SESSION['firstname']." ".$_SESSION['lastname'];
    $mail->AddAddress($_SESSION['useremail'],''); 
    //$mail->AddAddress('azeem.talerang@gmail.com', 'Azeem Merchant'); 
    //$mail->AddAddress('azeem_merchant999@hotmail.com', 'Azeem Merchant'); 
    
    $mail->Subject = 'Feedback for Talerang Express';
    $mail->AddEmbeddedImage('img/logoemail.gif', 'logo');
    
    $id=sha1(uniqid(rand(), true));

    //$mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
    $emailbody="<!DOCTYPE html>
                <html>
                <head></head>
                <body>
                    <img src='cid:logo' width=\"150px\"/><br>
                    Dear ".$fullname.",<br><br>
                    Thank you for using Talerang Express. Was the service friendly and helpful? Please take a moment to tell us how we did.<br><br>
                    How satisfied were you with our online platform?<br><br>
                    <div style=\"font-family: Arial; font-size: 14px;\">
                        <span style=\"display: inline-block; text-align:center; min-width: 10%; max-width: 120px; margin-right: 5px; background-color: #2abf29; padding: 5px;\">
                            <a href=\"http://www.talerang.com/express/feedback.php?id=".$id."&rate=5\" target=\"_blank\" style=\"color: black; text-decoration: none\">Very satisfied</a>
                        </span>
                        <span style=\"display: inline-block; text-align:center; min-width: 10%; max-width: 120px; margin-right: 5px; background-color: #d1e231; padding: 5px;\">
                            <a href=\"http://www.talerang.com/express/feedback.php?id=".$id."&rate=4\" target=\"_blank\" style=\"color: black; text-decoration: none\">Satisfied</a>
                        </span>
                        <span style=\"display: inline-block; text-align:center; min-width: 10%; max-width: 120px; margin-right: 5px; background-color: #fcf800; padding: 5px;\">
                            <a href=\"http://www.talerang.com/express/feedback.php?id=".$id."&rate=3\" target=\"_blank\" style=\"color: black; text-decoration: none\">Neutral</a>
                        </span>
                        <span style=\"display: inline-block; text-align:center; min-width: 10%; max-width: 120px; margin-right: 5px; background-color: #eb792a; padding: 5px;\">
                            <a href=\"http://www.talerang.com/express/feedback.php?id=".$id."&rate=2\" target=\"_blank\" style=\"color: black; text-decoration: none\">Unsatisfied</a>
                        </span>
                        <span style=\"display: inline-block; text-align:center; min-width: 10%; max-width: 120px; margin-right: 5px; background-color: #f71e0a; padding: 5px;\">
                            <a href=\"http://www.talerang.com/express/feedback.php?id=".$id."&rate=1\" target=\"_blank\" style=\"color: black; text-decoration: none\">Very unsatisfied</a>
                        </span>
                    </div><br>
                    This feedback will be kept anonymous.<br><br>
                    Regards,<br>
                    Team Talerang
                </body>
                </html>";

    $mail->MsgHTML($emailbody);
      
    if(!$mail->Send())
    echo 'Message could not be sent';
    else echo 'Message Sent';
    
} catch (phpmailerException $e) {
    echo $e->errorMessage(); 
} catch (Exception $e) {
    echo $e->getMessage(); 
}
?>