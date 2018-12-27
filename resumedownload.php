<?php session_start();
/*********************************Fetching Data********************************/
require 'connectsql.php';

if(!(isset($_SESSION['useremail']) || isset($_SESSION['adminuser'])))
    header('location:index.php');

if(!(isset($_GET['user']) || isset($_GET['admindl'])))
    header('location:index.php');

if(isset($_GET['user']))
$resumeid=$_SESSION['accountno'];

if(isset($_GET['admindl'])) $resumeid=$_GET['account'];

$sql="SELECT * FROM `resume` WHERE `resumeid`='$resumeid';";
$ra=mysqli_query($DBcon,$sql);
//Check if resume exists
$resexists=mysqli_num_rows($ra);
//Store in array $ra
$ra=mysqli_fetch_assoc($ra);

if(!$resexists) exit;

//Getting all the variables
$firstname=$ra['firstname'];
$lastname=$ra['lastname'];
$mobileno=$ra['mobileno'];
$emailid=$ra['email'];
$address=explode('<br>', $ra['address']); 
$addressfull="";
for($i=0;$i<count($address);$i++)
{   
    if($address[$i]=="") continue;
    if(substr($address[$i],-1)==',')
    $addressfull.=$address[$i]." ";
    else $addressfull.=$address[$i].", ";
}
$addressfull=trim($addressfull);
if(substr($addressfull,-1)==',') 
$addressfull=substr($addressfull,0,strlen($addressfull)-1);

$city=trim($ra['city']);
$pincode=trim($ra['pincode']);
$country=trim($ra['country']);
if($addressfull!==""&&$city!=""&&$country!="")
$addressfull.=', '.$city.' - '.$pincode.', '.$country.'.';
elseif($city!=""&&$country!="")
$addressfull=$city.' - '.$pincode.', '.$country.'.';

$schoolname=explode('<br>', $ra['schoolname']);
$schoolcity=explode('<br>',$ra['schoolcity']);
$schoolcourse=explode('<br>',$ra['schoolcourse']);
$schoolyear=explode('<br>',$ra['schoolyear']);
$schoolmarks=explode('<br>',$ra['schoolmarks']);
if($ra['workcompany']!=='noworkex')
{
    $workco=explode('<br>',$ra['workcompany']);
    $workdes=explode('<br>',$ra['workdes']);
    $workstart=explode('<br>',$ra['workstart']);
    $workend=explode('<br>',$ra['workend']);
    $workresp=explode('//',$ra['workresp']);
    for($i=0;$i<count($workresp);$i++) $workresp[$i]=explode('<br>',$workresp[$i]);
}
$leadername=explode('<br>',$ra['leadername']);
$leaderdesc=explode('//',$ra['leaderdesc']);
for($i=0;$i<count($leaderdesc);$i++) $leaderdesc[$i]=explode('<br>',$leaderdesc[$i]);
$skills=explode('<br>',$ra['skills']);

function output_clean($str)
{
    $str=str_replace('&quot;','"', $str);
    $str=str_replace('&#x27;',"'",$str);
    $str=htmlentities($str);
    return $str;
}

for ($i=0; $i < count($schoolname) ; $i++)   $schoolname[$i]=output_clean($schoolname[$i]); 
for ($i=0; $i < count($schoolcity) ; $i++)   $schoolcity[$i]=output_clean($schoolcity[$i]);
for ($i=0; $i < count($schoolcourse) ; $i++) $schoolcourse[$i]=output_clean($schoolcourse[$i]);
for ($i=0; $i < count($schoolmarks) ; $i++)  $schoolmarks[$i]=output_clean($schoolmarks[$i]);
if($ra['workcompany']!=='noworkex')
{
    for ($i=0; $i < count($workco) ; $i++)       $workco[$i]=output_clean($workco[$i]);
    for ($i=0; $i < count($workdes) ; $i++)      $workdes[$i]=output_clean($workdes[$i]);
    for ($i=0; $i < count($workresp); $i++)   for($j=0; $j < count($workresp[$i]); $j++)  
        $workresp[$i][$j]=output_clean($workresp[$i][$j]); 
}
for ($i=0; $i < count($leadername); $i++)    $leadername[$i]=output_clean($leadername[$i]);
for ($i=0; $i < count($leaderdesc); $i++) for($j=0; $j < count($leaderdesc[$i]); $j++)
    $leaderdesc[$i][$j]=output_clean($leaderdesc[$i][$j]);
for ($i=0; $i < count($skills); $i++) $skills[$i]=output_clean($skills[$i]);
/*********************************Fetching Data********************************/
/********************************Invoke PHPWord********************************/
// Creating the resume...
require 'vendor/autoload.php';
$phpWord = new \PhpOffice\PhpWord\PhpWord();
/********************************Invoke PHPWord********************************/
/************************************Styles************************************/
$marginv=\PhpOffice\PhpWord\Shared\Converter::cmToTwip(1.25); //given in cm
$marginh=\PhpOffice\PhpWord\Shared\Converter::cmToTwip(1.25); //given in cm
$sectionStyle=array('marginTop'=>$marginv,'marginRight'=>$marginh,'marginBottom'=>$marginv,'marginLeft'=>$marginh);

$section = $phpWord->addSection($sectionStyle);

$section_style = $section->getStyle(); 
$position = $section_style->getPageSizeW() - $section_style->getMarginRight() - $section_style->getMarginLeft();
/*echo $position; exit;*/

$spaceAfter=4;//space given in pts
$spaceAfter*=20;//convert to twips
$spaceBefore=$spaceAfter;
$trparastyle0=array("tabs" => array(new \PhpOffice\PhpWord\Style\Tab("right", $position)) , "spaceAfter"=>'0','lineHeight'=>'1.0');
$trparastyle1=array("tabs" => array(new \PhpOffice\PhpWord\Style\Tab("right", $position)) , "spaceAfter"=>$spaceAfter,'lineHeight'=>'1.0');
$spaceAfter*=2;
$trparastyle2=array("tabs" => array(new \PhpOffice\PhpWord\Style\Tab("right", $position)) , "spaceAfter"=>$spaceAfter,'lineHeight'=>'1.0');
$trparastyle3=array("tabs" => array(new \PhpOffice\PhpWord\Style\Tab("right", $position)) , "spaceAfter"=>'0','spaceBefore'=>$spaceBefore,'lineHeight'=>'1.0');

$fontName='Calibri';
$phpWord->addFontStyle('ResumeStyle',array('name' => $fontName, 'size' => 11, 'color' => '000000', 'bold' => false) );
$phpWord->addFontStyle('ResumeStyleUS',array('name' => $fontName, 'size' => 4, 'color' => '000000', 'bold' => false, 'underline'=>'single') );
$phpWord->addFontStyle('ResumeStyleB',array('name' => $fontName, 'size' => 11, 'color' => '000000', 'bold' => true) );
$phpWord->addFontStyle('ResumeStyleI',array('name' => $fontName, 'size' => 11, 'color' => '000000', 'italic' => true) );
$phpWord->addFontStyle('ResumeStyleBM',array('name' => $fontName, 'size' => 14, 'color' => '000000', 'bold' => true ,'spaceAfter'=>'0'));
$phpWord->addFontStyle('ResumeStyleUBM',array('name' => $fontName, 'size' => 14, 'color' => '000000', 'bold' => true , 'underline' => 'single' ,'spaceAfter'=>'0'));
$phpWord->addFontStyle('ResumeStyleBL',array('name' => $fontName, 'size' => 16, 'color' => '000000', 'bold' => true) );
$linestyle = array('weight' => 0,'spaceAfter'=>'0', 'width' => 695, 'height' => 0, 'color'=>'000000');
$parastyle = array('lineHeight'=>'1.0','spaceAfter'=>'0');
$parastyle0 = array('lineHeight'=>'0','spaceAfter'=>'0');
$styleTable = array('borderSize'=>0, 'borderColor'=>'FFFFFF');
$styleFirstRow = array('borderBottomSize'=>1, 'borderBottomColor'=>'000000');
$phpWord->addTableStyle('myTableStyle', $styleTable, $styleFirstRow);
$cellLength=15500;
/************************************Styles************************************/
/********************************Creating Resume Object***************************/

$section->addText(strtoupper($firstname)." ".strtoupper($lastname),'ResumeStyleBL',$parastyle);
$section->addText($mobileno.' | '.$emailid,'ResumeStyle',$parastyle);
//$section->addText(,'ResumeStyle',$parastyle);
$section->addText($addressfull,'ResumeStyle',$parastyle);
$section->addText('','ResumeStyle',$parastyle);
//Education

$table=$section->addTable('myTableStyle');
$table->addRow();
$table->addCell($cellLength)->addText('EDUCATION','ResumeStyleBM',$parastyle);

for($i=0;$i<count($schoolname);$i++)
{   
    if(($i+1)==count($schoolname))
    $textrun = $section->addTextRun($trparastyle3);
    else
    $textrun = $section->addTextRun($trparastyle3);
    $textrun->addText($schoolname[$i].", ".$schoolcity[$i],'ResumeStyleB');
    $textrun->addText(" | ",'ResumeStyle');
    $textrun->addText($schoolcourse[$i]." (".$schoolmarks[$i].")",'ResumeStyleI');
    $textrun->addText("\t".$schoolyear[$i],'ResumeStyleB');
}
$section->addText('','ResumeStyle',$parastyle);
//Work Ex
if($ra['workcompany']!=='noworkex')
{
    $table=$section->addTable('myTableStyle');
    $table->addRow();
    $table->addCell($cellLength)->addText('WORK EXPERIENCE','ResumeStyleBM',$parastyle);
    for($i=0;$i<count($workco);$i++)
    {
        $textrun = $section->addTextRun($trparastyle3);
        $textrun->addText($workco[$i], 'ResumeStyleB');
        $textrun->addText(' | ', 'ResumeStyle');
        $textrun->addText($workdes[$i],'ResumeStyleI');
        $textrun->addText("\t".$workstart[$i].' - '.$workend[$i], 'ResumeStyleB');
        //$section->addText($workdes[$i],'ResumeStyleI',$parastyle);

        for($j=0;$j<count($workresp[$i]);$j++)
        {
            $workbullet=$workresp[$i][$j];
            if($workbullet!="")
            $section->addListItem($workbullet,0,'ResumeStyle',array('format'=>'bullet'),$parastyle);
        }  
    }
$section->addText('','',$parastyle);
}

//Leadership Experience
$table=$section->addTable('myTableStyle');
$table->addRow();
$table->addCell($cellLength)->addText('LEADERSHIP EXPERIENCE','ResumeStyleBM',$parastyle);
for($i=0;$i<count($leadername);$i++)
{
    $section->addText($leadername[$i],'ResumeStyleB',$trparastyle3);
    for($j=0;$j<count($leaderdesc[$i]);$j++)
    {
        $ldrbullet=$leaderdesc[$i][$j];
        if($ldrbullet!="")
        $section->addListItem($ldrbullet,0,'ResumeStyle',array('format'=>'bullet'),$parastyle);
    }
}
//Skills and Interests
$section->addText('','',$parastyle);
$table=$section->addTable('myTableStyle');
$table->addRow();
$table->addCell($cellLength)->addText('SKILLS AND INTERESTS','ResumeStyleBM',$parastyle);
for ($i=0; $i <count($skills) ; $i++) 
{
    if($i!=0)
    $section->addListItem($skills[$i],0,'ResumeStyle',array('format'=>'bullet'),$parastyle);
    else
    $section->addListItem($skills[$i],0,'ResumeStyle',array('format'=>'bullet'),$trparastyle3);
}
/********************************Creating Resume Object***************************/
/*************************Saving the file as download*************************/
$filename = $firstname.'_'.$lastname.'_Resume';
$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
$extension='.docx';
$objWriter->save($filename.$extension);
header('Content-Type: application/octet-stream');
header('Content-Description: File Transfer');
header('Content-Disposition: attachment; filename='.$filename.$extension);
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');
header('Content-Length: '.filesize($filename.$extension));

flush();

readfile($filename.$extension);
unlink($filename.$extension); // deletes the temporary file
exit;
?>