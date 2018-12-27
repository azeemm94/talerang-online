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

    $mail->Username='support@talerang.com'; // SMTP account username 
    $mail->Password='TalerangSupport2015';  // SMTP account password 
    
    $mail->SetFrom('support@talerang.com', 'Talerang Support Team');
    $mail->AddReplyTo('support@talerang.com', 'Talerang Support Team');

    //$fullname=$_SESSION['firstname']." ".$_SESSION['lastname'];
    $mail->AddAddress($signinemail,$fullname); 
    //$mail->AddAddress('azeem.talerang@gmail.com', 'Azeem Merchant'); 
    //$mail->AddAddress('azeem_merchant999@hotmail.com', 'Azeem Merchant'); 
    
    $mail->Subject = 'Introduction to Talerang';
    $mail->AddEmbeddedImage('img/logoemail.gif', 'logo');
    //$mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
    $emailbody="<!DOCTYPE html><html><head></head><body>Dear ".$fullname.",<br><br>Thank you for registering on <a href=\"http://www.talerang.com/express\" target=\"new\">Talerang Express!</a><br><br><a href=\"http://www.talerang.com\" target=\"new\">Talerang</a> began as a project at Harvard Business School with the aim to bridge the gap between what colleges teach and what organizations look for. After a year of conducting research at several organizations and running pilots at a few leading colleges in India, we found that less than 60% of the students surveyed felt ready for a front-office job. Less than 50% had someone to go to for advice on their life path. Almost 50% of students at top undergraduate universities in India do not secure work internships in their college years, which makes their first job the first time they have ever worked.<br><br>Additionally, our research identified that between the college education students receive and the demands of today’s premium organizations there was a gap of six key skills. We felt that if things continued this way, India would soon see a crisis in the work-readiness space. A real crisis – one that has the potential to disillusion our youth and affect the health of our economy.<br><br>Based on the research, Talerang sought to address the transition from being a student to joining the workforce, and a social enterprise was born in the summer of 2013.<br><br>Since our inception, we have run multiple interventions to bridge the gap. First, we launched our <b>Future CEOs Program</b> (formerly Work Immersion Program) where students are hand-picked and taken through a rigorous combination of training, mentorship, feedback and work immersion. Second, on request from corporates and colleges we conduct <b>specialized programs</b> for them. Third, we write for the <b>media</b> to spread the word to a wider audience and conduct continuous research to update our curriculum based on the industry's needs.<br><br>Regards,<br>Team Talerang<br><img src='cid:logo' width=\"150px\"/></body></html>";

    $mail->MsgHTML($emailbody);
      
    if(!$mail->Send())
        echo '<div class="notif fail">Oops! Something went wrong please try again.</div>';
    else echo '<div class="notif success">Email sent!</div>'; 
} 
catch (phpmailerException $e) { echo $e->errorMessage(); } 
catch (Exception $e) { echo $e->getMessage(); }
?>