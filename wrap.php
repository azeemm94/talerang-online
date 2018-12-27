<?php session_start(); 
date_default_timezone_set('Asia/Kolkata'); 
if(isset($_SESSION['accountno'])) $accountno=$_SESSION['accountno'];
else $accountno="";
if(isset($_SESSION['useremail'])) $email=$_SESSION['useremail'];
else $email="";

if(!$email==""){
    require 'connectsql.php';
    $coupon  =mysqli_num_rows(mysqli_query($DBcon,"SELECT * FROM `couponcodes` WHERE `email`='$email'"));
    $feespaid=mysqli_num_rows(mysqli_query($DBcon,"SELECT * FROM `feespaid` WHERE `email`='$email' AND `status`='SUCCESS' AND `type`='WRAP';"));
    $placement=mysqli_num_rows(mysqli_query($DBcon,"SELECT * FROM `feespaid` WHERE `accountno`='$accountno' AND `status`='SUCCESS' AND `type`='Placement Express';"));
    $started =mysqli_num_rows(mysqli_query($DBcon,"SELECT * FROM `teststart` WHERE `email`='$email'"));

        if($started)
        {
            if(!$_SESSION['sndtprogram']) 
                 header('location:teststart.php');
            else header('location:sndtwrap.php');
        }
        elseif($coupon>0||$feespaid>0||$placement>0||$_SESSION['sndtprogram'])
        {
            $date=date("Y-m-d h:i:sa");
            $sql="INSERT INTO `teststart` (`email`,`accountno`,`starttime`) VALUES('$email','$accountno','$date');";
            mysqli_query($DBcon, $sql);
        }
        else
        {
            if(!$_SESSION['sndtprogram']) 
                 header('location:teststart.php');
            else header('location:sndtwrap.php');
        }
        
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1" />
    <meta name="robots" content="index, follow">
    <title>Talerang Express | Work Readiness Aptitude Predictor (WRAP)</title>
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css?version=2.4"/>
    <link rel="stylesheet" type="text/css" href="css/radiocheckbox.css?version=1.3" />
    <?php include 'noscript.php' ?>
    <?php include 'jqueryload.php' ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
</head>

<body>
<?php include 'google-analytics.php'; ?>
    <div id="page-container">
        <div id="header" class="container">
            <img src="img/logoexpress.jpg" alt="Talerang">
            <?php if(isset($_SESSION['useremail'])): ?>
            <span id="countdownbox">
                <span style="height:100px;">
                    <img src="img/loginboomerang.png" style="width:100px" alt="" id="img">
                </span>
                <span id="clockdiv">
                    <span class="minutes"></span>:<span class="seconds"></span>
                </span>
            </span>
            <?php endif; ?>
        </div>

        <div class="ribbon container-fluid">
            <div class="container" id="middle">
                Work Readiness Aptitude Predictor
            </div>
        </div>
        <?php if(!isset($_SESSION['useremail'])): ?>
            <div class="container">
                <p style="margin-top: 20px;">
                    You are not signed into your account! <br>
                    Please <a href="index.php">sign in</a> first.
                </p>
            </div>
        <?php else: ?>
        
        <!-- Nav tabs -->
        <div class="container-fluid alltabs">
        <ul id="mytabs" class="nav nav-tabs nav-justified" role="tablist">
            <li class="tabtop first active">
                <a class="tablink" href="#first" role="tab" data-toggle="tab"><div class="tabdiv"><span>Know<br class="tab-break"> Yourself</span></div></a>
            </li>
            <li class="tabtop second">
                <a class="tablink" href="#second" role="tab" data-toggle="tab"><div class="tabdiv"><span>Know<br class="tab-break"> Yourself</span></div></a>
            </li>
            <li class="tabtop lifevision">
                <a class="tablink" href="#lifevision" role="tab" data-toggle="tab"><div class="tabdiv"><span>Know<br class="tab-break"> Yourself</span></div></a>
            </li>
            <li class="tabtop third">
                <a class="tablink" href="#third" role="tab" data-toggle="tab"><div class="tabdiv"><span>Prove<br class="tab-break"> Yourself</span></div></a>
            </li>
            <li class="tabtop fourth">
                <a class="tablink" href="#fourth" role="tab" data-toggle="tab"><div class="tabdiv"><span>Prepare<br class="tab-break"> Yourself</span></div></a>
            </li>
            <li class="tabtop fifth">
                <a class="tablink" href="#fifth" role="tab" data-toggle="tab"><div class="tabdiv"><span>Prepare<br class="tab-break"> Yourself</span></div></a>
            </li>
            <li class="tabtop sixth">
                <a class="tablink" href="#sixth" role="tab" data-toggle="tab"><div class="tabdiv"><span>Prove<br class="tab-break"> Yourself</span></div></a>
            </li>
            <li class="tabtop seventh">
                <a class="tablink" href="#seventh" role="tab" data-toggle="tab"><div class="tabdiv"><span>Prepare<br class="tab-break"> Yourself</span></div></a>
            </li>
            <li class="tabtop eighth">
                <a class="tablink" href="#eighth" role="tab" data-toggle="tab"><div class="tabdiv"><span>Prepare<br class="tab-break"> Yourself</span></div></a>
            </li>
            <li class="tabtop ninth">
                <a class="tablink" href="#ninth" role="tab" data-toggle="tab"><div class="tabdiv"><span>Prepare<br class="tab-break"> Yourself</span></div></a>
            </li>
        </ul>
        </div>

        <div id="page-wrap" class="container">

            <form name="workready" action="grader.php" method="post" id="talquiz" class="dirty">
            <!-- Tab panes -->
            <div class="tab-content">
            <div class="tab-pane in active" id="first">
                <?php //Competency : Self-Belief ?>
                <!--NEW: ul, form-group -->
                <ul class="form-group">
                    <!-- NEW: div QuestionAnswer, div Question, div Answers -->
                    <div class="QuestionAnswer">
                        <li class="Question">
                            <h4>How did you decide to go to the college you are in today and choose your stream?</h4>
                        </li>

                        <li class="Answers">
                            <label for="question1answers" class="error"></label>
                            <div class="shuffle">
                            <div>
                                <input type="radio" name="question1answers" id="question-1-answers-A" value="A" />
                                <label for="question-1-answers-A"><span><span></span></span>Took the best stream available based on my marks</label>
                            </div>
                            <div>
                                <input type="radio" name="question1answers" id="question-1-answers-B" value="B" />
                                <label for="question-1-answers-B"><span><span></span></span>Took my parents’ advise on what to study</label>
                            </div>
                            <div>
                                <input type="radio" name="question1answers" id="question-1-answers-C" value="C" />
                                <label for="question-1-answers-C"><span><span></span></span>Followed my teacher’s advice on what to study</label>
                            </div>
                            <div>
                                <input type="radio" name="question1answers" id="question-1-answers-D" value="D" />
                                <label for="question-1-answers-D"><span><span></span></span>Chose to study what I enjoy studying</label>
                            </div>
                            <div>
                                <input type="radio" name="question1answers" id="question-1-answers-E" value="E" />
                                <label for="question-1-answers-E"><span><span></span></span>Chose to study what I am good at</label>
                            </div>
                            <div>
                                <input type="radio" name="question1answers" id="question-1-answers-F" value="F" />
                                <label for="question-1-answers-F"><span><span></span></span>Made a decision based on where I thought I want to be in the future</label>
                            </div>
                            <div>
                                <input type="radio" name="question1answers" id="question-1-answers-G" value="G" />
                                <label for="question-1-answers-G"><span><span></span></span>Decided to choose to keep my options open</label>
                            </div>
                            <div>
                                <input type="radio" name="question1answers" id="question-1-answers-H" value="H" />
                                <label for="question-1-answers-H"><span><span></span></span>Combination of enjoying and being good at what I want to study  </label>
                            </div>
                            <div>
                                <input type="radio" name="question1answers" id="question-1-answers-I" value="I" />
                                <label for="question-1-answers-I"><span><span></span></span>Combination of best available stream for my marks and parental advice</label>
                            </div>
                            </div>
                        </li>
                    </div>
                    <div class="QuestionAnswer">
                        <li class="Question">
                            <h4>If you had another opportunity to choose your college and stream of study, how would you like to decide?</h4> 
                        </li>
                        <li class="Answers">
                            <label for="question2answers" class="error"></label>
                            <div class="shuffle">
                            <div>
                                <input type="radio" name="question2answers" id="question-2-answers-A" value="A" />
                                <label for="question-2-answers-A"><span><span></span></span>Take the best stream available based on my marks </label>
                            </div>
                            <div>
                                <input type="radio" name="question2answers" id="question-2-answers-B" value="B" />
                                <label for="question-2-answers-B"><span><span></span></span>Take my parents’ advise on what to study</label>
                            </div>
                            <div>
                                <input type="radio" name="question2answers" id="question-2-answers-C" value="C" />
                                <label for="question-2-answers-C"><span><span></span></span>Follow my teacher’s advice on what to study </label>
                            </div>
                            <div>
                                <input type="radio" name="question2answers" id="question-2-answers-D" value="D" />
                                <label for="question-2-answers-D"><span><span></span></span>Choose to study what I enjoy studying </label>
                            </div>
                            <div>
                                <input type="radio" name="question2answers" id="question-2-answers-E" value="E" />
                                <label for="question-2-answers-E"><span><span></span></span>Choose to study what I am good at </label>
                            </div>
                            <div>
                                <input type="radio" name="question2answers" id="question-2-answers-F" value="F" />
                                <label for="question-2-answers-F"><span><span></span></span>Make a decision based on where I thought I want to be in the future</label>
                            </div>
                            <div>
                                <input type="radio" name="question2answers" id="question-2-answers-G" value="G" />
                                <label for="question-2-answers-G"><span><span></span></span>Choose to keep my options open</label>
                            </div>
                            <div>
                                <input type="radio" name="question2answers" id="question-2-answers-H" value="H" />
                                <label for="question-2-answers-H"><span><span></span></span>Combination of enjoying and being good at what I want to study  </label>
                            </div>
                            <div>
                                <input type="radio" name="question2answers" id="question-2-answers-I" value="I" />
                                <label for="question-2-answers-I"><span><span></span></span>Combination of best available stream for my marks and parental advice </label>
                            </div>
                            </div>
                        </li>
                    </div>
                    <div class="QuestionAnswer">
                        <li class="Question">
                            <h4>What values are most important to you?</h4>
                        </li>
                        <li class="Answers">
                            <label for="question1banswers" class="error"></label>
                            <label for="question1banswerstext" class="error"></label>
                            <div class="shuffle">
                            <div>
                                <input type="radio" name="question1banswers" id="question-1b-answers-A" value="A"/>
                                <label for="question-1b-answers-A"><span><span></span></span>Honesty, Trust and Loyalty</label>
                            </div>
                            <div>
                                <input type="radio" name="question1banswers" id="question-1b-answers-B" value="B"/>
                                <label for="question-1b-answers-B"><span><span></span></span>Hard-work, Perseverance and Determination</label>
                            </div>
                            <div>
                                <input type="radio" name="question1banswers" id="question-1b-answers-C" value="C"/>
                                <label for="question-1b-answers-C"><span><span></span></span>Love, Compassion and Generosity</label>
                            </div>
                            <div>
                                <input type="radio" name="question1banswers" id="question-1b-answers-E" value="E"/>
                                <label for="question-1b-answers-E"><span><span></span></span>I’m still to decide what my core values are</label>
                            </div>
                            </div>
                            <div>
                                <input type="radio" name="question1banswers" id="question-1b-answers-D" value="D"/>
                                <label for="question-1b-answers-D"><span><span></span></span>Other</label>
                                <input type="text" name="question1banswerstext" id="hideshow1" placeholder="Please specify">
                            </div>
                        </li>
                    </div>
                    <div class="QuestionAnswer">
                        <li class="Question">
                            <h4>What do you look for in your friends?</h4>
                        </li>
                        <li class="Answers">
                            <label for="question2banswers" class="error"></label>
                            <div class="shuffle">
                            <div>
                                <input type="radio" name="question2banswers" id="question-2b-answers-A" value="A"/>
                                <label for="question-2b-answers-A"><span><span></span></span>Alignment with your values</label>
                            </div>
                            <div>
                                <input type="radio" name="question2banswers" id="question-2b-answers-B" value="B"/>
                                <label for="question-2b-answers-B"><span><span></span></span>People you respect and trust </label>
                            </div>
                            <div>
                                <input type="radio" name="question2banswers" id="question-2b-answers-C" value="C"/>
                                <label for="question-2b-answers-C"><span><span></span></span>People you look up to</label>
                            </div>
                            <div>
                                <input type="radio" name="question2banswers" id="question-2b-answers-D" value="D"/>
                                <label for="question-2b-answers-D"><span><span></span></span>People with similar backgrounds and interests</label>
                            </div>
                            <div>
                                <input type="radio" name="question2banswers" id="question-2b-answers-E" value="E"/>
                                <label for="question-2b-answers-E"><span><span></span></span>I’m friends with most people around me</label>
                            </div>
                            <div>
                                <input type="radio" name="question2banswers" id="question-2b-answers-F" value="F"/>
                                <label for="question-2b-answers-F"><span><span></span></span>People who know how to have a good time</label>
                            </div>
                            </div>
                        </li>
                    </div>
                </ul>
                <!--NEW: div buttons-->
                <div class="buttons">
                    <button type="button" class="btn btn-primary next">Next section</button>
                </div>
                <div class="sectionerror"></div>
            </div>
            <!-- END TAB PANE1 -->
            <div class="tab-pane" id="second">
                <?php //Competency : Self- Awareness ?>
                <ul class="form-group">
                    <?php $randominput = array(0,1,2,3);
                          $rand_keys = array_rand($randominput, 2); 
                          if(in_array(0,$rand_keys)): ?>
                    <div class="QuestionAnswer">
                        <li class="Question">
                            <h4> What is your ideal working style? </h4> 
                        </li>
                        <li class="Answers"> <label for="question3answers" class="error"></label>
                            <div class="shuffle">
                            <div>
                                <input type="radio" name="question3answers" id="question-3-answers-A" value="A" />
                                <label for="question-3-answers-A"><span><span></span></span> Like working with people in teams</label>
                            </div>
                            <div>
                                <input type="radio" name="question3answers" id="question-3-answers-B" value="B" />
                                <label for="question-3-answers-B"><span><span></span></span> Prefer working alone </label>
                            </div>
                            <div>
                                <input type="radio" name="question3answers" id="question-3-answers-C" value="C" />
                                <label for="question-3-answers-C"><span><span></span></span> It depends on the situation</label>
                            </div>
                            <div>
                                <input type="radio" name="question3answers" id="question-3-answers-D" value="D" />
                                <label for="question-3-answers-D"><span><span></span></span> I don’t have a clear preference </label>
                            </div>
                            </div>
                        </li>
                    </div>
                    <?php endif; if(in_array(1,$rand_keys)): ?>
                    <div class="QuestionAnswer">
                        <li class="Question">
                            <h4> How do you organize yourself in a professional context?</h4> 
                        </li>
                        <li class="Answers"> <label for="question4answers" class="error"></label>
                            <div class="shuffle">
                            <div>
                                <input type="radio" name="question4answers" id="question-4-answers-A" value="A" />
                                <label for="question-4-answers-A"><span><span></span></span> Make lists and work on them</label>
                            </div>
                            <div>
                                <input type="radio" name="question4answers" id="question-4-answers-B" value="B" />
                                <label for="question-4-answers-B"><span><span></span></span> Go with the flow</label>
                            </div>
                            <div>
                                <input type="radio" name="question4answers" id="question-4-answers-C" value="C" />
                                <label for="question-4-answers-C"><span><span></span></span> It depends on the situation</label>
                            </div>
                            <div>
                                <input type="radio" name="question4answers" id="question-4-answers-D" value="D" />
                                <label for="question-4-answers-D"><span><span></span></span> I don’t have a clear preference</label>
                            </div>
                            </div>
                        </li>
                    </div>
                    <?php endif; if(in_array(2,$rand_keys)): ?>
                    <div class="QuestionAnswer">
                        <li class="Question">
                            <h4> How do you usually approach work related problems?  </h4> 
                        </li>
                        <li class="Answers"> <label for="question5answers" class="error"></label>
                            <div class="shuffle">
                            <div>
                                <input type="radio" name="question5answers" id="question-5-answers-A" value="A" />
                                <label for="question-5-answers-A"><span><span></span></span> I like to analyze data and come to a conclusion</label>
                            </div>
                            <div>
                                <input type="radio" name="question5answers" id="question-5-answers-B" value="B" />
                                <label for="question-5-answers-B"><span><span></span></span> I like to follow my gut and intuition</label>
                            </div>
                            <div>
                                <input type="radio" name="question5answers" id="question-5-answers-C" value="C" />
                                <label for="question-5-answers-C"><span><span></span></span> It depends on the situation</label>
                            </div>
                            <div>
                                <input type="radio" name="question5answers" id="question-5-answers-D" value="D" />
                                <label for="question-5-answers-D"><span><span></span></span> I don’t have a clear preference </label>
                            </div>
                            </div>
                        </li>
                    </div>
                    <?php endif; if(in_array(3,$rand_keys)): ?>
                    <div class="QuestionAnswer">
                        <li class="Question">
                            <h4>How do you usually react to situations in a professional context?</h4> 
                        </li>
                        <li class="Answers"> <label for="question6answers" class="error"></label>
                            <div class="shuffle">
                            <div>
                                <input type="radio" name="question6answers" id="question-6-answers-A" value="A" />
                                <label for="question-6-answers-A"><span><span></span></span> Think with your head – you are very rational </label>
                            </div>
                            <div>
                                <input type="radio" name="question6answers" id="question-6-answers-B" value="B" />
                                <label for="question-6-answers-B"><span><span></span></span> Follow your heart – you are concerned about how it will affect people</label>
                            </div>
                            <div>
                                <input type="radio" name="question6answers" id="question-6-answers-C" value="C" />
                                <label for="question-6-answers-C"><span><span></span></span> It depends on the situation</label>
                            </div>
                            <div>
                                <input type="radio" name="question6answers" id="question-6-answers-D" value="D" />
                                <label for="question-6-answers-D"><span><span></span></span> I don’t have a clear preference </label>
                            </div>
                            </div>
                        </li>
                    </div>
                    <?php endif ?>
                </ul>
                <div class="buttons">
                    <button type="button" class="btn btn-primary previous">Previous section</button>
                    <button type="button" class="btn btn-primary next">Next section</button>
                </div>
            </div>
            <!-- END TAB PANE2 -->

            <div class="tab-pane" id="lifevision">
                <?php //Competency : Life Vision ?>
                <ul class="form-group">
                    <div class="QuestionAnswer">
                        <li class="Question">
                            <h4>What matters most to you and why? (150 word summary)</h4>
                            <div><label for="question37answers" class="error"></label></div>
                            <textarea class="lifevision-essay" name="question37answers" id="question37answers"></textarea>
                        </li>
                        <li class="Question">
                            <h4>What is your plan for the next 3-5 years? (150 word summary)</h4>
                            <div><label for="question38answers" class="error"></label></div>
                            <textarea class="lifevision-essay" name="question38answers" id="question38answers"></textarea>
                        </li>
                    </div>
                </ul>
                <div class="buttons">
                    <button type="button" class="btn btn-primary previous">Previous section</button>
                    <button type="button" class="btn btn-primary next">Next section</button>
                </div>
            </div>
            
            <div class="tab-pane" id="third">
                <?php //Competency : Professionalism ?>
                <ul class="form-group">
                    <?php if(rand(1,2)==1): ?>
                    <div class="QuestionAnswer">
                        <li class="Question">
                            <h4>Think of a situation where you’ve had trouble getting along professionally with someone on a team at college. How did you deal with it?</h4>
                        </li>
                        <li class="Answers"><label for="question7answers" class="error"></label>
                            <div class="shuffle">
                            <div>
                                <input type="radio" name="question7answers" id="question-7-answers-A" value="A" />
                                <label for="question-7-answers-A"><span><span></span></span> Openly shared my issue with the person concerned </label>
                            </div>
                            <div>
                                <input type="radio" name="question7answers" id="question-7-answers-B" value="B" />
                                <label for="question-7-answers-B"><span><span></span></span> Spoke to another team member and we approached the person concerned</label>
                            </div>
                            <div>
                                <input type="radio" name="question7answers" id="question-7-answers-C" value="C" />
                                <label for="question-7-answers-C"><span><span></span></span> Spoke to his/her superior</label>
                            </div>
                            <div>
                                <input type="radio" name="question7answers" id="question-7-answers-D" value="D" />
                                <label for="question-7-answers-D"><span><span></span></span> Didn’t do anything about it</label>
                            </div>
                            </div>
                        </li>
                    </div>
                    <?php else: ?>
                    <div class="QuestionAnswer">
                        <li class="Question">
                            <h4>You have joined an organization looking to do an internship in marketing. But on your first day at work you are asked to work on a project in research. What will you do in such a situation?</h4>
                        </li>
                        <li class="Answers"><label for="question7answers" class="error"></label>
                            <div>
                            <div>
                                <input type="radio" name="question7answers" id="question-7-answers-A" value="A" />
                                <label for="question-7-answers-A"><span><span></span></span>Initially do the research work and then ask for work that interests you</label>
                            </div>
                            <div>
                                <input type="radio" name="question7answers" id="question-7-answers-B" value="B" />
                                <label for="question-7-answers-B"><span><span></span></span>Try and understand why your project has been changed</label>
                            </div>
                            <div>
                                <input type="radio" name="question7answers" id="question-7-answers-C" value="C" />
                                <label for="question-7-answers-C"><span><span></span></span>Just do the work as told</label>
                            </div>
                            <div>
                                <input type="radio" name="question7answers" id="question-7-answers-D" value="D" />
                                <label for="question-7-answers-D"><span><span></span></span>Quit and find a better internship</label>
                            </div>
                            </div>
                        </li>
                    </div>
                    <?php endif;  if(rand(1,2)==1): ?>
                    <div class="QuestionAnswer">
                        <li class="Question">
                            <h4>It’s the weekend before a really major deadline for your team. It’s clashing with your birthday week and you had planned a trip with your close friends to Lonavala to celebrate. How would you approach this?</h4>
                        </li>
                        <li class="Answers"> <label for="question32answers" class="error"></label>
                            <div class="shuffle">
                            <div>
                                <input type="radio" name="question32answers" id="question-32-answers-A" value="A" />
                                <label for="question-32-answers-A"><span><span></span></span>You would push back your birthday celebrations by a week</label>
                            </div>
                            <div>
                                <input type="radio" name="question32answers" id="question-32-answers-B" value="B" />
                                <label for="question-32-answers-B"><span><span></span></span>You would request someone on the team to fill in for you </label>
                            </div>
                            <div>
                                <input type="radio" name="question32answers" id="question-32-answers-C" value="C" />
                                <label for="question-32-answers-C"><span><span></span></span>You would work from Lonavala but still get everything done</label>
                            </div>
                            <div>
                                <input type="radio" name="question32answers" id="question-32-answers-D" value="D" />
                                <label for="question-32-answers-D"><span><span></span></span>You would tell your manager you cannot contribute this time but will make it up later</label>
                            </div>
                            </div>
                        </li>
                    </div>
                    <?php else: ?>
                    <div class="QuestionAnswer">
                        <li class="Question">
                            <h4>Your boss starts yelling at you for a mistake that isn’t yours. How would you react?</h4>
                        </li>
                        <li class="Answers"> <label for="question32answers" class="error"></label>
                            <div class="shuffle">
                            <div>
                                <input type="radio" name="question32answers" id="question-32-answers-A" value="A" />
                                <label for="question-32-answers-A"><span><span></span></span>Take the blame entirely, it’s not worth arguing with your manager</label>
                            </div>
                            <div>
                                <input type="radio" name="question32answers" id="question-32-answers-B" value="B" />
                                <label for="question-32-answers-B"><span><span></span></span>Cover up for your colleague and deal with it later</label>
                            </div>
                            <div>
                                <input type="radio" name="question32answers" id="question-32-answers-C" value="C" />
                                <label for="question-32-answers-C"><span><span></span></span>First correct the mistake and then later investigate</label>
                            </div>
                            <div>
                                <input type="radio" name="question32answers" id="question-32-answers-D" value="D" />
                                <label for="question-32-answers-D"><span><span></span></span>Identify who was responsible for the error and communicate it to your manager</label>
                            </div>
                            </div>
                        </li>
                    </div>
                    <?php endif ?>
                </ul>
                <div class="buttons">
                    <button type="button" class="btn btn-primary previous">Previous section</button>
                    <button type="button" class="btn btn-primary next">Next section</button>
                </div>
            </div>
            <!-- END TAB PANE3 -->
            
            <div class="tab-pane" id="fourth">
                <?php //Competency : Business Communication ?>
                <!--NEW: div, class=scenario class = one/two/three   -->
                <div class="scenario one">
                    <h4><u> Scenario: E-mail for Sick Leave (relevant content)</u></h4> Dear Mr. X,<br> I am in a bit of a fix. I got your mail regarding the design and I was in the process of creating it but as I pressed enter all my work vanished. It is not even there in the draft. I spent more than an hour doing it, inspite of, the viral fever. And I understand that the deadline is in next 30 minutes, but I won't be able to finish it. I am not feeling well.<br> I understand that this could affect my performance, but I feel helpless because of the deadline.<br> regards,
                    <br>ABC<br>
                </div>                     
                <ul class="form-group one">
                    <div class="QuestionAnswer">
                        <li class="Question">
                            <h4>Identify all the issues with the e-mail? (Select all that apply)</h4> 
                        </li>
                        <li class="Answers"> <label for="question8answers[]" class="error"></label>
                            <div class="shuffle">
                            <div>
                                <input type="checkbox" name="question8answers[]" id="question-8-answers-A" value="A" />
                                <label for="question-8-answers-A"><span></span> The e-mail is poorly structured</label>
                            </div>
                            <div>
                                <input type="checkbox" name="question8answers[]" id="question-8-answers-B" value="B" />
                                <label for="question-8-answers-B"><span></span> The tone of the e-mail makes the writer seem irresponsible. </label>
                            </div>
                            <div>
                                <input type="checkbox" name="question8answers[]" id="question-8-answers-C" value="C" />
                                <label for="question-8-answers-C"><span></span> The e-mail contains spelling errors. </label>
                            </div>
                            <div>
                                <input type="checkbox" name="question8answers[]" id="question-8-answers-D" value="D" />
                                <label for="question-8-answers-D"><span></span> There is nothing wrong with this e-mail. </label>
                            </div>
                            </div>
                        </li>
                    </div>
                    <div class="QuestionAnswer">
                        <li class="Question rewriteemail">
                            <h4>Which of the following is the best way to rewrite the e-mail?</h4> 
                        </li>
                        <li class="Answers"> <label for="question9answers" class="error"></label>
                            <div class="shuffle1">
                            <div class="shuffleopt">
                                <input type="radio" name="question9answers" id="question-9-answers-A" value="A" />
                                <label for="question-9-answers-A"><span><span></span></span>
                                Dear Mr. X, 
                                <div class="optionFormatPurpose">I cannot make it to work today, as I am ill with viral fever. However, I am attaching the design for Y project with this e-mail and look forward to your feedback.
                                <br>Regards, 
                                <br>ABC </div>
                                </label>
                            </div>
                            <div class="shuffleopt">
                                <input type="radio" name="question9answers" id="question-9-answers-B" value="B" />
                                <label for="question-9-answers-B"><span><span></span></span> Dear Mr. X,  
                                    <div class="optionFormatPurpose">Hope you are doing well.  
                                    <br>I woke up this morning with sore throat. The doctor diagnosed the fever as symptoms of viral.   
                                    <br>I will not be able to make it to work on time today. If I feel better later this evening, I could work on the design from home.  
                                    <br>Apologies for the short notice and inconvenience caused.  
                                    <br>Thanks and Regards,
                                    <br>ABC
                                    </div>
                                </label>
                            </div>
                            <div class="shuffleopt">
                                <input type="radio" name="question9answers" id="question-9-answers-C" value="C" />
                                <label for="question-9-answers-C"><span><span></span></span> Dear Mr. X,
                                    <div class="optionFormatPurpose">
                                    I am not coming to work today as I am sick. I went to the doctor, who mentioned that I have viral fever and prescribed me some medicines. 
                                    <br>I will be able to work on the draft but it will be delayed from my end. 
                                    <br>Regards, 
                                    <br>ABC
                                    </div>
                                </label>
                            </div>
                            <div class="shuffleopt">
                                <input type="radio" name="question9answers" id="question-9-answers-D" value="D" />
                                <label for="question-9-answers-D"><span><span></span></span>Dear Mr. X,
                                    <div class="optionFormatPurpose">
                                    I have done the works and have sent them to you. But I am sick today so I cannot make it to office. Please accept my sincere apologies and grant me a sick leave.
                                    <br>Regards,
                                    <br>ABC  
                                    </div> 
                                </label>
                            </div>
                            </div>
                        </li>
                    </div>
                </ul>
                <div class="scenario two">
                    <h4><u> Scenario: Client E-mail (Brevity)</u></h4> Dear Ms. M, First of all, let me thank you for your cooperation and patience caused due to the delay in getting back. I sincerely apologise for the same.<br> Thanks for the call today and sharing some of the inputs. It was heartening to understand your team’s views. I would look forward to further interactions whilst devising a convenient solution for your organization.<br> Please find attached for your kind approval, the documents mentioned hereforewith.<br> With regards,<br> Mr. H <br>
                </div>
                <ul class="form-group two">
                    <div class="QuestionAnswer">
                        <li class="Question">
                            <h4>Identify all the issues with the e-mail? (Select all that apply)</h4> 
                        </li>
                        <li class = "Answers"> <label for="question10answers[]" class="error"></label>
                            <div class="shuffle">
                            <div>
                                <input type="checkbox" name="question10answers[]" id="question-10-answers-A" value="A" />
                                <label for="question-10-answers-A"><span></span> The issue is not addressed in a clear and concise manner.</label>
                            </div>
                            <div>
                                <input type="checkbox" name="question10answers[]" id="question-10-answers-B" value="B" />
                                <label for="question-10-answers-B"><span></span> E-mail is very rude. </label>
                            </div>
                            <div>
                                <input type="checkbox" name="question10answers[]" id="question-10-answers-C" value="C" />
                                <label for="question-10-answers-C"><span></span> E-mail contains too many details about the project.</label>
                            </div>
                            <div>
                                <input type="checkbox" name="question10answers[]" id="question-10-answers-D" value="D" />
                                <label for="question-10-answers-D"><span></span> There is nothing wrong with the e-mail. It can be sent. </label>
                            </div>
                            </div>
                        </li>
                    </div>
                    <div class="QuestionAnswer">
                        <li class="Question rewritemail">
                            <h4>Which of the following is the best way to rewrite the e-mail?</h4> 
                        </li>
                        <li class = "Answers"> <label for="question11answers" class="error"></label>
                            <div class="shuffle1">
                            <div class="shuffleopt">
                                <input type="radio" name="question11answers" id="question-11-answers-A" value="A" />
                                <label for="question-11-answers-A"><span><span></span></span> Dear Ms. M,
                                    <div class="optionFormatPurpose">
                                    I apologize for the delay in responding to you. It was a pleasure speaking with you and I look forward to working on this project together. Please find the documents attached for your reference.
                                    <br>With regards, 
                                    <br>Mr. H 
                                    </div>
                                </label>
                            </div>
                            <div class="shuffleopt">
                                <input type="radio" name="question11answers" id="question-11-answers-B" value="B" />
                                <label for="question-11-answers-B"><span><span></span></span> Dear Ms. M,
                                    <div class="optionFormatPurpose">
                                    I am writing to you to offer my apologies for not replying at a sooner date. It was wonderful to speak to you on the phone today and I’m glad to be able to understand your team’s views better. I look forward to our interactions and working together on this project. Please find attached the documents for your reference.  
                                    <br>With regards,
                                    <br>Mr. H 
                                    </div>
                                </label>
                            </div>
                            <div class="shuffleopt">
                                <input type="radio" name="question11answers" id="question-11-answers-C" value="C" />
                                <label for="question-11-answers-C"><span><span></span></span>Dear Ms. M,
                                    <div class="optionFormatPurpose">
                                    Please find attached the documents for your reference. I look forward to all our future interactions and thank you for getting on the call today. I’m sorry for not being able to get back to you sooner.
                                    <br>With regards,
                                    <br>Mr. H
                                    </div>
                                </label>
                            </div>
                            </div>
                        </li>
                    </div>
                    <div class="QuestionAnswer">
                        <li class="Question">
                            <h4> When should you send this e-mail?  </h4> 
                        </li>
                        <li class="Answers"> <label for="question12answers" class="error"></label>
                            <div class="shuffle">
                            <div>
                                <input type="radio" name="question12answers" id="question-12-answers-A" value="A" />
                                <label for="question-12-answers-A"><span><span></span></span> Within 48 hours, as it contains documents referenced in the phone conversation.</label>
                            </div>
                            <div>
                                <input type="radio" name="question12answers" id="question-12-answers-B" value="B" />
                                <label for="question-12-answers-B"><span><span></span></span> When the receiver sends an e-mail asking for the documents. </label>
                            </div>
                            <div>
                                <input type="radio" name="question12answers" id="question-12-answers-C" value="C" />
                                <label for="question-12-answers-C"><span><span></span></span> It doesn’t matter. Since the sender sent a delayed response the previous time, he can send a delayed response the following time.</label>
                            </div>
                            <div>
                                <input type="radio" name="question12answers" id="question-12-answers-D" value="D" />
                                <label for="question-12-answers-D"><span><span></span></span> Within a week’s time, after the next phone conversation. </label>
                            </div>
                            </div>
                        </li>
                    </div>
                </ul>
                <div class="scenario three">
                    <h4><u> Scenario: Rude tone</u></h4> To: &nbsp; <u>mark@abc.com</u> , <u>jen@abc.com</u> , <u>martin@abc.com</u> , <u>tia@abc.com</u> , <u>jacob@abc.com</u> , <u>franz@abc.com</u> <br> Subject: [No subject]<br> Dear all,<br> I am waiting for Jen to send me the powerpoint slide to complete the video. I have already reminded her. It all depends on when she sends it. And I was thinking of setting up a call with the website people after editing the videos.<br>
                    Regards, <br> Marla
                    <br>
                </div>
                <ul class="form-group three">
                    <div class="QuestionAnswer">
                        <li class="Question">
                            <h4>Identify the odd one out </h4> 
                        </li>
                        <li class = "Answers"> <label for="question13answers" class="error"></label>
                            <div class="shuffle">
                            <div>
                                <input type="radio" name="question13answers" id="question-13-answers-A" value="A" />
                                <label for="question-13-answers-A"><span><span></span></span> The tone of the e-mail is rude and puts Jen in bad light as five other people are marked on it.</label>
                            </div>
                            <div>
                                <input type="radio" name="question13answers" id="question-13-answers-B" value="B" />
                                <label for="question-13-answers-B"><span><span></span></span> There is nothing wrong with the e-mail. It is clear and concise. </label>
                            </div>
                            <div>
                                <input type="radio" name="question13answers" id="question-13-answers-C" value="C" />
                                <label for="question-13-answers-C"><span><span></span></span> E-mail does not specify the deadlines by which Jen or Marla must submit their work.</label>
                            </div>
                            <div>
                                <input type="radio" name="question13answers" id="question-13-answers-D" value="D" />
                                <label for="question-13-answers-D"><span><span></span></span> E-mail does not have a subject line. </label>
                            </div>
                            </div>
                        </li>
                    </div>
                </ul>
                <div class="buttons">
                    <button type="button" class="btn btn-primary previous">Previous section</button>
                    <button type="button" class="btn btn-primary next">Next section</button>
                </div>                    
            </div>
            <!-- END TAB PANE4 -->

            <div class="tab-pane" id="fifth">
                 <?php //Competency : Prioritization ?>
                    <div class="scenario">
                        <h4>Imagine a day when you have a lot on your plate at work. It’s 9am. How would you prioritize the following?</h4>
                        <p id="pri1">Drag options to rearrange (Keep high priority tasks on top)</p>
                        <label for="question-14-answers" class="error"></label>
                        <input type='text' class="displaynone" id='question-14-answers' name='question14answers' value='A.B.C.D.E.F'/>
                            <ul id="sortable1" class="sortable">
                                <li class="ui-state-default" pri1-id="A">Submit your daily task report to your manager.</li>
                                <li class="ui-state-default" pri1-id="B">Speak to a colleague who seems to be having a bad day.</li>
                                <li class="ui-state-default" pri1-id="C">Complete an analysis that is due to a client by 5pm tomorrow.</li>
                                <li class="ui-state-default" pri1-id="D">Prepare for a presentation later today to your team.</li>
                                <li class="ui-state-default" pri1-id="E">Get feedback on work you had done last week for which you are still waiting for a response from your manager.</li>
                                <li class="ui-state-default" pri1-id="F">Get materials printed for a meeting next week.</li>
                            </ul>
                    </div>

                    <?php if(rand(1,2)==1): ?>
                    <input type="text" name="prioritization" value="option1" class="displaynone">
                    <div class="scenario">
                        <h4> 
                            It’s your first month working in a consulting company. You have worked really hard to prepare a presentation for your boss. However, when you share it with him, he is very unhappy with it. It will require another 4-5 hours of work from you. You feel that he should have given you a clearer brief. How would you approach it? 
                        </h4>
                    </div>
                    <ul class="form-group">
                    <div class="QuestionAnswer">
                        <li class="Answers"> <label for="question15answers" class="error"></label>
                            <div class="shuffle">
                            <div>
                                <input type="radio" name="question15answers" id="question-15-answers-A" value="A" />
                                <label for="question-15-answers-A"><span><span></span></span>You will first rework the presentation and then let him know at a later time that you feel the brief wasn’t clear enough</label>
                            </div>
                            <div>
                                <input type="radio" name="question15answers" id="question-15-answers-B" value="B" />
                                <label for="question-15-answers-B"><span><span></span></span>You will first share that he should have briefed you better and then rework the presentation</label>
                            </div>
                            <div>
                                <input type="radio" name="question15answers" id="question-15-answers-C" value="C" />
                                <label for="question-15-answers-C"><span><span></span></span>Tell him you can’t rework it because you’re exhausted and will do it the next day</label>
                            </div>
                            <div>
                                <input type="radio" name="question15answers" id="question-15-answers-D" value="D" />
                                <label for="question-15-answers-D"><span><span></span></span>Apologize for not understanding the brief, then ask for a brief again, and stay back and complete it</label>
                            </div>
                            </div>
                        </li>
                    </div>
                    </ul>
                    <?php else: ?>
                    <div class="scenario">
                        <h4> You are working in the marketing department of a company. You come into work at 9am on Monday morning and have to complete the following tasks during the day and over the week. Which of the following tasks would you categorize as the 3 most important and the 3 least important tasks?</h4>
                        <p id="pri2">Drag and drop options into the gray boxes below to create your lists</p>
                        <input type="text" name="prioritization" value="option2" class="displaynone"> 
                        <input type='text' class="displaynone" id='question-15-answers-1' name='question15answers1' value=''/>
                        <input type='text' class="displaynone" id='question-15-answers-2' name='question15answers2' value=''/>

                        <ul id="sortable2" class="droptrue sortablepri2 sortable">
                            <li class="ui-state-default" pri2-id="A">Design a logo for a new product</li>
                            <li class="ui-state-default" pri2-id="B">Buy tickets for a recently released movie</li>
                            <li class="ui-state-default" pri2-id="C">Track your company’s competitors market share for the month</li>
                            <li class="ui-state-default" pri2-id="D">Edit a video for your company website</li>
                            <li class="ui-state-default" pri2-id="E">Submit a report which is due in an hour</li>
                            <li class="ui-state-default" pri2-id="F">Spend time surfing on Facebook</li>
                            <li class="ui-state-default" pri2-id="G">Answer co-worker’s e-mail for upcoming finance meeting about a discrepancy in the submitted budget</li>
                            <li class="ui-state-default" pri2-id="H">Meet a stationery vendor to scout potential merchandise</li>
                            <li class="ui-state-default" pri2-id="I">Reschedule weekly performance feedback with your juniors</li>
                            <li class="ui-state-default" pri2-id="J">Schedule weekend lunch plans with your spouse</li>
                            <li class="ui-state-default" pri2-id="K">Follow up with another company’s senior manager with a phone call</li>
                        </ul>
                        <ul id="top3" class="droptrue sortablepri2 sortable">
                            <p class="ui-state-disabled" pri2-id="X">3 most important tasks</p>
                        </ul>
                        <ul id="bottom3" class="droptrue sortablepri2 sortable">
                            <p class="ui-state-disabled" pri2-id="X">3 least important tasks</p>
                        </ul>
                        <div class="clearfix"></div>
                    </div>  
                    <?php endif ?>
                    
                    <div class="buttons">
                        <button type="button" class="btn btn-primary previous">Previous section</button>
                        <button type="button" class="btn btn-primary next">Next section</button>
                    </div>
            </div>
            <!-- END TAB PANE5 -->

            <div class="tab-pane" id="sixth">
                <?php //Competency : Professional Awareness ?>
                <ul class="form-group">
                    <div class="QuestionAnswer">
                        <li class="Question">
                            <h4> What kind of work are you most interested in?</h4> 
                        </li>
                        <li class = "Answers"><label for="question35answers" class="error"></label>
                            <div class="container" style="width: 100%;">
                            <div class="row">
                            <div class="shuffle">
                                <div class="col-md-6 col-sm-6 col-sm-12">
                                    <input type="radio" name="question35answers" id="question-35-answers-A" value="A" />
                                    <label for="question-35-answers-A"><span><span></span></span>Trading</label>
                                </div>
                                <div class="col-md-6 col-sm-6 col-sm-12">
                                    <input type="radio" name="question35answers" id="question-35-answers-B" value="B" />
                                    <label for="question-35-answers-B"><span><span></span></span>Consulting</label>
                                </div>
                                <div class="col-md-6 col-sm-6 col-sm-12">
                                    <input type="radio" name="question35answers" id="question-35-answers-C" value="C" />
                                    <label for="question-35-answers-C"><span><span></span></span>Marketing</label>
                                </div>
                                <div class="col-md-6 col-sm-6 col-sm-12">
                                    <input type="radio" name="question35answers" id="question-35-answers-D" value="D" />
                                    <label for="question-35-answers-D"><span><span></span></span>Investment Banking</label>
                                </div>
                                <div class="col-md-6 col-sm-6 col-sm-12">
                                    <input type="radio" name="question35answers" id="question-35-answers-E" value="E" />
                                    <label for="question-35-answers-E"><span><span></span></span>Analytics</label>
                                </div>
                                <div class="col-md-6 col-sm-6 col-sm-12">
                                    <input type="radio" name="question35answers" id="question-35-answers-F" value="F" />
                                    <label for="question-35-answers-F"><span><span></span></span>Strategy roles</label>
                                </div>
                                <div class="col-md-6 col-sm-6 col-sm-12">
                                    <input type="radio" name="question35answers" id="question-35-answers-G" value="G" />
                                    <label for="question-35-answers-G"><span><span></span></span>Operations roles</label>
                                </div>
                                <div class="col-md-6 col-sm-6 col-sm-12">
                                    <input type="radio" name="question35answers" id="question-35-answers-H" value="H" />
                                    <label for="question-35-answers-H"><span><span></span></span>Sales roles</label>
                                </div>
                                <div class="col-md-6 col-sm-6 col-sm-12">
                                    <input type="radio" name="question35answers" id="question-35-answers-I" value="I" />
                                    <label for="question-35-answers-I"><span><span></span></span>Start-ups</label>
                                </div>
                                <div class="col-md-6 col-sm-6 col-sm-12">
                                    <input type="radio" name="question35answers" id="question-35-answers-J" value="J" />
                                    <label for="question-35-answers-J"><span><span></span></span>Hospitality/Retail</label>
                                </div>
                            </div> <!-- end shuffle -->
                            </div> <!-- end row -->
                            </div> <!-- end container -->
                        </li>
                    </div>
                    <div class="QuestionAnswer">
                        <li class="Question">
                            <h4> What are your strongest skills and motivations? (Please select ONLY six options)</h4>
                        </li>
                        <li class = "Answers"> <label for="question36answers[]" class="error"></label>
                            <div class="container" style="width: 100%;">
                            <div class="row">
                            <div class="shuffle">
                                <div class="col-md-6 col-sm-12">
                                    <input type="checkbox" name="question36answers[]" id="question-36-answers-A" value="A" />
                                    <label for="question-36-answers-A"><span></span> Motivated by money</label>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <input type="checkbox" name="question36answers[]" id="question-36-answers-B" value="B" />
                                    <label for="question-36-answers-B"><span></span> Ability to handle pressure</label>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <input type="checkbox" name="question36answers[]" id="question-36-answers-C" value="C" />
                                    <label for="question-36-answers-C"><span></span> Ability to grasp concepts quickly</label>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <input type="checkbox" name="question36answers[]" id="question-36-answers-D" value="D" />
                                    <label for="question-36-answers-D"><span></span> Meet deadlines under stress  </label>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <input type="checkbox" name="question36answers[]" id="question-36-answers-E" value="E" />
                                    <label for="question-36-answers-E"><span></span> Motivated by client impact </label>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <input type="checkbox" name="question36answers[]" id="question-36-answers-F" value="F" />
                                    <label for="question-36-answers-F"><span></span> Problem solving ability </label>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <input type="checkbox" name="question36answers[]" id="question-36-answers-G" value="G" />
                                    <label for="question-36-answers-G"><span></span> Enjoy working in teams </label>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <input type="checkbox" name="question36answers[]" id="question-36-answers-H" value="H" />
                                    <label for="question-36-answers-H"><span></span> Creative thinking skills  </label>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <input type="checkbox" name="question36answers[]" id="question-36-answers-I" value="I" />
                                    <label for="question-36-answers-I"><span></span> People skills  </label>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <input type="checkbox" name="question36answers[]" id="question-36-answers-J" value="J" />
                                    <label for="question-36-answers-J"><span></span> Quantitative ability  </label>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <input type="checkbox" name="question36answers[]" id="question-36-answers-K" value="K" />
                                    <label for="question-36-answers-K"><span></span> Analytical ability   </label>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <input type="checkbox" name="question36answers[]" id="question-36-answers-L" value="L" />
                                    <label for="question-36-answers-L"><span></span> Ability to do research </label>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <input type="checkbox" name="question36answers[]" id="question-36-answers-M" value="M" />
                                    <label for="question-36-answers-M"><span></span> Willingness to work on the ground / in the field  </label>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <input type="checkbox" name="question36answers[]" id="question-36-answers-N" value="N" />
                                    <label for="question-36-answers-N"><span></span> Execution ability / motivated by getting things done </label>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <input type="checkbox" name="question36answers[]" id="question-36-answers-O" value="O" />
                                    <label for="question-36-answers-O"><span></span> Ability to think on your feet</label>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <input type="checkbox" name="question36answers[]" id="question-36-answers-P" value="P" />
                                    <label for="question-36-answers-P"><span></span> Communication skills</label>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <input type="checkbox" name="question36answers[]" id="question-36-answers-Q" value="Q" />
                                    <label for="question-36-answers-Q"><span></span> Ability to convince and close deals / get commitment </label>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <input type="checkbox" name="question36answers[]" id="question-36-answers-R" value="R" />
                                    <label for="question-36-answers-R"><span></span> Tenacity / Persistence</label>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <input type="checkbox" name="question36answers[]" id="question-36-answers-S" value="S" />
                                    <label for="question-36-answers-S"><span></span> Enthusiasm and passion for work</label>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <input type="checkbox" name="question36answers[]" id="question-36-answers-T" value="T" />
                                    <label for="question-36-answers-T"><span></span> Flexibility - willingness to take on multiple hats and flexibility with regards to the type of work</label>
                                </div>
                            </div> <!-- end shuffle -->
                            </div> <!-- end row -->
                            </div> <!-- end container -->
                        </li>
                    </div>
                </ul>
                <div class="buttons">
                    <button type="button" class="btn btn-primary previous">Previous section</button>
                    <button type="button" class="btn btn-primary next">Next section</button>
                </div>
            </div>
            <!-- END TAB PANE6 -->

            <div class="tab-pane" id="seventh">
                <?php //Competency : Problem - Solving ?>
                <div class="scenario">
                    <h4>On your first day of work internship at Disney, you have been given a project to size the current market for Mickey Mouse soft toys in India. How will you approach the project</h4>
                </div>
                <ul class="form-group">
                    <div class="QuestionAnswer">
                        <li class="Question">
                            <h4>Which of the following would you need to use to calculate the above? (Select all that apply)</h4>
                        </li>
                        <li class="Answers"> <label for="question17answers[]" class="error"></label>
                            <div class="shuffle">
                            <div>
                                <input type="checkbox" name="question17answers[]" id="question-17-answers-A" value="A" />
                                <label for="question-17-answers-A"><span></span> The selling price of a Mickey Mouse soft toy </label>
                            </div>
                            <div>
                                <input type="checkbox" name="question17answers[]" id="question-17-answers-B" value="B" />
                                <label for="question-17-answers-B"><span></span> Industry growth</label>
                            </div>
                            <div>
                                <input type="checkbox" name="question17answers[]" id="question-17-answers-C" value="C" />
                                <label for="question-17-answers-C"><span></span> Competitors in the market</label>
                            </div>
                            <div>
                                <input type="checkbox" name="question17answers[]" id="question-17-answers-D" value="D" />
                                <label for="question-17-answers-D"><span></span> The number of children below the age of 8</label>
                            </div>
                            <div>
                                <input type="checkbox" name="question17answers[]" id="question-17-answers-E" value="E" />
                                <label for="question-17-answers-E"><span></span> The number of children below age 8 who like Mickey Mouse</label>
                            </div>
                            <div>
                                <input type="checkbox" name="question17answers[]" id="question-17-answers-F" value="F" />
                                <label for="question-17-answers-F"><span></span> The percentage of children below age 8 who can afford a soft toy</label>
                            </div>
                            </div>
                        </li>
                    </div>
                    <div class="QuestionAnswer">
                        <li class="Question">
                            <h4>What will most effectively drive profitability per soft-toy? </h4> 
                        </li>
                        <li class="Answers"> <label for="question18answers" class="error"></label>
                            <div>
                                <input type="radio" name="question18answers" id="question-18-answers-A" value="A" />
                                <label for="question-18-answers-A"><span><span></span></span>Increase the price</label>
                            </div>
                            <div>
                                <input type="radio" name="question18answers" id="question-18-answers-B" value="B" />
                                <label for="question-18-answers-B"><span><span></span></span>Decrease the cost </label>
                            </div>
                            <div>
                                <input type="radio" name="question18answers" id="question-18-answers-C" value="C" />
                                <label for="question-18-answers-C"><span><span></span></span>Increase the quantity</label>
                            </div>
                            <div>
                                <input type="radio" name="question18answers" id="question-18-answers-E" value="E" />
                                <label for="question-18-answers-E"><span><span></span></span>Increase the price and decrease the cost</label>
                            </div>
                            <div>
                                <input type="radio" name="question18answers" id="question-18-answers-D" value="D" />
                                <label for="question-18-answers-D"><span><span></span></span>All the above could work</label>
                            </div>
                        </li>
                    </div>
                </ul>
                <div class="buttons">
                    <button type="button" class="btn btn-primary previous">Previous section</button>
                    <button type="button" class="btn btn-primary next">Next section</button>
                </div>
            </div>
            <!-- END TAB PANE7 -->

            <div class="tab-pane" id="eighth">
                <?php //Competency : Grammar ?>          
                <ul class="form-group">
                    <div class = "QuestionAnswer">
                        <li class = "Question">
                            <h4>_____ such a pleasure to meet you Bob.</h4>
                        </li>
                        <li class = "Answers"> 
                            <label for="question19answers" class="error"></label>
                            <div class="shuffle">
                            <div>
                                <input type="radio" name="question19answers" id="question-19-answers-A" value="A" />
                                <label for="question-19-answers-A"><span><span></span></span> It's</label>
                            </div>
                            <div>
                                <input type="radio" name="question19answers" id="question-19-answers-B" value="B" />
                                <label for="question-19-answers-B"><span><span></span></span> Its </label>
                            </div>
                            </div>
                        </li>
                    </div>
                </ul>
                <ul class="form-group">
                    <div class = "QuestionAnswer">
                    <li class="Question">
                        <h4>For ______ did you stop the car?</h4>
                    </li>
                    <li class="Answers">
                    <label for="question20answers" class="error"></label>
                        <div class="shuffle">
                        <div>
                            <input type="radio" name="question20answers" id="question-20-answers-A" value="A" />
                            <label for="question-20-answers-A"><span><span></span></span> whom</label>
                        </div>
                        <div>
                            <input type="radio" name="question20answers" id="question-20-answers-B" value="B" />
                            <label for="question-20-answers-B"><span><span></span></span> who </label>
                        </div>
                        </div>
                    </li>
                    </div>

                    <div class="QuestionAnswer">
                        <li class="Question">
                            <h4>Choose the sentence that is grammatically correct </h4>
                        </li>
                        <li class="Answers"><label for="question21answers" class="error"></label>
                            <div class="shuffle">
                            <div>
                                <input type="radio" name="question21answers" id="question-21-answers-A" value="A" />
                                <label for="question-21-answers-A"><span><span></span></span> Our office, which has two lunchrooms, is located in Delhi.</label>
                            </div>
                            <div>
                                <input type="radio" name="question21answers" id="question-21-answers-B" value="B" />
                                <label for="question-21-answers-B"><span><span></span></span> Our office, that has two lunchrooms, is located in Delhi.  </label>
                            </div>
                            <div>
                                <input type="radio" name="question21answers" id="question-21-answers-C" value="C" />
                                <label for="question-21-answers-C"><span><span></span></span> Our office which has two lunchrooms is located in Delhi.</label>
                            </div>
                            </div>
                        </li>
                    </div>

                    <div class = "QuestionAnswer">
                        <li class = "Question">
                            <h4>Choose the sentence that is grammatically correct </h4>
                        </li>
                        <li class = "Answers"><label for="question22answers" class="error"></label>
                            <div class="shuffle">
                            <div>
                                <input type="radio" name="question22answers" id="question-22-answers-A" value="A" />
                                <label for="question-22-answers-A"><span><span></span></span> My mother likes dance and playing music. </label>
                            </div>
                            <div>
                                <input type="radio" name="question22answers" id="question-22-answers-B" value="B" />
                                <label for="question-22-answers-B"><span><span></span></span> My mother likes dancing and playing music. </label>
                            </div>
                            <div>
                                <input type="radio" name="question22answers" id="question-22-answers-C" value="C" />
                                <label for="question-22-answers-C"><span><span></span></span> My mother likes to dance and music.</label>
                            </div>
                            </div>
                        </li>
                    </div>

                    <div class = "QuestionAnswer">
                        <li class="Question">
                            <h4>Three weeks _______ passed since I sent the letter.</h4>
                        </li>
                        <li class="Answers"><label for="question23answers" class="error"></label>
                            <div class="shuffle">
                            <div>
                                <input type="radio" name="question23answers" id="question-23-answers-A" value="A" />
                                <label for="question-23-answers-A"><span><span></span></span> has </label>
                            </div>
                            <div>
                                <input type="radio" name="question23answers" id="question-23-answers-B" value="B" />
                                <label for="question-23-answers-B"><span><span></span></span> have </label>
                            </div>
                            </div>
                        </li>
                    </div>

                    <div class = "QuestionAnswer">
                        <li class = "Question"><h4>The Fairfield News ______ been published since 1923.</h4></li>
                        <li class = "Answers"><label for="question24answers" class="error"></label>
                            <div class="shuffle">
                            <div>
                                <input type="radio" name="question24answers" id="question-24-answers-A" value="A" />
                                <label for="question-24-answers-A"><span><span></span></span> has</label>
                            </div>
                            <div>
                                <input type="radio" name="question24answers" id="question-24-answers-B" value="B" />
                                <label for="question-24-answers-B"><span><span></span></span> have </label>
                            </div>
                            </div>
                        </li>
                    </div>
                    <div class = "QuestionAnswer">
                        <li class = "Question"><h4>I _________ the AGM on the following Monday</h4></li>
                        <li class = "Answers">
                            <label for="question25answers" class="error"></label>
                            <div class="shuffle">
                            <div>
                                <input type="radio" name="question25answers" id="question-25-answers-A" value="A"/>
                                <label for="question-25-answers-A"><span><span></span></span>will attend</label>
                            </div>
                            <div>
                                <input type="radio" name="question25answers" id="question-25-answers-B" value="B"/>
                                <label for="question-25-answers-B"><span><span></span></span>have attended</label>
                            </div>
                            <div>
                                <input type="radio" name="question25answers" id="question-25-answers-C" value="C"/>
                                <label for="question-25-answers-C"><span><span></span></span>attend</label>
                            </div>
                            <div>
                                <input type="radio" name="question25answers" id="question-25-answers-D" value="D"/>
                                <label for="question-25-answers-D"><span><span></span></span>would have been attending</label>
                            </div>
                            </div>
                        </li>
                    </div>
                    <div class = "QuestionAnswer">
                        <li class = "Question"><h4>Any feedback you can give me on this would be gratefully ________ .</h4></li>
                        <li class = "Answers">
                            <label for="question26answers" class="error"></label>
                            <div class="shuffle">
                            <div>
                                <input type="radio" name="question26answers" id="question-26-answers-A" value="A"/>
                                <label for="question-26-answers-A"><span><span></span></span>acceptable</label>
                            </div>
                            <div>
                                <input type="radio" name="question26answers" id="question-26-answers-B" value="B"/>
                                <label for="question-26-answers-B"><span><span></span></span>accepting</label>
                            </div>
                            <div>
                                <input type="radio" name="question26answers" id="question-26-answers-C" value="C"/>
                                <label for="question-26-answers-C"><span><span></span></span>accepted</label>
                            </div>
                            <div>
                                <input type="radio" name="question26answers" id="question-26-answers-D" value="D"/>
                                <label for="question-26-answers-D"><span><span></span></span>being accepted</label>
                            </div>
                            </div>
                        </li>
                    </div>
                    <div class = "scenario"><h4><u> Pick the sentence with the correct punctuation</u></h4></div>
                    <div class = "QuestionAnswer">
                        <li class="Question"><h4>We submitted the proposal last week, however, we have not received approval yet.</h4></li>
                        <li class="Answers">
                        <label for="question27answers" class="error"></label>
                            <div class="shuffle">
                            <div>
                                <input type="radio" name="question27answers" id="question-27-answers-A" value="A"/>
                                <label for="question-27-answers-A"><span><span></span></span>We have not received approval yet. However, we submitted the proposal last week.</label>
                            </div>
                            <div>
                                <input type="radio" name="question27answers" id="question-27-answers-B" value="B"/>
                                <label for="question-27-answers-B"><span><span></span></span>We had submitted the proposal last week, however, we have not yet received approval.</label>
                            </div>
                            <div>
                                <input type="radio" name="question27answers" id="question-27-answers-C" value="C"/>
                                <label for="question-27-answers-C"><span><span></span></span>We submitted the proposal last week. However, we have not received approval yet.</label>
                            </div>
                            <div>
                                <input type="radio" name="question27answers" id="question-27-answers-D" value="D"/>
                                <label for="question-27-answers-D"><span><span></span></span>We submitted the proposal last week however, we have not received approval yet.</label>
                            </div>
                            </div>
                        </li>
                    </div>
                    <div class = "QuestionAnswer">
                        <li class = "Question"><h4>Here are the winners: Michael Grace, Accounting, Davida Banks, Finance, and Elray Davis, Member Services.</h4></li>
                        <li class = "Answers">
                        <label for="question28answers" class="error"></label>
                            <div class="shuffle">
                            <div>
                                <input type="radio" name="question28answers" id="question-28-answers-A" value="A"/>
                                <label for="question-28-answers-A"><span><span></span></span>Here are the winners: Michael Grace- Accounting, David Banks- Finance, Elray Davis- Member Services.</label>
                            </div>
                            <div>
                                <input type="radio" name="question28answers" id="question-28-answers-B" value="B"/>
                                <label for="question-28-answers-B"><span><span></span></span>Here are the winners: Michael Grace, Accounting; Davida Banks, Finance; and Elray Davis, Member Services.</label>
                            </div>
                            <div>
                                <input type="radio" name="question28answers" id="question-28-answers-C" value="C"/>
                                <label for="question-28-answers-C"><span><span></span></span>Here are the winners: Michael Grace for accounting, Davida Banks for finance and Elray Davis for member services.</label>
                            </div>
                            <div>
                                <input type="radio" name="question28answers" id="question-28-answers-D" value="D"/>
                                <label for="question-28-answers-D"><span><span></span></span>Here are the winners; Michael Grace in accounting, David Banks in finance and Elray Davis in member services.</label>
                            </div>
                            </div>
                        </li>
                    </div>
                    <div class = "scenario"><h4><u>Convert sentences in passive voice to active voice </u></h4></div>
                    <div class="QuestionAnswer">
                        <li class = "Question"><h4>The report will be reviewed by the supervisor before it is sent to the manager.</h4></li>
                        <li class = "Answers">
                        <label for="question29answers" class="error"></label>
                            <div class="shuffle">
                            <div>
                                <input type="radio" name="question29answers" id="question-29-answers-A" value="A"/>
                                <label for="question-29-answers-A"><span><span></span></span>The report is being reviewed by the supervisor before it is sent the manager.</label>
                            </div>
                            <div>
                                <input type="radio" name="question29answers" id="question-29-answers-B" value="B"/>
                                <label for="question-29-answers-B"><span><span></span></span>Before the report is sent to the manager, the supervisor will review it.</label>
                            </div>
                            <div>
                                <input type="radio" name="question29answers" id="question-29-answers-C" value="C"/>
                                <label for="question-29-answers-C"><span><span></span></span>Before it is sent to the manager, the report will be reviewed by the supervisor.</label>
                            </div>
                            <div>
                                <input type="radio" name="question29answers" id="question-29-answers-D" value="D"/>
                                <label for="question-29-answers-D"><span><span></span></span>The supervisor will review the report before he sends it to the manager.</label>
                            </div>
                            </div>
                        </li>
                    </div>
                    <div class="QuestionAnswer">
                        <li class = "Question"><h4>Can the e-mail that contained the 6 tasks allocated to me be sent to me?</h4></li>
                        <li class = "Answers">
                        <label for="question30answers" class="error"></label>
                            <div class="shuffle">
                            <div>
                                <input type="radio" name="question30answers" id="question-30-answers-A" value="A"/>
                                <label for="question-30-answers-A"><span><span></span></span>Is it possible for the e-mail that contained 6 tasks, allocated to me, be sent to me?</label>
                            </div>
                            <div>
                                <input type="radio" name="question30answers" id="question-30-answers-B" value="B"/>
                                <label for="question-30-answers-B"><span><span></span></span>Can you send me the e-mail containing the 6 tasks allocated to me?</label>
                            </div>
                            <div>
                                <input type="radio" name="question30answers" id="question-30-answers-C" value="C"/>
                                <label for="question-30-answers-C"><span><span></span></span>Can the e-mail that contained 6 tasks allocated to me be sent?</label>
                            </div>
                            <div>
                                <input type="radio" name="question30answers" id="question-30-answers-D" value="D"/>
                                <label for="question-30-answers-D"><span><span></span></span>Can the email allocated to me be sent to me containing all the 6 tasks?</label>
                            </div>
                            </div>
                        </li>
                    </div>
                    <div class = "scenario"><h4><u> Fill in the right prepositions</u></h4></div>
                    <div class="QuestionAnswer" id="prepositions">
                    <label for="question30answersA" class="error fib"></label>
                    <label for="question30answersB" class="error fib"></label>
                    <label for="question30answersC" class="error fib"></label>
                    <label for="question30answersD" class="error fib"></label>
                    <label for="question30answersE" class="error fib"></label>
                        <li class = "Question"><h4>I work <span><input type="text" name="question30answersA" class="fibprep"/></span> a food wholesaler.  Our head office is <span><input type="text" name="question30answersB" class="fibprep"/></span> Norway.  We export farm produce <span><input type="text" name="question30answersC" class="fibprep"/></span> South East Asia and the Pacific Region. I’m responsible <span><input type="text" name="question30answersD" class="fibprep"/></span> finding new markets or products for the company.  I usually start work <span><input type="text" name="question30answersE" class="fibprep"/></span> 9 am.</h4></li>
                    </div>
                    <div class="QuestionAnswer">
                        <li class = "Question"><h4> I work ________ 10 and 12 hours a day.</h4></li>
                        <li class = "Answers">
                        <label for="question30answersF" class="error"></label>
                            <div class="shuffle">
                            <div>
                                <input type="radio" name="question30answersF" id="question-30F-answers-A" value="A"/>
                                <label for="question-30F-answers-A"><span><span></span></span>among</label>
                            </div>
                            <div>
                                <input type="radio" name="question30answersF" id="question-30F-answers-B" value="B"/>
                                <label for="question-30F-answers-B"><span><span></span></span>between</label>
                            </div>
                            <div>
                                <input type="radio" name="question30answersF" id="question-30F-answers-C" value="C"/>
                                <label for="question-30F-answers-C"><span><span></span></span>amongst</label>
                            </div>
                            <div>
                                <input type="radio" name="question30answersF" id="question-30F-answers-D" value="D"/>
                                <label for="question-30F-answers-D"><span><span></span></span>by</label>
                            </div>
                            </div>
                        </li>
                    </div>
                </ul>
                <div class="buttons">
                        <button type="button" class="btn btn-primary previous">Previous section</button>
                        <button type="button" class="btn btn-primary next">Next section</button>
                    </div>
            </div>
            <!-- END TAB PANE8 -->

            <div class="tab-pane" id="ninth">
               <?php  //Competency : Ethics  ?>
                <div class="scenario">
                    <h4>You have been asked to share some slides with a client. On checking the data behind the slides you realize that the slides are misrepresenting profitability. You speak to your manager about it but he feels that at this stage it’s more important to get the client business and it’s okay to exaggerate the numbers slightly.</h4>
                </div>
                <ul class="form-group">
                    <div class="QuestionAnswer">
                        <li class="Question">
                            <h4> You would: </h4> </li>
                        <li class="Answers"> <label for="question31answers" class="error"></label>
                            <div class="shuffle">
                            <div>
                                <input type="radio" name="question31answers" id="question-31-answers-A" value="A" />
                                <label for="question-31-answers-A"><span><span></span></span> Trust your manager’s opinion and do nothing – stay calm and let it tide over </label>
                            </div>
                            <div>
                                <input type="radio" name="question31answers" id="question-31-answers-B" value="B" />
                                <label for="question-31-answers-B"><span><span></span></span> Go to the supervisor (your manager’s boss) at the risk of getting into trouble with your manager </label>
                            </div>
                            <div>
                                <input type="radio" name="question31answers" id="question-31-answers-C" value="C" />
                                <label for="question-31-answers-C"><span><span></span></span> Feel stressed and guilty but do nothing – it’s not your responsibility to do something  </label>
                            </div>
                            <div>
                                <input type="radio" name="question31answers" id="question-31-answers-D" value="D" />
                                <label for="question-31-answers-D"><span><span></span></span> Resign – you don’t want to be part of an organization with people who misrepresent data </label>
                            </div>
                            </div>
                        </li>
                    </div>
                </ul>
                
                <div class="scenario">
                        <h4> Your team has returned from a work trip in Sikkim and you need to submit an expense log to the HR head. You notice that your colleague has misreported his travel expenses. This colleague is your best friend at and outside work.</h4>
                </div>
                <ul class="form-group">
                    <div class="QuestionAnswer">
                        <li class="Question">
                            <h4>What is your dilemma between?</h4> </li>
                        <li class="Answers"> <label for="question33answers" class="error"></label>
                            <div class="shuffle">
                            <div>
                                <input type="radio" name="question33answers" id="question-33-answers-A" value="A" />
                                <label for="question-33-answers-A"><span><span></span></span> Owing loyalty to the firm and owing loyalty to the colleague.</label>
                            </div>
                            <div>
                                <input type="radio" name="question33answers" id="question-33-answers-B" value="B" />
                                <label for="question-33-answers-B"><span><span></span></span> Misreporting the expenses and lying to the firm.</label>
                            </div>
                            </div>
                        </li>
                    </div>
                    <div class="QuestionAnswer">
                        <li class="Question">
                            <h4> How would you react in this situation?</h4> </li>
                        <li class="Answers"> <label for="question34answers" class="error"></label>
                            <div class="shuffle">
                            <div>
                                <input type="radio" name="question34answers" id="question-34-answers-A" value="A" />
                                <label for="question-34-answers-A"><span><span></span></span> Approach the colleague and have a chat with him to own up </label>
                            </div>
                            <div>
                                <input type="radio" name="question34answers" id="question-34-answers-B" value="B" />
                                <label for="question-34-answers-B"><span><span></span></span> Go to the supervisor at the risk of jeopardizing your relationship with your colleague </label>
                            </div>
                            <div>
                                <input type="radio" name="question34answers" id="question-34-answers-C" value="C" />
                                <label for="question-34-answers-C"><span><span></span></span> Feel stressed and guilty but do nothing – it’s not your responsibility</label>
                            </div>
                            </div>
                        </li>
                    </div>
                </ul>

                <div class="scenario" style="margin-top:7%; border-width:medium">
                    <div style="padding-left:0">
                        <div>
                            <label for="agree" class="error"></label>
                        </div>
                        <div style="margin-left: 40px;">
                            <input type="checkbox" name="agree" id="agree" />
                            <label for="agree"><span></span>I have not given nor received any unauthorized aid on this test.</label>
                        </div>
                       <!--  <div style="margin-left: 40px;">
                           <input type="checkbox" name="industryconn" id="industryconn">
                           <label for="industryconn"><span></span>Are you interested in Industry Connect? (Industry Connect is a module of Talerang Express through which we connect you to Corporate partners for internships and full time opportunities after review of your references and resume)
                           <br>
                           If you are interested, submit two references and your resume and video essay(optional) in the Industry Connect section of Talerang Express.
                           </label>
                       </div> -->
                    </div>
                </div>
                <div class="buttons">
                    <button type="button" class="btn btn-primary previous">Previous section</button>
                    <label class="error" for="submit"></label>
                    <input name="wrap-submit" class="btn btn-primary btn-success" id="submit" type="submit" value="Submit" onclick="return confirm('Are you sure you want to submit?')"/>
                    <input name="wrap-submit" class="btn btn-primary btn-success displaynone" id="submit2" type="submit" value="Submit" formnovalidate="formnovalidate"/>
                </div>
            </div>
                <!-- END TAB PANE9 -->
            </div> <!-- END TAB CONTENT -->
            </form>
        </div>
        <!-- END PAGE WRAP -->
        
        <?php endif //session useremail isset ?>
        <?php include 'footer.php' ?>
    </div>
    <!--  END PAGE CONTAINER  -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.1/jquery.validate.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/javascripts.js?version=1.1"></script>
    <!-- INCLUDES validation,touch punch,text counter,rotate,shuffle,timer,are you sure? -->
</body>
</html>