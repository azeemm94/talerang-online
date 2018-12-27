<?php session_start();
if(isset($_SESSION['useremail'])) { header("location:landing.php"); exit(); }
date_default_timezone_set('Asia/Kolkata'); 

if(!isset($_SESSION['quizid'])) $_SESSION['quizid']=uniqid();

$collegesnames=array("Amrita School of Engineering","BMS College of Engineering","Brown University","College of Engineering Pune","Columbia University","Cornell University","Christ University","Dartmouth College","Fergusson College","H R College of Commerce","Hansraj College","Harvard University","Hindu College","IIT Bombay","IIT Delhi","IIT Roorkee","Indian Institute of Journalism and New Media","Jai Hind College","Jesus and Mary College","Jyothi Nivas College","Kirori Mal College","Lady Shri Ram College","Miranda House","Mount Carmel College","MS Ramaiah Institute of Technology","National Law School of India University","Netaji Subhas Institute of Technology","NMIMS College","PES Institute of Technology","Princeton University","RV College of Engineering","Shaheed Sukhdev College of Business Studies","Shri Ram College of Commerce","SNDT University","St. Joseph's College of Arts and Science","St. Joseph's College of Commerce","St. Stephen's College","St. Xavier's College (Mumbai)","Stanford University","Symbiosis University","University of Pennsylvania","Yale University"); 
$heararr=array("Advertisement","College dean/placement cell","Campus ambassador","Email/newsletter","Facebook","Family or friends","Google","Google Plus profile","Newspaper story","TV/Cable News","LinkedIn","Twitter","Website/Search engine","YouTube","College Presentation","Future CEOs Program");

sort($collegesnames);
sort($heararr);
                
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
    <link href="css/loginstyle.css?version=2.0" rel="stylesheet">
    <?php include 'noscript.php' ?>
</head>

<body>
<?php include 'google-analytics.php'; ?>
<div id="wrapper">

    <nav class="navbar navbar-default navbar-fixed-top" id="nav-header">
      <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <img alt="Talerang" src="img/logoexpress.jpg">
        </div>
        <ul class="nav navbar-nav navbar-right">
       <!--      <li class="nav-link welcome">
                <div> <span class="link-instruction">New here?</span><a class="register-link"><span class="text">Register</span></a></div>
            </li> -->
            <li class="nav-link welcome">
                <div><span class="link-instruction">Have an account?</span><a id="signin-link"><span class="text">Sign in</span></a></div>
            </li>
        </ul>
      </div><!-- /.container-fluid -->
      <!-- <div class="ribbon container-fluid one"></div> --><!-- Red/Yellow band -->
    </nav>

<!-- <div id="header" class="container"><img src="img/logoexpress.jpg" alt="Talerang"></div> -->

<div id="content">

<?php if(isset($_POST['Register']))
{   
    $encodedpw=crypt($_POST['password']);
    
    require 'connectsql.php';

     $sql= "CREATE TABLE IF NOT EXISTS `register`(
            `id` int(10) NOT NULL AUTO_INCREMENT,
            `firstname` varchar(20) NOT NULL,
            `lastname` varchar(20) NOT NULL,
            `email` varchar(60) NOT NULL,
            `password` varchar(255) NOT NULL,
            `country` varchar(20) NOT NULL,
            `state` varchar(30) NOT NULL,
            `city` varchar(20) NOT NULL,
            `phoneno` varchar(20) NOT NULL,
            `college` varchar(100) NOT NULL,
            `aboutus` varchar(100) NOT NULL,
            `regtime` varchar(30) NOT NULL,
            `hash`    varchar(100) NOT NULL,
            `active`  tinyint(1) NOT NULL,
            `accountno` varchar(10) NOT NULL,
            PRIMARY KEY (`id`)
            ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";

    mysqli_query($DBcon, $sql);

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

        /*$_POST['fname'];*/
        $firstname=ucfirst(trim(strtolower($_POST['fname'])));
        $lastname=ucfirst(trim(strtolower($_POST['lname'])));

        $firstname=mysqli_real_escape_string($DBcon,$firstname);
        $lastname=mysqli_real_escape_string($DBcon,$lastname);
        $colname=mysqli_real_escape_string($DBcon,$colname);
        $country=mysqli_real_escape_string($DBcon,$country);
        $state=mysqli_real_escape_string($DBcon,$_POST['statesindia']);
        $city=mysqli_real_escape_string($DBcon,$_POST['city']);
        $hear=mysqli_real_escape_string($DBcon,$hear);
        $phoneno=mysqli_real_escape_string($DBcon,$_POST['phone3']);

        $fullname=$firstname." ".$lastname;

        $hash=sha1(chr(rand(65,90)).chr(rand(65,90)).chr(rand(65,90)).chr(rand(65,90)).chr(rand(65,90)).chr(rand(65,90)));
        $emailregister=strtolower($_POST['email']);
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
        $page="landing";

    $loginpw=$_POST['password'];
    $signinemail=$_POST['email'];
    
    require 'connectsql.php';

    $date=date("Y-m-d h:i:sa");

    $sql= "CREATE TABLE IF NOT EXISTS `signin`(
        `id` int(10) NOT NULL AUTO_INCREMENT,
        `email` varchar(50) NOT NULL,
        `signtime` varchar(30) NOT NULL,
        `login` boolean NOT NULL,
        PRIMARY KEY (`id`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";
    mysqli_query($DBcon, $sql);
    
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
        {
             $passcmp=true;
             if(!(substr($dbpass,0,1)=='$'))
             {
                $newpass=crypt($loginpw);
                $sql="UPDATE `register` SET `password`='$newpass' WHERE `email`='$signinemail';";
                mysqli_query($DBcon,$sql);
             }
        }
        else 
        {
            $passcmp=false;
        }    
    }
    //if correct password and activated account ---successful login
    if($passcmp==true && $active==true)
    {
        $sql="INSERT INTO `signin`(`email`,`signtime`,`login`)
          VALUES('$_POST[email]','$date',true);";
        mysqli_query($DBcon, $sql);
        /*echo 'Successfully logged in!';*/

        $sql="SELECT `firstname`,`lastname`,`intro`,`college`,`accountno` FROM `register` WHERE `email`='$signinemail';";
        $result = mysqli_query($DBcon,$sql);
        $row = mysqli_fetch_row($result);

        $_SESSION["useremail"]=$signinemail;
        $_SESSION["firstname"]=$row[0];
        $_SESSION["lastname"]=$row[1];
        $_SESSION['accountno']=$row[4];
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
        $sql="INSERT INTO `signin`(`email`,`signtime`,`login`)
          VALUES('$_POST[email]','$date',false);";
        mysqli_query($DBcon, $sql);

        /*Login error*/
        if ($exists==0)
        echo '<div class="alert alert-danger">You must register first</div>';
        if($passcmp==false&&!$exists==0)
        echo '<div class="alert alert-danger">Sorry that is the wrong password!</div>';
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
    
   <!--  <div class="row page-section" id="explainer">
       <div class="col-xs-12 col-sm-12 col-md-offset-2 col-md-8 text">Talerang Express is an online platform which provides a common space for students and industry experts to connect with each other.</div>
   </div> -->

    <div class="row page-section" id="WRAP">
        <div class="col-xs-12 col-sm-6 col-md-4 image">
            <div class="img-wrap">
            <p class="pictitle">Assess yourself</p>
            <img src="img/wrap.jpg" alt="Work Readiness Aptitude Predictor" title="Start with our Work-Readiness Aptitude Predictor (WRAP)"/>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-4 image">
            <div class="img-wrap">
            <p class="pictitle">Mock Interviews</p>
            <img src="img/mockinterviews.jpg" alt="Talerang Mock Interviews" title="Practice until perfect with our best-practice Mock Interviews" />
            </div>
        </div>
               <div class="col-xs-12 col-sm-6 col-md-4 image">
            <div class="img-wrap">
                <p class="quiztitle">
                    How well do you know Generation Z?
                    <br>
                    <a href="genz.php">Take the quiz now</a>
                </p>
                <img src="img/genz.jpg" alt="Generation Z">
            </div>
        </div><!-- Gen Z Quiz -->
        <div class="col-xs-12 col-sm-6 col-md-4 image">
            <div class="img-wrap">
                <p class="quiztitle">
                    What is the right path for you post college?
                    <br>
                    <a href="jhe.php">Take the quiz now</a>
                </p>
                <img src="img/after-graduation.jpg" alt="Jobs vs Higher Studies vs Entrepreneurship">
            </div>
        </div><!-- J H E Quiz -->
                <div class="col-xs-12 col-sm-6 col-md-4 image">
            <div class="img-wrap">
            <p class="pictitle">Get Work-Ready</p>
            <img src="img/mentorship.jpg" alt="Mentorship Session" title="Get professional feedback during a Mentorship Session" />
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-4 image">
            <div class="img-wrap">
            <p class="pictitle">Access internships and jobs</p>
            <img src="img/IMG_1731.jpg" alt="Industry Connect" title="Get connected for internships and jobs with Talerang's corporate partners with Industry Connect" />
            </div>
        </div>
    </div> <!-- End WRAP and Mock interviews row -->

    <div class="row page-section" id="quiz">

    </div> <!-- End Quizzes row -->

    <div class="row page-section" id="mock">

    </div> <!-- End Mentorship and Industry Connect row -->

    <a id="form"></a>
    <div class="row" id="formRow"> <!-- Register and Sign In buttons -->
        <div class="col-md-6 col-sm-6 col-xs-6 Register">
                <a class="btn btn-lg Register" id="myRegisterButton" href="#" role="button">Register</a>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-6 signIn">
                <a class="btn btn-lg signIn" id="mySignInButton" href="#" role="button">Sign In</a>
        </div>
    </div>
    <div class="row" id="inputRow"> <!-- Register and Sign In forms -->
        <form method="post" action="#" class="registerForm col-md-6 col-sm-12 col-xs-12">
        <div class="row">
        <div class="col-md-offset-3 col-md-9 col-sm-12 col-xs-12">
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
                <?php
                    $states=array("Andaman and Nicobar Islands","Andhra Pradesh","Arunachal Pradesh","Assam","Bihar","Chandigarh","Chhattisgarh","Dadra and Nagar Haveli","Daman and Diu","Delhi NCR","Goa","Gujarat","Haryana","Himachal Pradesh","Jammu and Kashmir","Jharkhand","Karnataka","Kerala","Lakshadweep","Madhya Pradesh","Maharashtra","Manipur","Meghalaya","Mizoram","Nagaland","Odisha","Puducherry","Punjab","Rajasthan","Sikkim","Tamil Nadu","Telangana","Tripura","Uttar Pradesh","Uttarakhand","West Bengal");
                    sort($states);
                    for ($i=0; $i < count($states); $i++) { 
                       echo '<option value="'.$states[$i].'">'.$states[$i].'</option>';
                    }
                ?>
            </select>
            <input name="city" class="form-control" id="city" type="text" placeholder="City" />
            <input name="phone3" class="form-control" id="phone3" type="text" value="" placeholder="Phone Number" />
            <?php if(!isset($_GET['sndt'])): ?>
            <select name="colname" id="colname" class="form-control">
                <option selected disabled value="">College</option>
                <?php for ($i=0; $i < count($collegesnames); $i++)
                        echo "<option value=\"".$collegesnames[$i]."\">".$collegesnames[$i]."</option>";
                    ?>
                <option value="Other">Other</option>
            </select>
            <?php else:
                    echo '<div class="sndtinput">SNDT University</div>'; 
                  endif ?>

            <input type="text" name="college" class="form-control" id="college" placeholder="Enter college name" />

            <select name="hear" id="hear" class="form-control">
                <option selected disabled value="">How did you hear about us?</option>
                <?php for ($i=0; $i<count($heararr); $i++)
                        echo "<option value=\"".$heararr[$i]."\">".$heararr[$i]."</option>";
                ?>
                <option value="Other">Other</option>
            </select>

            <input type="text" name="hearother" class="form-control" id="hearother" placeholder="How did you hear about us?">
            <input name="Register" type="submit" value="Register" id="RegisterSubmit"/>
        </div><!-- End Column -->
        </div><!-- End Row -->
        </form> <!-- End Register Form -->

        <form method="post" action="#" class="signinForm col-md-offset-6 col-md-6 col-sm-12 col-xs-12">
            <div class="row">
            <div class="col-md-9 col-sm-12 col-xs-12">
                <input type="email" class="form-control" name="email" placeholder="Email" id="signinemail" value="<?php echo $signinemail;?>"/>
                <input name="password" class="form-control" id="password" type="password" placeholder="Password" />
                <input name="SignIn" type="submit" value="Sign In" id="SignSubmit" />
                <div id="forgotp"><a href="forgotpass.php" id="forgot">Forgot your password?</a></div>
            </div> <!-- End Column -->
            </div><!-- End Row -->
        </form><!--  End Sign in Form -->
    </div>
</div><!--  end main container-fluid -->
    
</div><!-- end content -->

<?php include 'loginfooter.php' ?> <!-- Footer -->

</div> <!-- end wrapper -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
      <!-- custom js here -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.1/jquery.validate.min.js"></script>
<script type="text/javascript" src="js/loginvalidator.js?version=1.2"></script>
</body>
</html>