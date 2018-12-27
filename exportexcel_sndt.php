<?php session_start();
if(!isset($_SESSION['adminuser'])) { header('location:adminlogin.php'); exit; }
date_default_timezone_set('Asia/Kolkata');
require_once "vendor/phpoffice/phpexcel/Classes/PHPExcel.php";
$ea = new PHPExcel(); 
ob_start();
$ea->getProperties()
  ->setCreator('Azeem Merchant')
  ->setLastModifiedBy('Azeem Merchant')
  ->setTitle('SNDT Registerations');

$ews = $ea->getSheet(0);
$ews->setTitle('Registrations');

$titles = array("ID", "First Name", "Last Name", "Email", "Country", "Phone No", "College", "About Us", "Registration Time", "Active", "Intro","PRN","School Name","Degree","Course","Year","Job?","Skill tracks","Rationale for skill track","Preferred City","Salary Exp","Life Goals","Any extra info?","Account No");
for($i=0,$col='A'; $i<count($titles); $i++,$col++)
$ews->setCellValue($col.'1', $titles[$i]);

$rowCount = 3; 

require 'connectsql.php';
$sql = "SELECT * FROM `register` ORDER BY id DESC LIMIT 10000";  
$result = mysqli_query($DBcon, $sql);
$sndtemails=array();
  
while($row = mysqli_fetch_assoc($result))  
{  
    if($row["college"]!='SNDT University') continue;

    array_push($sndtemails,$row['email']);
    $accountno=$row["accountno"];
    $sql="SELECT * FROM `sndt` WHERE `accountno`='$accountno' LIMIT 1;";
    $sndtrow=mysqli_fetch_assoc(mysqli_query($DBcon,$sql));

    $ews->setCellValue('A'.$rowCount,$row["id"]);
    $ews->setCellValue('B'.$rowCount,$row["firstname"]);
    $ews->setCellValue('C'.$rowCount,$row["lastname"]);
    $ews->setCellValue('D'.$rowCount,$row["email"]);
    $ews->setCellValue('E'.$rowCount,$row["country"]);
    $ews->setCellValueExplicit('F'.$rowCount,$row["phoneno"],PHPExcel_Cell_DataType::TYPE_STRING);
    $ews->setCellValue('G'.$rowCount,$row["college"]);
    $ews->setCellValue('H'.$rowCount,$row["aboutus"]);
    $ews->setCellValue('I'.$rowCount,$row["regtime"]);
    $ews->setCellValue('J'.$rowCount,$row["active"]);
    $ews->setCellValue('K'.$rowCount,$row["intro"]);
    $ews->setCellValue('L'.$rowCount,$sndtrow["sndtreg"]);
    $ews->setCellValue('M'.$rowCount,$sndtrow["college"]);
    $ews->setCellValue('N'.$rowCount,$sndtrow["degree"]);
    $ews->setCellValue('O'.$rowCount,$sndtrow["course"]);
    $ews->setCellValue('P'.$rowCount,$sndtrow["year"]);
    $ews->setCellValue('Q'.$rowCount,$sndtrow["job"]);
    $ews->setCellValue('R'.$rowCount,$sndtrow["skill"]);
    $ews->setCellValue('S'.$rowCount,$sndtrow["skillexp"]);
    $ews->setCellValue('T'.$rowCount,$sndtrow["city_pref"]);
    $ews->setCellValue('U'.$rowCount,$sndtrow["salary"]);
    $ews->setCellValue('V'.$rowCount,$sndtrow["lifegoals"]);
    $ews->setCellValue('W'.$rowCount,$sndtrow["extrainfo"]);
    $ews->setCellValue('X'.$rowCount,$row["accountno"]);
    $rowCount++;
} 
$ews->setCellValue('A2',"Count: ".($rowCount-3));

$column ='F1:F'.$rowCount;
$style = array(
    'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,),
    );
$ews->getStyle($column)->applyFromArray($style);

//Header stlying
$header = 'A1:X1';
$style = array(
    'font' => array('bold' => true,),
    'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,),
    'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'CCCCCC'))
    );
$ews->getStyle($header)->applyFromArray($style);

//Column Width
for ($col = ord('A'); $col <= ord('X'); $col++)
{
    $ews->getColumnDimension(chr($col))->setAutoSize(true);

    if($col==ord('H'))
    {
        $ews->getColumnDimension(chr($col))->setAutoSize(false);
        $ews->getColumnDimension(chr($col))->setWidth(15);
    }

    if($col==ord('M')||$col==ord('O')||$col==ord('R')||$col==ord('S')||$col==ord('U')||$col==ord('V')||$col==ord('W')||$col==ord('W'))
    {
        $ews->getColumnDimension(chr($col))->setAutoSize(false);
        $ews->getColumnDimension(chr($col))->setWidth(30);
    }
    if($col==ord('P'))
    {
        $ews->getColumnDimension(chr($col))->setAutoSize(false);
        $ews->getColumnDimension(chr($col))->setWidth(5);
    }
}

//Exporting SNDT WRAP results 
$ews = $ea->createSheet();
$ews->setTitle('WRAP');

$titles = array("ID","First Name","Last Name","Email","Life Vision 1","Life Vision 2","Average","Percentile","Self Belief","Self Awareness","Professionalism","Business Communication","Professional Awareness","Prioritization","Problem Solving","Grammar","Ethics","Test Completion");
for($i=0,$col='A'; $i<count($titles); $i++,$col++)
$ews->setCellValue($col.'1', $titles[$i]);

$rowCount = 3; 

require 'connectsql.php';
$sql = "SELECT * FROM `results` ORDER BY id DESC LIMIT 10000";  
$result = mysqli_query($DBcon, $sql);
      
while($row = mysqli_fetch_assoc($result))  
{  
    if(!in_array($row['email'],$sndtemails)) continue;
    $ews->setCellValue('A'.$rowCount, $row["id"]);
    $ews->setCellValue('B'.$rowCount, $row["firstname"]);
    $ews->setCellValue('C'.$rowCount, $row["lastname"]);
    $ews->setCellValue('D'.$rowCount, $row["email"]);
    $ews->setCellValue('E'.$rowCount, $row["lv1grade"]);
    $ews->setCellValue('F'.$rowCount, $row["lv2grade"]);
    $ews->setCellValue('G'.$rowCount, $row["avg"]);
    $ews->setCellValue('H'.$rowCount, $row["percentile"]);
    $ews->setCellValue('I'.$rowCount, $row["selfbelief"]);
    $ews->setCellValue('J'.$rowCount, $row["selfaware"]);
    $ews->setCellValue('K'.$rowCount, $row["professionalism"]);
    $ews->setCellValue('L'.$rowCount, $row["businesscomm"]);
    $ews->setCellValue('M'.$rowCount, $row["profaware"]);
    $ews->setCellValue('N'.$rowCount, $row["prioritization"]);
    $ews->setCellValue('O'.$rowCount, $row["probsolve"]);
    $ews->setCellValue('P'.$rowCount, $row["grammar"]);
    $ews->setCellValue('Q'.$rowCount, $row["ethics"]);
    $ews->setCellValue('R'.$rowCount, $row["resulttime"]);
    $rowCount++;
} 
$ews->setCellValue('A2',"Count: ".($rowCount-3));
//Header Stlying
$header = 'A1:R1';
$style = array(
    'font' => array('bold' => true,),
    'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,),
    'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'CCCCCC'))
);
$ews->getStyle($header)->applyFromArray($style);

//Auto Column Width
for ($col = ord('A'); $col <= ord('R'); $col++)
    $ews->getColumnDimension(chr($col))->setAutoSize(true);

$ea->setActiveSheetIndex(0);

//XLSX Header and download file
$filename=date('dmY')."_Talerang Express_SNDT Registerations.xlsx";
header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="'.$filename.'"');
$writer = PHPExcel_IOFactory::createWriter($ea, 'Excel2007');
ob_end_clean();
$writer->save('php://output'); ?>