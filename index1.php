<?php session_start();
if(isset($_SESSION['useremail'])) { header("location:landing.php"); exit(); }
date_default_timezone_set('Asia/Kolkata'); 

if(!isset($_SESSION['quizid'])) $_SESSION['quizid']=uniqid();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1">
    <meta name="robots" content="index, follow">
    <meta name="description" content="Talerang Express is an omni-platform which provides one common platform for Students and Industry Experts to connect with each other.">
    <title>Talerang Express | Registration and Login</title>
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/lity.min.css">
    <link href="css/loginstyle1.css?version=3.1<?php echo uniqid(); ?>" rel="stylesheet">
    <?php include 'noscript.php' ?>
</head>

<body>
<?php include 'google-analytics.php'; ?>
<div id="wrapper">

    <nav class="navbar navbar-default navbar-fixed-top" id="nav-header">
      <div class="container-fluid">
        <div class="navbar-header">
          <img alt="Talerang" src="img/logoexpress.jpg">
        </div>
        <ul class="nav navbar-nav navbar-right">
            <li class="nav-link welcome">
                <div><span class="link-instruction">Have an account?</span><a id="signin-link"><span class="text">Sign in</span></a></div>
            </li>
        </ul>
      </div><!-- /.container-fluid -->
    </nav>

<div id="content">

<?php if(isset($_POST['Register']))
{   
    $encodedpw=crypt($_POST['password']);
    
    require 'connectsql.php';

    if ($result = $DBcon->query("SELECT email FROM register WHERE email='$_POST[email]';"))
    {
        $row_cnt = $result->num_rows;
        $result->close();
    }
    
    if($row_cnt>0){
       echo '<div class="alert alert-danger">This email ID has already been registered</div>';
    }
    else{
       //not found 
       
        $date=date("Y-m-d h:i:sa"); 

        if($_POST['colname']==="Other") $colname="Other - ".$_POST['college'];
        else $colname=$_POST['colname'];

        if($_POST['country']==="Other") $country="Other - ".$_POST['countryo'];
        else $country=$_POST['country'];

        if($_POST['hear']==="Other") $hear="Other - ".$_POST['hearother'];
        else $hear=$_POST['hear'];

        $firstname=mysqli_real_escape_string($DBcon,ucwords(strtolower(trim($_POST['fname']))));
        $lastname=mysqli_real_escape_string($DBcon,ucwords(strtolower(trim($_POST['lname']))));
        $colname=mysqli_real_escape_string($DBcon,$colname);
        $country=ucwords(mysqli_real_escape_string($DBcon,strtolower(trim($country))));
        $state=mysqli_real_escape_string($DBcon,$_POST['statesindia']);
        $city=ucwords(mysqli_real_escape_string($DBcon,strtolower(trim($_POST['city']))));
        $hear=mysqli_real_escape_string($DBcon,$hear);
        $phoneno=mysqli_real_escape_string($DBcon,$_POST['phone3']);

        $fullname=$firstname." ".$lastname;

        $hash=sha1(chr(rand(65,90)).chr(rand(65,90)).chr(rand(65,90)).chr(rand(65,90)).chr(rand(65,90)).chr(rand(65,90)));
        $emailregister=strtolower(trim($_POST['email']));
        $link="http://www.talerang.com/express/verify.php?email=".$emailregister."&hash=".$hash;
        
        function getrandom()
        {
            $chars = "123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"; $res = "";
            for ($j=0;$j<10; $j++) $res .= $chars[mt_rand(0, strlen($chars)-1)];
            return $res;
        }
        function generate_id()
        {
            require 'connectsql.php';
            $notgenerated=true; $random="";

            while($notgenerated)
            {
                $random=getrandom(); 
                //Checks if ID isn't already in database
                if(! mysqli_num_rows(mysqli_query($DBcon,"SELECT `id` FROM `register` WHERE `accountno`='$random'")))
                {
                    if(! is_numeric($random))
                    $notgenerated=false;
                }
                
            }
            return $random;
        }
        $accountno=generate_id();
        
    $sql="INSERT INTO `register`(`firstname`,`lastname`,`email`,`password`,`country`,`state`,`city`,`phoneno`,`college`,`aboutus`,`regtime`,`hash`,`active`,`accountno`) VALUES('$firstname','$lastname','$emailregister','$encodedpw','$country','$state','$city','$phoneno','$colname','$hear','$date','$hash','0','$accountno');";
            
    if (mysqli_query($DBcon, $sql))
    {

       if(!in_array($_SERVER['REMOTE_ADDR'],array('127.0.0.1','::1')))   
            include 'emailverify.php';
    }
    else echo '<div class="alert alert-danger">Oops! Something went wrong please try again.</div>';
    }
    $DBcon->close();
}
//if sign in form is submitted
$signinemail="";
if(isset($_POST['SignIn']))
{   
    //redirect from not signed in using get variable
    if(isset($_GET['pg']))
    $page=$_GET['pg'];
    else $page="landing";

    if(!in_array($page,array("genz","jhe","mock","mockform","teststart","industry","skilltraining","dashboard","resumecreate","placementregister"))) //only these pages allowed for redirect
        $page="landing"; //if anything else it goes to landing.php

    $loginpw=$_POST['password'];
    $signinemail=strtolower($_POST['email']);
    
    require 'connectsql.php';
    $date=date("Y-m-d h:i:sa");
    
    if ($result = $DBcon->query("SELECT * FROM `register` WHERE `email`='$signinemail';")) 
    {
        $exists=mysqli_num_rows($result);
        $row=mysqli_fetch_assoc($result);
        $dbpass=$row['password'];

        //Check if verified
        if($row['active']==0) 
             $active=false; 
        else $active=true;

        //Check if pass compares
        if(sha1($loginpw)==$dbpass||($dbpass==crypt($loginpw,$dbpass)))
             $passcmp=true;
        else $passcmp=false;
    }
    //if correct password and activated account ---successful login
    if($passcmp==true && $active==true)
    {
        $signinemail=mysqli_real_escape_string($DBcon,$signinemail);
        $sql="INSERT INTO `signin`(`email`,`signtime`,`login`)
          VALUES('$signinemail','$date',true);";
        mysqli_query($DBcon, $sql);
        /*echo 'Successfully logged in!';*/

        $sql="SELECT `firstname`,`lastname`,`intro`,`college`,`accountno` FROM `register` WHERE `email`='$signinemail';";
        $result = mysqli_query($DBcon,$sql);
        $row = mysqli_fetch_row($result);
        session_regenerate_id();
        $_SESSION["useremail"]=$signinemail;
        $_SESSION["firstname"]=$row[0];
        $_SESSION["lastname"]=$row[1];
        $_SESSION["accountno"]=$row[4];
        $uniqquiz=$_SESSION['quizid'];

        $fullname=$row[0]." ".$row[1];

        //checking for SNDT Program
        if($row[3]=='SNDT University')
        $_SESSION["sndtprogram"]=true;
        else 
        $_SESSION["sndtprogram"]=false;

        if($row[2]==0)
        {
            $fullname=$_SESSION["firstname"]." ".$_SESSION["lastname"];
            include 'emailintro.php';
            $sql="UPDATE `register` SET `intro`='1' WHERE `email`='$signinemail';";
            mysqli_query($DBcon,$sql);
        }

        $sql="UPDATE `genz` SET `email`='$signinemail',`fullname`='$fullname' WHERE `quizid`='$uniqquiz';";
        mysqli_query($DBcon,$sql);
        $sql="UPDATE `jhe` SET `email`='$signinemail',`fullname`='$fullname' WHERE `quizid`='$uniqquiz';";
        mysqli_query($DBcon,$sql);

        header("location:".$page.".php");
    }
    else{
        $signinemail=mysqli_real_escape_string($DBcon,$signinemail);
        $sql="INSERT INTO `signin`(`email`,`signtime`,`login`)
          VALUES('$signinemail','$date',false);";
        mysqli_query($DBcon, $sql);

        /*Login error*/
        if ($exists==0)
        echo '<div class="alert alert-danger">You must register first</div>';
        if($passcmp==false&&!$exists==0)
        echo '<div class="alert alert-danger">Sorry that is the wrong password! <a class="alert-link" href="forgotpass.php">Forgot your password?</a></div>';
        elseif($active==false&&!$exists==0)
        echo '<div class="alert alert-warning">Please activate your account from the verification email sent to your email account.</div>';
        $DBcon->close();
        }
}//endif post signin form
?>

<div class="container-fluid">
    <div class="row page-section" id="welcome">
        <div class=" col-xs-12 col-sm-6 col-md-8" id="intro-div">
            <div style="line-height: 34px; max-width: 550px; display: inline-block;">Talerang Express empowers college students to discover and determine their career path</div>
            <div><a id="register-link">Register Now!</a></div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-4 image">
            <div class="img-wrap">
                <img src="img/priyanka-image.jpg" alt="Talerang Express Video" href="https://www.youtube.com/watch?v=lo9seG8dE2k&rel=0" data-lity style="cursor:pointer; max-height: 430px;">
            </div>
        </div>
    </div>
</div>
<div class="container-fluid" id="intro-banner">
        <h2>Introducing Placement Express</h2>
</div>
<div class="container-fluid">
    <div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="placement">
                <div class="header arrowed">
                    <div class="arrowback"></div>
                    <span class="title">Know Yourself</span>
                    <div class="arrow"></div>
                </div>
                <div class="desc">
                    <ul>
                        <li>WRAP</li>
                        <li>Skill Track Selector</li>
                        <li>Choose your Path</li>
                    </ul>
                </div>
            </div>
                
        </div>
        <div class="col-md-4">
            <div class="placement">
                 <div class="header arrowed">
                    <div class="arrowback"></div>
                    <span class="title">Prepare Yourself</span>
                    <div class="arrow"></div>
                </div>
                <div class="desc">
                    <ul>
                        <li>Live Training</li>
                        <li>Resume Creator</li>
                        <li>Mock interview</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="placement">
                <div class="header arrowed">
                    <div class="arrowback"></div>
                    <span class="title">Prove Yourself</span>
                    <div class="arrow"></div>
                </div>
                <div class="desc">
                    <ul>
                        <li>Project Submission</li>
                        <li>Reference Checks</li>
                        <li>Industry Connect</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    </div>

    <a id="form"></a>
    <div class="row" id="formRow"> <!-- Register and Sign In buttons -->
        <div class="col-md-12 col-sm-12 col-xs-12 Register" style="text-align: center;">
            <a class="btn btn-lg Register" id="myRegisterButton" href="#" role="button">
                Register
            </a>
        </div>
    </div>
    <div class="row" id="inputRow"> <!-- Register and Sign In forms -->
        <form method="post" action="#" class="registerForm col-md-12 col-sm-12 col-xs-12">
        <div class="row">
        <div class="col-md-offset-4 col-md-4 col-sm-offset-2 col-sm-8 col-xs-12">
            <input name="fname" id="fname" type="text" class="name form-control" placeholder="First Name" />
            <input name="lname" id="lname" type="text" class="name form-control" placeholder="Last Name" />
            <input name="email" class="form-control" id="email" type="email" placeholder="Email Address"/>
            <label class="error" id="email_status"></label>
            <input name="password" class="form-control" id="password" type="password" placeholder="New password" />
            <input name="passwordc" class="form-control" id="passwordc" type="password" placeholder="Confirm password" />

            <select name="country" id="country" class="form-control">
                <option selected disabled value="">Country</option>
                <option>India</option>
                <option>United States</option>
                <option>Other</option>
            </select>
            <input type="text" class="form-control" name="countryo" id="countryo" placeholder="Enter country name" />
            <select class="form-control displaynone" style="display: none;" id="statesindia" name="statesindia">
                <option value="" selected="selected" disabled="disabled">State</option>
                <option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
                <option value="Andhra Pradesh">Andhra Pradesh</option>
                <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                <option value="Assam">Assam</option>
                <option value="Bihar">Bihar</option>
                <option value="Chandigarh">Chandigarh</option>
                <option value="Chhattisgarh">Chhattisgarh</option>
                <option value="Dadra and Nagar Haveli">Dadra and Nagar Haveli</option>
                <option value="Daman and Diu">Daman and Diu</option>
                <option value="Delhi NCR">Delhi NCR</option>
                <option value="Goa">Goa</option>
                <option value="Gujarat">Gujarat</option>
                <option value="Haryana">Haryana</option>
                <option value="Himachal Pradesh">Himachal Pradesh</option>
                <option value="Jammu and Kashmir">Jammu and Kashmir</option>
                <option value="Jharkhand">Jharkhand</option>
                <option value="Karnataka">Karnataka</option>
                <option value="Kerala">Kerala</option>
                <option value="Lakshadweep">Lakshadweep</option>
                <option value="Madhya Pradesh">Madhya Pradesh</option>
                <option value="Maharashtra">Maharashtra</option>
                <option value="Manipur">Manipur</option>
                <option value="Meghalaya">Meghalaya</option>
                <option value="Mizoram">Mizoram</option>
                <option value="Nagaland">Nagaland</option>
                <option value="Odisha">Odisha</option>
                <option value="Puducherry">Puducherry</option>
                <option value="Punjab">Punjab</option>
                <option value="Rajasthan">Rajasthan</option>
                <option value="Sikkim">Sikkim</option>
                <option value="Tamil Nadu">Tamil Nadu</option>
                <option value="Telangana">Telangana</option>
                <option value="Tripura">Tripura</option>
                <option value="Uttar Pradesh">Uttar Pradesh</option>
                <option value="Uttarakhand">Uttarakhand</option>
                <option value="West Bengal">West Bengal</option>
            </select>
            <input name="city" class="form-control" id="city" type="text" placeholder="City" />
            <input name="phone3" class="form-control" id="phone3" type="text" value="" placeholder="Phone Number" />
            <select name="colname" id="colname" class="form-control">
                <option selected disabled value="">College</option>
                <option value="Amrita School of Engineering">Amrita School of Engineering</option>
                <option value="BMS College of Engineering">BMS College of Engineering</option>
                <option value="Brown University">Brown University</option>
                <option value="Christ University">Christ University</option>
                <option value="College of Engineering Pune">College of Engineering Pune</option>
                <option value="Columbia University">Columbia University</option>
                <option value="Cornell University">Cornell University</option>
                <option value="Dartmouth College">Dartmouth College</option>
                <option value="Fergusson College">Fergusson College</option>
                <option value="H R College of Commerce">H R College of Commerce</option>
                <option value="Hansraj College">Hansraj College</option>
                <option value="Harvard University">Harvard University</option>
                <option value="Hindu College">Hindu College</option>
                <option value="IIT Bombay">IIT Bombay</option>
                <option value="IIT Delhi">IIT Delhi</option>
                <option value="IIT Roorkee">IIT Roorkee</option>
                <option value="Indian Institute of Journalism and New Media">Indian Institute of Journalism and New Media</option>
                <option value="Jai Hind College">Jai Hind College</option>
                <option value="Jesus and Mary College">Jesus and Mary College</option>
                <option value="Jyothi Nivas College">Jyothi Nivas College</option>
                <option value="Kirori Mal College">Kirori Mal College</option>
                <option value="Lady Shri Ram College">Lady Shri Ram College</option>
                <option value="MS Ramaiah Institute of Technology">MS Ramaiah Institute of Technology</option>
                <option value="Miranda House">Miranda House</option>
                <option value="Mount Carmel College">Mount Carmel College</option>
                <option value="NMIMS College">NMIMS College</option>
                <option value="National Law School of India University">National Law School of India University</option>
                <option value="Netaji Subhas Institute of Technology">Netaji Subhas Institute of Technology</option>
                <option value="PES Institute of Technology">PES Institute of Technology</option>
                <option value="Princeton University">Princeton University</option>
                <option value="RV College of Engineering">RV College of Engineering</option>
                <option value="SNDT University">SNDT University</option>
                <option value="Shaheed Sukhdev College of Business Studies">Shaheed Sukhdev College of Business Studies</option>
                <option value="Shri Ram College of Commerce">Shri Ram College of Commerce</option>
                <option value="St. Joseph's College of Arts and Science">St. Joseph's College of Arts and Science</option>
                <option value="St. Joseph's College of Commerce">St. Joseph's College of Commerce</option>
                <option value="St. Stephen's College">St. Stephen's College</option>
                <option value="St. Xavier's College (Mumbai)">St. Xavier's College (Mumbai)</option>
                <option value="Stanford University">Stanford University</option>
                <option value="Symbiosis University">Symbiosis University</option>
                <option value="University of Pennsylvania">University of Pennsylvania</option>
                <option value="Yale University">Yale University</option>
                <option value="Other">Other</option>
            </select>

            <input type="text" name="college" class="form-control" id="college" placeholder="Enter college name" />

            <select name="hear" id="hear" class="form-control">
                <option selected disabled value="">How did you hear about us?</option>
                <option value="Advertisement">Advertisement</option>
                <option value="Campus ambassador">Campus ambassador</option>
                <option value="College Presentation">College Presentation</option>
                <option value="College dean/placement cell">College dean/placement cell</option>
                <option value="Email/newsletter">Email/newsletter</option>
                <option value="Facebook">Facebook</option>
                <option value="Family or friends">Family or friends</option>
                <option value="Future CEOs Program">Future CEOs Program</option>
                <option value="Google">Google</option>
                <option value="Google Plus profile">Google Plus profile</option>
                <option value="LinkedIn">LinkedIn</option>
                <option value="Newspaper story">Newspaper story</option>
                <option value="TV/Cable News">TV/Cable News</option>
                <option value="Twitter">Twitter</option>
                <option value="Website/Search engine">Website/Search engine</option>
                <option value="YouTube">YouTube</option>
                <option value="Other">Other</option>
            </select>

            <input type="text" name="hearother" class="form-control" id="hearother" placeholder="How did you hear about us?">
            <input name="Register" type="submit" value="Register" id="RegisterSubmit"/>
        </div><!-- End Column -->
        </div><!-- End Row -->
        </form> <!-- End Register Form -->
    </div>
</div><!--  end main container-fluid -->
<div id="signinpopupwrap">
    <div id="signinpopup">
        <a id="closesignin"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
        <form method="post" action="" class="signinForm">
            <input type="email" class="form-control" name="email" placeholder="Email" id="signinemail" value="<?php echo $signinemail;?>"/>
            <input name="password" class="form-control" id="password" type="password" placeholder="Password" />
            <input name="SignIn" type="submit" value="Sign In" id="SignSubmit" />
            <div id="forgotp"><a href="forgotpass.php" id="forgot">Forgot your password?</a></div>
        </form><!--  End Sign in Form -->      
    </div>
</div> <!-- end signinpopupwrap -->
 
</div><!-- end content -->

<?php include 'loginfooter.php' ?> <!-- Footer -->

</div> <!-- end wrapper -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
      <!-- custom js here -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.1/jquery.validate.min.js"></script>
<script type="text/javascript" src="js/loginvalidator1.js?version=1.4"></script>
<?php if(isset($_GET['signin'])) { ?>
<script type="text/javascript">
    $("#signinpopupwrap").show('fast');
    $("#signinemail").focus();
</script>
<?php  } elseif(isset($_GET['register'])) { ?> 
<script>
    $("form.registerForm").slideToggle('fast');

        $("#myRegisterButton").toggleClass('selected');

        $('html, body').animate({
            scrollTop: $("#formRow").offset().top -96
        }, 1000);
</script>
<?php } ?>
</body>
</html>