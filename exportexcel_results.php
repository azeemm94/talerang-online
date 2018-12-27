<?php  session_start();
   if(!isset($_SESSION['adminuser'])) { header('location:adminlogin.php'); exit; }
   date_default_timezone_set('Asia/Kolkata');
   require_once "vendor/phpoffice/phpexcel/Classes/PHPExcel.php";
   
   $ea = new PHPExcel(); 
   ob_start();
   $ea->getProperties()
      ->setCreator('Azeem Merchant')
      ->setLastModifiedBy('Azeem Merchant')
      ->setTitle('WRAP Results');
    
  $ews = $ea->getSheet(0);
  $ews->setTitle('Results');

  $titles = array("ID","First Name","Last Name","Email","Life Vision 1","Life Vision 2","Average","Percentile","Self Belief","Self Awareness","Professionalism","Business Communication","Professional Awareness","Prioritization","Problem Solving","Grammar","Ethics","Test Completion","Account No");
  for($i=0,$col='A'; $i<count($titles); $i++,$col++)
    $ews->setCellValue($col.'1', $titles[$i]);

  $rowCount = 3; 
  
  require 'connectsql.php';
  $sql = "SELECT * FROM `results` ORDER BY id DESC LIMIT 10000";  
  $result = mysqli_query($DBcon, $sql);
      
   while($row = mysqli_fetch_assoc($result))  
   {  
      $accountno=$row["accountno"];
      $sndt=mysqli_num_rows(mysqli_query($DBcon,"SELECT `id` FROM `sndt` WHERE `accountno`='$accountno';"));
      if($sndt) continue;

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
      $ews->setCellValue('S'.$rowCount, $row["accountno"]);
      $rowCount++;
   } 

   $ews->setCellValue('A2',"Count: ".($rowCount-3));
   //Header Stlying
    $header = 'A1:S1';
    $style = array(
        'font' => array('bold' => true,),
        'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,),
        );
    $ews->getStyle($header)->applyFromArray($style);
    
    //Auto Column Width
   for ($col = ord('A'); $col <= ord('S'); $col++)
      $ews->getColumnDimension(chr($col))->setAutoSize(true);
    
    //XLSX Header and download file
    $filename=date('dmY')."_WRAP Results.xlsx";
    header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="'.$filename.'"');
    $writer = PHPExcel_IOFactory::createWriter($ea, 'Excel2007');
    ob_end_clean();
    $writer->save('php://output');
   ?>