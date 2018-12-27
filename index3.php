<?php session_start();
if(isset($_SESSION['useremail'])) header("location:landing.php");
date_default_timezone_set('Asia/Kolkata'); 
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
    <link href="css/loginstyle2.css" rel="stylesheet">
    <?php include 'noscript.php' ?>
</head>

<body>
    <div id="wrapper">
    <div id="header" class="container"><img src="img/logoexpress.jpg" alt="Talerang"></div>

    <div id="content">
    <div class="ribbon container-fluid one"></div>

    <div id="carousel-talerang" class="carousel slide" data-ride="carousel">
      <!-- Indicators -->
      <ol class="carousel-indicators">
        <li data-target="#carousel-talerang" data-slide-to="0" class="active"></li>
        <li data-target="#carousel-talerang" data-slide-to="1"></li>
        <li data-target="#carousel-talerang" data-slide-to="2"></li>
        <li data-target="#carousel-talerang" data-slide-to="3"></li>
      </ol>

      <!-- Wrapper for slides -->
      <div class="carousel-inner" role="listbox">
        <div class="item active" id="no1">
          <div class="container jumbo">
            <h1 class="text">
                Welcome to Talerang Express!
                <img src="img/loginboomerang.png" alt="Talerang">
            </h1>
            <div id="explainer">
                <a href="https://www.youtube.com/watch?v=lo9seG8dE2k&rel=0" data-lity>
                    Watch a short explainer video
                </a> 
            </div>
          </div>
        </div>
        <div class="item" id="no2">
          <div class="carousel-caption">
            Start with our Work-Readiness Aptitude Predictor (WRAP)
          </div>
        </div>
        <div class="item" id="no3">
          <div class="carousel-caption">
            Practice until perfect with our best-practice Mock Interviews
          </div>
        </div>
        <div class="item" id="no4">
          <div class="carousel-caption">
            Get professional feedback during a Mentorship Session
          </div>
        </div>
      </div>

      <!-- Controls -->
      <a class="left carousel-control" href="#carousel-talerang" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="right carousel-control" href="#carousel-talerang" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
    </div>
        
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
                        `phoneno` varchar(20) NOT NULL,
                        `college` varchar(100) NOT NULL,
                        `aboutus` varchar(100) NOT NULL,
                        `regtime` varchar(30) NOT NULL,
                        `hash`    varchar(100) NOT NULL,
                        `active`  tinyint(1) NOT NULL,
                        PRIMARY KEY (`id`)
                        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";

                mysqli_query($DBcon, $sql);

                if ($result = $DBcon->query("SELECT email FROM register WHERE email='$_POST[email]';"))
                {
                    $row_cnt = $result->num_rows;
                    $result->close();
                }
                
                if($row_cnt>0){
                   echo '<div class="notif">This email ID has already been registered</div>';
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

                    $fullname=$firstname." ".$lastname;

                    $hash=sha1(chr(rand(65,90)).chr(rand(65,90)).chr(rand(65,90)).chr(rand(65,90)).chr(rand(65,90)).chr(rand(65,90)));
                    $emailregister=strtolower($_POST['email']);
                    $link="http://www.talerang.com/express/verify.php?email=".$emailregister."&hash=".$hash;

                    $sql="INSERT INTO register(firstname,lastname,email,password,country,phoneno,college,aboutus,regtime,hash,active) VALUES('$firstname','$lastname','$emailregister','$encodedpw','$country','$_POST[phone3]','$colname','$hear','$date','$hash','0');";
                        
                if (mysqli_query($DBcon, $sql))
                {
                   if(!in_array($_SERVER['REMOTE_ADDR'],array('127.0.0.1','::1')))  
                   {
                        include 'emailverify.php';

                        include 'connectsql.php?edusynch';
                        $sql="INSERT INTO `register` (`firstname`,`lastname`,`email`,`password`,`country`,`college`,`aboutus`,`regtime`,`active`,`intro`) VALUES('$firstname','$lastname','$emailregister','$encodedpw','$country','$colname','$hear','$date','0','0');";
                        mysqli_query($EDcon,$sql);
                   } 
                }
                else 
                    echo '<div class="notif fail">Oops! Something went wrong please try again.</div>';
                //echo "Error: " . $sql . "<br>" . mysqli_error($DBcon);
                }
                $DBcon->close();
            }
            //if sign in form is submitted
            $signinemail="";
            if(isset($_POST['SignIn']))
            {   
                if(isset($_GET['pg']))
                $page=$_GET['pg'];
                else $page="landing";

                if(!in_array($page,array("genz","jhe","mock","teststart","industry","livelearning")))
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
                if($passcmp==true && $active==true){
                    $sql="INSERT INTO `signin`(`email`,`signtime`,`login`)
                      VALUES('$_POST[email]','$date',true);";

                    mysqli_query($DBcon, $sql);
                    /*echo 'Successfully logged in!';*/

                    $sql="SELECT `firstname`,`lastname`,`intro`,`college` FROM `register` WHERE `email`='$signinemail';";
                    $result = mysqli_query($DBcon,$sql);
                    $row = mysqli_fetch_row($result);

                    $_SESSION["useremail"]=$signinemail;
                    $_SESSION["firstname"]=$row[0];
                    $_SESSION["lastname"]=$row[1];

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

                    header("location:".$page.".php");
                }
                else{
                    $sql="INSERT INTO `signin`(`email`,`signtime`,`login`)
                      VALUES('$_POST[email]','$date',false);";
                    mysqli_query($DBcon, $sql);

                    /*Login error*/
                    if ($exists==0)
                    echo '<div class="notif">You must register first</div>';
                    if($passcmp==false&&!$exists==0)
                    echo '<div class="notif">Sorry that is the wrong password!</div>';
                    elseif($active==false&&!$exists==0)
                    echo '<div class="notif">Please activate your account from the verification email sent to your email account.</div>';
                    $DBcon->close();
                    }
            }//endif post signin form
      ?>

    <div class="container" id="formContainer">
        <div class="row">
            <div class="col-md-6 Register">
                <ul>
                    <li class="RegisterButton" style="display:inline"><a class="btn btn-lg" id="myRegisterButton" href="#" role="button">Register</a></li>
                </ul>
                <form method="post" action="#" class="registerForm">
                    <input name="fname" id="fname" type="text" class="name form-control" placeholder="First Name" />
                    <input name="lname" id="lname" type="text" class="name form-control" placeholder="Last Name" />
                    <input name="email" class="form-control" id="email" type="email" placeholder="Email Address" onkeyup="checkemail()" />
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
                    <input name="phone3" class="form-control" id="phone3" type="text" value="" placeholder="Phone Number" />
                    <?php if(!isset($_GET['sndt'])): ?>
                    <select name="colname" id="colname" class="form-control">
                        <option selected disabled value="">College</option>
                        <?php $collegesnames=array("Amrita School of Engineering","BMS College of Engineering","Brown University","College of Engineering Pune","Columbia University","Cornell University","Christ University","Dartmouth College","Fergusson College","H R College of Commerce","Hansraj College","Harvard University","Hindu College","IIT Bombay","IIT Delhi","IIT Roorkee","Indian Institute of Journalism and New Media","Jai Hind College","Jesus and Mary College","Jyothi Nivas College","Kirori Mal College","Lady Shri Ram College","Miranda House","Mount Carmel College","MS Ramaiah Institute of Technology","National Law School of India University","Netaji Subhas Institute of Technology","NMIMS College","PES Institute of Technology","Princeton University","RV College of Engineering","Shaheed Sukhdev College of Business Studies","Shri Ram College of Commerce","SNDT University","St. Joseph's College of Arts and Science","St. Joseph's College of Commerce","St. Stephen's College","St. Xavier's College (Mumbai)","Stanford University","Symbiosis University","University of Pennsylvania","Yale University"); 
                            sort($collegesnames);
                            for ($i=0; $i < count($collegesnames); $i++)
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
                        <?php
                        $heararr=array("Advertisement","College dean/placement cell","Campus ambassador","Email/newsletter","Facebook","Family or friends","Google Plus profile","Newspaper story","TV/Cable News","LinkedIn","Twitter","Website/Search engine","YouTube","College Presentation","Future CEOs Program");
                        sort($heararr);
                        for ($i=0; $i<count($heararr); $i++)
                            echo "<option value=\"".$heararr[$i]."\">".$heararr[$i]."</option>";
                        ?>
                        <option value="Other">Other</option>
                    </select>

                    <input type="text" name="hearother" class="form-control" id="hearother" placeholder="How did you hear about us?">
                    <input name="Register" type="submit" value="Register" id="RegisterSubmit"/>
                </form>
            </div>
            <!--  end col-md-6 -->

            <div class="col-md-6 signIn">
                <ul>
                    <li class="SignInButton" style="display:inline"><a class="btn btn-lg" id="mySignInButton" href="#" role="button">Sign In</a></li>
                </ul>

                <form method="post" action="#" class="signinForm">
                    <input type="email" class="form-control" name="email" placeholder="Email" value="<?php echo $signinemail;?>"/>
                    <input name="password" class="form-control" id="password" type="password" placeholder="Password" />
                    <input name="SignIn" type="submit" value="Sign In" id="SignSubmit" />
                    <div id="forgotp"><a href="forgotpass.php" id="forgot">Forgot your password?</a></div>
                </form>
            </div>
            <!-- end col-md-6    -->
        </div>
    </div>
    
    </div><!-- end content -->
    <?php include 'loginfooter.php' ?>

    </div> <!-- end wrapper -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
          <!-- custom js here -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.1/jquery.validate.min.js"></script>
    <script type="text/javascript" src="js/loginvalidator.js"></script>
</body>
</html>