<?php 
echo levenshtein('aagtgcttagcccag', '').'<br>';
echo levenshtein('aagtgcttagcccag', 'a').'<br>';
echo levenshtein('aagtgcttagcccag', 'at').'<br>';
echo levenshtein('aagtgcttagcccag', 'atg').'<br>';
echo levenshtein('aagtgcttagcccag', 'atgc').'<br>';
echo levenshtein('aagtgcttagcccag', 'atgcg').'<br>';
echo levenshtein('aagtgcttagcccag', 'atgcgc').'<br>';
echo levenshtein('aagtgcttagcccag', 'atgcgct').'<br>';
echo levenshtein('aagtgcttagcccag', 'atgcgcta').'<br>';
echo levenshtein('aagtgcttagcccag', 'atgcgctaa').'<br>';
echo levenshtein('aagtgcttagcccag', 'atgcgctaac').'<br>';
echo levenshtein('aagtgcttagcccag', 'atgcgctaacc').'<br>';
echo levenshtein('aagtgcttagcccag', 'atgcgctaacct').'<br>';
echo levenshtein('aagtgcttagcccag', 'atgcgctaaccta').'<br>';
echo levenshtein('aagtgcttagcccag', 'atgcgctaacctca').'<br>';
exit;
/************************Calculate Feedback Ratings************************/
require 'connectsql.php';
$result=mysqli_query($DBcon,"SELECT `rating` FROM `feedback`;");
$total=0;
while($row=mysqli_fetch_row($result)) $total+=substr($row[0],0,1);
echo 'Feedback Rating - '.round($total/mysqli_num_rows($result),2)."/5";
exit; ?>
/************************Calculate Feedback Ratings************************/<?php
/*
create simple homepage
update link for webinar
*/
exit;
$confirmed=array('a','b','c','d','b','c','d','e');
for ($i=0; $i < count($confirmed); $i++) 
    if($confirmed[$i]=='b')
        unset($confirmed[$i]);
$confirmed=implode(',',$confirmed);
var_dump($confirmed);
exit;
require 'connectsql.php';
$result=mysqli_query($DBcon,"SELECT * FROM `results`;");
$selfbelief=0;
$selfaware=0;
$professionalism=0;
$businesscomm=0;
$profaware=0;
$prioritization=0;
$probsolve=0;
$grammar=0;
$ethics=0;

$num_rows=mysqli_num_rows($result);
while($row=mysqli_fetch_assoc($result))
{
    $selfbelief+=$row['selfbelief'];
    $selfaware+=$row['selfaware'];
    $professionalism+=$row['professionalism'];
    $businesscomm+=$row['businesscomm'];
    $profaware+=$row['profaware'];
    $prioritization+=$row['prioritization'];
    $probsolve+=$row['probsolve'];
    $grammar+=$row['grammar'];
    $ethics+=$row['ethics'];
}

$selfbelief=round($selfbelief/$num_rows,2);
$selfaware=round($selfaware/$num_rows,2);
$professionalism=round($professionalism/$num_rows,2);
$businesscomm=round($businesscomm/$num_rows,2);
$profaware=round($profaware/$num_rows,2);
$prioritization=round($prioritization/$num_rows,2);
$probsolve=round($probsolve/$num_rows,2);
$grammar=round($grammar/$num_rows,2);
$ethics=round($ethics/$num_rows,2);

//echo 'selfbelief - '.$selfbelief.'<br>selfaware - '.$selfaware.'<br>professionalism - '.$professionalism.'<br>businesscomm - '.$businesscomm.'<br>profaware - '.$profaware.'<br>prioritization - '.$prioritization.'<br>probsolve - '.$probsolve.'<br>grammar - '.$grammar.'<br>ethics - '.$ethics;
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.bundle.min.js"></script> -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.min.js"></script>
</head>
<body>
<div class="container">
 <canvas id="myChart" style="max-width: 100%; "></canvas>   
</div>
 <script type="text/javascript">
    var ctx = document.getElementById("myChart");
    var mixedChart = new Chart(ctx, {
      type: 'bar',
      data: {
        datasets: [{
              label: 'You',
              borderColor: '#27215b',
              backgroundColor: '#27215b',
              lineTension: 0,
              fill: false,
              data: [10, 20, 30, 40, 10, 20, 30, 40, 70]
            }, {
              label: 'Average',
              borderColor: '#bd2325',
              backgroundColor: '#bd2325',
              lineTension: 0,
              fill: false,
              data: [<?php echo implode(',',array($selfbelief,$selfaware,$professionalism,$businesscomm,$profaware,$prioritization,$probsolve,$grammar,$ethics)); ?>],
            }],
        labels: ['Self Belief','Self Aware','Professionalism','B. Communication','Prof. Awareness','Prioritization','Prob. Solving','Grammar','Ethics']
      },
      options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
      }
    });
</script>
</body>
</html>
<?php 
exit;

?>
<?php
require 'connectsql.php';
$result=mysqli_query($DBcon,"SELECT * FROM `teststart`");
while($row=mysqli_fetch_assoc($result))
{
    $id=$row['id'];
    $email=$row['email'];
    $acc=mysqli_fetch_assoc(mysqli_query($DBcon,"SELECT `accountno` FROM `register` WHERE `email`='$email';"));
    $acc=$acc['accountno'];
    $sql="UPDATE `teststart` SET `accountno`='$acc' WHERE `id`='$id';<br>";
    echo $sql;
}
exit;
?>
<?php

//CLEAN UP `signin` table
// DELETE FROM `signin` WHERE `email`='azeem@a.com' OR `email`='azeem_merchant999@hotmail.com' OR `email`='azeem.talerang@gmail.com' OR `email`='azeemm94@gmail.com' OR `email`='azeem@p.com'; SET @i=0; UPDATE `signin` SET `id`=(@i:=@i+1); ALTER TABLE `signin` AUTO_INCREMENT = 1;

//SET @i=0; UPDATE `register` SET `id`=(@i:=@i+1); ALTER TABLE `register` AUTO_INCREMENT = 1;
//SET @i=0; UPDATE `results` SET `id`=(@i:=@i+1); ALTER TABLE `results` AUTO_INCREMENT = 1;

//SELECT * FROM `register` RIGHT JOIN `resume` ON `register`.`accountno` = `resume`.`resumeid`; 

/*  echo "<table>";foreach ($_POST as $key => $value) echo "<tr><td>".$key."</td><td>".$value."</td></tr>"; echo "</table>";*/


//Resume tool list
//SELECT  `register`.`firstname` ,  `register`.`lastname` ,  `register`.`email` FROM  `register` INNER JOIN  `resume` ON  `register`.`accountno` =  `resume`.`resumeid` 
?>
<?php 
//***************************Displays server variables in table***************************
$indicesServer = array('PHP_SELF', 'argv', 'argc', 'GATEWAY_INTERFACE', 'SERVER_ADDR', 'SERVER_NAME', 'SERVER_SOFTWARE', 'SERVER_PROTOCOL', 'REQUEST_METHOD', 'REQUEST_TIME', 'REQUEST_TIME_FLOAT', 'QUERY_STRING', 'DOCUMENT_ROOT', 'HTTP_ACCEPT', 'HTTP_ACCEPT_CHARSET', 'HTTP_ACCEPT_ENCODING', 'HTTP_ACCEPT_LANGUAGE', 'HTTP_CONNECTION', 'HTTP_HOST', 'HTTP_REFERER', 'HTTP_USER_AGENT', 'HTTPS', 'REMOTE_ADDR', 'REMOTE_HOST', 'REMOTE_PORT', 'REMOTE_USER', 'REDIRECT_REMOTE_USER', 'SCRIPT_FILENAME', 'SERVER_ADMIN', 'SERVER_PORT', 'SERVER_SIGNATURE', 'PATH_TRANSLATED', 'SCRIPT_NAME', 'REQUEST_URI', 'PHP_AUTH_DIGEST', 'PHP_AUTH_USER', 'PHP_AUTH_PW', 'AUTH_TYPE', 'PATH_INFO', 'ORIG_PATH_INFO') ; 
sort($indicesServer);
echo '<table cellpadding="10">'; 
foreach ($indicesServer as $arg) 
{ 
    if (isset($_SERVER[$arg])) 
    echo '<tr><td>'.$arg.'</td><td>'.$_SERVER[$arg].'</td></tr>'; 
    else 
    echo '<tr><td>'.$arg.'</td><td>-</td></tr>'; 
} 
echo '</table>';
exit;
//***************************Displays server variables in table***************************
?>
<?php
require 'connectsql.php';
$result=mysqli_query($DBcon,"SELECT * FROM `results`;");
while ($row=mysqli_fetch_assoc($result)) 
{
    $email=$row['email'];
    $id=$row['id'];
    $accountno=mysqli_fetch_assoc(mysqli_query($DBcon,"SELECT `accountno` FROM `register` WHERE `email`='$email' LIMIT 1;"));
    $accountno=$accountno['accountno'];

    echo "UPDATE `results` SET `accountno`='$accountno' WHERE `id`='$id';"."<br>";
}
exit;
?>
<?php
//***********************GENERATING RANDOM IDS**************************************
function getrandom()
{
    $chars = "123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"; $res = "";
    for ($j=0;$j<10; $j++) $res .= $chars[mt_rand(0, strlen($chars)-1)];
    return $res;
}
function generate_id(){
    require 'connectsql.php';
    $notgenerated=true;
    $random="";

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
?>